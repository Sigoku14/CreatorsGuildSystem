<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="ユーザー登録画面です" />
    <meta name="keywords" content="" />
    <!-- Title -->
    <title>ユーザー登録</title>
    <!-- StyleSheet -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="text/css" rel="stylesheet" href="/var/www/html/CreatorsGuild/public/css/default.css" />
    <link type="text/css" rel="stylesheet" href="/var/www/html/CreatorsGuild/public/css/style.css" />
</head>

<body id="index" class="index">
    <!-- header -->
    <header>
        <div id="header">
            <h1 id="headerLogo"><a href="/var/www/html/CreatorsGuild/public/"><img src="/var/www/html/CreatorsGuild/public/img/image/logo.png" alt="ロゴロゴ"></a></h1>
        </div>
    </header>
    <!-- /header -->
    <!-- #breadcrumb -->
    <nav>
        <div id="breadcrumbs">
            <p>
                <a href="/var/www/html/CreatorsGuild/public/" rel="home">ホーム</a>
                <span class="delimiter"></span>
                <span>ユーザー登録</span>
            </p>
        </div>
    </nav> <!-- /#breadcrumb -->

    <body>
        <!-- <h1>会員登録</h1> -->

        <div id="body">
            <div class="workBox">
                <form>
                    <h2 class="title"><img src="/var/www/html/CreatorsGuild/public/img/image/register_title.svg" alt="ユーザー登録" /></h2>
                    <table class="register">
                        <tbody>
                            <tr>
                                <th><label for="id">ID<span class="require">必須</span></label></th>
                                <td><input type="text" id="id" name="user_id" autocomplete="off" /></td>
                            </tr>
                            <tr>
                                <th><label for="mail">メールアドレス<span class="require">必須</span></label></th>
                                <td><input type="text" id="mail" name="user_mail" /></td>
                            </tr>
                            <tr>
                                <th><label for="name">ペンネーム<span class="require">必須</span></label></th>
                                <td><input type="text" id="name" name="penname" /></td>
                            </tr>
                            <tr>
                                <th><label for="password">パスワード<span class="require">必須</span></label></th>
                                <td><input type="password" id="password" name="user_password" autocomplete="off" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="button"><button id="push" name="push">登録</button></p>
                </form>
            </div>
        </div>
    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="js/jquery.anchor.js"></script> -->
    <script type="text/javascript">
        $("#push").on('click', function() {
            var user_id = $('[name=user_id').val();
            var penname = $('[name=penname]').val();
            var user_mail = $('[name=user_mail]').val();
            var user_password = $('[name=user_password]').val();
            var arrayData = {
                'user_id': user_id,
                'penname': penname,
                'user_mail': user_mail,
                'user_password': user_password
            };
            send_data = JSON.stringify(arrayData);
            console.log(send_data);
            $.ajax({
                type: "POST",
                url: "/var/www/html/CreatorsGuild/public/api/register",
                contentType: "Content-Type: application/json; charset=UTF-8",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: send_data
            }).done(function(msg, status, xhr) {
                //success
                var id = msg['id'];
                if (msg['status'] == "success") {
                    window.location.href = "/var/www/html/CreatorsGuild/public/goHome/" + id;
                }
            }).fail(function(xhr, status, error) {
                console.log(status);
            })
        })
    </script>

</html>