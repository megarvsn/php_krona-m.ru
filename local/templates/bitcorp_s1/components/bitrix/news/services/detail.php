<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
global $arSetting;
?>
<?$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:news.detail",
	"service",
	Array(
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"META_KEYWORDS" => $arParams["META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
		"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
		"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
		"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"USE_SHARE" => $arParams["USE_SHARE"],
		"SHARE_HIDE" => $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
		"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
		'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
	),
	$component
);?>

<?	
	//Link elements
	$arLinkElements = array();
	$linkElementsCacheID = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ELEMENT_ID" => $ElementID);
	$obCache = new CPHPCache();
	if($obCache->InitCache($arParams["CACHE_TIME"], serialize($linkElementsCacheID), "/".SITE_ID."/news/services/detail")) {
		$arLinkElements = $obCache->GetVars();	
	} elseif($obCache->StartDataCache()) {

		$arItemFilter = CBitcorp::GetCurrentElementFilter($arResult['VARIABLES'], $arParams);
		$arSelect = array("ID","IBLOCK_ID","NAME");
		$arSort = array("SORT"=>"ASC");

		$rsItems = CIBlockElement::GetList($arSort, $arItemFilter, $arSelect);
		while ($arItem = $rsItems->GetNextElement()){			
			$arLinkElements = $arItem->GetProperties();	
			$arLinkElements["ELEMENT"] = $arItem->GetFields();					
		}

		$obCache->EndDataCache($arLinkElements);
	}	
?>

<?if(in_array('LINK_FAQ', $arParams['DETAIL_PROPERTY_CODE']) && $arLinkElements['LINK_FAQ']['VALUE'] && $arLinkElements['LINK_FAQ']['LINK_IBLOCK_ID']):?>	
	<h2><?=GetMessage("MD_SERVICE_FAQ")?></h2>
	<?global $arMdFilter; $arMdFilter = array('ID' => $arLinkElements['LINK_FAQ']['VALUE']);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list", 
		"faq", 
		array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_TEXT",
				2 => "",
			),
			"FILTER_NAME" => "arMdFilter",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => $arLinkElements['LINK_FAQ']['LINK_IBLOCK_ID'],			
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"INCLUDE_SUBSECTIONS" => "Y",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "99",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "modern",
			"PAGER_TITLE" => "������� � ������",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array(
				0 => "",				
			),
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
			"STRICT_SECTION_CHECK" => "N",
			"COMPONENT_TEMPLATE" => "faq",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"SHOW_FIRST_TAB" => "N"
		),
		false,
		array("HIDE_ICONS" => "Y")
	);?>
	<br>
<?endif;?>

<?if(in_array('LINK_STAFF', $arParams['DETAIL_PROPERTY_CODE']) && $arLinkElements['LINK_STAFF']['VALUE'] && $arLinkElements['LINK_STAFF']['LINK_IBLOCK_ID']):?>	
	<h2><?=GetMessage("MD_SERVICE_STAFF")?></h2>
	<?global $arMdFilter; $arMdFilter = array('ID' => $arLinkElements['LINK_STAFF']['VALUE']);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"inner_team",
		Array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array("NAME","PREVIEW_PICTURE",""),
			"FILTER_NAME" => "arMdFilter",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"IBLOCK_ID" => $arLinkElements['LINK_STAFF']['LINK_IBLOCK_ID'],		
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
			"PAGER_TITLE" => "���������� �� �������",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array("SHOW_FRONT_PAGE","POST","PHONE","EMAIL","SKYPE",""),
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
			"STRICT_SECTION_CHECK" => "N",
			"COMPONENT_TEMPLATE" => "inner_team",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"		
		),
		false,
		array("HIDE_ICONS" => "Y")
	);?>
	<br>
<?endif;?>

