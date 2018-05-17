<?php $l10nNav = $l10n["sidebar"]; ?>
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="<?= BASE_URL ?>profile"><img src="<?= BASE_URL ?>userIco.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?= $user ?></h5>

            <?php
            function doLink ($href, $attr, $isActive = false) {
                if (!isset($attr["_iClass"])) $attr["_iClass"] = ""; ?>
                <li <?= $isActive ? 'class="active"': '' ?>>
                    <a href="<?= BASE_URL . $href ?>" >
                        <i class="<?= $attr["_iClass"] ?>"></i><span><?= $attr["text"] ?></span>
                    </a>
                </li> <?php
            }

            function doSubMenu($menu, $isActive = false) {
                if (!isset($menu["_iClass"])) $menu["_iClass"] = ""; ?>
                <li class="sub-menu">
                    <a href="javascript:;" <?= $isActive ? 'class="active"': '' ?> >
                        <i class="<?= $menu["_iClass"] ?>"></i>
                        <span><?= $menu["text"] ?></span>
                    </a>
                    <ul class="sub">
                        <?php doMenu($menu); ?>
                    </ul>
                </li> <?php
            }

            $pathMenu = isset($path) ? $path : BASE_URL;
            function doMenu($menu = []) {
                global $pathMenu;
                foreach ($menu as $href => $attr) {
                    if (is_array($attr)) {
                        $isSubMenu = false;
                        $isActive = false;
                        foreach ($attr as $k => $item) {
                            if (is_array($item)) {
                                $isSubMenu = true;
                                if ($k == $pathMenu) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        }
                        if ($isSubMenu)
                            doSubMenu($attr, $isActive);
                        else
                            doLink($href, $attr, $href == $pathMenu);
                    }
                }
            }



            $menu["dashboard"] = [
                "text" => $l10nNav["dashboard"],
                "_iClass" => "fa fa-dashboard"
            ];


            if ($user->getRole()->getId() == 1) {
                $menu["creationUser"] = [
                    "text" => $l10nNav["creationUser"],
                    "_iClass" => "fa fa-user-plus"
                ];

                $menu["creationSpecialUser"] = [
                    "text" => $l10nNav["creationSpecialUser"],
                    "_iClass" => "fa fa-user-plus"
                ];
            }

            if ($user->getRole()->getId() == 2) {
                $menu["installationGateway"] = [
                    "text" => $l10nNav["installationGateway"],
                    "_iClass" => "fa fa-wrench"
                ];

                $menu["checkUserData"] = [
                    "text" => $l10nNav["checkUserData"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];
            }

            if ($user->getRole()->getId() == 4) {
                $menu[] = [
                    "_iClass" => "fa fa-desktop",
                    "text" => $l10nNav["analyse"],
                    "boiler" => [
                        "text" => $l10nNav["consumption"]
                    ],
                    "heater" => [
                        "text" => $l10nNav["heat_pump"]
                    ],
                ];
            }

            $menu["profile"] = [
                "text" => $l10nNav["profile"],
                "_iClass" => "fa fa-book"
            ];


            doMenu($menu);?>
        </ul>
    </div>
</aside>