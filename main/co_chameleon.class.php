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
defined( 'LGV_ACCESS_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

define('__CHAMELEON_VERSION__', '1.0.0.2001');

require_once(CO_Config::badger_main_class_dir().'/co_access.class.php');

$lang = CO_Config::$lang;

global $g_lang_override;    // This allows us to override the configured language at initiation time.

if (isset($g_lang_override) && $g_lang_override && file_exists(CO_Config::badger_lang_class_dir().'/'.$g_lang_override.'.php')) {
    $lang = $g_lang_override;
}

$lang_file = CO_Config::chameleon_lang_class_dir().'/'.$lang.'.php';
$lang_common_file = CO_Config::chameleon_lang_class_dir().'/common.inc.php';

if ( !defined('LGV_LANG_CATCHER') ) {
    define('LGV_LANG_CATCHER', 1);
}

require_once($lang_file);
require_once($lang_common_file);

/***************************************************************************************************************************/
/**
 */
class CO_Chameleon extends CO_Access {
    protected   $_cached_collection_objects;
    
    /***********************************************************************************************************************/
    /***********************/
    /**
     */
    protected function _get_next_level_up(  $in_data_item   ///< The item we're examining.
                                        ) {
        $ret = NULL;
        
        if (isset($in_data_item) && $in_data_item) {
            if (!isset($this->_cached_collection_objects) || !$this->_cached_collection_objects) {
                $this->_cached_collection_objects = $this->generic_search(Array('access_class' => '%_Collection', 'use_like' => TRUE));
            }
        
            if (isset($this->_cached_collection_objects) && is_array($this->_cached_collection_objects) && count($this->_cached_collection_objects)) {
                foreach ($this->_cached_collection_objects as $parent_object) {
                    if ($parent_object->areYouMyDaddy($the_object, FALSE)) {
                        $ret = $parent_object;
                        break;
                    }
                }
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    The constructor.
     */
	public function __construct(    $in_login_id = NULL,        ///< The login ID
                                    $in_hashed_password = NULL, ///< The password, crypt-hashed
                                    $in_raw_password = NULL     ///< The password, cleartext.
	                            ) {
        parent::__construct($in_login_id, $in_hashed_password, $in_raw_password);
	    $this->version = __CHAMELEON_VERSION__;
    }
    
    /***********************/
    /**
    This method allows you to search for a given item in the "data" database, given its ID.
    This will return an array, with the item in the first element, and its hierarchy (if any) in subsequent elements.
    NULL is returned if the item cannot be found.
    The ancestry only goes "up." If the object is a collection, and has children, they are not included in this response.
    
    \returns an array of record objects. The first element of the array is the object, and the next is the "parent" of that object. As the hierarchy is crawled, it goes down the array.
     */
	public function get_data_item_ancestry_by_id(   $in_data_item_id    ///< The ID of the item we are searching for.
	                                            ) {
	    $ret = NULL;
	    
	    $the_object = $this->get_single_data_record_by_id($in_data_item_id);
	    
	    if (isset($the_object) && $the_object) {
	        $ret = Array();
	        
	        $this->_cached_collection_objects = NULL;

	        while (isset($the_object) && $the_object) {
	            array_push($ret, $the_object);
	            $the_object = $this->_get_next_level_up($the_object);
	        }
        } else {
            $this->error = new LGV_Error(   CO_CHAMELEON_Lang_Common::$co_collection_error_code_item_not_valid,
                                            CO_CHAMELEON_Lang::$co_collection_error_name_item_not_valid,
                                            CO_CHAMELEON_Lang::$co_collection_error_desc_item_not_valid);
        }
        
	    return $ret;
	}
};
