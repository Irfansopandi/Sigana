<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoordinatorReport extends Model
{
    protected $fillable = [
        'campaign_id', 
        'user_id', 
        'title', 
        'description',
        'victim_helped', 
        'total_distribution', 
        'reported_at',
        'status', 
        'rejection_note', 
        'verified_at', 
        'verified_by',
    ];

    protected $casts = [
        'reported_at' => 'date',
        'verified_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(CoordinatorReportPhoto::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CoordinatorReportItem::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(CoordinatorReportTimeline::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CoordinatorReportDocument::class);
    }
}