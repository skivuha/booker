<?php
class EventController extends Controller
{
	private $valid;
	private $event;

	public function __construct()
	{
		$this->valid = new Validator();
		$this->event = new Event();
	}
	public function addAction()
	{
		$action = $this->valid->clearDataArr($_POST);
		$this->event->setData($action);
		if('false' == $action['recuringon'])
		{
			$this->event->checkDateNoRecursion();
		}
		else
		{
			$this->event->checkDateRecursion();
		}


		//echo '<pre>';
		//print_r($action);
		//echo true;


	}
}
?>