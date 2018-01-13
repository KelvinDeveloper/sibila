<?php

namespace App\Console\Commands\Task;

use App\Trello;

trait Data {

    private function getDone ($Setting)
    {
        $Trello = new Trello;
        $Cards  = [];

        foreach ($Trello->Board->cards()->all($Setting->board_id) as $Card){

            if ($Setting->list_done_id == $Card['idList'])
                $Cards[] = $Card;
        }

        return $Cards;
    }
}