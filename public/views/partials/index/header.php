<header class="header black-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="<?= $l10n["header"]["nav-text"] ?>"></div>
    </div>

    <a href="" class="logo"><b>GOFLEX</b></a>

    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li>
                <?php include __DIR__ . '/../sltLang.php'; ?>
            </li>
            <li><a class="logout" href="<?= BASE_URL ?>logout"><?= $l10n["header"]["logout"] ?></a></li>
        </ul>
    </div>
</header>
