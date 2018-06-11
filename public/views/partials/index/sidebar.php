<?php $l10nNav = $l10n["sidebar"];

if($user->getRole() == "client")
{
    $userIcon = Picture::getIcon($user->getInstallations()[0]->getId()) ;

    if(empty($userIcon))
    {
        $userIconPath = "public/images/default_user.jpg";
    }
    else
    {
        $userIconPath = "public/pics/" . $userIcon;
    }
}
else
{
    $userIconPath = "public/images/default_user.jpg";
}

?>
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="<?= BASE_URL ?>profile"><img src="<?= $userIconPath ?>" class="img-circle" width="70"></a></p>
            <h5 class="centered"><?= $user ?></h5>

            <?php
            function doLink ($href, $attr, $isActive = false) {
                if (!isset($attr["_iClass"])) $attr["_iClass"] = "";
                printf("<li %s>" , $isActive ? 'class="active"': ''); ?>
                    <a href="<?= BASE_URL . $href ?>" >
                        <i class="<?= $attr["_iClass"] ?>"></i><span><?= $attr["text"] ?></span>
                    </a>
                </li> <?php
            }

            function doSubMenu($menu, $isActive = false, $pathMenu = "") {
                if (!isset($menu["_iClass"])) $menu["_iClass"] = ""; ?>
                <li class="sub-menu">
                    <a href="javascript:;" <?= $isActive ? 'class="active"': '' ?> >
                        <i class="<?= $menu["_iClass"] ?>"></i>
                        <span><?= $menu["text"] ?></span>
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

                /*
                $menu["allUsers"] = [
                    "text" => $l10nNav["allUsers"],
                    "_iClass" => "fa fa-users"
                ];*/

                $menu["checkUserData"] = [
                    "text" => $l10nNav["checkUserData"],
                    "_iClass" => "fa fa-odnoklassniki"
                ];

                $menu["grafana"] = [
                    "text" => $l10nNav["grafana"],
                    "_iClass" => "fa fa-wrench"
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

                $menu[] = [

                    "_iClass" => "fa fa-desktop",
                    "text" => $l10nNav["analyse"],

                    "consumption" => [
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