<?php $l10nNav = $l10n["sidebar"]; ?>
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="<?= BASE_URL ?>profile"><img src="<?= BASE_URL ?>user.icon" class="img-circle" width="60"></a></p>
            <h5 class="centered"><?= $user ?></h5>

            <?php
            function doLink ($href, $attr, $isActive = false) {
                if (!isset($attr["_iClass"])) $attr["_iClass"] = "";
                printf("<li %s>" , $isActive ? 'class="active"': ''); ?>
                    <a href="<?= isset($attr["href"]) ? $attr["href"] : BASE_URL . $href ?>" target="<?= isset($attr["target"]) ? $attr["target"] : "" ?>">
                        <i class="<?= $attr["_iClass"] ?>"></i><span><?= $attr["text"] ?></span>
                    </a>
                </li> <?php
            }

            function doSubMenu($menu, $isActive = false, $pathMenu = "") {
                if (!isset($menu["_iClass"])) $menu["_iClass"] = ""; ?>
                <li class="sub-menu">
                    <a href="javascript:;" <?= $isActive ? 'class="active"': '' ?> >
                        <i class="<?= isset($menu["_iClass"]) ?  $menu["_iClass"] : ""?>"></i>
                        <span><?= isset($menu["text"]) ? $menu["text"] : ""?></span>
                    </a>
                    <ul class="sub">
                        <?php doMenu($menu, $pathMenu); ?>
                    </ul>
                </li> <?php
            }

            function doMenu($menu = [], $pathMenu = "") {
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
                        if ($isSubMenu) doSubMenu($attr, $isActive, $pathMenu);
                        else doLink($href, $attr, $href == $pathMenu);
                    }
                }
            }


            if ($user->getRole()->getId() == 1) {


                $menu["creationUser"] = [
                    "text" => $l10nNav["creationUser"],
                    "_iClass" => "fa fa-user-plus"
                ];

                $menu["editUser"] = [
                    "text" => $l10nNav["editUser"],
                    "_iClass" => "fa fa-user"
                ];

                $menu["allUsers"] = [
                    "text" => $l10nNav["allUsers"],
                    "_iClass" => "fa fa-users"
                ];

                $menu["checkUserData"] = [
                    "text" => $l10nNav["checkUserData"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];

                $menu["userGraph"] = [
                    "text" => $l10nNav["userGraph"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];

                $menu["grafana"] = [
                    "text" => $l10nNav["grafana"],
                    "_iClass" => "fa fa-wrench",
                    "href" => "https://cloudio-data.esr.ch/grafana/",
                    "target" => "_blanck"
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

                $menu["userGraph"] = [
                    "text" => $l10nNav["userGraph"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];

                $menu["grafana"] = [
                    "text" => $l10nNav["grafana"],
                    "_iClass" => "fa fa-wrench"
                ];
            }

            if ($user->getRole()->getId() == 3) {
                $menu["checkUserData"] = [
                    "text" => $l10nNav["checkUserData"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];
            }

            if ($user->getRole()->getId() == 4) {

                $menu[""] = [
                    "text" => $l10nNav["dashboard"],
                    "_iClass" => "fa fa-dashboard"
                ];

                $menu["consumptionElect"] = [
                    "text" => $l10nNav["consumptionElec"],
                    "_iClass" => "fa fa-bolt"
                ];

                $menu["boiler"] = [
                    "text" => $l10nNav["boiler"],
                    "_iClass" => "fa fa-bath"
                ];

                $menu["consumptionHeatPump"] = [
                    "text" => $l10nNav["heat_pump"],
                    "_iClass" => "fa fa-fire"
                ];

                $menu["insideTemp"] = [
                    "text" => $l10nNav["insideTemp"],
                    "_iClass" => "fa fa-thermometer"
                ];

                if($user->getInstallations()[0]->Solar()->isExistant()) {

                    $menu["productionElect"] = [
                        "text" => $l10nNav["productionElect"],
                        "_iClass" => "fa fa-certificate"
                    ];
                }



                /*
                 * :TODO Put a submenu Graphics
                if($user->getInstallations()[0]->Solar()->isExistant())
                {
                    $menu[] = [

                        "_iClass" => "fa fa-desktop",
                        "text" => $l10nNav["analyse"],

                        "consumptionElect" => [
                            "text" => $l10nNav["consumptionElec"]
                        ],
                        "boiler" => [
                            "text" => $l10nNav["boiler"]
                        ],
                        "consumptionHeatPump" => [
                            "text" => $l10nNav["heat_pump"]
                        ],
                        "insideTemp" => [
                            "text" => $l10nNav["insideTemp"]
                        ],
                        "productionElect" => [
                            "text" => $l10nNav["productionElect"]
                        ],
                    ];
                }
                else
                {
                    $menu[] = [

                        "_iClass" => "fa fa-desktop",
                        "text" => $l10nNav["analyse"],

                        "consumptionElect" => [
                            "text" => $l10nNav["consumptionElec"]
                        ],
                        "boiler" => [
                            "text" => $l10nNav["boiler"]
                        ],
                        "consumptionHeatPump" => [
                            "text" => $l10nNav["heat_pump"]
                        ],
                        "insideTemp" => [
                            "text" => $l10nNav["insideTemp"]
                        ],
                    ];
                }*/
            }

            $menu["profile"] = [
                "text" => $l10nNav["profile"],
                "_iClass" => "fa fa-book"
            ];

            doMenu($menu, isset($path) ? $path : ""); ?>
            <li style="text-align: center"><?php include __DIR__ . '/../sltLang.php'; ?></li>
        </ul>
    </div>
</aside>