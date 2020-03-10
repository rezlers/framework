<?php

use App\Model\LinkInterface;
use Kernel\Request\RequestInterface as Request;

/** @var Request $request */
global $request;
$login = $request->getParam('userData')['login'];
$errorMessage = $request->getParam('errorMessage');
$request->setParam('isAuthButtonActive', true);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auth</title>
    <style><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/css/bootstrap.min.css'; ?></style>
</head>

<body>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/HeaderForNotLogged.php';?>
<div class="container">
    <h1 class="page-header">Auth</h1>
</div>
<div class="container">
    <form action="/auth/do" method="get" id="authForm">
        <div class="form-group">
            <label for="exampleInputEmail1">Login</label>
            <input type="text" name="login" class="form-control" id="exampleInputEmail1" placeholder="Login" <?php echo "value='${login}'";?>>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <div class="container">
        <p class="lead text-right"><small class="text-muted">Not <a href="/registration">registred?</a></small></p>
    </div>
</div>
<div class="container">
    <p class="lead"><?php echo $errorMessage;?></p>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'?>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
        crossorigin="anonymous"></script>
<script><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/js/bootstrap.min.js'; ?></script>
<script>
    document.forms['authForm']['']
</script>
</body>

</html>