<?php
include("c:\OpenServer\domains\booker\lib\models\Session.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\Validator.php");
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
include("c:\OpenServer\domains\booker\lib\models\Check.php");
include("c:\OpenServer\domains\booker\lib\core\Router.php");
class CheckTest extends PHPunit_Framework_TestCase

{
	function setUp()
	{
		$this->checkObj = new Check();
	}

	function tearDown()
	{
		$this->checkObj = null;
	}
	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->checkObj,
			'setFirstDay'));
		$this->assertTrue(method_exists($this->checkObj,
			'setTimeFormat'));
		$this->assertTrue(method_exists($this->checkObj,
			'setRoom'));
		$this->assertTrue(method_exists($this->checkObj,
			'choiseLang'));
		$this->assertTrue(method_exists($this->checkObj,
			'redirect'));
		$this->assertTrue(method_exists($this->checkObj,
			'getUserStatus'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('validObj', 'Check');
		$this->assertClassHasAttribute('cookieObj', 'Check');
		$this->assertClassHasAttribute('session', 'Check');
		$this->assertClassHasAttribute('queryToDbObj', 'Check');
		$this->assertClassHasAttribute('redirect', 'Check');
		$this->assertClassHasAttribute('data', 'Check');
	}
}
?>
