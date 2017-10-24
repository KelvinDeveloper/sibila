<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTimeCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_cards', function (Blueprint $table) {
            $table->increments('id');

            $table->string('card_id');
            $table->integer('difficulty');
            $table->dateTime('init_doing');
            $table->dateTime('end_doing');
            $table->dateTime('total_doing');
            $table->string('board_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_cards');
    }
}
