<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTrades extends Migration
{
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->enum('fair', ['JUSTA', 'INJUSTA']);
            $table->integer('diff');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
