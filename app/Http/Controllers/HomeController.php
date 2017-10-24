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
}
