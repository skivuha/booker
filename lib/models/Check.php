<?php

class Check
{
	private $valid;
	private $cookie;
	private $session;
	private $myPdo;
	private $redirect;
	private $data;
	private $statusUser;

	public function __construct()
	{
		$this->valid = new Validator();
		$this->data = Router::getInstance();
		$this->cookie = new Cookie();
		$this->session = Session::getInstance();
		$this->myPdo = MyPdo::getInstance();
		$this->lang();
		$this->choiseLang();
		$this->setFirstDay();
		$this->setTimeFormat();
		$this->setRoom();
	}

	private function lang()
	{
		if ( ! isset($_COOKIE['langanator']))
		{
			$this->cookie->add('langanator', 'en');
		}
	}

	private function setFirstDay()
	{
		$this->redirect();
		$post_clear = $this->valid->clearDataArr($_POST);
		if ('sunday' === $post_clear['firstday'])
		{
			$this->cookie->add('user2_firstday', 'sunday');
			header('Location:' .$this->redirect);
		}
		elseif('monday' === $post_clear['firstday'])
		{
			$this->cookie->add('user2_firstday', 'monday');
			header('Location:' .$this->redirect);
		}
	}

	private function setTimeFormat()
	{
		if(!isset($_COOKIE['langanator']))
		{
			$this->cookie->add('user2_timeFormat','24h');
		}
		else
		{
			$this->redirect();
			$post_clear = $this->valid->clearDataArr($_POST);
			if ('12h' === $post_clear['timeFormat'])
			{
				$this->cookie->add('user2_timeFormat', '12h');
				header('Location:' . $this->redirect);
			}
			elseif ('24h' === $post_clear['timeFormat'])
			{
				$this->cookie->add('user2_timeFormat', '24h');
				header('Location:' . $this->redirect);
			}
		}
	}
	
	private function setRoom()
	{
	  if(!isset($_SESSION['room']))
		{
			$this->session->setSession('room','1');
		}
		else
		{
			$this->redirect();
			$params = $this->data->getParams();
			if(isset($params['room']))
			{
				$params = abs((int)$params['room']);
				$this->session->setSession('room', $params);
				header('Location:' .$this->redirect);
			}
		}
	}

	private function choiseLang()
	{
		$this->redirect();
		$post_clear = $this->valid->clearDataArr($_POST);
		if ('ru' === $post_clear['leng'])
		{
			$this->cookie->add('langanator', 'ru');
			header('Location:' .$this->redirect);
		}
		elseif ('en' === $post_clear['leng'])
		{
			$this->cookie->add('langanator', 'en');
			header('Location:' .$this->redirect);
		}
	}

	private function redirect()
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->redirect = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			$this->redirect = PATH;
		}
	}

	public function getUserStatus()
	{
		if (isset($_SESSION['id_employee'])
			&& isset($_SESSION['name_employee'])
			&& isset($_SESSION['mail_employee']))
		{
			return true;
		}
		else
		{
			if (isset($_COOKIE['code_employee']))
			{
				$code_user = $this->valid->clearData($_COOKIE['code_employee']);
				$arr = $this->myPdo->select('id_employee, mail_employee,
				key_employee, name_employee, role')->table('employee')->where(array
				('code_employee' => $code_user), array('='))->query()->commit();
				if ( ! empty($arr))
				{
					$this->session->setSession('id_employee', $arr[0]['id_employee']);
					$this->session->setSession('mail_employee', $arr[0]['mail_employee']);
					$this->session->setSession('name_employee', $arr[0]['name_employee']);
					$this->session->setSession('role', $arr[0]['role']);
					$this->cookie->add("code_employee", $code_user);
				}
				else
				{
					$this->cookie->remove('code_employee');
					return false;
				}
			}
			else
			{
				$this->cookie->remove('code_employee');
				return false;
			}
		}
	}
}

?>
