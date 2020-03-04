<?php
use Kernel\Request\RequestInterface as Request;

global $request;
$params = $request->getParam('linkData');
$link = $params['link'];
$header = $params['header'];
$description = $params['description'];
$tag = $params['tag'];
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
        <h1 class="page-header">Edit link</h1>
    </div>
    <div class="container">
        <form action="/links/edit/<?php echo $request->getUrlParams()['id']; ?>" method="post">
            <div class="form-group">
                <label for="exampleInputPassword1">Link </label>
                <input type="text" name="link" class="form-control" id="exampleInputPassword1"
                       placeholder="Link" <?php echo "value='${link}'";?> required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Title </label>
                <input type="text" name="header" class="form-control" id="exampleInputPassword1"
                       placeholder="Title" <?php echo "value='${header}'";?> required>
            </div>
            <div class="form-group">
                <label for="tag">Type</label>
                <select class="form-control" id="tag" name="tag">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <textarea class="md-textarea form-control" rows="3" id="exampleInputPassword1" name="description"><?php echo "${description}";?> </textarea>
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

?>