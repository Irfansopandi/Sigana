<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignVolunteer extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_id',
        'campaign_role_id',
        'tugas_lain',
        'joined_at',
        'status',
        'catatan',
        'alasan',
        'pengalaman',
        'verifikasi',
        'catatan_admin',
        'is_coordinator',
        'minat_koordinator',
        'keahlian',
        'dokumen_1',
        'dokumen_2',
        'dokumen_3',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'minat_koordinator' => 'boolean',
        'is_coordinator' => 'boolean',
        'keahlian' => 'array',
];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(CampaignRole::class, 'campaign_role_id');
    }

    public function roles()
    {
        return $this->hasMany(CampaignRole::class);
    }

    public function coordinatorReports()
    {
        return $this->hasMany(CoordinatorReport::class, 'user_id', 'user_id')
            ->where('campaign_id', $this->campaign_id);
    }
}