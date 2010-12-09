<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
*
* @version $Id: ps_csv.php 617 2007-01-04 19:43:08Z soeren_nb $
* @package VirtueMart
* @subpackage classes
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

/* The ps_csv class
 *
 * This class allows for the adding of multiple
 * products and categories from a csv file
 *************************************************************************/

class ps_csv {
	var $classname = "ps_csv";
	/** @var Array  Contains all fieldnames that are required on CSV Upload */
	var $reserved_words = array("product_sku");
	/** @var Array  Contains all fieldnames for the mos_{vm}_products table which are to be updated */
	var $use_in_product_query = array("vendor_id",
							 "product_parent_id",
							 "product_sku",
							 "product_s_desc",
							 "product_desc",
							 "product_thumb_image",
							 "product_full_image",
							 "product_publish",
							 "product_weight",
							 "product_weight_uom",
							 "product_length",
							 "product_width",
							 "product_height",
							 "product_lwh_uom",
							 "product_url",
							 "product_in_stock",
							 "product_available_date",
							 "product_availability",
							 "product_special",
							 "product_discount",
							 "product_discount_id",
							 "product_name",
							 "product_sales",
							 "attribute",
							 "custom_attribute",
							 "product_tax_id",
							 "product_unit",
							 "product_packaging");
	
	/** @var Array  Contains all fieldnames for the mos_{vm}_products table which are pre-filled by the system */
	var $fixed_fields = array("cdate","mdate","vendor_id");
	/** @var Array  Contains all fieldnames that are supported by the Improved CSV import/export */
	var $supported_fields = array("product_sku",
							"category_path",
							"attribute",
							"attributes",
							"custom_attribute",
							"attribute_values",
							"manufacturer_id",
							"manufacturer_name",
							"product_availability",
							"product_available_date",
							"product_box",
							"product_packaging",
							"product_delete",
							"product_desc",
							"product_discount",
							"product_discount_id",
							"product_full_image",
							"product_height",
							"product_length",
							"product_name",
							"product_publish",
							"product_s_desc",
							"product_thumb_image",
							"product_width",
							"product_weight",
							"product_weight_uom",
							"product_lwh_uom",
							"product_url",
							"product_in_stock",
							"product_sales",
							"product_special",
							"product_unit",
							"product_tax_id",
							"product_discount_date_start",
							"product_discount_date_end",
							"product_parent_sku",
							"product_price",
							"product_currency",
							"product_type_name",
						     "product_type_description",
						     "product_type_publish",
						     "product_type_browsepage",
						     "product_type_flypage",
						     "product_type_parameter_name",
						     "product_type_parameter_label",
						     "product_type_parameter_description",
						     "product_type_parameter_list_order",
						     "product_type_parameter_type",
						     "product_type_parameter_values",
						     "product_type_parameter_multiselect",
						     "product_type_parameter_default",
						     "product_type_parameter_unit",
							"price_quantity_start",
							"price_quantity_end",
							"price_delete");
	
	/** @var Array  Contains all fieldnames for the mos_{vm}_product_type table which are to be updated */
	var $use_in_product_type_query = array("product_type_name",
								    "product_type_description",
								    "product_type_publish",
								    "product_type_browsepage",
								    "product_type_flypage");
	
	/** @var Array  Contains all fieldnames for the mos_{vm}_product_type table which are to be updated */
	var $use_in_product_type_parameter_query = array("product_type_name",
									         "product_type_parameter_name",
										    "product_type_parameter_label",
										    "product_type_parameter_description",
										    "product_type_parameter_list_order",
										    "product_type_parameter_type",
										    "product_type_parameter_values",
										    "product_type_parameter_multiselect",
										    "product_type_parameter_default",
										    "product_type_parameter_unit");
	/** @var Array  Contains all fieldnames for the mos_{vm}_product_price table which are to be updated */
	var $use_in_product_multiple_price_query = array("product_sku",
								    "product_price",
								    "product_currency",
								    "price_quantity_start",
								    "price_quantity_end");
	var $encl;
	var $delim;
	
	function ps_csv() {
		$this->process = "NormalUpload";
		$this->price_list_only = false;
		$this->multiple_prices_upload = false;
		$this->product_type_upload = false;
		$this->product_type_parameters_upload = false;
		$this->product_type_xref_upload = false;
		$this->empty_database = false;
		$this->greater43 = false;
		
		// Check which PHP version the user runs. Lower than 4.3 does not support enclosure parameter
		if (substr(phpversion(), 0, 3) >= 4.3) $this->greater43 = true;
		else $this->greater43 = false;
	}
	
	/**************************************************************************
	** name: upload_csv()
	** created by: John Syben
	** modified by: nhyde
	** A db table named 'mos_{vm}_csv' must exist with the product fields
	** allocated their relative positions in the csv line
	***************************************************************************/
	
	function upload_csv(&$d) {
		global $data, $timestamp, $vmLogger;
		
		// Set the reporting array
		$d['csv_stats']['updated']['message'] = "";
		$d['csv_stats']['updated']['count'] = 0;
		$d['csv_stats']['deleted']['message'] = "";
		$d['csv_stats']['deleted']['count'] = 0;
		$d['csv_stats']['added']['message'] = "";
		$d['csv_stats']['added']['count'] = 0;
		$d['csv_stats']['skipped']['message'] = "";
		$d['csv_stats']['skipped']['count'] = 0;
		$d['csv_stats']['incorrect']['message'] = '';
		$d['csv_stats']['incorrect']['count'] = 0;
		
		// Get the user choices for import
		if (!$this->ValidateImportChoices($d)) $this->CleanUp($d);
		
		// Check if the user wants to empty the database instead of uploading a CSV file
		if ($this->empty_database) {
			$this->EmptyDatabase($d);
			$this->CleanUp($d);
			return true;
		}
		
		// Handle the upload here
		if (false == $this->handle_csv_upload($d) ) {
			return false;
		}
		
		// Open csv file
		$file = $d['csv_file'];
		$this->fp = fopen ($file,"r");
		$this_error = "";
		$this->line = 0;
		
		// Retrieve first line
		$this->RetrieveSingleLine();
		
		// Get the field configuration
		$this->RetrieveConfigFields();
		
		// Setup the product object
		$this->product_details = new product_details();
		
		// Check if the user wants us to show a preview
		if ($this->show_preview) {
			$d['preview'] = $this->ShowPreview($d);
			$this->CleanUp($d);
			return true;
		}
		else {
			// Start processing the data
			$this->RetrieveLine($d);
			$this->CleanUp($d);
			return true;
		}
	} //End function upload_csv
	
	function CleanUp(&$d) {
		// Check if there is any file left in the cache folder
		if (isset($d["was_preview"]) && $d["was_preview"] == "Y") {
			// if (file_exists($d['csv_file'])) unlink($d['csv_file']);
		}
		
		// Hide any errors generated by other components
		$d["error"] = '';
		
		// Make the debug messages global
		if ($this->debug) $d['csv_debug']['message'] = $this->csv_debug['message'];
		return true;
	}
	
	function RetrieveConfigFields() {
		global $data, $vmLogger;
		
		$this->csv_fields = array();
		$this->required_fields = array();
		$this->no_product_publish = true;
		
		if ($this->price_list_only) {
			$this->csv_fields['product_sku']['name'] = 'product_sku';
			$this->csv_fields['product_sku']['ordering'] = 1;
			$this->csv_fields['product_price']['name'] = 'product_price';
			$this->csv_fields['product_price']['ordering'] = 2;
			$this->required_fields['product_sku'] = 1;
			$this->required_fields['product_price'] = 2;
		}
		else if ($this->import_config_csv_file) {
			$this->unsupported_fields = "";
			foreach ($data as $ordering => $name) {
				// Trim the name in case the name contains any preceding or trailing spaces
				$name = trim($name);
				if ($this->process != "ProductTypeDetailUpload") {
					// Check if the fieldname is supported
					if (in_array($name, $this->supported_fields)) {
						$this->csv_fields[$name]["name"] = $name;
						$this->csv_fields[$name]["ordering"] = $ordering+1;
						$this->csv_fields[$name]["default_value"] = "";
						// Filter all required fields
						$this->required_fields[$name] = $ordering+1;
					}
					else $this->unsupported_fields .= $name.", ";
				}
				else {
					$this->csv_fields[$name]["name"] = $name;
					$this->csv_fields[$name]["ordering"] = $ordering+1;
					$this->csv_fields[$name]["default_value"] = "";
					// Filter all required fields
					$this->required_fields[$name] = $ordering+1;
				}
			}
			if ($this->unsupported_fields != "") {
				$vmLogger->err('CSV file contains unsupported fields: '.$this->unsupported_fields);
				return false;
			}
			if ($this->debug) $this->csv_debug['message'] .= 'Using the first line to setup the required fields<br />';
		}
		else {
			// Get row positions of each element as set in csv table
			$db = new ps_DB;        
			$q = "SELECT field_id,field_name,field_ordering,field_default_value,field_required FROM #__{vm}_csv ORDER BY field_ordering";
			$db->query($q);
			
			while( $db->next_record() ) {
				$this->csv_fields[$db->f("field_name")]["name"] = $db->f("field_name");
				$this->csv_fields[$db->f("field_name")]["ordering"] = $db->f("field_ordering");
				$this->csv_fields[$db->f("field_name")]["default_value"] = $db->f("field_default_value");
				// Filter all required fields
				if( $db->f("field_required" ) == "Y" ) {
					$this->required_fields[$db->f("field_name")] = $db->f("field_ordering");
				}
			}
			if ($this->debug) $this->csv_debug['message'] .= 'Use database for configuration<br />';
		}
		
		// Check if the user has specified the product_publish field
		if (array_key_exists("product_publish", $this->required_fields)) {
			$this->no_product_publish = false;
			if ($this->debug) $this->csv_debug['message'] .= 'Publish products field is used<br />';
		}
	}
	
	function RetrieveSingleLine() {
		global $data;
		
		if($this->greater43) $data = fgetcsv($this->fp, 4096, $this->delim, $this->encl);
		else $data = fgetcsv($this->fp, 4096, $this->delim);
	}
	
	function RetrieveLine(&$d) {
		global $data, $product_details;
		
		// Run through each line of file
		if($this->greater43) {
	  		$this->line = 1;	  
			while (($data = fgetcsv($this->fp, 4096, $this->delim, $this->encl)) !== FALSE) {
				// Get the product details
				$product_details = new product_details();
				// Call the appropiate function, depending on what the user has chosen
				if (call_user_func_array(array(&$this, $this->process), array(&$d)) !== FALSE) $this->line++;
				else return false;
			}
		}
		else {//PHP < 4.3
			while (($data = fgetcsv($this->fp, 4096, $this->delim)) !== FALSE) {
				if($this->skip_first_line) {
				    $this->skip_first_line = false;
				    continue;
				}
				// Get the product details
				$product_details = new product_details();
				call_user_func_array(array($this, $this->process), array(&$d));
				$this->line++;
			}
		}
		// Close the file, we are finished
		fclose($this->fp);
	}
	
