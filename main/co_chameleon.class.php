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

define('__CHAMELEON_VERSION__', '1.0.0.2022');

require_once(CO_Config::badger_main_class_dir().'/co_access.class.php');

if ( !defined('LGV_LANG_CATCHER') ) {
    define('LGV_LANG_CATCHER', 1);
}

require_once(CO_Config::chameleon_lang_class_dir().'/common.inc.php');

/***************************************************************************************************************************/
/**
 */
class CO_Chameleon extends CO_Access {
    protected $_special_access_id;  ///< This is a special ephemeral ID that we use to allow a manager to create a login, and add that login to its pool.
    
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
    This fetches the list of security tokens the currently logged-in user has available.
    This will reload any non-God Mode IDs before fetching the IDs, in order to spike privilege escalation.
    If they have God Mode, then you're pretty much screwed, anyway.
    
    \returns an array of integers, with each one representing a security token. The first element will always be the ID of the user.
     */
    public function get_security_ids() {
        $ret = parent::get_security_ids();
        
        if (isset($this->_special_access_id)) {
            $id = $this->_special_access_id;
            unset($this->_special_access_id);
            $ret[] = intval($id);
        }
        
        return $ret;
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
            $collection_objects = $this->generic_search(Array('access_class' => Array('%_collection', 'use_like' => TRUE)));

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
    
    /***********************/
    /**
    This returns the language string for the given user/login.
    
    If there is a user item associated with the login, then that gets first dibs. Login item gets dibs over default server.
    
    \returns a string, with the language ID for the login. If none, the the server default is returned.
     */
    public function get_lang(   $in_login_id = NULL ///< The integer login ID to check. If not-NULL, then the ID of a login instance. It must be one that the current user can see.
                            ) {
        $ret = parent::get_lang();
        
        $login_item = $this->get_login_item($in_login_id);
        
        if ($login_item) {
            $user_item = $this->get_user_from_login($login_item->login_id);
            if ($user_item) {
                $ret = $user_item->get_lang();
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    This tests a login ID for the special "Heisenberg" one-time test.
    
    \returns TRUE, if the item was a login, and had the flag set.
     */
    public function test_access(    $in_login_id    ///< The ID of the instance to test.
                                ) {
        $ret = FALSE;
        
        // Yeah, this will crash if we're not in COBRA. Good.
        if ($this->security_db_available() && ($this->get_login_item() instanceof CO_Login_Manager)) {
            $item_to_test = $this->_security_db_object->get_initial_record_by_id($in_login_id);
            
            if (($item_to_test instanceof CO_Cobra_Login) || ($item_to_test instanceof CO_Security_ID)) {
                $ret = $item_to_test->security_exemption();
                if ($ret) {
                    $this->_special_access_id = $in_login_id;
                }
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    \returns the value for a given key. It is dependednt on the class passed in. NULL, if no value or instance for the key.
     */
    public function get_value_for_key(  $in_key,                        ///< This is the key that we are searching for. It must be a string.
                                        $in_classname = 'CO_KeyValue'   ///< This is the class to search for the key. The default is the base class.
                                    ) {
        $value_object_array = $this->generic_search(Array('access_class' => $in_classname, 'tags' => Array(strval($in_key))));
        $ret = NULL;
        
        if (isset($value_object_array) && is_array($value_object_array) && count($value_object_array)) {
            $value_object = $value_object_array[0]; // If the DB is messed up, we could get more than one. In that case, we only take the first one.
            if (isset($value_object) && ($value_object instanceof CO_KeyValue)) {
                $ret = $value_object->get_value();
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    This sets a value to a key, creating the record, if need be. Passing in NULL will delete the key (if we have write access).
    We need to have a login for it to work at all. If the value already exists, then we need to have write access to it, or we will fail.
    
    \returns TRUE, if successful.
     */
    public function set_value_for_key(  $in_key,                        ///< This is the key that we are setting. It must be a string.
                                        $in_value,                      ///< The value to set. If NULL, then we will delete the key.
                                        $in_classname = 'CO_KeyValue'   ///< This is the class to use for the key. The default is the base class.
                                    ) {
        $ret = FALSE;
        
        if ($this->security_db_available()) {
            // First, we look for the object.
            $value_object = $this->generic_search(Array('access_class' => $in_classname, 'tags' => Array(strval($in_key))));
        
            if (!isset($value_object) || !$value_object) {
                $value_object = $access_instance->make_new_blank_record($in_classname);
            }
            
            if (isset($value_object) && ($value_object instanceof CO_KeyValue) && $value_object->user_can_write()) {
                if (NULL == $in_value) {    // If we are deleting, we ask the object to go quietly into the great beyond.
                    $ret = $value_object->delete_from_db();
                } else {                    // Otherwise, we just set the value.
                    $ret = $value_object->set_value($in_value);
                }
            } else {
                if (isset($value_object) && ($value_object instanceof CO_KeyValue) && !$value_object->user_can_write()) {
                    $this->error = new LGV_Error(   CO_CHAMELEON_Lang_Common::$co_key_value_error_code_user_not_authorized,
                                                    CO_CHAMELEON_Lang::$co_key_value_error_name_user_not_authorized,
                                                    CO_CHAMELEON_Lang::$co_key_value_error_desc_user_not_authorized);
                } else {
                    $this->error = new LGV_Error(   CO_CHAMELEON_Lang_Common::$co_key_value_error_code_instance_failed_to_initialize,
                                                    CO_CHAMELEON_Lang::$co_key_value_error_name_instance_failed_to_initialize,
                                                    CO_CHAMELEON_Lang::$co_key_value_error_desc_instance_failed_to_initialize);
                }
            }
        } else {
            $this->error = new LGV_Error(   CO_CHAMELEON_Lang_Common::$co_key_value_error_code_user_not_authorized,
                                            CO_CHAMELEON_Lang::$co_key_value_error_name_user_not_authorized,
                                            CO_CHAMELEON_Lang::$co_key_value_error_desc_user_not_authorized);
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    \returns the user collection object for a given login. If there is no login given, then the current login is assumed. This is subject to security restrictions.
     */
    public function get_user_from_login(    $in_login_id = NULL ///< The login ID that is associated with the user collection. If NULL, then the current login is used.
                                        ) {
        $ret = NULL;

        $login_id = $this->get_login_id();  // Default is the current login.
        
        if (isset($in_login_id) && (0 < intval($in_login_id))) {    // See if they seek a different login.
            $login_id = intval($in_login_id);
        }
        
        $tag0 = strval($login_id);
        
        $ret_temp = $this->generic_search(Array('access_class' => Array('%_user_collection', 'use_like' => TRUE), 'tags' => Array($tag0)));
        
        if (isset($ret_temp) && is_array($ret_temp) && count($ret_temp)) {
            $ret = $ret_temp[0];    // We only get the first one. Multiple responses mean the DB is not so healthy.
        }
        
        return $ret;
    }
};
