<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignNeed extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'qty',
    ];

    public function getIconAttribute(): string
    {
        $map = [
            'Makanan Cepat Saji' => 'fa-solid fa-utensils',
            'Obat & Masker' => 'fa-solid fa-kit-medical',
            'Susu & Popok Bayi' => 'fa-solid fa-baby',
            'Pakaian Layak Pakai' => 'fa-solid fa-shirt',
            'Tenda Darurat' => 'fa-solid fa-tent',
            'Selimut & Matras' => 'fa-solid fa-mattress-pillow',
            'Pasokan Air Bersih' => 'fa-solid fa-droplet',
            'Kid Wear & Milk' => 'fa-solid fa-hands-holding-child',
            'Masker N95 / Kacamata' => 'fa-solid fa-mask',
            'Paket Sembako' => 'fa-solid fa-box-open',
            'Tabung Oksigen' => 'fa-solid fa-wind',
            'Pemeriksaan Kesehatan' => 'fa-solid fa-user-doctor',
            'Peralatan Kebersihan' => 'fa-solid fa-broom',
            'Kasur Lipat & Selimut' => 'fa-solid fa-mattress-pillow',
            'Hygiene Kit' => 'fa-solid fa-box-tissue',
            'Bahan Pangan Pokok' => 'fa-solid fa-wheat-awn',
            'Truk Tangki Air Bersih' => 'fa-solid fa-truck-droplet',
            'Bak Penampung Air / Toren' => 'fa-solid fa-fill-drip',
            'Jeriken Plastik' => 'fa-solid fa-bucket',
            'Suplemen & Vitamin Medis' => 'fa-solid fa-prescription-bottle-medical',
            'Biskuit PMT Khusus Balita' => 'fa-solid fa-cookie-bite',
            'Susu Formula Khusus' => 'fa-solid fa-cow',
            'Rehabilitasi Medis Rawat Jalan' => 'fa-solid fa-hospital-user',
        ];

        return $map[$this->name] ?? 'fa-solid fa-circle-check';
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
