<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<?if (!empty($arResult)):?>
		<?
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
		?>
			<div class="projects-2 row row-in">					
				<div class="col-md-12">
					<div class="row row-in row-equal row-in">
						<?foreach($arResult["ITEMS"] as $arItem):?>
							<?
							$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
							$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							$projectSize = "";
							$bDetailLink = (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || strlen($arItem["DETAIL_TEXT"]) ? true : false);
							$bImage = strlen($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);
							$projectSizeValue = $arItem['PROPERTIES']['BANNER_SIZE']['VALUE_XML_ID'];
							if($projectSizeValue == "narrow"){
								$projectSize = "col-lg-3";
							} elseif($projectSizeValue == "normal"){
								$projectSize = "col-lg-4";
							}elseif($projectSizeValue == "wide"){
								$projectSize = "col-lg-6";
							}
							?>								
							<div class="col-xs-12 col-sm-6 col-md-4 <?=$projectSize?> project-2">
								<?if($bDetailLink):?><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?endif;?>
									<div class="project-2--img" style="background-image: url(<?=$arItem['FIELDS']['PREVIEW_PICTURE']['SRC']?>);">
										<div class="project-2--more">
											<span><?=GetMessage("MD_READ_MORE_LINK")?></span>
											<i class="icon-rounded fa fa-angle-right" aria-hidden="true"></i>
										</div>
									</div>		
									<div class="project-2--name">
										<span><?=$arItem['~NAME']?></span>
									</div>
									<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT']) && $arParams['PROJECTS_SHOW_DESCRIPTION'] == 'Y'):?>	
										<div class="project-2--descr">
											<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
										</div>
									<?endif;?>	
								<?if($bDetailLink):?></a><?endif;?>
							</div>

						<?endforeach;?>
					</div>
				</div>
			</div>		
	<?endif;?>