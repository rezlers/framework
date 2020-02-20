<?php
use Kernel\Request\RequestInterface as Request;
global $request;
session_start();
$params = $_SESSION['userData'];
$firstName = $params['firstName'];
$lastName = $params['lastName'];
$email = $params['email'];
$login = $params['login'];
$errorMessage = $_SESSION['errorMessage'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account</title>
</head>
<body>
<nav>
    <a href="/main">Main</a>
    <a href="/links">My links</a>
    <a href="/account">Account</a>
</nav>
<h1>Account</h1>
<a href="/account/edit">Edit profile</a>
<a href="/account/create">Create link</a>
<ul>
    <?php
    echo "<li>First name: ${firstName}</li>";
    echo "<li>Last name: ${lastName}</li>";
    echo "<li>Email: ${email}</li>";
    echo "<li>Login: ${login}</li>";
    ?>
</ul>
<nav>
    <p>Cool sign</p>
</nav>
</body>
</html>
