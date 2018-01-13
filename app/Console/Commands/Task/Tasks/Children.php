<?php

namespace App\Console\Commands\Task\Tasks;

use Illuminate\Support\Facades\Auth;

class Children {

    use \App\Console\Commands\Task\Data;

    public function boot ($Setting)
    {
        $Cards = $this->getDone($Setting);
    }
}
