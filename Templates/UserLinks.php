<?php

use App\Model\LinkInterface;

/** @var LinkInterface[] $links */
$links = $_SESSION['linkData'];
$pages = $_SESSION['pagerData'];
$request->setParam('isLinksButtonActive', true);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style><?php include_once '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/bootstrap/css/bootstrap.min.css'; ?></style>
    <title>Links</title>
</head>
<body>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Header.php'; ?>
<h1 class="page-header">My links</h1>
<nav class="navbar">
    <ul class="nav navbar-nav">
    <li><a class="lead" href="/links/create">Create link</a></li>
    </ul>
</nav>
<?php
foreach ($links as $link) {
    echo '<div class="container pull-left" style="padding: 10px;">';
    echo "<h4 class='list-group-item-heading'><b>" . $link->getHeader() . "</b></h4>";
    echo "<p class='lead'><a href='/links/description/" . $link->getId() . "'>" . $link->getLink() . "</a></p>";
    echo "<p class='text-muted'><b>Type</b><br>" . $link->getPrivacyTag() . "</p>";
    echo '<nav class="navbar"><ul class="nav navbar-nav">';
    echo "<li><a href='/links/edit/" . $link->getId() . "'>Edit</a></li>";
    echo "<li><a href='#'>Delete</a></li>";
    echo '</ul></nav>';
    echo '<br>';
    echo '</div>';
}
?>
<div class="container pull-left">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            if (isset($pages['previous']))
                echo "<li class='page-item'><a class='page-link' href='/links?page=${pages['previous']}'>Previous</a></li>";
            foreach ($pages as $key => $page) {
                if (is_numeric($key))
                    echo "<li class='page-item'><a class='page-link' href='/links?page=${page}'>${page}</a></li>";
            }
            if (isset($pages['next']))
                echo "<li class='page-item'><a class='page-link' href='/links?page=${pages['next']}'>Next</a></li>";
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
<?php
unset($_SESSION['linkData']);
unset($_SESSION['pagerData']);
?>
