<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'status',
        'status_class',
        'status_icon',
        'used',
        'date',
        'description',
        'beneficiaries',
    ];

    protected $casts = [
        'date' => 'date',
        'used' => 'decimal:2',
    ];

    public function getCollectedAttribute(): string
    {
        return $this->campaign->collected ?? 'Rp0';
    }

    public function getUsedAttribute($value): string
    {
        return 'Rp' . number_format($value, 0, ',', '.');
    }

    public function getRemainingAttribute(): string
    {
        $usedRaw = $this->getRawOriginal('used');
        $collectedRaw = $this->campaign->collected_raw ?? 0;
        return 'Rp' . number_format($collectedRaw - $usedRaw, 0, ',', '.');
    }

    public function getProgressAttribute(): string
    {
        $percent = $this->progress_raw;
        $formatted = (floor($percent) == $percent) ? number_format($percent, 0) : number_format($percent, 1);
        return $formatted . '%';

    }

    public function getDateAttribute($value): string
    {
        return $this->formatIndonesianDate($value);
    }

    private function formatIndonesianDate($date): string
    {
        $bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $carbon = \Carbon\Carbon::parse($date);
        return $carbon->day . ' ' . $bulan[$carbon->month] . ' ' . $carbon->year;
    }

    public function getStatusSlugAttribute(): string
    {
        return match ($this->status) {
            'Dalam Penyaluran' => 'penyaluran',
            'Hampir Selesai' => 'hampir-selesai',
            'Selesai' => 'selesai',
            'Aktif' => 'aktif',
            default => 'aktif',
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'Aktif'            => 'bg-primary',
            'Dalam Penyaluran' => 'bg-warning text-dark',
            'Hampir Selesai'   => 'bg-info text-dark',
            'Selesai'          => 'bg-success',
            default            => 'bg-secondary',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'Aktif'            => 'fa-solid fa-circle-dot',
            'Dalam Penyaluran' => 'fa-solid fa-truck',
            'Hampir Selesai'   => 'fa-solid fa-circle-check',
            'Selesai'          => 'fa-solid fa-flag-checkered',
            default            => 'fa-solid fa-circle-question',
        };
    }

    public function getProgressRawAttribute(): float
    {
        $usedRaw = $this->getRawOriginal('used');
        $collectedRaw = $this->campaign->collected_raw ?? 0;
        if ($collectedRaw <= 0) return 0;
        return min( round(($usedRaw / $collectedRaw) * 100, 1),100);
    }

    public function getProgressColorAttribute(): string
    {
        $p = $this->progress_raw;
        return match(true) {
            $p >= 75 => '#22c55e',
            $p >= 50 => '#3b82f6',
            $p >= 25 => '#f59e0b',
            default  => '#ef4444',
        };
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function allocations()
    {
        return $this->hasMany(ReportAllocation::class, 'report_id');
    }

    public function timeline()
    {
        return $this->hasMany(ReportTimeline::class, 'report_id');
    }

    public function evidence()
    {
        return $this->hasMany(ReportEvidence::class, 'report_id');
    }

    public function docs()
    {
        return $this->hasMany(ReportDoc::class, 'report_id');
    }
}
