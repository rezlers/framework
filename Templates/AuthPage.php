<?php
use Kernel\Request\RequestInterface as Request;
/** @var Request $request */
global $request;
session_start();
$login = $_SESSION['login'];
$errorMessage = $_SESSION['errorMessage'];
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
    <form method="get" action="/auth/do">
        <ul>
            <?php
            echo "<li>Login <input type=\"text\" name=\"login\" value=\"${login}\" required></li>";
            echo "<li>Password <input type=\"text\" name=\"password\" required></li>"
            ?>
        </ul>
        <p><?php echo $errorMessage;?></p>
        <input type="submit">
    </form>
    <p>Not <a href="/registration">registered</a>?</p>
</div>
</body>
</html>

