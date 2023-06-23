<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Реквизиты");

LoadProperty::setIblock('pages');
LoadProperty::setSection('');
$arHTML = LoadProperty::m_LoadProperty();

echo $arHTML["requisites-text"]["HTML"];
?>
    <div class="table-responsiver">
        <table>
            <thead>
            <tr>
                <th colspan="2">Наши реквизиты</th>
            </tr>
            </thead>
            <tbody>
            <? $dbElement = CIBlockElement::GetList(
                Array("SORT" => "ASC"),
                Array("IBLOCK_CODE" => "requisites", "ACTIVE" => "Y"),
                false,
                false,
                Array("NAME", "PREVIEW_TEXT")
            );

            while ($arElement = $dbElement->GetNext()): ?>
                <tr>
                    <td><b><?= $arElement["NAME"] ?>:</b></td>
                    <td><?= $arElement["PREVIEW_TEXT"] ?></td>
                </tr>

            <? endwhile; ?>
            </tbody>
        </table>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>