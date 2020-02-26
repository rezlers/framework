<?php
global $request;
if ($request->getParam('isLinksButtonActive'))
    $linksButton = 'class="active"';
if ($request->getParam('isAccountButtonActive'))
    $accountButton = 'class="active"';
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/main">App</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li <?php echo $linksButton;?>><a href="/links">My links</a></li>
                <li <?php echo $accountButton;?>><a href="/account">Account</a></li>
                <li><a href="/auth/logout">Log out</a></li>
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav>