<?php

 /*
 * Class: Employee
 *
 * Model admin page.
 *
 */

class Employee extends model
{

	private $flag;
	private $dataArray;
	private $error;

	public function getEmployee()
	{
		$arr = $this->queryToDbObj->getEmployeeList();

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

	public function setAction($value)
	{
		if('delete' == $value)
		{
			return $this->deleteEmployee();
		}
		elseif('edit' == $value)
		{
			return $this->editEmployee();
		}
		elseif('add' == $value)
		{
			return $this->addEmployee();
		}

	}
	private function deleteEmployee()
	{
		if (true === $this->flag)
		{
			$id_employee = $this->data->getParams();
			$rez = $this->queryToDbObj->deleteEmployee($id_employee['id']);
			return $rez;
		}

		return false;
	}

	private function addEmployee()
	{
		if (false === $this->flag)
		{
			if (isset($this->dataArray))
			{
				if ('' === $this->dataArray['pass_employee'])
				{
					$this->error['ERROR_PASS'] = ERROR_EMPTY;
					$pass = false;
				}
				else
				{
					if (false === $this->validatorObj
							->checkPass($this->dataArray['pass_employee']))
					{
						$this->error['ERROR_PASS'] = ERROR_WRONG_DATA;
					}
					else
					{
						$pass = $this->dataArray['pass_employee'];
					}
				}

				if ('' === $this->dataArray['name_employee'])
				{
					$this->error['ERROR_NAME'] = ERROR_EMPTY;
					$name = false;
				}
				else
				{
					if (false === $this->validatorObj
							->checkForm($this->dataArray['name_employee']))
					{
						$this->error['ERROR_NAME'] = ERROR_WRONG_DATA;
						$name = false;
					}
					else
					{
						$name = $this->dataArray['name_employee'];
					}
				}
				if ('' === $this->dataArray['email_employee'])
				{
					$this->error['ERROR_EMAIL'] = ERROR_EMPTY;
					$email = false;
				}
				else
				{
					if (false === $this->validatorObj
							->checkEmail($this->dataArray['email_employee']))
					{
						$this->error['ERROR_EMAIL'] = ERROR_WRONG_DATA;
						$email = false;
					}
					else
					{
						$email = $this->dataArray['email_employee'];
					}
				}
				if (false !== $name && false !== $pass && false !== $email)
				{
					$arr = $this->queryToDbObj
						->getEmployeeForCheckExists($email);
					if (!empty($arr))
					{
						$this->error['ERROR_STATUS'] = ERROR_EXISTS;
					}
					else
					{
						$key_employee = $this->encodeObj->generateCode($name);
						$pass = md5($key_employee . $pass . SALT);
						$arr = $this->queryToDbObj
							->setNewEmployee($name, $pass, $email,
								$key_employee);
						if ($arr)
						{
							$success['ADD'] = 'User add';

							return $success;
						}
					}
				}
			}
		}
		if (!empty($this->error))
		{
			return $this->error;
		}
	}

	private function editEmployee()
	{
		if (true === $this->flag)
		{
			if (isset($this->dataArray))
			{
				$array = array();
				$name = $this->dataArray['name_employee'];
				$email = $this->dataArray['email_employee'];
				$pass = $this->dataArray['pass_employee'];
				$key_employee = $this->encodeObj->generateCode($name);
				if (0 != strlen($name))
				{
					$array['name_employee'] = $name;
				}
				if (0 != strlen($email))
				{
					$array['mail_employee'] = $email;
				}
				if (0 != strlen($pass))
				{
					$array['passwd_employee'] = md5($key_employee.$pass.SALT);
					$array['key_employee'] = $key_employee;
				}
				$id_employee = $this->data->getParams();
				$id_employee = abs((int)$id_employee['id']);
				$rez = $this->queryToDbObj
					->setEmployeeNewData($array, $id_employee);

				return $rez;
			}
			else
			{
				$id_employee = $this->data->getParams();
				$rez = $this->queryToDbObj
					->getEmployeeById($id_employee['id']);
				$arr['EMPLOYEE_N'] = $rez[0]['name_employee'];
				$arr['EMPLOYEE_EMAIL'] = $rez[0]['mail_employee'];
			}
		}

		return $arr;
	}
}

?>