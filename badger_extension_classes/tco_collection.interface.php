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
This is a trait for the basic "collection" aggregator functionality.
 */
trait tCO_Collection {
    protected $_container;  ///< This contains instances of the records referenced by the IDs stored in the object.
	
    /***********************/
    /**
    This method simply sets up the internal container from the object's tags.
    The tags already need to be loaded when this is called, so it should be called towards the end of the
    object's constructor.
     */
    protected function _set_up_container() {
        $children_ids = $this->children();
        
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
    This appends one record to the end of the collection.
    The element cannot be already in the collection at any level, as that could
    cause a loop.
    The logged-in user must have write access to the collection object (not the data object)
    in order to add the item.
    You can opt out of the automatic database update.
    
    \returns TRUE, if the data was successfully added. If a DB update was done, then the response is the one from the update.
     */
    public function appendElement(  $in_element,            ///< The database record to add.
                                    $dont_update = FALSE    ///< TRUE, if we are to skip the DB update (default is FALSE).
                                ) {
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
    This appends multiple elements (passed as an array).
    The logged-in user must have write access to the collection object (not the data object)
    in order to add the items.
    
    \returns TRUE, if the data was successfully updated in the DB. FALSE, if none of the items were added.
     */
    public function appendElements( $in_element_array   ///< An array of database element instances to be appended.
                                ) {
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
    This takes an element, and checks to see if it already exists in our hierarchy (anywhere).
    
    \returns TRUE, if this instance already has the presented object.
     */
    public function whosYourDaddy(  $in_element ///< The element to check.
                                ) {
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
    This applies a given function to each of the elements in the child list.
    
    The function needs to have a signature of function mixed map_func(mixed $item);
    
    \returns a flat array of function results. The array maps to the children array.
     */
    public function map(    $in_function    ///< The function to be applied to each element.
                        ) {
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
    This applies a given function to each of the elements in the child list, and any embedded (recursive) ones.
    
    The function needs to have a signature of function mixed map_func(mixed $item, integer $hierarchy_level, mixed $parent_object);
    
    \returns a flat array of function results. The array maps to the children array.
     */
    public function recursiveMap(   $in_function,               ///< This is the function to be applied to all elements.
                                    $in_hierarchy_level = 0,    ///< This is a 0-based integer that tells the callback how many "levels deep" the function is.
                                    $in_parent_object = NULL    ///< This is the collection object that is the "parent" of the current array.
                                ) {
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
    This is an accessor for the child object array (instances).
    
    It should be noted that this may not be the same as the 'children' context variable, because the user may not be allowed to see all of the items.
    
    \returns the child objects array.
     */
    public function children() {
        return $this->_container;
    }
    
    /***********************/
    /**
    \returns an instance "map" of the collection. It returns an array of associative arrays.
    Each associative array has the following elements:
        - 'object' (Required). This is the actual instance that maps to this object.
        - 'children' (optional -may not be instantiated). This is an array of the same associative arrays for any "child objects" of the current object.
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