<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportEvidence extends Model
{
    use HasFactory;

    protected $table = 'report_evidences';

    protected $fillable = [
        'report_id',
        'url',
        'desc',
    ];

    public function report()
    {
        return $this->belongsTo(TransparencyReport::class, 'report_id');
    }
}
