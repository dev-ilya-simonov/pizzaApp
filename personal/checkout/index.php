<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog.php');
if(isset($_GET['order_id']) && $_GET['order_id'] > 0):
?>

<section class="content">
    <div class="container">
        <h1>Your order № <b><?=$_GET['order_id']?></b> is completed!</h1>
        <p>Within 10 minutes our staff will contact you to confirm the order<p><br/><br/>
        <h2>Bon appetit!<h2>
    </div>
</section>
<?
else:
    $basket = new Basket;
    $delivery = new Delivery;

    $basketObj = $basket::find_by_id($_GET['bid']);
    if($basketObj->completed == 'N'):
        if(!$basketObj):
            echo 'Выбранной вами корзины не существует!';
        else:
            $arResult['id'] = $_GET['bid'];
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
                if($k == 0) 
                    $arResult['checked_delivery'] = $arResult['deliveries'][$k];
            endforeach;

            $total = round($basketObj->total + $arResult['checked_delivery']['price']['value'],2);
            $arResult['total']['value'] = $total;
            $arResult['total']['#formatted'] = General::currencyFormat($total).' | '.General::currencyFormat($total,'eur');
            ?>
            <section class="content">
                <div class="container">
                    <h1>Оформление заказа</h1>
                    <div class="cart-page-wrapper" data-bid="<?=$_GET['bid']?>">
                        <?=General::renderTemplate('/templates/checkout/checkout_page.html',['basket'=>$arResult])?>
                    </div>
                </div>
            </section>
        <?endif;?>
    <?else:?>
        <section class="content">
            <div class="container">
                <h1>An order for this basket has already been placed</h1>
                <p>Please, choose new products at <a href="/">menu</a></p>
            </div>
        </section>
    <?endif;?>
<?endif;?>
<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/epilog.php');