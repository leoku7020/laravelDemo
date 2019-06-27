<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $table = 'members';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'account',
        'password',
        'mail',
    ];

    protected $hidden = [
        'password',
    ];
}
