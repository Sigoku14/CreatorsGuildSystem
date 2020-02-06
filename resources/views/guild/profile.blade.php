@extends('template/template')

@section('title', 'マイページ')
@section('css', '/CreatorsGuild/public/css/mypage.css')
@include('template/header')

@section('content')
<article id="p_art">
    <div class="prof">
        <img src="" alt="のアイコン" id="userIcon">
        <h2 id="penname"></h2>
        <br>
        <section class="profile"></section>
        <div class="perform">
            <div id="performances"></div>
        </div>
    </div>
</article>
<article id=" works">

</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "o_id": "{{$o_id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/otherProf",
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
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
            console.log(xhr);
        })
    })
</script>
@endsection