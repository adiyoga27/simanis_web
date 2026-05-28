<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'desa_id',
        'kader_id',
        'avatar',
        'birthdate',
        'phone',
        'jk',
        'is_smoke',
        'medical_history',
        'province',
        'city',
        'subdistrict',
        'village',
        'address',
        'kode_pos',
        'tall',
        'weight',
        'blood',
        'otp',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
            'is_smoke' => 'integer',
            'tall' => 'integer',
            'weight' => 'integer',
        ];
    }

    public function desa(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    public function kader(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'kader_id');
    }

    public function patients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'kader_id');
    }
}
