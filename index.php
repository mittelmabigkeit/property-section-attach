<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
CModule::IncludeModule('iblock');

$arFilter = array(
	'IBLOCK_ID' => 69
);

$res = CIBlockElement::GetList(false, $arFilter, array('IBLOCK_ID','ID'));

while($el = $res->GetNext()):
	$arElementsID[] = $el['ID'];
endwhile;

foreach($arElementsID as $key):
	$ELEMENT_ID = $key;
	$res = CIBlockElement::GetByID($ELEMENT_ID);
	if($arRes = $res->Fetch())
	{
		$res = CIBlockSection::GetByID($arRes["IBLOCK_SECTION_ID"]);
		if($arRes = $res->Fetch())
		{
			$list = CIBlockSection::GetNavChain(false,$arRes['ID'], array(), true);
			foreach ($list as $arSectionPath){
				if($arSectionPath['DEPTH_LEVEL'] == 1):
					$TYPE_OF_EQUIPMENT = $arSectionPath['NAME'];
				endif;
				if($arSectionPath['DEPTH_LEVEL'] == 2):
					$TYPE_OF_EQUIPMENT_TWO = $arSectionPath['NAME'];
				endif;
				if($arSectionPath['DEPTH_LEVEL'] == 3):
					$SUBTYPE = $arSectionPath['NAME'];
				endif;
			}
		}
	}
	$cbe = new CIBlockElement;
		$cbe -> SetPropertyValuesEx($ELEMENT_ID, 69, array('TYPE_OF_EQUIPMENT' => $TYPE_OF_EQUIPMENT, 'TYPE_OF_EQUIPMENT_TWO' => $TYPE_OF_EQUIPMENT_TWO, 'SUBTYPE' => $SUBTYPE));
		if($cbe):
			echo "OK!<br>";
		else:
			echo "Ошибка!<br>";
	endif;
	$TYPE_OF_EQUIPMENT = '';
	$TYPE_OF_EQUIPMENT_TWO = '';
	$SUBTYPE = '';
endforeach;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>