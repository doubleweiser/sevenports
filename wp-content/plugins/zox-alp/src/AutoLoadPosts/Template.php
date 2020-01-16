<?php
namespace AutoLoadPosts;

class Template
{
	public function Show($file, $data = null)
	{
		require_once(ALP_PLUGIN_TEMPLATES_PATH . $file . '.php');
	}
	
	public function Get($file, $data = null)
	{
		ob_start();
		$this->Show($file, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	
}