<?php
include("c:\OpenServer\domains\booker\lib\core\Model.php");
include("c:\OpenServer\domains\booker\lib\models\Session.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\Validator.php");
include("c:\OpenServer\domains\booker\lib\models\Encode.php");
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
include("c:\OpenServer\domains\booker\lib\core\Router.php");
include("c:\OpenServer\domains\booker\lib\models\Event.php");
class EventTest extends PHPunit_Framework_TestCase

{
	function setUp()
	{
		$this->eventObj = new Event();
	}

	function tearDown()
	{
		$this->eventObj = null;
	}
	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->eventObj,
			'dataFromPost'));
		$this->assertTrue(method_exists($this->eventObj,
			'time'));
		$this->assertTrue(method_exists($this->eventObj,
			'startDay'));
		$this->assertTrue(method_exists($this->eventObj,
			'endDay'));
		$this->assertTrue(method_exists($this->eventObj,
			'checkDateNoRecursion'));
		$this->assertTrue(method_exists($this->eventObj,
			'detailsEvent'));
		$this->assertTrue(method_exists($this->eventObj,
			'deleteEvent'));
		$this->assertTrue(method_exists($this->eventObj,
			'updateEvent'));
		$this->assertTrue(method_exists($this->eventObj,
			'setRecurent'));
		$this->assertTrue(method_exists($this->eventObj,
			'userRole'));
		$this->assertTrue(method_exists($this->eventObj,
			'setData'));
		$this->assertTrue(method_exists($this->eventObj,
			'setRoom'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('dataArray', 'Event');
		$this->assertClassHasAttribute('error', 'Event');
		$this->assertClassHasAttribute('id', 'Event');
		$this->assertClassHasAttribute('dArray', 'Event');
		$this->assertClassHasAttribute('userRole', 'Event');
		$this->assertClassHasAttribute('recurent', 'Event');
		$this->assertClassHasAttribute('room', 'Event');
		$this->assertClassHasAttribute('employee', 'Event');
		$this->assertClassHasAttribute('selectedDay', 'Event');
		$this->assertClassHasAttribute('selectedMonth', 'Event');
		$this->assertClassHasAttribute('selectedYear', 'Event');
		$this->assertClassHasAttribute('selectedStartHour', 'Event');
		$this->assertClassHasAttribute('selectedStartMinute', 'Event');
		$this->assertClassHasAttribute('selectedEndHour', 'Event');
		$this->assertClassHasAttribute('selectedEndMinute', 'Event');
		$this->assertClassHasAttribute('description', 'Event');
		$this->assertClassHasAttribute('currentTime', 'Event');
	}
}
?>
