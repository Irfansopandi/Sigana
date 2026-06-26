<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'tanggal',
        'judul',
        'deskripsi',
        'icon',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function getTanggalAttribute($value): string
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

    public function report()
    {
        return $this->belongsTo(TransparencyReport::class, 'report_id');
    }
}
