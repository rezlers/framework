<?php
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <h1>Welcome to App</h1>
    <h2>Login in system</h2>
    <form method="get" action="/AuthenticationController">
        <ul>
            <li><input type="text" value="login" required></li>
            <li><input type="text" value="password" required></li>
        </ul>
        <input type="submit">
    </form>
    <p>Not <a href="/registration">registered</a>?</p>
</div>
</body>
</html>
