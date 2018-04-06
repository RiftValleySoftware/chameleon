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

require_once(CO_Config::db_classes_class_dir().'/co_ll_location.class.php');

/***************************************************************************************************************************/
/**
This is an interface and trait combination for the basic "collection" aggregator functionality.
 */
interface iCO_Collection {
    public function appendElement(mixed $in_element);
    public function appendElements(mixed $in_element_array);
    public function whosYourDaddy(mixed $in_element);
    public function map(mixed $in_function);
    public function recursiveMap(mixed $in_function, integer $in_hierarchy_level);
    public function getHierarchy();
};

/***************************************************************************************************************************/
/**
 */
trait tCO_Collection {
    protected $_container;
	
    /***********************/
    /**
     */
    protected function _set_up_container() {
        $children_ids = $this->children;
        
        if (isset($children_ids) && is_array($children_ids) && count($children_ids)) {
            foreach ($children_ids as $child_id) {
                $instance = $this->_db_object->get_single_record_by_id($child_id);
            
                if (isset($instance) && ($instance instanceof CO_Main_DB_Record)) {
                    array_push($this->_container, $instance);
                }
            }
        }
    }
    
    /***********************/
    /**
     */
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
    
    /***********************/
    /**
     */
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
    
    /***********************/
    /**
     */
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
    
    /***********************/
    /**
     */
    public function map($in_function) {
        $ret = Array();
        
        $children = $this->children();
        
        foreach ($children as $child) {
            $result = $in_function($child);
            array_push($ret, $result);
        }
        
        return self::class;
    }
    
    /***********************/
    /**
     */
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
    
    /***********************/
    /**
     */
    public function children() {
        return $this->_container;
    }
    
    /***********************/
    /**
     */
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
}