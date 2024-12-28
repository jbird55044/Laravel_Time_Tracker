<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCode extends Model
{
    //use HasFactory;

    protected $fillable = [
        'name', 
        'billing_code',
        'updated_at'
    ];

}
