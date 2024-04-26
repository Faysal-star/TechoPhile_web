@extends('layouts.user')

@section('title' , 'Report')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/posts/report.css')}}">
@endsection

@section('contents')
<div class="mainReport">
    <h2>Report This Post By : {{$post->user->name}}</h2>
    <h3>Title : {{$post->title}}</h3>
    <div class="reportForm">
        <form action="/report/{{$post->id}}" method="post">
            @csrf
            <textarea class="body" id="reportBody" name="reportBody"
            rows="10" cols="50" >
                {{old('reportBody')}}
            </textarea>
            @error('reportBody')
                <p class="errText">{{ $message }}</p>
            @enderror
            <br>
            <button>Report</button>
        </form>
    </div>
</div>


@endsection