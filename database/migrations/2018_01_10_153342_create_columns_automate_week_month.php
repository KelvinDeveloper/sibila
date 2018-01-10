<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsAutomateWeekMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_automates', function (Blueprint $table) {
            $table->integer('week_day')->after('labels_id')->nullable();
            $table->integer('month_day')->after('labels_id')->nullable();
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
