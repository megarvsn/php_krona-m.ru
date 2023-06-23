<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

if (!defined("BITCORP_MODULE_NAME")) {
    define("BITCORP_MODULE_NAME", "boxsol.bitcorp");
}
CJSCore::Init(array("jquery", "fx"));
IncludeTemplateLangFile(__FILE__);

$arCurrentSite = CSite::GetByID(SITE_ID)->Fetch();
$request = Application::getInstance()->getContext()->getRequest();
\Bitrix\Main\Loader::includeModule(BITCORP_MODULE_NAME);

include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/include_area/variable_definition.php");

// get site data
$cache = new CPHPCache();
$cache_time = 86400;
$cache_id = 'CSiteGetByID' . SITE_ID;
$cache_path = '/siteData/';
if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
    $res = $cache->GetVars();
    if (is_array($res["CSiteGetByID"]) && (count($res["CSiteGetByID"]) > 0))
        $CSiteGetByID = $res["CSiteGetByID"];
}
if (!is_array($CSiteGetByID)) {
    $rsSites = CSite::GetByID(SITE_ID);
    $CSiteGetByID = $rsSites->Fetch();
    if ($cache_time > 0) {
        $cache->StartDataCache($cache_time, $cache_id, $cache_path);
        $cache->EndDataCache(array("CSiteGetByID" => $CSiteGetByID));
    }
}

// Last Modified
$filename = __FILE__;
$LastModified_unix = filemtime($filename); // время последнего изменения страницы

$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
$IfModifiedSince = false;
if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
    exit;
}
header('Last-Modified: ' . $LastModified);

//$APPLICATION->SetPageProperty("ogimage", CBitcorp::ShowLogoImg());
?>
<!doctype html>
<html dir="ltr" lang="<?= $arCurrentSite["LANGUAGE_ID"] ?>">

<head>
    <? Asset::getInstance()->addString('<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">'); ?>
    <? Asset::getInstance()->addString('<meta content="telephone=no" name="format-detection">'); ?>
    <? Asset::getInstance()->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge" />'); ?>
    <? Asset::getInstance()->addString('<script>BX.message(' . CUtil::PhpToJSObject($MESS, false) . ')</script>', true); ?>
    <? CBitcorp::ShowFaviconImg(); ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&amp;subset=cyrillic" rel="stylesheet">

    <? $APPLICATION->ShowHead(); ?>

    <?
    $moduleStatus = CModule::IncludeModuleEx(BITCORP_MODULE_NAME);
    if ($moduleStatus == 0) {
        die(GetMessage("BITCORP_NOT_INSTALLED"));
    } elseif ($moduleStatus == 3) {
        die(GetMessage("BITCORP_DEMO_EXPIRED"));
    } else {
        CBitcorp::init();
        //for demo site only
        //CBitcorp::setDemoMode();
    }
    ?>

    <title>
        <?php
        $APPLICATION->ShowTitle();
        if ($CSiteGetByID['SITE_NAME'] != ''):
            echo ' | ' . $CSiteGetByID['SITE_NAME'];
        endif;
        ?>
    </title>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "url": "https://<?=SITE_SERVER_NAME?><?= $APPLICATION->GetCurPage(); ?>",
            "logo": "https://<?=SITE_SERVER_NAME?>/logo.png"
        }
    </script>

    <meta property="og:title" content="<?= $APPLICATION->ShowTitle(); ?>"/>
    <meta property="og:description" content="<?= $APPLICATION->GetProperty("description"); ?>"/>
    <meta property="og:image" content="https://<?=SITE_SERVER_NAME?>/logo.png">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="https://<?=SITE_SERVER_NAME?><?= $APPLICATION->GetCurPage(); ?>"/>

    <?= $codeHead; ?>
</head>

<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>

<body>
<?= $codeBody; ?>

