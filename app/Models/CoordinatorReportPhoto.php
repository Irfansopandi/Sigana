<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoordinatorReportPhoto extends Model
{
    protected $fillable = [
        'coordinator_report_id', 
        'photo', 
        'caption', 
        'order'
    ];

    public function coordinatorReport(): BelongsTo
    {
        return $this->belongsTo(CoordinatorReport::class);
    }
}