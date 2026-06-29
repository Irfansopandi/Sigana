<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignRole extends Model
{
    protected $fillable = [
        'campaign_id',
        'nama',
        'deskripsi',
        'kuota',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function volunteers()
    {
        return $this->hasMany(CampaignVolunteer::class);
    }
}