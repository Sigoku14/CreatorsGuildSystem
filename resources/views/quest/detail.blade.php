@extends('template/template')

@section('title', '')
@section('css', '/var/www/html/CreatorsGuild/public/css/questDetail.css')
@include('template/header')

@section('content')
<article>
    <h2></h2>
    <div class="de-sha">
        <div class="box">
            <div id="detail"></div>
            <div id="creChoose">
                <p id="decision"></p>
                <div id="creators"></div>
                <div id="button">
                    <button id="push" name="push">依頼する</button>
                </div>
            </div>
        </div>
    </div>

</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
            "q_id": "{{$q_id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/var/www/html/CreatorsGuild/public/api/questDetail",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            console.log(msg);
            var parent = document.getElementById('detail');
            for (const [key, value] of Object.entries(msg.detail)) {
                //クエストタイトル
                var questTitle = document.createElement("h2");
                questTitle.className = "quest-title";
                questTitle.innerHTML = value.quest_title;
                parent.appendChild(questTitle);

                //クエスト内容
                var explanation = document.createElement("div");
                explanation.className = "explanation";
                parent.appendChild(explanation);
                var explanationH3 = document.createElement("h3");
                explanationH3.innerHTML = "依頼内容";
                explanation.appendChild(explanationH3);
                var explanationP = document.createElement("p");
                explanationP.innerHTML = value.quest_explanation.replace(/\r?\n/g, '<br>');
                explanation.appendChild(explanationP);

                //詳細囲み
                var miniInfo = document.createElement("div");
                miniInfo.className = "mini-info";
                parent.appendChild(miniInfo);

                //納品形式
                var type = document.createElement("div");
                type.className = "type";
                miniInfo.appendChild(type);
                var typeH3 = document.createElement("h3");
                typeH3.innerHTML = "納品形式";
                type.appendChild(typeH3);
                var typeP = document.createElement("p");
                typeP.innerHTML = value.submit_type;
                type.appendChild(typeP);

                //報酬
                var reward = document.createElement("div");
                reward.className = "reward";
                miniInfo.appendChild(reward);
                var rewardH3 = document.createElement("h3");
                rewardH3.innerHTML = "報酬";
                reward.appendChild(rewardH3);
                var rewardP = document.createElement("p");
                rewardP.innerHTML = value.quest_reward + "G";
                reward.appendChild(rewardP);

                //クエスト条件
                var qualification = document.createElement("div");
                qualification.className = "qualification";
                miniInfo.appendChild(qualification);
                var qualificationH3 = document.createElement("h3");
                qualificationH3.innerHTML = "受注・参加条件";
                qualification.appendChild(qualificationH3);

                //受注ランク
                var lank = document.createElement("div");
                lank.className = "lank";
                qualification.appendChild(lank);
                var lankH4 = document.createElement("h4");
                lankH4.innerHTML = "必要ランク";
                lank.appendChild(lankH4);
                var lankP = document.createElement("p");
                lankP.innerHTML = value.lank_name + "ランク以上";
                lank.appendChild(lankP);

                //期日
                var period = document.createElement("div");
                period.className = "period";
                miniInfo.appendChild(period);
                var periodH3 = document.createElement("h3");
                periodH3.innerHTML = "納品期限";
                period.appendChild(periodH3);
                var periodP = document.createElement("p");
                periodP.innerHTML = value.quest_period;
                period.appendChild(periodP);

                var status = 0;
                if (value.status == 1) {
                    $('#decision').append("依頼したいクリエイターを必要人数分選んでください。");
                    var status = 1;
                } else {
                    $('#decision').append("クエスト進行中メンバー");
                }

                if (value.status == 2) {
                    var deli = document.createElement("div");
                    deli.className = "deli";
                    deli.innerHTML = "納品報告";
                    deli.onclick = function() {
                        swal({
                            title: "納品を確認しましたか？",
                            text: "依頼主に納品できた場合のみ報告してください。",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((delivered) => {
                            if (delivered) {
                                swal("ご苦労様でした。\n評価完了で完全に終了となります。", {
                                    icon: "success",
                                }).then((yes) => {
                                    if (yes) {
                                        window.location.href = "/var/www/html/CreatorsGuild/public/evaluation/{{$id}}/" + value.quest_id + "/2";
                                    }
                                })
                            } else {
                                swal(value.quest_period + "までに納品してください。\n納品後、報告してください。", {
                                    icon: "info",
                                });
                            }
                        });
                    };
                    parent.appendChild(deli);
                }
            };

            var creators = document.getElementById('creators');
            var j = 0;
            for (const [key, value] of Object.entries(msg.creator)) {
                //各クリエイター
                var creatorBox = document.createElement("div");
                creatorBox.className = "creator-box";
                creators.appendChild(creatorBox);
                if (status == 1) {
                    var choose = document.createElement("div");
                    choose.className = "choose";
                    creatorBox.appendChild(choose);

                    var creatorCheck = document.createElement("input");
                    creatorCheck.className = "creator-check";
                    creatorCheck.setAttribute("type", "checkbox");
                    creatorCheck.setAttribute("value", value.user_id);
                    choose.appendChild(creatorCheck);
                }
                //クリエイター名
                var nameLink = document.createElement("a");
                nameLink.className = "name-link name-color-" + msg.lank[value.user_id];
                nameLink.href = "/var/www/html/CreatorsGuild/public/showProfile/{{$id}}/" + value.user_id;
                nameLink.innerHTML = value.penname;
                creatorBox.appendChild(nameLink);
                j++;
            };

            if (status !== 1) {
                $('#push').addClass('already');
            }

        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })

    $("#push").on('click', function() {
        var c_id = $('.creator-check:checked').map(function() {
            return $(this).val();
        }).get();

        var arrayData = {
            'id': "{{$id}}",
            'q_id': "{{$q_id}}",
            'c_id': c_id,
        };
        send_data = JSON.stringify(arrayData);
        console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/var/www/html/CreatorsGuild/public/api/request",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg.result);
            if (msg.status === true) {
                window.location.href = "/var/www/html/CreatorsGuild/public/questDetail/{{$id}}/{{$q_id}}";
            } else {
                $(".error").append("<p>" + msg.response + "</p>")
            }
        }).fail(function(xhr, status, error) {
            console.log(msg);
        })
    })
</script>
@endsection