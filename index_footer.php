<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $arSetting;?>
<?if(in_array("NEWS", $arSetting["HOME_PAGE"]["VALUE"])):?>
	<?$GLOBALS['arNewsItemsFilter'] = array('!PROPERTY_SHOW_FRONT_PAGE' => false);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list", 
		"front_news", 
		array(
			"COMPONENT_TEMPLATE" => "front_news",
			"IBLOCK_TYPE" => "marsd_bitcorp_s1",
			"IBLOCK_ID" => "6",
			"NEWS_COUNT" => "3",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "arNewsItemsFilter",
			"FIELD_CODE" => array(
				0 => "NAME",
				1 => "PREVIEW_PICTURE",
				2 => "DATE_ACTIVE_FROM",
				3 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "j M Y",
			"SET_TITLE" => "N",
			"SET_BROWSER_TITLE" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_LAST_MODIFIED" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"INCLUDE_SUBSECTIONS" => "Y",
			"STRICT_SECTION_CHECK" => "N",
			"PAGER_TEMPLATE" => ".default",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Новости на главной",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"DISPLAY_DATE" => "Y",
			"DISPLAY_NAME" => "Y",
			"DISPLAY_PICTURE" => "Y",
			"DISPLAY_PREVIEW_TEXT" => "Y",
			"AUTOPLAY_TIME" => "3",
			"AUTOPLAY" => "Y",
			"ANIMATION_IN" => "",
			"ANIMATION_OUT" => "",
			"SHOW_NAME" => "Y",
			"SHOW_ALL_TITLE" => "Все новости",
			"NEWS_BLOCK_TITLE" => "Новости"
		),
		false
	);?>
<?endif;?>
<?if(in_array("PARTNERS", $arSetting["HOME_PAGE"]["VALUE"])):?>
	<?$GLOBALS['arPartnersItemsFilter'] = array('!PROPERTY_SHOW_FRONT_PAGE' => false);?>
	<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"front_partners", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
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
			1 => "PREVIEW_PICTURE",
			2 => "",
		),
		"FILTER_NAME" => "arPartnersItemsFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => "10",
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
		"PAGER_TITLE" => "Ключевые партнеры",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "SHOW_FRONT_PAGE",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"PARTNER_BLOCK_DESCRIPTION" => "",
		"COMPONENT_TEMPLATE" => "front_partners",
		"PARTNER_BLOCK_TITLE" => "Ключевые партнеры",
		"AUTOPLAY_TIME" => "5",
		"AUTOPLAY" => "Y"
	),
	false
);?>
<?endif?>