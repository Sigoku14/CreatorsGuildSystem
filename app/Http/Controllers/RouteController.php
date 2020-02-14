<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function goLogin()
    {
        return view("user/login");
    }
    public function goRegister()
    {
        return view("user/register");
    }

    public function goUpdate()
    {
        return view("user/update");
    }

    public function goMypage(string $id)
    {
        return view("user/mypage")->with('id', $id);
    }

    public function goProfEdit(string $id)
    {
        return view("user/profEdit")->with('id', $id);
    }
    public function goHome(string $id)
    {
        return view("guild/home")->with('id', $id);
    }

    public function goOrdered(string $id)
    {
        return view("quest/ordered")->with('id', $id);
    }

    public function goApplied(string $id)
    {
        return view("quest/applied")->with('id', $id);
    }

    public function goMadeQuest(string $id)
    {
        return view("quest/madeQuest")->with('id', $id);
    }

    public function makeQuest(string $id)
    {
        return view("quest/makeQuest")->with('id', $id);
    }

    public function showProfile(string $id, string $o_id)
    {
        return view("guild/profile")->with([
            "id" => $id,
            "o_id" => $o_id
        ]);
    }

    public function questDetail(string $id, string $q_id)
    {
        return view("quest/detail")->with([
            "id" => $id,
            "q_id" => $q_id
        ]);
    }

    public function evaluation(string $id, int $q_id, int $status)
    {
        return view("quest/evaluation")->with([
            "id" => $id,
            "q_id" => $q_id,
            "status" => $status,
        ]);
    }

    public function showPerformance(string $id)
    {
        return view("user/showPerformance")->with('id', $id);
    }
}