	function PriceListUploadOnly(&$d) {
		global $data, $product_details;
		
		$dbu = new ps_DB;
		$dbp = new ps_DB;
		$dbpp = new ps_DB;
		
		if ($this->debug) $this->csv_debug['message'] .= 'Going into price list upload only<br />';
		// Check if the number of configured fields is the same as the number of fields in the CSV file
		
		if (2 > count($data)) {
			$d['csv_stats']['incorrect']['message'] .= "<strong>Incorrect column count</strong>";
			$data = false;
			return false;
		}
		else {
			$timestamp = time();
			// Check for required fields, do not allow empty values
			foreach( $this->required_fields as $fieldname => $ordering ) {
				if (empty($data[$ordering-1])) {
					$d['csv_stats']['incorrect']['message'] .= "Line $this->line: Contains empty value<br />";
					$d['csv_stats']['incorrect']['count']++;
					continue 2;
				}
				else {
					$data[$ordering-1] = trim($data[$ordering-1]);
					$$fieldname = $data[$ordering-1]; // This is a cool trick with dynamic variable names
				}
			}
			if ($this->debug) $this->csv_debug['message'] .= '<hr>Processing SKU: '.$product_details->product_sku.'<br />';
			// See if sku exists. If so, update product - otherwise add product
			$q = "SELECT product_id FROM #__{vm}_product ";
			$q .= "WHERE product_sku='".$product_details->product_sku."'";
			if ($this->debug) $this->csv_debug['message'] .= 'Check if the product exists: '.htmlentities($q).'<br />';
			$dbp->query($q);
			// Check if the SKU exists
			if ($dbp->next_record()) {
				/****************************
				** UPDATE PRODUCT ***********
				****************************/
				// Update product information
				$q = "UPDATE #__{vm}_product SET product_sku = '".$product_details->product_sku."', mdate='" . $timestamp . "' ";
				$q .= "WHERE product_sku='" . $product_details->product_sku . "'";
				if ($this->debug) $this->csv_debug['message'] .= 'Update the product with a modified timestamp: <a onclick="switchMenu(\''.$product_details->product_sku.'_mod_timestamp\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_mod_timestamp" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				if ($dbu->query($q)) {
					// Get the default shopper group ID
					$this->GetDefaultShopperGroupID($product_details->vendor_id);
					
					// Update product price for default shopper group
					$q = "UPDATE #__{vm}_product_price SET product_price='".$product_details->product_price."', mdate='" . $timestamp . "' ";
					$q .= "WHERE product_id='" . $dbp->f("product_id") . "'";
					if ($this->debug) $this->csv_debug['message'] .= 'Update the price of the product: '.htmlentities($q).'<br />';
					if ($dbpp->query($q)) {
						// Add report for this line to message
						$d['csv_stats']['updated']['message'] .= "Line $this->line: <strong>Updated</strong> Product SKU: $product_details->product_sku<br />";
						$d['csv_stats']['updated']['count']++;
					}
					else  {
						$d['csv_stats']['incorrect']['message'] .= "Line $this->line: Product SKU: $product_details->product_sku could not be updated<br />";
						$d['csv_stats']['incorrect']['count']++;
					}
				}
				else {
					$d['csv_stats']['incorrect']['message'] .= "Line $this->line: Product SKU: $product_details->product_sku could not be updated<br />";
					$d['csv_stats']['incorrect']['count']++;
				}
			}
			else {
				$d['csv_stats']['incorrect']['message'] .= "Line $this->line: Product SKU: $product_details->product_sku does not exist<br />";
				$d['csv_stats']['incorrect']['count']++;
			}
		}
		return true;
	}
	
	function NormalUpload(&$d) {
		global $data, $product_details;
		$dbp = new ps_DB;
		$dbu = new ps_DB;
		
		// Check if the number of configured fields is the same as the number of fields in the CSV file
		if (count($this->required_fields) != count($data)) {
			$d['csv_stats']['incorrect']['message'] .= "<strong>Incorrect column count</strong><br />Configration: ".count($this->required_fields)." fields<br />File: ".count($data)." fields<br />";
			return false;
		}
		else {
			// Check for required fields, allow empty values
			foreach( $this->required_fields as $fieldname => $ordering ) {
				if (!trim($data[$ordering-1]) && in_array($fieldname, $this->reserved_words)) {
					$this_error .= "No $fieldname";
				}
				else {
					// Clear the value from any trailing or preceding spaces
					$data[$ordering-1] = trim($data[$ordering-1]);
					$$fieldname = $data[$ordering-1]; // This is a cool trick with dynamic variable names
				}
			}
			if ($this->debug) $this->csv_debug['message'] .= '<hr>Processing SKU: '.$product_details->product_sku.'<br />';
			if ($this->debug) $this->csv_debug['message'] .= 'Going into normal upload<br />';
			
			// Process discount
			$product_details->ProcessDiscount();
			
			// If a required field was missing, add to error to main message and start next line
			// Otherwise add or update product
			if (!empty($this_error)) {
				$d['csv_stats']['incorrect']['message'] .= "Line $this->line: $this_error<br />";
				$d['csv_stats']['incorrect']['count']++;
				$this_error = "";
			}
			else if (!$product_details->product_sku) {
				$d['csv_stats']['incorrect']['message'] .= "Line $this->line: Product SKU not specified<br />";
				$d['csv_stats']['incorrect']['count']++;
			}
			else {
				$timestamp = time();
				// See if sku exists. If so, update product - otherwise add product
				$q = "SELECT product_id FROM #__{vm}_product ";
				$q .= "WHERE product_sku='".$product_details->product_sku."'";
				if ($this->debug) $this->csv_debug['message'] .= 'Check if the product exists: <a onclick="switchMenu(\''.$product_details->product_sku.'_exist_product\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_exist_product" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				$dbp->query($q);
				// Check if the SKU exists
				if ($dbp->next_record()) {
					/** Andrea
					// Check if the user wants to add Joom!Fish translation
					if ($insert_translation) $joomfish->newContent($data, $this->required_fields, $this->get_product_id($data[$this->csv_fields["product_sku"]["ordering"]-1]));
					*/
					
					// Check if the user wants to overwrite existing data
					/*************************************
					** OVERWRITE EXISTING DATA ***********
					*************************************/
					if (!$this->overwrite_existing_data) {
						if ($this->debug) $this->csv_debug['message'] .= 'Skipping product as we are not overwriting data: '.$data[$this->csv_fields["product_sku"]["ordering"]-1].'<br />';
						$d['csv_stats']['skipped']['message'] .= "Line $this->line: <strong>Data exists</strong> Product SKU: ".$data[$this->csv_fields["product_sku"]["ordering"]-1]."<br />";
						$d['csv_stats']['skipped']['count']++;
					}
					else {
						// Check if the user wants the product to be deleted
						/****************************
						** DELETE PRODUCT ***********
						****************************/
						if ($product_details->product_delete == "Y") {
							if ($this->debug) $this->csv_debug['message'] .= 'Deleting the product: '.$product_details->product_sku.'<br />';
							if ($product_details->product_id) {
								$d["product_id"][0] = $product_details->product_id;
								$delete_product= new ps_product;
								$delete_product->delete($d);
								if ($delete_product) {
									$d['csv_stats']['deleted']['message'] .= "Line $this->line: <strong>Deleted</strong> Product SKU: $product_details->product_sku<br />";
									$d['csv_stats']['deleted']['count']++;
								}
							}
							else {
								$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Not found for deletion</strong> Product SKU: $product_details->product_sku<br />";
								$d['csv_stats']['incorrect']['count']++;
							}
						}
						else {
							// UPDATE PRODUCT 
							if (!$this->ProductQuery("update")) {
								$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Incorrect</strong> Product SKU: $product_details->product_sku could not be updated<br />";
								$d['csv_stats']['incorrect']['count']++;
								if ($this->debug) $this->csv_debug['message'] .= 'Could not update product price<br />';
								continue;
							}
							
							/**********************************************************************************
							** ATTRIBUTE HANDLING *************************************************************
							** Let's first search for Attributes **********************************************
							** which are then added to this Product *******************************************
							** Syntax:   attribute_name::list_order|attribute_name::list_order...... **********
							***********************************************************************************/
							// Check if the attributes is to be added
							if (isset($this->required_fields["attributes"])) {
								if( !empty($data[$this->csv_fields["attributes"]["ordering"]-1])) {
									$attributes = explode( "|", $data[$this->csv_fields["attributes"]["ordering"]-1] );
									$i = 0;
									$q = "DELETE FROM #__{vm}_product_attribute_sku WHERE product_id ='".$product_details->product_id."'";
									if ($this->debug) $this->csv_debug['message'] .= 'Adding attributes: <a onclick="switchMenu(\''.$product_details->product_sku.'_add_attributes\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_attributes" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
									$dbu->query($q);
									while(list(,$val) = each($attributes)) {
										$values = explode( "::", $val );
										if( empty( $values[1] )) {
											$values[1] = $i;
										}
										$q = "INSERT INTO #__{vm}_product_attribute_sku (`product_id`, `attribute_name`, `attribute_list`)
										 VALUES ('".$product_details->product_id."', '".$values[0]."', '".$values[1]."' )";
										if ($this->debug) $this->csv_debug['message'] .= '<a onclick="switchMenu(\''.$product_details->product_sku.'_add_attributes.'.$i.'\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_attributes" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
										$dbu->query($q);
										$i++;
									}
								}
							}
							/******************************************************************************************
							** Now let's search for Attribute Values **************************************************
							** which are then added to this Child Product *********************************************
							** Syntax:   attribute_name::attribute_value|attribute_name::attribute_value..... *********
							******************************************************************************************/
							// Check if the attribute values is to be updated
							if ($product_details->attribute_values) {
								if ($this->debug) $this->csv_debug['message'] .= 'Adding attribute values<br />';
								$attribute_values = explode( "|", $data[$this->csv_fields["attribute_values"]["ordering"]-1] );
								$i = 0;
								$q = "DELETE FROM #__{vm}_product_attribute WHERE product_id ='".$product_details->product_id."'";
								if ($this->debug) $this->csv_debug['message'] .= 'Delete old values:<a onclick="switchMenu(\''.$product_details->product_sku.'_add_attribute_values\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_attribute_values" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
								$dbu->query($q);
								while(list(,$val) = each($attribute_values)) {
									$values = explode( "::", $val );
									if( empty( $values[1] )) {
										$values[1] = "";
									}
									$q = "INSERT INTO #__{vm}_product_attribute (`product_id`, `attribute_name`, `attribute_value`) VALUES ('".$product_details->product_id."', '".$values[0]."', '".$values[1]."' )";
									if ($this->debug) $this->csv_debug['message'] .= 'Insert new value: <a onclick="switchMenu(\''.$product_details->product_sku.'_add_attribute_value'.$i.'\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_attribute_value'.$i.'" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
									$dbu->query( );
									$i++;
								}
							}
							// Check if the product price is to be updated
							$this->PriceQuery("update");
							
							/*************************************************
							** Category path Check ***************************
							*************************************************/
							$this->CheckCategoryPath();
							
							/*************************************************
							** Manufacturer Check ****************************
							*************************************************/
							// Check if the category_path is to be added
							if ($product_details->manufacturer_name || $product_details->manufacturer_id) {
								if ($this->debug) $this->csv_debug['message'] .= 'Checking manufacturer<br />';
								$this->process_manufacturer($product_details->product_id);
							}
							
							// Add report for this line to message
							$d['csv_stats']['updated']['message'] .= "Line $this->line: <strong>Updated</strong> Product SKU: $product_details->product_sku<br />";
							$d['csv_stats']['updated']['count']++;
						}
					}
				}
				else if ($product_details->product_delete != "Y") {
					if ($this->debug) $this->csv_debug['message'] .= 'Adding new products<br />';
					
					/*************************************************
					** SKU does not exist - add new product **********
					** Add product information ***********************
					*************************************************/
					if (!$this->ProductQuery("add")) {
						$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Incorrect</strong> Product SKU: $product_details->product_sku could not be added<br />";
						$d['csv_stats']['incorrect']['count']++;
						continue;
					}
					
					/*************************************************
					** Manufacturer Check ****************************
					*************************************************/
					// Check if the manufacturer is to be added
					if ($product_details->manufacturer_name || $product_details->manufacturer_id) {
						if ($this->debug) $this->csv_debug['message'] .= 'Checking manufacturer<br />';
						$this->process_manufacturer($product_details->product_id);
					}
					
					/*************************************************
					** Category Check ********************************
					*************************************************/
					$this->CheckCategoryPath();
					
					/*************************************************
					** Price Check ***********************************
					*************************************************/
					// Check if the price is to be added
					$this->PriceQuery("add");
					
					/**********************************************************************************
					** ATTRIBUTE HANDLING *************************************************************
					** Let's first search for Attributes **********************************************
					** which are then added to this Product *******************************************
					** Syntax:   attribute_name::list_order|attribute_name::list_order...... **********
					***********************************************************************************/
					// Check if the category_path is to be added
					if ($product_details->attributes) {
						if ($this->debug) $this->csv_debug['message'] .= 'Adding attributes<br />';
						$attributes = explode( "|", $data[$this->csv_fields["attributes"]["ordering"]-1] );
						$i = 0;
						while(list(,$val) = each($attributes)) {
							$values = explode( "::", $val );
							if( empty( $values[1] ))
							$values[1] = $i;
							$dbu->query( "INSERT INTO #__{vm}_product_attribute_sku (`product_id`, `attribute_name`, `attribute_list`)
							 VALUES ('".$product_details->product_id."', '".$values[0]."', '".$values[1]."' )");
							$i++;
						}
					}
					/******************************************************************************************
					** Now let's search for Attribute Values **************************************************
					** which are then added to this Child Product *********************************************
					** Syntax:   attribute_name::attribute_value|attribute_name::attribute_value..... *********
					******************************************************************************************/
					// Check if the category_path is to be added
					if ($product_details->attribute_values) {
						if ($this->debug) $this->csv_debug['message'] .= 'Adding attribute values<br />';
						$attribute_values = explode( "|", $data[$this->csv_fields["attribute_values"]["ordering"]-1] );
						$i = 0;
						while(list(,$val) = each($attribute_values)) {
							$values = explode( "::", $val );
							if( empty( $values[1] ))
							$values[1] = "";
							$dbu->query( "INSERT INTO #__{vm}_product_attribute (`product_id`, `attribute_name`, `attribute_value`)
							 VALUES ('".$product_details->product_id."', '".$values[0]."', '".$values[1]."' )");
							$i++;
						}
					}
					// Add report for this line to message
					$d['csv_stats']['added']['message'] .= "Line $this->line: Product SKU: ".$product_details->product_sku."<br />";
					$d['csv_stats']['added']['count']++;
				}
				else if ($product_details->product_delete == "Y") {
					$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Not found for deletion</strong> Product SKU: ".$product_details->product_sku."<br />";
					$d['csv_stats']['incorrect']['count']++;
				}
			}
		}
	}
	
	function MultiplePricesUpload(&$d) {
		global $data, $product_details;
		
		$dbsg = new ps_DB();
		$db = new ps_DB();
		
		require_once(CLASSPATH.'ps_product_price.php');
		$ps_product_price = new ps_product_price();
		
		// Get the default shopper group ID
		$this->GetDefaultShopperGroupID($product_details->vendor_id);
		
		// Check if the user wants to delete a price
		if ($product_details->price_delete) {
			$q = "SELECT product_price_id FROM #__{vm}_product_price ";
			$q .= "WHERE product_id = '".$product_details->product_id."' ";
			$q .= "AND product_price = '".$product_details->product_price."' ";
			$q .= "AND product_currency = '".$product_details->product_currency."' ";
			$q .= "AND shopper_group_id = '".$GLOBALS[$product_details->vendor_id]["default_shopper_group"]."' ";
			$q .= "AND price_quantity_start = '".$product_details->price_quantity_start."' ";
			$q .= "AND price_quantity_end = '".$product_details->price_quantity_end."'";
			if ($this->debug) $this->csv_debug['message'] .= 'Get product price ID: <a onclick="switchMenu(\'product_price_id_'.$this->line.$product_details->product_sku.$product_details->product_id.'\');" title="Show/hide query">Show/hide query</a><div id="product_price_id_'.$this->line.$product_details->product_sku.$product_details->product_id.'" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
			$db->query($q);
			if (!$db->next_record()) {
				$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Price cannot be found</strong> Product SKU: ".$product_details->product_sku."<br />";
				$d['csv_stats']['incorrect']['count']++;
			}
			else {
				$product_price_id = $db->f('product_price_id');
				if (!$ps_product_price->delete_record($product_price_id, $d)) {
					$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Price cannot be deleted</strong> Product SKU: ".$product_details->product_sku."<br />";
					$d['csv_stats']['incorrect']['count']++;
				}
				else {
					$d['csv_stats']['deleted']['message'] .= "Line $this->line: <strong>Price has been deleted</strong> Product SKU: ".$product_details->product_sku."<br />";
					$d['csv_stats']['deleted']['count']++;
				}
			}
		}
		else {
			$d["product_id"] = $product_details->product_id;
			$d["shopper_group_id"] = $GLOBALS[$product_details->vendor_id]["default_shopper_group"];
			$d["product_price"] = $product_details->product_price;
			$d["product_currency"] = $product_details->product_currency;
			$d["price_quantity_start"] = $product_details->price_quantity_start;
			$d["price_quantity_end"] = $product_details->price_quantity_end;
			
			// Need to find out what these two fields are for
			$d["product_price_vdate"] = "";
			$d["product_price_edate"] = "";
			
			if (!$ps_product_price->add($d)) {
				$d['csv_stats']['skipped']['message'] .= "Line $this->line: <strong>Price already exists</strong> Product SKU: ".$product_details->product_sku."<br />";
				$d['csv_stats']['skipped']['count']++;
			}
			else {
				$d['csv_stats']['added']['message'] .= "Line $this->line: <strong>Price has been added</strong> Product SKU: ".$product_details->product_sku."<br />";
				$d['csv_stats']['added']['count']++;
			}
		}
	}
	
	function ProductTypeXrefUpload(&$d) {
		global $data, $product_details;
		
		$csv_product_type = new product_type();
		require_once(CLASSPATH.'ps_product_product_type.php');
		$ps_product_product_type_xref = new ps_product_product_type();
		// Set the values needed for adding the cross reference
		$d["product_id"] = $product_details->product_id;
		$d["product_type_id"] = $csv_product_type->product_type_id;
		
		if (!$ps_product_product_type_xref->add($d)) {
			$d['csv_stats']['incorrect']['message'] .= "Line $this->line: <strong>Cross reference already exists</strong> Product SKU: ".$product_details->product_sku."<br />";
			$d['csv_stats']['incorrect']['count']++;
		}
		else {
			$d['csv_stats']['added']['message'] .= "Line $this->line: <strong>Cross reference has been added</strong> Product SKU: ".$product_details->product_sku."<br />";
			$d['csv_stats']['added']['count']++;
		}
	}
	
	function ProductTypeUpload(&$d) {
		global $data, $product_details;
		
		// Check for product type
		$csv_product_type = new product_type();
		require_once(CLASSPATH.'ps_product_type.php');
		$ps_product_type = new ps_product_type();
		if ($csv_product_type->product_type_id) {
			// Set the values to be updated
			$d['product_type_id'] = $csv_product_type->product_type_id;
			$d['product_type_name'] = $csv_product_type->product_type_name;
			$d['product_type_description'] = $csv_product_type->product_type_description;
			$d['product_type_publish'] = $csv_product_type->product_type_publish;
			$d['product_type_browsepage'] = $csv_product_type->product_type_browsepage;
			$d['product_type_flypage'] = $csv_product_type->product_type_flypage;
			$d['list_order'] = $csv_product_type->product_type_list_order;
			$d['currentpos'] = $csv_product_type->product_type_list_order;
			if ($ps_product_type->update($d)) {
				$d['csv_stats']['updated']['message'] .= 'Line '.$this->line.': <strong>Updated</strong> Product type name: '.$csv_product_type->product_type_name.'<br />';
				$d['csv_stats']['updated']['count']++;
			}
			else {
				$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Updated</strong> Product type name: '.$csv_product_type->product_type_name.' could not be updated<br />';
				$d['csv_stats']['incorrect']['count']++;
			}
		}
		else {
			// Set the values to be added
			$d['product_type_name'] = $csv_product_type->product_type_name;
			$d['product_type_description'] = $csv_product_type->product_type_description;
			$d['product_type_publish'] = $csv_product_type->product_type_publish;
			$d['product_type_browsepage'] = $csv_product_type->product_type_browsepage;
			$d['product_type_flypage'] = $csv_product_type->product_type_flypage;
			if ($ps_product_type->add($d)) {
				$d['csv_stats']['added']['message'] .= 'Line '.$this->line.': <strong>Added</strong> Product type name: '.$csv_product_type->product_type_name.'<br />';
				$d['csv_stats']['added']['count']++;
			}
			else {
				$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Incorrect</strong> Product type name: '.$csv_product_type->product_type_name.' could not be added<br />';
				$d['csv_stats']['incorrect']['count']++;
			}
		}
	}
	
	function ProductTypeParametersUpload(&$d) {
		global $data, $product_details;
		
		$db = new ps_DB;
		
		// Check for product type
		$csv_product_type_parameters = new product_type_parameters();
		require_once(CLASSPATH.'ps_product_type_parameter.php');
		$ps_product_type_parameters = new ps_product_type_parameter();
		
		// Set the values to be updated
		$d['product_type_id'] = $csv_product_type_parameters->product_type_id;
		$d['parameter_name'] = $csv_product_type_parameters->product_type_parameter_name;
		$d['parameter_old_name'] = $csv_product_type_parameters->product_type_parameter_name;
		$d['parameter_label'] = $csv_product_type_parameters->product_type_parameter_label;
		$d['parameter_description'] = $csv_product_type_parameters->product_type_parameter_description;
		$d['list_order'] = $csv_product_type_parameters->product_type_parameter_list_order;
		$d['currentpos'] = $csv_product_type_parameters->product_type_parameter_list_order;
		$d['parameter_type'] = $csv_product_type_parameters->product_type_parameter_type;
		$d["parameter_old_type"] = $csv_product_type_parameters->product_type_parameter_old_type;
		$d['parameter_values'] = $csv_product_type_parameters->product_type_parameter_values;
		$d['parameter_multiselect'] = $csv_product_type_parameters->product_type_parameter_multiselect;
		$d['parameter_default'] = $csv_product_type_parameters->product_type_parameter_default;
		$d['parameter_unit'] = $csv_product_type_parameters->product_type_parameter_unit;
		
		if ($csv_product_type_parameters->product_type_id) {
			// Check if we need to update or add the data
			$q = "SELECT COUNT(*) AS total FROM #__{vm}_product_type_parameter WHERE product_type_id = '".$csv_product_type_parameters->product_type_id."' AND parameter_name = '".$csv_product_type_parameters->product_type_parameter_name."'";
			$db->query($q);
			if ($db->f("total") > 0) {
				if ($ps_product_type_parameters->update_parameter($d)) {
					$d['csv_stats']['updated']['message'] .= 'Line '.$this->line.': <strong>Updated</strong> Product type parameter name: '.$csv_product_type_parameters->product_type_parameter_name.'<br />';
					$d['csv_stats']['updated']['count']++;
				}
				else {
					$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Updated</strong> Product type parameter name: '.$csv_product_type_parameters->product_type_parameter_name.' could not be updated<br />';
					$d['csv_stats']['incorrect']['count']++;
				}
			}
			else {
				if ($ps_product_type_parameters->add_parameter($d)) {
					$d['csv_stats']['added']['message'] .= 'Line '.$this->line.': <strong>Added</strong> Product type parameter name: '.$csv_product_type_parameters->product_type_parameter_name.'<br />';
					$d['csv_stats']['added']['count']++;
				}
				else {
					$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Incorrect</strong> Product type parameter name: '.$csv_product_type_parameters->product_type_parameter_name.' could not be added<br />';
					$d['csv_stats']['incorrect']['count']++;
				}
			}
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Incorrect</strong> Product type parameter name: '.$csv_product_type_parameters->product_type_parameter_name.' has no product type linked<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
	}
	
	function ProductTypeDetailUpload(&$d) {
		global $data, $product_details;
		
		if ($product_details->product_id) {
			$db = new ps_DB;
			
			// Get the product type parameters, we need the product_type_id
			$csv_product_type = new product_type();
			
			// Get the fields for the product type #
			$q = "SHOW COLUMNS FROM #__{vm}_product_type_".$csv_product_type->product_type_id;
			$db->query($q);
			
			$q = "INSERT INTO #__{vm}_product_type_".$csv_product_type->product_type_id." ";
			$q .= "(";
			foreach ($db->loadAssoclist() as $key => $col_details) {
				$q .= $col_details["Field"].", ";
			}
			$q = substr($q, 0, -2);
			$q .= ") VALUES (".$product_details->product_id.",";
			foreach ($this->required_fields as $fieldname => $id) {
				if (($fieldname != "product_sku") && ($fieldname != "product_type_name")) {
					$q .= "'".$data[$id-1]."',";
				}
			}
			$q = substr($q, 0, -1);
			$q .= ")";
			if ($this->debug) $this->csv_debug['message'] .= 'Adding new product type details: <a onclick="switchMenu(\''.$product_details->product_sku.'_add_product_type\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_product_type" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
			
			if ($db->query($q)) {
				$d['csv_stats']['added']['message'] .= 'Line '.$this->line.': <strong>Added</strong> Product type detail SKU: '.$product_details->product_sku.'<br />';
				$d['csv_stats']['added']['count']++;
			}
			else {
				$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Incorrect</strong> Product SKU could not be added: '.$product_details->product_sku.'<br />';
				$d['csv_stats']['incorrect']['count']++;
			}
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Line '.$this->line.': <strong>Incorrect</strong> Product SKU not found: '.$product_details->product_sku.'<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
	}
	
	function EmptyDatabase(&$d) {
		$db = new ps_DB();
		
		// Empty all the necessary tables
		$q = "TRUNCATE TABLE `#__{vm}_product`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product table: <a onclick="switchMenu(\'product_table\');" title="Show/hide query">Show/hide query</a><div id="product_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_price`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product price table: <a onclick="switchMenu(\'product_price_table\');" title="Show/hide query">Show/hide query</a><div id="product_price_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product price table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product price table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_mf_xref`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product manufacturer link table: <a onclick="switchMenu(\'product_mf_xref_table\');" title="Show/hide query">Show/hide query</a><div id="product_mf_xreftable" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product manufacturer link table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product manufactuere link table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_attribute`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product attribute table: <a onclick="switchMenu(\'product_attribute_table\');" title="Show/hide query">Show/hide query</a><div id="product_attribute_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product attribute table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product attribute table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_category`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty category table: <a onclick="switchMenu(\'category_table\');" title="Show/hide query">Show/hide query</a><div id="category_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Category table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Category table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_category_xref`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty category link table: <a onclick="switchMenu(\'category_link_table\');" title="Show/hide query">Show/hide query</a><div id="category_link_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Category link table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Category link table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_attribute_sku`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty attribute for parent products table: <a onclick="switchMenu(\'product_attribute_sku_table\');" title="Show/hide query">Show/hide query</a><div id="product_attribute_sku_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Attribute for parent products table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Attribute for parent products table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_category_xref`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product category link table: <a onclick="switchMenu(\'product_category_xref\');" title="Show/hide query">Show/hide query</a><div id="product_category_xref" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product category link table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product category link table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_discount`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product discount table: <a onclick="switchMenu(\'product_discount_table\');" title="Show/hide query">Show/hide query</a><div id="product_discount_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product discount table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product discount table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_type`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product type table: <a onclick="switchMenu(\'product_type_table\');" title="Show/hide query">Show/hide query</a><div id="product_type_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product type table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product type table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_type_parameter`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product type parameter table: <a onclick="switchMenu(\'product_type_parameter_table\');" title="Show/hide query">Show/hide query</a><div id="product_type_parameter_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product type parameter table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product type parameter table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "TRUNCATE TABLE `#__{vm}_product_product_type_xref`;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty product type link table: <a onclick="switchMenu(\'product_product_type_xref_table\');" title="Show/hide query">Show/hide query</a><div id="product_product_type_xref_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Product type link table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Product type link table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		$q = "DELETE FROM `#__{vm}_manufacturer` WHERE manufacturer_id > 1;";
		if ($this->debug) $this->csv_debug['message'] .= 'Empty manufacturer table: <a onclick="switchMenu(\'manufacturer_table\');" title="Show/hide query">Show/hide query</a><div id="manufacturer_table" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		if ($db->query($q)) {
			$d['csv_stats']['added']['message'] .= 'Manufacturer table has been emptied<br />';
			$d['csv_stats']['added']['count']++;
		}
		else {
			$d['csv_stats']['incorrect']['message'] .= 'Manufacturer table has not been emptied<br />';
			$d['csv_stats']['incorrect']['count']++;
		}
		
		// Check if there are any product type tables created, if so, remove them
		$q = "SHOW TABLES LIKE '%product_type__'";
		$db->query($q);
		while ($db->next_record()) {
			$db_drop = new ps_DB();
			$tablename = $db->f("Tables_in_furniturestore (%product_type__)");
			$q_drop = "DROP TABLE `".$tablename."`;";
			if ($this->debug) $this->csv_debug['message'] .= 'Deleting product type name '.$tablename.' table: <a onclick="switchMenu(\'product_type_name_table_'.$tablename.'\');" title="Show/hide query">Show/hide query</a><div id="product_type_name_table_'.$tablename.'" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_drop).'</div><br />';
			if ($db_drop->query($q_drop)) {
				$d['csv_stats']['deleted']['message'] .= 'Product type name table '.$tablename.' has been removed<br />';
				$d['csv_stats']['deleted']['count']++;
			}
			else {
				$d['csv_stats']['incorrect']['message'] .= 'Product type name table '.$tablename.' has not been removed<br />';
				$d['csv_stats']['incorrect']['count']++;
			}
		}
	}
	
	/**************************************************************************
	** name: csv_category()
	** created by: John Syben
	** Creates categories from slash delimited line
	***************************************************************************/
	function csv_category($line) {
		
		// New: Get all categories in this field,
		// delimited with |
		$categories = explode("|", $line);
		foreach( $categories as $line ) {
			// Explode slash delimited category tree into array
			$category_list = explode("/", $line);
			$category_count = count($category_list);

			$db = new ps_DB;
			$category_parent_id = '0';

			// For each category in array
			for($i = 0; $i < $category_count; $i++) {
				// See if this category exists with it's parent in xref
				$q = "SELECT #__{vm}_category.category_id FROM #__{vm}_category,#__{vm}_category_xref ";
				$q .= "WHERE #__{vm}_category.category_name='" . $db->getEscaped($category_list[$i]) . "' ";
				$q .= "AND #__{vm}_category_xref.category_child_id=#__{vm}_category.category_id ";
				$q .= "AND #__{vm}_category_xref.category_parent_id='$category_parent_id'";
				$db->query($q);
				// If it does not exist, create it
				if ($db->next_record()) { // Category exists
					$category_id = $db->f("category_id");
				}
				else { // Category does not exist - create it

					$timestamp = time();

					// Let's find out the last category in
					// the level of the new category
					$q = "SELECT MAX(list_order) AS list_order FROM #__{vm}_category_xref,#__{vm}_category ";
					$q .= "WHERE category_parent_id='".$category_parent_id."' ";
					$q .= "AND category_child_id=category_id ";
					$db->query( $q );
					$db->next_record();

					$list_order = intval($db->f("list_order"))+1;

					// Add category
					$q = "INSERT INTO #__{vm}_category ";
					$q .= "(vendor_id,category_name, category_publish,cdate,mdate,list_order) ";
					$q .= "VALUES ('1', '";
					$q .= $category_list[$i] . "', '";
					$q .= "Y', '";
					$q .= $timestamp . "', '";
					$q .= $timestamp . "', '$list_order')";
					$db->query($q);

					$category_id = $db->last_insert_id();

					// Create xref with parent
					$q = "INSERT INTO #__{vm}_category_xref ";
					$q .= "(category_parent_id, category_child_id) ";
					$q .= "VALUES ('";
					$q .= $category_parent_id . "', '";
					$q .= $category_id . "')";
					$db->query($q);
				}
				// Set this category as parent of next in line
				$category_parent_id = $category_id;
			} // end for
			$category[] = $category_id;
		}
		// Return an array with the last category_ids which is where the product goes
		return $category;

	} // End function csv_category

	/**
	  * Handle the upload of file "file".
	  *
	  * Longer, multi-line description here.
	  * 
	  * @name handle_csv_upload
	  * @author Nathan Hyde <nhyde@bigdrift.com>
	  * @param array d posted items crammed into 1 arr
	  * @returns boolean True of False
	  */
	function handle_csv_upload(&$d) {
		global $vmLogger, $mosConfig_cachepath;
		$allowed_suffixes_arr = array(
		0=> 'csv'
		,1 => 'txt'
		// add more here if needed
		);
		
		$allowed_mime_types_arr = array('text/html',
									'text/plain',
									'text/csv',
									'application/octet-stream',
									'application/x-octet-stream',
									'application/vnd.ms-excel',
									'application/force-download',
									'text/comma-separated-values',
									'text/x-csv',
									'text/x-comma-separated-values'
									// add more here if needed
									);

		$error = "";
		// No CSV file given
		if (empty($_FILES["file"]["name"]) && empty($d['local_csv_file'])) {
			$vmLogger->err('No CSV file provided.' );
			return False;
		}
		// Using local file
		if (empty($_FILES["file"]["tmp_name"])) {
			$d['csv_file'] = $d['local_csv_file'];
			if( !file_exists($d['csv_file'])) {
				$vmLogger->err('Specified local file doesn\'t exist.' );
				return False;
			}
			$fileinfo = pathinfo($d['csv_file']);
			$extension = $fileinfo["extension"];
		}
		// Using an uploaded file
		else {
			// Check if user is going to preview first
			// User doing a preview, we must save the file first
			if (isset($d['show_preview']) && $d['show_preview'] == "Y") {
				$d['preview_message'] = "";
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {
					if (is_dir($mosConfig_cachepath) && is_writeable($mosConfig_cachepath)) {
						move_uploaded_file($_FILES['file']['tmp_name'], $mosConfig_cachepath."/".basename($_FILES['file']['name']));
						$d['csv_file'] = $mosConfig_cachepath."/".basename($_FILES['file']['name']);
					}
					else {
						$d['preview_only'] = 'Cannot upload file to '.$mosConfig_cachepath.'. Only preview is possible. To import the file, do a direct import.';
						$d['csv_file'] = $_FILES['file']['tmp_name'];
					}
				}
				else {
					$vmLogger->err('Possible file upload attack: filename "'. $_FILES['file']['tmp_name'] . '"."');
				}
			}
			// Test the mime type
			if (!in_array($_FILES["file"]["type"], $allowed_mime_types_arr) ) {
				$vmLogger->err('Mime type not accepted. Type for file uploaded: '.$_FILES["file"]["type"] );
				return false;
			}
			if (empty($d['show_preview'])) $d['csv_file'] = $_FILES['file']['tmp_name'];
			$fileinfo = pathinfo($_FILES["file"]["name"]);
			$extension = $fileinfo["extension"];
		}
		if (!in_array($extension, $allowed_suffixes_arr) ) {
			$vmLogger->err('File Extension not allowed. Valid extensions are: ' . join(", ",$allowed_suffixes_arr) );
			return false;
		}
		return true;
	}
	
	/**
	  * Handle the export of product records in a csv file
	  *
	  * @name export_csv
	  * @author soeren
	  * @param array d
	  * @return void
	  * 
	  */
	function export_csv (&$d) {
		global $mosConfig_sitename;
		$ps_vendor_id = $_SESSION['ps_vendor_id'];
		$use_standard_order = mosGetParam( $_REQUEST, 'use_standard_order', "N" );
		$db = new ps_DB;
		$dbs = new ps_DB;
		$database = new ps_DB;

		// Get the default shopper group ID
		$shopper_group_id = $this->GetDefaultShopperGroupID($ps_vendor_id, true);
		
		// Get row positions of each element as set in csv table
		$db = new ps_DB;
		$q = "SELECT * FROM #__{vm}_csv ORDER BY field_ordering";
		$db->query($q);

		$csv_ordering = array();
		while( $db->next_record() ) {
			$csv_ordering[] = $db->f("field_name");
		}
		
		/** Export SQL Query
        * Get all products - including items
        * as well as products without a price
        **/
	   $sql = 'SELECT *, #__{vm}_product.product_id FROM #__{vm}_product
        		LEFT OUTER JOIN #__{vm}_product_price
        		ON #__{vm}_product.product_id = #__{vm}_product_price.product_id
        		AND #__{vm}_product.vendor_id = \'1\'
        		AND shopper_group_id = \'5\'
        		LEFT JOIN #__{vm}_product_mf_xref
        			ON #__{vm}_product.product_id = #__{vm}_product_mf_xref.product_id
        		ORDER BY product_parent_id ASC , #__{vm}_product.product_id ASC';
		$db->query($sql);
		// Check if the user has entered a custom delimeter
		if (!$d['csv_delimiter']) $this->delim = $d['csv_delimiter_custom'];
		else $this->delim = $d['csv_delimiter'];
		
		// Check if the user has entered a custom enclosure char
		if (!$d['csv_enclosurechar']) $this->encl = stripslashes(@$d['csv_enclosurechar_custom']);
		else $this->encl = stripslashes(@$d['csv_enclosurechar']);

		if(empty($this->encl) && !isset($d['csv_enclosurechar'])) $this->encl = "~";
		
		// Check if the user has chosen to add column headers
		$include_column_headers = false;
		if(!empty($d['include_column_headers'])) {
			$include_column_headers = true;
		}
		
		$contents = "";
		$db_attributes = new ps_DB;
		$db_attribute_values = new ps_DB;
		// Add the column headers if user choose them
		if ($include_column_headers) {
			$contents .= $this->encl. implode( $this->encl.$this->delim . $this->encl, $csv_ordering ) . $this->encl;
			$contents .= "\n";
		}
		/** Loop through all records
		* and create the csv file - line after line ***/
		while ($db->next_record()) {
			$attributes = $attribute_values = "";
			if( $db->f("product_parent_id") == 0 ) {
				$db_attributes->query( "SELECT attribute_name, attribute_list FROM #__{vm}_product_attribute_sku WHERE product_id = '".$db->f("product_id")."'" );
				if( $db_attributes->next_record() ) {
					$has_attributes = true;
					$db_attributes->reset();
					while( $db_attributes->next_record() ) {
						$attributes .= $db_attributes->f("attribute_name"). "::". $db_attributes->f("attribute_list");
						// to be replaced by
						// if( !$db_attributes->is_last_record())
						if( $db_attributes->row+1 < $db_attributes->num_rows()) {
							$attributes .= "|";
						}
					}
				}
				
				$export_sku = $db->f("product_sku");
			}
			else {
				$db_attribute_values->query( "SELECT attribute_name, attribute_value FROM #__{vm}_product_attribute WHERE product_id = '".$db->f("product_id")."'" );
				if( $db_attribute_values->next_record() ) {
					$db_attribute_values->reset();
					while( $db_attribute_values->next_record() ) {
						$attribute_values .= $db_attribute_values->f("attribute_name")."::". $db_attribute_values->f("attribute_value");
						if( $db_attribute_values->row+1 < $db_attribute_values->num_rows()) {
							$attribute_values .= "|";
						}
					}
				}
				$database->query( "SELECT product_sku FROM #__{vm}_product WHERE product_id='".$db->f("product_parent_id")."'" );
				$database->next_record();
				$export_sku = $database->f('product_sku');
			}
			if ($use_standard_order == "Y") {
				$contents .= 	$this->encl . $db->f("product_sku"). 	$this->encl
					. $this->delim .	$this->getEscapedAndEnclosed( $db->f("product_name"))
					. $this->delim . 	$this->getEscapedAndEnclosed( $this->get_category_path( $db->f("product_id") ) )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_price") )
					. $this->delim . 	$this->cleanString( $this->getEscapedAndEnclosed( $db->f("product_s_desc")))
					. $this->delim . 	$this->cleanString( $this->getEscapedAndEnclosed($db->f("product_desc")))
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_thumb_image"))
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_full_image"))
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_weight") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_weight_uom") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_length") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_width") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_height") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_lwh_uom"))
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_in_stock") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_available_date") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_discount_id") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("manufacturer_id") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_tax_id") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("product_sales") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $export_sku )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("attribute") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $db->f("custom_attribute") )
					. $this->delim . 	$this->getEscapedAndEnclosed( $attributes )
					. $this->delim . 	$this->getEscapedAndEnclosed( $attribute_values ) ."\n";
			}
			else {
				$num = sizeof( $csv_ordering );
				for( $i = 0; $i < $num; $i++ ) {
					if( $csv_ordering[$i] == "category_path" ) {
						$contents .= $this->getEscapedAndEnclosed( $this->get_category_path( $db->f("product_id") ) );
					}
					elseif( $csv_ordering[$i] == "attributes" ) {
						$contents .= $this->getEscapedAndEnclosed( $attributes ) ;
					}
					elseif( $csv_ordering[$i] == "attribute_values" ) {
						$contents .= $this->getEscapedAndEnclosed( $attribute_values );
					}
					// PROBLEM: when exporting the Product Parent ID we can't be sure
					// that the Parent Product gets the same ID on re-import
					// So we just take the Parent Product's SKU!
					elseif( $csv_ordering[$i] == "product_parent_sku" ) {
						$contents .= $this->getEscapedAndEnclosed( $export_sku );
					}
					// To be able to import the date again, we need to make sure it
					// is human readable again
					elseif( $csv_ordering[$i] == "product_available_date" ) {
						$date_parts = getdate(trim($db->f($csv_ordering[$i])));
						$contents .= $this->getEscapedAndEnclosed( $date_parts["mday"]."/".$date_parts["mon"]."/".$date_parts["year"] );
					}
					else {
						$contents .= $this->getEscapedAndEnclosed( $this->cleanString($db->f($csv_ordering[$i] )) );
					}
					// Add delimiter (if not line end)
					if( $i+1 < $num ) {
						$contents .= $this->delim;
					}
				}
				// Finish line
				$contents .=  "\n";
			}

		}
		$filename = "CSV_Export_" .date("j-m-Y_H.i"). ".csv";

		if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
			$UserBrowser = "Opera";
		}
		elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
			$UserBrowser = "IE";
		} else {
			$UserBrowser = '';
		}
		$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';

		// dump anything in the buffer
		while( @ob_end_clean() );

		header('Content-Type: ' . $mime_type);
		header('Content-Encoding: none');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		if ($UserBrowser == 'IE') {
			header('Content-Disposition: inline; filename="' . $filename . '"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Pragma: no-cache');
		}
		/*** Now dump the data!! ***/
		echo $contents;
		
		// do nothin' more
		exit();
	}

	/**
	  * Get the slash delimited category path of a product
	  *
	  * @name get_category_path
	  * @author soeren
	  * @param int $product_id
	  * @returns String category_path
	  */
	function get_category_path( $product_id ) {
		$db = new ps_DB;
		$database = new ps_DB();

		$q = "SELECT #__{vm}_product.product_id, #__{vm}_product.product_parent_id, category_name,#__{vm}_category_xref.category_parent_id "
		."FROM #__{vm}_category, #__{vm}_product, #__{vm}_product_category_xref,#__{vm}_category_xref "
		."WHERE #__{vm}_product.product_id='$product_id' "
		."AND #__{vm}_category_xref.category_child_id=#__{vm}_category.category_id "
		."AND #__{vm}_category_xref.category_child_id = #__{vm}_product_category_xref.category_id "
		."AND #__{vm}_product.product_id = #__{vm}_product_category_xref.product_id";
		$database->query( $q );
		$rows = $database->record;
		$k = 1;
		$category_path = "";

		foreach( $rows as $row ) {
			$category_name = Array();

			/** Check for product or item **/
			if ( $row->category_name ) {
				$category_parent_id = $row->category_parent_id;
				$category_name[] = $row->category_name;
			}
			else {
				/** must be an item
              * So let's search for the category path of the
              * parent product **/
				$q = "SELECT product_parent_id FROM #__{vm}_product WHERE product_id='$product_id'";
				$db->query( $q );
				$db->next_record();

				$q  = "SELECT #__{vm}_product.product_id, #__{vm}_product.product_parent_id, category_name,#__{vm}_category_xref.category_parent_id "
				."FROM #__{vm}_category, #__{vm}_product, #__{vm}_product_category_xref,#__{vm}_category_xref "
				."WHERE #__{vm}_product.product_id='".$db->f("product_parent_id")."' "
				."AND #__{vm}_category_xref.category_child_id=#__{vm}_category.category_id "
				."AND #__{vm}_category_xref.category_child_id = #__{vm}_product_category_xref.category_id "
				."AND #__{vm}_product.product_id = #__{vm}_product_category_xref.product_id";
				$db->query( $q );
				$db->next_record();
				$category_parent_id = $db->f("category_parent_id");
				$category_name[] = $db->f("category_name");
			}
			if( $category_parent_id == "") $category_parent_id = "0";

			while( $category_parent_id != "0" ) {
				$q = "SELECT category_name, category_parent_id "
				."FROM #__{vm}_category, #__{vm}_category_xref "
				."WHERE #__{vm}_category_xref.category_child_id=#__{vm}_category.category_id "
				."AND #__{vm}_category.category_id='$category_parent_id'";
				$db->query( $q );
				$db->next_record();
				$category_parent_id = $db->f("category_parent_id");
				$category_name[] = $db->f("category_name");
			}
			if ( sizeof( $category_name ) > 1 ) {
				for ($i = sizeof($category_name)-1; $i >= 0; $i--) {
					$category_path .= $category_name[$i];
					if( $i >= 1) $category_path .= "/";
				}
			}
			else
			$category_path .= $category_name[0];

			if( $k++ < sizeof($rows) )
			$category_path .= "|";
		}
		return $category_path;
	}
	
	/**
	  * Show preview
	  *
	  * @name show_preview
	  * @author rolandd
	  * @param int $query_type
	  * @returns String update or insert query for a product
	  */
	function ShowPreview(&$d) {
		global $data;
		
		$d['preview'] = "<table style=\"empty-cells: show;\"><tr>";
		foreach ($this->required_fields as $name => $order) {
			$d['preview'] .= "<td style=\"border: 1px solid #000000; border-color: #FF0000; font-weight: bold;\">".$name."</td>";
		}
		$d['preview'] .= "</tr><tr>";
		$total_lines = 0;
		for ($i = 0; $i < 5; $i++) {
			if( $this->skip_first_line || $this->import_config_csv_file) {
				// If the first line is to be skipped, set the flag to false and continue with the second line
				$this->skip_first_line = false;
				$this->import_config_csv_file = false;
				
				$this->RetrieveSingleLine();
			}
			else {
				$this->RetrieveSingleLine();
			}
			if (empty($data)) continue;
			foreach( $this->csv_fields as $fieldname ) {
				// Process only those fields that the user has set to required
				if  (array_key_exists($fieldname["name"], $this->required_fields)) {
					$d['preview'] .= "<td style=\"border: 1px solid #000000; vertical-align: top;\">".substr(trim($data[$fieldname["ordering"]-1]),0,100)."</td>";
				}
			}
			$d['preview'] .= "</tr><tr>";
		}
		$d['preview'] .= "</tr></table>";
		return $d['preview'];
	}
	
	/**
	  * Creates either an update or insert SQL query for a product.
	  *
	  * @name product_query
	  * @author rolandd
	  * @param int $query_type
	  * @returns String update or insert query for a product
	  */
	function ProductQuery($query_type) {
		global $timestamp, $product_details, $database;
		
		$dbu = new ps_DB;
		if ($query_type == "update") $q = "UPDATE #__{vm}_product SET ";			
		else if ($query_type == "add") {
			$qfields = "";
			$qdata = "";
		}
		// Update product information
		foreach ($this->use_in_product_query as $id => $column) {
			// Process only those fields that the user has set to required
			if  (array_key_exists($column, $this->required_fields)) {
				// Add a redirect for the product discount
				if ($column == "product_discount") $column = "product_discount_id";
				
				if ($query_type == "update") $q .= $column . " = '" . $dbu->getEscaped($product_details->$column) . "', ";			
				else if ($query_type == "add") {
					$qfields .= $column.", ";
					$qdata .= "'".$dbu->getEscaped($product_details->$column) . "', ";
				}
			}
		}
		
		if ($query_type == "update") {
			$q .= "mdate='".$timestamp."' ";
			// If the user is not using the product publish field, we set it to yes
			if ($this->no_product_publish) $q .= ", product_publish ='Y' ";
			// If the user is not using the product publish field, we set it to yes
			$q .= "WHERE product_sku='".$product_details->product_sku."'";
			if ($this->debug) $this->csv_debug['message'] .= 'Updating the product with new data: <a onclick="switchMenu(\''.$product_details->product_sku.'_update_product\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_update_product" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		}
		else if ($query_type == "add") {
			// If the user is not using the product publish field, we set it to yes
			if ($this->no_product_publish) {
				$qfields .= "product_publish";
				$qdata .= "'Y'";
			}
			// Put the whole SQL statement together
			$q  = "INSERT INTO #__{vm}_product (cdate,mdate,vendor_id,";
			$q .= $qfields.") ";
			$q .= "VALUES ('".$timestamp."','".$timestamp."','".$product_details->vendor_id."',";
			$q .= $qdata.") ";
			$q = str_replace( ", )", ")", $q );
			if ($this->debug) $this->csv_debug['message'] .= 'Adding product: <a onclick="switchMenu(\''.$product_details->product_sku.'_adding_product\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_adding_product" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
		}
		if ($dbu->query($q)) {
			if ($query_type == "add") $product_details->product_id = $dbu->last_insert_id();
			return true;
		}
		else return false;
	}
	
	/**
	  * Creates either an update or insert SQL query for a product price.
	  *
	  * @name price_query
	  * @author rolandd
	  * @param int $query_type
	  * @returns String update or insert query for a product
	  */
	function PriceQuery($query_type) {
		global $data, $timestamp, $product_details;
		
		$dbpq = new ps_DB;
		$q = "";
		// Check if the product price is to be updated
		// Check if the price already exists if we are updating
		if ($query_type == "update") {
			$q = "SELECT COUNT(product_price_id) AS total FROM #__{vm}_product_price ";
			$q .= "WHERE product_id='".$product_details->product_id."'";
			$dbpq->query($q);
			if ($dbpq->f("total") == 0) $query_type = "add";
		}
		
		if (strlen($product_details->product_price) == 0) $query_type = "delete";
		
		// Get the default shopper group ID
		$this->GetDefaultShopperGroupID($product_details->vendor_id);
		switch ($query_type) {
			case "add":
				// Add  product price for default shopper group
				$q = "INSERT INTO #__{vm}_product_price ";
				$q .= "(product_price,product_currency,product_id,shopper_group_id,mdate) ";
				$q .= "VALUES ('";
				$q .= $product_details->product_price."', '";
				$q .= $product_details->product_currency."', '";
				$q .= $product_details->product_id."', '";
				$q .= $GLOBALS[$product_details->vendor_id]["default_shopper_group"] . "', '";
				$q .= $timestamp . "') ";
				if ($this->debug) $this->csv_debug['message'] .= 'Adding price query: <a onclick="switchMenu(\''.$product_details->product_sku.'_add_price\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_price" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				break;
				
			case "update":
				// Update product price for default shopper group
				$q = "UPDATE #__{vm}_product_price SET ";
				$q .= "product_price='" . $product_details->product_price."', ";
				$q .= "product_currency='" . $product_details->product_currency."', ";
				$q .= "shopper_group_id='" . $GLOBALS[$product_details->vendor_id]["default_shopper_group"] . "', ";
				$q .= "mdate='" . $timestamp . "' ";
				$q .= "WHERE product_id='".$product_details->product_id."'";
				if ($this->debug) $this->csv_debug['message'] .= 'Updating price: <a onclick="switchMenu(\''.$product_details->product_sku.'_update_price\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_update_price" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				break;
			case "delete":
				// Delete the product price for default shopper group
				$q = "DELETE FROM #__{vm}_product_price ";
				$q .= "WHERE product_id='".$product_details->product_id."'";
				if ($this->debug) $this->csv_debug['message'] .= 'Deleting price: <a onclick="switchMenu(\''.$product_details->product_sku.'_delete_price\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_delete_price" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				break;
		}
		if ($dbpq->query($q)) return true;
		else return false;
	}
	
	/*************************************************
	** Manufacturer Check ****************************
	*************************************************/
	function process_manufacturer($product_id) {
		global $data, $manufacturers, $database;
		
		
		require_once( CLASSPATH."ps_manufacturer.php" );
		$ps_manufacturer =& new ps_manufacturer();
		
		$dbcat = new ps_DB;
		$dbmu = new ps_DB;
		
		// The manufacturer name takes precedence over the ID
		// See if the user wants to update the manufacturer
		if (isset($this->required_fields["manufacturer_id"]) || isset($this->required_fields["manufacturer_name"])) {
		
			$product_relation = false;
			$mf_name_set = false;
			$mf_id_set = false;
			// Check for default values and if both are set or only one
			if (isset($this->required_fields["manufacturer_name"])) {
				if(empty($data[$this->csv_fields["manufacturer_name"]["ordering"]-1])) $data[$this->csv_fields["manufacturer_name"]["ordering"]-1] = $this->csv_fields["manufacturer_name"]["default_value"];
				if (isset($data[$this->csv_fields["manufacturer_name"]["ordering"]-1]) && strlen($data[$this->csv_fields["manufacturer_name"]["ordering"]-1]) > 0) $mf_name_set = true;
			}
			if (isset($this->required_fields["manufacturer_id"])) {
				if(empty($data[$this->csv_fields["manufacturer_id"]["ordering"]-1])) $data[$this->csv_fields["manufacturer_id"]["ordering"]-1] = $this->csv_fields["manufacturer_id"]["default_value"];
				if (isset($data[$this->csv_fields["manufacturer_id"]["ordering"]-1]) && strlen($data[$this->csv_fields["manufacturer_id"]["ordering"]-1]) > 0) $mf_id_set = true;
			}
			
			$db_mf_name_id = new ps_DB;
			$db_mf_name_id_count = 0;
			// Check if the manufacturer name exists, if not used, check the manufacturer ID
			if ($mf_name_set) {
				// Check if the manufacturer exist searching by name since it has preference
				$q_mf_name = "SELECT mf_name, manufacturer_id FROM #__{vm}_manufacturer WHERE mf_name='".$data[$this->csv_fields["manufacturer_name"]["ordering"]-1]."'";
				$db_mf_name_id->query($q_mf_name);
				$db_mf_name_id_count = $db_mf_name_id->num_rows();
			}
			if ($db_mf_name_id_count == 0 && $mf_id_set) { 
				// Check if the manufacturer exist searching by id
				$q_mf_id = "SELECT mf_name, manufacturer_id FROM #__{vm}_manufacturer WHERE manufacturer_id='".$data[$this->csv_fields["manufacturer_id"]["ordering"]-1]."'";
				$db_mf_name_id->query($q_mf_id);
				$db_mf_name_id_count = $db_mf_name_id->num_rows();
			}
			$current_mf_id = $db_mf_name_id->f("manufacturer_id");
			// Check if name or ID has been found
			if ($mf_name_set || $mf_id_set) {
				// The CSV manufacturer name is not the same as the DB manufacturer name, update it
				if ($mf_name_set && $db_mf_name_id->f("mf_name") != $data[$this->csv_fields["manufacturer_name"]["ordering"]-1] && $db_mf_name_id_count > 0) {
					$q = "UPDATE #__{vm}_manufacturer SET mf_name = '".$data[$this->csv_fields["manufacturer_name"]["ordering"]-1]."' ";
					if ($mf_id_set) $q .= "WHERE manufacturer_id = '".$data[$this->csv_fields["manufacturer_id"]["ordering"]-1]."'";
					else $q .= "WHERE manufacturer_id = '".$db_mf_name_id->f("manufacturer_id")."'";
					$dbmu->query($q);
				}
				// The CSV manufacturer ID is not the same as the DB manufacturer ID, update it
				elseif ($mf_id_set && $db_mf_name_id->f("manufacturer_id") != $data[$this->csv_fields["manufacturer_id"]["ordering"]-1] && $db_mf_name_id_count > 0) {
					$q = "UPDATE #__{vm}_manufacturer SET manufacturer_id = '".$data[$this->csv_fields["manufacturer_id"]["ordering"]-1]."'";
					$q .= "WHERE manufacturer_id = '".$data[$this->csv_fields["manufacturer_id"]["ordering"]-1]."'";
					$dbmu->query($q);
				}
				// No name or ID to update, create manufacturer
				elseif ($db_mf_name_id_count == 0) {
					if ($mf_id_set)  $d['mf_id'] = $data[$this->csv_fields["manufacturer_id"]["ordering"]-1];
					if ($mf_name_set) $d['mf_name'] = $data[$this->csv_fields["manufacturer_name"]["ordering"]-1];
					else $d['mf_name'] = uniqid( "Generic Manufacturer_" );
					$d['mf_category_id'] = 1;
					$d['mf_desc'] = $d['mf_email'] = $d['mf_url'] = "";
					$ps_manufacturer->add($d);
					// Remove mf_id to prevent the id from being inserted again
					unset($d['mf_id']);
					$current_mf_id = $database->insertid();
				}
				
				// Check if a product <--> manufacturer link exists
				$product_relation = false;
				$q = "SELECT COUNT(product_id) AS mf_total FROM #__{vm}_product_mf_xref WHERE product_id = '".$product_id."'";
				$dbcat->query($q);
				
				// The product already has a product <--> manufacturer link, only update it
				// Each product should have only 1 manufacturer id
				if ($dbcat->f("mf_total") == 1) {
					$product_relation = true;
					// Update the manufacturer ID if it is set
					$q = "UPDATE #__{vm}_product_mf_xref SET manufacturer_id = '";
					if ($mf_id_set) $q .= $data[$this->csv_fields["manufacturer_id"]["ordering"]-1]."' ";
					elseif ($mf_name_set) {
						// Manufacturer ID is empty use the ID from the newly created manufacturer
						$q .= $db_mf_name_id->f("manufacturer_id")."' ";
					}
					else {
						// Manufacturer ID is empty and there is no default value, use the first manufacturer
						$mf_id_q = "SELECT MIN(manufacturer_id) as manufacturer_id FROM #__{vm}_manufacturer";
						$dbmid = new ps_DB;
						$dbmid->query($mf_id_q);
						$q .= $dbmid->f("manufacturer_id")."' ";
					}
					$q .= "WHERE product_id = '".$product_id."'";
					$dbmu->query($q);
				}
				// There is no product <--> manufacturer link, create it
				else $product_relation = false;
				
				
				if (!$product_relation) {
					// Create a product <-> manufacturer relationship
					$q = "INSERT INTO #__{vm}_product_mf_xref VALUES (";
					$q .= "'".$product_id."', '";
					if ($mf_id_set) $q .= $data[$this->csv_fields["manufacturer_id"]["ordering"]-1];
					else $q .= $current_mf_id;
					$q .= "')";
					$dbcat->query($q);
				}
			}
			// No name or ID, do not do anything, creating a generic
			// manufacturer leads to creating endless manufacturers on
			// subsequent imports
		}
	}

	/**************************************************************************
	** name: validate_add()
	** created by:
	** description:
	** parameters:
	** returns:
	***************************************************************************/
	function validate_add( &$d ) {

		$db = new ps_DB;
		foreach ($d["field"] as $field) {
			if ($field["_ordering"] == 0) {
				$d["error"] = "The order position cannot be 0";
				return false;
			}
			if (!$field["_name"]) {
				$d["error"] = "ERROR:  You must enter a name for the Field.";
				return false;
			}
			$q = "SELECT count(*) as rowcnt from #__{vm}_csv where";
			$q .= " field_name='" .  $field["_name"] . "'";
			$db->setQuery($q);
			$db->query();
			$db->next_record();
			if ($db->f("rowcnt") > 0) {
				$d["error"] = "The given field name already exists.";
				return false;
			}
		}
		return true;
	}

	/**************************************************************************
	** name: validate_update
	** created by:
	** description:
	** parameters:
	** returns:
	***************************************************************************/
	function validate_update( &$d ) {
		global $db;
		$i = 0;
		foreach( $d["field"] as $field ) {
			if (!$field["_name"]) {
				$d["error"] = "ERROR:  You must enter a name for the Field.";
				return False;
			}
			if( in_array( $field["_name"], $this->reserved_words ))
			$i++;
			$q = "SELECT count(*) as rowcnt from #__{vm}_csv where";
			$q .= " field_name='" .  $field["_name"] . "' AND field_id <> '".$field["_id"]."'";
			$db->query($q);
			$db->next_record();
			if ($db->f("rowcnt") > 0) {
				$d["error"] = "The given field name already exists: ".$field["_name"];
				return False;
			}
		}
		if( $i < sizeof($this->reserved_words)) {
			$d["error"] = sizeof($this->reserved_words) - $i . " required Field(s) is/are missing (Required Fields: ".implode(", ", $this->reserved_words).")";
			return false;
		}
		return true;
	}

	/**************************************************************************
	** name: validate_delete()
	** created by:
	** description:
	** parameters:
	** returns:
	***************************************************************************/
	function validate_delete( &$d ) {

		if (!$d["field_id"]) {
			$d["error"] = "ERROR:  Please select a Field to delete.";
			return False;
		}
		else {
			return True;
		}
	}

	/**************************************************************************
	* name: add()
	* created by: soeren
	* description: creates a new CSV Field Entry
	* parameters:
	* returns:
	**************************************************************************/
	function add(&$d) {

		global $db;
		if (!$this->validate_add($d)) {
			return false;
		}
		
		foreach( $d['field'] as $field ) {
			$q = "INSERT INTO #__{vm}_csv (field_name, field_default_value, field_ordering, field_required)";
			$q .= " VALUES ('";
			$q .= $field["_name"] . "','";
			$q .= $field["_default_value"] . "','";
			$q .= $field["_ordering"] . "','";
			$q .= $field["_required"] . "')";
			$db->query($q);
		}
		return True;

	}

	/**************************************************************************
	* name: update()
	* created by: pablo
	* description: updates country information
	* parameters:
	* returns:
	**************************************************************************/
	function update(&$d) {
		$db = new ps_DB;
		$timestamp = time();
		if (!$this->validate_update($d)) {
			return False;
		}
		
		// Empty the CSV database so we are sure there are no unsupported fields
		$q = "TRUNCATE TABLE #__{vm}_csv";
		$db->query($q);
		
		// Add all fields back into the database
		$this->add($d);
		return True;
	}

	/**************************************************************************
	* name: delete()
	* created by: pablo
	* description: Should delete a country record.
	* parameters:
	* returns:
	**************************************************************************/
	function delete(&$d) {
		$db = new ps_DB;

		if (!$this->validate_delete($d)) {
			$d["error"]=$this->error;
			return False;
		}
		$q = "DELETE from #__{vm}_csv WHERE field_id='" . $d["field_id"] . "'";
		$db->setQuery($q);
		$db->query();
		$db->next_record();
		return True;
	}
	
	/**
	*	Check user options for import
	*
  	*	@param variable to validate
	*	@returns boolean True if variable isset and is not empty or False otherwise
  	**/
  	function ValidateImportChoices(&$d) {
		global $VM_LANG;
		// Collect debug information
		if (isset($d['collect_debug_info']) && $this->validateField($d['collect_debug_info'])) {
			$this->debug = true;
			$this->csv_debug['message'] = '<hr />';
			$this->csv_debug['message'] .= "Version: ".$VM_LANG->_PHPSHOP_CSV_VERSION."<br />";
		}
		else $this->debug = false;
		
		// Check delimiter char
		if (isset($d['csv_delimiter_custom']) &&  $this->validateField($d['csv_delimiter_custom']) ) {
			$this->delim = stripslashes($d['csv_delimiter_custom']);
		}
		elseif (isset($d['csv_delimiter']) &&  $this->validateField($d['csv_delimiter']) ) {
		 	$this->delim = stripslashes($d['csv_delimiter']); 
		}
		if ($this->debug) $this->csv_debug['message'] .= 'Using delimiter: '.$this->delim.'<br />';
		
		// Check enclosure char
  	  	if (isset($d['csv_enclosurechar_custom']) &&  $this->validateField($d['csv_enclosurechar_custom']) ) {
			$this->encl = $d['csv_enclosurechar_custom'];
		}
		elseif (isset($d['csv_enclosurechar']) &&  $this->validateField($d['csv_enclosurechar']) ) {
		 	$this->encl = str_replace("\\","", $d["csv_enclosurechar"]); 
		}
		else {
			$this->encl = false;
		}
		if ($this->debug) $this->csv_debug['message'] .= 'Using enclosure: '.$this->encl.'<br>';
		
		// Skip first line
		if (isset($d['skip_first_line']) &&  $this->validateField($d['skip_first_line']) ) {
			$this->skip_first_line = $d['skip_first_line'];
			if ($this->debug) $this->csv_debug['message'] .= 'Skipping the first line<br />';
		}
		else {
			$this->skip_first_line = false;
			if ($this->debug) $this->csv_debug['message'] .= 'Not skipping the first line<br />';
		}
		
		// Skip default value
		if (isset($d['skip_default_value']) &&  $this->validateField($d['skip_default_value']) ) {
			$this->skip_default_value = $d['skip_default_value'];
			if ($this->debug) $this->csv_debug['message'] .= 'Skip default value<br />';
		}
		else {
			$this->skip_default_value = false;
			if ($this->debug) $this->csv_debug['message'] .= 'Not skipping default value<br />';
		}
		
		// Overwrite existing data
		if (isset($d['overwrite_existing_data']) &&  $this->validateField($d['overwrite_existing_data']) ) {
			$this->overwrite_existing_data = $d['overwrite_existing_data'];
			if ($this->debug) $this->csv_debug['message'] .= 'Overwriting data<br />';
		}
		else {
			$this->overwrite_existing_data = false;
			if ($this->debug) $this->csv_debug['message'] .= 'Do not overwrite data<br />';
		}
		
		// Use column headers as configuration
		if (isset($d['import_config_csv_file']) &&  $this->validateField($d['import_config_csv_file'])) {
			$this->import_config_csv_file = $d['import_config_csv_file'];
			if ($this->debug) $this->csv_debug['message'] .= 'Use column headers for configuration<br />';
		}
		else {
			$this->import_config_csv_file = false;
			if ($this->debug) $this->csv_debug['message'] .= 'Do not use column headers for configuration<br />';
		}
		
		// Show preview
		if (isset($d['show_preview']) &&  $this->validateField($d['show_preview'])) {
			$this->show_preview = $d['show_preview'];
			if ($this->debug) $this->csv_debug['message'] .= 'Using preview<br />';
		}
		else {
			$this->show_preview = false;
			if (isset($d['was_preview'])) {
				if ($this->debug) $this->csv_debug['message'] .= 'Preview used<br />';
			}
			else if ($this->debug) $this->csv_debug['message'] .= 'Not using preview<br />';
		}
		
		// Type of upload
		if ($this->validateField($d['upload_type'])) {
			$this->process = $d['upload_type'];
			switch ($d['upload_type']) {
				case "NormalUpload" :
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a normal upload<br />';
					break;
				case "PriceListUploadOnly" :
					$this->price_list_only = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a price list only upload<br />';
					break;
				case "MultiplePricesUpload" :
					$this->multiple_prices_upload = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a multiple prices upload<br />';
					break;
				case "ProductTypeUpload" :
					$this->product_type_upload = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a product type upload<br />';
					break;
				case "ProductTypeParametersUpload" :
					$this->product_type_parameters_upload = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a product type parameters upload<br />';
					break;
				case "ProductTypeXrefUpload" :
					$this->product_type_xref_upload = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Doing a product type cross reference upload<br />';
					break;
				case "EmptyDatabase" :
					$this->empty_database = true;
					if ($this->debug) $this->csv_debug['message'] .= 'Emptying database !!!<br />';
					break;
			}
		}
	}
	
	/**
  	*	@param variable to validate
	*	@returns boolean True if variable isset and is not empty or False otherwise
  	**/
  	function validateField($field) {
		return (isset($field) && !empty($field)) ? true : false;    
	}
	
	/**
	*	Check user options for import
	*
  	*	@param variable to validate
	*	@returns boolean True if variable isset and is not empty or False otherwise
  	**/
  	function CheckCategoryPath() {
		global $product_details;
		
		$dbcat = new ps_DB;
		
		if ($product_details->category_path && !$product_details->child_product) {
			if ($this->debug) $this->csv_debug['message'] .= 'Checking category path<br />';
			if (!$product_details->product_parent_id) {
				// Use csv_category() method to confirm/add category tree for this product
				// Modification: $category_id now is an array
				$category_id = $this->csv_category($product_details->category_path);
				
				// Delete old entries
				$q  = "DELETE FROM #__{vm}_product_category_xref WHERE product_id = '".$product_details->product_id."'";
				if ($this->debug) $this->csv_debug['message'] .= 'Delete old category references: <a onclick="switchMenu(\''.$product_details->product_sku.'_delete_old_cat_xref\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_delete_old_cat_xref" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
				$dbcat->query($q);
				
				// Insert new product/category relationships
				foreach( $category_id as $value ) {
					$q  = "INSERT INTO #__{vm}_product_category_xref (category_id, product_id ) VALUES (";
					$q .= "'$value', '".$product_details->product_id."')";
					if ($this->debug) $this->csv_debug['message'] .= 'Add new category references: <a onclick="switchMenu(\''.$product_details->product_sku.'_add_new_cat_xref'.$value.'\');" title="Show/hide query">Show/hide query</a><div id="'.$product_details->product_sku.'_add_new_cat_xref'.$value.'" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q).'</div><br />';
					$dbcat->query($q);
				}
			}
		}
	}
	
	/**
	*	Gets the default Shopper Group ID
	*
  	*	@param $ps_vendor_id	Vendor ID
	*	@param $return			If set to true, return the value
	*	@returns numeric value of Shopper group if return set true otherwise add it to the global array
  	**/
	function GetDefaultShopperGroupID($ps_vendor_id, $return = false) {
		$dbsg = new ps_DB;
		// Get default shopper group ID
		if( empty( $GLOBALS[$ps_vendor_id]["default_shopper_group"] )) {
			$q = "SELECT shopper_group_id FROM #__{vm}_shopper_group ";
			$q .= "WHERE `default`='1' and vendor_id='".$ps_vendor_id."'";
			$dbsg->query($q);
			$dbsg->next_record();
			if (!$return) $GLOBALS[$ps_vendor_id]["default_shopper_group"] = $dbsg->f("shopper_group_id");
			else return $dbsg->f("shopper_group_id");
		}
	}
	/**
	 * Strips all line endings from a string
	 *
	 * @param unknown_type $str
	 * @return unknown
	 */
	function cleanString( $str ) {
		return str_replace(	"\r", '',
				str_replace( "\n", '', trim($str) ));
	}
	/**
	 * Strips all line endings from a string
	 *
	 * @param unknown_type $str
	 * @return unknown
	 */
	function getEscapedAndEnclosed( $str ) {
		switch( $this->encl ) {
			case '"':
				return $this->encl . str_replace('"', '""', $str ) . $this->encl;
			default:
				return $this->encl . str_replace($this->encl, '\\' .$this->encl, $str ) . $this->encl;
		}
	}
}

