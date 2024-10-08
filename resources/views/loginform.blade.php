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
  <form class="form" method="POST" action="{{route('loginform')}}">
    {{ csrf_field() }}
    <p class="form-title">Sign in to your account</p>
        <div class="input-container">
          <input type="email" placeholder="Enter email">
          <span>
          </span>
      </div>
      <div class="input-container">
          <input type="password" placeholder="Enter password">
        </div>
         <button type="submit" class="submit">
        Sign in
      </button>

      <p class="signup-link">
        No account?
        <a href="{{route('regform')}}">Sign up</a>
      </p>
  </form>
</div>
</body>
</html>