<?php

define('ALP_PLUGIN_PATH', __DIR__ . '/');
define('ALP_PLUGIN_SRC_PATH', ALP_PLUGIN_PATH . 'src/');
define('ALP_PLUGIN_TEMPLATES_PATH', ALP_PLUGIN_PATH . '/templates/');
define('ALP_PLUGIN_SCRIPTS_PATH', ALP_PLUGIN_PATH . '/scripts/');
define('ALP_PLUGIN_LANGUAGES_REL_PATH', dirname(plugin_basename(__FILE__)) . '/languages/');

define('ALP_PLUGIN_URL', plugin_dir_url(__FILE__ ));
define('ALP_PLUGIN_STYLES_URL', ALP_PLUGIN_URL . '/styles/');
define('ALP_PLUGIN_SCRIPTS_URL', ALP_PLUGIN_URL . '/scripts/');

define('ALP_PLUGIN_DOMAIN', 'auto-load-posts');

spl_autoload_register(function($class)
{
	$file = ALP_PLUGIN_SRC_PATH . str_replace('\\', '/', $class) . '.php';
	if(file_exists($file))
		require_once($file);
});