class product_details {
	var $classname = "product_details";
	var $product_id = false;
	var $vendor_id = false;
	var $product_parent_id  = false;
	var $product_sku  = false;
	var $product_s_desc  = false;
	var $product_desc  = false;
	var $product_thumb_image  = false;
	var $product_full_image  = false;
	var $product_publish  = false;
	var $product_weight  = false;
	var $product_weight_uom  = false;
	var $product_length  = false;
	var $product_width  = false;
	var $product_height  = false;
	var $product_lwh_uom  = false;
	var $product_url  = false;
	var $product_in_stock  = false;
	var $product_available_date  = false;
	var $product_availability  = false;
	var $product_special  = false;
	var $product_discount = 0;
	var $product_discount_percentage = "0";
	var $product_discount_date_start = 0;
	var $product_discount_date_end = 0;
	var $product_discount_id = false;
	var $product_name  = false;
	var $product_sales  = false;
	var $attribute  = false;
	var $attributes  = false;
	var $custom_attribute  = false;
	var $product_tax_id  = false;
	var $product_unit  = false;
	var $product_delete = false;
	var $attribute_values = false;
	var $manufacturer_id = false;
	var $manufacturer_name = false;
	var $product_price = false;
	var $product_parent_sku = 0;
	var $category_path = false;
	var $child_product = false;
	var $product_packaging = 0;
	var $product_box = 0;
	var $product_currency = false;
	var $price_quantity_start = false;
	var $price_quantity_end = false;
	var $price_delete = false;
	
