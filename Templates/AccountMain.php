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
$request->setParam('isAccountButtonActive', true);
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/css/bootstrap.min.css'; ?></style>
        <title>Account</title>
    </head>
    <body>
    <?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'; ?>
    <h1 class="page-header">Account</h1>
    <nav class="navbar">
        <ul class="nav navbar-nav">
            <li><a class="lead" href="/account/edit">Edit profile</a></li>
        </ul>
    </nav>
    <div class="container pull-left">
        <ul class="list-group">
            <?php
            echo "<li class='list-group-item'>First name: ${firstName}</li>";
            echo "<li class='list-group-item'>Last name: ${lastName}</li>";
            echo "<li class='list-group-item'>Email: ${email}</li>";
            echo "<li class='list-group-item'>Login: ${login}</li>";
            ?>
        </ul>
    </div>
    <?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'; ?>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
            crossorigin="anonymous"></script>
    <script><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/js/bootstrap.min.js'; ?></script>
    </body>
    </html>
<?php
unset($_SESSION['userData']);
unset($_SESSION['errorMessage']);
?>