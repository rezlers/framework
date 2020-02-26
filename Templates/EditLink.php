<?php
session_start();
global $request;
$linkInstance = $_SESSION['linkData'];
$link = $linkInstance->getLink();
$header = $linkInstance->getHeader();
$tag = $linkInstance->getPrivacyTag();
$description = $linkInstance->getDescription();
$errorMessage = $_SESSION['errorMessage'];
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
        <h1 class="page-header">Edit link</h1>
    </div>
    <div class="container">
        <form action="/links/edit/<?php echo $request->getUrlParams()['id']; ?>" method="post">
            <div class="form-group">
                <label for="exampleInputPassword1">Link </label>
                <input type="text" name="link" class="form-control" id="exampleInputPassword1"
                       placeholder="Link" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Header </label>
                <input type="password" name="header" class="form-control" id="exampleInputPassword1"
                       placeholder="Header" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Type</label>
                <input type="text" name="tag" class="form-control" id="exampleInputEmail1" placeholder="Type" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <input type="text" name="description" class="form-control" id="exampleInputPassword1"
                       placeholder="Description" required>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
    <div class="container">
        <?php echo '<p class="lead">' . $errorMessage . '</p>'; ?>
    </div>
    <?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'; ?>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
            crossorigin="anonymous"></script>
    <script><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/js/bootstrap.min.js'; ?></script>
    </body>
    </html>
<?php
unset($_SESSION['linkData']);
unset($_SESSION['errorMessage']);
?>