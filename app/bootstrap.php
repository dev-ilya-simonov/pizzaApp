<?

require_once 'php_interface/init.php';
require_once 'vendor/php-activerecord/php-activerecord/ActiveRecord.php';

$connectTmp = 'mysql://%s:%s@%s/%s';
$genConnStr = sprintf(
    $connectTmp,
    $settings['db']['user'],
    $settings['db']['pwd'],
    $settings['db']['host'],
    $settings['db']['name']
);

ActiveRecord\Config::initialize(function($cfg) {
     $cfg->set_model_directory($_SERVER['DOCUMENT_ROOT'].'/app/core');
     $cfg->set_connections(array(
        'development' => 'mysql://godzila_pizza:%&7t0Y0*@localhost/godzila_pizza'));
});