	function product_details() {
		global $ps_csv;
		
		$this->get_product_id();
		$this->get_vendor_id();
		$this->get_product_currency();
		
		foreach ($ps_csv->supported_fields as $id => $name) {
			$function_name = "get_".$name;
			
			if (is_callable(array($this, $function_name))) {
				call_user_func(array(&$this, $function_name));
			}
			// else echo "Unsupported field: ".$name."<br />";
		}
	}
	
	function get_vendor_id() {
		$this->vendor_id = $_SESSION['ps_vendor_id'];
		if ($this->vendor_id < 1 ) $this->vendor_id = 1;
		$GLOBALS[$this->vendor_id]["default_shopper_group"] = "";
	}
	
	function get_product_currency() {
		$this->ValidateCSVInput("product_currency");
		
		// If the user does not use product currency we take the one from the currenct vendor
		if (!$this->product_currency) {
			$dbc = new ps_DB;
			$q = "SELECT vendor_currency FROM #__{vm}_vendor WHERE vendor_id='".$this->vendor_id."' ";
			$dbc->query($q);
			$dbc->next_record();
			$this->product_currency = $dbc->f("vendor_currency");
			unset($dbc);
		}
	}
	
	function get_product_sku() {
		$this->ValidateCSVInput("product_sku");
	}
	
