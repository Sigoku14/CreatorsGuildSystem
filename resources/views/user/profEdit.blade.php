@extends('template/template')

@section('title', 'プロフィール編集')
@section('css', '/CreatorsGuild/public/css/profEdit.css')
@include('template/header')

@section('content')
<article>
    <h2 class='edit-h2'>プロフィール変更</h2>
    <div class="comment"></div>
    <section class="form-sec">
        <div>
            <p>ペンネーム</p>
            <input type="text" name="penname" id="penname" value="">
        </div>

        <div>
            <p>性別</p>
            <input type="radio" name="gender" class="gender" value="male"><span>男</span>
            <input type="radio" name="gender" class="gender second" value="female"><span>女</span>
        </div>

        <div>
            <p>住所(地域)</p>
            <select name="area" id="area">
                @foreach(config('prefecture') as $index => $name)
                <option value="{{$index}}">{{$name}}</option>
                @endforeach
            </select>
        </div>

        <div class="birth">
            <p>生年月日</p>
            <select name="year" id="year">
                @for( $value = date('Y'); $value >= 1950; $value-- )
                <option value="{{$value}}">
                    {{$value}}
                </option>
                @endfor
            </select>
            年
            <select name="month" id="month">
                @for( $value = 1; $value <= 12; $value++ ) <option value="{{$value}}">
                    {{$value}}
                    </option>
                    @endfor
            </select>
            月
            <select name="day" id="day">
                @for( $value = 1; $value <= 31; $value++ ) <option value="{{$value}}">
                    {{$value}}
                    </option>
                    @endfor
            </select>
            日
        </div>
        <div>
            <p>SNS(連絡先)</p>
            <input type="text" name="sns" id="sns" value="">
        </div>

        <div>
            <p>アイコン画像</p>
            <input type="file" name="icon" id="icon">
        </div>

        <div>
            <p>自己紹介</p>
            <textarea name="profile" id="profile" cols="30" rows="10"></textarea>
        </div>

        <input type="hidden" name="base64" id="base64" value="">
        <button id="push">保存</button>
    </section>
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
            url: "/CreatorsGuild/public/api/goProfEdit",
            contentType: "Content-Type: application/json; charset=UTF-8",
            data: senddata,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function(msg, status, xhr) {
            //success

            var i = 0;
            $.each(msg.profile, function(key, item) {
                $("#penname").eq(i).attr('value', item.penname);
                $("#profile").eq(i).text(item.profile);
                $("#sns").eq(i).attr('value', item.user_sns);
                $("#area").eq(i).val(item.user_area);
                $('[name="gender"]').val([item.user_gender]);
                i++;
            })
            $.each(msg.birth, function(key, item) {
                $('#' + key).val(item);
            })
        }).fail(function(xhr, status, error) {
            //error
            console.log(status);
        })
    })

    $("#push").on('click', function() {

        var penname = $('[name=penname]').val();
        var gender = $('[name=gender]:checked').val();
        var area = $('[name=area]').val();
        var year = $('[name=year]').val();
        var month = $('[name=month]').val();
        var day = $('[name=day]').val();
        var sns = $('[name=sns]').val();
        var profile = $('[name=profile]').val();
        var icon = $('[name=base64]').val();

        var arrayData = {
            'penname': penname,
            'gender': gender,
            'area': area,
            'year': year,
            'month': month,
            'day': day,
            'sns': sns,
            'profile': profile,
            'icon': icon,
            'id': "{{$id}}",
        };
        send_data = JSON.stringify(arrayData);
        // console.log(send_data);
        $.ajax({
            type: "POST",
            url: "/CreatorsGuild/public/api/profEdit",
            contentType: "Content-Type: application/json; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: send_data
        }).done(function(msg, status, xhr) {
            $(".comment").empty();
            $(".comment").append("<p>" + msg + "</p>");
        }).fail(function(xhr, status, error) {
            console.log(msg);
        })
    })

    $(function() {
        $('#icon').on('change', function(e) {
            var file = e.target.files[0];
            var fileReader = new FileReader();
            fileReader.onload = function() {
                var dataUri = this.result;
                $("#base64").val(dataUri);
            }
            fileReader.readAsDataURL(file);
        });
    });
</script>

@endsection