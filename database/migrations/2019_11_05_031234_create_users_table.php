<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id')->comment('ユーザー任意で一意性のある英数字英数字');
            $table->string('penname')->comment('ユーザー任意のペンネーム');
            $table->string('user_mail')->comment('ユーザーのメールアドレス');
            $table->string('user_password')->comment('ユーザーのパスワード（hash化）');
            $table->dateTime('user_created_at');
            $table->datetime('user_updated_at');
            $table->integer('user_status')->comment('0=退会、1=正常');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
