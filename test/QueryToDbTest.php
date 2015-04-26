<?php
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
class MyPdoTest extends PHPUnit_Framework_TestCase {


	function setUp()
	{
		$this->queryToDbObj = new QueryToDb();
	}

	function tearDown()
	{
		$this->queryToDbObj = null;
	}
	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getUserAllDataByName'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setUserCodeCookie'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getUserAllDataByCode'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEmployeeList'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setDeleteEmployee'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'deleteAppointmentsCurrentEmployee'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEmployeeForCheckExists'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setNewEmployee'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setEmployeeNewData'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEmployeeById'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getCalendarRoomList'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getCalendarAppointmentsSelectedMonth'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getCalendarListEmployee'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEventSelectedDayAndRoom'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setEvent'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setEventWithRecur'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getLastId'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setParentRecur'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEventById'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEmployeeListExeptRoot'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'deleteEventNoRecur'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'deleteEventWithRecur'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getEventFromDay'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setNewDataInEventNoRecur'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'setNewDataInEvent'));
		$this->assertTrue(method_exists($this->queryToDbObj,
			'getAllEvents'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('myPdoObj', 'QueryToDb');
	}
}