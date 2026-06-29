<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoordinatorReportItem extends Model
{
    protected $fillable = [
        'coordinator_report_id', 
        'category', 
        'description', 
        'amount'
    ];

    public function coordinatorReport(): BelongsTo
    {
        return $this->belongsTo(CoordinatorReport::class);
    }
}