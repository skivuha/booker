<?php
class EventController extends Controller
{
	private $valid;
	private $event;
	private $data;

	public function __construct()
	{
		$this->data = Router::getInstance();
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
	public function editAction()
	{
		$param = $this->data->getParams();
		$param = $this->valid->numCheck($param['id']);
		$this->event->setData($param);
		$this->event->userRole($this->userRole);
		$arrayToDetails = $this->event->detailsEvent();
		$this->view->addToReplace($arrayToDetails);
		$this->view->setTemplateFile('details')->templateRender();
	}

	public function updateAction()
	{
		$param = $this->data->getParams();
		$name = $this->valid->clearData($param['do']);
		$id = $this->valid->numCheck($param['id']);
		if('delete' == $name)
			{
				if(isset($_POST['recurrences']))
				{
					$recur = $this->valid->numCheck($_POST['recurrences']);
					$this->event->setRecurent($recur);
				}
				$this->event->setData($id);
				$this->event->deleteEvent();
			}
		if('update' == $name)
		{
			$param = $this->valid->clearDataArr($_POST);
			if(isset($_POST['recurrences']))
			{
				//$recur = $this->valid->numCheck($_POST['recurrences']);
				//$this->event->setRecurent($recur);
			}
			$param['update'] = $id;
			$this->event->setData($param);
			$status = $this->event->updateEvent();
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