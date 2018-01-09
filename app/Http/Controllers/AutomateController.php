<?php

namespace App\Http\Controllers;

use App\BoardAutomate;
use Illuminate\Http\Request;
use App\Trello;
use Illuminate\Support\Facades\Auth;

class AutomateController extends Controller
{
    public function index (Trello $Trello, $id_board, $id_list)
    {
        $Board     = $Trello->Manager->getBoard($id_board);
        $Lists     = $Trello->Board->lists()->all($id_board);
        $Automates = BoardAutomate::where('board_id', $id_board)->get();

        $List = false;

        foreach ($Lists as $Obj) {

            if ($Obj['id'] == $id_list) {

                $List = $Obj;
                break;
            }
        }

        return view('automate', compact('Board', 'List', 'Automates'))->render();
    }

    public function form (Trello $Trello, $id_board, $id_list, $id_automate)
    {
        $Board     = $Trello->Manager->getBoard($id_board);
        $Lists     = $Trello->Board->lists()->all($id_board);
        $Automate  = BoardAutomate::find($id_automate);
        $Labels    = $Trello->Board->labels()->all($id_board);
        $Members   = $Trello->Board->members()->all($id_board);

        if (! $Automate) $Automate = new BoardAutomate;

        $List = false;

        foreach ($Lists as $Obj) {

            if ($Obj['id'] == $id_list) {

                $List = $Obj;
                break;
            }
        }

        return view('automate_form', compact('Board', 'List', 'Automate', 'id_automate', 'Labels', 'Members'))->render();
    }

    public function save (Request $request, $id_board, $id_list, $id_automate)
    {
        $Automate  = BoardAutomate::find($id_automate);

        if (! $Automate) $Automate = new BoardAutomate;

        $Automate->fill(array_merge(
           [
               'board_id'   =>  $id_board,
               'list_id'    =>  $id_list,
               'user_id'    =>  Auth::user()->id
           ], $request->all()
        ));

        $Automate->save();

        return redirect("/board/{$id_board}/automate/{$id_list}");
    }

    public function delete (Request $request, $id_board, $id_list, $id_automate)
    {
        $Automate  = BoardAutomate::find($id_automate);

        return response()->json(['status'   =>  $Automate->delete()]);
    }
}
