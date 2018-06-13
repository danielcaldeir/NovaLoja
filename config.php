<?php
require 'environment.php';

global $config;
global $db;

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/NovaLoja/");
	$config['dbname'] = 'loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
        $config['default_lang'] = 'pt-br';
        $config['cep_origem'] = '71065052';
        $config['pagseguro_email'] = 'danielcaldeir@gmail.com';
        $config['mpID'] = '8991433061703497';
        $config['mpSecretKEY'] = 'Fh7xrEeOj9M7JsO4gVEB34i7JbEvSLp7';
} else {
	define("BASE_URL", "http://localhost/NovaLoja/");
	$config['dbname'] = 'loja';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
        $config['default_lang'] = 'pt-br';
        $config['cep_origem'] = '71065052';
        $config['pagseguro_email'] = 'danielcaldeir@gmail.com';
        $config['mpID'] = '8991433061703497';
        $config['mpSecretKEY'] = 'Fh7xrEeOj9M7JsO4gVEB34i7JbEvSLp7';
}

$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("NovaLoja")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("NovaLoja")->setRelease("1.0.0");

\PagSeguro\Configuration\Configure::setEnvironment('sandbox');
\PagSeguro\Configuration\Configure::setAccountCredentials('danielcaldeir@gmail.com', '0B659419F77647219A4A80ECCC72F7F7');
\PagSeguro\Configuration\Configure::setCharset('UTF-8');
\PagSeguro\Configuration\Configure::setLog(true, 'pagseguro.log');
?>