<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class BoardConfiguration extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'board_id', 'list_backlog_id', 'list_sprint_id', 'list_doing_id', 'list_done_id', 'task_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public $tasks = [
        1   =>  'Children'
    ];
}