<div class="md-wrapper slider-wrapper">
    <?
    global $arSetting, $arSite, $headerType, $menuType, $is404;
    $arSetting = $APPLICATION->IncludeComponent("boxsol:settings", "", array(), false, array("HIDE_ICONS" => "Y"));
    $arSite = CSite::GetByID(SITE_ID)->Fetch();
    $isIndex = CSite::inDir(SITE_DIR . "index.php");
    $isLeftSidebar = ($APPLICATION->GetProperty('SIDEBAR_LEFT') == "Y" ? true : false);
    $isRightSidebar = ($APPLICATION->GetProperty('SIDEBAR_RIGHT') == "Y" ? true : false);
    $is404 = defined("ERROR_404") && ERROR_404 === "Y";
    $headerType = $arSetting["HEADER_TYPE"]["VALUE"];
    $menuType = ($arSetting['MENU_TYPE']['VALUE'] == "WHITE" ? "main-menu-wrapper_white" : ($arSetting['MENU_TYPE']['VALUE'] == "DARK" ? "main-menu-wrapper_black" : ""));

    ?>

    <? if ($arSetting['MENU_TYPE']['VALUE'] == 'DARK' && $arSetting['HEADER_TYPE']['VALUE'] != 'SECOND'): ?>
    <div class="black-menu">
        <? endif; ?>

        <div class="header <?= ($headerType == 'SECOND' ? 'header_compact' : ''); ?>">

            <? if ($headerType == "FIRST"): ?>
                <div class="container ">
                    <div class="row header--row">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <a class="logo" href="<?= SITE_DIR ?>"><?= CBitcorp::ShowLogoImg(); ?></a>
                        </div>
                        <div class="col-sm-5 col-md-3 col-lg-3 hide-sm">
                            <div class="top-tagline">
                                <?= $slogan ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-6 col-lg-6 header-contacts hide-sm">
                            <div class="h-phone">
                                <p class="h-phone--worktime">
                                    <?= $work ?>
                                </p>
                                <p class="h-phone--number">
                                    <a href="tel:<?= preg_replace("#[^\d]#", "", $phone) ?>"><?= $phone; ?></a><br>
                                    <a href="mailto:<?= $email ?>">
                                        <small><?= $email ?></small>
                                    </a>
                                </p>
                            </div>
                            <div class="h-button">
                                <a class="btn btn-primary" data-event="jqm" data-ajax="<?= SITE_DIR ?>ajax/form.php"
                                   data-name="callback">
                                    <?= GetMessage("MD_ORDER_BUTTON_TITLE") ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <? elseif ($headerType == "SECOND"): ?>
                <div class="top-block hide-sm">
                    <div class="container">
                        <div class="row header--row">
                            <div class="col-sm-6">
                                <div class="top-block--info">
                                    <?= $address ?>
                                </div>
                            </div>
                            <div class="col-sm-6 tar">
                                <div class="h-phone">
                                    <p class="h-phone--number">
                                        <a href="tel:<?= preg_replace("#[^\d]#", "", $phone) ?>"><?= $phone; ?></a><br>
                                        <a href="mailto:<?= $email ?>">
                                            <small><?= $email ?></small>
                                        </a>
                                    </p>
                                </div>
                                <a class="btn btn-xs btn-primary" data-event="jqm"
                                   data-ajax="<?= SITE_DIR ?>ajax/form.php"
                                   data-name="callback"><?= GetMessage("MD_ORDER_BUTTON_TITLE") ?>  </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second_header">
                    <div class="container">
                        <div class="row header--row">
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <a class="logo" href="<?= SITE_DIR ?>">
                                    <?= CBitcorp::ShowLogoImg(); ?>
                                </a>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-9 hide-sm">
                                <? $APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel_second", array(
                                    "ROOT_MENU_TYPE" => "top",
                                    "MAX_LEVEL" => "3",
                                    "CHILD_MENU_TYPE" => "left",
                                    "USE_EXT" => "Y",
                                    "MENU_CACHE_TYPE" => "A",
                                    "MENU_CACHE_TIME" => "36000000",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "MENU_CACHE_GET_VARS" => ""
                                ),
                                    false
                                ); ?>
                            </div>

                        </div>
                    </div>
                </div>

            <? endif; ?>
        </div>

        <? if ($headerType == "FIRST"): ?>
            <div class="main-menu-wrapper hide-sm <?= $menuType ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <? $APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel_first", array(
                                "ROOT_MENU_TYPE" => "top",
                                "MAX_LEVEL" => "3",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => ""
                            ),
                                false
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>

        <? endif; ?>

        <div class="mobile-menu--btn show-sm dn">
            <span></span>
        </div>
        <? $APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel_mobile", array(
            "ROOT_MENU_TYPE" => "top",
            "MAX_LEVEL" => "3",
            "CHILD_MENU_TYPE" => "left",
            "USE_EXT" => "Y",
            "MENU_CACHE_TYPE" => "A",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => ""
        ),
            false,
            array(
                "HIDE_ICONS" => "Y",
                "ACTIVE_COMPONENT" => "Y"
            )
        ); ?>

        <? $APPLICATION->ShowViewContent('hide_breadcrubs_start') ?>
        <? /* page title and breadcrumbs block */ ?>
        <? if (!$isIndex && !$is404): ?>
            <div class="page-head page-head_compact">
                <div class="container">
                    <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "bitcorp", array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => SITE_ID
                    ),
                        false
                    ); ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h1><? $APPLICATION->ShowTitle(false); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        <? endif; ?>

        <? if ($arSetting['MENU_TYPE']['VALUE'] == 'DARK' && $arSetting['HEADER_TYPE'] != 'SECOND'): ?>
    </div>
<? endif; ?>

    <? $APPLICATION->ShowViewContent('hide_breadcrubs_end') ?>

    <? $APPLICATION->ShowViewContent('top_banner') ?>

    <?
    $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        Array(
            "AREA_FILE_SHOW" => "page",
            "AREA_FILE_SUFFIX" => "header",
            "AREA_FILE_RECURSIVE" => "N",
            "EDIT_TEMPLATE" => ""
        ),
        false,
        array(
            "HIDE_ICONS" => "Y",
            "ACTIVE_COMPONENT" => "Y"
        )
    );
    ?>
    <? if ($isIndex): ?>
        <? @include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_DIR . '/indexblocks.php')); ?>
    <? else: ?>

    <div class="content-wrapper <?= $is404 ? 'content-wrapper_bg-default' : '' ?>">
        <div class="container">
            <div class="row">
                <? if ($is404): ?>

                <? elseif ($isLeftSidebar): ?>
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
                <div class="col-md-9">
                    <div class="first-elem"></div>
                    <? elseif ($isRightSidebar): ?>
                    <div class="col-md-9">
                        <div class="first-elem"></div>
                        <? else: ?>
                        <div class="col-md-12">
                            <div class="first-elem"></div>
                            <? endif; ?>
                            <? endif; ?>
