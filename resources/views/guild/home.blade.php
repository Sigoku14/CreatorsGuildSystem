@extends('template/template')

@section('title', 'ギルド広場')
@section('css', '/CreatorsGuild/public/css/home.css')
@include('template/header')

@section('content')
<article id="guildHome">
    <h2>クエストカウンター</h2>
    <div id="quest-book">
        <div id="quest-list">
            <div id="quest-more">
                <div id="quest-des">
                    <div class="conditions">
                        <div class="searcher">
                            <input type="text" name="search" class="search" placeholder="検索キーワード">
                        </div>
                        <div class="refine">
                            <div class="genre">
                                <p>ジャンル：</p>
                                <select name="genre" id="genre-sel">
                                    <option value="">▼ジャンル▼</option>
                                </select>
                            </div>
                            <div class="reward">
                                報酬額：<input type="number" name="reward" min="3000" step="500" value="3000">G以上
                            </div>
                            <div class="lank">
                                <p>ランク帯：</p>
                                <select name="lank" id="lank-sel">
                                    <option value="">▼ランク▼</option>
                                </select>
                            </div>
                        </div>
                        <button name="push" id="push">検索</button>
                    </div>
                    <hr>
                    <div id="list">
                    </div>
                </div>
            </div>
        </div>
        <div id="quest-paper">
            <div class="paper">
                <h3 id="title"></h3>
                <div>
                    <p id="explanation"></p>
                </div>
                <div id="imp">
                    <p id="reward"></p>
                    <p id="period"></p>
                </div>
                <div>
                    <p id="type"></p>
                </div>
                <div>
                    <p id="genre"></p>
                </div>
                <div>
                    <p id="lank"></p>
                </div>
                <div id="owner-name">
                    <p>依頼主：</p>
                </div>
                <div id="apply">
                    <p id="applied"></p>
                    <p id="now"></p>
                </div>
                <div>
                    <p id="created-at"></p>
                </div>
                <button name="order" id="order" value="">応募</button>
            </div>
        </div>
    </div>
