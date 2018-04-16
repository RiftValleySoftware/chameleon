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

define('__CHAMELEON_VERSION__', '1.0.0.2004');

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
    /***********************************************************************************************************************/    
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
    This method chacks all the collections for the presence of the given element.
    If the collection is a direct parent of the element, it is returned.
    
    \returns an array of collection objects. If the element has no parents, then NULL is returned.
     */
    public function get_all_collections_for_element(    $in_element ///< The element we're looking for parents.
                                                    ) {
        $ret = NULL;
        
        if (isset($in_element) && $in_element && ($in_element->get_access_object() == $this)) {
            $collection_objects = $this->generic_search(Array('access_class' => Array('%_Collection', 'use_like' => TRUE)));

            if (isset($collection_objects) && is_array($collection_objects) && count($collection_objects)) {
                foreach ($collection_objects as $parent_object) {
                    if ($parent_object->areYouMyDaddy($in_element, FALSE)) {
                        if (!$ret) {
                            $ret = Array();
                        }
                        array_push($ret, $parent_object);
                    }
                }
            }
        } else {    // If the item is invalid, we not only give a NULL, we also flag an error.
            $this->error = new LGV_Error(   CO_CHAMELEON_Lang_Common::$co_collection_error_code_item_not_valid,
                                            CO_CHAMELEON_Lang::$co_collection_error_name_item_not_valid,
                                            CO_CHAMELEON_Lang::$co_collection_error_desc_item_not_valid);
        }
        
        return $ret;
    }
};
