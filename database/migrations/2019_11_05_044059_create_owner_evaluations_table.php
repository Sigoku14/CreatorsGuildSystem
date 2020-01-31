<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_evaluations', function (Blueprint $table) {
            $table->integer('quest_id');
            $table->string('user_id');
            $table->integer('support');
            $table->integer('difficulty');
            $table->integer('sincerity');
            $table->integer('repeat');
            $table->string('comment');
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_evaluations');
    }
}
