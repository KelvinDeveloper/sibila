<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsBoardSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_configurations', function (Blueprint $table) {
            $table->string('list_backlog_id')->after('id')->nullable();
            $table->string('list_sprint_id')->after('id')->nullable();
            $table->string('list_done_id')->after('list_doing_id')->nullable();
            $table->string('task_id')->after('list_doing_id')->nullable();
            $table->integer('user_id')->after('list_doing_id')->nullable();

            $table->string('list_doing_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_configurations', function (Blueprint $table) {
            //
        });
    }
}
