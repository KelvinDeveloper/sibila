<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trello;

class TrelloController extends Controller
{
    public function index(Trello $Trello)
    {
        $Boards = $Trello->getBoards();

        return view('boards', compact('Boards'))->render();
    }
}
