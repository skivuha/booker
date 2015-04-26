<?php
include("c:\OpenServer\domains\booker\lib\core\Model.php");
include("c:\OpenServer\domains\booker\lib\models\Auth.php");
include("c:\OpenServer\domains\booker\lib\models\Session.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\Validator.php");
include("c:\OpenServer\domains\booker\lib\models\Encode.php");
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
include("c:\OpenServer\domains\booker\lib\core\Router.php");
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