<?if(in_array('LINK_REVIEWS', $arParams['DETAIL_PROPERTY_CODE']) && $arLinkElements['LINK_REVIEWS']['VALUE'] && $arLinkElements['LINK_REVIEWS']['LINK_IBLOCK_ID']):?>	
	<h2><?=GetMessage("MD_SERVICE_REVIEWS")?></h2>
	<?global $arMdFilter; $arMdFilter = array('ID' => $arLinkElements['LINK_REVIEWS']['VALUE']);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list", 
		"inner_reviews", 
		array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AUTOPLAY" => "Y",
			"AUTOPLAY_TIME" => "3",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_TEXT",
				2 => "",
			),
			"FILTER_NAME" => "arMdFilter",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"IBLOCK_ID" => $arLinkElements['LINK_REVIEWS']['LINK_IBLOCK_ID'],			
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
			"PAGER_TITLE" => "������ �� �������",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array(
				0 => "SHOW_FRONT_PAGE",
				1 => "POST",
				2 => "COMPANY",
				3 => "SOCIAL_VK",
				4 => "SOCIAL_FACEBOOK",
				5 => "SOCIAL_ODNOKLASSNIKI",
				6 => "SOCIAL_INSTAGRAM",
				7 => "SOCIAL_GOOGLE",
				8 => "SOCIAL_SKYPE",
				9 => "SOCIAL_TWITTER",
				10 => "DOCUMENTS",
			),			
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
			"STRICT_SECTION_CHECK" => "N",
			"COMPONENT_TEMPLATE" => "inner_reviews",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false,
		array("HIDE_ICONS" => "Y")
	);?>
	<br>
<?endif;?>

<?if(in_array('LINK_PROJECTS', $arParams['DETAIL_PROPERTY_CODE']) && $arLinkElements['LINK_PROJECTS']['VALUE'] && $arLinkElements['LINK_PROJECTS']['LINK_IBLOCK_ID']):?>	
	<h2><?=GetMessage("MD_SERVICE_PROJECTS")?></h2>
	<?global $arMdFilter; $arMdFilter = array('ID' => $arLinkElements['LINK_PROJECTS']['VALUE']);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"inner_".strtolower($arSetting["PROJECTS_TYPE"]["VALUE"]),
		Array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array("NAME","PREVIEW_TEXT","PREVIEW_PICTURE",""),
			"FILTER_NAME" => "arMdFilter",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"IBLOCK_ID" => $arLinkElements['LINK_PROJECTS']['LINK_IBLOCK_ID'],			
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
			"PAGER_TITLE" => "������ �� �������",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",			
			"PROJECTS_SHOW_DESCRIPTION" => "Y",
			"PROPERTY_CODE" => array("SHOW_FRONT_PAGE","BANNER_SIZE",""),		
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
	);?>
<?endif;?>

<?if(in_array('FORM_ORDER', $arParams['DETAIL_PROPERTY_CODE']) && $arLinkElements['FORM_ORDER']['VALUE'] && $arLinkElements['FORM_ORDER']['VALUE'] == "Y"):?>
	<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("services-form-block");?>
	<div id="service-order-form"></div>
	<?$APPLICATION->IncludeComponent(
	"boxsol:forms", 
	".default", 
	array(
		"IBLOCK_TYPE" => "marsd_bitcorp_requests_s1",
		"IBLOCK_ID" => "19",
		"ELEMENT_NAME" => $arLinkElements["ELEMENT"]["NAME"] ? $arLinkElements["ELEMENT"]["NAME"] : "",
		"BUTTON_TITLE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"SHOW_PERSONAL_DATA" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>	
	<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("services-form-block", "");?>	
<?endif;?>


<div class="row row-in mt50">
	<div class="<?=$arParams['USE_SHARE'] == 'Y' ? 'col-md-6' : 'col-md-12'?>">
		<div class="g-news--link">
			<a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"]?>">
				<i class="icon-rounded fa fa-angle-left"></i>
				<span class="link_underline"><?=GetMessage("T_NEWS_DETAIL_BACK")?></span>		
			</a>
		</div>
	</div>
	<?if($arParams['USE_SHARE'] == 'Y'):?>
		<div class="col-md-6">
			<div class="ya-share">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
				   "AREA_FILE_SHOW" => "file",
				   "PATH" => SITE_DIR."include/ya-share.php",
				   "EDIT_TEMPLATE" => ""
				   ),
				   false,
				   array('HIDE_ICONS' => 'Y')
				);?>								
			</div>
		</div>
	<?endif;?>
</div>