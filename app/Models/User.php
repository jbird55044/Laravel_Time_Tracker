<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Entry;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }


    /**
     * Get the info associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
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


    /**
     * Get all of the entries for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function approvers()
    {
        return $this->belongsToMany(
            User::class,
            'approvers',          // Pivot table name
            'user_id',            // Foreign key on the pivot table for this user
            'approver_id'         // Foreign key on the pivot table for the approvers
        );
    }

    /**
     * Users whose timecards this user can approve.
     */
    public function approvals()
    {
        return $this->belongsToMany(
            User::class,
            'approvers',          // Pivot table name
            'approver_id',        // Foreign key on the pivot table for this user
            'user_id'             // Foreign key on the pivot table for the users they can approve
        );
    }
}
