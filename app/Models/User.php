<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'phone',
        'role',
        'photo',
        'email_verified_at',
        'tanggal_lahir',
        'jenis_kelamin',
        'keahlian',
        'nik',
        'alamat',
        'pengalaman',
        'foto_ktp',
        'status',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir'  => 'date',
            'keahlian'  => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isRelawan(): bool
    {
        return $this->role === 'relawan';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function getProfileCompleteAttribute(): bool
    {
        return filled($this->name)
            && filled($this->email)
            && filled($this->phone);
    }

    public function getIsVerifiedAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function isProfileComplete(): bool
    {
        return $this->profile_complete;
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
