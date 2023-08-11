<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("SOR_CITIES_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("SOR_CITIES_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"PATH" => array(
        "ID" => "e-store",
        "CHILD" => array(
            "ID" => "sale_order_rating",
            "NAME" => GetMessage("SOR_NAME"),
        )
	),
);
