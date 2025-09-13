<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCandidate()
    {
        return $this->role === 'candidate';
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'candidate_id');
    }
}
