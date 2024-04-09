@props(['tagsCsv'])

@php
    $tags = explode(',' , $tagsCsv)
@endphp

<ul class="postTags">
    @foreach ($tags as $tag)
        <li>
            <a href="/home/?tags={{$tag}}">{{$tag}}</a>
        </li>
    @endforeach
</ul>