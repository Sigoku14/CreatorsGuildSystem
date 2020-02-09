function getThisQuest(questId) {
    var id = {
        "q_id": questId,
    };
    senddata = JSON.stringify(id);
    $.ajax({
        type: "POST",
        url: "/api/showThisQuest",
        contentType: "Content-Type: application/json; charset=UTF-8",
        data: senddata,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (msg, status, xhr) {
        //success
        for (const [key, value] of Object.entries(msg.quests)) {
            $("#title").empty();
            $("#explanation").empty();
            $("#reward").empty();
            $("#period").empty();
            $("#type").empty();
            $("#genre").empty();
            $("#lank").empty();
            $("#owner").empty();
            $("#applied").empty();
            $("#now").empty();
            $("#created-at").empty();

            var beforeDate = moment(value.quest_period, "YYYY-MM-DD");
            var afterPeriod = beforeDate.format('YYYY年MM月DD日');

            var beforeDate = moment(value.quest_applied, "YYYY-MM-DD");
            var afterApplied = beforeDate.format('YYYY年MM月DD日');

            var beforeDate = moment(value.created_at, "YYYY-MM-DD");
            var afterCreated = beforeDate.format('YYYY年MM月DD日');

            $('#title').append(value.quest_title);
            $("#explanation").append(value.quest_explanation.replace(/\r?\n/g, '<br>'));
            $('#reward').append("報酬額：<span>" + value.quest_reward + "</span>G");
            $("#period").append("納期：<span>" + afterPeriod + "</span>まで");
            $("#type").append("納品形式：<span>" + value.submit_type + "</span>");
            $("#genre").append("依頼ジャンル：<span>" + value.genre_name + "</span>");
            $("#lank").append("推奨ランク：<span>" + value.lank_name + "</span>");
            $("#owner").append(value.user_id);
            $("#now").append("募集人数：<span>" + msg.count[value.quest_id] + "/" + value.quest_people + "人</span>");
            $("#applied").append("応募締切日：<span>" + afterApplied + " </span>");
            $("#created-at").append("クエスト発行日：<span>" + afterCreated + " </span>");
            $("#order").append().attr("value", value.quest_id);
        }

    }).fail(function (xhr, status, error) {
        //error
        console.log(status);
    })

}
