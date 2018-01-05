<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trello;

class AutomateController extends Controller
{
    public function index (Trello $Trello, $id_board, $id_list)
    {
        $Board    = $Trello->Manager->getBoard($id_board);
        $Lists    = $Trello->Board->lists()->all($id_board);

        $List = false;

        foreach ($Lists as $Obj) {

            if ($Obj['id'] == $id_list) {

                $List = $Obj;
                break;
            }
        }

        return view('automate', compact('Board', 'List'))->render();
    }
}
