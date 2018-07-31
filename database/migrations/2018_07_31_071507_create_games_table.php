<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGamesTable
 */
class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_x_id');
            $table->unsignedInteger('user_o_id');
            $table->boolean('active');
            $table->string('winner', 20);
            $table->timestamps();

            $table->foreign('user_x_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('user_o_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
