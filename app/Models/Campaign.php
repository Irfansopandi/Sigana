<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'location',
        'category',
        'image',
        'status',
        'collected_raw',
        'target_raw',
        'days_left',
        'date_published',
        'description_short',
        'description_long',
        'victims',
        'latitude',
        'longitude',
        'assigned_to',
        'submitted_by',
        'report_status',
        'documentation_1',
        'documentation_2',
        'documentation_3',
    ];

    protected $casts = [
        'date_published' => 'date',
        'collected_raw'  => 'integer',
        'target_raw'     => 'integer',
        'days_left'      => 'integer',
    ];

    // ─────────────────────────────────────────────
    //  COUNTDOWN & RIWAYAT
    // ─────────────────────────────────────────────

    /**
     * Sisa hari kampanye dihitung otomatis dari date_published + durasi DB.
     * Nilai days_left di DB = total durasi kampanye (tidak pernah berubah).
     */
    public function getDaysLeftAttribute(): int
    {
        $duration  = $this->attributes['days_left'] ?? 0;
        $published = Carbon::parse($this->attributes['date_published']);
        $deadline  = $published->copy()->addDays($duration);

        $remaining = (int) now()->startOfDay()->diffInDays($deadline, false);
        return max(0, $remaining);
    }

    /**
     * Total durasi asli kampanye (nilai mentah dari DB).
     * Berguna untuk halaman riwayat / arsip.
     */
    public function getDurationAttribute(): int
    {
        return (int) ($this->attributes['days_left'] ?? 0);
    }

    /**
     * Tanggal berakhir kampanye (date_published + durasi DB).
     */
    public function getDeadlineAttribute(): string
    {
        $duration  = $this->attributes['days_left'] ?? 0;
        $published = Carbon::parse($this->attributes['date_published']);
        return $published->copy()->addDays($duration)->format('d M Y');
    }

    /**
     * Apakah kampanye sudah berakhir?
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->days_left <= 0;
    }

    // ─────────────────────────────────────────────
    //  STATUS
    // ─────────────────────────────────────────────

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'Darurat' => 'bg-danger',
            'Waspada' => 'bg-warning text-dark',
            'Aktif'   => 'bg-primary',
            default   => 'bg-secondary',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'Aktif'  => 'fa-solid fa-circle-dot',
            default  => 'fa-solid fa-triangle-exclamation',
        };
    }

    // ─────────────────────────────────────────────
    //  DANA
    // ─────────────────────────────────────────────

    public function getCollectedAttribute(): string
    {
        return 'Rp' . number_format($this->collected_raw, 0, ',', '.');
    }

    public function getTargetAttribute(): string
    {
        return 'Rp' . number_format($this->target_raw, 0, ',', '.');
    }

    public function getProgressRawAttribute(): float
    {
        if ($this->target_raw <= 0) return 0;
        return round(($this->collected_raw / $this->target_raw) * 100, 1);
    }

    public function getProgressAttribute(): string
    {
        $raw       = $this->progress_raw;
        $formatted = (floor($raw) == $raw)
            ? number_format($raw, 0)
            : number_format($raw, 1);
        return $formatted . '%';
    }

    public function getProgressColorAttribute(): string
    {
        $p = $this->progress_raw;
        return match (true) {
            $p >= 75 => '#22c55e',  // hijau  – hampir tercapai
            $p >= 50 => '#3b82f6',  // biru   – setengah jalan
            $p >= 25 => '#f59e0b',  // kuning – baru mulai
            default  => '#ef4444',  // merah  – kritis
        };
    }

    // ─────────────────────────────────────────────
    //  TANGGAL
    // ─────────────────────────────────────────────

    public function getDatePublishedAttribute($value): string
    {
        return $this->formatIndonesianDate($value);
    }

    private function formatIndonesianDate($date): string
    {
        $bulan = [
            1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
            4  => 'April',     5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ];
        $carbon = Carbon::parse($date);
        return $carbon->day . ' ' . $bulan[$carbon->month] . ' ' . $carbon->year;
    }

    // ─────────────────────────────────────────────
    //  RELASI
    // ─────────────────────────────────────────────

    public function needs()
    {
        return $this->hasMany(CampaignNeed::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getDonorsCountAttribute(): int
    {
        return $this->donations()
            ->where('payment_status', 'success')
            ->distinct('name')
            ->count('name');
    }

    public function transparencyReport()
    {
        return $this->hasOne(TransparencyReport::class);
    }

    public function assignedVolunteer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}