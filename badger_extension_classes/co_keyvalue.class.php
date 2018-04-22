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

require_once(CO_Config::db_class_dir().'/co_main_db_record.class.php');

/***************************************************************************************************************************/
/**
 */
class CO_KeyValue extends CO_Main_DB_Record {
    protected $_my_key = NULL;
    
    /***********************************************************************************************************************/
    /***********************/
    /**
    Constructor (Initializer)
     */
	public function __construct(    $in_db_object = NULL,   ///< The database object for this instance.
	                                $in_db_result = NULL,   ///< The database row for this instance (associative array, with database keys).
	                                $inKey = NULL           ///< The key to be used for this instance.
                                ) {
        parent::__construct($in_db_object, $in_db_result);
        $this->class_description = "This is an class for doing \"key/value\" storage.";
        
        if (NULL != $inKey) {
            $this->set_key($inKey);
        }
    }

    /***********************/
    /**
    This function sets up this instance, according to the DB-formatted associative array passed in.
    
    \returns TRUE, if the instance was able to set itself up to the provided array.
     */
    public function load_from_db(   $in_db_result   ///< This is an associative array, formatted as a database row response.
                                    ) {
        $ret = parent::load_from_db($in_db_result);
        
        $this->class_description = "This is an class for doing \"key/value\" storage.";
        $this->instance_description = $this->name;
    }
    
    /***********************/
    /**
     */
    function set_key(    $inKey  ///< The key to be applied to this object.
                    ) {
        $this->_my_key = $inKey;
        $this->update_db();
    }
    
    /***********************/
    /**
     */
    function get_key() {
        return $this->_my_key;
    }
};
