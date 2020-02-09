@extends('template/template')

@section('title', 'レビュー')
@section('css', '/var/www/html/CreatorsGuild/public/css/evaluation.css')
@include('template/header')

@section('content')
<article id="evaluation">
    @if ($status === 1)
    <div id="for-creator">
        <h2>依頼主評価</h2>
        <p class="exp">
            ・各問いに100点満点で評価してください。
        </p>
        <div class="question">
            <div class="form">
                <p id="q1">依頼主の対応は適切でしたか？</p>
                <p class="qin"><input type="number" name="q1" id="q1-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q2">仕事の難易度は適切でしたか？</p>
                <p class="qin"><input type="number" name="q2" id="q2-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q3">急な仕様変更などありませんでしたか？</p>
                <p class="qin"><input type="number" name="q3" id="q3-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q4">もう一度仕事を受けたい？</p>
                <p class="qin"><input type="number" name="q4" id="q4-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="textarea">
                <p id="area">その他コメント</p>
                <textarea name="textarea" id="textarea" cols="30" rows="10" required></textarea>
            </div>
            <button name="push" id="push">確定</button>
        </div>
    </div>
    @else
    <div id="for-owner">
        <h2>クリエイター評価</h2>
        <p class="exp">
            ・各問いに100点満点で評価してください。
        </p>
        <div class="question">
            <div class="form">
                <p id="q1">納品された作品の完成度は良かったですか？</p>
                <p class="qin"><input type="number" name="q1" id="q1-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q2">クリエイターの対応は適切でしたか？</p>
                <p class="qin"><input type="number" name="q2" id="q2-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q3">納期遵守できていましたか？</p>
                <p class="qin"><input type="number" name="q3" id="q3-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="form">
                <p id="q4">もう一度仕事を依頼したい？</p>
                <p class="qin"><input type="number" name="q4" id="q4-eva" min="0" max="100" required>pt</p>
            </div>
            <div class="textarea">
                <p id="area">その他コメント</p>
                <textarea name="textarea" id="textarea" cols="30" rows="10" required></textarea>
            </div>
            <button name="push" id="push">確定</button>
        </div>
    </div>
    @endif
</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $("#push").on('click', function() {
        var user_id = "{{$id}}";
        var quest_id = "{{$q_id}}";
        var status = "{{$status}}";
        var q1 = $('[name=q1]').val();
        var q2 = $('[name=q2]').val();
        var q3 = $('[name=q3]').val();
        var q4 = $('[name=q4]').val();
        var com = $('[name=textarea]').val();

        var arrayData = {
            'user_id': user_id,
            'quest_id': quest_id,
            'status': status,
            'q1': q1,
            'q2': q2,
            'q3': q3,
            'q4': q4,
            'com': com,
        };
        send_data = JSON.stringify(arrayData);
        console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/var/www/html/CreatorsGuild/public/api/storeEvaluation",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            console.log(msg);
            swal("お疲れ様でした。またのご利用お待ちしてます。").then((yes) => {
                if (yes) {
                    window.location.href = "/var/www/html/CreatorsGuild/public/goHome/{{$id}}/";
                }
            });
        }).fail(function(xhr, status, error) {
            console.log(xhr);
        })
    })
</script>
@endsection