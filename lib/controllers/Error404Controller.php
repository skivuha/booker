<?php
class Error404Controller extends Controller
{
	public function __construct()
	{
		self::index();
	}

	public static function index()
	{
		$view = new View();
		$view->setTemplateFile('err404')->templateRender();

	}
}
?>