	function get_product_id() {
		global $data, $ps_csv;
		$db = new ps_DB;
		if (isset($ps_csv->csv_fields["product_sku"])) {
			$q = "SELECT product_id FROM #__{vm}_product WHERE product_sku = '".$data[$ps_csv->csv_fields["product_sku"]["ordering"]-1]."'";
			$db->query($q);
			$db->next_record();
			if (isset($db->record[0])) $this->product_id = $db->f("product_id");
			else $this->product_id = false;
		}
		else $this->product_id = false;
	}
	
	function get_product_s_desc() {
		$this->ValidateCSVInput("product_s_desc");
	}
	
	function get_product_desc() {
		$this->ValidateCSVInput("product_desc");
	}
	
	function get_product_thumb_image() {
		$this->ValidateCSVInput("product_thumb_image");
	}
	
	function get_product_full_image() {
		$this->ValidateCSVInput("product_full_image");
	}
	
	function get_product_publish() {
		global $ps_csv;
		
		$this->ValidateCSVInput("product_publish");
		if (!$this->product_publish) {
			if ($ps_csv->no_product_publish) {
				$this->product_publish = "Y";
			}
		}
	}
	
	function get_product_weight() {
		$this->ValidateCSVInput("product_weight");
	}
	
	function get_product_weight_uom() {
		$this->ValidateCSVInput("product_weight_uom");
	}
	
