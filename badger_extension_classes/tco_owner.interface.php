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
    $my_owner_id = NULL;    ///< This is the ID We will use for the "owner." If left NULL, then the instance ID is used instead.
    
    /***********************/
    /**
    This counts the direct children of this collection, and returns that count.
    If recursive, then it counts everything inside, including collections.
        
    \returns the number of direct children.
     */
    public function count(  $is_recursive = FALSE,  ///< If TRUE, then this will also count all "child" collections or owners. Default is FALSE.
                            $loop_stopper = Array() /**< This is used to prevent "hierarchy loops."
                                                         As we descend into recursion, we save the collection ID here.
                                                         If the ID shows up in a "lower" collection or owner, we don't add that collection or owner.
                                                         This shouldn't happen anyway, as were're not supposed to have been able to add embedded collections, but we can't be too careful.
                                                         There can only be one...
                                                    */
                        ) {
        $children_ids = $this->children_ids();
        $my_count = count($children_ids);
        
        if ($is_recursive) {
            foreach ($children_ids as $child_id) {
                $child = $this->get_access_object()->get_single_data_record_by_id(intval($child_id));
                if (isset($child) && method_exists($child, 'count')) {
                    if (!in_array($child->id(), $loop_stopper)) {
                        array_push($loop_stopper, $child->id());
                        $my_count += $child->count($is_recursive, $loop_stopper);
                    }
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
        $my_owner_id = intval($this->my_owner_id) ? intval($this->my_owner_id) : $this->id();
        $test_item = $this->get_access_object()->generic_search(Array('owner' => $my_owner_id), FALSE, 0, 0, FALSE, FALSE, TRUE);
    }
    
    /***********************/
    /**
    WARNING: Since the "owner" object is for big, fat datasets, this could blow up memory!
    
    \returns an array of instances, comprising all "owned" instances. This could recurse, inside the "child" objects.
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
    
    /***********************/
    /**
    This is a "generic" data database search. It can be called from external user contexts, and allows a fairly generalized search of the "data" database.
    Sorting will be done for the "owner" and "location" values. "owner" will be sorted by the ID of the returned records, and "location" will be by distance from the center.
    This will ignore any "owner" parameters, and will only look for this specific owner.
    There is no "OR" search. It is always "AND."
    
    It is "security-safe."
    
    \returns an array of instances that match the search parameters. If $count_only is TRUE, then it will be a single integer, with the count of responses to the search (if a page, then only the number of items on that page).
     */
    public function generic_search( $in_search_parameters = NULL,   /**< This is an associative array of terms to define the search. The keys should be:
                                                                        - 'id'
                                                                            This should be accompanied by an array of one or more integers, representing specific item IDs. These can only be ones "owned" by this instance.
                                                                        - 'access_class'
                                                                            This should be accompanied by an array, containing one or more PHP class names.
                                                                        - 'name'
                                                                            This will contain a case-insensitive array of strings to check against the object_name column.
                                                                        - 'tags'
                                                                            This should be accompanied by an array (up to 10 elements) of one or more case-insensitive strings, representing specific tag values.
                                                                        - 'location'
                                                                            This requires that the parameter be a 3-element associative array of floating-point numbers:
                                                                                - 'longtude'
                                                                                    This is the search center location longitude, in degrees.
                                                                                - 'latitude'
                                                                                    This is the search center location latitude, in degrees.
                                                                                - 'radius'
                                                                                    This is the search radius, in Kilometers.
                                                                    */
                                    $page_size = 0,                 ///< If specified with a 1-based integer, this denotes the size of a "page" of results. NOTE: This is only applicable to MySQL or Postgres, and will be ignored if the DB is not MySQL or Postgres.
                                    $initial_page = 0,              ///< This is ignored unless $page_size is greater than 0. If so, then this 0-based index will specify which page of results to return.
                                    $and_writeable = FALSE,         ///< If TRUE, then we only want records we can modify.
                                    $count_only = FALSE,            ///< If TRUE (default is FALSE), then only a single integer will be returned, with the count of items that fit the search.
                                    $ids_only = FALSE               ///< If TRUE (default is FALSE), then the return array will consist only of integers (the object IDs). If $count_only is TRUE, this is ignored.
                                    ) {
        $my_owner_id = intval($this->my_owner_id) ? intval($this->my_owner_id) : $this->id();
        $in_search_parameters['owner'] = $my_owner_id;
        return $this->get_access_object->generic_search($in_search_parameters, FALSE, $page_size, $initial_page, $and_writeable, $count_only, $ids_only);
        
        return $ret;
    }
}