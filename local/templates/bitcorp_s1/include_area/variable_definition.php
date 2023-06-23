<?php
/************************************************************************************
Класс LoadProperty находится в файле /bitrix/php_interface/include/LoadProperty.php
 ************************************************************************************/

// SEO коды
LoadProperty::setIblock('seo-codes');
LoadProperty::setSection('');
$arSEO = LoadProperty::m_LoadProperty();
$codeHead = $arSEO["code-head"]["HTML"];
$codeBody = $arSEO["code-body"]["HTML"];
$codeCloseBody = $arSEO["code-close-body"]["HTML"];
$schemaOrgAddress = $arSEO["schema-org-address"]["HTML"];

// Контактная информация
LoadProperty::setIblock('contacts');
LoadProperty::setSection('');
$arContacts = LoadProperty::m_LoadProperty();
$address = $arContacts["address"]["HTML"];
$phoneName = $arContacts["phone"]["NAME"];
$phone = $arContacts["phone"]["HTML"];
$emailName = $arContacts["email"]["NAME"];
$email = $arContacts["email"]["HTML"];
$work = $arContacts["work-time-office"]["HTML"];
$slogan = $arContacts["slogan"]["HTML"];
$rights = $arContacts["all-rights"]["HTML"];

LoadProperty::setIblock('requisites');
LoadProperty::setSection('');
$arCompany = LoadProperty::m_LoadProperty();
$company = $arCompany["sokrashchennoe-naimenovanie"]["HTML"];