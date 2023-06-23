<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Loader,
	Bitrix\Main\Text\Encoding,
	Bitrix\Iblock,	
	Bitrix\Main\Application,
	Bitrix\Main\Mail\Event,
	Bitrix\Main\Localization\Loc;
global $APPLICATION;
global $USER;

if(!Loader::includeModule("iblock"))
	return;

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

if( $arParams["IBLOCK_ID"] > 0 ){
	$arResult["FORM_RIGHT"] = CIBlock::GetPermission( $arParams["IBLOCK_ID"] );

	if( $arResult["FORM_RIGHT"] == "D" ){
		$arResult["ERROR_MESSAGE"][] = Loc::getMessage("FORM_ACCESS_DENIED")."<br />";	
	}
} else{
	$arResult["ERROR_MESSAGE"][] = Loc::getMessage("NO_IBLOCK_ID")."<br />";
}


$arSetting = CBitcorp::GetFrontParametrsValues(SITE_ID);

//MODULE OPTIONS
$arParams["MODULE_OPTIONS"] = $arSetting;
$arParams["IS_AUTHORIZED"] = $USER->IsAuthorized() ? "Y" : "N";
$arParams["PHONE_MASK"] = $arSetting["FORMS_PHONE_MASK"];
$arParams["VALIDATE_PHONE_MASK"] = $arSetting["FORMS_VALIDATE_PHONE_MASK"];
$arParams["SHOW_PERSONAL_DATA"] = "Y";
$arParams["SHOW_PERSONAL_DATA"] = $arSetting["SHOW_PERSONAL_DATA"];
$arParams["TEXT_PERSONAL_DATA"] = $arSetting["TEXT_PERSONAL_DATA"];

