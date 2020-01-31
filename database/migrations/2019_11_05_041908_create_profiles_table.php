<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('profile')->nullable();
            $table->string('user_area')->nullable();
            $table->string('user_gender')->nullable();
            $table->date('user_birthday')->nullable();
            $table->string('user_sns')->nullable();
            $table->string('user_icon_path')->nullable();
            $table->datetime('user_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
