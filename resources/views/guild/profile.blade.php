@extends('template/template')

@section('title', '')
@section('css', '/CreatorsGuild/public/css/otherProf.css')
@include('template/header')

@section('content')
<article>
    <img src="" alt="のアイコン" id="userIcon">
    <h2 id="penname"></h2>
    <section class="profile"></section>
</article>
<article id="works">

</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
            "o_id": "{{$o_id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/profile",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg);
            var i = 0;
            $.each(msg.profile, function(key, item) {
                $("#penname").eq(i).text(item.penname);
                $(".profile").eq(i).text(item.profile);

                //画像の存在チェック
                if (item.user_icon_path !== "") {
                    image = '/CreatorsGuild/public/img/userIcon/' + item.user_icon_path;
                } else {
                    image = "/CreatorsGuild/public/img/icon/noImage.png";
                }
                $("#userIcon").attr('src', image);
                i++;
            })
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })
</script>
@endsection