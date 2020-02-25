<?php

use App\Model\LinkInterface;

$pathToStyles = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/css/bootstrap.min.css';
$pathToJS = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/js/bootstrap.min.js';
/** @var LinkInterface[] $links */
$links = $_SESSION['linkData'];
$pages = implode(' ', $_SESSION['pagerData']);
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
<h1>Main</h1>
<?php
foreach ($links as $link) {
    echo '<div>';
    echo "<p><b>Header</b><br>". $link->getHeader() ."</p>";
    echo "<p><b>Link</b><br><a href='/links/description/". $link->getId() ."'>". $link->getLink() ."</a></p>";
    echo "<p><b>Author</b><br>". $link->getUser()->getLogin() ."</p>";
    echo '<br>';
    echo '</div>';
}
?>
<?php echo $pages;?>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php';?>
</body>
</html>
