<?php
include("c:\OpenServer\domains\booker\lib\models\Lang.php");
class LangTest extends PHPUnit_Framework_TestCase {

	public function testHasMethod()
	{
		$this->assertFileExists('c:\OpenServer\domains\booker\templates\lang\eu.strings');
	}
}