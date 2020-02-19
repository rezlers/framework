<?php
    use Kernel\Request\RequestInterface as Request;
    global $request;
    session_start();
    $params = $_SESSION['userData'];
    $firstName = $params['firstName'];
    $lastName = $params['lastName'];
    $login = $params['login'];
    $email = $params['email'];
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
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'?>
<h1>Registration</h1>
<div>
    <form method="post" action="/registration/do">
        <ul>
            <?php
            echo "<li>First name <input type=\"text\" name=\"firstName\" value=\"${firstName}\" required></li>";
            echo "<li>Last name <input type=\"text\" name=\"lastName\" value=\"${lastName}\" required></li>";
            echo "<li>Email <input type=\"email\" name=\"email\" value=\"${email}\" required></li>";
            echo "<li>Login <input type=\"text\" name=\"login\" value=\"${login}\" required></li>";
            echo "<li>Password <input type=\"password\" name=\"password\" required></li>";
            ?>
        </ul>
        <input type="submit" >
        Go back to <a href="auth">main page</a>
    </form>
    <p><?php echo $errorMessage;?></p>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'?>
</body>
</html>