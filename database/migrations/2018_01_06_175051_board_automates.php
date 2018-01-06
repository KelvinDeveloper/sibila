<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BoardAutomates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_automates', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('frequency');
            $table->string('board_id');
            $table->string('list_id');
            $table->string('user_id');

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
        Schema::dropIfExists('board_automates');
    }
}
