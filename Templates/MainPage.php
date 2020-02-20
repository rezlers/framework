<?php

use App\Model\LinkInterface;

$pathToStyles = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/css/bootstrap.min.css';
$pathToJS = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/js/bootstrap.min.js';
/** @var LinkInterface[] $links */
$links = $_SESSION['linkData'];
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
<nav>
    <a href="/main">Main</a>
    <a href="/links">My links</a>
    <a href="/account">Account</a>
</nav>
<h1>Main</h1>
<?php
foreach ($links as $link) {
    echo "<p>Link<br>". $link->getLink() ."</p>";
    echo "<p>Header<br>". $link->getHeader() ."</p>";
    echo "<p>Description<br>". $link->getDescription() ."</p>";
    echo "<p>Author<br>". $link->getUser()->getLogin() ."</p>";
    echo '<br>';
}
?>
<nav>
    <p>Cool sign</p>
</nav>
</body>
</html>
