# sale.order.rating_cities
Bitrix Order ORM. 
Вывод рейтинга городов, куда были отправлены заказы

Вызов

``<?$APPLICATION->IncludeComponent("mwi:sale.order.rating_cities", "", Array(
        'TITLE' => 'Сорта недели:',
        'PERSON_TYPE_ID' => 2,
        'PERIOD' =>  'LAST_WEEK',
        'STATUS_ID' => [],
        'PAYED' => '',
    ),
    false
);?>
``
