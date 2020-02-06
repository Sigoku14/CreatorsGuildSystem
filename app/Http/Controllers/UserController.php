<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\ProfileRequest;
// use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user_id = $request->input('user_id');
        $penname = $request->input('penname');
        $user_mail = $request->input('user_mail');
        $user_password = $request->input('user_password');

        $validationMsgs = [];
        $us_id = DB::table('users')
            ->where('user_id', $user_id)
            ->first();
        if ($us_id !== null) {
            $validationMsgs['id'] = "そのIDは既に登録されています。";
        }

        $us_ma = DB::table('users')
            ->where('user_mail', $user_mail)
            ->first();
        if ($us_ma !== null) {
            $validationMsgs['mail'] = "そのメールアドレスは既に登録されています。";
        }

        if (empty($validationMsgs)) {
            $user_password = password_hash($user_password, PASSWORD_DEFAULT);
            $user_created_at = date('Y-m-d H:i:s');
            $user_updated_at = date('Y-m-d H:i:s');
            $user_status = 1;
            DB::table('users')->insert(
                ['user_id' => $user_id, 'penname' => $penname, 'user_mail' => $user_mail, 'user_password' => $user_password, 'user_created_at' => $user_created_at, 'user_updated_at' => $user_updated_at, 'user_status' => $user_status]
            );

            DB::table('user_exps')->insert(
                ['user_id' => $user_id, 'exp' => 0, 'updated_at' => $user_updated_at]
            );

            DB::table('profiles')->insert(
                ['user_id' => $user_id, 'user_updated_at' => $user_updated_at]
            );

            $status = "success";
        } else {
            $status = "error";
        }

        return response()->json([
            'id' => $user_id,
            'status' => $status,
            'validationMsgs' => $validationMsgs
        ]);
    }

    public function goUpdate(Request $request)
    {
        $users = DB::table('users')
            ->where('user_id', $request->session()->get('id'))
            ->first();

        $session = $request->session();
        $session->put("penname", $users->penname);
        $session->put("mail", $users->user_mail);
    }

    public function update(Request $request)
    {
        $penname = $request->input('penname');
        $user_mail = $request->input('user_mail');
        $user_mail_ch = $request->input('user_mail_ch');
        $user_password = $request->input('user_password');
        $user_password_ch = $request->input('user_password_ch');

        $validationMsgs = [];
        if ($user_mail == $user_mail_ch) {
            if ($user_mail !== $request->session()->get('mail')) {
                $us_ma = DB::table('users')
                    ->where('user_mail', $user_mail)
                    ->first();
                if ($us_ma !== null) {
                    $validationMsgs['mail'] = $user_mail . "-----" . $request->session()->get('mail');
                    $validationMsgs['msg'] = "そのメールアドレスは既に登録されています。";
                }
            }
        } else {
            $validationMsgs['mail'] = "メールアドレスが一致しません。";
        }

        if ($user_password == $user_password_ch) {
            if ($user_password === null) {
                $user_password = DB::table('users')
                    ->where('user_id', $request->session()->get('id'))
                    ->value('user_password');
            }
            $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        } else {
            $validationMsgs['pass'] = "パスワードが一致しません。";
        }

        if (empty($validationMsgs)) {
            $user_updated_at = date('Y-m-d H:i:s');

            DB::table('users')
                ->where('user_id', $request->session()->get('id'))
                ->update(['penname' => $penname, 'user_mail' => $user_mail, 'user_password' => $user_password, 'user_updated_at' => $user_updated_at]);

            $status = "success";
        } else {
            $status = "error";
        }

        return response()->json([
            'status' => $status,
            'validationMsgs' => $validationMsgs
        ]);
    }

    public function mypage(Request $request)
    {
        $id = $request->input("id");
        $profile[] = DB::table('profiles')->select()
            ->join('users', 'users.user_id', '=', 'profiles.user_id')
            ->where('profiles.user_id', $id)
            ->first();

        $performance = DB::table('portfolios')->select()
            ->where('user_id', $id)
            ->get();

        return  response()->json([
            'profile' => $profile,
            'performance' => $performance,
        ]);
    }
    public function otherProf(Request $request)
    {
        $o_id = $request->input("o_id");
        $profile[] = DB::table('profiles')->select()
            ->join('users', 'users.user_id', '=', 'profiles.user_id')
            ->where('profiles.user_id', $o_id)
            ->first();

        $performance = DB::table('portfolios')->select()
            ->where('user_id', $o_id)
            ->get();

        return  response()->json([
            'profile' => $profile,
            'performance' => $performance,
        ]);
    }

    public function goProfEdit(Request $request)
    {
        $id = $request->input("id");
        $profile[] = DB::table('profiles')->select()
            ->join('users', 'users.user_id', '=', 'profiles.user_id')
            ->where('profiles.user_id', $id)
            ->first();

        $assign = [];
        foreach ($profile as $each) {
            if (isset($each->user_birthday)) {
                $assign['year'] = (int) substr($each->user_birthday, 0, 4);
                $assign['month'] = (int) substr($each->user_birthday, 5, 2);
                $assign['day'] = (int) substr($each->user_birthday, 8, 2);
            }
        }

        return  response()->json([
            'profile' => $profile,
            'birth' => $assign,
        ]);
    }

    public function profEdit(Request $request)
    {
        $penname = $request->input('penname');
        $user_gender = $request->input('gender');
        $user_area = $request->input('area');
        $user_birthday = $request->input('year') . "-" . $request->input('month') . "-" . $request->input('day');
        $user_sns = $request->input('sns');
        $profile = $request->input('profile');
        $user_updated_at = date('Y-m-d H:i:s');

        // // Base64文字列をデコードしてバイナリに変換
        // list(, $fileData) = explode(';', $request->input('icon'));
        // list(, $fileData) = explode(',', $fileData);
        // $fileData = base64_decode($fileData);
        $fileName = $request->input('id') . "_icon" . '.jpg';
        // // 保存するパスを決める
        // $path = "/CreatorsGuild/public/img/userIcon/";
        // // $data = Storage::putFileAs($path, $fileData, $fileName);

        DB::table('users')
            ->where('user_id', $request->input('id'))
            ->update(['penname' => $penname, 'user_updated_at' => $user_updated_at]);

        DB::table('profiles')
            ->where('user_id', $request->input('id'))
            ->update(['profile' => $profile, 'user_area' => $user_area, 'user_gender' => $user_gender, 'user_birthday' => $user_birthday, 'user_sns' => $user_sns, 'user_icon_path' => $fileName, 'user_updated_at' => $user_updated_at]);

        $msg = 'プロフィールを変更しました。';
        return $msg;
    }

    public function showPerformance(Request $request)
    {
        $id = $request->input("id");
        $performance = DB::table('portfolios')->select()
            ->where('user_id', $id)
            ->get();

        return  response()->json([
            'performance' => $performance,
        ]);
    }

    public function addPerformance(Request $request)
    {
        $this->validate($request, [
            'upload' => [
                'required',
                'file',
                'image',
                'mimes:jpeg,png',
            ],
            'title' => [
                'required',
            ],
            'comment' => [
                'required',
            ]
        ]);

        $id = $request->input("id");
        $title = $request->input('title');
        $url = $request->input('url');
        $com = $request->input('comment');
        $madeAt = $request->input('madeYear') . "-" . $request->input('madeMonth');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $status = 1;

        if ($url == '') {
            $url = "null";
        }

        if ($request->file('upload')->isValid([])) {
            $date = date('YmdHis');
            $img = $id . "_" . $date . ".jpg";
            $filename = $request->upload->storeAs('public/portfolio', $img);

            DB::table('portfolios')->insert(
                ['user_id' => $id, 'title' => $title, 'img_path' => $img, 'comment' => $com, 'url' => $url, 'made_at' => $madeAt, 'created_at' => $created_at, 'updated_at' => $updated_at, 'status' => $status]
            );
            return redirect("/goMypage/" . $id);
        }
    }
}
