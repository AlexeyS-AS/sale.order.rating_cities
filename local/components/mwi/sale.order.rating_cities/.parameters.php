<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

// Получить статусы заказов
$arStatuses = [];
$statusResult = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
    'order' => array('STATUS.SORT' => 'ASC'),
    'filter' => array('STATUS.TYPE' => 'O', 'LID' => LANGUAGE_ID),
    'select' => array('STATUS_ID', 'NAME'),
));
while ($arStatus = $statusResult->fetch()) {
    $arStatuses[$arStatus['STATUS_ID']] = '[' . $arStatus['STATUS_ID'] . '] ' . $arStatus['NAME'];
}

// Получить типы плательщиков
$arPersonTypes = [];
$personTypeResult = \Bitrix\Sale\Internals\PersonTypeTable::getList([
    'select' => ['ID', 'NAME', 'LID']
]);
while ($arPersonType = $personTypeResult->fetch()) {
    $arPersonTypes[$arPersonType['ID']] = '[' . $arPersonType['ID'] . '] ' . $arPersonType['NAME'] . ' (' . $arPersonType['LID'] . ')';
}

$arComponentParameters = [
    "PARAMETERS" => [
        'PERSON_TYPE_ID' => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SOR_CITIES_PARAMS_PERSON_TYPE'),
            "TYPE" => "LIST",
            "VALUES" => $arPersonTypes,
            "MULTIPLE" => "Y",
        ],
        'PERIOD' => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SOR_CITIES_PARAMS_PERIOD'),
            "TYPE" => "LIST",
            "VALUES" => [
                'LAST_WEEK' => Loc::getMessage('SOR_CITIES_PARAMS_TITLE'),
            ],
        ],
        'STATUS_ID' => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SOR_CITIES_PARAMS_STATUS'),
            "TYPE" => "LIST",
            "VALUES" => $arStatuses,
            "MULTIPLE" => "Y",
        ],
        'PAYED' => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SOR_CITIES_PARAMS_PAYED'),
            "TYPE" => "LIST",
            "VALUES" => [
                '' => Loc::getMessage('SOR_CITIES_PARAMS_PAYED_ALL'),
                'Y' => Loc::getMessage('SOR_CITIES_PARAMS_PAYED_YES'),
                'N' => Loc::getMessage('SOR_CITIES_PARAMS_PAYED_NO'),
            ],
        ],
        "COUNT" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SOR_CITIES_PARAMS_COUNT'),
            "TYPE" => "STRING",
            "DEFAULT" => "10",
        ],
        "CACHE_TIME" => ["DEFAULT" => 86400],
    ]
];
