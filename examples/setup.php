<?php
$rootDir = dirname(dirname(__FILE__));

//include the autoloader for eazymatch classes
include_once($rootDir . '/bootstrap.autoload.php');


if (isset($_GET['debug'])) {
//create a new connection using our private configuration
    $apiConnect = new emolclient_manager_base(include($rootDir . '/config-dev.php'));

} else {
//create a new connection using our private configuration
    $apiConnect = new emolclient_manager_base(include($rootDir . '/config.php'));
}
