<header class="header black-bg">


    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="<?= $l10n["header"]["nav-text"] ?>"></div>
    </div>

    <a href="<?= BASE_URL ?>" class="logo">
        <b>
            <img src="<?= BASE_URL ?>goflex-logo.png" style="width: 120px;"/>
            <img src="<?= BASE_URL ?>eu.png" style="height: 30px; margin-right:5px;"/>
            <img src="<?= BASE_URL ?>ch.png" style="height: 30px;"/>
        </b>
    </a>

    <div class="top-menu">
        <ul class="nav pull-right top-menu">
            <li><a class="logout" href="<?= BASE_URL ?>logout"><span class="fa fa-sign-out"></span></a></li>
        </ul>
    </div>
</header>