	function get_product_length() {
		$this->ValidateCSVInput("product_length");
	}
	
	function get_product_width() {
		$this->ValidateCSVInput("product_width");
	}
	
	function get_product_height() {
		$this->ValidateCSVInput("product_height");
	}
	
	function get_product_lwh_uom() {
		$this->ValidateCSVInput("product_lwh_uom");
	}
	
	function get_product_url() {
		$this->ValidateCSVInput("product_url");
	}
	
	function get_product_in_stock() {
		$this->ValidateCSVInput("product_in_stock");
	}
	
	function get_product_available_date() {
		$this->ValidateCSVInput("product_available_date");
		
		if ($this->product_available_date) {
			// Date must be in the format of day/month/year
			$new_date = preg_replace('/-|\./', '/', $this->product_available_date);
			$date_parts = explode('/', $new_date);
			if ((count($date_parts) == 3) && ($date_parts[0] > 0 && $date_parts[0] < 32 && $date_parts[1] > 0 && $date_parts[1] < 13 && (strlen($date_parts[2]) == 4))) {
				$this->product_available_date = mktime(0,0,0,$date_parts[1],$date_parts[0],$date_parts[2]);
			}
		}
	}
	
	function get_product_availability() {
		$this->ValidateCSVInput("product_availability");
	}
	
