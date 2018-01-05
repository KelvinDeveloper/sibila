<?php

namespace App\Console\Commands;

use App\BoardConfiguration;
use App\MemberCard;
use App\TimeCard;
use App\Trello;
use App\User;
use Carbon\Carbon;
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

//                    if ($Card['id'] == '59e772c10132d65d24080e79') dd($Card);

                    if (! preg_match('[D=[0-9]]', $Card['name'], $Difficulty)) continue;

                    $TimeCard   = TimeCard::where('card_id', $Card['id'])->first();

                    if (! $TimeCard) {

                        $TimeCard = new TimeCard;
                    }

                    /**
                     * Members
                     * */
                    foreach ($Card['idMembers'] as $member_id) {

                        $MemberCard = MemberCard::where('card_id', $Card['id'])->where('member_id', $member_id)->first();

                        if (! $MemberCard) {

                            $MemberCard = new MemberCard;
                            $MemberCard->fill([
                               'card_id'    =>  $Card['id'],
                               'member_id'  =>  $member_id
                            ]);

                            $MemberCard->save();
                        }
                    }

                    /**
                     * Actions
                     * */
                    $TimeDoing = [
                      'init_doing'  =>  null,
                      'end_doing'   =>  null,
                      'total_doing' =>  null
                    ];

                    foreach ($Trello->Card->actions()->all($Card['id']) as $Action) {

                        if (isset($Action['data']['listAfter']) && $Action['data']['listAfter']['id'] == $Settings->list_doing_id) {

                            $TimeDoing['init_doing'] = new Carbon($Action['date']);
                        }

                        if (isset($Action['data']['listBefore']) && $Action['data']['listBefore']['id'] == $Settings->list_doing_id) {

                            $TimeDoing['end_doing']  = new Carbon($Action['date']);
                        }
                    }

                    if ($TimeDoing['init_doing'] && $TimeDoing['end_doing'] ) {

                        $TimeDoing['total_doing'] = $TimeDoing['init_doing']->diffInHours($TimeDoing['end_doing']);
                    }


                    if ($TimeDoing['total_doing']) {

                        if ($TimeCard->init_doing != $TimeDoing['init_doing'] || $TimeCard->end_doing != $TimeDoing['end_doing']) {

                            $TimeCard->init_doing  = $TimeDoing['init_doing'];
                            $TimeCard->end_doing   = $TimeDoing['end_doing'];
                            $TimeCard->total_doing = $TimeDoing['total_doing'] + $TimeCard->total_doing;
                        }
                    }

                    $TimeCard->card_id    = $Card['id'];
                    $TimeCard->difficulty = str_replace('D=', '', $Difficulty[0]);
                    $TimeCard->board_id   = $Board['id'];

                    $TimeCard->save();
                }
            }
        }
    }
}
