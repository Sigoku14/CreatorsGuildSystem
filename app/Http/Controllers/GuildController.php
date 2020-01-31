<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuildController extends Controller
{
    public function profile(Request $request)
    {
        $o_id = $request->input("o_id");
        $profile[] = DB::table('profiles')->select()
            ->join('users', 'users.user_id', '=', 'profile.user_id')
            ->where('profile.user_id', $o_id)
            ->first();

        return  response()->json([
            'profile' => $profile,
        ]);
    }
}
