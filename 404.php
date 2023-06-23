<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка: 404 - Страница не найдена");

LoadProperty::setIblock('pages');
LoadProperty::setSection('');
$arContent = LoadProperty::m_LoadProperty();
$name = $arContent["error404"]["NAME"];
$text = $arContent["error404"]["HTML"];
?>
<div class="page-404">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-6">
                <?= $text ?>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="icon-404">404</div>
			</div>
		</div>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>