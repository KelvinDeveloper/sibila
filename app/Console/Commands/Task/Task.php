<?php

namespace App\Console\Commands\Task;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Task extends Command
{
    use Data;

    private $User;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks';

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
        foreach (User::get() as $User) {

            $this->User = $User;
            Auth::login($User);

            $this->getCardsDay();
        }
    }
}
