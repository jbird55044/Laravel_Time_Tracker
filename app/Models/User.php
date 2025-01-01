<?php

// /app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function approvers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'approver_user', 'user_id', 'approver_id')->withTimestamps();
    }
    
    public function approvals(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'approver_user',
            'approver_id',
            'user_id'
        );
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }
    
    public function user_infos()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function isAdmin() {
        return $this->info->admin;
    }
}
