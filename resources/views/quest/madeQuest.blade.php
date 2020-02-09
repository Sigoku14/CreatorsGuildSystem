@extends('template/template')

@section('title', '依頼中クエスト一覧')
@section('css', '/css/madeQuest.css')
@include('template/header')

@section('content')
<article>
    <h2>発注中クエストリスト</h2>
    <div class="makeQ">
        <a href="/makeQuest/{{$id}}">＋</a>
    </div>
    <div id="list-shadow">
        <div id="list"></div>
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
            url: "/api/showMadeQuest",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg.count);
            var parent = document.getElementById('list');
            var i = 0;
            for (const [key, value] of Object.entries(msg.list)) {
                //外枠
                var column = document.createElement("div");
                for (var c = 1; c <= 5; c++) {
                    if (value.quest_level == c) {
                        column.className = "list-column level" + c;
                    }
                }
                parent.appendChild(column);

                //クエストタイトル
                var questTitle = document.createElement("h3");
                questTitle.className = "quest-title";
                column.appendChild(questTitle);

                //詳細へのリンク
                var questLink = document.createElement("a");
                questLink.href = "/questDetail/{{$id}}/" + value.quest_id;
                questLink.className = "quest-link"
                questLink.innerHTML = value.quest_title;
                questTitle.appendChild(questLink);

                //応募中人数
                var questPeople = document.createElement("p");
                questPeople.className = "quest-people";
                questPeople.innerHTML = msg.count[value.quest_id] + "人";
                column.appendChild(questPeople);

                var questStatus = document.createElement("p");
                questStatus.className = "quest-status";
                if (value.status === 1) {
                    questStatus.innerHTML = "クリエイター応募中";
                } else {
                    questStatus.innerHTML = "クエスト進行中";
                }
                column.appendChild(questStatus);

                i++;
            };

            //クエストがない場合
            if (i === 0) {
                //外枠
                var noQuest = document.createElement("div");
                noQuest.className = "column noQuests";
                parent.appendChild(noQuest);

                //中身
                var noQuestTitle = document.createElement("h3");
                noQuestTitle.innerHTML = "現在、応募もしくは進行中のクエストはございません。";
                noQuest.appendChild(noQuestTitle);

                var noQuestP = document.createElement("p");
                noQuestP.innerHTML = "クエストを作成したい場合はこちら↓";
                noQuest.appendChild(noQuestP);

                $(".makeQ").addClass("noQ");
            }
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })
</script>
@endsection