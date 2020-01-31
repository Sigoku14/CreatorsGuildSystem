@extends('template/template')

@section('title', '実績編集')
@section('css', '/CreatorsGuild/public/css/showPerformance.css')
@include('template/header')

@section('content')
<button class="add-p" id="add-p" name="add-p">追加する</button>
<article id="performance">
</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    $("body").ready(function() {
        var id = {
            "id": "{{$id}}",
        };
        senddata = JSON.stringify(id);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/showPerformance",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success
            // console.log(msg);
            var parent = document.getElementById('performance');
            var i = 0;
            for (const [key, value] of Object.entries(msg.performance)) {
                var column = document.createElement("div");
                column.className = "performance-column";
                parent.appendChild(column);

                //クエストタイトル
                var PerformanceTitle = document.createElement("h3");
                PerformanceTitle.className = "performance-title";
                column.appendChild(PerformanceTitle);
                i++;
            }
            //実績登録がない場合
            if (i === 0) {
                //外枠
                var noPerformance = document.createElement("div");
                noPerformance.className = "performance-column noPerformance";
                parent.appendChild(noPerformance);

                //中身
                var noPerformanceTitle = document.createElement("h3");
                noPerformanceTitle.innerHTML = "実績が登録されていません";
                noPerformance.appendChild(noPerformanceTitle);
            }
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
            console.log(xhr);
        })
    })

    $("#add-p").on('click', function() {
        Swal.mixin({
            confirmButtonText: 'Next &rarr;',
            showCancelButton: true,
            progressSteps: ['1', '2', '3', '4'],
            background: 'white',
        }).queue([{
                title: '追加するファイルの選択',
                text: '実績を紹介する画像ファイルを選択してください。',
                input: 'file',
                customClass: 'choose-img',
                inputAttributes: {
                    accept: 'image/*',
                    'aria-label': 'Upload your profile picture'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return '画像ファイルを選択してください。'
                    }
                },
            },
            {
                title: '作品タイトル',
                text: '作品名を入力してください。',
                input: 'text',
                customClass: 'title-text',
                inputValidator: (value) => {
                    if (!value) {
                        return '未入力です。'
                    }
                },
            },
            {
                title: '作品URL',
                text: '作品が関連するURLを入力してください。',
                input: 'url',
                customClass: 'url-text',
            },
            {
                title: '作品詳細',
                text: '作品の一言紹介',
                input: 'textarea',
                customClass: 'exp-textarea',
                inputValidator: (value) => {
                    if (!value) {
                        return '未入力です。'
                    }
                },
            },
        ]).then((result) => {
            if (result.value) {
                const answers = JSON.stringify(result.value)
                console.log(answers);
            }
            if (result) {
                // const reader = new FileReader()
                // reader.onload = (e) => {
                //     Swal.fire({
                //         title: 'Your uploaded picture',
                //         imageUrl: e.target.result,
                //         imageAlt: 'The uploaded picture'
                //     })
                // }
                // reader.readAsDataURL(file)
                console.log(result);
            }
        })
    })
</script>
@endsection