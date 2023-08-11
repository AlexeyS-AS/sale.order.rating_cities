<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * string $templateFolder
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Localization\Loc;

if (empty($arResult['ITEMS'])) return;
?>
<div class="sale-order-rating-cities">
    <?php if (!empty($arParams['TITLE'])): ?>
        <div class="sale-order-rating-cities-title"><?= $arParams['TITLE'] ?></div>
    <?php endif; ?>
    <div class="sale-order-rating-cities-items">
        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
            <div class="sale-order-rating-cities-item">
                <span class="sale-order-rating-cities-item-name">
                    <?= $arItem['NAME'] ?>
                </span>
                <?php if ($arItem['WEIGHT'] > 100): ?>
                    <span class="sale-order-rating-cities-item-weight">
                        <?= (round($arItem['WEIGHT']/1000*100)/100) ?>
                        <?= Loc::getMessage('SOR_CITIES_WEIGHT_KG') ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>