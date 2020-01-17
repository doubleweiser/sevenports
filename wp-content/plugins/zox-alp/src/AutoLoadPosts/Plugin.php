<?php
namespace AutoLoadPosts;

class Plugin
{
	public function Init()
	{
		add_action('plugins_loaded', array($this, 'LoadTextDomain'));
		add_action('wp_enqueue_scripts', array($this, 'RegisterStyles'));
		add_action('wp_enqueue_scripts', array($this, 'RegisterScripts'));
		
		$RelatedPostsWidget = new RelatedPostsWidget();
		$RelatedPostsWidget->init();
		
//		$RentReceipt = new RentReceipt();
//		$RentReceipt->Init();
	}
	
	public function LoadTextDomain()
	{
		load_plugin_textdomain(ALP_PLUGIN_DOMAIN, false, ALP_PLUGIN_LANGUAGES_REL_PATH);
	}
	
	public function RegisterStyles()
	{
		wp_enqueue_style('ql-jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
		wp_enqueue_style('ql-main', ALP_PLUGIN_STYLES_URL . 'main.css', array('ql-bootstrap', 'ql-jquery-ui'));
	}
	
	public function RegisterScripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		
		//wp_enqueue_script('jquery-history', ALP_PLUGIN_SCRIPTS_URL . 'jquery.history.js', array('jquery'), false, true);
		wp_enqueue_script('jquery-sticky-kit', ALP_PLUGIN_SCRIPTS_URL . 'jquery.sticky-kit.min.js', array('jquery'), false, true);
		wp_enqueue_script('jquery-waypoints', ALP_PLUGIN_SCRIPTS_URL . 'jquery.waypoints.min.js', array('jquery'), false, true);
		
		$data = array();
		$data['ajaxurl'] = admin_url('admin-ajax.php');
		$params = array(
			'l10n_print_after' => 'alp_config = ' . json_encode($data) . ';'
		);
		
	}
}
