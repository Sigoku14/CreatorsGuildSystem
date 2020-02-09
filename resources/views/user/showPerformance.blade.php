@extends('template/template')

@section('title', '実績編集')
@section('css', '/css/showPerformance.css')
@include('template/header')

@section('content')
<article id="performance">
    <h2>実績登録</h2>
    <form action="/addPerformance" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="file" name="upload" id="upload">
        </div>
        <div>
            タイトル<br>
            <input type="text" name="title" id="title">
        </div>
        <br>
        <div>
            関連URL<br>
            <input type="url" name="url" id="url">
        </div>
        <br>
        <div>
            詳細<br>
            <textarea name="comment" id="comment"></textarea>
        </div>
        <br>
        <div>
            作成年月<br>
            <select name="madeYear" id="made-year">
                @for ($year = 2020; $year >= 2010; $year--) <option value="{{ $year }}">{{ $year }}年</option> @endfor
            </select>
            <select name="madeMonth" id="made-month">
                @for ($month = 1; $month <= 12; $month++) <option value="{{ $month }}">{{ $month }}月</option> @endfor
            </select>
        </div>
        <input type="hidden" name="id" id="id" value="{{$id}}">
        <input type="submit" name="submit" id="submit" value="送信">
    </form>
</article>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection