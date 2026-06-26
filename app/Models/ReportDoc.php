<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'doc_id',
        'nama',
        'nominal',
        'file',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    public function getNominalAttribute($value): string
    {
        return 'Rp' . number_format($value, 0, ',', '.');
    }

    public function report()
    {
        return $this->belongsTo(TransparencyReport::class, 'report_id');
    }
}
