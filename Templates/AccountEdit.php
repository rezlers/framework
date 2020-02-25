<?php
use Kernel\Request\RequestInterface as Request;
global $request;
session_start();
$params = $_SESSION['userData'];
$firstName = $params['firstName'];
$lastName = $params['lastName'];
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
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php';?>
<h1>Account</h1>
<h2>Edit profile</h2>
<form method="post" action="/account/edit">
    <ul>
        <?php
        echo "<li>First name <input type=\"text\" name=\"firstName\" value=\"${firstName}\"></li>";
        echo "<li>Last name <input type=\"text\" name=\"lastName\" value=\"${lastName}\"></li>";
        echo "<li>Email <input type=\"email\" name=\"email\" value=\"${email}\"></li>";
        echo "<li>Password <input type=\"password\" name=\"password\"></li>";
        ?>
    </ul>
    <input type="submit" >
</form>
<?php echo "<p>${errorMessage}</p>"; ?>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php';?>
</body>
</html>
<?php
unset($_SESSION['userData']);
unset($_SESSION['errorMessage']);
?>