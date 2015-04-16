<?php
class Employee
{
	private $myPdo;
	private $flag;
	private $dataArray;
	private $error;
	private $check;

	public function __construct()
	{
		$this->myPdo = MyPdo::getInstance();
		$this->data = Router::getInstance();
		$this->check = new Validator();
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
	
	public function setDataArray(array $arr)
	{
	    $this->dataArray = $arr;
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
	
	public function addEmployee()
	{
	    if(false === $this->flag)
	    {
		if(isset($this->dataArray))
		{
		    if('' === $this->dataArray['pass_employee'])
		    {
			$this->error['ERROR_PASS'] = 'Field is empty';
			$pass = false;
		    }
		    else
		    {
			if(false === $this->check->checkPass($this->dataArray['pass_employee']))
			{
			    $this->error['ERROR_PASS'] = 'Wrong data';
			}
			else
			{
			    $pass = $this->dataArray['pass_employee'];
			}
		    }
		    
		    if('' === $this->dataArray['name_employee'])
		    {
			$this->error['ERROR_NAME'] = 'Field is empty';
			$name = false;
		    }
		    else
		    {
			if(false === $this->check->checkForm($this->dataArray['name_employee']))
			{
			    $this->error['ERROR_NAME'] = 'Wrong data';
			    $name = false;
			}
			else
			{
			    $name = $this->dataArray['name_employee'];
			}
		    }
		    if('' === $this->dataArray['email_employee'])
		    {
			$this->error['ERROR_EMAIL'] = 'Field is empty';
			$email = false;
		    }
		    else
		    {
			if(false === $this->check->checkEmail($this->dataArray['email_employee']))
			{
			    $this->error['ERROR_EMAIL'] = 'Wrong data';
			    $email = false;
			}
			else
			{
			    $email = $this->dataArray['email_employee'];
			}
		    }
		    if(false !== $name && false !== $pass && false !== $email)
		    {
			$arr = $this->myPdo->select('name_employee, mail_employee')
			->table('employee')
			->where(array('name_employee'=>$name, 'mail_employee'=> $email), array('=','='))
			->query()
			->commit();
		    }
		}
	    }
	}
	
	public function editEmployee()
	{
		if (true === $this->flag)
		{
		if (isset($this->dataArray))
		{
		    $name = $this->dataArray['name_employee'];
		    $email = $this->dataArray['email_employee'];
		    $id_employee = abs((int)$this->data->getParams());
		    $rez = $this->myPdo->update()
		    ->table("employee SET name_employee = '$name', mail_employee = '$email' ")
		    ->where(array('id_employee'=>$id_employee), array('='))
		    ->query()
		    ->commit();
		    return $rez;
		}
		else
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
		}
		return $arr;
	}
}
?>