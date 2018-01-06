<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardAutomate extends Model
{
    protected $fillable = ['title', 'description', 'frequency', 'board_id', 'list_id', 'user_id'];
    protected $frequencies = [
        1   =>  'Daily',
        2   =>  'Weekly',
        3   =>  'Monthly'
    ];

    public function getFrequency ()
    {
        return $this->frequencies[$this->frequency];
    }
}
