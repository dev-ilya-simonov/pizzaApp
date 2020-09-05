<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog_before.php');

$basket = new Basket;
$delivery = new Delivery;

$basketObj = $basket::find_by_id($_POST['bid']);
$arResult = [];

$choosenDelivery = $_POST['delivery'];
$arResult['id'] = $_POST['bid'];
$arResult['user'] = [
    'first_name'    => $_POST['first_name'],
    'last_name'     => $_POST['last_name'],
    'address'       => $_POST['address'],
    'description'   => $_POST['description'],
    'phone'         => $_POST['phone']
];

foreach(json_decode($basketObj->items) as $k => $arItem):
    $arResult['items'][$arItem->id]['id'] = $arItem->id;
    $arResult['items'][$arItem->id]['title'] = $arItem->title;
    $arResult['items'][$arItem->id]['pic'] = $arItem->pic;
    $arResult['items'][$arItem->id]['price'] = General::currencyFormat($arItem->price).' | '.General::currencyFormat($arItem->price,'eur');
    $arResult['items'][$arItem->id]['cnt'] = $arItem->cnt;
endforeach;
$arResult['sub_total']['value'] = $basketObj->total;
$arResult['sub_total']['#formatted'] = General::currencyFormat($basketObj->total).' | '.General::currencyFormat($basketObj->total,'eur');

$deliveries = $delivery->find('all');
foreach($deliveries as $k => $arItem):
    $arResult['deliveries'][$k]['id'] = $arItem->id;
    $arResult['deliveries'][$k]['title'] = $arItem->title;
    $arResult['deliveries'][$k]['description'] = $arItem->description;
    $arResult['deliveries'][$k]['price']['value'] = $arItem->price;
    $arResult['deliveries'][$k]['price']['#formatted'] = General::currencyFormat($arItem->price).' | '.General::currencyFormat($arItem->price,'eur');
    if($arItem->id == $choosenDelivery) 
        $arResult['checked_delivery'] = $arResult['deliveries'][$k];
endforeach;

$total = round($basketObj->total + $arResult['checked_delivery']['price']['value'],2);
$arResult['total']['value'] = $total;
$arResult['total']['#formatted'] = General::currencyFormat($total).' | '.General::currencyFormat($total,'eur');

echo General::renderTemplate('/templates/checkout/checkout_page.html',['basket'=>$arResult]);