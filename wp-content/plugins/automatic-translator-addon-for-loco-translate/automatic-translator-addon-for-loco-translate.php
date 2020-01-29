<?php
/*
Plugin Name:Loco Automatic Translate Addon
Description:Auto language translator add-on for Loco Translate plugin to translate plugins and themes translation files into any language via fully automatic machine translations via yandex Translate API.
Version:1.5
License:GPL2
Text Domain:atlt
Domain Path:languages
Author:Cool Plugins
Author URI:https://coolplugins.net/
 */
namespace LocoAutoTranslateAddon;
use  LocoAutoTranslateAddon\Helpers\Helpers;
 /**
 * @package Loco Automatic Translate Addon
 * @version 1.5
 */
if (!defined('ABSPATH')) {
    die('WordPress Environment Not Found!');
}

define('ATLT_FILE', __FILE__);
define('ATLT_URL', plugin_dir_url(ATLT_FILE));
define('ATLT_PATH', plugin_dir_path(ATLT_FILE));
define('ATLT_VERSION', '1.5');

class LocoAutoTranslate
{
    public function __construct()
    {
        register_activation_hook( ATLT_FILE, array( $this, 'atlt_activate' ) );
        register_deactivation_hook( ATLT_FILE, array( $this, 'atlt_deactivate' ) );
        add_action('plugins_loaded', array($this, 'atlt_check_required_loco_plugin'));
            /*** Template Setting Page Link inside Plugins List */
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this,'atlt_settings_page_link'));
        add_action( 'admin_enqueue_scripts', array( $this, 'atlt_enqueue_scripts') );
        add_action('wp_ajax_atlt_translation', array($this, 'atlt_translate_string_callback'), 100);
        add_action('init',array($this,'checkStatus'));
        add_action('plugins_loaded', array($this,'include_files'));
      
    }

    /**
     * create 'settings' link in plugins page
     */
    public function atlt_settings_page_link($links){
        $links[] = '<a style="font-weight:bold" href="'. esc_url( get_admin_url(null, 'admin.php?page=loco-atlt') ) .'">Settings</a>';
        return $links;
    }

   /*
   |----------------------------------------------------------------------
   | required php files
   |----------------------------------------------------------------------
   */
   public function include_files()
   {
        include_once ATLT_PATH . 'includes/Helpers/Helpers.php';
        include_once ATLT_PATH . 'includes/Core/class.settings-api.php';
        include_once ATLT_PATH . 'includes/Core/class.settings-panel.php';
        new Core\Settings_Panel();
         if ( is_admin() ) {
            include_once ATLT_PATH . "includes/ReviewNotice/class.review-notice.php";
            new ALTLReviewNotice\ALTLReviewNotice(); 
            include_once ATLT_PATH . 'includes/Feedback/class.feedback-form.php';
            new FeedbackForm\FeedbackForm();
                //require_once ATLT_PATH . "includes/init-api.php";  
            include_once ATLT_PATH . 'includes/Register/LocoAutomaticTranslateAddonPro.php';
            } 
        
   }
   public function checkStatus(){
         Helpers::checkPeriod();
   }
  
   /*
   |----------------------------------------------------------------------
   | check if required "Loco Translate" plugin is active
   | also register the plugin text domain
   |----------------------------------------------------------------------
   */
   public function atlt_check_required_loco_plugin()
   {

      if (!function_exists('loco_plugin_self')) {
         add_action('admin_notices', array($this, 'atlt_plugin_required_admin_notice'));
      }
      load_plugin_textdomain('atlt', false, basename(dirname(__FILE__)) . '/languages/');

   }

   /*
   |----------------------------------------------------------------------
   | Notice to 'Admin' if "Loco Translate" is not active
   |----------------------------------------------------------------------
   */
   public function atlt_plugin_required_admin_notice()
   {
      if (current_user_can('activate_plugins')) {
         $url = 'plugin-install.php?tab=plugin-information&plugin=loco-translate&TB_iframe=true';
         $title = "Loco Translate";
         $plugin_info = get_plugin_data(__FILE__, true, true);
         echo '<div class="error"><p>' . sprintf(__('In order to use <strong>%s</strong> plugin, please install and activate the latest version of <a href="%s" class="thickbox" title="%s">%s</a>', 'atlt'), $plugin_info['Name'], esc_url($url), esc_attr($title), esc_attr($title)) . '.</p></div>';
         deactivate_plugins(__FILE__);
      }
   }

   /*
   |------------------------------------------------------
   |   Send Request to  yandex API
   |------------------------------------------------------
  */
  public function yandex_api_call($stringArr,$target_language,$source_language,$requestType,$apiKey){
        // create query string 
        $queryString='';
        $langParam = $source_language.'-'.$target_language;
      
        if(is_array($stringArr)){
            foreach($stringArr as $str){
                $queryString.='&text='.urlencode($str);
            }
        }
        // build query
        $buildReqURL='';
        $buildReqURL.='https://translate.yandex.net/api/v1.5/tr.json/translate';
        $buildReqURL.='?key=' . $apiKey . '&lang=' . $langParam.'&format='.$requestType;
        $buildReqURL.=$queryString;
        // get API response 
        $response = wp_remote_get($buildReqURL, array('timeout'=>'180'));

        if (is_wp_error($response)) {
            return $response; // Bail early
        }
        $body = wp_remote_retrieve_body($response);
        // convert string into assoc array
        $data = json_decode( $body, true);  
        return $data; 
    }


    /*
   |----------------------------------------------------------------------
   | AJAX called to this function for translation
   |----------------------------------------------------------------------
   */
  public function atlt_translate_string_callback()
  {
      // verify request
    if ( ! wp_verify_nonce($_REQUEST['nonce'], 'atlt_nonce' ) ) {
           die(json_encode(array('code' => 850, 'message' => 'Request Time Out. Please refresh your browser window.')));
       } else {
               // user status
           $status=Helpers::atltVerification();
           if($status['type']=="free" && $status['allowed']=="no"){
               die(json_encode(array('code' => 800, 'message' => 'You have cons med daily limit')));
           }
           // get request vars
           if (empty($_REQUEST['data'])) {
               die(json_encode(array('code' => 900, 'message' => 'Empty request')));
           }  
       if(isset($_REQUEST['data'])){
           $responseArr=array();
           $response=array();
         
           $requestData = $_REQUEST['data'];
           $targetLang=$_REQUEST['targetLan'];
           $sourceLang=$_REQUEST['sourceLan'];
           if($targetLang=="nb" || $targetLang=="nn"){
               $targetLang="no";
           }
        
           $request_chars  = $_REQUEST['requestChars'];
           $totalChars  = $_REQUEST['totalCharacters'];
           $requestType=$_REQUEST['strType'];  
           $apiType=$_REQUEST['apiType'];  
           $stringArr= json_decode(stripslashes($requestData),true);  
          
            if($apiType=="google"){
                $g_api_key= Helpers::getAPIkey("google");
                if(empty($g_api_key)||$g_api_key==""){
                    die(json_encode(array('code' => 902, 'message' => 'You have not Entered Google Translate API Key')));  
                }
                $apiKey = $g_api_key;

                if(is_array( $stringArr)&& !empty($stringArr))
                {
                    $response=$this->translate_array($stringArr,$targetLang,$sourceLang, $apiKey);
                    if(is_array($response)&& count($response)>=1)
                    {
                    $responseArr['translatedString']=$response;
                    $responseArr['code']=200;   
                        // grab translation count data
                    $responseArr['stats']= $this->saveStringsCount($request_chars,$totalChars,$apiType);
                     }else{

                    $responseArr['code']=500;  
                    $responseArr['message']=$response;
                    
                     }
            }
            }else{
                   // grab API keys
                   $api_key = Helpers::getAPIkey("yandex");
                  
                   if(empty($api_key)|| $api_key==""){
                    die(json_encode(array('code' => 902, 'message' => 'You have not Entered yandex API Key')));  
                   }
                   $apiKey = $api_key;
                if(is_array( $stringArr)&& !empty($stringArr))
                {
                   $response=$this->yandex_api_call($stringArr,$targetLang,$sourceLang,$requestType,$apiKey);

                   if(is_array($response) && $response['code']==200)
                    {
                        // grab translation count data
                    $responseArr['code']=200;       
                    $responseArr['translatedString']= $response['text'];        
                    $responseArr['stats']= $this->saveStringsCount($request_chars,$totalChars,$apiType);
                    }else{
                     $responseArr['code']=500;  
                     $responseArr['message']=$response['errors']['http_request_failed'];
                    }
                 }
            }
           
            die(json_encode($responseArr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
     
       }  
     
    }

 }
  

   
    public function saveStringsCount($request_chars,$totalChars,$apiType)
    {
        if($apiType=="google"){
            $today_translated = Helpers::gTodayTranslated( $request_chars);
            $monthly_translated = Helpers::gMonthlyTranslated( $request_chars);
        }else{
        $today_translated = Helpers::todayTranslated( $request_chars);
        $monthly_translated = Helpers::monthlyTranslated( $request_chars);
        }
        /** Calculate the total time save on translation */
        $session_time_saved = Helpers::atlt_time_saved_on_translation( $totalChars);
        $total_time_saved = Helpers::atlt_time_saved_on_translation($totalChars);
        // create response array
      
        $stats=array(
                        'todays_translation'=>$today_translated,
                        'total_translation'=>$monthly_translated,
                        'time_saved'=> $session_time_saved,
                        'total_time_saved'=>$total_time_saved,
                        'totalChars'=>$totalChars
                    );
        return $stats;
    }
  /*
   |------------------------------------------------------
   |   Send Request to API
   |------------------------------------------------------
  */
   /**
     * @param array $strings_array          Array of string to translate
     * @return array|WP_Error               Response
     */
    public function send_request( $source_language, $target_language, $strings_array,$apiKey ){
       // $apiKey='AIzaSyAA575IhTNuMrgS-ISe23WlGmjs4LGZu58';

        /* build our translation request */
        $translation_request = 'key='.$apiKey;
      
        $translation_request .= '&source='.$source_language;
        $translation_request .= '&target='.$target_language;
        foreach( $strings_array as $new_string ){
            $translation_request .= '&q='.rawurlencode($new_string);
        }
       // $referer =

        /* Due to url length restrictions we need so send a POST request faked as a GET request and send the strings in the body of the request and not in the URL */
        $response = wp_remote_post( "https://www.googleapis.com/language/translate/v2", array(
                'headers' => array(
                    'X-HTTP-Method-Override' => 'GET', //this fakes a GET request
                //    'Referer'                => $referer
                ),
                'body' => $translation_request,
            )
        );
        return $response;
    }



   /*
   |------------------------------------------------------
   |   Translate Array
   |------------------------------------------------------
   */

    /**
     * Returns an array with the API provided translations of the $new_strings array.
     */
    public function translate_array($new_strings, $target_language_code, $source_language_code,$api_key ){
      
        if( empty( $new_strings ) )
            return array();

        $source_language =$source_language_code;
        $target_language = $target_language_code;

        $translated_strings = array();

        /* split our strings that need translation in chunks of maximum 128 strings because Google Translate has a limit of 128 strings */
        $new_strings_chunks = array_chunk( $new_strings, 128, true );
        /* if there are more than 128 strings we make multiple requests */
        foreach( $new_strings_chunks as $new_strings_chunk ){
            $response = $this->send_request( $source_language, $target_language, $new_strings_chunk,$api_key );
            /* analyze the response */
            if ( is_array( $response ) && ! is_wp_error( $response ) ) {

                /* decode it */
                $translation_response = json_decode( $response['body'] );
                if( !empty( $translation_response->error ) ){
                    return array(); // return an empty array if we encountered an error. This means we don't store any translation in the DB
                }
                else{
                    /* if we have strings build the translation strings array and make sure we keep the original keys from $new_string */
                    $translations = $translation_response->data->translations;
                    $i = 0;
                    foreach( $new_strings_chunk as $key => $old_string ){
                        if( !empty( $translations[$i]->translatedText ) ) {
                            $translated_strings[$key] = $translations[$i]->translatedText;
                        }
                        $i++;
                    }
                }
            }
    
        }

        // will have the same indexes as $new_string or it will be an empty array if something went wrong
        return $translated_strings;
    }

     /*
   |------------------------------------------------------------------------
   |  Enqueue required JS file
   |------------------------------------------------------------------------
   */
   function atlt_enqueue_scripts(){
    wp_deregister_script('loco-js-editor');
    wp_register_script( 'sweet-alert', ATLT_URL.'assets/sweetalert/sweetalert.min.js', array('loco-js-min-admin'),false, true);
    wp_register_script( 'loco-js-editor', ATLT_URL.'assets/js/loco-js-editor.min.js', array('loco-js-min-admin'),false, true);
    
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'file-edit')
     {
         $data=array();
         wp_enqueue_script('sweet-alert');
         wp_enqueue_script('loco-js-editor');
         $status=Helpers::atltVerification();

         $data['api_key']['yApiKey']=Helpers::getAPIkey("yandex");
         $data['info']['yAvailableChars']=Helpers::getAvailableChars("yandex");
         $data['nonce']= wp_create_nonce('atlt_nonce');

         if($status['type']=="free"){
             $data['info']=Helpers::atltVerification();
         }else{
             $data['api_key']['gApiKey']=Helpers::getAPIkey("google");
             $key=Helpers::getLicenseKey();
             if(Helpers::validKey( $key)){
                 $data['info']['type']="pro";
                 $data['info']['allowed']="yes";
                 $data['info']['licenseKey']=$key;
                 $data['info']['gAvailableChars']=Helpers::getAvailableChars("google");
             }
         }

         $extraData['preloader_path']=ATLT_URL.'/assets/images/preloader.gif';
         wp_localize_script('loco-js-editor', 'ATLT', $data);
         wp_localize_script('loco-js-editor', 'extradata', $extraData);
         
    }

}

   /*
   |------------------------------------------------------
   |    Plugin activation
   |------------------------------------------------------
    */
   public function atlt_activate(){
       $plugin_info = get_plugin_data(__FILE__, true, true);
       update_option('atlt_version', $plugin_info['Version'] );
       update_option("atlt-installDate",date('Y-m-d h:i:s') );
       update_option("atlt-ratingDiv","no");
       update_option("atlt-type","free");
   }



   /*
   |-------------------------------------------------------
   |    Plugin deactivation
   |-------------------------------------------------------
   */
   public function atlt_deactivate(){

   }

}
  
$atlt=new LocoAutoTranslate();
  

