<?
require_once($_SERVER['DOCUMENT_ROOT'].'/app/vendor/twig/twig/lib/Twig/Autoloader.php');

class General {
    static $eur_usd_pair = 0.84;

    public static function currencyFormat($price,$currency = 'usd') {
        $formattedPrice = 0;
        switch($currency) {
            case 'eur':
                $formattedPrice = '<span>'.round(self::$eur_usd_pair*$price,2).'</span> €';
                break;
            default:
                $formattedPrice = '<span>'.round($price,2).'</span> $';
                break;
        }

        return $formattedPrice;
    }

    public static function renderTemplate($path,$params = []) {        
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem(SITE_TEMPLATE_PATH);
        $twig = new Twig_Environment($loader, [
            'debug' => true
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        return $twig->render($path,$params);
    }

}