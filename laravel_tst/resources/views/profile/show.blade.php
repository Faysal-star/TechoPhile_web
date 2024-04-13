<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/profile/show.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <title>Profile</title>
</head>
<body>
    <div class="main">
        <div class="upperPart">
            <div class="cover">
                <img src="{{asset('images/cover.jpg')}}" alt="cover">
            </div>
            <div class="profile">
                <img src="{{asset('images/profile.jpg')}}" alt="profile">
                <div class="details">
                    <p class="name">{{$profile->name}}</p>
                    <p class="email">{{$profile->email}}</p>
                    <div class="follow">
                        <p class="followers">{{$followers}} followers</p>
                        <p class="following">{{$followings}} following</p>
                    </div>
                </div>
                <div class="edit">
                    @if(auth()->user()->id == $profile->user_id)
                        <a href="/profile/edit/{{$profile->id}}"><button class="editBtn">
                            <i class="fas fa-user-edit"></i>
                            Edit Profile
                        </button></a>
                    @elseif(auth()->user()->profile->isFollowing($profile))
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
                        <a href="/" class="#e74c3c#e74c3c">
                            <i class="fab fa-github"></i>
                            @if ($profile->github)
                                {{$profile->github}}
                            @else
                                username
                            @endif
                        </a>
                    </div>
                    <div class="twitter infoP">
                        <a href="/" class="twitterP">
                            <i class="fab fa-twitter"></i>
                            @if ($profile->twitter)
                                {{$profile->twitter}}
                            @else
                                username    
                            @endif 
                        </a>
                    </div>
                    <div class="linkedin infoP">
                        <a href="/" class="linkedinP">
                            <i class="fab fa-linkedin"></i>
                            @if ($profile->linkedin)
                                {{$profile->linkedin}}
                            @else
                                username
                            @endif
                        </a>
                    </div>
                    <div class="facebook infoP">
                        <a href="/" class="facebookP">
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
                <div class="post">
                    <div class="postHeader">
                        <div class="proPic">
                            <img src="{{asset('images/profile.jpg')}}" alt="profile">
                        </div>
                        <div class="otherDetails">
                            <p class="nameP">John Doe</p>
                            <p class="time">2 hours ago</p>
                        </div>
                    </div>
                    <div class="postContent">
                        <a href="/" class="postTitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, reiciendis.</a>
                    </div>
                    <div class="postFooter">
                        <div class="tags">
                            <a href="/" class="tag">tag1</a>
                            <a href="/" class="tag">tag2</a>
                            <a href="/" class="tag">tag3</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>