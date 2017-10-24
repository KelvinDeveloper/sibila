<?php

namespace App\Http\Controllers;

use App\BoardConfiguration;
use App\Trello;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Trello $Trello, $id)
    {
        $Board    = $Trello->Manager->getBoard($id);
        $Lists    = $Trello->Board->lists()->all($id);
        $Settings = BoardConfiguration::where('board_id', $id)->first();

        if (! $Settings) {
            $Settings = new BoardConfiguration;
        }

//        dd(
//            $Trello->Board->cards()->all($id)[55],
//            $Trello->Card->actions()->all('59e75caac5873fb475d06815')
//        );


        return view('board', compact('id', 'Board', 'Lists', 'Settings'))->render();
    }

    public function save(Request $request, $id)
    {
        $Board = BoardConfiguration::where('board_id', $id)->first();

        if (! $Board) {

            $Board = new BoardConfiguration;
        }

        $Board->fill($request->all());
        $Board->board_id = $id;

        $Board->save();

        return response()->json($Board);
    }
}
