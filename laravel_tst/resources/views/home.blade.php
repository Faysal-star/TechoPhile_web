@extends('layouts.user')

@section('title' , 'Home')

@section('contents')

@unless (count($posts) == 0)
    @foreach ($posts as $post)
        {{-- <h2>Post</h2> --}}
        <x-post-component :post="$post" />
    @endforeach
    
@else
    <p>No Posts</p>
@endunless

@endsection