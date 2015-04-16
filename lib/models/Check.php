<?php

class Check
{
	private $valid;
	private $cookie;
	private $session;
	private $myPdo;
	private $redirect;

	public function __construct()
	{
		$this->valid = new Validator();
		$this->cookie = new Cookie();
		$this->session = Session::getInstance();
		$this->myPdo = MyPdo::getInstance();
		$this->lang();
		$this->choiseLang();
		$this->setFirstDay();
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
	
	private function setRoom()
	{
	    $this->redirect();
	    $post_clear = $this->valid->clearDataArr($_POST);
	    $post_room = abs((int)$_POST[selectedroom]);
	    $this->cookie->add('user2_room', '$post_room');
	    header('Location:' .$this->redirect);
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
				key_employee, name_employee')->table('employee')->where(array
				('code_employee' => $code_user), array('='))->query()->commit();
				if ( ! empty($arr))
				{
					$this->session->setSession('id_employee', $arr[0]['id_employee']);
					$this->session->setSession('mail_employee', $arr[0]['mail_employee']);
					$this->session->setSession('name_employee', $arr[0]['name_employee']);
					$this->cookie->add("code_employee", $code_user);
					return true;
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
