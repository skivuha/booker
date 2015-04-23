<?php
class CalendarController extends Controller
{

	private $arrRender;

	public function __construct()
	{
		$this->accessToCalendar();
		$this->arrayLang();
	}

	public function indexAction()
	{
		$cal = new Calendar();
		$cal->setUserRole($this->userRole);
		$cal->setFirstDay($this->getFirstDay());
		$cal->setTimeFormat($this->getTimeFormat());
		$b = $cal->printCalendar();
		$view = new View;
		if(true === $this->userRole)
		{
			$b['ADMIN'] = $view->setTemplateFile('employee')->renderFile();
		}

		$view->addToReplace($b);
		$view->addToReplace($this->langArr);

		$view->setTemplateFile('calendar')->templateRenderContent();
		$this->listRoom();
		$view->addToReplace($this->arrRender);
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}

	public function anotherAction()
	{
		$cal = new Calendar();
		$cal->setFirstDay($this->getFirstDay());
		$cal->setTimeFormat($this->getTimeFormat());
		$cal->setUserRole($this->userRole);
		$getParam = false;
		$data = Router::getInstance();
		$params = $data->getParams();
		if(isset($params))
		{
			$getParam = true;
		}
		$cal->setFlagParams($getParam);
		$data = $cal->printCalendar();
		$view = new View;
		if(true === $this->userRole)
		{
			$data['ADMIN'] = $view->setTemplateFile('employee')->renderFile();
		}
		$view->addToReplace($data);
		$view->addToReplace($this->langArr);
		$view->setTemplateFile('calendar')->templateRenderContent();
		$this->listRoom();
		$view->addToReplace($this->arrRender);
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}
	public function logoutAction()
	{
		session_destroy();
		$this->cookie->remove('code_employee');
		header('Location: '.PATH.'');
	}

	private function listRoom()
	{
		$cal = new Calendar();
		$view = new View;
		$room = $cal->getListRoom();
		foreach($room as $key => $val)
		{
			$arr = array('ROOM_ID' => $val['id_room'],
						 'ROOM_NAME' => $val['name_room']);
			$view->addToReplace($arr);
			$this->arrRender['ROOMLIST'] .= $view->
			setTemplateFile('room')->renderFile();
		}
	}
}
?>