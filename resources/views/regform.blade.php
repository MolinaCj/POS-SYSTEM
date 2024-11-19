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
    <form class="form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <p class="form-title">Create your account</p>
        <div class="input-container">
            <label for="name">Full Name</label>
            <input id="name" type="text" placeholder="Full Name" name="employee_name" autocomplete="name" required>
        </div>
        <div class="input-container">
            <label for="username">Username</label>
            <input id="username" type="text" placeholder="Username" name="username" autocomplete="username" required>
        </div>
        <div class="input-container">
            <label for="email">Email</label>
            <input id="email" type="email" placeholder="Enter email" name="email" autocomplete="email" required>
        </div>
        <div class="input-container">
            <label for="password">Password</label>
            <input id="password" type="password" placeholder="Enter password" name="password" autocomplete="new-password" required>
        </div>
        <div class="input-container">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" placeholder="Confirm password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        <button type="submit" class="submit">Sign up</button>

        <p class="signup-link">
            Already have an account?
            <a href="{{ route('loginForm') }}">Sign in</a>
        </p>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- <script>
    window.onload = function() {
    let notification = document.querySelector('.notification');
    if (notification) {
        setTimeout(function() {
            notification.classList.add('fade-out');
        }, 5000); // 5 seconds before it fades out
    }
} --}}
</script>

</div>
</body>
</html>