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
This is a specialization of the location class. It adds support for US addresses, and uses the first eight tags for this.
 */
class CO_Place extends CO_LL_Location {
    protected $_tag_key_array = Array();
    
    var $address_elements = Array();
    
    /***********************************************************************************************************************/
    /***********************/
    /**
     */
	protected function _get_address_element_labels() {
	    return Array(
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_0,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_1,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_2,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_3,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_4,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_5,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_6,
                        CO_CHAMELEON_Lang::$chameleon_co_place_tag_7
                    );
	}
	
    /***********************************************************************************************************************/
    /***********************/
    /**
    Constructor (Initializer)
     */
	public function __construct(    $in_db_object = NULL,   ///< The database object for this instance.
	                                $in_db_result = NULL,   ///< The database row for this instance (associative array, with database keys).
	                                $in_owner_id = NULL,    ///< The ID of the object (in the database) that "owns" this instance.
                                    $in_tags_array = NULL,  /**< An array of up to 10 strings, with address information. Order is important:
                                                                - 0: Venue
                                                                - 1: Street Address
                                                                - 2: Extra Information
                                                                - 3: Town
                                                                - 4: County
                                                                - 5: State
                                                                - 6: ZIP Code
                                                                - 7: Nation
	                                                        */
	                                $in_longitude = NULL,   ///< An initial longitude value.
	                                $in_latitude = NULL     ///< An initial latitude value.
                                ) {
        
        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array, $in_longitude, $in_latitude);
        
        $this->class_description = "This is a 'Place' Class for General Addresses.";
        $this->instance_description = isset($this->name) && $this->name ? "$this->name ($this->longitude, $this->latitude)" : "($this->longitude, $this->latitude)";
        
        $this->set_address_elements($this->tags);
    }
    
    /***********************/
    /**
    This sets the address_elements property, as per the provided array of strings.
     */
	public function set_address_elements ( $in_tags     /**< An array of up to 8 strings, with the new address information. Order is important:
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
                                ) {
        $this->address_elements = Array();
        $labels = $this->_get_address_element_labels();
        
        for ($i = 0; $i < count($labels); $i++) {
            $key = $labels[$i];
            $this->address_elements[$key] = isset($in_tags[$i]) ? $in_tags[$i] : '';
        }
    }

    /***********************/
    /**
    This updates the tags (and saves them to the DB) as per our internal address_elements property.
    
    \returns TRUE, if successful.
     */
	public function set_tags_from_address_elements() {
	    $new_tags = $this->tags;
        $labels = $this->_get_address_element_labels();
	    
        for ($i = 0; $i < count($labels); $i++) {
            $key = $labels[$i];
            $new_tags[$key] = $this->address_elements[$key];
        }
        
        return $this->set_tags($new_tags);
	}
};
