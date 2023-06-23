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
		<div class="rewiew-group">							
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				$bDetailLink = (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || strlen($arItem["DETAIL_TEXT"]) ? true : false);
				$bImage = strlen($arItem['FIELDS']['PREVIEW_PICTURE']['SRC']);						
				?>							
				<div class="rewiew" id="<?=$this->GetEditAreaId($arItem['ID'])?>">					
					<div class="rewiew--autor">
						<?=$arItem['NAME']?>

						<?if(isset($arItem['SOCIAL_PROPS']) && $arItem['SOCIAL_PROPS']):?>
							<!-- noindex -->
								<?foreach($arItem['SOCIAL_PROPS'] as $arSocProp):?>
									<a class="social-icon social-icon_inverse social-icon_xs" href="<?=$arSocProp['VALUE']?>" target="_blank" rel="nofollow">
										<i class="fa fa-<?=strtolower(str_replace("SOCIAL_", "", $arSocProp['CODE']));?>"></i>
									</a>	
								<?endforeach;?>
							<!-- /noindex -->												
						<?endif;?>
					</div>
					<?if($arItem['DISPLAY_PROPERTIES']['POST']['VALUE'] || $arItem['DISPLAY_PROPERTIES']['COMPANY']['VALUE']):?>
						<div class="rewiew--descr">
							<?=$arItem['DISPLAY_PROPERTIES']['POST']['VALUE']?> <?=$arItem['DISPLAY_PROPERTIES']['COMPANY']['VALUE']?>
						</div> 
					<?endif;?>

					<?if(strlen($arItem['FIELDS']['PREVIEW_TEXT'])):?>
						<div class="rewiew--text">
							<?=$arItem['FIELDS']['PREVIEW_TEXT']?>
						</div>
					<?endif;?>

					<?if($arItem['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE']):?>								
						<div class="mt10">
							<?foreach($arItem['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'] as $fileID):?>
								<?
									$arFile = CBitcorp::getFileInfo($fileID);
									$fileName = (strlen($arFile['DESCRIPTION']) ? $arFile['DESCRIPTION'] : $arFile['ORIGINAL_NAME']);
								?>								
								<a href="<?=$arFile['SRC']?>" class="file file_<?=$arFile['FILE_TYPE']?>" target="_blank" <?= $arFile['FILE_TYPE'] == 'jpg' || $arFile['FILE_TYPE'] == 'png' ? 'data-fancybox="gallery"' : ''?>>
									<span class="file--name"><?=$fileName?></span>
									<span class="file--size"><?=$arFile['FILE_SIZE']?></span>
								</a>								
							<?endforeach;?>										
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>						
		</div>		
	<?endif;?>