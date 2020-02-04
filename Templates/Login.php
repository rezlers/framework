<?php
    use Kernel\Request as Request;
?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8" />
    <title>HTML Document</title>
</head>
<body>
<p>
    <b>
        Этот текст будет полужирным, <i>а этот — ещё и курсивным</i>.
        <?php
            echo $request->getParam('key');
        ?>
    </b>
</p>
</body>
</html>
