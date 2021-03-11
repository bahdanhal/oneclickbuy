<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "ELEMENT_NUMBER" => array(
            "NAME" => "Номер товара",
            "TYPE" => "STRING",
        ),
        "PERSON_TYPE" => array(
            "NAME" => "ID типа покупателя",
            "TYPE" => "STRING",
            "DEFAULT" => "1",
        ),
        "DELIVERY" => array(
            "NAME" => "ID способа доставки",
            "TYPE" => "STRING",
            "DEFAULT" => "1",
        ),        
        "PAYSYSTEM" => array(
            "NAME" => "ID платежной системы",
            "TYPE" => "STRING",
            "DEFAULT" => "1",
        ),
    ),
);
?>