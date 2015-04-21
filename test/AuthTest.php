<?php
include("lib/models/Auth.php");
class EncodeTest extends PHPUnit_Framework_TestCase {
    function setUp()
    {
        $this->auth =new Auth();
        $this->string = 'mimimi';
        $this->number = 4;
        $this->array = array();
    }

    function tearDown()
    {
        $this->auth = null;
    }

    public function testGenerateCode()
    {
      $this->assertTrue(is_string($this->encode->generateCode($this->string)));
      $this->assertFalse(is_string($this->encode->generateCode($this->array)));
      $this->assertTrue(is_string($this->encode->generateCode($this->number)));
      $this->assertEquals(10 ,strlen($this->encode->generateCode($this->number)));
    }
}
 
