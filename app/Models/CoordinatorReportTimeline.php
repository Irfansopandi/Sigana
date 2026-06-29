<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoordinatorReportTimeline extends Model
{
    protected $fillable = [
        'coordinator_report_id', 
        'date', 
        'title', 
        'description'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function coordinatorReport(): BelongsTo
    {
        return $this->belongsTo(CoordinatorReport::class);
    }
}