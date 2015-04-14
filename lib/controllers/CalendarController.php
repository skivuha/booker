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
		$b = $cal->printCalendar();
		$view = new View;
		$view->addToReplace($b);
		$view->addToReplace($this->langArr);
		$view->setTemplateFile('calendar')->templateRenderContent();
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}

	public function anotherAction()
	{
		$cal = new Calendar();
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
		$view->addToReplace($data);
		$view->addToReplace($this->langArr);
		$view->setTemplateFile('calendar')->templateRenderContent();
		$view->setTemplateFile('workpage')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();

	}

}
?>