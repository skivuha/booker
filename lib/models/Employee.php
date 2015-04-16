<?php
class Employee
{
	private $myPdo;
	private $flag;

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
	public function setFlag($var)
	{
		$this->flag = $var;
	}

	public function deleteEmployee()
	{
		if (true === $this->flag)
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

	public function editEmployee()
	{
		if (true === $this->flag)
		{
			$id_employee = $this->data->getParams();
			$rez = $this->myPdo->select('mail_employee, name_employee')
				->table('employee')
				->where(array('id_employee'=>$id_employee['id']),array('='))
				->query()
				->commit();

			$arr['EMPLOYEE_N'] = $rez[0]['name_employee'];
			$arr['EMPLOYEE_EMAIL'] = $rez[0]['mail_employee'];
		}
		return $arr;
	}
}
?>