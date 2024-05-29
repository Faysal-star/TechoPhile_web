@extends('layouts.user')

@section('title' , 'Profile')

@section('CustomCss')
    <link rel="stylesheet" href="{{asset('css/profile/show.css')}}">
@endsection

@section('contents')
<div class="main">
    <div class="upperPart">
        <div class="cover">
            {{-- <img src="{{asset('images/cover.jpg')}}" alt="cover"> --}}
            <img src={{ $profile->cover ? asset('storage/'.$profile->cover) : asset('images/cover.jpg') }} alt="cover">
        </div>
        <div class="profile">
            {{-- <img src="{{asset('images/profile.jpg')}}" alt="profile"> --}}
            <img src={{ $profile->avatar ? asset('storage/'.$profile->avatar) : asset('images/profile.jpg') }} alt="profile">
            <div class="details">
                <p class="name">{{$profile->name}}</p>
                <p class="email">{{$profile->email}}</p>
                <div class="follow">
                    <p class="followers">{{$followers}} followers</p>
                    <p class="following">{{$followings}} following</p>
                </div>
            </div>
            <div class="edit">
                @if($authUser->id == $profile->user_id)
                    @if($authUser->type == 'admin' || $authUser->type == 'superAdmin')
                        <a href="/admin"><button class="editBtn">
                            <i class="fa-solid fa-user-tie"></i>
                            Admin Panel
                        </button></a>
                    @else
                        <a href='/admin/apply'><button class="editBtn">
                            <i class="fa-solid fa-user-tie"></i>
                            Job
                        </button></a>
                    @endif
                    <a href="/profile/{{$profile->id}}/edit"><button class="editBtn">
                        <i class="fas fa-user-edit"></i>
                        Edit Profile
                    </button></a>
                    <a href="/logout">
                    <button class="editBtn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                    </a>
                @elseif($authUser->profile->isFollowing($profile))
                    <form method="POST" action="{{ route('profile.unfollow', $profile) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="editBtn">
                            <i class="fas fa-user-minus"></i>
                            Unfollow
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('profile.follow', $profile) }}">
                        @csrf
                        <button type="submit" class="editBtn">
                            <i class="fas fa-user-plus"></i>
                            Follow
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="lowerPart">
        <div class="left">
            <div class="bio">
                <p class="bioP">
                    @if($profile->bio)
                        {{$profile->bio}}
                    @else
                        Add a bio
                    @endif
                </p>
                <div class="line"></div>
            </div>
            <div class="info">
                <!-- phone,address,city,github,twitter,linkedin,facebook -->
                <div class="phone infoP">
                    <p class="phoneP">
                        <i class="fas fa-phone-alt"></i>
                        @if ($profile->phone)
                            {{$profile->phone}}
                        @else
                            Add phone number
                        @endif
                    </p>
                </div>
                <div class="address infoP">
                    <p class="addressP">
                        <i class="fas fa-map-marker-alt"></i>
                        @if ($profile->address)
                            {{$profile->address}}
                        @else
                            Add address
                        @endif
                    </p>
                </div>
                <div class="city infoP">
                    <p class="cityP">
                        <i class="fas fa-city"></i>
                        @if ($profile->city)
                            {{$profile->city}}
                        @else
                            Add city
                        @endif
                    </p>
                </div>
                <div class="github infoP">
                    <a href="{{$profile->github_link ? '//'.$profile->github_link : '#' }}" target="_blank" class="github">
                        <i class="fab fa-github"></i>
                        @if ($profile->github)
                            {{$profile->github}}
                        @else
                            username
                        @endif
                    </a>
                </div>
                <div class="twitter infoP">
                    <a href="{{$profile->twitter_link ? '//'.$profile->twitter_link : '#' }}" class="twitterP">
                        <i class="fab fa-twitter"></i>
                        @if ($profile->twitter)
                            {{$profile->twitter}}
                        @else
                            username    
                        @endif 
                    </a>
                </div>
                <div class="linkedin infoP">
                    <a href="{{$profile->linkedin_link ? '//'.$profile->linkedin_link : '#' }}" class="linkedinP">
                        <i class="fab fa-linkedin"></i>
                        @if ($profile->linkedin)
                            {{$profile->linkedin}}
                        @else
                            username
                        @endif
                    </a>
                </div>
                <div class="facebook infoP">
                    <a href="{{$profile->facebook_link ? '//'.$profile->facebook_link : '#' }}" class="facebookP">
                        <i class="fab fa-facebook"></i>
                        @if ($profile->facebook)
                            {{$profile->facebook}}
                        @else
                            username
                        @endif 
                    </a>
                </div>
            </div>
        </div>

        <div class="right">
            @unless (count($posts) == 0)
            @foreach ($posts as $post)
                {{-- <h2>Post</h2> --}}
                <x-post-component :post="$post" />
            @endforeach
            
            @else
                <p>No Posts yet</p>
            @endunless
        </div>
    </div>
</div>




@endsection
