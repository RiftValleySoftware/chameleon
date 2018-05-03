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
defined( 'LGV_DBF_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

CO_Config::require_extension_class('tco_collection.interface.php');
require_once(CO_Config::db_class_dir().'/co_main_db_record.class.php');

$lang_file = CO_Config::badger_lang_class_dir().'/'.$lang.'.php';
$lang_common_file = CO_Config::badger_lang_class_dir().'/common.inc.php';

if ( !defined('LGV_LANG_CATCHER') ) {
    define('LGV_LANG_CATCHER', 1);
}

require_once($lang_file);
require_once($lang_common_file);

/***************************************************************************************************************************/
/**
This is a container, meant to define a user.
 */
class CO_User_Collection extends CO_Main_DB_Record {
    private $_login_object = NULL;  ///< The Security DB COBRA login instance associated with this user.

    /***********************/
    /**
    \returns TRUE, if the instance was able to set itself up to the internal login ID.
     */
    protected function _load_login() {
        $ret = FALSE;
        
        // Tag 0 contains the ID of the user login (in the security DB) for this user.
        $login_id = intval($this-itags[0]);
        
        if (0 < $login_id) {
            $my_login_object = $this->get_access_object()->get_single_security_record_by_id($login_id);
            
            if (isset($my_login_object) && ($my_login_object instanceof CO_Security_Login)) {
                $this->_login_object = $my_login_object;
                $ret = TRUE;
            } elseif (!($my_login_object instanceof CO_Security_Login)) {
                $this->error = new LGV_Error(   CO_Lang_Common::$user_error_code_invalid_class,
                                                CO_Lang::$user_error_name_invalid_class,
                                                CO_Lang::$user_error_desc_invalid_class,
                                                __FILE__,
                                                __LINE__,
                                                __METHOD__
                                            );
            } else {
                $this->error = new LGV_Error(   CO_Lang_Common::$user_error_code_user_not_authorized,
                                                CO_Lang::$user_error_name_user_not_authorized,
                                                CO_Lang::$user_error_desc_user_not_authorized,
                                                __FILE__,
                                                __LINE__,
                                                __METHOD__
                                            );
            }
        } else {
            $this->error = new LGV_Error(   CO_Lang_Common::$user_error_code_invalid_id,
                                            CO_Lang::$user_error_name_invalid_id,
                                            CO_Lang::$user_error_desc_invalid_id,
                                            __FILE__,
                                            __LINE__,
                                            __METHOD__
                                        );
        }
        
        return $ret;
    }
    
    /***********************************************************************************************************************/
    /***********************/
    /**
    Constructor (Initializer)
     */
	public function __construct(    $in_db_object = NULL,   ///< The database object for this instance.
	                                $in_db_result = NULL,   ///< The database row for this instance (associative array, with database keys).
	                                $in_owner_id = NULL,    ///< The ID of the object (in the database) that "owns" this instance.
	                                $in_tags_array = NULL   ///< An array of strings, up to ten elements long, for the tags. Tag 0 MUST be a single integer (as a string), with the ID of the login object associated with this instance.
                                ) {
        
        $this->_container = Array();
        $this->_login_object = NULL;
        
        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array);
        
        $this->class_description = "This is a 'Collection' Class for Users.";
    }
    
    /***********************/
    /**
    This function sets up this instance, according to the DB-formatted associative array passed in.
    
    \returns TRUE, if the instance was able to set itself up to the provided array.
     */
    public function load_from_db(   $in_db_result   ///< This is an associative array, formatted as a database row response.
                                    ) {
        $ret = parent::load_from_db($in_db_result);
        
        if ($this->_load_login()) {
            $this->_set_up_container();
        }
        
        $this->class_description = "This is a 'Collection' Class for Users.";
    }
    
    /***********************/
    /**
     Accessor for the login object.
     */
    public function get_login_instance() {
        return $this->_login_object;
    }
    
    use tCO_Collection; ///< These are the built-in collection methods.
    
    /***********************/
    /**
    Simple setter for the tags.
    
    \returns TRUE, if successful.
     */
    public function set_tags(   $in_tags_array  ///< An array of strings, up to ten elements long, for the tags.
                            ) {
        $ret = FALSE;
        
        if (isset($in_tags_array) && is_array($in_tags_array) && count($in_tags_array) && (11 > count($in_tags_array))) {
            // We cannot assign a user we don't have write permissions for
            $id_pool = $this->get_access_object()->get_security_ids();
            $tag0 = intval($in_tags_array[0]);
            if ($this->get_access_object()->god_mode() || ((isset($id_pool) && is_array($id_pool) && count($id_pool) && ((0 == $tag0) || in_array($tag0, $id_pool))))) {
                $ret = parent::set_tags($in_tags_array);
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    Setter for one tag, by index.
    
    \returns TRUE, if successful.
     */
    public function set_tag(    $in_tag_index,  ///< The index (0-based -0 through 9) of the tag to set.
                                $in_tag_value   ///< A string, with the tag value.
                            ) {
        $ret = FALSE;
        
        $in_tag_index = intval($in_tag_index);
        
        if (isset($in_tag_value) && (10 > $in_tag_index) && $this->user_can_write()) {
            // We cannot assign a user we don't have write permissions for
            $id_pool = $this->get_access_object()->get_security_ids();
            $tag0 = intval($in_tags_array[0]);
            if ($this->get_access_object()->god_mode() || ((isset($id_pool) && is_array($id_pool) && count($id_pool) && ((0 < $in_tag_index) || in_array(intval($in_tag_value), $id_pool))))) {
                $ret = parent::set_tag($in_tag_index, $in_tag_value);
            }
        }
        
        return $ret;
    }
};
