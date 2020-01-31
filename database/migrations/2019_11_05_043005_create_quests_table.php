<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->bigIncrements('quest_id')->comment('連番・クエスト番号');
            $table->string('user_id')->comment('クエスト申請者のID');
            $table->integer('genre_id')->comment('登録ジャンル');
            $table->string('quest_title')->comment('クエスト名');
            $table->string('quest_explanation')->comment('クエスト内容文');
            $table->string('submit_type')->comment('納品形式');
            $table->string('quest_level')->comment('最終的な難易度');
            $table->string('quest_lank')->comment('依頼主希望ランク');
            $table->date('quest_applied')->comment('クエスト応募締め切り日');
            $table->date('quest_period')->comment('クエスト納品期日');
            $table->integer('quest_reward')->comment('報酬額');
            $table->integer('quest_people')->comment('必要人数');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->integer('status')->comment('0=削除、1=応募中、2=クエスト進行中、9=終了');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quests');
    }
}
