<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: product.product_category_list.php 739 2007-03-02 00:12:00Z gregdev $
* @package VirtueMart
* @subpackage html
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
mm_showMyFileName( __FILE__ );
global $ps_product_category;

require_once( CLASSPATH . "pageNavigation.class.php" );
require_once( CLASSPATH . "htmlTools.class.php" );

$categories = $ps_product_category->getCategoryTreeArray( false, $keyword );

// Copy the Array into an Array with auto_incrementing Indexes
$key = array_keys($categories);
$size = sizeOf($key);
for ($i=0; $i<$size; $i++) 
	$category_tmp[$i] = &$categories[$key[$i]];
    
$html = "";
/** FIRST STEP
* Order the Category Array and build a Tree of it
**/
$nrows = $num_rows = @count( $category_tmp );
    
$id_list = Array();
$row_list = Array();
$depth_list = Array();
$levelcounter = Array();

$children = array();
$parent_ids = array();
for($k = 0 ; $k < $nrows ; $k++) {
	$parent_ids[$k] = $category_tmp[$k]['category_parent_id'];
}

for($n = 0 ; $n < $nrows ; $n++)
	if($category_tmp[$n]["category_parent_id"] == 0) { 
		array_push($id_list,$category_tmp[$n]["category_child_id"]);
		array_push($row_list,$n);
		array_push($depth_list,0);
	}
$loop_count = 0;
while(count($id_list) < $nrows) {
	if( $loop_count > $nrows )
		break;
	$id_temp = array();
	$row_temp = array();
	$depth_temp = array();
	for($i = 0 ; $i < count($id_list) ; $i++) {
		$id = $id_list[$i];
		$row = $row_list[$i];
		$depth = $depth_list[$i];
		array_push($id_temp,$id);
		array_push($row_temp,$row);
		array_push($depth_temp,$depth);

		$pattern = '/\b'.$id.'\b/';
		$children = preg_grep( $pattern, $parent_ids );

		foreach($children as $key => $value) {
			if( array_search($category_tmp[$key]["category_child_id"],$id_list) == NULL) {
				array_push($id_temp,$category_tmp[$key]["category_child_id"]);
				array_push($row_temp,$key);
				array_push($depth_temp,$depth + 1);
			}
		}
	}
	$id_list = $id_temp;
	$row_list = $row_temp;
	$depth_list = $depth_temp;
	$loop_count++;
}

// Create the Page Navigation
$pageNav = new vmPageNav( $nrows, $limitstart, $limit );

for($n = $pageNav->limitstart ; $n < $nrows ; $n++) {
	@$levelcounter[$category_tmp[$row_list[$n]]["category_parent_id"]]++;
}

// Create the List Object with page navigation
$listObj = new listFactory( $pageNav );

// print out the search field and a list heading
$listObj->writeSearchHeader($VM_LANG->_PHPSHOP_CATEGORY_LIST_LBL, IMAGEURL."ps_image/categories.gif", $modulename, "product_category_list");

// start the list table
$listObj->startTable();

// these are the columns in the table
$columns = Array(  "#" => "width=\"20\"", 
					"<input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(".$pageNav->limit.")\" />" => "width=\"20\"",
					$VM_LANG->_PHPSHOP_CATEGORY_FORM_NAME => 'width="25%"',
					$VM_LANG->_PHPSHOP_CATEGORY_FORM_DESCRIPTION => 'width="30%"',
					$VM_LANG->_PHPSHOP_PRODUCTS_LBL => 'width="10%"',
					$VM_LANG->_PHPSHOP_PRODUCT_LIST_PUBLISH => 'width="5%"',
					$VM_LANG->_PHPSHOP_MODULE_LIST_ORDER => 'width="7%"',
					vmCommonHTML::getSaveOrderButton( min($nrows - $pageNav->limitstart, $pageNav->limit ) ) => 'width="8%"',
					$VM_LANG->_E_REMOVE => "width=\"5%\""
				);
$listObj->writeTableHeader( $columns );

$ibg = 0;
if( $pageNav->limit < $nrows )
	if( $pageNav->limitstart+$pageNav->limit < $nrows ) {
		$nrows = $pageNav->limitstart + $pageNav->limit;
	}

