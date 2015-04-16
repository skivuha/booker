<?php
class EmployeeController extends Controller
{
	private $data;
	private $employee;

	public function __construct()
	{
		$this->data = Router::getInstance();
		$this->employee = new Employee();
		$this->valid = new Validator();
		$this->accessToCalendar();
		$this->arrayLang();
	}
	public function indexAction()
	{
		$view = new View;
		$view->addToReplace($this->langArr);
		$employees = $this->employee->getEmployee();
		$cnt = 1;
		foreach($employees as $key => $val)
		{
			$arr = array('CNT'=>$cnt,'EMPLOYEE_NAME'=>$val['name_employee'],
				'EMPLOYEE_ID'=>$val['id_employee']);
			$cnt++;
			$view->addToReplace($arr);
			$arrRender['LISTEMPLOYEES'] .= $view->setTemplateFile('employeeslist')
				->renderFile();
		}
		$view->addToReplace($arrRender);
		$view->setTemplateFile('employeeedit')->templateRenderContent();
		$view->setTemplateFile('index')->templateRender();
	}

	public function deleteAction()
	{
		$params = $this->data->getParams();
		$params = $this->valid->clearDataArr($params);
		if(isset($params['id']))
		{
			$this->employee->setDelete(true);
		}
		if(true === $this->employee->deleteEmployee())
		{
			header('Location: '.PATH.'Employee/index/');
		}
	}

	public function editAction()
	{
		
	}
}
?>