//$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());
$arResult["ERROR_MESSAGE"] = $arResult["SUCCESS_MESSAGE"] = array();
$request = Application::getInstance()->getContext()->getRequest();

	$arResult = array();
	$arResultCacheID = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ELEMENT_NAME" => $arParams["ELEMENT_NAME"]);
	$obCache = new CPHPCache();

	if($obCache->InitCache($arParams["CACHE_TIME"], serialize($arResultCacheID), "/".SITE_ID.$this->GetRelativePath())) {
		$arResult = $obCache->GetVars();		
	} elseif($obCache->StartDataCache()) {

		//IBLOCK//
		$arIblock = CIBlock::GetList(array("SORT" => "ASC"), array("ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"))->Fetch();
		
		if(empty($arIblock)) {
			$this->abortResultCache();
			return;
		}
		
		$arResult["IBLOCK"]["ID"] = $arIblock["ID"];
		$arResult["IBLOCK"]["CODE"] = $arIblock["CODE"];
		$arResult["IBLOCK"]["NAME"] = $arIblock["NAME"];
		$arResult["IBLOCK"]["DESCRIPTION"] = $arIblock["DESCRIPTION"];
		$arResult["IBLOCK"]["DESCRIPTION_TYPE"] = $arIblock["DESCRIPTION_TYPE"];

		//ELEMENT_AREA_ID//
		$arResult["ELEMENT_AREA_ID"] = $arResult["IBLOCK"]["CODE"];
		
		//IBLOCK_PROPS//
		$rsProps = CIBlock::GetProperties($arIblock["ID"], array("SORT" => "ASC", "NAME" => "ASC"), array("ACTIVE" => "Y"));
		while($arProps = $rsProps->fetch()) {
			$arResult["IBLOCK"]["PROPERTIES"][] = $arProps;
		}
		
		foreach($arResult["IBLOCK"]["PROPERTIES"] as $key => $arProp){

			if(is_array($arProp)){
							
				$required = $arProp["IS_REQUIRED"] == "Y" ? 'required' : '';
				$bRequired = $arProp["IS_REQUIRED"] == "Y" ? true : false;
				$phone = strpos( $arProp["CODE"], "PHONE" ) !== false ? 'phone' : '';
				$placeholder = $bRequired ? $arProp["NAME"].'*' : $arProp["NAME"];
				$labelPlaceholder = $required ? ''.$arProp["NAME"].'<span class="required-star">*</span>':''.$arProp["NAME"].'';
				$icon = ($arProp["CODE"] == "NAME") ? '<i class="fa fa-user-o"></i>' : (($arProp["CODE"] == "EMAIL") ? '<i class="fa fa-envelope-o"></i>' : (($arProp["CODE"] == "PHONE")? '<i class="fa fa-phone"></i>' : ''));
				$multiple = $arProp["MULTIPLE"] == "Y" ? ' multiple ' : '';
				$elementName = $arParams["ELEMENT_NAME"] ? $arParams["ELEMENT_NAME"] : "";			
				$value = $arProp["DEFAULT_VALUE"] ? $arProp["DEFAULT_VALUE"] : "";
				$readonly = "";
				
				if($arProp["CODE"] == "SERVICE" && strlen($elementName) > 0){
					$value = $elementName;
					$readonly = 'readonly="readonly"';
				}

				$html = '';
				if($arProp["PROPERTY_TYPE"] == "S"  && empty($arProp["USER_TYPE"]) && $arProp["CODE"] == "SEND_FROM"){
					//input=hidden
					$value = $APPLICATION->GetCurPage();
					$html = '<input value="'.$value.'" type="hidden" id="form_'.$arProp["CODE"].'" name="'.$arProp["CODE"].'"/>';
					$arResult["IBLOCK"]["PROPERTIES"][$key]["HTML_CODE"] = $html;
				}elseif($arProp["PROPERTY_TYPE"] == "S"  && empty($arProp["USER_TYPE"])){
					//input=text
					$html = '<input value="'.$value.'" type="'.($arProp["CODE"] == "EMAIL" ? "email" : "text").'" id="form_'.$arProp["CODE"].'" name="'.$arProp["CODE"].'" class="form-control '.$required.' '.$phone.'" placeholder="'.$placeholder.'" '.$readonly.' />'.'<label for="form-'.$arProp["CODE"].'">'.$labelPlaceholder.'</label>'.$icon;
					$arResult["IBLOCK"]["PROPERTIES"][$key]["HTML_CODE"] = $html;

				}elseif($arProp["PROPERTY_TYPE"] == "S" && !empty($arProp["USER_TYPE"]) && $arProp["USER_TYPE"] == "HTML" ){
					//textarea
					$value = (isset($value['TEXT']) ? $value['TEXT'] : $value);
					$html = '<textarea rows="3" id="form_'.$arProp["CODE"].'"  class="form-control '.$required.'"  name="'.$arProp["CODE"].'" placeholder="'.$placeholder.'">'.$value.'</textarea><label for="form-'.$arProp["CODE"].'">'.$labelPlaceholder.'</label><i class="fa fa-commenting-o "></i>';
					$arResult["IBLOCK"]["PROPERTIES"][$key]["HTML_CODE"] = $html;
				} elseif($arProp["PROPERTY_TYPE"] == "L" && $arProp["LIST_TYPE"] == "L"){
					//select
					$rsSelectValues = CIBlockProperty::GetPropertyEnum( $arProp["CODE"], array( "SORT" => "ASC", "ID" => "ASC" ), array("IBLOCK_ID" => $arParams["IBLOCK_ID"]));				

					$html = '<select id="form_'.$arProp["CODE"].'" name="'.$arProp["CODE"].($arProp["MULTIPLE"] == "Y" ? '[]' : '').'" class="form-control '.$required.'" '.$multiple.$placeholder.' '.$readonly.'>';
					while( $arSelectValue = $rsSelectValues->Fetch() ){
						$selected = '';
						if( !empty( $value ) && (!is_array($value) ? ($arSelectValue["ID"] == $value) : (in_array($arSelectValue["ID"], $value))) ){
							$selected = 'selected="selected"';
						}
						if( empty( $value ) && $arSelectValue["DEF"] == "Y" ){
							$selected = 'selected="selected"';
						}
						$html .= '<option '.$selected.' value="'.$arSelectValue["ID"].'">'.$arSelectValue["VALUE"].'</option>';

						$arResult["IBLOCK"]["PROPERTIES"][$key]["ENUMS"][$arSelectValue["ID"]] = $arSelectValue["VALUE"];
					}
					$html .= '</select>';

					$arResult["IBLOCK"]["PROPERTIES"][$key]["HTML_CODE"] = $html;
				} elseif($arProp["PROPERTY_TYPE"] == "F"){

                    if( $arProp["MULTIPLE"] == "Y" ){
                        $html = '';
                        for( $i = 1; $i < 5; $i++ ){
                            $html .= '<div class="form-group"><div class="custom-file-input"><label class="btn btn-default file-input-triger btn-xs">';
                            $html .= '<input type="file" id="'.$arProp["CODE"].'_n'.$i.'" name="'.$arProp["CODE"].'_n'.$i.'" '.$required.' class="js-custom-file-input '.$required.'" value="'.$valFile['n'.$i].'" />Выберите файл';
                            $html .= '</label><div class="js-custom-file-input-name custom-file-input--name">Файл не выбран</div></div></div>';
                        }
                    }else{
                        $html .= '<div class="form-group"><div class="custom-file-input"><label class="btn btn-default file-input-triger btn-xs">';
                        $html .= '<input type="file" id="'.$arProp["CODE"].'" name="'.$arProp["CODE"].'" '.$required.' class="js-custom-file-input '.$required.'" />Выберите файл';
                        $html .= '</label><div class="js-custom-file-input-name custom-file-input--name">Файл не выбран</div></div></div>';
                    }

                    $arResult["IBLOCK"]["PROPERTIES"][$key]["HTML_CODE"] = $html;
				}
			}
		}

		if(!isset($arResult["IBLOCK"]["PROPERTIES"]) || empty($arResult["IBLOCK"]["PROPERTIES"])) {
			$this->abortResultCache();
			return;
		}		
		$obCache->EndDataCache($arResult);
	}
	
	


