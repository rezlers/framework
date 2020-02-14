<?php
    use Kernel\Request\RequestInterface as Request;
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
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'?>
<h1>Registration</h1>
<div>
    <form method="post" action="/RegistrationController">
        <ul>
            <li><input type="text" value="firstName" required></li>
            <li><input type="text" value="lastName" required></li>
            <li><input type="email" value="email" required></li>
            <li><input type="text" value="login" required></li>
            <li><input type="password" value="password" required></li>
        </ul>
        <input type="submit" >
        Go back to <a href="main">main page</a>
    </form>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'?>
</body>
</html>
