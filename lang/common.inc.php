<?php
/***************************************************************************************************************************/
/**
    CHAMELEON Object Abstraction Layer
    
    © Copyright 2018, Little Green Viper Software Development LLC.
    
    This code is proprietary and confidential code, 
    It is NOT to be reused or combined into any application,
    unless done so, specifically under written license from Little Green Viper Software Development LLC.

    Little Green Viper Software Development: https://littlegreenviper.com
*/
defined( 'LGV_LANG_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

global $g_lang_override;    // This allows us to override the configured language at initiation time.

if (isset($g_lang_override) && $g_lang_override && file_exists(dirname(__FILE__).'/'.$lang.'.php')) {
    $lang = $g_lang_override;
} else {
    $lang = CO_Config::$lang;
}

$lang_file = CO_Config::badger_lang_class_dir().'/'.$lang.'.php';
$lang_common_file = CO_Config::badger_lang_class_dir().'/common.inc.php';

require_once(dirname(__FILE__).'/'.$lang.'.php');
require_once($lang_file);
require_once($lang_common_file);

/***************************************************************************************************************************/
/**
 */
class CO_CHAMELEON_Lang_Common {
    static  $co_place_error_code_failed_to_geocode = 1000;
    static  $co_place_error_code_failed_to_lookup = 1001;
    static  $co_collection_error_code_item_not_valid = 1100;
    static  $co_collection_error_code_user_not_authorized = 1101;
    static  $co_owner_error_code_user_not_authorized = 1200;
    static  $co_key_value_error_code_user_not_authorized = 1300;
    static  $co_key_value_error_code_instance_failed_to_initialize = 1301;

    static  $user_error_code_user_not_authorized = 1400;
    static  $user_error_code_invalid_id = 1401;
    static  $user_error_code_invalid_class = 1402;
}
?>