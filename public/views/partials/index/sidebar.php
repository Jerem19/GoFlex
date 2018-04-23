<?php $l10nNav = $l10n["sidebar"]; ?>
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile"><img src="userIco.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?= $params["User"] ?></h5>

            <?php
            function doLink ($text, $attr, $isActive = false) {
                if (!isset($attr["_iClass"])) $attr["_iClass"] = ""; ?>
                <li <?= $isActive ? 'class="active"': '' ?>>
                    <a href="<?= $attr["href"] ?>">
                        <i class="<?= $attr["_iClass"] ?>"></i><span><?= $text ?></span>
                    </a>
                </li> <?php
            }

            function doSubMenu($text, $menu, $isActive = false) {
                if (!isset($menu["_iClass"])) $menu["_iClass"] = ""; ?>
                <li class="sub-menu">
                    <a href="javascript:;" <?= $isActive ? 'class="active"': '' ?>>
                        <i class="<?= $menu["_iClass"] ?>"></i><?php unset($menu["_iClass"]); ?>
                        <span><?= $text ?></span>
                    </a>
                    <ul class="sub">
                        <?php doMenu($menu); ?>
                    </ul>
                </li> <?php
            }

            global $path;
            $path = isset($params["path"]) ? $params["path"] : "/GoFlex";
            function doMenu($menu = []) {
                global $path;
                foreach ($menu as $text => $attr) {
                    if (array_key_exists('href', $attr))
                        doLink($text, $attr, $path == $attr["href"]);
                    else {
                        $active = false;
                        foreach ($attr as $item)
                            if (isset($item["href"]) && $item["href"] == $path) {
                                $active = true;
                                break;
                            }
                        doSubMenu($text, $attr, $active);
                    }
                }
            }


            doMenu([
                $l10nNav["dashboard"] => [
                    "href" => "/GoFlex",
                    "_iClass" => "fa fa-dashboard"
                ],
                $l10nNav["administration"] => [
                    "_iClass" => "fa fa-book",
                    $l10nNav["user"] => [
                        "href" => "user"
                    ],
                    $l10nNav["profil"] => [
                        "href" => "profile"
                    ]
                ]
            ]); ?>
        </ul>
    </div>
</aside>