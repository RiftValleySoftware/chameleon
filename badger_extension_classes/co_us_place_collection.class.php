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
    protected $_container;
	
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
        
        $this->_container = Array();

        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array, $in_longitude, $in_latitude);
        
        $children_ids = $this->context['children_ids'];
        
        if (isset($children_ids) && is_array($children_ids) && count($children_ids)) {
            foreach ($children_ids as $child_id) {
                $instance = $this->_db_object->get_single_record_by_id($child_id);
            
                if (isset($instance) && ($instance instanceof CO_Main_DB_Record)) {
                    array_push($this->_container, $instance);
                }
            }
        }
        
        $this->class_description = "This is a 'Place Collection' Class for US Addresses.";
    }
    
    /// iCO_Collection Methods
    public function appendElement($in_element, $dont_update = FALSE) {
        $ret = FALSE;
        
        if ($this->user_can_write() ) { // You cannot add to a collection if you don't have write privileges.
            $id = intval($in_element->id());
        
            if (!$this->whosYourDaddy($in_element)) {
                array_push($this->_container, $in_element);
                $ret = TRUE;
            
                if (!isset($this->context['children_ids'])) {
                    $this->context['children_ids'] = Array();
                }
            
                if (!in_array($in_element->id(), $this->context['children_ids'])) {
                    array_push($this->context['children_ids'], $id);
                }
            }
        
            if ($ret && !$dont_update) {
                $ret = $this->update_db();
            }
        }
        
        return $ret;
    }
    
    public function appendElements($in_element_array) {
        $ret = FALSE;
        
        foreach($in_element_array as $element) {
            $ret |= $this->appendElement($element, TRUE);
        }
        
        if ($ret) {
            $ret = $this->update_db();
        }
        
        return $ret;
    }
    
    public function whosYourDaddy($in_element) {
        $ret = FALSE;
        $id = intval($in_element->id());
        
        $checkup = $this->recursiveMap(function($i){return intval($i->id());});
        
        if (isset($checkup) && is_array($checkup) && count($checkup)) {
            $checkup = array_unique($checkup);
            
            $ret = in_array($id, $checkup);
        }
        
        return $ret;
    }
    
    public function map($in_function) {
        $ret = Array();
        
        $children = $this->children();
        
        foreach ($children as $child) {
            $result = $in_function($child);
            array_push($ret, $result);
        }
        
        return self::class;
    }
    
    public function recursiveMap($in_function, $in_hierarchy_level = 0, $in_parent_object = NULL) {
        $ret = Array();
        $in_hierarchy_level = intval($in_hierarchy_level);
        
        $children = $this->children();
        
        foreach ($children as $child) {
            $result = $in_function($child, $in_hierarchy_level, $in_parent_object);
            array_push($ret, $result);
            if (method_exists($child, 'children')) {
                $in_hierarchy_level++;
                $result = $child->recursiveMap($in_function, $in_hierarchy_level, $child);
                $in_hierarchy_level--;
                array_merge($ret, $result);
            }
        }
        
        return $ret;
    }
    
    public function children() {
        return $this->_container;
    }
    
    public function getHierarchy($in_instance = NULL) {
        if (NULL == $in_instance) {
            $in_instance = $this;
        }
        
        $instance = Array('object' => $in_instance);
        
        if (method_exists($in_instance, 'children')) {
            $children = $in_instance->children();
        
            foreach ($children as $child) {
                $result = $this->getHierarchy($child);
            
                if ($result) {
                    if (!isset($instance['children'])) {
                        $instance['children'] = Array();
                    }
            
                    array_push($instance['children'], $result);
                }
            }
        }
        
        return $instance;
    }
};
