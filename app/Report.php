<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['sprint', 'done', 'total', 'percent', 'score'];
}
