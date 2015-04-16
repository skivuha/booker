<?php
class EmployeeController extends Controller
{
	private $data;
	private $employee;
	private $arrRender;
	private $view;

	public function __construct()
	{
		$this->data = Router::getInstance();
		$this->employee = new Employee();
		$this->view = new View;
		$this->valid = new Validator();
		$this->accessToCalendar();
		$this->arrayLang();
	}
	
	public function indexAction()
	{
	if(isset($_POST['submit']))
	{
	    $action = $this->valid->clearDataArr($_POST);
	    $this->employee->setDataArray($action);
	    //header('Location: '.PATH.'Employee/index/');
	}
		$this->view->addToReplace($this->langArr);
		$this->listEmployee();
		$this->arrayToPrint();
	}
	
	public function deleteAction()
	{
		$params = $this->data->getParams();
		$params = $this->valid->clearDataArr($params);
		if(isset($params['id']))
		{
			$this->employee->setFlag(true);
		}
		if(true === $this->employee->deleteEmployee())
		{
			header('Location: '.PATH.'Employee/index/');
		}
	}
	public function editAction()
	{
		$params = $this->data->getParams();
		$params = $this->valid->clearDataArr($params);
	if(isset($params['id']))
	    {
		$this->employee->setFlag(true);
	    }
	if(isset($_POST['submit']))
	    {
		$action = $this->valid->clearDataArr($_POST);
		$this->employee->setDataArray($action);
		header('Location: '.PATH.'Employee/index/');
	    }
	    $employee = $this->employee->editEmployee();
	    $this->view->addToReplace($employee);
	    $this->listEmployee();
	    $this->arrayToPrint();
	}

	private function arrayToPrint()
	{
		$this->view->addToReplace($this->arrRender);
		$this->view->setTemplateFile('employeeedit')->templateRenderContent();
		$this->view->setTemplateFile('index')->templateRender();
	}

	private function listEmployee()
	{
		$employees = $this->employee->getEmployee();
		$cnt = 1;
		foreach($employees as $key => $val)
		{
			$arr = array('CNT'=>$cnt,'EMPLOYEE_NAME'=>$val['name_employee'],
									 'EMPLOYEE_ID'=>$val['id_employee']);
			$cnt++;
			$this->view->addToReplace($arr);
			$this->arrRender['LISTEMPLOYEES'] .= $this->view->setTemplateFile
			('employeeslist')
				->renderFile();
		}
	}
}
?>