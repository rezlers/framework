<?php

use Kernel\Request\RequestInterface as Request;

global $request;
$params = $request->getParam('userData');
$firstName = $params['firstName'];
$lastName = $params['lastName'];
$email = $params['email'];
$errorMessage = $request->getParam('errorMessage');
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/css/bootstrap.min.css'; ?></style>
        <title>Document</title>
    </head>
    <body>
    <?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'; ?>
    <div class="container">
        <h1 class="page-header">Account</h1>
    </div>
    <div class="container">
        <h2>Edit profile</h2>
    </div>
    <div class="container">
        <form action="/account/edit" method="post">
            <div class="form-group">
                <label for="exampleInputPassword1">First name</label>
                <input type="text" name="firstName" class="form-control" id="exampleInputPassword1"
                       placeholder="First name"  <?php echo "value='${firstName}'";?>>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Last Name</label>
                <input type="text" name="lastName" class="form-control" id="exampleInputPassword1"
                       placeholder="Last name"  <?php echo "value='${lastName}'";?>>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email"  <?php echo "value='${email}'";?>>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                       placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Repeat password</label>
                <input type="password" name="repeatedPassword" class="form-control" id="exampleInputPassword1"
                       placeholder="Repeat password">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
    <div class="container">
        <?php echo "<p class='lead'>${errorMessage}</p>"; ?>
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