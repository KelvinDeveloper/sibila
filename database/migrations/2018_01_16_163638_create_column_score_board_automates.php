<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnScoreBoardAutomates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_automates', function (Blueprint $table) {
            $table->integer('score')->after('members_id')->nullable();
            $table->integer('penalty')->after('members_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_automates', function (Blueprint $table) {
            //
        });
    }
}