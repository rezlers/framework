<?php

use App\Model\LinkInterface;
use Kernel\Request\RequestInterface;

/** @var RequestInterface $request */
global $request;

$pathToStyles = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/css/bootstrap.min.css';
$pathToJS = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Public/bootstrap/js/bootstrap.min.js';
/** @var LinkInterface[] $links */
$links = $request->getParam('linkData');
$pages = $request->getParam('pagerData');
if ($_SESSION['authentication'])
    $header = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php';
else
    $header = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/HeaderForNotLogged.php';
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Main</title>
        <style><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/css/bootstrap.min.css'; ?></style>
    </head>
    <body>
    <?php include $header; ?>
    <div class="container">
        <h1 class="page-header">Main</h1>
    </div>
    <?php
    foreach ($links as $link) {
        echo '<div class="container" style="padding: 10px;">';
        echo "<h4 class='list-group-item-heading'><b>" . $link->getHeader() . "</b></h4>";
        echo "<p class='lead'><a href='/links/description/" . $link->getId() . "'>" . $link->getLink() . "</a></p>";
        echo "<footer><p class='text-muted'>" . $link->getUser()->getLogin() . "</p></footer>";
        echo '</div>';
    }
    ?>
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                if (isset($pages['previous']))
                    echo "<li class='page-item'><a class='page-link' href='/main?page=${pages['previous']}'>Previous</a></li>";
                foreach ($pages as $key => $page) {
                    if (is_numeric($key))
                        echo "<li class='page-item'><a class='page-link' href='/main?page=${page}'>${page}</a></li>";
                }
                if (isset($pages['next']))
                    echo "<li class='page-item'><a class='page-link' href='/main?page=${pages['next']}'>Next</a></li>";
                ?>
            </ul>
        </nav>
    </div>
    <?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'; ?>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
            crossorigin="anonymous"></script>
    <script><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/js/bootstrap.min.js'; ?></script>
    </body>
    </html>