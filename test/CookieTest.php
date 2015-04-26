<?php
include("c:\OpenServer\domains\booker\lib\models\Cookie.php");
class SessionTest extends PHPUnit_Framework_TestCase {

 		public function testCookieRead() 
		{
			$cookie = new Cookie();
			$this->assertFalse($cookie->remove('test'));
 		}
}
 