for($n = $pageNav->limitstart ; $n < $nrows ; $n++) {
	$catname = shopMakeHtmlSafe( $category_tmp[$row_list[$n]]["category_name"] );
	
	$listObj->newRow();
	
	// The row number
	$listObj->addCell( $pageNav->rowNumber( $ibg ) );
	
	// The Checkbox
	$listObj->addCell( mosHTML::idBox( $ibg, $category_tmp[$row_list[$n]]["category_child_id"], false, "category_id" ) );
	
	// Which category depth level we are in?
	$repeat = $depth_list[$n]+1;
	$tmp_cell = str_repeat("&nbsp;&nbsp;&nbsp;", $repeat ) 
				. "&#095&#095;|" . $repeat ."|&nbsp;"
				."<a href=\"". $_SERVER['PHP_SELF'] . "?option=com_virtuemart&page=product.product_category_form&category_id=" . $category_tmp[$row_list[$n]]["category_child_id"]. "&category_parent_id=" . $category_tmp[$row_list[$n]]["category_parent_id"]."\">"
				. $catname
				. "</a>";
	$listObj->addCell( $tmp_cell );
	
	$desc = strlen( $category_tmp[$row_list[$n]]["category_description"] ) > 255 ? mm_ToolTip( $category_tmp[$row_list[$n]]["category_description"], $VM_LANG->_PHPSHOP_CATEGORY_FORM_DESCRIPTION ) :$category_tmp[$row_list[$n]]["category_description"];
	$listObj->addCell( "&nbsp;&nbsp;". $desc );
	
	$listObj->addCell( ps_product_category::product_count( $category_tmp[$row_list[$n]]["category_child_id"] )
						."&nbsp;<a href=\"". $_SERVER['PHP_SELF'] . "?page=product.product_list&category_id=" . $category_tmp[$row_list[$n]]["category_child_id"]."&option=com_virtuemart"
						. "\">[ ".$VM_LANG->_PHPSHOP_SHOW." ]</a>"
					);
	// Publish / Unpublish
	$tmp_cell = "<a href=\"". $sess->url( $_SERVER['PHP_SELF']."?page=product.product_category_list&category_id=".$category_tmp[$row_list[$n]]["category_child_id"]."&func=changePublishState" );
	if ($category_tmp[$row_list[$n]]["category_publish"]=='N') {
		$tmp_cell .= "&task=publish\">";
	} 
	else { 
		$tmp_cell .= "&task=unpublish\">";
	}
	$tmp_cell .= vmCommonHTML::getYesNoIcon ( $category_tmp[$row_list[$n]]["category_publish"] );
	$tmp_cell .= "</a>";
	$listObj->addCell( $tmp_cell );
	
	// Order Up and Down Icons
	// This must be a big cheat, because we're working on sorted arrays,
	// not on database information
	// Check for predecessors and brothers and sisters
	$upCondition = $downCondition = false;
	if( !isset( $levels[$depth_list[$n]+1] ))
		$levels[$depth_list[$n]+1] = 1;
	if( $category_tmp[$row_list[$n]]["category_parent_id"] == @$category_tmp[$row_list[$n-1]]["category_parent_id"])
		$upCondition = true;
	if( $category_tmp[$row_list[$n]]["category_parent_id"] == @$category_tmp[$row_list[$n+1]]["category_parent_id"] )
		$downCondition = true;
	if( !$downCondition || !$upCondition ) {
		
		if( $levelcounter[$category_tmp[$row_list[$n]]["category_parent_id"]] > $levels[$depth_list[$n]+1] )
			$downCondition = true;
			if( $levels[$depth_list[$n]+1] > 1 )
				$upCondition = true;
		if( $levelcounter[$category_tmp[$row_list[$n]]["category_parent_id"]] == $levels[$depth_list[$n]+1] ) {
			$upCondition = true;
			$downCondition = false;
		}
		if( $levelcounter[$category_tmp[$row_list[$n]]["category_parent_id"]] < $levels[$depth_list[$n]+1] ) {
			$downCondition = false;
			$upCondition = false;
		}
	}
	$levels[$depth_list[$n]+1]++;
	
	$listObj->addCell( $pageNav->orderUpIcon( $ibg, $upCondition, 'orderup', 'Order Down', $page, 'reorder' )
						. '&nbsp;'
						.$pageNav->orderDownIcon( $ibg, $levelcounter[$category_tmp[$row_list[$n]]["category_parent_id"]], $downCondition, 'orderdown', 'Order Down', $page, 'reorder' )
					);
					
	$listObj->addCell( vmCommonHTML::getOrderingField( $category_tmp[$row_list[$n]]["list_order"] ) );
	
	$listObj->addCell( $ps_html->deleteButton( "category_id", $category_tmp[$row_list[$n]]["category_child_id"], "productCategoryDelete", $keyword, $limitstart ) );
	
	$ibg++;
}

$listObj->writeTable();

$listObj->endTable();

$listObj->writeFooter( $keyword );
?>
