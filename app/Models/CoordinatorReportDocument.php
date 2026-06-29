<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoordinatorReportDocument extends Model
{
    protected $fillable = [
        'coordinator_report_id', 
        'name', 
        'file', 
        'code'
    ];

    public function coordinatorReport(): BelongsTo
    {
        return $this->belongsTo(CoordinatorReport::class);
    }
}