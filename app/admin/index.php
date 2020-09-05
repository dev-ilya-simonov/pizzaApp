<?
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog.php');
$user = new User();
?>
<div class="container">
    <h1>Orders</h1>
</div>
<?
if(isset($_POST['login']) && isset($_POST['pass'])) {
    if(!$user->auth($_POST['login'],$_POST['pass']))
        echo '<p class="error" style="color:#ff0000;">Wrong login or password<p>';
}
if(isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'admin'):
    $arResult = [];
    $basket = new Basket();
    $basketObj = $basket->find('all',array('order' => 'id asc'));
    foreach($basketObj as $k => $arItem):
        $arResult['BASKET'][$arItem->id] = $arItem;
    endforeach;
    
    $order = new Order();
    $ordersObj = $order->find('all',array('order' => 'order_date asc'));
    foreach($ordersObj as $k => $arItem):
        $basketOrder = json_decode($arResult['BASKET'][$arItem->basket_id]->items);
        $arResult['ORDERS'][$arItem->id]['ID'] = $arItem->id;
        $arResult['ORDERS'][$arItem->id]['DELIVERY'] = $arItem->delivery;
        $arResult['ORDERS'][$arItem->id]['PRICE']['value'] = $arItem->total_price;
        $arResult['ORDERS'][$arItem->id]['PRICE']['#render'] = General::currencyFormat($arItem->total_price);
        $arResult['ORDERS'][$arItem->id]['DATE'] = date('d.m.Y H:i',strtotime($arItem->order_date));
        $arResult['ORDERS'][$arItem->id]['USER'] = unserialize($arItem->description);
        foreach($basketOrder as $j => $item):
            $arResult['ORDERS'][$arItem->id]['BASKET'][$j]['value'] = $item->title.': '.General::currencyFormat($item->price).' x '.$item->cnt.' = '.General::currencyFormat($item->price*$item->cnt);
            $arResult['ORDERS'][$arItem->id]['BASKET'][$j]['#render'] = $item->title.': '.General::currencyFormat($item->price).' x '.$item->cnt.' = '.General::currencyFormat($item->price*$item->cnt);
        endforeach;
    endforeach;
    
    echo General::renderTemplate('templates/checkout/orders_list.html',['orders' => $arResult['ORDERS']]);
else:
    echo General::renderTemplate('templates/user/auth_form.html');
endif;
?>

<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/epilog.php');?>