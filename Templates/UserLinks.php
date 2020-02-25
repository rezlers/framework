<?php
use App\Model\LinkInterface;
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
<h1>My links</h1>
<a href="/links/create">Create link</a>
<?php
foreach ($links as $link) {
    echo '<div>';
    echo "<p><b>Header</b><br>". $link->getHeader() ."</p>";
    echo "<p><b>Link</b><br><a href='/links/description/". $link->getId() ."'>". $link->getLink() ."</a></p>";
    echo "<p><b>Type</b><br>". $link->getPrivacyTag() ."</p>";
    echo "<p><a href='/links/edit/". $link->getId() ."'>edit</a></p>";
    echo '<br>';
    echo '</div>';
}
?>
<?php echo $pages;?>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php';?>
</body>
</html>
