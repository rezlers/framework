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
    <title>Document</title>
</head>
<body>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'; ?>
<h1>Links</h1>
<h2>Link description</h2>
<div>
    <ul>
        <?php
        echo "<p>Link <br><a href='${link}'>${link}</a></p>";
        echo "<p>Header <br>${header}</p>";
        echo "<p>Type <br>${tag}</p>";
        echo "<p>Description <br>${description}</p>";
        ?>
    </ul>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'; ?>
</body>
</html>
<?php
unset($_SESSION['linkData']);
?>