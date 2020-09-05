<?
class Basket extends ActiveRecord\Model {
    static $table = 'basket';
    protected $total;
    public $template = 'header_cart';
    static $uid = 0;

    public function getTemp() {
        if(isset($_COOKIE['basket']) && (!empty($_COOKIE['basket']))) {
            return json_decode($_COOKIE['basket'],1);
        } else return NULL;
    }

    public function saveTemp(Product $product, $cnt = 1) {
        if(isset($_COOKIE['basket']) && (!empty($_COOKIE['basket']))) {
            $cartArr = json_decode($_COOKIE['basket'],1);
            $itemsArr = $cartArr['items'];
            if(isset($itemsArr[$product->id])) {
                $itemsArr[$product->id] = [
                    'id'    => $product->id,
                    'title' => $product->title,
                    'pic'   => $product->picture,
                    'price' => $product->price,
                    'cnt'   => $itemsArr[$product->id]['cnt']+$cnt
                ];
            } else {
                $itemsArr[$product->id] = [
                    'id'    => $product->id,
                    'title' => $product->title,
                    'pic'   => $product->picture,
                    'price' => $product->price,
                    'cnt'   => $cnt
                ];
            }
            $total = round($cartArr['total']+$product->price*$cnt,2);
            $cartArr = [
                'items' => $itemsArr,
                'total' => $total
            ];            
        } else {
            $itemsArr[$product->id] = [
                'id'    => $product->id,
                'title' => $product->title,
                'pic'   => $product->picture,
                'price' => $product->price,
                'cnt'   => $cnt
            ];
            $total = round($product->price*$cnt,2);
            $cartArr = [
                'items' => $itemsArr,
                'total' => $total
            ];
        }

        setcookie("basket", json_encode($cartArr), time()+3600*3,'/');  // cookie set to 3 hours

        $cartArr['rendered'] = General::renderTemplate('/templates/basket/'.$this->template.'.html',['basket'=>$cartArr]);
        return json_encode($cartArr);
    }

    public function deleteTemp($id) {
        $cartArr = json_decode($_COOKIE['basket'],1);

        $newTotal = round($cartArr['total'] - ($cartArr['items'][$id]['price']*$cartArr['items'][$id]['cnt']),2);
        unset($cartArr['items'][$id]);

        $cartArr['total'] = $newTotal;

        setcookie("basket", json_encode($cartArr), time()+3600*3,'/');  // cookie set to 3 hours
        $_COOKIE['basket'] = json_encode($cartArr); //use it for instant access to cookie

        $cartArr['rendered'] = General::renderTemplate('/templates/basket/'.$this->template.'.html',['basket'=>$cartArr]);
        return json_encode($cartArr);
    }
}