<?php

namespace App\Http\Controllers;

use App\TrelloAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
    public function index()
    {
        return view('setup');
    }

    public function save(Request $request)
    {
        $Setup = TrelloAuth::where('user_id', Auth::user()->id)->first(['id']);

        if (! $Setup) {

            $Setup = new TrelloAuth;
        }

        $Setup->fill($request->all());
        $Setup->user_id = Auth::user()->id;

        $Setup->save();

        return redirect('/home');
    }
}
