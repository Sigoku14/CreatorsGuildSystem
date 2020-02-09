<!DOCTYPE html>
<html>

<head>
    @yield('header')
</head>

<body>
    <header>
        <div>
            <h1><img src="/var/www/html/CreatorsGuild/public/img/image/logo.png" alt="ロゴロゴ"></h1>
            <nav>
                <ul class="nav-ul">
                    <li><a href="/var/www/html/CreatorsGuild/public/goHome/{{$id}}"><img src="/var/www/html/CreatorsGuild/public/img/icon/splash.png" alt="広場へ" class="icon"><span>広場</span></a></li>
                    <li><a href="/var/www/html/CreatorsGuild/public/goOrdered/{{$id}}"><img src="/var/www/html/CreatorsGuild/public/img/icon/book.png" alt="受注一覧へ" class=" icon"><span>受注中リスト</span></a></li>
                    <li><a href="/var/www/html/CreatorsGuild/public/goApplied/{{$id}}"><img src="/var/www/html/CreatorsGuild/public/img/icon/paper.png" alt="応募済みへ" class="icon"><span>応募済みリスト</span></a></li>
                    <li><a href="/var/www/html/CreatorsGuild/public/goMadeQuest/{{$id}}"><img src="/var/www/html/CreatorsGuild/public/img/icon/write.png" alt="発注中のクエストへ" class="icon"><span>発注中リスト</span></a></li>
                    <li><a href="/var/www/html/CreatorsGuild/public/goMypage/{{$id}}"><img src="/var/www/html/CreatorsGuild/public/img/icon/home.png" alt="マイページへ" class=" icon"><span>マイページ</span></a></li>
                </ul>
            </nav>
            <a href="/var/www/html/CreatorsGuild/public/api/logout" id="setting">Logout</a>
            <!-- <a href="/var/www/html/CreatorsGuild/public/api/logout" id="logout">ログアウト</a> -->
        </div>
    </header>
    <div id="wrapper">
        @yield('content')
    </div>
    <footer>
        <small>© 2019-2020 H.Kitayama. All Rights Reserved.</small>
    </footer>
</body>

</html>