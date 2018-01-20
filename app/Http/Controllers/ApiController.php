<?php

namespace App\Http\Controllers;

use App\BoardConfiguration;
use App\Report;
use App\Trello;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class ApiController extends Controller
{

    use \App\Console\Commands\Task\Data;

    private $User;
    private $Trello;

    public function __construct()
    {
        try  {
            $this->User = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {

            abort(422, json_encode(['error' => 'invalid token']));
        }

        Auth::login($this->User);
        $this->Trello = new Trello;
    }

    public function getBoards ()
    {
        return response()->json( (new HomeController)->index($this->Trello, true) );
    }

    public function getReport (Request $request, $id)
    {
        if (! isset($request->date)) {

            $request->date = Carbon::now()->format('Y-m');
        }

        $Setting = BoardConfiguration::where('task_id', '!=', '')->where('user_id', Auth::user()->id)->first();

        $Report = [];

        $Obj = Report::where('board_id', $id)->where('date', 'like',  "%{$request->date}%");

        $Report['summary']['score'] = $Obj->select(\DB::raw('SUM(score) AS score'))->first();

        foreach ($Obj->orderBy('date', 'DESC')->get() as $item) {

            $item->score   = empty($item->score) ? '0' : $item->score;
            $item->penalty = empty($item->penalty) ? '0' : $item->penalty;
            $item->date    = (new Carbon($item->date))->format('d/m/Y');

            $Report['all'][] = $item;
        }

        $Report['summary']['money'] = 'R$ ' . number_format( ((int) $Report['summary']['score']->score / 10), 2, '.', '.' );
        $Report['dates'] = [];

        $Report['cards'] = $this->getCards($Setting);

        if (is_object($Report['summary']['score'])) {

            $Report['summary']['score'] = $Report['summary']['score']->score;

            foreach (Report::where('board_id', $id)->get() as $Item) {

                $Report['dates'][] = (new Carbon($Item->date))->format('M/Y');
            }

            $Report['dates'] = array_unique($Report['dates']);
            rsort($Report['dates']);
        }

        return response()->json($Report);
    }
}
