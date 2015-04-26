<?php
include("c:\OpenServer\domains\booker\lib\core\Model.php");
include("c:\OpenServer\domains\booker\lib\models\Session.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\Validator.php");
include("c:\OpenServer\domains\booker\lib\models\Encode.php");
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
include("c:\OpenServer\domains\booker\lib\core\Router.php");
include("c:\OpenServer\domains\booker\lib\models\Employee.php");
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
