<?php

namespace App\Console\Commands\Task;

use App\BoardAutomate;
use App\Trello;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait Data {

    private function getCards ($Setting)
    {
        $Trello = new Trello;
        $Cards  = [];

        $Cards['backlog'] = [];
        $Cards['sprint'] = [];
        $Cards['doing'] = [];
        $Cards['done'] = [];

        foreach ($Trello->Board->cards()->all($Setting->board_id) as $Card){

            switch ($Card['idList']) {

                case $Setting->list_backlog_id:
                    $Cards['backlog'][] = $Card;
                    break;

                case $Setting->list_sprint_id:
                    $Cards['sprint'][] = $Card;
                    break;

                case $Setting->list_doing_id:
                    $Cards['doing'][] = $Card;
                    break;

                case $Setting->list_done_id:
                    $Cards['done'][] = $Card;
                    break;
            }
        }

        return $Cards;
    }

    private function getDailyCards ($Title=false)
    {

        $Obj = BoardAutomate::where('user_id', Auth::user()->id)
            ->where('frequency', 1)
            ->orWhere(function ($query) {
                return $query->where('frequency', 2)->where('week_day', date(Carbon::now()->format('N')));
            })
            ->orWhere(function ($query) {
                return $query->where('frequency', 3)->where('month_day', date(Carbon::now()->format('d')));
            });

        if ($Title) {

            $Obj->where('title', $Title);
        }

        return $Obj->get();
    }
}