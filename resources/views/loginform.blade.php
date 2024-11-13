<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/loginform.css">
    <title>Document</title>
</head>
<body>
<div class="container">
  <form class="form" method="POST" action="{{route('login')}}">
    {{ csrf_field() }}
    <p class="form-title">Sign in to your account</p>
        <div class="input-container">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" placeholder="Enter username" autocomplete="username">
          @if ($errors->has('username'))
        <span class="error">{{ $errors->first('username') }}</span>
      @endif
      </div>
      <div class="input-container">
        <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="Enter password" autocomplete="current-password">
          @if ($errors->has('password'))
        <span class="error">{{ $errors->first('password') }}</span>
      @endif
        </div>
         <button type="submit" class="submit">
        Sign in
      </button>

      <p class="signup-link">
        No account?
        <a href="{{route('regForm')}}">Sign up</a>
      </p>
  </form>
</div>
<script>
  window.onload = function() {
    let notification = document.querySelector('.notification');
    if (notification) {
        setTimeout(function() {
            notification.classList.add('fade-out');
        }, 5000); // 5 seconds before it fades out
    }
}
</script>
</body>
</html>