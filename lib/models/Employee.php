<?php
class Employee
{
	private $myPdo;

	public function __construct()
	{
		$this->myPdo = MyPdo::getInstance();
	}

	public function getEmployee()
	{
		$arr = $this->myPdo->select('id_employee, mail_employee,
				name_employee')->table('employee')->query()->commit();
		return $arr;
	}
}
?>