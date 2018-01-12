<?php

namespace App\Console\Commands\Task;

use App\Trello;

trait Data {

    private function getCardsDay ()
    {
        $Trello = new Trello;

//        foreach ($Trello->Board->cards()->all($Automate->board_id) as $Card){
//
//            if ( $Card['idList'] == $Automate->list_id && $Card['name'] == $Automate->title ) {
//
//                $Exist = true;
//            }
//        }
    }
}