$formSubmit = $request->getPost("form_submit");
$paramsHash = $request->getPost("PARAMS_HASH");
$bPost = $request->isPost();
$method = $request->getRequestMethod();

//process submit
if($bPost && $formSubmit <> ''){

	$captchaWord = $request->getPost("CAPTCHA_WORD");
	$captchaSid = $request->getPost("CAPTCHA_SID");

	//REQUARED//
	foreach($arResult["IBLOCK"]["PROPERTIES"] as $key => $arProp) {		
		if($arProp["IS_REQUIRED"] == "Y" && $arProp['PROPERTY_TYPE'] != "F") {
			$arRequired[] = array(
				"CODE" => $arProp["CODE"],
				"NAME" => $arProp["NAME"]
			);
		}
	}	

	//CHECKS//
	if(isset($arRequired) && !empty($arRequired)) {
		foreach($arRequired as $arRequiredProp) {
			$arPropFromPost = $request->getPost($arRequiredProp["CODE"]);
			if(empty($arPropFromPost)){
				$arResult["ERROR_MESSAGE"][] = Loc::getMessage("FIELD_NOT_FILLED", array("#FIELD#" => $arRequiredProp["NAME"]))."<br />";
			}
		}
	}

	//VALIDATE PHONE_MASK//
	/*
	foreach($arResult["IBLOCK"]["PROPERTIES"] as $key => $arProp) {
		if($arProp["CODE"] == "PHONE") {
			$arPropFromPost = $request->getPost($arProp["CODE"]);
			if(!empty($arPropFromPost)) {
				if(!preg_match($arParams["VALIDATE_PHONE_MASK"], $arPropFromPost)) {
					$arResult["ERROR_MESSAGE"][] = Loc::getMessage("FIELD_INVALID", array("#FIELD#" => $arProp["NAME"]))."<br />";
				}
			}
		}
	}
	*/

	//PROCESS CAPTCHA
    if($arParams["MODULE_OPTIONS"]["FORMS_USE_CAPTCHA"] == "Y"){

        if($arParams["MODULE_OPTIONS"]["CAPTCHA_TYPE"] == "BITRIX_CAPTCHA"){
            if(empty($captchaSid) && !$APPLICATION->CaptchaCheckCode($captchaWord, $captchaSid)){
                $arResult['ERROR_MESSAGE'][] = Loc::getMessage("WRONG_CAPTCHA")."<br />";
            }
        } elseif($arParams["MODULE_OPTIONS"]["CAPTCHA_TYPE"] == "GOOGLE_RECAPTCHA"){
            $proved = false;
            $gResponse = $request->getPost('g-recaptcha-response');

            if(isset($gResponse) && strlen($gResponse)){
                $result = file_get_contents(
                    'https://www.google.com/recaptcha/api/siteverify',
                    false,
                    stream_context_create(
                        array(
                            'http' => array(
                                'method'  => 'POST',
                                'header'  => 'Content-type: application/x-www-form-urlencoded',
                                'timeout' => 5,
                                'content' => http_build_query(
                                    array(
                                        'secret' => $arParams["MODULE_OPTIONS"]["RECAPTCHA_SECRET_KEY"],
                                        'response' => $request->getPost('g-recaptcha-response'),
                                    )
                                )
                            )
                        )
                    )
                );

                if($result){
                    if($arResponse = json_decode($result, true)){
                        if(is_array($arResponse)){
                            $proved = (isset($arResponse['success']) && isset($arResponse['success']) === true);
                        }
                    }
                }
            }

            if(!$proved){
                $arResult['ERROR_MESSAGE'][] = GetMessage('FORM_RECAPTCHA');
                $captcha_error = true;
            }
        }
    }


	//PROCESS PROPERTIES//
	$arProps = array();//fields for event
	$arElementProps = array();//fields for new iblock element

	foreach($arResult["IBLOCK"]["PROPERTIES"] as $arProp) {
		$arPropFromPost = $request->getPost($arProp["CODE"]);

		if(!empty($arPropFromPost)) {
			if($arProp["USER_TYPE"] == "HTML") {
				$arProps[$arProp["CODE"]] = array(
					"VALUE" => array(
						"TEXT" => \Bitrix\Main\Text\Encoding::convertEncodingToCurrent(strip_tags(trim($arPropFromPost))),
						"TYPE" => $arProp["DEFAULT_VALUE"]["TYPE"]
					)
				);
				$arElementProps[$arProp["CODE"]] = array(
					"VALUE" => array(
						"TEXT" => \Bitrix\Main\Text\Encoding::convertEncodingToCurrent(strip_tags(trim($arPropFromPost))),
						"TYPE" => $arProp["DEFAULT_VALUE"]["TYPE"]
					)
				);
			} elseif ($arProp["PROPERTY_TYPE"] == "L" && $arProp["LIST_TYPE"] == "L"){
				if(is_array($arPropFromPost)){
					foreach ($arPropFromPost as $propValue) {
						$arTmp[] = $arProp["ENUMS"][$propValue];	
					}
					$arProps[$arProp["CODE"]] = implode(" / ", $arTmp);
				} else {
					$arProps[$arProp["CODE"]] = $arProp["ENUMS"][$arPropFromPost];
				}

				$arElementProps[$arProp["CODE"]] = $arPropFromPost;

			} else {
				$arProps[$arProp["CODE"]] = \Bitrix\Main\Text\Encoding::convertEncodingToCurrent(strip_tags(trim($arPropFromPost)));

				$arElementProps[$arProp["CODE"]] = \Bitrix\Main\Text\Encoding::convertEncodingToCurrent(strip_tags(trim($arPropFromPost)));									
			}
		}
	}

    //file proccess
    if(is_array($_FILES)){
        foreach($arResult["IBLOCK"]["PROPERTIES"] as $arProp) {
        	if($arProp["PROPERTY_TYPE"] == "F") {

                $arFiles = array();
                $bMultiple = $arProp["MULTIPLE"] === "Y";

                if (isset($_FILES[$arProp["CODE"]]) && !$bMultiple) {
                    $arFiles[$arProp["CODE"]] = $_FILES[$arProp["CODE"]];
                } elseif ($bMultiple) {
                    foreach ($_FILES as $key => $arFile) {
                        if (strpos($key, '_n') !== false) {
                            if (is_numeric(str_replace(array($arProp["CODE"], '_', 'n'), '', $key))) {
                                $arFiles[$key] = $_FILES[$key];
                            }
                        }
                    }
                }

                if($arFiles){
                    foreach($arFiles as $key => $arFile){
                        if($arFile['name']){
                            if($arFile['error']){
                                $arResult["ERROR_MESSAGE"][] = GetMessage('FORM_FILE_UPLOAD_ERROR').$arFile['name'];
                            } else{
                                $code = explode('_', $key);
                                $tmp = $code[$cntCode - 1];
                                $arElementProps[$arProp["CODE"]][($tmp ? $tmp : count($arElementProps[$arProp["CODE"]]))] = $arFile;
                            }
                        }
                    }
                }
            }
        }
    }
	
	//NEW_ELEMENT//
	if(count($arResult["ERROR_MESSAGE"]) <= 0){
		$el = new CIBlockElement;

		$arFields = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
			"NAME" => Loc::getMessage("IBLOCK_ELEMENT_NAME").ConvertTimeStamp(time(), "FULL", SITE_ID),
			"PROPERTY_VALUES" => isset($arElementProps) && !empty($arElementProps) ? $arElementProps : array(),
		);

		if($resultID = $el->Add($arFields)) {

			$arResult["SUCCESS_MESSAGE"][] = Loc::getMessage("SUCCESS_MESSAGE")."<br />";	

			//MAIL_EVENT//
			$eventName = "MD_FORM_".$arResult["IBLOCK"]["CODE"];

			$eventDesc = "";
			$messBody = "";

			foreach($arResult["IBLOCK"]["PROPERTIES"] as $key => $arProp) {
				$eventDesc .= "#".$arProp["CODE"]."# - ".$arProp["NAME"]."\n";
				$messBody .= $arProp["NAME"].": "."#".$arProp["CODE"]."#\n";
			}

			$eventDesc .= GetMessage("MAIL_EVENT_DESCRIPTION");

			//MAIL_EVENT_TYPE//
			$arEvent = CEventType::GetByID($eventName, LANGUAGE_ID)->Fetch();
			if(empty($arEvent)) {
				$et = new CEventType;
				$arEventFields = array(
					"LID" => LANGUAGE_ID,
					"EVENT_NAME" => $eventName,
					"NAME" => GetMessage("MAIL_EVENT_TYPE_NAME")." \"".$arResult["IBLOCK"]["NAME"]."\"",
					"DESCRIPTION" => $eventDesc
				);
				$et->Add($arEventFields);
			}

			//MAIL_EVENT_MESSAGE//
			$arMess = CEventMessage::GetList($by = "site_id", $order = "desc", array("TYPE_ID" => $eventName))->Fetch();
			if(empty($arMess)) {
				$em = new CEventMessage;
				$arMess = array();
				$arMess["ID"] = $em->Add(
					array(
						"ACTIVE" => "Y",
						"EVENT_NAME" => $eventName,
						"LID" => SITE_ID,
						"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
						"EMAIL_TO" => "#DEFAULT_EMAIL_FROM#",
						"BCC" => "",
						"SUBJECT" => GetMessage("MAIL_EVENT_MESSAGE_SUBJECT"),
						"BODY_TYPE" => "text",
						"MESSAGE" => GetMessage("MAIL_EVENT_MESSAGE_MESSAGE_HEADER").$messBody.GetMessage("MAIL_EVENT_MESSAGE_MESSAGE_FOOTER")
					)
				);
			}

			//PREPARE LINKS TO FILES FOR EMAIL
            foreach($arResult["IBLOCK"]["PROPERTIES"] as $arProp) {
                if($arProp["PROPERTY_TYPE"] == "F") {
                    $dbRes = CIBlockElement::GetList(
                        array(),
                        array('ID' => $resultID, 'IBLOCK_ID' => $arParams["IBLOCK_ID"]),
                        false,
                        false,
                        array('ID', 'PROPERTY_'.$arProp['CODE'])
                    );

                    while($arItem = $dbRes->Fetch()){
                        if($arItem['PROPERTY_'.strtoupper($arProp['CODE']).'_VALUE']){
                            $filePath = CFile::GetPath($arItem['PROPERTY_'.strtoupper($arProp['CODE']).'_VALUE']);
                            $fileSize = filesize($_SERVER['DOCUMENT_ROOT'].$filePath);
                            $fileLink = (CMain::IsHTTPS() ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$filePath;
                            $format = 0;
                            $formats = array(
                                GetMessage('FORM_CT_NAME_b'),
                                GetMessage('FORM_CT_NAME_KB'),
                                GetMessage('FORM_CT_NAME_MB'),
                                GetMessage('FORM_CT_NAME_GB'),
                                GetMessage('FORM_CT_NAME_TB')
                            );
                            while($fileSize > 1024 && count($formats) != ($format + 1)){
                                ++$format;
                                $fileSize = round($fileSize / 1024, 1);
                            }
                            $arProps[$arProp['CODE']][] = GetMessage('FORM_CT_NAME_SIZE').$fileSize.$formats[$format].'. '.GetMessage('FORM_CT_NAME_LINK').$fileLink;
                        }
                    }
                    $arProps[$arProp['CODE']] = (count($arProps[$arProp['CODE']]) > 1 ? "\n" : '').implode("\n", $arProps[$arProp['CODE']]);
                }
            }


			//SEND_MAIL//
			$arProps["FORM_NAME"] = $arResult["IBLOCK"]["NAME"];

			Event::send(array(
				"EVENT_NAME" => $eventName,
				"LID" => SITE_ID,
				"C_FIELDS" => $arProps,
			));			

		} else {
			$arResult["ERROR_MESSAGE"][] = Loc::getMessage("ERROR_MESSAGE")."<br />".$el->LAST_ERROR;		
		}
	}

	//\Bitrix\Main\Diag\Debug::dumpToFile($_REQUEST);
	
}

/*
if($arParams["MODULE_OPTIONS"]["FORMS_USE_CAPTCHA"] == 'Y' && $arParams["MODULE_OPTIONS"]["CAPTCHA_TYPE"] == 'GOOGLE_RECAPTCHA'){
    $recaptchaSrc = "https://www.google.com/recaptcha/api.js?render=explicit&hl=".LANGUAGE_ID;
    ?>
    <script type="text/javascript">
        if(typeof grecaptcha === 'undefined'){
            var script = document.createElement('script');
            script.src = '<?=$recaptchaSrc?>';
            (document.head || document.documentElement).appendChild(script);
        }
    </script>
    <?
}
*/
$this->IncludeComponentTemplate();
?>