<?
$basket = new Basket;
echo General::renderTemplate('header.html',['title' => 'pizzaAPP','basket'=>$basket->getTemp(),'page' => $_SERVER['REQUEST_URI']]);