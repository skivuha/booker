<?php
include("lib/core/Model.php");
include("lib/models/Auth.php");
include("lib/models/Session.php");
include("lib/models/MyPdo.php");
include("lib/models/QueryToDb.php");
include("lib/models/Validator.php");
include("lib/models/Encode.php");
include("lib/models/Cookie.php");
include("lib/core/Router.php");
class AuthTest extends PHPunit_Framework_TestCase
{


	function setUp()
	{
		$this->authObj = new Auth();
	}

    function tearDown()
	{
		$this->authObj = null;
	}

	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->authObj,
			'logon'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('error', 'Auth');
	}

}
?>
