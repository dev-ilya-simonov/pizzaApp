<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog_before.php');

$basket = new Basket;
$tempBasket = $basket->getTemp();
print_r($tempBasket);
$basket->items = json_encode($tempBasket['items']);
$basket->total = json_encode($tempBasket['total']);
/*
if($newID = $basket->save()) {
    setcookie("basket", '', time()-3600*3,'/');  // cookie set to 3 hours
    echo $newID;
} else
    echo 'Ups! it seems that something went wrong... Please, try again later!';
