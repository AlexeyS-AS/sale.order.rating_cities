<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader,
    \Bitrix\Main\Type\Date,
    \Bitrix\Main\Entity,
    \Bitrix\Sale\Order;

if (!Loader::IncludeModule("sale")) {
    ShowError(GetMessage("SALE_MODULE_NOT_INSTALL"));
    return;
}

// Проверка и инициализация входных параметров
$arParams['PERSON_TYPE_ID'] = (!empty($arParams['PERSON_TYPE_ID']) ? intval($arParams['PERSON_TYPE_ID']) : 0);
$arParams['PERIOD'] = ($arParams['PERIOD'] ?: 'LAST_WEEK');
$arParams['STATUS_ID'] = ($arParams['STATUS_ID'] ?: '');
$arParams['PAYED'] = ($arParams['PAYED'] ?: '');
$arParams['LIMIT'] = (!empty($arParams['LIMIT']) ? intval($arParams['LIMIT']) : 10);

if ($this->StartResultCache()) {
    
    $arResult = [
        'ITEMS' => []
    ];

    // Период
    $rangeStart = new Date();
    $rangeEnd = new Date();
    switch ($arParams['PERIOD']) {
        case 'LAST_WEEK':
            // За прошлую неделю
            $rangeStart->add('Monday last week');
            $rangeEnd->add('Sunday last week');
            break;
        default:
            // За 7 дней
            $rangeStart->add('-7 day');
    }
    
    $arFilter = [
        // По текущему сайту
        'LID' => SITE_ID,
        // Отбор по городам
        '=PROPERTY_CITY.CODE' => 'CITY',
        // За период
        '>=DATE_INSERT' => $rangeStart,
        '<=DATE_INSERT' => $rangeEnd,
        // Не отмененные
        'CANCELED' => 'N',
    ];
    
    // Типа плательщика
    if (!empty($arParams['PERSON_TYPE_ID'])) {
        $arFilter['PERSON_TYPE_ID'] = $arParams['PERSON_TYPE_ID'];
    }
    
    // Статус
    if (!empty($arParams['STATUS_ID'])) {
        $arFilter['STATUS_ID'] = $arParams['STATUS_ID'];
    }

    // Оплачен
    if (!empty($arParams['PAYED'])) {
        $arFilter['PAYED'] = ($arParams['PAYED'] == 'Y' ? 'Y' : 'N');
    }
    
    $dbRes = Order::getList([
        'select' => ['NAME', 'WEIGHT'],
        'filter' => $arFilter,
        'runtime' => [
            new Entity\ReferenceField(
                'PROPERTY_CITY',
                '\Bitrix\sale\Internals\OrderPropsValueTable',
                ["=this.ID" => "ref.ORDER_ID"],
                ["join_type" => "left"]
            ),
            new Entity\ReferenceField(
                'SHIPMENT',
                '\Bitrix\sale\Internals\ShipmentTable',
                ["=this.ID" => "ref.ORDER_ID"],
                ["join_type" => "left"]
            ),
            new Entity\ExpressionField(
                'WEIGHT',
                'SUM(%s)',
                ['SHIPMENT.WEIGHT']
            ),
            new Entity\ExpressionField(
                'NAME',
                '%s',
                ['PROPERTY_CITY.VALUE']
            ),
        ],
        'order' => ['WEIGHT' => 'DESC'],
        'limit' => ($arParams['LIMIT'] > 0 ? $arParams['LIMIT'] : 10),
    ]);
    
    while ($arItem = $dbRes->fetch()) {
        $arResult['ITEMS'][] = $arItem;
    }
    
    if (empty($arResult['ITEMS']))
        $this->AbortResultCache();
    
    // Подключить шаблон вывода
    $this->IncludeComponentTemplate();
}
