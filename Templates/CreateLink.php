<?php
use Kernel\Request\RequestInterface as Request;
global $request;
session_start();
$params = $_SESSION['linkData'];
$link = $params['link'];
$header = $params['header'];
$description = $params['description'];
$tag = $params['tag'];
$errorMessage = $_SESSION['errorMessage'];
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
<h1>Account</h1>
<h2>Create link</h2>
<form method="post" action="/links/create">
    <ul>
        <?php
        echo "<li>Link <br><input type=\"text\" name=\"link\" value=\"${link}\" required></li>";
        echo "<li>Header <br><input type=\"text\" name=\"header\" value=\"${header}\" required></li>";
        echo "<li>Type <br><input type=\"text\" name=\"tag\" value='${tag}' required></li>";
        echo "<li>Description <br><textarea name=\"description\" required>${description}</textarea></li>";
        ?>
    </ul>
    <input type="submit" >
    <?php echo '<p>' . $errorMessage . '</p>';?>
</form>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php';?>

</body>
</html>
