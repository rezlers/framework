<?php

use App\Model\LinkInterface;

session_start();
global $request;
/** @var LinkInterface $linkInstance */
$linkInstance = $_SESSION['linkData'];
$link = $linkInstance->getLink();
$header = $linkInstance->getHeader();
$tag = $linkInstance->getPrivacyTag();
$description = $linkInstance->getDescription();
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
        <h1 class="page-header">Links</h1>
    </div>
    <div class="container">
        <h2>Link description</h2>
    </div>
    <div class="container">
        <ul class="list-group">
            <?php
            echo "<li class='list-group-item'><b>Link</b><br><a href='${link}'>${link}</a></li>";
            echo "<li class='list-group-item'><b>Header</b><br> ${header}</li>";
            echo "<li class='list-group-item'><b>Type</b><br> ${tag}</li>";
            echo "<li class='list-group-item'><b>Description</b><br> ${description}</li>";
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
unset($_SESSION['linkData']);
?>