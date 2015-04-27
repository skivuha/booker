<?php
include("lib/models/Session.php");
include("lib/models/MyPdo.php");
include("lib/models/QueryToDb.php");
include("lib/models/Validator.php");
include("lib/models/Cookie.php");
include("lib/models/Check.php");
include("lib/core/Router.php");
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
