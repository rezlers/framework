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
            <li>First name <input type="text" name="firstName" required></li>
            <li>Last name <input type="text" name="lastName" required></li>
            <li>Email <input type="email" name="email" required></li>
            <li>Login <input type="text" name="login" required></li>
            <li>Password <input type="password" name="password" required></li>
        </ul>
        <input type="submit" >
        Go back to <a href="main">main page</a>
    </form>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'?>
</body>
</html>
