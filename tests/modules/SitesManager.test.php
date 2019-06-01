<?php
if(!defined("PATH_TEST_TO_ROOT")) {
	define('PATH_TEST_TO_ROOT', '../..');
}
require_once PATH_TEST_TO_ROOT ."/tests/config_test.php";

require_once('Database.test.php');

Zend_Loader::loadClass('Analytica_SitesManager');

class Test_Analytica_SitesManager extends Test_Database
{
    function __construct() 
    {
        parent::__construct('Log class test');
    }
    public function test_addSite()
    {
        try
        {
            Analytica_SitesManager::addSite('', array());
        }
        catch($e)
        {
            $this->
        }
    }
    public function test_addSite2()
    {
        $this->assertError(Analytica_SitesManager::addSite('', array()));
    }
    /*static public function addSite($name, $aUrls)
    {
        self::checkName($name);
        $aUrls = self::cleanParameterUrls($aUrls);
        self::checkUrls($aUrls);

        if (count($aUrls) == 0)
        {
            throw new Exception("You must specify at least one URL for the site.");
        }

        $db = Zend_Registry::get('db');

        $url = $aUrls[0];
        $aUrls = array_slice($aUrls, 1);

        $db->insert(Analytica::prefixTable("site"), array(
            'name' => $name,
            'main_url' => $url,
            )
        );

        $idSite = $db->lastInsertId();

        self::insertSiteUrls($idSite, $aUrls);

        return $idSite;
    }*/
}
?>
