<?php

namespace App\Console\Commands\Task;

use App\Trello;

trait Data {

    private function getCardsDay ($Setting)
    {
        $Trello = new Trello;
        $Cards  = [];

        foreach ($Trello->Board->cards()->all($Setting->board_id) as $Card){

            $Cards[] = $Card;
        }

        return $Cards;
    }
}