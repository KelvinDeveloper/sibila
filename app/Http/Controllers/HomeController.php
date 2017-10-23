<?php

namespace App\Http\Controllers;

use App\Trello;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Trello $Trello)
    {
        $Boards = $Trello->getBoards();

        return view('home', compact('Boards'));
    }

    public function board(Trello $Trello, $id)
    {
        $Board = $Trello->Manager->getBoard($id);
        $Lists = $Trello->Board->lists()->all($id);

//        dd(
//            $Trello->Board->cards()->all($id)[55],
//            $Trello->Card->actions()->all('59e75caac5873fb475d06815')
//        );


        return view('board', compact('Board', 'Lists'))->render();
    }
}
