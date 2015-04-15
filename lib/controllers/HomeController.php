<?php

class HomeController extends Controller
{


	public function indexAction()
	{
		$view = new View;
		$auth = new Auth();
		$signin = false;
		if (isset($_POST['signin']))
		{
			$signin = true;
		}
		$resultAuth = $auth->logon($signin);
		if (true === $resultAuth || true === $this->userAuth)
		{
			header('Location: '.PATH.'Calendar/index');
		}
		else
		{
			$view->addToReplace($resultAuth);
			$view->addToReplace($this->langArr);
			$view->setTemplateFile('login')->templateRenderContent();
		}
		$view->setTemplateFile('index')->templateRender();
	}
}

?>