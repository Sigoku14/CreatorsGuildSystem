@extends('template/template')

@section('title', 'マイページ')
@section('css', '/CreatorsGuild/public/css/mypage.css')
@include('template/header')

@section('content')
<article>
    <div class="prof">
        <img src="" alt="のアイコン" id="userIcon">
        <h2 id="penname"></h2>
        <a href="/CreatorsGuild/public/goProfEdit/{{$id}}" id="editProf">プロフィールを編集</a>
        <br>
        <!-- <a href="/CreatorsGuild/public/goUpdate/{{$id}}" id="update">ユーザ設定を編集</a> -->
        <section class="profile"></section>
        <div class="perform">
            <a href="/CreatorsGuild/public/showPerformance/{{$id}}" id="showPerformance">実績を編集</a>
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
                    image = '/CreatorsGuild/public/' + value.user_icon_path;
                }
                $("#userIcon").attr('src', image);
                i++;
            }
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
            console.log(xhr);
        })
    })
</script>
@endsection