<!DOCTYPE html>
<html lang="ja" dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="ログイン画面です" />
    <!-- Title -->
    <meta name="keywords" content="" />
    <!-- StyleSheet -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="text/css" rel="stylesheet" href="/var/www/html/CreatorsGuild/public/css/default.css" />
    <link type="text/css" rel="stylesheet" href="public/css/style.css" />
    <title>ログイン</title>
</head>

<body id="index" class="index">
    <!-- header -->
    <header>
        <div id="header">
            <h1 id="headerLogo"><a href="/var/www/html/CreatorsGuild/public/"><img src="/var/www/html/CreatorsGuild/public/img/image/logo.png" alt="ロゴロゴ"></a></h1>
        </div>
    </header>
    <!-- /header -->

    <div id="body">
        <div class="workBox">
            <form>
                <h2 class="title"><img src="/var/www/html/CreatorsGuild/public/img/image/login_title.svg" alt="ログイン" /></h2>
                <dl class="login">
                    <dt><label for="mail">メールアドレス</label></dt>
                    <dd><input type="text" id="mail" name="user_mail" /></dd>
                    <dt><label for="password">パスワード</label></dt>
                    <dd><input type="password" id="password" name="user_password" /></dd>
                </dl>
                <p class="button"><input type="submit" id="submit" value="LOGIN" /></p>
            </form>
        </div>
        <div class="add">
            <p><a href="/var/www/html/CreatorsGuild/public/goRegister">新規登録の場合はこちら</a></p>
        </div>
    </div>

    <p id="backToTop"><a href="#">ページトップに戻る</a></p>
    <!-- footer -->
    <footer>
        <div id="footer">
            <p id="copyright">&copy;2019 foo</p>
        </div>
    </footer>
    <!-- /footer -->
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/var/www/html/CreatorsGuild/public/js/jquery.anchor.js"></script>
<script type="text/javascript">
    $("#submit").on('click', function() {
        var user_mail = $('[name=user_mail]').val();
        var user_password = $('[name=user_password]').val();
        var arrayData = {
            'user_mail': user_mail,
            'user_password': user_password
        };
        send_data = JSON.stringify(arrayData);
        console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/var/www/html/CreatorsGuild/public/api/login",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: send_data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            var id = msg['id'];
            if (msg['status'] == "success") {
                window.location.href = "/var/www/html/CreatorsGuild/public/goHome/" + id;
            }
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })
</script>

</html>