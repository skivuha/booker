<?php

class Auth
{
	private $check;
	private $encode;
	private $error;
	private $myPdo;

	public function __construct()
	{
		$this->myPdo = MyPdo::getInstance();
		$this->check = new Validator();
		$this->encode = new Encode();
		$this->cookie = new Cookie();
		$this->session = Session::getInstance();
	}

	public function logon($var)
	{
		if (true === $var)
		{
			$data_post = $this->check->clearDataArr($_POST);
			if ('' === $data_post['password'])
			{
				$this->error['ERRORPASS'] = 'Field is empty';
				$pass = false;
			}
			else
			{
				if (false === $this->check->checkPass($data_post['password']))
				{
					$this->error['ERRORPASS'] = 'Wrong data';
					$pass = false;
				}
				else
				{
					$pass = $data_post['password'];
				}
			}

			if ('' === $data_post['name'])
			{
				$this->error['ERRORLOGIN'] = 'Field is empty';
				$name = false;
			}
			else
			{
				if (false === $this->check->checkForm($data_post['name']))
				{
					$this->error['ERRORLOGIN'] = 'Wrong data';
					$name = false;
				}
				else
				{
					$name = $data_post['name'];
				}
			}

			if (false !== $pass && false !== $name)
			{
				$arr = $this->myPdo->select('id_employee, mail_employee,
				 passwd_employee, key_employee, name_employee')
					->table('employee')
					->where(array('name_employee' => $name), array('='))
					->query()
					->commit();
				if (empty($arr))
				{
					$this->error['ERRORSTATUS'] = 'Wrong name or password';
				}
				else
				{
					$password = md5($arr[0]['key_employee'] . $pass . SALT);
					if ($arr[0]['passwd_employee'] === $password)
					{
						$this->session->setSession('id_employee', $arr[0]['id_employee']);
						$this->session->setSession('mail_employee',
							$arr[0]['mail_employee']);
						$this->session->setSession('name_employee',
							$arr[0]['name_employee']);

						if (isset($data_post['remember'])
							&& 'on' === $data_post['remember'])
						{
							$encode = new Encode();
							$code_employee = $encode->generateCode($arr[0]['name_employee']);
							$this->myPdo->update()
								->table("employee SET code_employee = '$code_employee'")
								->where(array('name_employee' => $name), array('='))
								->query()
								->commit();
							$this->cookie->add('code_employee', $code_employee);
						}

						return true;
					}
					else
					{
						$this->error['ERRORSTATUS'] = 'Wrong name or password';
					}
				}
			}
		}

		return $this->error;
	}
}

?>
