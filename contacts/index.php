<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
    <div class="row row-in">
        <div class="col-md-7 mt30">
            <div class="row row-in main-contacts">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <p class="h-phone--worktime">
                        <?= $phoneName ?>
                    </p>
                    <p class="c-phone--number">
                        <a href="tel:<?= preg_replace("#[^\d]#", "", $phone) ?>"><?= $phone; ?></a>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <p class="h-phone--worktime">
                        <?= $emailName ?>
                    </p>
                    <p class="c-email--number">
                        <a href="mailto:<?= $email ?>"><?= $email ?></a>
                    </p>
                </div>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "contacts",
                array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "COMPONENT_TEMPLATE" => "contacts",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array(0 => "NAME", 1 => "PREVIEW_TEXT", 2 => "",),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "IBLOCK_ID" => "2",
                    "IBLOCK_TYPE" => "marsd_bitcorp_s1",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "20",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Контакты",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array(0 => "ADDRESS", 1 => "PHONE", 2 => "MAIL", 3 => "SKYPE", 4 => "",),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            ); ?>
        </div>
        <div class="col-md-5">

            <? Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("contacts-form-block"); ?>

            <? $APPLICATION->IncludeComponent(
                "boxsol:forms",
                "contacts",
                array(
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "BUTTON_TITLE" => "",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "ELEMENT_NAME" => "",
                    "IBLOCK_ID" => "17",
                    "IBLOCK_TYPE" => "marsd_bitcorp_requests_s1",
                    "SHOW_PERSONAL_DATA" => "Y"
                )
            ); ?>

            <? Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("contacts-form-block", ""); ?>

        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>