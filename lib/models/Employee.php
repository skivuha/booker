<?php
class Employee
{
	private $myPdo;
	private $delete;

	public function __construct()
	{
		$this->myPdo = MyPdo::getInstance();
		$this->data = Router::getInstance();
	}

	public function getEmployee()
	{
		$arr = $this->myPdo->select('id_employee, mail_employee,
				name_employee')->table('employee')->query()->commit();
		return $arr;
	}
	public function setDelete($var)
	{
		$this->delete = $var;
	}

	public function deleteEmployee()
	{
		if (true === $this->delete)
		{
			$id_employee = $this->data->getParams();
			$rez = $this->myPdo->delete()
				->table('employee')
				->where(array('id_employee'=>$id_employee['id']),array('='))
				->query()
				->commit();
		}
		return $rez;
	}
}
?>