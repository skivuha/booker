<?php
include("c:\OpenServer\domains\booker\lib\core\Model.php");
include("c:\OpenServer\domains\booker\lib\models\Session.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
include("c:\OpenServer\domains\booker\lib\models\QueryToDb.php");
include("c:\OpenServer\domains\booker\lib\models\Validator.php");
include("c:\OpenServer\domains\booker\lib\models\Encode.php");
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
include("c:\OpenServer\domains\booker\lib\core\Router.php");
include("c:\OpenServer\domains\booker\lib\models\Calendar.php");
class CalendarTest extends PHPunit_Framework_TestCase

{
	function setUp()
	{
		$this->calendarObj = new Calendar();
	}

	function tearDown()
	{
		$this->calendarObj = null;
	}
	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->calendarObj,
			'getNewData'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getTimeStamp'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getCalendar'));
		$this->assertTrue(method_exists($this->calendarObj,
			'printCalendar'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getAppointments'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getDataToBookIt'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getCurrentData'));
		$this->assertTrue(method_exists($this->calendarObj,
			'getListRoom'));
		$this->assertTrue(method_exists($this->calendarObj,
			'setUserRole'));
		$this->assertTrue(method_exists($this->calendarObj,
			'setFirstDay'));
		$this->assertTrue(method_exists($this->calendarObj,
			'setFlagParams'));
		$this->assertTrue(method_exists($this->calendarObj,
			'setTimeFormat'));
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('currentMonth', 'Calendar');
		$this->assertClassHasAttribute('newMonth', 'Calendar');
		$this->assertClassHasAttribute('currentYear', 'Calendar');
		$this->assertClassHasAttribute('newYear', 'Calendar');
		$this->assertClassHasAttribute('currentDay', 'Calendar');
		$this->assertClassHasAttribute('countDayOfCurrentMonth',
			'Calendar');
		$this->assertClassHasAttribute('nextMonth', 'Calendar');
		$this->assertClassHasAttribute('nextYear', 'Calendar');
		$this->assertClassHasAttribute('subMonth', 'Calendar');
		$this->assertClassHasAttribute('subYear', 'Calendar');
		$this->assertClassHasAttribute('startDay', 'Calendar');
		$this->assertClassHasAttribute('flagParams', 'Calendar');
		$this->assertClassHasAttribute('saturday', 'Calendar');
		$this->assertClassHasAttribute('sunday', 'Calendar');
		$this->assertClassHasAttribute('headTable', 'Calendar');
		$this->assertClassHasAttribute('disable', 'Calendar');
		$this->assertClassHasAttribute('calendar', 'Calendar');
		$this->assertClassHasAttribute('firstDayTimeStampChoiseMonth',
			'Calendar');
		$this->assertClassHasAttribute('lastDayTimeStampChoiseMonth',
			'Calendar');
		$this->assertClassHasAttribute('currentDayTimeStamp',
			'Calendar');
		$this->assertClassHasAttribute('timeFormat', 'Calendar');
		$this->assertClassHasAttribute('room', 'Calendar');
		$this->assertClassHasAttribute('userRole', 'Calendar');

	}
}
?>
