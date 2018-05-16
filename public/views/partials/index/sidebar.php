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



            $menu = [
                "" => [
                    "text" => $l10nNav["dashboard"],
                    "_iClass" => "fa fa-dashboard"
                ]
            ];

            if ($user->getRole()->getId() == 1) {
                $menu["creationUser"] = [
                    "text" => $l10nNav["creationUser"],
                    "_iClass" => "fa fa-plus-circle"
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
                        "text" => $l10nNav["boiler"]
                    ],
                    "heater" => [
                        "text" => $l10nNav["heater"]
                    ],
                    "summary" => [
                        "text" => $l10nNav["summary"]
                    ],
                ];
            }

            $menu[] = [
                "_iClass" => "fa fa-book",
                "text" => $l10nNav["administration"],
                "profile" => [
                    "text" => $l10nNav["profil"]
                ],
                "password" => [
                    "text" => $l10nNav["passwordModification"]
                ],
            ];

            doMenu($menu);?>
        </ul>
    </div>
</aside>