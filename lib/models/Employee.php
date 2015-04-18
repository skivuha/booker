<?php
class Employee
{
	private $myPdo;
	private $flag;
	private $dataArray;
	private $error;
	private $check;
	private $encode;

	public function __construct()
	{
		$this->myPdo = MyPdo::getInstance();
		$this->data = Router::getInstance();
		$this->check = new Validator();
		$this->encode = new Encode();
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
          if(!empty($arr))
          {
            $this->error['ERROR_STATUS'] = 'E-mail or name already exists';
          }
          else
          {

            $key_employee = $this->encode->generateCode($name);
            $pass = md5($key_employee.$pass.SALT);
            $arr = $this->myPdo->insert()
              ->table("employee SET name_employee = '$name',
               passwd_employee = '$pass', mail_employee = '$email', key_employee = '$key_employee'")
              ->query()
              ->commit();
            if($arr)
            {
              return true;
            }
          }
		    }
		}
	    }
    if(!empty($this->error))
    {
      return $this->error;
    }
	}
	
	public function editEmployee()
	{
		if (true === $this->flag)
		{
		if (isset($this->dataArray))
		{
			$array = array();
		  $name = $this->dataArray['name_employee'];
		  $email = $this->dataArray['email_employee'];
			$pass = $this->dataArray['pass_employee'];
			$key_employee = $this->encode->generateCode($name);
			if(0 != strlen($name))
			{
				$array['name_employee'] = $name;
			}
			if(0 != strlen($email))
			{
				$array['mail_employee'] = $email;
			}
			if(0 != strlen($pass))
			{
				$array['passwd_employee'] = md5($key_employee.$pass.SALT);
				$array['key_employee'] = $key_employee;
			}
			$id_employee = $this->data->getParams();
			$id_employee = abs((int)$id_employee['id']);
		    $rez = $this->myPdo->update()
		    ->table("employee")
				->set($array)
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