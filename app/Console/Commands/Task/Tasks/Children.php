<?php

namespace App\Console\Commands\Task\Tasks;

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

        foreach ($Cards as $List => $allCards) {

            if (empty($allCards)) continue;

            foreach ($allCards as $Card) {

                $Automate = $this->getDailyCards($Card['name']);

                if (! $Automate) continue;

                if ($List == 'doing') {
                    $Report['score'] = $Report['score'] + $Automate[0]->penalty;
                }

                else if ($List == 'done') {
                    $Report['score'] = $Report['score'] + $Automate[0]->score;
                }
            }
        }

        $ReportObj = Report::where('board_id', $Setting->board_id)
            ->where('date', Carbon::now()->format('Y-m-d'))->first();

        if (! $ReportObj) $ReportObj = new Report;

        $Report = $ReportObj->fill($Report);

        $Report->date     = Carbon::now()->format('Y-m-d');
        $Report->board_id = $Setting->board_id;

        $Report->save();
    }
}
