<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'order_id',
        'name',
        'amount',
        'message',
        'payment_method',
        'payment_status',
        'snap_token',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function getAmountAttribute($value): string
    {
        return 'Rp' . number_format($value, 0, ',', '.');
    }

    public function getTimeAttribute(): string
    {
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
