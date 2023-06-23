<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);
CBitcorp::setColorCSS();
?>
<? if (!$isIndex): ?>
    <? if ($isLeftSidebar): ?>
        </div><!-- /.col-md-9 -->
    <? elseif ($isRightSidebar): ?>
        </div><!-- /.col-md-9 -->
        <div class="col-md-3 col-sm-3 hide-sm hide-md">
            <aside class="sidebar">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "left",
                    array(
                        "ROOT_MENU_TYPE" => "left",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600000",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "4",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "Y",
                        "COMPONENT_TEMPLATE" => "left"
                    ),
                    false
                ); ?>
            </aside>
        </div>
    <? else: ?>
        </div><!-- /.col-md-12 -->
    <? endif; ?>

    </div><!-- /.row -->
    </div><!-- /.container -->
    </div><!-- /.content-wrapper -->
<? endif; ?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    ".default",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "footer",
        "AREA_FILE_RECURSIVE" => "N",
        "EDIT_TEMPLATE" => ""
    ),
    false
);
?>


<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <? $APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
                    "ROOT_MENU_TYPE" => "bottom",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "N",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                ),
                    false
                ); ?>
            </div>
            <div class="col-sm-4 col-md-3 tar">
                <div class="footer--contacts">
                    <div class="f-phone-number">
                        <a href="tel:<?= preg_replace("#[^\d]#", "", $phone) ?>"><?= $phone; ?></a>
                    </div>
                    <div class="f-email">
                        <a href="mailto:<?= $email ?>"><small><?= $email ?></small></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer--info">
            <div class="col-xs-12 col-sm-6 col-md-6 pull-right">

                <?
                /*$APPLICATION->IncludeComponent(
                    "boxsol:variable.set",
                    "bottom_social",
                    array(
                        "COMPONENT_TEMPLATE" => "bottom_social",
                        "LINK_VK" => "#",
                        "LINK_FB" => "#",
                        "LINK_TWITTER" => "",
                        "LINK_INSTAGRAM" => "#",
                        "LINK_YOUTUBE" => "",
                        "LINK_ODNIKLASSNIKI" => "#",
                        "LINK_GOOGLEPLUS" => ""
                    ),
                    false
                );*/
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="cop">
                    &copy; <?= $company ?>, <?= date('Y'); ?>.<br/><?= $rights ?>.
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- /.md-wrapper-->
<?= $schemaOrgAddress ?>
<?= $codeCloseBody ?>
</body>
</html>