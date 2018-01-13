<?php

namespace App\Http\Controllers;

use App\BoardConfiguration;
use App\Trello;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{

    /**
     * Show display select board
     *
     * @param $Trello
     * @param $id int
     *
     * @return view()
     * */
    public function index(Trello $Trello, $id)
    {
        $Board    = $Trello->Manager->getBoard($id);
        $Lists    = $Trello->Board->lists()->all($id);
        $Settings = BoardConfiguration::where('board_id', $id)->first();

        if (! $Settings) {
            $Settings = new BoardConfiguration;
        }

        return view('board', compact('id', 'Board', 'Lists', 'Settings'))->render();
    }

    /**
     * Save board settings
     *
     * @param $request
     * @param $id int
     *
     * @return object
     * */
    public function save(Request $request, $id)
    {
        $Board = BoardConfiguration::where('board_id', $id)->first();

        if (! $Board) {

            $Board = new BoardConfiguration;
        }

        $Board->fill($request->all());
        $Board->board_id = $id;
        $Board->user_id  = Auth::user()->id;

        $Board->save();

        return response()->json($Board);
    }
}
