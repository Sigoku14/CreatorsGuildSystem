@extends('template/template')

@section('title', 'クエスト登録')
@section('css', '/var/www/html/CreatorsGuild/public/css/makeQuest.css')
@include('template/header')

@section('content')
<article>
    <div class="error"></div>
    <div class="new-shadow">
        <div class="new-quest-paper">
            <h2>依頼書</h2>
            <hr>
            <div class="inside">
                <div class="title">
                    <p>クエストタイトル：</p>
                    <input type="text" name="title" id="title" autocomplete="off" maxlength="20" required>
                </div>

                <div class="exp">
                    <p>クエスト内容</p>
                    <textarea name="explanation" id="explanation" cols="30" rows="8" required placeholder="依頼する内容の詳細をご記入ください。"></textarea>
                </div>

                <div class="genre">
                    <p>ジャンル：</p>
                    <select name="genre" id="genre" required>
                    </select>
                </div>

                <div class="type">
                    <p>納品形式：</p>
                    <input type="text" name="type" id="type" maxlength="20" placeholder="PNGやMP4など" required>
                </div>

                <div class="reward">
                    <p>報酬額：</p>
                    <input type="number" name="reward" id="reward" placeholder="3000" min="3000" step="500" required>
                </div>

                <div class="amount">
                    <p>必要人数：</p>
                    <input type="number" name="amount" id="amount" placeholder="1" required>
                </div>

                <div class="lank">
                    <p>希望ランク：</p>
                    <select name="lank" id="lank" required>
                    </select>
                </div>

                <div class="applied">
                    <p>応募〆切り：</p>
                    <input type="date" name="applied" id="applied" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required>
                </div>

                <div class="period">
                    <p>納品期限：</p>
                    <input type="date" name="period" id="period" min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required>
                </div>
                <button name="push" id="push">登録</button>
            </div>
        </div>
    </div>
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
            url: "/var/www/html/CreatorsGuild/public/api/makeQuest",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg);
            for (const [key, value] of Object.entries(msg.genre)) {
                var genreSel = document.getElementById('genre');
                var genreOp = document.createElement("option");
                genreOp.value = value.genre_id;
                genreOp.innerHTML = value.genre_name;
                genreSel.appendChild(genreOp);
            }

            for (const [key, value] of Object.entries(msg.lank)) {
                var lankSel = document.getElementById('lank');
                var lankOp = document.createElement("option");
                lankOp.value = value.lank_id;
                lankOp.innerHTML = value.lank_name;
                lankSel.appendChild(lankOp);
            }

        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })

    $("#push").on('click', function() {
        var user_id = "{{$id}}";
        var title = $('[name=title]').val();
        var explanation = $('[name=explanation]').val();
        var type = $('[name=type]').val();
        var genre = $('[name=genre] option:selected').val();
        var reward = $('[name=reward]').val();
        var amount = $('[name=amount]').val();
        var lank = $('[name=lank] option:selected').val();
        var applied = $('[name=applied]').val();
        var period = $('[name=period]').val();

        var arrayData = {
            'id': "{{$id}}",
            'title': title,
            'explanation': explanation,
            'type': type,
            'genre': genre,
            'reward': reward,
            'amount': amount,
            'lank': lank,
            'applied': applied,
            'period': period,
        };
        send_data = JSON.stringify(arrayData);
        console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/var/www/html/CreatorsGuild/public/api/storeQuest",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg);
            if (msg.status === true) {
                window.location.href = "/var/www/html/CreatorsGuild/public/goMadeQuest/" + user_id;
            } else {
                $(".error").append("<p>" + msg.response + "</p>")
            }
        }).fail(function(xhr, status, error) {
            console.log(msg);
        })
    })
</script>

@endsection