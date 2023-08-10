<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$arTemplateParameters['TITLE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('SOR_CITIES_PARAMS_TITLE'),
    'TYPE' => 'TEXT',
    'DEFAULT' => Loc::getMessage('SOR_CITIES_PARAMS_TITLE_DEF'),
);
