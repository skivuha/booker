<?php
include("c:\OpenServer\domains\booker\config.php");
include("c:\OpenServer\domains\booker\lib\models\MyPdo.php");
class MyPdoTest extends PHPUnit_Framework_TestCase {

	public function __construct()
	{
		$this->db = MyPdo::getInstance();
	}

	public function testHasMethod()
	{
		$this->assertTrue(method_exists($this->db, 'select'));
		$this->assertTrue(method_exists($this->db, 'delete'));
		$this->assertTrue(method_exists($this->db, 'insert'));
		$this->assertTrue(method_exists($this->db, 'update'));
		$this->assertTrue(method_exists($this->db, 'table'));
		$this->assertTrue(method_exists($this->db, 'where'));
		$this->assertTrue(method_exists($this->db, 'limit'));
		$this->assertTrue(method_exists($this->db, 'set'));
		$this->assertTrue(method_exists($this->db, 'order'));
		$this->assertTrue(method_exists($this->db, 'query'));
		$this->assertTrue(method_exists($this->db, 'protect'));
		$this->assertTrue(method_exists($this->db, 'commit'));
		$this->assertTrue(method_exists($this->db, 'defaultVar'));
	}

	public function testSingletone()
	{
		$db1 = MyPdo::getInstance();
		$db2 = MyPdo::getInstance();
		$this->assertEquals($db1, $db2);
	}

	public function testClassHasAttr()
	{
		$this->assertClassHasAttribute('_instance', 'MyPdo');
		$this->assertClassHasAttribute('db', 'MyPdo');
		$this->assertClassHasAttribute('queryError', 'MyPdo');
		$this->assertClassHasAttribute('select', 'MyPdo');
		$this->assertClassHasAttribute('table', 'MyPdo');
		$this->assertClassHasAttribute('where', 'MyPdo');
		$this->assertClassHasAttribute('is', 'MyPdo');
		$this->assertClassHasAttribute('whereArr', 'MyPdo');
		$this->assertClassHasAttribute('order', 'MyPdo');
		$this->assertClassHasAttribute('delete', 'MyPdo');
		$this->assertClassHasAttribute('update', 'MyPdo');
		$this->assertClassHasAttribute('insert', 'MyPdo');
		$this->assertClassHasAttribute('old', 'MyPdo');
		$this->assertClassHasAttribute('znak', 'MyPdo');
		$this->assertClassHasAttribute('new', 'MyPdo');
		$this->assertClassHasAttribute('query', 'MyPdo');
		$this->assertClassHasAttribute('limit_start', 'MyPdo');
		$this->assertClassHasAttribute('limit_end', 'MyPdo');
		$this->assertClassHasAttribute('join', 'MyPdo');
		$this->assertClassHasAttribute('lastId', 'MyPdo');
		$this->assertClassHasAttribute('set', 'MyPdo');

	}
}