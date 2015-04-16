<?php

/**
 * Class: View
 *
 */
class View
{
	private $forRender;
	private $file;
	private $template;

	public function __construct()
	{
		$this->forRender = array();
	}

	public function setTemplateFile($template)
	{
		$this->template = $template;
		$template = TEMPLATE . $template . '.html';
		if (is_file($template))
		{
			$this->file = file_get_contents($template);

			return $this;
		}
		else
		{
			throw new Exception('No template file');
		}
	}

	public function addToReplace($mArray)
	{
		if (is_array($mArray))
		{
			foreach ($mArray as $key => $val)
			{
				$this->forRender[$key] = $val;
			}
		}
	}

	private function langRender()
	{
		foreach ($this->forRender as $key => $val)
		{
			$this->file = preg_replace('/%LANG_' . $key . '%/i', $val, $this->file);
		}
	}

	public function renderFile()
	{
		foreach ($this->forRender as $key => $val)
		{
			$this->file = preg_replace('/{{' . $key . '}}/i', $val, $this->file);
		}
		return $this->file;
	}

	public function templateRenderContent()
	{
		$this->renderFile();
		$default = '';
		$this->file = preg_replace('/{{(.*)}}/Uis', $default, $this->file);
		$this->forRender['CONTENT'] = $this->file;
	}


	public function templateRender()
	{
		$this->renderFile();
		$this->langRender();

		$default = '';
		$this->file = preg_replace('/{{(.*)}}/Uis', $default, $this->file);
		echo $this->file;
	}
}

?>