<?php

if (!CModule::IncludeModule("iblock"))
    return;

/**
 * Created by PhpStorm.
 * User: yegoshin
 * Date: 30.12.16
 * Time: 14:41
 */
class LoadProperty
{
    static private $pr_iblockValue;
    static private $pr_sectionValue;
    static private $pr_checkIblock = false;
    static private $pr_checkSection = false;

    static private function checkValue()
    {
        if (!self::$pr_checkIblock || !self::$pr_checkSection)
            return false;
        else
            return true;
    }

    static public function setIblock($value)
    {
        if (is_string($value)) {
            self::$pr_iblockValue = $value;
            self::$pr_checkIblock = 'IBLOCK_CODE';
        }
        if (is_int($value)) {
            self::$pr_iblockValue = $value;
            self::$pr_checkIblock = 'IBLOCK_ID';
        }
    }

    static public function setSection($value)
    {
        if (is_string($value)) {
            self::$pr_sectionValue = $value;
            self::$pr_checkSection = 'SECTION_CODE';
        }
        if (is_int($value)) {
            self::$pr_sectionValue = $value;
            self::$pr_checkSection = 'SECTION_ID';
        }
    }
    static public function m_LoadProperty()
    {
        if (!self::checkValue())
            return false;

        $arReturn = array();
        $dbElement = CIBlockElement::GetList(
            Array("SORT" => "ASC"),
            Array(
                self::$pr_checkIblock => self::$pr_iblockValue,
                self::$pr_checkSection => self::$pr_sectionValue,
                "ACTIVE" => "Y"
            ),
            false,
            false,
            Array("CODE", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", "DETAIL_PICTURE", "PROPERTY_UP_FILE")
        );

        while ($arElement = $dbElement->GetNext()) {

            if ($arElement["CODE"])
                $elCode = $arElement["CODE"];
            else
                return false;

            if ($arElement["NAME"])
                $arReturn[$elCode]["NAME"] = $arElement["NAME"];

            if ($arElement["PREVIEW_TEXT"])
                $arReturn[$elCode]["TEXT"] = $arElement["PREVIEW_TEXT"];
            else
                $arReturn[$elCode]["TEXT"] = $arElement["DETAIL_TEXT"];

            if ($arElement["~PREVIEW_TEXT"])
                $arReturn[$elCode]["HTML"] = $arElement["~PREVIEW_TEXT"];
            else
                $arReturn[$elCode]["HTML"] = $arElement["~DETAIL_TEXT"];

            if ($arElement["PREVIEW_PICTURE"])
                $arReturn[$elCode]["PICTURE"] = CFile::GetFileArray($arElement["PREVIEW_PICTURE"]);
            else
                $arReturn[$elCode]["PICTURE"] = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);

            if ($arElement["PROPERTY_UP_FILE_VALUE"])
                $arReturn[$elCode]["FILE"] = CFile::GetFileArray($arElement["PROPERTY_UP_FILE_VALUE"]);

        }
        return $arReturn;
    }
}