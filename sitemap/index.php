<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
    <div class="row row-in">
        <div class="col-md-7 mt30">
            <div class="sitemap">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.map",
                    ".default",
                    Array(
                        "LEVEL" => "3",    // Максимальный уровень вложенности (0 - без вложенности)
                        "COL_NUM" => "1",    // Количество колонок
                        "SHOW_DESCRIPTION" => "Y",    // Показывать описания
                        "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                    ),
                    false
                ); ?>
            </div>
        </div>
        <div class="col-md-5">

            <? Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("contacts-form-block"); ?>

            <? $APPLICATION->IncludeComponent(
                "boxsol:forms",
                "contacts",
                Array(
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