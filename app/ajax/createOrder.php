<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog_before.php');

$order = new Order();
$userArr = [
    'first_name'    => $_POST['first_name'],
    'last_name'     => $_POST['last_name'],
    'address'       => $_POST['address'],
    'description'   => $_POST['description'],
    'phone'         => $_POST['phone']
];
$order->description = serialize($userArr);
$order->basket_id = $_POST['bid'];
$order->delivery = $_POST['delivery'];
$order->total_price = $_POST['total_price'];

if($new_order = $order->save()) {
    $basket = Basket::find_by_id($order->basket_id);
    $basket->completed = 'Y';
    $basket->save();
    echo $new_order;
} else
    echo 'we have some problems with your order. Please, try again or contact us!';

