<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestController extends Controller
{
    public function showHome(Request $request)
    {
        $id = $request->input('id');
        $date = date('Y-m-d');

        $list = DB::table('quests')->select()
            ->join('genres', 'genres.genre_id', '=', 'quests.genre_id')
            ->join('lanks', 'lanks.lank_id', '=', 'quests.quest_level')
            ->whereNotIn('quests.user_id', [$id])
            ->whereNotIn('status', [2, 9])
            ->where('quests.quest_applied', '>=', $date)
            ->orderBy('quests.created_at', 'desc')
            ->limit(20)
            ->get();

        $count = [];
        foreach ($list as $li) {
            $count[$li->quest_id] = DB::table('quest_apply')->select()
                ->where('quest_id', '=', $li->quest_id)
                ->count();
        }

        $genre = DB::table('genres')->select()->get();
        $lank = DB::table('lanks')->select()->get();

        return response()->json([
            'list' => $list,
            'count' => $count,
            'genre' => $genre,
            'lank' => $lank,
            'date' => $date
        ]);
    }

    public function conditionQuest(Request $request)
    {
        $id = $request->input('id');
        $search = $request->input('search');
        $genre = $request->input('genre');
        $reward = $request->input('reward');
        $lank = $request->input('lank');
        $date = date('Y-m-d');

        $query = DB::table('quests')->select()->join('genres', 'genres.genre_id', '=', 'quests.genre_id');
        if (isset($search)) {
            $query->where('quests.quest_title', 'like', '%' . $search . '%');
            $query->orWhere('quests.quest_explanation', 'like', '%' . $search . '%');
        }
        if (isset($genre)) {
            $query->where('quests.genre_id', $genre);
        }
        if (isset($reward)) {
            $query->where('quests.quest_reward', '>=', $reward);
        }
        if (isset($lank)) {
            $query->where('quests.quest_level', $lank);
        }
        $query->whereNotIn('quests.user_id', [$id])
            ->whereNotIn('quests.status', [2, 9])
            ->where('quests.quest_applied', '>=', $date)
            ->orderBy('quests.created_at', 'desc')
            ->limit(20);
        $list = $query->get();

        $count = [];
        foreach ($list as $li) {
            $count[$li->quest_id] = DB::table('quest_apply')->select()
                ->where('quest_id', '=', $li->quest_id)
                ->count();
        }
        $genre = DB::table('genres')->select()->get();
        $lank = DB::table('lanks')->select()->get();

        return response()->json([
            'list' => $list,
            'count' => $count,
            'genre' => $genre,
            'lank' => $lank,
        ]);
    }

    public function showThisQuest(Request $request)
    {
        $q_id = $request->input('q_id');

        $quest = DB::table('quests')->select()
            ->join('genres', 'genres.genre_id', '=', 'quests.genre_id')
            ->join('lanks', 'lanks.lank_id', '=', 'quests.quest_level')
            ->where('quests.quest_id', $q_id)
            ->get();
        $count = [];
        foreach ($quest as $li) {
            $count[$li->quest_id] = DB::table('quest_apply')->select()
                ->where('quest_id', '=', $li->quest_id)
                ->count();
        }

        return response()->json([
            'quests' => $quest,
            'count' => $count
        ]);
    }

    public function applyQuest(Request $request)
    {
        $id = $request->input('id');
        $q_id = $request->input('q_id');
        $created_at = date('Y-m-d H:i:s');

        $check = DB::table('quest_apply')->select()
            ->where('user_id', '=', $id)
            ->where('quest_id', '=', $q_id)
            ->count();

        if ($check === 0) {
            DB::table('quest_apply')->insert(
                ['user_id' => $id, 'quest_id' => $q_id, 'created_at' => $created_at]
            );
            $status = "応募が完了しました。";
        } else {
            $status = "既に応募済みです。";
        }

        return response()->json([
            'status' => $status,
        ]);
    }

    public function showMadeQuest(Request $request)
    {
        $id = $request->input('id');
        $list = DB::table('quests')->select('quests.quest_id', 'quests.quest_title', 'quests.quest_level', 'quests.status')
            ->where('quests.user_id', '=', $id)
            ->whereNotIn('status', [9])
            ->groupBy('quests.quest_id', 'quests.quest_title', 'quests.quest_level', 'quests.status')
            ->get();

        $count = [];
        foreach ($list as $app) {
            $count[$app->quest_id] = DB::table('quest_apply')->select()
                ->where('quest_id', '=', $app->quest_id)
                ->count();
        }

        return response()->json([
            'list' => $list,
            'count' => $count
        ]);
    }

    public function makeQuest(Request $request)
    {
        $genre = DB::table('genres')->select()->get();

        $lank = DB::table('lanks')->select()->get();

        return response()->json([
            'genre' => $genre,
            'lank' => $lank,
        ]);
    }

    public function storeQuest(Request $request)
    {
        $user_id = $request->input('id');
        $title = $request->input('title');
        $explanation = $request->input('explanation');
        $submitType = $request->input('type');
        $genre = $request->input('genre');
        $reward = $request->input('reward');
        $amount = $request->input('amount');
        $lank = $request->input('lank');
        $applied = $request->input('applied');
        $period = $request->input('period');

        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $status = 1;


        DB::table('quests')->insert(
            ['user_id' => $user_id, 'quest_title' => $title, 'quest_explanation' => $explanation, 'submit_type' => $submitType, 'genre_id' => $genre, 'quest_reward' => $reward, 'quest_people' => $amount, 'quest_level' => $lank, 'quest_lank' => $lank, 'quest_applied' => $applied, 'quest_period' => $period, 'created_at' => $created_at, 'updated_at' => $updated_at, 'status' => $status]
        );
        $id = DB::getPdo()->lastInsertId();
        if ($id !== null) {
            $response = '依頼が受理されました。';
            $status = true;
        } else {
            $response = '依頼が正常に受理されませんでした。';
            $status = false;
        }

        return response()->json([
            'response' => $response,
            'status' => $status,
        ]);
    }

    public function showApplied(Request $request)
    {
        $applied = DB::table('quest_apply')->select()
            ->join('quests', 'quests.quest_id', '=', 'quest_apply.quest_id')
            ->join('users', 'users.user_id', '=', 'quests.user_id')
            ->join('lanks', 'lanks.lank_id', '=', 'quests.quest_level')
            ->where('quest_apply.user_id', $request->input('id'))
            ->where('quests.status', '=', 1)
            ->get();

        $amount = [];
        foreach ($applied as $app) {
            $amount[$app->quest_id] = DB::table('quest_apply')
                ->where('quest_id', '=', $app->quest_id)
                ->count();
        }

        return response()->json([
            'applied' => $applied,
            'amount' => $amount
        ]);
    }

    public function showOrdered(Request $request)
    {
        $ordered = DB::table('quest_apply')->select()
            ->join('quests', 'quests.quest_id', '=', 'quest_apply.quest_id')
            ->join('users', 'users.user_id', '=', 'quests.user_id')
            ->join('lanks', 'lanks.lank_id', '=', 'quests.quest_level')
            ->where('quest_apply.user_id', $request->input('id'))
            ->where('quests.status', '=', 2)
            ->get();

        $amount = '';
        foreach ($ordered as $app) {
            $amount[$app->quest_id] = DB::table('quest_apply')
                ->where('quest_id', '=', $app->quest_id)
                ->count();
        }

        return response()->json([
            'ordered' => $ordered,
        ]);
    }

    public function questDetail(Request $request)
    {
        $detail = DB::table('quests')->select()
            ->join('lanks', 'lanks.lank_id', '=', 'quests.quest_level')
            ->join('genres', 'genres.genre_id', '=', 'quests.genre_id')
            ->where('quests.quest_id', $request->input('q_id'))
            ->where('quests.status', '<>', 9)
            ->get();

        $creator = DB::table('quest_apply')->select('quest_apply.user_id', 'users.penname', 'user_exps.exp')
            ->join('users', 'users.user_id', '=', 'quest_apply.user_id')
            ->join('user_exps', 'user_exps.user_id', '=', 'quest_apply.user_id')
            ->where('quest_apply.quest_id', $request->input('q_id'))
            ->get();

        $lank = DB::table('lanks')->select()->get();

        $creatorLank = [];
        foreach ($creator as $cre) {
            foreach ($lank as $lnk) {
                if ($lnk->lank_min_score <= $cre->exp && $cre->exp <= $lnk->lank_max_score) {
                    $creatorLank[$cre->user_id] = $lnk->lank_name;
                }
            }
        }

        return response()->json([
            'detail' => $detail,
            'creator' => $creator,
            'lank' => $creatorLank
        ]);
    }

    public function request(Request $request)
    {
        $q_id = $request->input('q_id');
        $c_id = $request->input('c_id');
        $created_at = date('Y-m-d H:i:s');

        foreach ($c_id as $creator_id) {
            DB::table('quest_decided')->insert(
                ['quest_id' => $q_id, 'user_id' => $creator_id, 'created_at' => $created_at]
            );
        }

        $updated_at = date('Y-m-d H:i:s');
        DB::table('quests')
            ->where('quest_id', $q_id)
            ->update(['updated_at' => $updated_at, 'status' => 2]);


        $status = true;
        return response()->json([
            'status' => $status,
        ]);
    }

    public function storeEvaluation(Request $request)
    {
        $q_id = $request->input('quest_id');
        $id = $request->input('user_id');
        $status = $request->input('status');
        $q1 = $request->input('q1');
        $q2 = $request->input('q2');
        $q3 = $request->input('q3');
        $q4 = $request->input('q4');
        $com = $request->input('com');
        $created_at = date('Y-m-d H:i:s');
        $exp = 0;

        $evad_id = DB::table('quest_decided')->select('user_id')
            ->where('quest_id', '=', $q_id)
            ->first();
        foreach ($evad_id as $value) {
            $evad_id = $value;
        }

        //依頼主に対する評価のインサート
        if ($status == 1) {
            $already = DB::table('owner_evaluations')->select()
                ->where('quest_id', $q_id)
                ->where('user_id', $id)
                ->where('evad_id', $evad_id)
                ->count();

            if ($already === 0) {
                DB::table('owner_evaluations')->insert(
                    ['quest_id' => $q_id, 'user_id' => $id, 'evad_id' => $evad_id, 'support' => $q1, 'difficulty' => $q2, 'sincerity' => $q3, 'repeat' => $q4, 'comment' => $com,  'created_at' => $created_at]
                );
            } else {
                DB::table('owner_evaluations')
                    ->where('quest_id', $q_id)
                    ->where('user_id', $id)
                    ->where('evad_id', $evad_id)
                    ->update(['support' => $q1, 'difficulty' => $q2, 'sincerity' => $q3, 'repeat' => $q4, 'comment' => $com]);
            }
        } else {
            $already = DB::table('creator_evaluations')->select()
                ->where('quest_id', $q_id)
                ->where('user_id', $id)
                ->where('evad_id', $evad_id)
                ->count();

            if ($already ===  0) {
                DB::table('creator_evaluations')->insert(
                    ['quest_id' => $q_id, 'user_id' => $id, 'evad_id' => $evad_id, 'completeness' => $q1, 'support' => $q2, 'compliance' => $q3, 'repeat' => $q4, 'comment' => $com,  'created_at' => $created_at]
                );
            } else {
                DB::table('creator_evaluations')
                    ->where('quest_id', $q_id)
                    ->where('user_id', $id)
                    ->where('evad_id', $evad_id)
                    ->update(['completeness' => $q1, 'support' => $q2, 'compliance' => $q3, 'repeat' => $q4, 'comment' => $com]);
            }
        }

        $creators = DB::table('quest_apply')->select()
            ->where('quest_id', $q_id)
            ->count();
        $creators = $creators + 1;

        $eva1 = DB::table('creator_evaluations')->select()
            ->where('quest_id', $q_id)
            ->count();
        $eva2 = DB::table('owner_evaluations')->select()
            ->where('quest_id', $q_id)
            ->count();

        if ($creators == $eva1 + $eva2) {
            DB::table('quests')
                ->where('quest_id', $q_id)
                ->update(['status' => 9]);
        }
        if ($status == 2) {
            $u_exp = DB::table('user_exps')->select('exp')->where('user_id', '=', $evad_id)->first();
            foreach ($u_exp as $value) {
                $u_exp = $value;
            }
            $lank = DB::table('quests')->select('quest_level')->where('quest_id', '=', $q_id)->first();
            foreach ($lank as $value) {
                $lank = $value;
            }
            $ave = floor(($q1 + $q2 + $q3 + $q4) / 8);
            $base = 80;
            $exp = $u_exp + ($ave * ($base * (($lank + 1) / 2)));
            $updated_at = date('Y-m-d H:i:s');

            DB::table('user_exps')
                ->where('user_id', $evad_id)
                ->update([
                    'exp' => $exp,
                    'updated_at' => $updated_at
                ]);
        }

        $status = true;
        return response()->json([
            'status' => $status,
            'eva1' => $eva1,
            'eva2' => $eva2,
            'cre' => $creators,
            'exp' => $exp
        ]);
    }
}
