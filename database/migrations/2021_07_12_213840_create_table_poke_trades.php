<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePokeTrades extends Migration
{
    public function up()
    {
        Schema::create('poke_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id');
            $table->foreignId('poke_id');
            $table->integer('player_id');
            $table->string('name', 255);
            $table->integer('xp');
            $table->timestamps();
            
            $table->foreign('trade_id')->references('id')->on('trades');
        });
    }

    public function down()
    {
        Schema::table('poke_trades', function (Blueprint $table) {
            $table->dropForeign(['trade_id']);
        });

        Schema::dropIfExists('poke_trades');
    }
}
