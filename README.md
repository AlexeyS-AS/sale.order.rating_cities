# sale.order.rating_cities
Bitrix Order ORM.
## Вывод топ городов, куда были отправлены заказы. Учет по весу заказа.

**Вызов**

````
<?$APPLICATION->IncludeComponent("mwi:sale.order.rating_cities", "", Array(
        'TITLE' => 'Города недели:',
        'PERSON_TYPE_ID' => [1],
        'PERIOD' =>  'LAST_WEEK',
        'STATUS_ID' => ['F'],
        'PAYED' => 'Y',
        'COUNT' => 10,
    ),
    false
);?>
````
