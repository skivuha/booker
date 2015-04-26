<?php
include("c:\OpenServer\domains\booker\lib\models\Session.php");
class SessionTest extends PHPUnit_Framework_TestCase {
    function setUp()
    {
        $this->session = Session::getInstance();
    }

    function tearDown()
    {
        $this->session = null;
    }

	public function __construct()
	{
	}

    public function testSessionHasMethod()
    {
		$this->assertTrue(method_exists($this->session, 'setSession'));
		$this->assertTrue(method_exists($this->session, 'getSession'));
		$this->assertTrue(method_exists($this->session, 'removeSession'));
    }
}
 
