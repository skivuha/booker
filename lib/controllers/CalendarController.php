<?php
class CalendarController extends Controller
{

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
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}

	public function anotherAction()
	{
		$cal = new Calendar();
		$cal->setFirstDay($this->getFirstDay());
		$cal->setTimeFormat($this->getTimeFormat());
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
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}
	public function logoutAction()
	{
		session_destroy();
		$this->cookie->remove('code_employee');
		header('Location: '.PATH.'');
	}
}
?>