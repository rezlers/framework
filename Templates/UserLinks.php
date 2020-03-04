<?php

use App\Model\LinkInterface;

/** @var LinkInterface[] $links */
$links = $request->getParam('linkData');
$pages = $request->getParam('pagerData');
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
<div class="container">
    <h1 class="page-header">My links</h1>
</div>
<div class="container">
    <nav class="navbar">
        <ul class="nav navbar-nav">
            <li><a class="lead" href="/links/create">Create link</a></li>
        </ul>
    </nav>
</div>
<?php
foreach ($links as $link) {
    echo '<div class="container" style="padding: 10px;">';
    echo "<h4 class='list-group-item-heading'><b>" . $link->getHeader() . "</b></h4>";
    echo "<p class='lead'><a href='/links/description/" . $link->getId() . "'>" . $link->getLink() . "</a></p>";
    echo "<p class='text-muted'><b>Type</b><br>" . $link->getPrivacyTag() . "</p>";
    echo '<nav class="navbar"><ul class="nav navbar-nav">';
    echo "<li><a href='/links/edit/" . $link->getId() . "'>Edit</a></li>";
    $id = $link->getId();
    echo "<li><a href='#' class='forPass' data-action='/links/delete/${id}' data-toggle=\"modal\" data-target=\"#exampleModal\">Delete</a></li>";
    echo '</ul></nav>';
    echo '<br>';
    echo '</div>';
}
?>
<div class="container">
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="lead"> Are you sure you want delete it? </p>
            </div>
            <div class="modal-footer">
                <form id='deleteButton' method="post" action="">
                    <button type="button" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Templates/Blocks/Footer.php'; ?>
<script>
    $(document).on("click", ".forPass", function () {
        let id = $(this).data('action');
        $(".modal-footer #deleteButton").attr('action', id);
        // As pointed out in comments,
        // it is superfluous to have to manually call the modal.
        // $('#addBookDialog').modal('show');
    });
</script>
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
