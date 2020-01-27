<?php
/*
|------------------------------------------------------------------------
|   Settings panel
|------------------------------------------------------------------------
*/
namespace LocoAutoTranslateAddon\Core;
use LocoAutoTranslateAddon\Helpers\Helpers;

if( !class_exists( 'Settings_Panel' ) ){
    class Settings_Panel {
        
        public $settings_api;
        public $PREFIX;
        public function __construct(){
                $this->settings_api = new Settings_API;
                $this->PREFIX = 'atlt_';    
                add_action('admin_init', array($this, 'admin_init' ) );
                add_action('admin_menu', array( $this, 'admin_menu' ),100 );
                add_action('admin_notices', array( $this, 'missing_api_key') );
        }


        /*
        |------------------------------------------
        |    Initialize settings section
        |------------------------------------------
        */
        public function admin_init(){
            $this->settings_api->set_sections( $this->get_settings_sections() );            
            $this->settings_api->set_fields( $this->get_settings_fields() );            
            $this->settings_api->admin_init();
        }

        /*
        |--------------------------------------------------------------------
        |   Create multiple section in settings page using array in $sections
        |--------------------------------------------------------------------
        */
        public function get_settings_sections()
        {
                $sections = array(

                    array(
                        'id' => $this->PREFIX.'register',
                        'title' => __('Loco Automatic Translate Addon Settings', 'cmb2'),
                    )
                );
                return $sections;
        }

        
        public function create_google_stats_tbl(){
            $month = get_option('g_translation_month');
            $total_translation = get_option('g_month_translated_chars', 0);
            $a_per_mon=0;
            $total_aval=0;
            $a_per_mon=500000;
            $total_aval=$a_per_mon-$total_translation;
            $info_tbl='<table>
            <tr>
                <th>Total Characters</th>
                <th>'.number_format($a_per_mon).' / Month</th>
                <th>Special Note</th>
            </tr>
            <tr>
                <td><strong>Used Characters</strong></td>
                <td>'.number_format($total_translation).'<br/><span>(Used This Month)</span></td>
                <td rowspan="2" style="max-width:200px;">Plugin do not provide any free translation limit. All free characters translation limit provided by translate API providers - Google, Yandex, Microsoft etc.</td>
            </tr>
            <tr> 
                <td><strong>Available Characters</strong></td>
                <td>'.number_format($total_aval).'<br/><span>(Available This Month)</span></td>
                </tr>
            </table>
            *Check your correct translation limit usage inside API dashboard if you are using same API key on multiple sites.';
            return $info_tbl;
        }


        /*
        |--------------------------------------------------------------------
        |   return all settings fields to be initialized in settings page
        |--------------------------------------------------------------------
        */
        public function get_settings_fields()
        {

            $month = get_option('atlt_translation_month');
            $today = ('atlt_translation_day');
            $total_translation = get_option('atlt_month_translated_chars', 0);
            $todays_total_translation = get_option('atlt_perday_translated_chars', 0);
            $a_per_day=0;
            $a_per_mon=0;
            $today_aval=0;
            $total_aval=0;
          
            $key=Helpers::getLicenseKey();

            $LS_html='';
            if(Helpers::userType()=="free"){
                $LS_html='<table>
                <tr>
                    <th><strong>FREE User</strong></th>
                    <th><a href="?page=loco-atlt-register">Enter License Key<br/><span>(Click Here!)</span></a></th>
                    <th><a target="_blank" href="https://locotranslate.com/addon/loco-automatic-translate-premium-license-key/#pricing">Buy Pro License Key<br/><span>(Increase Translation Limit!)</span></a></th>
                </tr>
                </table>';
                 $a_per_day=300000;
                 $a_per_mon=1000000;
                 $today_aval= $a_per_day-$todays_total_translation;
                 $total_aval=$a_per_mon-$total_translation;
                
            }else{
                $key=Helpers::getLicenseKey();
                if(Helpers::validKey( $key)){
                 $LS_html='<table>
                 <tr>
                     <th><strong>PREMIUM User</strong></th>
                     <th><a href="?page=loco-atlt-register">Check License Validity Status<br/><span>(Click Here!)</span></a></th>
                 </tr>
                 </table>';
                 $a_per_day=1000000;
                 $a_per_mon=10000000;
                 $today_aval= $a_per_day-$todays_total_translation;
                 $total_aval=$a_per_mon-$total_translation;
                }      
            }
            $info_tbl='<table>
            <tr>
                <th>Total Characters</th>
                <th>'.number_format($a_per_day).' / Day</th>
                <th>'.number_format($a_per_mon).' / Month</th>
            </tr>
            <tr>
                <td><strong>Used Characters</strong></td>
                <td>'.number_format($todays_total_translation).'<br/><span>(Used Today)</span></td>
                <td>'.number_format($total_translation).'<br/><span>(Used This Month)</span></td>
            </tr>
            <tr> 
                <td><strong>Available Characters</strong></td>
                <td>'.number_format($today_aval).'<br/><span>(Available Today)</span></td>
                <td>'.number_format($total_aval).'<br/><span>(Available This Month)</span></td>
                </tr>
            </table>';


            $pro_per_day=1000000;
            $pro_per_mon=10000000;
            $pro_info='<table>
                <tr>
                    <th><a href="https://locotranslate.com/addon/loco-automatic-translate-premium-license-key/#pricing" target="_blank">Buy Pro License Key</a></th>
                    <th>'.number_format($pro_per_day).' / Day</th>
                    <th>'.number_format($pro_per_mon).' / Month</th>
                </tr>
                </table>';
          
            $settingArr[]=array(
                'name'  => $this->PREFIX.'api-key',
                'id'    => $this->PREFIX.'api-key',
                'class' => $this->PREFIX.'settings-field',
                'label'  => 'Enter Yandex Translate<br/>API Key:',
                'desc'  => '<a target="_blank" href="https://tech.yandex.com/translate/">Click here to get free Yandex API key.</a><br/>',
                'type'  => 'text',
                'placeholder'=>__('Yandex API Key','cmb2'),
                'default' => ''
            );
       if(Helpers::userType()=="pro") {
        $key=Helpers::getLicenseKey();
        if(Helpers::validKey( $key)){
            $settingArr[]=array(
                'name'  => $this->PREFIX.'google-api-key',
                'id'    => $this->PREFIX.'google-api-key',
                'class' => $this->PREFIX.'settings-field',
                'label'  => 'Enter Google Translate<br>API Key:',
                'desc'  => '<a href="https://locotranslate.com/howto-generate-google-translate-api-key/">Please check API key generation guide</a>',
                'type'  => 'text',
                'placeholder'=>__('Google Translate API Key','cmb2'),
                'default' => ''
            );
        }
        }else{
                $settingArr[]=
                array(
                    'name'  => $this->PREFIX.'google-api-key-demo',
                    'id'    => $this->PREFIX.'google-api-key-demo',
                    'class' => $this->PREFIX.'settings-field',
                    'label' => 'Enter Google Translate<br>API Key:',
                    'desc'  =>'<a href="https://locotranslate.com/addon/loco-automatic-translate-premium-license-key/#pricing" target="_blank"><img  style="width:auto" src="'.ATLT_URL.'/assets/images/google-api.png" alt="Add Google Translate API Key"></a>',
                    'type'  => 'html'
                );
        }
            $settingArr[]= array(
                'name'  => $this->PREFIX.'index-per-request',
                'id'    => $this->PREFIX.'index-per-request',
                'class' => $this->PREFIX.'settings-field',
                'label'  => 'Index Per Request:',
                'desc'  => 'Number of strings index to send to Yandex in every request. Decrease it if you have long strings inside your loco translate table fields.'.$this->welcome_tab(),
                'type'  => 'number',
                'placeholder'=>__('50','cmb2'),
                'default' => '50'
            );

           
           // if(Helpers::userType()=="pro") {
               
           // }
            $settingArr[]=
            array(
                'name'  => $this->PREFIX.'traslation-limit',
                'id'    => $this->PREFIX.'traslation-limit',
                'class' => $this->PREFIX.'settings-field',
                'label' => 'Yandex Translate<br>Free Translation Limit:',
                'desc'  => $info_tbl,
                'type'  => 'html'
            );
            if(Helpers::userType()=="free") {
                $settingArr[]=  array(
                    'name'  => $this->PREFIX.'upgrade-to-pro',
                    'id'    => $this->PREFIX.'upgrade-to-pro',
                    'class' => $this->PREFIX.'settings-field',
                    'label' => 'Increase Translation Limit:',
                    'desc'  => $pro_info,       
                    'type'  => 'html'
                );
            }else{
               
                $settingArr[]= array(
                'name'  => $this->PREFIX.'google-traslation-limit',
                'id'    => $this->PREFIX.'google-traslation-limit',
                'class' => $this->PREFIX.'settings-field',
                'label' => 'Google Translate<br>Free Translation Limit:',
                'desc'  =>$this->create_google_stats_tbl(),
                'type'  => 'html'
            ); 
            }
            $settingArr[]= array(
                'name'  => $this->PREFIX.'license-status',
                'id'    => $this->PREFIX.'license-status',
                'class' => $this->PREFIX.'settings-field',
                'label' => 'Current License Status:',
                'desc'  => $LS_html,
                'type'  => 'html'
            );
            $settingArr[]= array(
                'name'  => $this->PREFIX.'rating',
                'id'    => $this->PREFIX.'rating',
                'label' => 'Share Your Review:',
                'desc'  => $this->rate_now(),
                'type'  => 'html'
            );
            $settingArr[]=  array(
                'name'  => $this->PREFIX.'screenshort',
                'id'    => $this->PREFIX.'screenshort',
                'label' => 'Usage Instructions:',
                'desc'  => $this->screenshort(),
                'type'  => 'html'
            );
            $settings_fields = array(
                $this->PREFIX.'register' =>  $settingArr
            );
            return $settings_fields;
        }

        public function welcome_tab(){
            //$this->ce_get_option($this->PREFIX.'-api-key');
            return get_submit_button('Save');

        }

        public function rate_now(){
            $like_it_text='Rate Now! ★★★★★';
            $p_link=esc_url('https://wordpress.org/support/plugin/automatic-translator-addon-for-loco-translate/reviews/#new-post');
            $ajax_url=admin_url( 'admin-ajax.php' );
            $html ='<p>Thanks for using Loco Automatic Translate Addon - WordPress plugin. We hope it has saved your valuable time and efforts! <br/>Please give us a quick rating, it works as a boost for us to keep working on more <a href="https://coolplugins.net/">Cool Plugins!</a></p>
            <a href="'.$p_link.'" class="like_it_btn button button-primary" target="_new" title="'.$like_it_text.'">'.$like_it_text.'</a>
            ';            
            return $html;
        }

        public function screenshort(){
            
            $src = ATLT_URL .'assets/images/screenshot-1.gif';
            $html = '<img src="'.$src.'" width="100%">';

            return $html;
        }
        /*
        |---------------------------------------------------
        |   Add settings page to wordpress menu
        |---------------------------------------------------
        */
        public function admin_menu()
        {
                add_submenu_page( 'loco','Loco Auto Translator', 'Auto Translator Addon - Settings', 'manage_options', 'loco-atlt', array($this, 'atlt_settings_page'));
        }

        public function atlt_settings_page(){
            
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms('Save',false);

        }

        /*
        |---------------------------------------------------------
        |   Gather settings field-values like get_options()
        |---------------------------------------------------------
        */
        public function ce_get_option($option, $default = '')
        {

            $section = $this->PREFIX.'register';
            $options = get_option($section);

            if (isset($options[$option])) {
                return $options[$option];
            }

            return $default;
        }

        /*
        |-----------------------------------------------------------
        |   Show message in case of no api-key is saved
        |-----------------------------------------------------------
        */
        public function missing_api_key(){

            $api_key = $this->ce_get_option( $this->PREFIX.'api-key');

            if( isset( $api_key ) && !empty( $api_key ) ){
                return;
            }

            // Show API message only in translation editor page
            if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'file-edit' ){
                $plugin_info = get_plugin_data( ATLT_FILE , true, true );

                $message = sprintf('You must provide an %s to use the functionality of <strong>%s</strong>','<a href="'.admin_url('admin.php?page=loco-atlt').'">API key</a>',$plugin_info['Name']);

                $translation = __($message,'atlt');

                $HTML = '<div class="notice notice-warning inline is-dismissible"><p>'.$translation.'</p></div>';
                echo $HTML;
            }else if( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'loco-atlt' ){
                
                $message = sprintf('Get a free API KEY from %s and save it below to enable the Auto Translation feature.','<a href="https://tech.yandex.com/translate/" target="_blank">Yandex.com</a>');
                
                $translation = __($message,'atlt');

                $HTML = '<div class="notice notice-warning inline is-dismissible"><p>'.$translation.'</p></div>';

                echo $HTML;
            }
        }
        
    }
    
}