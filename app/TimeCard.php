<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id', 'difficulty', 'init_doing', 'end_doing', 'total_doing', 'board_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
