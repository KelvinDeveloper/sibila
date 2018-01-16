<?php

namespace App\Console\Commands;

use App\BoardAutomate;
use App\Trello;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Automate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (BoardAutomate::get() as $Automate) {

            $User = User::find($Automate->user_id);

            Auth::login($User);

            switch ($Automate->frequency) {

                case '1': // Daily
                    $this->daily($Automate);
                    break;

                case '2': // Weekly
                    $this->weekly($Automate);

                    break;

                case '3': // Monthly
                    $this->monthly($Automate);
                    break;
            }
        }
    }

    private function daily ($Automate)
    {
        return $this->cardExists($Automate);
    }

    private function weekly ($Automate)
    {
        if ($Automate->week_day == Carbon::now()->format('N')) {

            return $this->cardExists($Automate);
        }
    }

    private function monthly ($Automate)
    {
        if ((int) Carbon::now()->format('d') == $Automate->month_day) {

            return $this->cardExists($Automate);
        }
    }

    private function cardExists ($Automate)
    {
        $Trello = new Trello;
        $Exist  = false;
        foreach ($Trello->Board->cards()->all($Automate->board_id) as $Card){

            if ( $Card['idList'] == $Automate->list_id && $Card['name'] == $Automate->title ) {

                $Exist = true;
            }
        }

        if (! $Exist) {
            return $this->cardCreate($Automate);
        }
    }

    private function cardCreate ($Automate)
    {
        $Trello = new Trello;

        return $Trello->Card->create([
            'idList'    =>  $Automate->list_id,
            'name'      =>  $Automate->title,
            'desc'      =>  $Automate->description,
            'idMembers' =>  $Automate->members_id,
            'idLabels'  =>  $Automate->labels_id,
        ]);
    }
}
