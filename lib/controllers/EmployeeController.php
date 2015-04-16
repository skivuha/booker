<?php
class EmployeeController extends Controller
{
	public function __construct()
	{
		$this->accessToCalendar();
		$this->arrayLang();
	}
	public function indexAction()
	{
		$view = new View;
		$employee = new Employee();
		$view->addToReplace($this->langArr);
		$employees = $employee->getEmployee();
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

	}
}
?>