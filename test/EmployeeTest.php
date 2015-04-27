<?php
include("lib/core/Model.php");
include("lib/models/Session.php");
include("lib/models/MyPdo.php");
include("lib/models/QueryToDb.php");
include("lib/models/Validator.php");
include("lib/models/Encode.php");
include("lib/models/Cookie.php");
include("lib/core/Router.php");
include("lib/models/Employee.php");
class EmployeeTest extends PHPunit_Framework_TestCase

{
	function setUp()
	{
		$this->employeeObj = new Employee();
	}

	function tearDown()
	{
		$this->checkObj = null;
	}
	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->employeeObj,
			'getEmployee'));
		$this->assertTrue(method_exists($this->employeeObj,
			'setFlag'));
		$this->assertTrue(method_exists($this->employeeObj,
			'setDataArray'));
		$this->assertTrue(method_exists($this->employeeObj,
			'setAction'));
		$this->assertTrue(method_exists($this->employeeObj,
			'deleteEmployee'));
		$this->assertTrue(method_exists($this->employeeObj,
			'addEmployee'));
		$this->assertTrue(method_exists($this->employeeObj,
			'editEmployee'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('flag', 'Employee');
		$this->assertClassHasAttribute('dataArray', 'Employee');
		$this->assertClassHasAttribute('error', 'Employee');
	}
}
?>
