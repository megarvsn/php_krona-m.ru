<?
if (!CModule::IncludeModule("iblock"))
    return;

$redirect = array();

$dbElement = CIBlockElement::GetList(
    Array(),
    Array("IBLOCK_CODE" => "redirects", "ACTIVE" => "Y"),
    false,
    false,
    Array(
        "NAME",
        "PROPERTY_UP_URL_SOURCE"
    )
);

while ($arElement = $dbElement->GetNext()) {
    $redirect[$arElement["PROPERTY_UP_URL_SOURCE_VALUE"]] = $arElement["NAME"];
}

if (isset($redirect[$_SERVER['REQUEST_URI']])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $redirect[$_SERVER['REQUEST_URI']]);
    exit();
}