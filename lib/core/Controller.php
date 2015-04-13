<?php

/**
 * Class: Controller
 *
 */
abstract class Controller
{
	private $session;
	private $check;
	private $cookie;
	protected $userAuth;
	protected $langArr;

	public function __construct()
	{
		$this->userAuth = false;
		$this->session = Session::getInstance();
		$this->cookie = new Cookie();
		$this->check = new Check();
		$this->checkUser();
		$this->arrayLang();
	}

	private function checkUser()
	{
		return $this->userAuth = $this->check->getUserStatus();
	}

	private function arrayLang()
	{
		$langObj = new Lang($this->cookie->read('langanator'));
		$this->langArr = $langObj->getLangArr();
	}

	protected function accessToCalendar()
	{
		$this->check = new Check();
		if(false === $this->check->getUserStatus())
		{
			header('Location: /Home/index');
		}
	}
}

?>