<?php
namespace LocoAutoTranslateAddon\Helpers;
/**
 * @package Loco Automatic Translate Addon
 */

class Helpers{

    /*
   |----------------------------------------------------------------------------|
   |         Delete or update per day translated charachter stats               |
   | @param $value int current translated character to update in database       |
   |----------------------------------------------------------------------------|
    */
    // count today translated strings
    public static function todayTranslated($value = 0)
    {
        $now_translated = $value;
         if (false===($today= get_transient('atlt_translation_day'))) {
            delete_option('atlt_perday_translated_chars');
            update_option('atlt_perday_translated_chars', $now_translated);
            set_transient('atlt_translation_day', 'true', DAY_IN_SECONDS);
            $today_total_translated=$now_translated;
        } else {
            $already_translated = intval(get_option('atlt_perday_translated_chars'));
            $today_total_translated = $already_translated+$now_translated;
            update_option('atlt_perday_translated_chars', $today_total_translated);
        }
        return $today_total_translated;
    }
    // count monthly translated strings
    public static function monthlyTranslated($value = 0){
            $now_translated=$value;
            if (false===($month= get_transient('atlt_translation_month'))) {
                delete_option('atlt_month_translated_chars');
                update_option('atlt_month_translated_chars',$now_translated);
                set_transient('atlt_translation_month', 'true', MONTH_IN_SECONDS);
                $month_total_translated=$now_translated;
            } else {
                $already_translated = intval(get_option('atlt_month_translated_chars'));
                $month_total_translated= $already_translated+$now_translated;
                update_option('atlt_month_translated_chars', $month_total_translated);
            }
            return $month_total_translated;
    }
    /* google chars stats*/
    public static function gTodayTranslated($value = 0)
    {
        $now_translated = $value;
         if (false===($today= get_transient('g_translation_day'))) {
            delete_option('g_perday_translated_chars');
            update_option('g_perday_translated_chars', $now_translated);
            set_transient('g_translation_day', 'true', DAY_IN_SECONDS);
            $today_total_translated=$now_translated;
        } else {
            $already_translated = intval(get_option('g_perday_translated_chars'));
            $today_total_translated = $already_translated+$now_translated;
            update_option('g_perday_translated_chars', $today_total_translated);
        }
        return $today_total_translated;
    }
    // count monthly translated strings
    public static function gMonthlyTranslated($value = 0){
            $now_translated=$value;
            if (false===($month= get_transient('g_translation_month'))) {
                delete_option('g_month_translated_chars');
                update_option('g_month_translated_chars',$now_translated);
                set_transient('g_translation_month', 'true', MONTH_IN_SECONDS);
                $month_total_translated=$now_translated;
            } else {
                $already_translated = intval(get_option('g_month_translated_chars'));
                $month_total_translated= $already_translated+$now_translated;
                update_option('g_month_translated_chars', $month_total_translated);
            }
            return $month_total_translated;
    }
    // check timing
    public static function checkPeriod(){
        $today=get_transient('atlt_translation_day');
        $month=get_transient('atlt_translation_month');
        if(false===$today){
            delete_option('atlt_perday_translated_chars');
        }
        if(false===$month){
            delete_option('atlt_month_translated_chars');
        }
    }
    // verifiy user limit
    public static function atltVerification(){
        $allowed='';
        $info=array();
        $info['type']=Helpers::userType();
        $today_timing = get_transient('atlt_translation_day');
        $monthly_timing = get_transient('atlt_translation_day');
        $all_translated_chars = intval(get_option('atlt_month_translated_chars',0));
        $info['total']= $all_translated_chars;
        if($today_timing===false){
            if($all_translated_chars>10000000){
                $allowed='no';
            }else{
                $allowed='yes';
            }
     
        }else{
            $today_chars=(int)get_option('atlt_perday_translated_chars');
            $info['today']= $today_chars;
            if($today_chars>300000){
               $allowed='no';
            }else if($all_translated_chars>10000000){
                $allowed='no';
            }else{
               $allowed='yes';
            }
        }
      
       $info['allowed']= $allowed;
        return $info;
    }
    // return user type
    public static function userType(){
        $type='';
      if(get_option('atlt-type')==false || get_option('atlt-type')=='free'){
            return $type='free';
        }else if(get_option('atlt-type')=='pro'){
            return $type='pro';
        }  
       
    }

    public static function getAvailableChars($source)
    {
        $availableChars=0;
        if($source=="yandex"){
            $a_per_day=1000000;
            $today_total_translated = get_option('atlt_perday_translated_chars', 0);
            $availableChars=$a_per_day-$today_total_translated; 
        }else{
            $a_per_mon=500000;
            $total_translation = get_option('g_month_translated_chars', 0);
            $availableChars=$a_per_mon-$total_translation;
        }
        return $availableChars;
    }

    public static function getAPIkey($source){
        $key='';
        $keys_arr= get_option('atlt_register');
        if($source=="google"){
            if(isset($keys_arr['atlt_google-api-key'])){
                $key=$keys_arr['atlt_google-api-key'];   
            }
        }else{
            if(isset($keys_arr['atlt_api-key'])){
                $key=$keys_arr['atlt_api-key'];   
            }
       
        }
        return $key;
    }
    // validate key
    public static function validKey($key){
    if (preg_match("/^([A-Z0-9]{8})-([A-Z0-9]{8})-([A-Z0-9]{8})-([A-Z0-9]{8})$/",$key)){
         return true;
        }else{
            return false;
        }
    }
    //grab key
    public static function getLicenseKey(){
        $licenseKey=get_option("LocoAutomaticTranslateAddonPro_lic_Key","");
        if($licenseKey==''||$licenseKey==false){
            return false;
        }else{
            return $licenseKey;
          }
    }
    
    // format cumber
    public static function formatNum($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));
        // is this a number?
        if (!is_numeric($n)) return false;
        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' million';
        elseif ($n > 1000) return round(($n/1000), 2).' thousand';

        return number_format($n);
    }

   /*
   |----------------------------------------------------------------|
   |       return the total amount of time saved on translation     |
   | @param $characters int number of translated charachters        |
   |----------------------------------------------------------------|
   */
   public static function atlt_time_saved_on_translation( $characters ){
        $total_saved = intval( $characters ) / 1800 ;
        if($characters='' || $characters<=0){
            return;
        }
        if( $total_saved >=1 && is_float( $total_saved ) ){
            $hour = intval( $total_saved );
            $minute =  $total_saved - $hour;
            $minute = intval( $minute * 60 );
            return $hour .' hour and '. round($minute,2).' minutes';
        }else{
            $minute = floatval($total_saved) * 60;
            if( $minute <1 ){
                return round($minute * 60, 2) . ' seconds';
            }
            return round($minute,2) . ' minutes';
        }
    }


}
