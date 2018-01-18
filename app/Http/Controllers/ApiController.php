<?php

namespace App\Http\Controllers;

use App\Report;
use App\Trello;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class ApiController extends Controller
{

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

        $Report = [];

        $Obj = Report::where('board_id', $id)->where('date', 'like',  "%{$request->date}%");

        $Report['all'] = $Obj->get();
        $Report['summary']['score'] = $Obj->select(\DB::raw('SUM(score) AS score'))->first();
        $Report['dates'] = [];

        if (is_object($Report['summary']['score'])) {

            $Report['summary']['score'] = $Report['summary']['score']->score;

            foreach (Report::where('board_id', $id)->get() as $Item) {

                $Report['dates'][] = substr($Item->date, 0, 7);
            }

            $Report['dates'] = array_unique($Report['dates']);
            rsort($Report['dates']);
        }

        return $Report;
    }
}
