<?php

namespace App\Http\Controllers;

use App\Trello;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

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

        return Report::where('board_id', $id)->where('date', $request->date)->get();
    }
}
