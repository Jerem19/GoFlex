<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="<?= $l10n["header"]["nav-text"] ?>"></div>
    </div>

    <a href="<?= BASE_URL ?>" class="logo"><b>GOFLEX</b></a>

    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li>
                <?php include __DIR__ . '/../sltLang.php'; ?>
            </li>
            <li><a class="logout" href="<?= BASE_URL ?>logout"><span class="fa fa-sign-out"></span></a></li>
        </ul>
    </div>
</header>
