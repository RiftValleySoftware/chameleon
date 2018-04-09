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
        $children_ids = $this->context['children_ids'];
        $this->_container = Array();
        
        if (isset($children_ids) && is_array($children_ids) && count($children_ids)) {
            foreach ($children_ids as $child_id) {
                $instance = $this->_db_object->get_single_record_by_id(intval($child_id));
                if (isset($instance) && ($instance instanceof CO_Main_DB_Record)) {
                    array_push($this->_container, $instance);
                }
            }
        }
    }
    
    /***********************/
    /**
    This inserts one record to just before the indexed item (0-based index). If the index is -1, the length of the collection or larger, then the item will be appeneded.
    The element cannot be already in the collection at any level, as that could cause a loop.
    The logged-in user must have write access to the collection object (not the data object) in order to add the item.
    You can opt out of the automatic database update.
    
    \returns TRUE, if the data was successfully added. If a DB update was done, then the response is the one from the update.
     */
    public function insertElement(  $in_element,            ///< The database record to add.
                                    $in_before_index = -1,  ///< The index of the element (in the current list) BEFORE which the insertion will be made. Default is -1 (append).
                                    $dont_update = FALSE    ///< TRUE, if we are to skip the DB update (default is FALSE).
                                ) {
        $ret = FALSE;
        
        if ($this->user_can_write() ) { // You cannot add to a collection if you don't have write privileges.
            if (!$this->areYouMyDaddy($in_element)) {   // Make sure that we aren't already in the woodpile somewhere.
                if (!isset($this->_container) || !is_array($this->_container)) {
                    $this->_container = Array();
                }
                
                if ((-1 == $in_before_index) || (NULL == $in_before_index) || !isset($in_before_index)) {
                    $in_before_index = count($this->_container);
                }
                
                $before_array = Array();
                
                if ($in_before_index) {
                    $before_array = array_slice($this->_container, 0, $in_before_index, FALSE);
                }
                
                $after_array = Array();
                
                if ($in_before_index < count($this->_container)) {
                    $end_count = count($this->_container) - $in_before_index;
                    $after_array = array_slice($this->_container, $end_count, FALSE);
                }
                
                $element_array = Array($in_element);
                
                $this->_container = array_merge($before_array, $element_array, $after_array);
                
                $ret = TRUE;
                if (!isset($this->context['children_ids'])) {
                    $this->context['children_ids'] = Array();
                }
                
                $id = intval($in_element->id());
                $ids = array_map('intval', $this->context['children_ids']);
                if (!in_array($id, $ids)) {
                    array_push($ids, $id);
                    $ids = array_unique($ids);
                    sort($ids);
                    $this->context['children_ids'] = $ids;
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
    This inserts multiple records to just before the indexed item (0-based index). If the index is -1, the length of the collection or larger, then the items will be appeneded.
    The elements cannot be already in the collection at any level, as that could cause a loop.
    The logged-in user must have write access to the collection object (not the data objects) in order to add the items.
    You can opt out of the automatic database update.
    
    \returns TRUE, if the data was successfully updated in the DB. FALSE, if none of the items were added.
     */
    public function insertElements( $in_element_array,      ///< An array of database element instances to be inserted.
                                    $in_before_index = -1   ///< The index of the element (in the current list) BEFORE which the insertion will be made. Default is -1 (append).
                                ) {
        $ret = FALSE;
        
        if ($this->user_can_write() ) { // You cannot add to a collection if you don't have write privileges.
            $i_have_a_daddy = FALSE;
            
            foreach ($in_element_array as $element) {
                if ($this->areYouMyDaddy($element)) {
                    $i_have_a_daddy = TRUE;
                    break;
                }
            }
            
            if (!$i_have_a_daddy) { // DON'T CROSS THE STREAMS!
                if (!isset($this->_container) || !is_array($this->_container)) {
                    $this->_container = Array();
                }
                
                if ((-1 == $in_before_index) || (NULL == $in_before_index) || !isset($in_before_index)) {
                    $in_before_index = count($this->_container);
                }
                
                $before_array = Array();
                
                if ($in_before_index) {
                    $before_array = array_slice($this->_container, 0, $in_before_index, FALSE);
                }
                
                $after_array = Array();
                
                if ($in_before_index < count($this->_container)) {
                    $end_count = count($this->_container) - $in_before_index;
                    $after_array = array_slice($this->_container, $end_count, FALSE);
                }
                
                $this->_container = array_merge($before_array, $in_element_array, $after_array);
                
                $ret = TRUE;
            
                if (!isset($this->context['children_ids'])) {
                    $this->context['children_ids'] = Array();
                }
                
                foreach ($in_element_array as $element) {
                    $id = intval($element->id());
                    $ids = array_map('intval', $this->context['children_ids']);
                    if (!in_array($id, $ids)) {
                        array_push($ids, $id);
                        $ids = array_unique($ids);
                        sort($ids);
                        $this->context['children_ids'] = $ids;
                    }
                }
            }
        
            if ($ret) {
                $ret = $this->update_db();
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    Deletes multiple elements from the collection.
    It should be noted that this does not delete the elements from the database, and it is not recursive.
    This is an atomic operation. If any of the elements can't be removed, then non of the elements can be removed.
    The one exception is that the deletion length can extend past the boundaries of the collection. It will be truncated.
    
    \returns TRUE, if the elements were successfully removed from the collection.
     */
    public function deleteElements( $in_first_index,    ///< The starting 0-based index of the first element to be removed from the collection.
                                    $in_deletion_length ///< The number of elements to remove (including the first one). If this is negative, then elements will be removed from the index, backwards (-1 is the same as 1).
                                ) {
        $ret = FALSE;
        
        if ($this->user_can_write() ) { // You cannot add to a collection if you don't have write privileges.
            $element_ids = Array(); // We will keep track of which IDs we delete, so we can delete them from our context variable.
            
            // If negative, we're going backwards.
            if (0 > $in_deletion_length) {
                $in_deletion_length = abs($in_deletion_length);
                $in_first_index -= ($in_deletion_length - 1);
                $in_first_index = max(0, $in_first_index);  // Make sure we stay within the lane markers.
            }
            
            $last_index_plus_one = min(count($self->_container), $in_first_index + $in_deletion_length);
        
            // We simply record the IDs of each of the elements we'll be deleting.
            for ($i = $in_first_index; $i < $last_index_plus_one; $i++) {
                $element = $self->_container[$i];
                array_push($element_ids, $element->id());
            }
            
            if ($in_deletion_length == count($element_ids)) {  // Belt and suspenders. Make sure we are actually deleting the requested elements.
                $new_container = Array();
                
                // We build a new container that doesn't have the deleted elements.
                foreach ($this->_container as $element) {
                    $element_id = $element->id();
                    
                    if (!in_array($element_id, $element_ids)) {
                        array_push($new_container, $element_id);
                    }
                }
                
                $this->_container = $new_container;
                
                $new_list = Array();
                
                // We build a new list that doesn't have the deleted element IDs.
                while ($element_id = array_unshift($this->context['children_ids'])) {
                    if (!in_array($element_id, $element_ids)) {
                        array_push($new_list, $element_id);
                    }
                }
                
                $new_list = array_unique($new_list);
                sort($new_list);
                $this->context['children_ids'] = $new_list;
                
                $ret = $this->update_db();
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    Deletes a single element, by its 0-based index (not recursive).
    It should be noted that this does not delete the element from the database, and it is not recursive.
    
    \returns TRUE, if the element was successfully removed from the collection.
     */
    public function deleteElement(  $in_index   ///< The 0-based index of the element we want to delete.
                                ) {
        return $this->deleteElements($in_index, 1);
    }
    
    /***********************/
    /**
    Deletes a single element, by its actual object reference (not recursive).
    It should be noted that this does not delete the element from the database, and it is not recursive.
    
    \returns TRUE, if the element was successfully removed from the collection.
     */
    public function deleteThisElement(  $in_element ///< The element we want to delete.
                                    ) {
        $ret = FALSE;
        $index = $this->indexOfThisElement($in_element);
        
        if (FALSE !== $index) {
            $ret = $this->deleteElement(intval($index));
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    \returns the 0-based index of the given element, or FALSE, if the element is not in the collection (This is not recursive).
     */
    public function indexOfThisElement(  $in_element    ///< The element we're looking for.
                                        ) {
        return array_search($in_element, $this->children());
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
    public function appendElement(  $in_element             ///< The database record to add.
                                ) {
        return $this->insertElement($in_element, -1);
    }
    
    /***********************/
    /**
    This appends multiple elements (passed as an array).
    The logged-in user must have write access to the collection object (not the data object)
    in order to add the items.
    
    \returns TRUE, if the data was successfully updated in the DB. FALSE, if none of the items were added.
     */
    public function appendElements( $in_element_array       ///< An array of database element instances to be appended.
                                ) {
        return $this->insertElements($in_element_array, -1);
    }
    
    /***********************/
    /**
    This takes an element, and returns its parent collection object (if available).
    This only checks the current collection and (if requested) its "child" collection objects.
    
    \returns an instance of a collection class, if that instance is the "parent" of the presented object. It may be this instance, or a "child" instance of this class.
     */
    public function whosYourDaddy(  $in_element ///< The element to check.
                                ) {
        $ret = NULL;
        $id = intval($in_element->id());
        
        $ret_array = $this->recursiveMap(function($instance, $hierarchy_level, $parent){
                $id = intval($instance->id());
                return Array($id, $parent);
            });
        
        if (isset($ret_array) && is_array($ret_array) && count($ret_array)) {
            foreach ($ret_array as $item) {
                if ($item[0] == $id) {
                    $ret = $item[1];
                    break;
                }
            }
        }
        
        return $ret;
    }
    
    /***********************/
    /**
    This takes an element, and checks to see if it already exists in our hierarchy (anywhere).
    
    \returns TRUE, if this instance already has the presented object.
     */    
    public function areYouMyDaddy(  $in_element,            ///< The element to check. This can be an array, in which case, each element is checked.
                                    $full_hierachy = TRUE   ///< If FALSE, then only this level (not the full hierarchy) will be searched. Default is TRUE.
                                ) {
        $ret = FALSE;
        
        $id = intval($in_element->id());
        
        $simple_map = function($i){
                                    return intval($i->id());
                                };
        
        $my_ids = $full_hierachy ? $this->recursiveMap($simple_map) : $this->map($simple_map);
        $their_ids = ($full_hierachy && method_exists($in_element, 'recursiveMap')) ? $in_element->recursiveMap($simple_map) : Array($in_element->id());
    
        if (isset($my_ids) && is_array($my_ids) && count($my_ids)) {
            $my_ids = array_unique($my_ids);
            $their_ids = array_unique($their_ids);
            $in_both = array_intersect($my_ids, $their_ids);
            $ret = 0 < count($in_both);
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
    
    \returns a flat array of function results. This array may be larger than the children array, as it will also contain any nested collections.
     */
    public function recursiveMap(   $in_function,               ///< This is the function to be applied to all elements.
                                    $in_hierarchy_level = 0,    ///< This is a 0-based integer that tells the callback how many "levels deep" the function is.
                                    $in_parent_object = NULL    ///< This is the collection object that is the "parent" of the current array.
                                ) {
        $in_hierarchy_level = intval($in_hierarchy_level);
        $ret = Array($in_function($this, $in_hierarchy_level, $in_parent_object));
        $children = $this->children();
        
        foreach ($children as $child) {
            if (method_exists($child, 'recursiveMap')) {
                $result = $child->recursiveMap($in_function, ++$in_hierarchy_level, $this);
            } else {
                $result = Array($in_function($child, ++$in_hierarchy_level, $this));
            }
            $ret = array_merge($ret, $result);
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