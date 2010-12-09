<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
* 	SQL update script for upgrading 
*	from VirtueMart 1.0.x to VirtueMart 1.0.8
* 
* @version $Id: sql.update.virtuemart-1.0.5.to.virtuemart-1.0.8.php 617 2007-01-04 19:43:08Z soeren_nb $
* @package VirtueMart
* @subpackage core
* @copyright Copyright (C) 2004-2006 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_phpshop/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

// Rename the field 'product_parent_id' to 'product_parent_sku', which is the correct name for it's function
$db->setQuery( "UPDATE #__{vm}_csv` SET `field_name` = 'product_parent_sku',
`field_default_value` = '',
`field_required` = 'N' WHERE `field_name` = 'product_parent_id' LIMIT 1" );
$db->query();

// Add a new field 'product_discount' to allow direct discount insertion
$db->setQuery( "INSERT INTO `#__{vm}_csv` ( `field_id` , `field_name` , `field_default_value` , `field_ordering` , `field_required` )
VALUES ( NULL , 'product_discount', NULL , '26', 'N' )" );
$db->query();


?>