<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/regform.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <form class="form" method="POST" action="{{ route('regform') }}">
        {{ csrf_field() }}
        <p class="form-title">Create your account</p>
        <div class="input-container">
            <input type="text" placeholder="Full Name" name="name" required>
        </div>
        <div class="input-container">
            <input type="email" placeholder="Enter email" name="email" required>
        </div>
        <div class="input-container">
            <input type="password" placeholder="Enter password" name="password" required>
        </div>
        <div class="input-container">
            <input type="password" placeholder="Confirm password" name="password_confirmation" required>
        </div>
        <button type="submit" class="submit">Sign up</button>

        <p class="signup-link">
            Already have an account?
            <a href="{{ route('loginform') }}">Sign in</a>
        </p>
    </form>
</div>
</body>
</html>