<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TrelloAuth extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_key', 'token', 'username', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
