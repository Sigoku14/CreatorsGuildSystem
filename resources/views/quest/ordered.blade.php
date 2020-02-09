@extends('template/template')

@section('title', '受注クエスト一覧')
@section('css', '/css/ordered.css')
@include('template/header')

@section('content')
<h2 id="quests">受注中のクエスト</h2>
<article id="guildBoard">

</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/api/showOrdered",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success

            var parent = document.getElementById('guildBoard');
            var i = 0;
            for (const [key, value] of Object.entries(msg.ordered)) {

                //外枠
                var shadow = document.createElement("div");
                shadow.className = "shadow";
                parent.appendChild(shadow);
                var guildPaper = document.createElement("section");
                guildPaper.id = "quest-" + value.quest_id;
                guildPaper.className = "guildPaper";
                shadow.appendChild(guildPaper);

                //クエストタイトル
                var questTitle = document.createElement("h2");
                questTitle.className = "quest-title";
                questTitle.innerHTML = value.quest_title;
                guildPaper.appendChild(questTitle);

                //クエスト内容
                var explanation = document.createElement("div");
                explanation.className = "explanation";
                guildPaper.appendChild(explanation);
                var explanationH3 = document.createElement("h3");
                explanationH3.innerHTML = "依頼内容";
                explanation.appendChild(explanationH3);
                var explanationP = document.createElement("p");
                explanationP.innerHTML = value.quest_explanation.replace(/\r?\n/g, '<br>');
                explanation.appendChild(explanationP);

                //詳細囲み
                var miniInfo = document.createElement("div");
                miniInfo.className = "mini-info";
                guildPaper.appendChild(miniInfo);

                //依頼主
                var owner = document.createElement("div");
                owner.className = "owner";
                miniInfo.appendChild(owner);
                var ownerNameH3 = document.createElement("h3");
                ownerNameH3.innerHTML = "依頼主";
                owner.appendChild(ownerNameH3);
                var ownerNameP = document.createElement("p");
                owner.appendChild(ownerNameP);
                var ownerName = document.createElement("a");
                ownerName.href = "/showProfile/{{$id}}/" + value.user_id;
                ownerName.innerHTML = value.penname;
                ownerNameP.appendChild(ownerName);

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

                //参加人数
                var amount = document.createElement("div");
                amount.className = "amount";
                qualification.appendChild(amount);
                var amountH4 = document.createElement("h4");
                amountH4.innerHTML = "受注人数";
                amount.appendChild(amountH4);
                var amountP = document.createElement("p");
                amountP.innerHTML = "5";
                amount.appendChild(amountP);
                var amountSpan = document.createElement("span");
                amountSpan.innerHTML = "/" + value.quest_people + "人";
                amountP.appendChild(amountSpan);

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

                var deli = document.createElement("div");
                deli.className = "deli";
                deli.innerHTML = "納品する";
                deli.onclick = function() {
                    swal({
                        title: "納品報告しますか？",
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
                                    window.location.href = "/evaluation/{{$id}}/" + value.quest_id + "/1";
                                }
                            })
                        } else {
                            swal(value.quest_period + "までに納品してください。\n納品後、報告してください。", {
                                icon: "info",
                            });
                        }
                    });
                };
                guildPaper.appendChild(deli);

                i++;
            };
            if (i === 0) {
                //外枠
                var shadow = document.createElement("div");
                shadow.className = "shadow";
                parent.appendChild(shadow);
                var guildPaper = document.createElement("section");
                guildPaper.className = "guildPaper noQuests";
                shadow.appendChild(guildPaper);

                //クエストタイトル
                var noQuestTitle = document.createElement("h2");
                noQuestTitle.innerHTML = "現在受注中のクエストはございません。";
                guildPaper.appendChild(noQuestTitle);

                var noQuestP = document.createElement("p");
                noQuestP.innerHTML = "クエストを受けたい場合はこちら↓";
                guildPaper.appendChild(noQuestP);

                var goQuestLink = document.createElement("a");
                goQuestLink.innerHTML = "ギルド広場へ";
                goQuestLink.href = "/goHome/{{$id}}";
                guildPaper.appendChild(goQuestLink);
            }
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })
</script>
@endsection