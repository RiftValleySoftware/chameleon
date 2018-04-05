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

require_once(CO_Config::db_classes_extension_class_dir().'/co_place.class.php');
	
/***************************************************************************************************************************/
/**
This is a specialization of the location class. It adds support for US addresses, and uses the first eight tags for this.
 */
class CO_US_Place extends CO_Place {
    /***********************************************************************************************************************/
    /***********************/
    /**
     */
	protected function _get_address_element_labels() {
	    return Array(
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_0,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_1,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_2,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_3,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_4,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_5,
                        CO_CHAMELEON_Lang::$chameleon_co_us_place_tag_6
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
                                    $in_tags_array = NULL,  /**< An array of up to 10 strings, with address information in the first 7. Order is important:
                                                                - 0: Venue
                                                                - 1: Street Address
                                                                - 2: Extra Information
                                                                - 3: Town
                                                                - 4: County
                                                                - 5: State
                                                                - 6: ZIP Code
                                                              
                                                                Associative keys are not used. The array should be in that exact order.
	                                                        */
	                                $in_longitude = NULL,   ///< An initial longitude value.
	                                $in_latitude = NULL     ///< An initial latitude value.
                                ) {
        
        parent::__construct($in_db_object, $in_db_result, $in_owner_id, $in_tags_array, $in_longitude, $in_latitude);
        
        $this->class_description = "This is a 'Place' Class for US Addresses.";
    }
};