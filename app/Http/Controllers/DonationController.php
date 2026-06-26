<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Buat transaksi Midtrans & simpan donation pending
     */
    public function createTransaction(Request $request, $slug)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'amount'         => 'required|integer|min:10000',
            'name'           => 'required|string|max:100',
            'message'        => 'nullable|string|max:500',
            'payment_method' => 'required|string',
        ], [
            'amount.required' => 'Nominal donasi wajib diisi.',
            'amount.min'      => 'Nominal donasi minimal Rp10.000.',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        $orderId  = 'SIGANA-' . strtoupper(uniqid());

        // Simpan donation dengan status pending
        $donation = Donation::create([
            'campaign_id'    => $campaign->id,
            'order_id'       => $orderId,
            'name'           => $request->name,
            'amount'         => $request->amount,
            'phone'          => $request->phone,
            'message'        => $request->message,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // Parameter Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
            ],
            'item_details' => [
                [
                    'id'       => $campaign->slug,
                    'price'    => (int) $request->amount,
                    'quantity' => 1,
                    'name'     => 'Donasi: ' . substr($campaign->title, 0, 50),
                ]
            ],
            'callbacks' => [
                'finish' => route('bencana.donasi.finish', $campaign->slug),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id'   => $orderId,
        ]);
    }

    /**
     * Callback/Notification dari Midtrans (webhook)
     */
    public function notification(Request $request)
    {
        $notification = new \Midtrans\Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;
        $paymentType       = $notification->payment_type;

        // Ambil nama bank atau e-wallet
        $paymentMethod = $paymentType;
        if ($paymentType === 'bank_transfer' && isset($notification->va_numbers[0]->bank)) {
            $paymentMethod = 'bank_transfer_' . $notification->va_numbers[0]->bank;
        } elseif ($paymentType === 'echannel') {
            $paymentMethod = 'bank_transfer_mandiri';
        } elseif ($paymentType === 'gopay') {
            $paymentMethod = 'gopay';
        } elseif ($paymentType === 'shopeepay') {
            $paymentMethod = 'shopeepay';
        } elseif ($paymentType === 'qris') {
            $paymentMethod = 'qris';
        } elseif ($paymentType === 'cstore') {
            $paymentMethod = $notification->store ?? 'cstore';
        }

        $donation = Donation::where('order_id', $orderId)->firstOrFail();

        if ($transactionStatus === 'capture') {
            $status = ($fraudStatus === 'accept') ? 'success' : 'failed';
        } elseif ($transactionStatus === 'settlement') {
            $status = 'success';
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $status = 'pending';
        } else {
            $status = 'pending';
        }

        // Cek dulu sebelum update
        if ($status === 'success' && $donation->getRawOriginal('payment_status') !== 'success') {
            $campaign = $donation->campaign;
            $campaign->collected_raw = $campaign->collected_raw + $donation->getRawOriginal('amount');
            $campaign->save();
        }

        $donation->update([
            'payment_status' => $status,
            'payment_method' => $paymentMethod,

        ]);

        return response()->json(['status' => 'ok']);
    }

    public function bencanaDetail($slug)
    {
        $campaign = Campaign::with(['needs', 'donations' => function ($q) {
            $q->where('payment_status', 'success')->latest()->limit(5);
        }])->where('slug', $slug)->firstOrFail();

        $donors = $campaign->donations;

        return view('bencana.detail', compact('campaign', 'donors'));
    }

    /**
     * Halaman finish setelah bayar
     */
    public function finish(Request $request, $slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        $orderId  = $request->get('order_id');
        $donation = Donation::where('order_id', $orderId)->first();

        return view('bencana.donasi-finish', compact('campaign', 'donation'));
    }

    public function updateStatus(Request $request)
    {
        $donation = Donation::where('order_id', $request->order_id)->firstOrFail();

        if ($donation->getRawOriginal('payment_status') === 'success') {
            return response()->json(['status' => 'already_success']);
        }

        // Ambil detail transaksi dari Midtrans
        $transactionStatus = (object) \Midtrans\Transaction::status($request->order_id);
        $paymentType = $transactionStatus->payment_type ?? null;

        $paymentMethod = $paymentType;
        if ($paymentType === 'bank_transfer' && isset($transactionStatus->va_numbers[0]->bank)) {
            $paymentMethod = 'bank_transfer_' . $transactionStatus->va_numbers[0]->bank;
        } elseif ($paymentType === 'echannel') {
            $paymentMethod = 'bank_transfer_mandiri';
        } elseif ($paymentType === 'gopay') {
            $paymentMethod = 'gopay';
        } elseif ($paymentType === 'shopeepay') {
            $paymentMethod = 'shopeepay';
        } elseif ($paymentType === 'qris') {
            $paymentMethod = 'qris';
        } elseif ($paymentType === 'cstore') {
            $paymentMethod = $transactionStatus->store ?? 'cstore';
        }

        $donation->update([
            'payment_status' => 'success',
            'payment_method' => $paymentMethod,
        ]);

        $campaign = $donation->campaign;
        $campaign->collected_raw = $campaign->collected_raw + $donation->getRawOriginal('amount');
        $campaign->save();

        return response()->json(['status' => 'ok']);
    }
}