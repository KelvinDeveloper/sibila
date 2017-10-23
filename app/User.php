<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Verify if user setup Trello information
     *
     * @return boolean
     * */
    public static function isSetup ()
    {
        $Setup = self::getSetup(['id']);

        Auth::guard();

        if (! $Setup) return false;

        return true;
    }

    public static function getSetup ($select = null)
    {
        return TrelloAuth::where('user_id', Auth::user()->id)->first($select);
    }
}
