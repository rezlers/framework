<?php

use App\Model\LinkInterface;

global $request;
/** @var LinkInterface $linkInstance */
$linkInstance = $request->getParam('linkData');
$link = $linkInstance->getLink();
$schemeInd = '';
if (is_null(parse_url($link, PHP_URL_SCHEME)))
    $schemeInd = 'http://';
$header = $linkInstance->getHeader();
$tag = $linkInstance->getPrivacyTag();
$description = $linkInstance->getDescription();
if ($_SESSION['authentication'])
    $htmlHeader = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php';
else
    $htmlHeader = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/HeaderForNotLogged.php';
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
    <?php include $htmlHeader; ?>
    <div class="container">
        <h1 class="page-header">Links</h1>
    </div>
    <div class="container">
        <h2>Link description</h2>
    </div>
    <div class="container">
        <ul class="list-group">
            <?php
            echo "<li class='list-group-item'><b>Link</b><br><a href='${schemeInd}${link}'>${link}</a></li>";
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