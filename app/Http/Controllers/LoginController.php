<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user_mail = $request->input('user_mail');
        $user_password = $request->input('user_password');
        $users = DB::table('users')
            ->where('user_mail', $user_mail)
            ->first();

        $validationMsgs = [];
        $id = "";
        if (!empty($users)) {
            if (password_verify($user_password, $users->user_password)) {
                $id = $users->user_id;
                $status = "success";
            } else {
                $status = "error";
                $validationMsgs['password'] = "パスワードが間違ってます。";
            }
        } else {
            $status = "error";
            $validationMsgs['mail'] = "メールアドレスが間違ってます。";
        }

        return response()->json([
            'id' => $id,
            'status' => $status,
            'validationMsgs' => $validationMsgs
        ]);
    }

    public function logout(Request $request)
    {
        // $session = $request->session();
        // $session->flush();
        // $session->regenerate();
        return redirect("/");
    }
}
