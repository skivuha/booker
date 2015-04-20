<?php
class EventController extends Controller
{
	private $valid;
	private $event;

	public function __construct()
	{
		$this->valid = new Validator();
		$this->event = new Event();
		$this->view = new View();
	}
	public function addAction()
	{
		$action = $this->valid->clearDataArr($_POST);
		$this->event->setData($action);
		if('false' == $action['recuringon'])
		{
			$status = $this->event->checkDateNoRecursion();
			if(true === $status)
			{
				$array[0]=true;
				$this->view->ajax($array);
			}
			else
			{
				$this->view->ajax($status);
			}
		}
		else
		{
			$status = $this->event->checkDateRecursion();
			if(true === $status)
			{
				$array[0]=true;
				$this->view->ajax($array);
			}
			else
			{
				$this->view->ajax($status);
			}
		}
	}
}
?>