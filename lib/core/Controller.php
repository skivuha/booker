<?php

/**
 * Class: Controller
 *
 */
abstract class Controller
{
	protected $session;
	protected $check;
	protected $cookie;
	protected $userAuth;
	protected $langArr;

	public function __construct()
	{

		$this->userAuth = false;
		$this->session = Session::getInstance();
		$this->check = new Check();
		$this->checkUser();
		$this->arrayLang();
	}

	protected function getFirstDay()
	{
		$this->cookie = new Cookie();
		return $this->cookie->read('user2_firstday');
	}

	protected function getTimeFormat()
	{
		$this->cookie = new Cookie();
		return $this->cookie->read('user2_timeFormat');
	}

	private function checkUser()
	{
		return $this->userAuth = $this->check->getUserStatus();
	}

	protected function arrayLang()
	{
		$this->cookie = new Cookie();
		$lang = $this->cookie->read('langanator');
		$langObj = new Lang($lang);
		$this->langArr = $langObj->getLangArr();
		return $this->langArr;
	}

	protected function accessToCalendar()
	{
		$this->check = new Check();
		if(false === $this->check->getUserStatus())
		{
			header('Location: '.PATH.'Home/index', true, 303);
		}
	}
}

?>
