<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{asset("css/register.css")}}">
</head>
<body class="">
    <div class="main">
        <h1>Welcome to <br> <span class='color'>TechoPhile</span></h1>
        
        <div class="form">
            <form action="/" method="post">
                @csrf
            
                <label for="name">Name</label>
                <br>
                <input type="text" name="name" id="name" value="{{old('name')}}" placeholder="Enter Name">
                @error('name')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
                <br>
                <label for="email">Email</label>
                <br>
                <input type="text" name="email" id="email" value="{{old('email')}}" placeholder="Enter email">
                @error('email')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
                <br>
                <label for="password">Password</label>
                <br>
                <input type="text" name="password" id="password" placeholder="Enter password">
                @error('password')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
                <br>
                <label for="password2">Confirm Password</label>
                <br>
                <input type="text" name="password_confirmation" id="password2" placeholder="Enter password">
                @error('password_confirmation')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
                <br>
                <div class="submitBlock">
                    <button type="submit" class="submitBtn">
                        Sign Up
                    </button>
                </div>
                <br>
                <div class="alreadyBlock">
                    <p>
                        Already have an account?
                        <a href="/login" class="loginLink">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

  
</body>
</html>