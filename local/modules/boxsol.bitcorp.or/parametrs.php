<?
$moduleClass = "CBitcorp";
$moduleID = "boxsol.bitcorp";
IncludeModuleLangFile(__FILE__);

//module default parametrs array
$moduleClass::initParametrs(
	array(
		"MAIN" => array(
			"TITLE" => GetMessage("MAIN_OPTIONS"),
			"OPTIONS" => array(
				"SHOW_SETTINGS_PANEL" => array(
					"TITLE" => GetMessage("SHOW_SETTINGS_PANEL"),
					"TYPE" => "checkbox",
					"DEFAULT" => "N",
					"IN_SETTINGS_PANEL" => "N",
					"HINT" => GetMessage("SHOW_SETTINGS_PANEL_HINT"),
				),
				"COLOR_SCHEME" => array(
					"TITLE" => GetMessage("COLOR_SCHEME"), 
					"TYPE" => "selectbox", 
					"LIST" => array(					
						"BLUE_RED" => array("COLOR_FIRST" => "#0c4da2", "COLOR_SECOND" => "#ed1c24", "TITLE" => GetMessage("COLOR_SCHEME_BLUE_RED")),
						"ORANGE_BLUE" => array("COLOR_FIRST" => "#ff6800", "COLOR_SECOND" => "#0097ff", "TITLE" => GetMessage("COLOR_SCHEME_ORANGE_BLUE")),
						"GREEN_RED" => array("COLOR_FIRST" => "#37b28d", "COLOR_SECOND" => "#f15207", "TITLE" => GetMessage("COLOR_SCHEME_GREEN_RED")),	
						"BLUE_ORANGE" => array("COLOR_FIRST" => "#075ae8", "COLOR_SECOND" => "#ff7f00", "TITLE" => GetMessage("COLOR_SCHEME_BLUE_ORANGE")),
						"BLUE" => array("COLOR_FIRST" => "#1331db", "COLOR_SECOND" => "#1331db", "TITLE" => GetMessage("COLOR_SCHEME_BLUE")),						
						"RED" => array("COLOR_FIRST" => "#ed1c24", "COLOR_SECOND" => "#ed1c24", "TITLE" => GetMessage("COLOR_SCHEME_RED")),									
						"CUSTOM" => array("COLOR" => "", "TITLE" => GetMessage("COLOR_SCHEME_CUSTOM"))
					),
					"DEFAULT" => "BLUE_RED",
					"IN_SETTINGS_PANEL" => "Y",				
				),
				"COLOR_SCHEME_CUSTOM_FIRST" => array(
					"TITLE" => GetMessage("COLOR_SCHEME_CUSTOM_FIRST"), 
					"TYPE" => "text", 
					"DEFAULT" => "#0c4da2",
					"IN_SETTINGS_PANEL" => "Y",
					"HINT" => GetMessage("COLOR_SCHEME_CUSTOM_FIRST_HINT"),
				),
				"COLOR_SCHEME_CUSTOM_SECOND" => array(
					"TITLE" => GetMessage("COLOR_SCHEME_CUSTOM_SECOND"), 
					"TYPE" => "text", 
					"DEFAULT" => "#ed1c24",
					"IN_SETTINGS_PANEL" => "Y",
					"HINT" => GetMessage("COLOR_SCHEME_CUSTOM_SECOND_HINT"),
				),
				"LOGO_WITHBG" => array(
					"TITLE" => GetMessage("LOGO_WITHBG"),
					"TYPE" => "checkbox",
					"DEFAULT" => "Y",
					"IN_SETTINGS_PANEL" => "N"
				),
				"LOGO_IMAGE" => array(
					"TITLE" => GetMessage("LOGO_IMAGE"),
					"TYPE" => "file",
					"DEFAULT" => "",				
					"IN_SETTINGS_PANEL" => "N"
				),
				"FAVICON_IMAGE" => array(
					"TITLE" => GetMessage("FAVICON_IMAGE"),
					"TYPE" => "file",
					"DEFAULT" => "",				
					"IN_SETTINGS_PANEL" => "N",
					"HINT" => GetMessage("FAVICON_IMAGE_HINT"),
				),
				"FONT_MAIN" => array(
					"TITLE" => GetMessage("FONT_MAIN"), 
					"TYPE" => "selectbox", 
					"LIST" => array(					
						"Open+Sans" => GetMessage("FONT_OPEN_SANS"),
						"Ubuntu" => GetMessage("FONT_UBUNTU"),
						"Roboto" => GetMessage("FONT_ROBOTO"),
						"Roboto+Condensed" => GetMessage("FONT_ROBOTO_CONDENSED"),						
						"Montserrat" => GetMessage("FONT_MONTSERRAT"),						
						"PT+Sans" => GetMessage("FONT_PT_SANS"),
						"Merriweather" => GetMessage("FONT_MERRIWEATHER"),
						"Roboto+Slab" => GetMessage("FONT_ROBOTO_SLAB"),
						"Fira+Sans" => GetMessage("FONT_FIRA_SANS"),
						"Rubik" => GetMessage("FONT_RUBIK"),
						"Lobster" => GetMessage("FONT_LOBSTER"),
						"Comfortaa" => GetMessage("FONT_COMFORTAA"),
						"Cuprum" => GetMessage("FONT_CUPRUM"),
						"Philosopher" => GetMessage("FONT_PHILOSOPHER"),
						"Neucha" => GetMessage("FONT_NEUCHA"),
						"Raleway" => GetMessage("FONT_RALEWAY"),
					),
					"DEFAULT" => "Open+Sans",
					"IN_SETTINGS_PANEL" => "Y"
				),
				"FONT_SECOND" => array(
					"TITLE" => GetMessage("FONT_SECOND"), 
					"TYPE" => "selectbox", 
					"LIST" => array(
						"Raleway" => GetMessage("FONT_RALEWAY"),					
						"Open+Sans" => GetMessage("FONT_OPEN_SANS"),
						"Ubuntu" => GetMessage("FONT_UBUNTU"),
						"Roboto" => GetMessage("FONT_ROBOTO"),
						"Roboto+Condensed" => GetMessage("FONT_ROBOTO_CONDENSED"),						
						"Montserrat" => GetMessage("FONT_MONTSERRAT"),						
						"PT+Sans" => GetMessage("FONT_PT_SANS"),
						"Merriweather" => GetMessage("FONT_MERRIWEATHER"),
						"Roboto+Slab" => GetMessage("FONT_ROBOTO_SLAB"),
						"Fira+Sans" => GetMessage("FONT_FIRA_SANS"),
						"Rubik" => GetMessage("FONT_RUBIK"),
						"Lobster" => GetMessage("FONT_LOBSTER"),
						"Comfortaa" => GetMessage("FONT_COMFORTAA"),
						"Cuprum" => GetMessage("FONT_CUPRUM"),
						"Philosopher" => GetMessage("FONT_PHILOSOPHER"),
						"Neucha" => GetMessage("FONT_NEUCHA"),						
					),
					"DEFAULT" => "Raleway",
					"IN_SETTINGS_PANEL" => "Y"
				),
				"HEADER_TYPE" => array(
					"TITLE" => GetMessage("HEADER_TYPE"), 
					"TYPE" => "selectbox", 
					"LIST" => array(					
						"FIRST" => GetMessage("HEADER_TYPE_FIRST"),
						"SECOND" => GetMessage("HEADER_TYPE_SECOND"),
					),
					"DEFAULT" => "FIRST",
					"IN_SETTINGS_PANEL" => "Y"
				),
				"FIX_TOP_MENU" => array(
					"TITLE" => GetMessage("FIX_TOP_MENU"),
					"TYPE" => "checkbox",
					"DEFAULT" => "Y",
					"IN_SETTINGS_PANEL" => "N"
				),
				"MENU_TYPE" => array(
					"TITLE" => GetMessage("MENU_TYPE"), 
					"TYPE" => "selectbox", 
					"LIST" => array(					
						"WHITE" => GetMessage("MENU_TYPE_WHITE"),
						"DEFAULT" => GetMessage("MENU_TYPE_COLOR_FIRST"),
                        "ACCENT" => GetMessage("MENU_TYPE_COLOR_SECOND"),
						"BLACK" => GetMessage("MENU_TYPE_DARK"),
                        "GRADIENT" => GetMessage("MENU_TYPE_GRADIENT"),
					),
					"DEFAULT" => "DEFAULT",
					"IN_SETTINGS_PANEL" => "Y",
					"HINT" => GetMessage("MENU_TYPE_HINT"),
				),
				"MENU_TEXT_CASE" => array(
					"TITLE" => GetMessage("MENU_TEXT_CASE"), 
					"TYPE" => "selectbox", 
					"LIST" => array(					
						"CAPITALIZE" => GetMessage("MENU_TEXT_CASE_CAPITALIZE"),
						"UPPERCASE" => GetMessage("MENU_TEXT_CASE_UPPERCASE"),												
					),
					"DEFAULT" => "CAPITALIZE",
					"IN_SETTINGS_PANEL" => "Y",					
				),
                "BUTTONS_STYLE" => array(
                    "TITLE" => GetMessage("BUTTONS_STYLE"),
                    "TYPE" => "selectbox",
                    "LIST" => array(
                        "1" => GetMessage("BUTTONS_STYLE_TITLE_1"),
                        "2" => GetMessage("BUTTONS_STYLE_TITLE_2"),
                        "3" => GetMessage("BUTTONS_STYLE_TITLE_3"),
                        "4" => GetMessage("BUTTONS_STYLE_TITLE_4"),
                    ),
                    "DEFAULT" => "4",
                    "IN_SETTINGS_PANEL" => "Y",
                ),
                "TEMPLATE_ELEMENTS_STYLE" => array(
                    "TITLE" => GetMessage("TEMPLATE_ELEMENTS_STYLE"),
                    "TYPE" => "selectbox",
                    "LIST" => array(
                        "1" => GetMessage("TEMPLATE_ELEMENTS_STYLE_1"),
                        "2" => GetMessage("TEMPLATE_ELEMENTS_STYLE_2"),
                        "3" => GetMessage("TEMPLATE_ELEMENTS_STYLE_3"),
                        "4" => GetMessage("TEMPLATE_ELEMENTS_STYLE_4"),
                    ),
                    "DEFAULT" => "2",
                    "IN_SETTINGS_PANEL" => "Y",
                ),
                "FOOTER_STYLE" => array(
                    "TITLE" => GetMessage("FOOTER_STYLE"),
                    "TYPE" => "selectbox",
                    "LIST" => array(
                        "DEFAULT" => GetMessage("FOOTER_STYLE_DEFAULT"),
                        "ACCENT" => GetMessage("FOOTER_STYLE_ACCENT"),
                        "DARK" => GetMessage("FOOTER_STYLE_DARK"),
                        "LIGHT" => GetMessage("FOOTER_STYLE_LIGHT"),
                        "GRADIENT" => GetMessage("FOOTER_STYLE_GRADIENT"),
                    ),
                    "DEFAULT" => "DEFAULT",
                    "IN_SETTINGS_PANEL" => "Y",
                ),
				"SERVICES_TYPE" => array(
					"TITLE" => GetMessage("SERVICES_TYPE"),
					"TYPE" => "selectbox",
					"LIST" => array(
						"SERVICES" => GetMessage("SERVICES_TYPE_SERVICES_FIRST"),
						"SERVICES_SECOND" => GetMessage("SERVICES_TYPE_SERVICES_SECOND"),						
					),
					"DEFAULT" => "SERVICES",
					"IN_SETTINGS_PANEL" => "Y",					
				),
                "USE_SERVICES_WITH_SECTION" => array(
                    "TITLE" => GetMessage("USE_SERVICES_WITH_SECTION"),
                    "TYPE" => "checkbox",
                    "DEFAULT" => "Y",
                    "IN_SETTINGS_PANEL" => "N"
                ),
				"PROJECTS_TYPE" => array(
					"TITLE" => GetMessage("PROJECTS_TYPE"),
					"TYPE" => "selectbox",
					"LIST" => array(
						"PROJECTS" => GetMessage("SERVICES_TYPE_PROJECTS_FIRST"),
						"PROJECTS_SECOND" => GetMessage("SERVICES_TYPE_PROJECTS_SECOND"),						
					),
					"DEFAULT" => "PROJECTS",
					"IN_SETTINGS_PANEL" => "Y",					
				),
                "USE_SEARCH" => array(
                    "TITLE" => GetMessage("USE_SEARCH"),
                    "TYPE" => "selectbox",
                    "LIST" => array(
                        "Y" => GetMessage("USE_SEARCH_YES"),
                        "N" => GetMessage("USE_SEARCH_NO"),
                    ),
                    "DEFAULT" => "Y",
                    "IN_SETTINGS_PANEL" => "Y",
                ),
				"HOME_PAGE" => array(
					"TITLE" => GetMessage("HOME_PAGE"),
					"TYPE" => "multiselectbox",
					"LIST" => array(
						"ADVANTAGES" => GetMessage("HOME_PAGE_ADVANTAGES"),
						"SERVICES" => GetMessage("HOME_PAGE_SERVICES"),
						"CATALOG" => GetMessage("HOME_PAGE_CATALOG"),
						"CATALOG_SECTIONS" => GetMessage("HOME_PAGE_CATALOG_SECTIONS"),
						"PROJECTS" => GetMessage("HOME_PAGE_PROJECTS"),
						"COMPANY" => GetMessage("HOME_PAGE_COMPANY"),
						"TEAM" => GetMessage("HOME_PAGE_TEAM"),
						"REVIEWS" => GetMessage("HOME_PAGE_REVIEWS"),
						"NEWS" => GetMessage("HOME_PAGE_NEWS"),
						"PARTNERS" => GetMessage("HOME_PAGE_PARTNERS")
					),
					"DEFAULT" => array("ADVANTAGES","SERVICES", "CATALOG", "CATALOG_SECTIONS", "PROJECTS", "COMPANY", "TEAM", "REVIEWS", "NEWS", "PARTNERS"),
					"IN_SETTINGS_PANEL" => "Y",
					"HINT" => GetMessage("HOME_PAGE_HINT"),
				),		
				
			)
		),	
		"FORMS" => array(
			"TITLE" => GetMessage("FORMS_OPTIONS"),
			"OPTIONS" => array(			
				"FORMS_USE_CAPTCHA" => array(
					"TITLE" => GetMessage("FORMS_USE_CAPTCHA"),
					"TYPE" => "checkbox",
					"DEFAULT" => "Y",
					"IN_SETTINGS_PANEL" => "N"
				),
                "CAPTCHA_TYPE" => array(
                    "TITLE" => GetMessage("FORMS_CAPTCHA_TYPE"),
                    "TYPE" => "selectbox",
                    "LIST" => array(
                        "BITRIX_CAPTCHA" => GetMessage("FORMS_CAPTCHA_TYPE_BITRIX"),
                        "GOOGLE_RECAPTCHA" => GetMessage("FORMS_CAPTCHA_TYPE_GOOGLE"),
                    ),
                    "DEFAULT" => "BITRIX_CAPTCHA",
                    "IN_SETTINGS_PANEL" => "N",
                ),
                "RECAPTCHA_SITE_KEY" => array(
                    "TITLE" => GetMessage("FORMS_RECAPTCHA_SITE_KEY"),
                    "TYPE" => "text",
                    "DEFAULT" => "",
                    "IN_SETTINGS_PANEL" => "N"
                ),
                "RECAPTCHA_SECRET_KEY" => array(
                    "TITLE" => GetMessage("FORMS_RECAPTCHA_SECRET_KEY"),
                    "TYPE" => "text",
                    "DEFAULT" => "",
                    "IN_SETTINGS_PANEL" => "N",
                    "HINT" => GetMessage("GOOGLE_RECAPTCHA_HINT"),
                ),
				"FORMS_PHONE_MASK" => array(
					"TITLE" => GetMessage("FORMS_PHONE_MASK"),				
					"TYPE" => "text",
					"DEFAULT" => "+7 (999) 999-99-99",
					"IN_SETTINGS_PANEL" => "N"				
				),
				"FORMS_VALIDATE_PHONE_MASK" => array(
					"TITLE" => GetMessage("FORMS_VALIDATE_PHONE_MASK"),
					"TYPE" => "text",
					"SIZE" => "40",
					"DEFAULT" => "^[+][0-9] [(][0-9]{3}[)] [0-9]{3}[-][0-9]{2}[-][0-9]{2}$",
					"IN_SETTINGS_PANEL" => "N"
				),			
			)
		),
		"PERSONAL_DATA" => array(
			"TITLE" => GetMessage("PERSONAL_DATA"),
			"OPTIONS" => array(
				"SHOW_PERSONAL_DATA" => array(
					"TITLE" => GetMessage("PERSONAL_DATA_SHOW_PERSONAL_DATA"),
					"TYPE" => "checkbox",
					"DEFAULT" => "Y",
					"IN_SETTINGS_PANEL" => "N"
				),
				"TEXT_PERSONAL_DATA" => array(
					"TITLE" => GetMessage("PERSONAL_DATA_TEXT_PERSONAL_DATA"),				
					'TYPE' => 'includefile',
					'INCLUDEFILE' => '#SITE_DIR#include/license.php',
					"COLS" => "50",
					"ROWS" => "5",
					"DEFAULT" => GetMessage("DEFAULT_PERSONAL_DATA_TEXT"),
					"IN_SETTINGS_PANEL" => "N"
				)
			)
		)
	)
);?>