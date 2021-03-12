<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
$component = ob_get_contents();
ob_start();
$APPLICATION->IncludeComponent(
	"custom:oneclickbuy",
	"",
	Array(
		"ELEMENT_NUMBER" => "",
		"PERSON_TYPE" => "1",
		"DELIVERY" => "1",
		"PAYSYSTEM" => "1"
	)
);
echo $component;
flush();
?>