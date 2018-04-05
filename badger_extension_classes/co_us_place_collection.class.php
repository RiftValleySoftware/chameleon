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
defined( 'LGV_DBF_CATCHER' ) or die ( 'Cannot Execute Directly' );	// Makes sure that this file is in the correct context.

require_once(CO_Config::db_classes_extension_class_dir().'/ico_collection.interface.php');
require_once(CO_Config::db_classes_extension_class_dir().'/co_us_place.class.php');

/***************************************************************************************************************************/
/**
This is a specialization of the location class. It adds support for US addresses, and uses the first eight tags for this.
 */
class CO_US_Place_Collection extends CO_US_Place implements iCO_Collection {
    var $container;
    var $position;
	
    /// CO_US_Place_Collection Methods
    /***********************************************************************************************************************/
    /***********************/
    /**
    Constructor (Initializer)
     */
	public function __construct(    $in_db_object = NULL,   ///< The database object for this instance.
	                                $in_db_result = NULL,   ///< The database row for this instance (associative array, with database keys).
	                                $in_owner_id = NULL,    ///< The ID of the object (in the database) that "owns" this instance.
                                    $in_tags_array = NULL,  /**< An array of up to 10 strings, with address information in the first 8. Order is important:
                                                                - 0: Venue
                                                                - 1: Street Address
                                                                - 2: Extra Information
                                                                - 3: Town
                                                                - 4: County
                                                                - 5: State
                                                                - 6: ZIP Code
                                                                - 7: Nation
                                                              
                                                                Associative keys are not used. The array should be in that exact order.
	                                                        */
	                                $in_longitude = NULL,   ///< An initial longitude value.
	                                $in_latitude = NULL     ///< An initial latitude value.
                                ) {
        
        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array, $in_longitude, $in_latitude);
        
        $this->class_description = "This is a 'Place Collection' Class for US Addresses.";
        
        $this->container = Array();
        $this->rewind();
    }
    
    /// Iterator Methods
    public function current() {
        return $this->offsetExists($this->key()) ? $this->container[$this->key()] : NULL;
    }
    
    public function key() {
        return $this->position;
    }
    
    public function next() {
        if ($this->position < (count($this->container) + 1)) {
            ++$this->position;
        }
    }
    
    public function rewind() {
        $this->position = 0;
    }
    
    public function valid () {
        return isset($this->container[$this->position]);
    }
    
    
    /// ArrayAccess Methods
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : NULL;
    }
    
    public function offsetSet($offset , $value) {
        if (!$this->isElementInHierarchy($value)) {
            if (is_null($offset)) {
                $this->container[] = $value;
            } else {
                $this->container[$offset] = $value;
            }
        }
    }
    
    public function offsetUnset($offset) {
        if ($this->offsetExists($offset)) {
            unset($this->container[$offset]);
        }
    }
    
    /// iCO_Collection Methods
    public function appendElement($in_element) {
    }
    
    public function appendElements($in_element_array) {
    }
    
    public function whosYourDaddy($in_element) {
    }
    
    public function getHierarchy() {
    }
};