	function get_product_special() {
		$this->ValidateCSVInput("product_special");
	}
	
	function get_product_discount() {
		global $data, $ps_csv;
		
		$this->ValidateCSVInput("product_discount");
		
		// Check first to see if we are dealing with a percentage
		$this->get_product_discount_percentage();
		
		if ($this->product_discount) {
			if ($this->product_discount_percentage) {
				$this->product_discount = substr(str_replace(",",".",$this->product_discount), 0, -1);
			}
			else $this->product_discount = str_replace(",",".",$this->product_discount);
		}
	}
	
	function get_product_discount_percentage() {
		if ($this->product_discount) {
			if (substr($this->product_discount,-1,1) == "%") {
				$this->product_discount_percentage = "1";
			}
		}
	}
	
	function get_product_discount_date_start() {
		$this->ValidateCSVInput("product_discount_date_start");
		
		if (!$this->product_discount_date_start) {
			// Date must be in the format of day/month/year
			$new_date = "";
			$new_date = str_replace('-', '/', $this->product_discount_date_start);
			$date_parts = explode('/', $new_date);
			if ((count($date_parts) == 3) && ($date_parts[0] > 0 && $date_parts[0] < 32 && $date_parts[1] > 0 && $date_parts[1] < 13 && (strlen($date_parts[2]) == 4))) {
				$this->product_discount_date_start = date('Y-m-d',mktime(0,0,0,$date_parts[1],$date_parts[0],$date_parts[2]));
			}
		}
	}
	
