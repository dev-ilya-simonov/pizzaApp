<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog.php');

$product = new Product();
$arResult = $product->find('all',
    [
        'order' => 'sort asc'
    ]
);
?>
<section class="content">
    <?=General::renderTemplate('/templates/product/product_list.html',['products' => $arResult]);?>
</section>
<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/epilog.php');