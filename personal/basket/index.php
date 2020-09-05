<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog.php');
$basket = new Basket;
?>

<section class="content">
    <div class="container">
        <h1>Basket</h1>
        <a href="/">&larr; Back to pizzas</a>
        <div class="cart-page-wrapper">
            <?=General::renderTemplate('/templates/basket/basket_page.html',['basket'=>$basket->getTemp()])?>
        </div>
    </div>
</section>

<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/epilog.php');