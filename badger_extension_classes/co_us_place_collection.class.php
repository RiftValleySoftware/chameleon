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
    public function __construct() {
        $this->container = Array();
        $this->rewind() = 0;
    }
    
    /// Iterator Methods
    public mixed current() {
        return $this->offsetExists($this->key()) ? $this->container[$this->key()] : NULL;
    }
    
    public scalar key() {
        return $this->position;
    }
    
    public void next() {
        if ($this->position < (count($this->container) + 1)) {
            ++$this->position;
        }
    }
    
    public void rewind() {
        $this->position = 0;
    }
    
    public bool valid () {
        return isset($this->container[$this->position]);
    }
    
    
    /// ArrayAccess Methods
    public bool offsetExists(mixed $offset) {
        return isset($this->container[$offset]);
    }
    
    public mixed offsetGet(mixed $offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : NULL;
    }
    
    public void offsetSet(mixed $offset , mixed $value) {
        if (!$this->isElementInHierarchy($value)) {
            if (is_null($offset)) {
                $this->container[] = $value;
            } else {
                $this->container[$offset] = $value;
            }
        }
    }
    
    public void offsetUnset(mixed $offset) {
        if ($this->offsetExists($offset)) {
            unset($this->container[$offset]);
        }
    }
    
    /// iCO_Collection Methods
    public bool appendElement(mixed $in_element) {
    }
    
    public bool appendElements([mixed $in_element]) {
    }
    
    public bool isElementInHierarchy(mixed $in_element) {
    }
    
    public [mixed] getHierarchy(mixed $in_element) {
    }
};
