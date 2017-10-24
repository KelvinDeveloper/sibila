<?php

namespace App\Console\Commands;

use App\BoardConfiguration;
use App\MemberCard;
use App\TimeCard;
use App\Trello;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Boot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
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
        $Users = User::get();

        foreach ($Users as $User) {

            Auth::login($User);

            $Trello = new Trello;

            foreach ($Trello->getBoards() as $Board) {

                $Settings = BoardConfiguration::where('board_id', $Board['id'])->first();

                if (! $Settings) continue;
                if (! $Settings->list_doing_id) continue;

                foreach ($Trello->Board->cards()->all($Board['id']) as $Card) {

                    $TimeCard   = TimeCard::where('card_id', $Card['id']);

                    if (! $TimeCard) {

                        $TimeCard = new TimeCard;
                    }

                    /*
                     * Members
                     * */
                    foreach ($Card['idMembers'] as $member_id) {

                        $MemberCard = MemberCard::where('card_id', $Card['id'])->where('member_id', $member_id);

                        if (! $MemberCard) {

                            $MemberCard = new MemberCard;
                            $MemberCard->fill([
                               'card_id'    =>  $Card['id'],
                               'member_id'  =>  $MemberCard
                            ]);
                            $MemberCard->save();
                        }
                    }

                    /*
                     * Actions
                     * */
                    foreach ($Trello->Card->actions()->all($Card['id']) as $Action) {

                        if (isset($Action['data']['listAfter']) && $Action['data']['listAfter']['id'] == $Settings->list_doing_id) {

//                            dd($Action, 'after');
                        }

                        if (isset($Action['data']['listBefore']) && $Action['data']['listBefore']['id'] == $Settings->list_doing_id) {

//                            dd($Action, 'before');
                        }
                    }
                }
            }
        }
    }
}