</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/CreatorsGuild/public/js/showThisQuest.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/showHome",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg);

            $(".genre-val").remove();
            $(".lank-val").remove();
            $('#list').empty();

            for (const [key, value] of Object.entries(msg.genre)) {
                var genreSel = document.getElementById('genre-sel');
                var genreOp = document.createElement("option");
                genreOp.className = "genre-val";
                genreOp.value = value.genre_id;
                genreOp.innerHTML = value.genre_name;
                genreSel.appendChild(genreOp);
            }

            for (const [key, value] of Object.entries(msg.lank)) {
                var lankSel = document.getElementById('lank-sel');
                var lankOp = document.createElement("option");
                lankOp.className = "lank-val";
                lankOp.value = value.lank_id;
                lankOp.innerHTML = value.lank_name;
                lankSel.appendChild(lankOp);
            }

            var parent = document.getElementById('list');
            var i = 0;
            for (const [key, value] of Object.entries(msg.list)) {
                //外枠
                var column = document.createElement("div");
                column.className = 'list-column col-' + value.quest_level;
                column.onclick = function() {
                    getThisQuest(value.quest_id);
                };
                parent.appendChild(column);

                //クエストタイトル
                var questTitle = document.createElement("h3");
                questTitle.className = "quest-title";
                questTitle.innerHTML = value.quest_title;
                column.appendChild(questTitle);

                //クエストジャンル
                var questGenre = document.createElement("p");
                questGenre.className = "quest-genre";
                questGenre.innerHTML = value.genre_name;
                column.appendChild(questGenre);

                //応募中人数
                var questPeople = document.createElement("p");
                questPeople.className = "quest-people";
                questPeople.innerHTML = "<span>" + msg.count[value.quest_id] + "</span>/" + value.quest_people + "人";
                column.appendChild(questPeople);

                //応募締め切り
                var questApplied = document.createElement("p");
                questApplied.className = "quest-applied";
                questApplied.innerHTML = value.quest_applied + "まで";
                column.appendChild(questApplied);

                var beforeDate = moment(value.quest_period, "YYYY-MM-DD");
                var afterPeriod = beforeDate.format('YYYY年MM月DD日');

                var beforeDate = moment(value.quest_applied, "YYYY-MM-DD");
                var afterApplied = beforeDate.format('YYYY年MM月DD日');

                var beforeDate = moment(value.created_at, "YYYY-MM-DD");
                var afterCreated = beforeDate.format('YYYY年MM月DD日');

                if (i == 0) {
                    $('#title').append(value.quest_title);
                    $("#explanation").append(value.quest_explanation.replace(/\r?\n/g, '<br>'));
                    $('#reward').append("報酬額：<span>" + value.quest_reward + "</span>G");
                    $("#period").append("納期：<span>" + afterPeriod + "</span>まで");
                    $("#type").append("納品形式：<span>" + value.submit_type + "</span>");
                    $("#genre").append("依頼ジャンル：<span>" + value.genre_name + "</span>");
                    $("#lank").append("推奨ランク：<span>" + value.lank_name + "</span>");
                    $("#owner-name").append('<a href="/CreatorsGuild/public/showProfile/{{$id}}/' + value.user_id + '" id="owner">' + value.user_id + '</a>');
                    $("#now").append("募集人数：<span>" + msg.count[value.quest_id] + "/" + value.quest_people + "人</span>");
                    $("#applied").append("応募締切日：<span>" + afterApplied + " </span>");
                    $("#created-at").append("クエスト発行日：<span>" + afterCreated + " </span>");
                    $("#order").append().attr("value", value.quest_id);
                }

                i++;
            };

            //クエストがない場合
            if (i === 0) {
                //外枠
                var noQuest = document.createElement("div");
                noQuest.className = "column noQuest";
                parent.appendChild(noQuest);

                //中身
                var noQuestTitle = document.createElement("h3");
                noQuestTitle.innerHTML = "応募中のクエストが見つかりません。";
                noQuest.appendChild(noQuestTitle);

                $(".paper div").addClass("no-quest");
                $("#order").addClass("no-quest");
            }

        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })

    $("#push").on('click', function() {
        var user_id = "{{$id}}";
        var search = $('[name=search]').val();
        var genre = $('[name=genre] option:selected').val();
        var reward = $('[name=reward]').val();
        var lank = $('[name=lank] option:selected').val();

        var arrayData = {
            'id': "{{$id}}",
            'search': search,
            'genre': genre,
            'reward': reward,
            'lank': lank,
        };
        send_data = JSON.stringify(arrayData);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/conditionQuest",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg);
            $(".genre-val").remove();
            $(".lank-val").remove();
            $('#list').empty();
            for (const [key, value] of Object.entries(msg.genre)) {
                var genreSel = document.getElementById('genre-sel');
                var genreOp = document.createElement("option");
                genreOp.className = "genre-val";
                genreOp.value = value.genre_id;
                genreOp.innerHTML = value.genre_name;
                genreSel.appendChild(genreOp);
            }

            for (const [key, value] of Object.entries(msg.lank)) {
                var lankSel = document.getElementById('lank-sel');
                var lankOp = document.createElement("option");
                lankOp.className = "lank-val";
                lankOp.value = value.lank_id;
                lankOp.innerHTML = value.lank_name;
                lankSel.appendChild(lankOp);
            }

            var parent = document.getElementById('list');
            var i = 0;
            for (const [key, value] of Object.entries(msg.list)) {
                //外枠
                var column = document.createElement("div");
                column.className = 'list-column col-' + value.quest_level;
                column.onclick = function() {
                    getThisQuest(value.quest_id);
                };
                parent.appendChild(column);

                //クエストタイトル
                var questTitle = document.createElement("h3");
                questTitle.className = "quest-title";
                questTitle.innerHTML = value.quest_title;
                column.appendChild(questTitle);

                //クエストジャンル
                var questGenre = document.createElement("p");
                questGenre.className = "quest-genre";
                questGenre.innerHTML = value.genre_name;
                column.appendChild(questGenre);

                //応募中人数
                var questPeople = document.createElement("p");
                questPeople.className = "quest-people";
                questPeople.innerHTML = "<span>" + msg.count[value.quest_id] + "</span>/" + value.quest_people + "人";
                column.appendChild(questPeople);

                //応募締め切り
                var questApplied = document.createElement("p");
                questApplied.className = "quest-applied";
                questApplied.innerHTML = value.quest_applied;
                column.appendChild(questApplied);

                i++;
            };

            //クエストがない場合
            if (i === 0) {
                //外枠
                var noQuest = document.createElement("div");
                noQuest.className = "column noQuest";
                parent.appendChild(noQuest);

                //中身
                var noQuestTitle = document.createElement("h3");
                noQuestTitle.innerHTML = "応募中のクエストが見つかりません。";
                noQuest.appendChild(noQuestTitle);

                // $(".paper div").addClass("no-quest");
                // $("#order").addClass("no-quest");
            }
        }).fail(function(xhr, status, error) {
            console.log(xhr);
        })
    })

    $("#order").on('click', function() {
        var user_id = "{{$id}}";
        var order = $('[name=order]').val();

        var arrayData = {
            'id': user_id,
            'q_id': order,
        };
        send_data = JSON.stringify(arrayData);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/applyQuest",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg);
            window.location.href = "/CreatorsGuild/public/goApplied/" + user_id;
        }).fail(function(xhr, status, error) {
            console.log(xhr);
        })
    })
</script>
@endsection