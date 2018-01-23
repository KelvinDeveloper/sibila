<?php

namespace App\Console\Commands\Task\Tasks;

use App\BoardAutomate;
use App\Console\Commands\Automate;
use App\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Children {

    use \App\Console\Commands\Task\Data;

    public function boot ($Setting)
    {
        $Cards = $this->getCards($Setting);
        $Items = $this->getDailyCards();

        $Report = [];

        $Report['done']    = count($Cards['done']);
        $Report['sprint']  = count($Cards['sprint']);
        $Report['total']   = count($Items);
        $Report['percent'] = ($Report['done'] / $Report['total']) * 100;
        $Report['score']   = 0;

        $GenerateReport = false;

        foreach ($Cards as $List => $allCards) {

            if (empty($allCards)) continue;

            $GenerateReport = true;

            foreach ($allCards as $Card) {

                $Automate = BoardAutomate::where('title', $Card['name'])->first();

                if (! $Automate) continue;

                if ($List == 'sprint') {

                    if (is_null($Automate->penalty)) $Automate->penalty = 0;

                    $Report['score'] = $Report['score'] + $Automate->penalty;
                }

                else if ($List == 'done') {

                    if (is_null($Automate->score)) $Automate->score = 0;

                    $Report['score'] = $Report['score'] + $Automate->score;
                }

                $this->closeCard($Card['id']);
            }
        }

        if ($GenerateReport) {

            $ReportObj = Report::where('board_id', $Setting->board_id)
                ->where('date', Carbon::now()->format('Y-m-d'))->first();

            if (! $ReportObj) $ReportObj = new Report;

            $Report = $ReportObj->fill($Report);

            $Report->date     = Carbon::now()->format('Y-m-d');
            $Report->board_id = $Setting->board_id;

            $Report->save();
        }

        (new Automate)->handle();
    }
}