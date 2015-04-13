<?php
class CalendarController extends Controller
{
	public function __construct()
	{
		$this->accessToCalendar();
	}
	public function indexAction()
	{
		$cal = new Calendar();
		$a = $cal->getCalendar();
		$b = $cal->printCalendar();
		$view = new View;
		$view->addToReplace($b);
		$view->setTemplateFile('calendar')->templateRenderContent();
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}

	public function anotherAction()
	{
		$getParam = false;
		$data = Router::getInstance();
		$params = $data->getParams();
		if(isset($params))
		{
			$getParam = true;
		}
		$cal = new Calendar();
		$data = $cal->printCalendar();
		$view = new View;
		$view->addToReplace($data);
		$view->setTemplateFile('calendar')->templateRenderContent();
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();

	}

}
?>