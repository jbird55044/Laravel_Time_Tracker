<?php

namespace App\Models;

use App\Models\Approval;
use App\Models\User;
use App\Models\JobCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\FuncCall;

class Entry extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'entry_date',
        'hours',
        'description',
    ];

    protected function casts(): array {
        return [
            'user_id' => 'integer', 
            'job_id' => 'integer',
            'entry_date' => 'datetime',
            'hours' => 'float',
            'description' => 'string',
        ];
    }


    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the Job associated with the Entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function job(): HasOne
    {
        return $this->hasOne(JobCode::class, 'id', 'job_id');
    }

    /**
     * Get all of the approvals for the Entry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'entry_id', 'id');
    }

}
