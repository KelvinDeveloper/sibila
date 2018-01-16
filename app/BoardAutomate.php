<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardAutomate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'frequency',
        'members_id',
        'labels_id',
        'week_day',
        'month_day',
        'board_id',
        'list_id',
        'user_id',
        'score',
        'penalty'
    ];

    protected $frequencies = [
        1   =>  'Daily',
        2   =>  'Weekly',
        3   =>  'Monthly'
    ];

    public $weekDays = [
        1   =>  'Segunda-feira',
        2   =>  'Terça-feira',
        3   =>  'Quarta-feira',
        4   =>  'Quinta-feira',
        5   =>  'Sexta-feira',
        6   =>  'Sábado',
        7   =>  'Domingo'
    ];

    public $monthDays = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];

    public function getFrequency ()
    {
        return $this->frequencies[$this->frequency];
    }
}
