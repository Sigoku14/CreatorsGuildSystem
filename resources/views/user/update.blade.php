<!DOCTYPE html>
<html lang="ja" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>会員情報編集</title>

<body>
    <h1>会員情報編集</h1>

    <div>
        メールアドレス：<input type="email" name="user_mail" id="user_mail" value="{{session('mail')}}">
        <br>
        (もし入力されたら)
        確認用メールアドレス：<input type="email" name="user_mail_ch" id="user_mail_ch">
        <hr>
        パスワード：<input type="password" name="user_password" id="user_password">
        <br>
        (もし入力されたら)
        確認用パスワード：<input type="password" name="user_password_ch" id="user_password_ch">
        <hr>
        <button name="push" id="push">更新</button>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $("#push").on('click', function() {
        var user_mail = $('[name=user_mail]').val();
        var user_mail_ch = $('[name=user_mail_ch]').val();
        var user_password = $('[name=user_password]').val();
        var user_password_ch = $('[name=user_password_ch]').val();
        var arrayData = {
            'user_mail': user_mail,
            'user_mail_ch': user_mail_ch,
            'user_password': user_password,
            'user_password_ch': user_password_ch
        };
        send_data = JSON.stringify(arrayData);
        console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/api/update",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg);
        }).fail(function(xhr, status, error) {
            console.log(msg);
        })
    })
</script>

</html>