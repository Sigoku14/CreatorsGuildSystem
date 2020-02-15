@extends('template/template')

@section('title', 'マイページ')
@section('css', '/CreatorsGuild/public/css/mypage.css')
@include('template/header')

@section('content')
<article id="p_art">
    <div class="prof">
        <img src="" alt="のアイコン" id="userIcon">
        <div id="user-info">
            <h2 id="penname"></h2>
            <section id="exp-bar"></section>
        </div>
        <a href="/CreatorsGuild/public/goProfEdit/{{$id}}" id="editProf">プロフィールを編集</a>
        <br>
        <!-- <a href="/CreatorsGuild/public/goUpdate/{{$id}}" id="update">ユーザ設定を編集</a> -->
        <section class="profile"></section>
        <section id="shows">
            <div class="show_e">評価を見る</div>
            <div class="show_p">ポートフォリオを見る</div>
        </section>
        <div class="perform">
            <a href="/CreatorsGuild/public/showPerformance/{{$id}}" id="showPerformance">実績追加</a>
            <div id="performances"></div>
        </div>
        <div class="evaluation">
            <div id="c_evaluation"></div>
            <div id="u_evaluation"></div>
        </div>
    </div>
</article>
<article id=" works">
</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/mypage",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg);
            var i = 0;
            for (const [key, value] of Object.entries(msg.profile)) {
                if (value.penname === null) {
                    penname = value.user_id;
                } else {
                    penname = value.penname;
                }
                $("#penname").eq(i).text(penname);
                if (value.profile != null) {
                    $(".profile").eq(i).html(value.profile.replace(/\r?\n/g, '<br>'));
                }

                if (value.user_icon_path === null || value.user_icon_path === "") {
                    image = "/CreatorsGuild/public/img/icon/noImage.png";
                } else {
                    image = '/CreatorsGuild/public/img/userIcon/' + value.user_icon_path;
                }
                $("#userIcon").attr('src', image);
                i++;
            }

            var parent = document.getElementById('performances');
            for (const [key, value] of Object.entries(msg.performance)) {
                var child = document.createElement("div");
                child.className = "child";
                parent.appendChild(child);

                var title = document.createElement("h2");
                title.className = "title";
                title.innerHTML = value.title;
                child.appendChild(title);

                var img = document.createElement("img");
                img.className = "img";
                img.setAttribute('src', "/CreatorsGuild/public/storage/portfolio/" + value.img_path);
                child.appendChild(img);

                if (value.url != "null") {
                    var url = document.createElement("a");
                    url.className = "url";
                    url.href = value.url;
                    url.innerHTML = "リンクはこちら";
                    child.appendChild(url);
                }

                var made = document.createElement("span");
                made.className = "made";
                made.innerHTML = value.made_at;
                child.appendChild(made);

                var comment = document.createElement("div");
                comment.className = "com";
                comment.innerHTML = value.comment.replace(/\r?\n/g, '<br>');
                child.appendChild(comment);
            }

            var exp_bar = document.getElementById("exp-bar");
            for (const [key, value] of Object.entries(msg.bexp)) {
                var expbox = document.createElement("div");
                expbox.className = "exp-box";
                exp_bar.appendChild(expbox);

                var uediv = document.createElement("div");
                uediv.className = "user-exp-box";
                expbox.appendChild(uediv);

                var expnum = document.createElement("span");
                expnum.className = "expnum";
                expnum.innerHTML = msg.exp + "exp";
                uediv.appendChild(expnum);

                var bediv = document.createElement("div");
                bediv.className = "base-exp-box";
                expbox.appendChild(bediv);

                var baseexp = document.createElement("span");
                baseexp.className = "baseexp";
                baseexp.innerHTML = value.lank_max_score + "exp";
                bediv.appendChild(baseexp);

                var percent = (msg.exp / Number(value.lank_max_score)) * 100;
            }
            $('.user-exp-box').css('width', percent + '%');

            if (msg.c_eva != "") {
                var parent = document.getElementById('c_evaluation');
                for (const [key, value] of Object.entries(msg.c_eva)) {
                    var eva_box = document.createElement("div");
                    eva_box.className = "eva-box";
                    parent.appendChild(eva_box);

                    var q1 = document.createElement("div");
                    q1.className = "q1";
                    q1.innerHTML = "<span>クオリティ：</span>" + value.completeness;
                    eva_box.appendChild(q1);

                    var q2 = document.createElement("div");
                    q2.className = "q2";
                    q2.innerHTML = "<span>対応力：</span>" + value.support;
                    eva_box.appendChild(q2);

                    var q3 = document.createElement("div");
                    q3.className = "q3";
                    q3.innerHTML = "<span>納期厳守：</span>" + value.compliance;
                    eva_box.appendChild(q3);

                    var q4 = document.createElement("div");
                    q4.className = "q4";
                    q4.innerHTML = "<span>リピート：</span>" + value.repeat;
                    eva_box.appendChild(q4);

                    var comment = document.createElement("div");
                    comment.className = "com";
                    comment.innerHTML = value.comment.replace(/\r?\n/g, '<br>');
                    eva_box.appendChild(comment);
                }
            }
            if (msg.o_eva != "") {
                var parent = document.getElementById('o_evaluation');
                for (const [key, value] of Object.entries(msg.c_eva)) {
                    var eva_box = document.createElement("div");
                    eva_box.className = "eva-box";
                    parent.appendChild(eva_box);

                    var q1 = document.createElement("div");
                    q1.className = "q1";
                    q1.innerHTML = "<span>対応力：</span>" + value.support;
                    eva_box.appendChild(q1);

                    var q2 = document.createElement("div");
                    q2.className = "q2";
                    q2.innerHTML = "<span>適性な難易度：</span>" + value.difficulty;
                    eva_box.appendChild(q2);

                    var q3 = document.createElement("div");
                    q3.className = "q3";
                    q3.innerHTML = "<span>急な仕様変更：</span>" + value.sincerity;
                    eva_box.appendChild(q3);

                    var q4 = document.createElement("div");
                    q4.className = "q4";
                    q4.innerHTML = "<span>リピート：</span>" + value.repeat;
                    eva_box.appendChild(q4);

                    var comment = document.createElement("div");
                    comment.className = "com";
                    comment.innerHTML = value.comment.replace(/\r?\n/g, '<br>');
                    eva_box.appendChild(comment);
                }
            }
            $('.evaluation').show();
            $('.perform').hide();
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
            console.log(xhr);
        })
    })

    $(".show_e").on('click', function() {
        $('.evaluation').show();
        $('.perform').hide();
    })
    $(".show_p").on('click', function() {
        $('.evaluation').hide();
        $('.perform').show();
    })
</script>
@endsection