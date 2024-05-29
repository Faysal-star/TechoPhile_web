@extends('layouts.user')

@section('title' , 'Report')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/posts/report.css')}}">
@endsection

@section('contents')
<div class="mainReport">
    <h2>Apply For Admin</h2>
    <h3>Write Your Application in short</h3>
    <div class="reportForm">
        <form action="/admin/apply" method="post">
            @csrf
            <textarea class="body" id="msg" name="msg"
            rows="10" cols="50" >
                {{old('msg')}}
            </textarea>
            @error('msg')
                <p class="errText">{{ $message }}</p>
            @enderror
            <br>
            <button>Apply</button>
        </form>
    </div>
</div>


@endsection