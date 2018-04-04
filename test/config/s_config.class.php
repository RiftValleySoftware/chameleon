<?php
/***************************************************************************************************************************/
/**
    Badger Hardened Baseline Database Component
    
    © Copyright 2018, Little Green Viper Software Development LLC.
    
    This code is proprietary and confidential code, 
    It is NOT to be reused or combined into any application,
    unless done so, specifically under written license from Little Green Viper Software Development LLC.

    Little Green Viper Software Development: https://littlegreenviper.com
*/
defined( 'LGV_CONFIG_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

/***************************************************************************************************************************/
/**
 */
class CO_Config {
    /***********************************************************************************************************************/
    /*                                                     CHANGE THIS                                                     */
    /***********************************************************************************************************************/
    
    static $lang = 'en';
    
    static $god_mode_id = 2;
    static $god_mode_password = 'BWU-HA-HAAAA-HA!';
    
    static $data_db_name = 'littlegr_badger_data';
    static $data_db_host = 'localhost';
    static $data_db_type = 'mysql';
    static $data_db_login = 'littlegr_badg';
    static $data_db_password = 'pnpbxI1aU0L(';

    static $sec_db_name = 'littlegr_badger_security';
    static $sec_db_host = 'localhost';
    static $sec_db_type = 'mysql';
    static $sec_db_login = 'littlegr_badg';
    static $sec_db_password = 'pnpbxI1aU0L(';
    
    /**
    This is the Google API key. It's required for CHAMELEON to do address lookups and other geocoding tasks.
    CHAMELEON requires this to have at least the Google Geocoding API enabled.
    */
    static $google_api_key = 'AIzaSyAPCtPBLI24J6qSpkpjngXAJtp8bhzKzK8';
    
    /***********************/
    /**
    \returns the POSIX path to the main CHAMELEON directory.
     */
    static function base_dir() {
        return dirname(dirname(dirname(__FILE__)));
    }
    
    /***********************************************************************************************************************/
    /*                                                  DON'T CHANGE THIS                                                  */
    /***********************************************************************************************************************/
    
    /***********************************************************************************************************************/
    /*                                                  CHAMELEON STUFF                                                    */
    /***********************************************************************************************************************/
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER main access class directory.
     */
    static function chameleon_main_class_dir() {
        return self::base_dir().'/main';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the CHAMELEON localization directory.
     */
    static function chameleon_lang_class_dir() {
        return self::base_dir().'/lang';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the CHAMELEON testing directory.
     */
    static function test_class_dir() {
        return self::base_dir().'/test';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the user-defined extended database row classes.
     */
    static function db_classes_extension_class_dir() {
        return self::base_dir().'/badger_extension_classes';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER main access class directory.
     */
    static function badger_base_dir() {
        return self::base_dir().'/badger';
    }
    
    /***********************************************************************************************************************/
    /*                                                    BADGER STUFF                                                     */
    /***********************************************************************************************************************/

    /***********************/
    /**
    \returns the POSIX path to the main BADGER database base classes.
     */
    static function db_class_dir() {
        return self::badger_base_dir().'/db';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER extended database row classes.
     */
    static function db_classes_class_dir() {
        return self::badger_base_dir().'/db_classes';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER main access class directory.
     */
    static function badger_main_class_dir() {
        return self::badger_base_dir().'/main';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER main access class directory.
     */
    static function badger_shared_class_dir() {
        return self::badger_base_dir().'/shared';
    }
    
    /***********************/
    /**
    \returns the POSIX path to the BADGER localization directory.
     */
    static function badger_lang_class_dir() {
        return self::badger_base_dir().'/lang';
    }
}
