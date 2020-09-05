<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/prolog_before.php');

switch($_POST['action']):
    case 'add':
        $product = new Product();
        $prodObj = $product::find_by_id($_POST['id']);

        $basket = new Basket();

        if(isset($_POST['tmp']) && !empty($_POST['tmp']))
            $basket->template = $_POST['tmp'];

        echo $basket->saveTemp($prodObj);

        break;
    case 'delete':
        $basket = new Basket();

        if(isset($_POST['tmp']) && !empty($_POST['tmp']))
            $basket->template = $_POST['tmp'];

        echo $basket->deleteTemp($_POST['id']);
        break;
    case 'update':
        $product = new Product();
        $prodObj = $product->find('all',[
            'conditions' => ['id' => $_POST['id']]
        ])[0];

        $basket = new Basket();

        if(isset($_POST['tmp']) && !empty($_POST['tmp']))
            $basket->template = $_POST['tmp'];
            
        echo $basket->saveTemp($prodObj,$_POST['cnt']);
        break;

endswitch;