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

    public function getPhotoUrlAttribute(): string
    {
        $path = $this->getRawOriginal('url');

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