	function get_product_discount_date_end() {
		$this->ValidateCSVInput("product_discount_date_end");
		
		if (!$this->product_discount_date_end) {
			// Date must be in the format of day/month/year
			$new_date = "";
			$new_date = str_replace('-', '/', $this->product_discount_date_end);
			$date_parts = explode('/', $new_date);
			if ((count($date_parts) == 3) && ($date_parts[0] > 0 && $date_parts[0] < 32 && $date_parts[1] > 0 && $date_parts[1] < 13 && (strlen($date_parts[2]) == 4))) {
				$this->product_discount_date_end = date('Y-m-d',mktime(0,0,0,$date_parts[1],$date_parts[0],$date_parts[2]));
			}
		}
	}
	
	function get_product_name() {
		$this->ValidateCSVInput("product_name");
	}
	
	function get_product_sales() {
		$this->ValidateCSVInput("product_sales");
	}
	
	function get_attribute() {
		$this->ValidateCSVInput("attribute");
	}
	
	function get_attributes() {
		$this->ValidateCSVInput("attributes");
	}
	
	function get_custom_attribute() {
		$this->ValidateCSVInput("custom_attribute");
	}
	
	function get_product_tax_id() {
		$this->ValidateCSVInput("product_tax_id");
	}
	
	function get_product_unit() {
		$this->ValidateCSVInput("product_unit");
	}
	
	function get_product_box() {
		$this->ValidateCSVInput("product_box");
	}
	
	function get_product_packaging() {
		$this->ValidateCSVInput("product_packaging");
		
		if (!$this->product_packaging) $this->product_packaging = (($this->product_box<<16) | ($this->product_packaging & 0xFFFF)); 
	}
	
	function get_product_delete() {
		$this->ValidateCSVInput("product_delete");
	}
	
	function get_attribute_values() {
		$this->ValidateCSVInput("attribute_values");
	}
	
	function get_manufacturer_id() {
		$this->ValidateCSVInput("manufacturer_id");
	}                           
	
	function get_manufacturer_name() {
		$this->ValidateCSVInput("manufacturer_name");
	}
	
	function get_product_price() {
		$this->ValidateCSVInput("product_price");
		
		if ($this->product_price) $this->product_price = str_replace(",",".",$this->product_price);
	}
	
	function get_product_parent_sku() {
		$this->ValidateCSVInput("product_parent_sku");
		
		if (!$this->product_parent_sku) {
			if (!$this->child_product) $this->product_parent_id = 0;
			else {
				$db_product_parent_id = new ps_DB;
				// Get the parent id first
				// This assumes that the Parent Product already has been added
				$db_product_parent_id->query("SELECT product_id FROM #__{vm}_product WHERE product_sku = '".$this->product_sku."'");
				$this->product_parent_id = $db_product_parent_id->f("product_id");
			}
		}
	}
	
	function get_category_path() {
		$this->ValidateCSVInput("category_path");
		
		if (!$this->category_path) {
			// Check if we are dealing with a child product
			if ($this->product_parent_sku != $this->product_sku) $this->child_product = true;
			else $this->child_product = false;
		}
	}
	
	function get_price_quantity_start() {
		$this->ValidateCSVInput("price_quantity_start");
	}
	
	function get_price_quantity_end() {
		$this->ValidateCSVInput("price_quantity_end");
	}
	
	function get_price_delete() {
		$this->ValidateCSVInput("price_delete");
	}
	
	/**
	 * Checks the field for existing value, if not set the default value if allowed
	 */
	function ValidateCSVInput($fieldname) {
		global $data, $ps_csv;
		
		if (isset($ps_csv->csv_fields[$fieldname])) {
			if (strlen($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1]) > 0) {
				$this->$fieldname = trim($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1]);
			}
			else if (!$ps_csv->skip_default_value) {
				$this->$fieldname = $ps_csv->csv_fields[$fieldname]["default_value"];
			}
		}
	}
	
	/**
	 * Stores the discount for a product
	 * @return unknown
	 */
	function ProcessDiscount() {
		global $data, $database, $d, $ps_csv;
		
		if (isset($ps_csv->required_fields["product_discount_id"])) {
			$this->product_discount_id = $data[$ps_csv->csv_fields["product_discount_id"]["ordering"]-1];
		}
		else {
			$ddc = new ps_DB;
			
			// Values of the discount to add it to the database
			$d['amount'] = $this->product_discount;
			$d['is_percent'] = $this->product_discount_percentage;
			$d['start_date'] = $this->product_discount_date_start;
			$d['end_date'] = $this->product_discount_date_end;
			
			// Check if the amount exists in the database
			$q_discount = "SELECT COUNT(discount_id) AS total_discount_ids FROM #__{vm}_product_discount WHERE amount = '".$this->product_discount."' ";
			$q_discount .= "AND is_percent = '".$this->product_discount_percentage."' ";
			$q_discount .= "AND start_date = '".$this->product_discount_date_start."' ";
			$q_discount .= "AND end_date = '".$this->product_discount_date_end."'";
			if ($ps_csv->debug) $ps_csv->csv_debug['message'] .= 'Check if a discount exists: <a onclick="switchMenu(\''.$this->product_sku.'_product_discount\');" title="Show/hide query">Show/hide query</a><div id="'.$this->product_sku.'_product_discount" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_discount).'</div><br />';
			$ddc->query($q_discount);
			
			if ($ddc->f('total_discount_ids') > 0) {
				$q_discount = "SELECT MIN(discount_id) AS discount_id FROM #__{vm}_product_discount WHERE amount = '".$this->product_discount."' ";
				$q_discount .= "AND is_percent = '".$this->product_discount_percentage."' ";
				$q_discount .= "AND start_date = '".$this->product_discount_date_start."' ";
				$q_discount .= "AND end_date = '".$this->product_discount_date_end."'";
				if ($ps_csv->debug) $ps_csv->csv_debug['message'] .= 'Discount exists, return discount id: <a onclick="switchMenu(\''.$this->product_sku.'_discount_id\');" title="Show/hide query">Show/hide query</a><div id="'.$this->product_sku.'_discount_id" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_discount).'</div><br />';
				$ddc->query($q_discount);
				$this->product_discount_id = $ddc->f('discount_id');
			}
			else {
				require_once( CLASSPATH. 'ps_product_discount.php' );
				$ps_product_discount = new ps_product_discount;
				$ps_product_discount->add( $d );
				$d['product_discount_id'] = $database->insertid();
				if ($ps_csv->debug) $ps_csv->csv_debug['message'] .= 'Discount does not exist, create discount<br />';
				$this->product_discount_id = $d['product_discount_id'];
			}
		}
	}
}

class product_type {
	var $classname = "product_type";
	var $product_type_id = false;
	var $product_type_name = "";
	var $product_type_description = false;
	var $product_type_publish = false;
	var $product_type_browsepage = false;
	var $product_type_flypage = false;
	var $product_type_list_order = false;
	
	function product_type() {
		// Handle all fields in this order:
		$this->get_product_type_name();
		$this->get_product_type_id();
		$this->get_product_type_list_order();
		$this->get_product_type_description();
		$this->get_product_type_publish();
		$this->get_product_type_browsepage();
		$this->get_product_type_flypage();
	}
	
	/**
	 * Checks the field for existing value, if not set the default value if allowed
	 */
	function ValidateCSVInput($fieldname) {
		global $data, $ps_csv;
		
		if (isset($ps_csv->csv_fields[$fieldname])) {
			if (!empty($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1])) {
				$this->$fieldname = trim($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1]);
			}
			else if (!$ps_csv->skip_default_value) {
				$this->$fieldname = $ps_csv->csv_fields[$fieldname]["default_value"];
			}
		}
	}
	
	function get_product_type_id() {
		$db = new ps_DB;

		$q = "SELECT product_type_id FROM #__{vm}_product_type ";
		$q .= "WHERE product_type_name='".$this->product_type_name."' LIMIT 1";
		$db->query($q);
		$db->next_record();
		
		$this->product_type_id = $db->f("product_type_id");
	}
	
	function get_product_type_name() {
		$this->ValidateCSVInput("product_type_name");
	}
	
	function get_product_type_description() {
		$this->ValidateCSVInput("product_type_description");
	}
	
	function get_product_type_publish() {
		$this->ValidateCSVInput("product_type_publish");
		if (empty($this->product_type_publish)) $this->product_type_publish = "Y";
	}
	
	function get_product_type_browsepage() {
		$this->ValidateCSVInput("product_type_browsepage");
	}
	
	function get_product_type_flypage() {
		$this->ValidateCSVInput("product_type_flypage");
	}
	
	function get_product_type_list_order() {
		$db = new ps_DB;

		$q = "SELECT product_type_list_order FROM #__{vm}_product_type ";
		$q .= "WHERE product_type_id=".$this->product_type_id;
		$db->query($q);
		$this->product_type_list_order = $db->f("product_type_list_order");
	}
}
class product_type_parameters {
	
	var $classname = "product_type_parameters";
	var $product_type_id = false;
	var $product_type_name = false;
	var $product_type_parameter_name = "";
	var $product_type_parameter_label = false;
	var $product_type_parameter_description = false;
	var $product_type_parameter_list_order = false;
	var $product_type_parameter_type = false;
	var $product_type_parameter_old_type = false;
	var $product_type_parameter_values = false;
	var $product_type_parameter_multiselect = false;
	var $product_type_parameter_default = false;
	var $product_type_parameter_unit = false;
	
	function product_type_parameters() {
		global $ps_csv;
		
		// Handle all fields in this order:
		$this->get_product_type_name();
		$this->get_product_type_id();
		$this->get_product_type_parameter_name();
		$this->get_product_type_parameter_list_order();
		$this->get_product_type_parameter_label();
		$this->get_product_type_parameter_description();
		$this->get_product_type_parameter_type();
		$this->get_product_type_parameter_old_type();
		$this->get_product_type_parameter_values();
		$this->get_product_type_parameter_multiselect();
		$this->get_product_type_parameter_default();
		$this->get_product_type_parameter_unit();
	}
	
	/**
	 * Checks the field for existing value, if not set the default value if allowed
	 */
	function ValidateCSVInput($fieldname) {
		global $data, $ps_csv;
		
		if (isset($ps_csv->csv_fields[$fieldname])) {
			if (!empty($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1])) {
				$this->$fieldname = trim($data[$ps_csv->csv_fields[$fieldname]["ordering"]-1]);
			}
			else if (!$ps_csv->skip_default_value) {
				$this->$fieldname = $ps_csv->csv_fields[$fieldname]["default_value"];
			}
		}
	}
	
	function get_product_type_id() {
		$db = new ps_DB;
		
		$q = "SELECT product_type_id FROM #__{vm}_product_type ";
		$q .= "WHERE product_type_name='".$this->product_type_name."' ";
		$db->query($q);
		$this->product_type_id = $db->f("product_type_id");
	}
	
	function get_product_type_name() {
		$this->ValidateCSVInput("product_type_name");
	}
	
	function get_product_type_parameter_name() {
		$this->ValidateCSVInput("product_type_parameter_name");
	}
	
	function get_product_type_parameter_label() {
		$this->ValidateCSVInput("product_type_parameter_label");
	}
	
	function get_product_type_parameter_description() {
		$this->ValidateCSVInput("product_type_parameter_description");
	}
	
	function get_product_type_parameter_type() {
		$this->ValidateCSVInput("product_type_parameter_type");
	}
	
	function get_product_type_parameter_old_type() {
		$db = new ps_DB();
		if ($this->product_type_parameter_name) {
			$q = "SELECT parameter_type FROM #__{vm}_product_type_parameter ";
			$q .= "WHERE parameter_name='".$this->product_type_parameter_name."' ";
			$q .= "AND product_type_id = ".$this->product_type_id;
			$db->query($q);
			$this->product_type_parameter_old_type = $db->f("parameter_type");
		}
	}
	
	function get_product_type_parameter_values() {
		$this->ValidateCSVInput("product_type_parameter_values");
	}
	
	function get_product_type_parameter_multiselect() {
		$this->ValidateCSVInput("product_type_parameter_multiselect");
	}
	
	function get_product_type_parameter_default() {
		$this->ValidateCSVInput("product_type_parameter_default");
	}
	
	function get_product_type_parameter_unit() {
		$this->ValidateCSVInput("product_type_parameter_unit");
	}
	
	function get_product_type_parameter_list_order() {
		$this->ValidateCSVInput("product_type_parameter_list_order");
		
		if ($this->product_type_id) {
			$db = new ps_DB;
			
			$q = "SELECT parameter_list_order FROM #__{vm}_product_type_parameter ";
			$q .= "WHERE product_type_id=".$this->product_type_id." ";
			$q .= "AND parameter_name = '".$this->product_type_parameter_name."'";
			$db->query($q);
			$this->product_type_list_order = $db->f("parameter_list_order");
		}
	}

}
?>
