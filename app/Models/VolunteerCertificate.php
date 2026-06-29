<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_id',
        'title',
        'file',
        'issued_at',
        'notes',
    ];

    protected $casts = [
        'issued_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'assignment_id');
    }

    public function getIssuedAtAttribute($value): string
    {
        $bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $carbon = \Carbon\Carbon::parse($value);
        return $carbon->day . ' ' . $bulan[$carbon->month] . ' ' . $carbon->year;
    }
}