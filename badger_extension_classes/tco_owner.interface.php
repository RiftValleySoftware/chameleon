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

require_once(CO_Config::db_classes_class_dir().'/co_ll_location.class.php');

/***************************************************************************************************************************/
/**
This is a trait for the basic "owner" aggregator functionality.
 */
trait tCO_Owner {
    $my_owner_id = NULL;
    
    /***********************/
    /**
    This counts the direct children of this collection, and returns that count.
    If recursive, then it counts everything inside, including collections.
        
    \returns the number of direct children.
     */
    public function count(  $is_recursive = FALSE   ///< If TRUE, then this will also count all "child" collections or owners. Default is FALSE.
                        ) {
        $children_ids = $this->children_ids();
        $my_count = count($children_ids);
        
        if ($is_recursive) {
            foreach ($children_ids as $child_id) {
                $child = $this->get_access_object()->get_single_data_record_by_id(intval($child_id));
                if (isset($child) && method_exists($child, 'count')) {
                    $my_count += $child->count($is_recursive);
                }
                unset($child);
            }
        }
        
        return $my_count;
    }
    
    /***********************/
    /**
    \returns an array of integers, with the "owned" object IDs.
     */
    public function children_ids() {
        $test_item = $this->get_access_object()->generic_search(Array('owner' => intval($my_owner_id)), FALSE, 0, 0, FALSE, FALSE, TRUE);
    }
    
    /***********************/
    /**
    WARNING: Since the "owner" object is for big, fat datasets, this could blow up memory!
    
    \returns an array of instances, comprising all "owned" instances.
     */
    public function children() {
        $ret = NULL;
        
        $children_ids = $this->children_ids();
        foreach ($children_ids as $child_id) {
            $child = $this->get_access_object()->get_single_data_record_by_id(intval($child_id));
            if (isset($child)) {
                if (!$ret) {
                    $ret = Array();
                }
                
                array_push($ret, $child);
            }
        }
        
        return $ret;
    }
}