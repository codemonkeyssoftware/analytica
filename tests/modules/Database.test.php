<?php
if(!defined("PATH_TEST_TO_ROOT")) {
	define('PATH_TEST_TO_ROOT', '../..');
}
require_once PATH_TEST_TO_ROOT ."/tests/config_test.php";

class Test_Database extends UnitTestCase
{
	function __construct( $title = '')
	{
		parent::__construct( $title );
	}
	
	function setUp()
	{
		Analytica::log("Setup database...");
		Analytica::createConfigObject();
		
		// setup database
		Analytica::createDatabaseObject();

		Zend_Registry::get('config')->setTestEnvironment();
		
		Analytica::createDatabase();
		Analytica::createTables();
	}
	
	function tearDown()
	{
		Analytica::log("TearDown database...");
		Analytica::dropDatabase();
	}
}

