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
        <h1>Welcome back to <br> <span class='color'>TechoPhile</span></h1>
        
        <div class="form">
            <form action="{{ route('login.action') }}" method="post">
                @csrf
        
                <label for="email">Email</label>
                <br>
                <input type="text" name="email" id="email" value="{{old('email')}}" placeholder="Enter email">
                @error('email')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
                <br>

                <label for="password">Password</label>
                <br>
                <input type="password" name="password" id="password" placeholder="Enter password">
                @error('password')
                    <p class="errTxt">{{ $message }}</p>
                @enderror
            
                <br>
                <div class="submitBlock">
                    <button type="submit" class="submitBtn">
                        Sign in
                    </button>
                </div>
                <br>
                <div class="alreadyBlock">
                    <p>
                        Don't have an account?
                        <a href="/register" class="loginLink">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

  
</body>
</html>