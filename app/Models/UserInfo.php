<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserInfo extends Model
{
    // //use HasFactory;
    // protected $fillable = [
    //     'user_id',
    //     'admin'
    // ];

    /**
     * Get the user that owns the UserInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(User::class);
//     }

    protected $table = 'user_infos';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}