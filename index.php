<?php
/*
 * PHP Configuration init
 */
error_reporting(E_ALL|E_NOTICE);
date_default_timezone_set('America/Chicago');
define('ANALYTICA_INCLUDE_PATH', '.');

require_once ANALYTICA_INCLUDE_PATH . "/modules/ErrorHandler.php";
set_error_handler('Analytica_ErrorHandler');

function Analytica_ExceptionHandler(Exception $exception) {
    echo "<div style='font-size:11pt'><pre>Uncaught exception: ", $exception->getMessage(), "\n";
    echo $exception->__toString();
    exit;
}
set_exception_handler('Analytica_ExceptionHandler');

set_include_path(ANALYTICA_INCLUDE_PATH
    . PATH_SEPARATOR . ANALYTICA_INCLUDE_PATH . '/libs/'
    . PATH_SEPARATOR . ANALYTICA_INCLUDE_PATH . '/core/'
    . PATH_SEPARATOR . ANALYTICA_INCLUDE_PATH . '/modules'
    . PATH_SEPARATOR . ANALYTICA_INCLUDE_PATH . '/core/models'
    . PATH_SEPARATOR . get_include_path());

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARING, 1);
assert_options(ASSERT_BAIL, 1);


/*
 * Zend classes
 */
include "Zend/Exception.php";
include "Zend/Loader.php";
Zend_Loader::loadClass('Zend_Controller_Front');
Zend_Loader::loadClass('Zend_Registry');
Zend_Loader::loadClass('Zend_Config_Ini');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Debug');
Zend_Loader::loadClass('Zend_Auth');
Zend_Loader::loadClass('Zend_Acl');
Zend_Loader::loadClass('Zend_Acl_Resource');
Zend_Loader::loadClass('Zend_Acl_Role');
Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');

/*
 * Analytica classes
 */
Zend_Loader::loadClass('Analytica_Access');
Zend_Loader::loadClass('Analytica_Apiable');
Zend_Loader::loadClass('Analytica_Log');
Zend_Loader::loadClass('Analytica_Config');
Zend_Loader::loadClass('Analytica_PublicApi');
Zend_Loader::loadClass('Analytica');


Analytica::createConfigObject();
Analytica::createDatabaseObject();
Analytica::createLogObject();

Analytica::createDatabase();
Analytica::createTables();

/*Analytica_UsersManager::deleteUser("login");
Analytica_UsersManager::deleteUser("login2");
Analytica_UsersManager::addUser("login","password1", "alias", "ema@i.coml");
Analytica_UsersManager::addUser("login2","password2", "alias23", "ema2@i.coml");

Analytica_SitesManager::replaceSiteUrls(1, array());
Analytica_SitesManager::addSiteUrls(1, array("https://1", "http://2"));
//var_dump(Analytica_SitesManager::getSiteUrlsFromId(4));
//Analytica_SitesManager::addSite("many urls", array("https://t", "http://localhost/", "http://domain76.com/ijndex/"));

Analytica_UsersManager::setUserRole("admin", "login", array(3,5));
Analytica_UsersManager::setUserRole("admin", "login", array(6,7));
*/

// Create auth object
$auth = Zend_Auth::getInstance();
$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'));
$authAdapter->setTableName(Analytica::prefixTable('user'))
    ->setIdentityColumn('login')
    ->setCredentialColumn('password')
    ->setCredentialTreatment('MD5(?)');

// Set the input credential values (e.g., from a login form)
$authAdapter->setIdentity('login')
    ->setCredential('password1');

// Perform the authentication query, saving the result
$access = new Analytica_Access($authAdapter);
Zend_Registry::set('access', $access);

main();
//Analytica::uninstall();

function main()
{
    Analytica::log("Start process...");
    $api = Analytica_PublicApi::getInstance();
    $api->registerClass("Analytica_SitesManager");
    $api->registerClass("Analytica_UsersManager");

    $api->SitesManager->getSiteUrlsFromId(1);
    $api->SitesManager->addSite("test name site", array("http://localhost", "http://test.com"));
    $api->UsersManager->addUser(2, "login", "password");
}

?>