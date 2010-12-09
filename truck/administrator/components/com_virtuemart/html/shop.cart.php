<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: shop.cart.php 617 2007-01-04 19:43:08Z soeren_nb $
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

$manufacturer_id = mosGetParam( $_REQUEST, 'manufacturer_id');

$mainframe->setPageTitle( $VM_LANG->_PHPSHOP_CART_TITLE );
$mainframe->appendPathWay( $VM_LANG->_PHPSHOP_CART_TITLE );

$continue_link = '';
if( !empty( $category_id)) {
    $continue_link = $sess->url( $_SERVER['PHP_SELF'].'?page=shop.browse&amp;category_id='.$category_id );
}
elseif( empty( $category_id) && !empty($product_id)) {
    $db->query( 'SELECT `category_id` FROM `#__{vm}_product_category_xref` WHERE `product_id`='.intval($product_id) );
    $db->next_record();
    $category_id = $db->f('category_id');
    $continue_link = $sess->url( $_SERVER['PHP_SELF'].'?page=shop.browse&amp;category_id='.$category_id );
}
elseif( !empty( $manufacturer_id )) {
    $continue_link = $sess->url( $_SERVER['PHP_SELF'].'?page=shop.browse&amp;manufacturer_id='.$manufacturer_id );
}

$show_basket = true;

echo '<h2>'. $VM_LANG->_PHPSHOP_CART_TITLE .'</h2>
<!-- Cart Begins here -->
';
include(PAGEPATH. 'basket.php');

echo '<!-- End Cart -->
<br />';

if ($cart["idx"]) {
	
    if( $continue_link != '') {
 		?>
 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     	<span class="componentheading"><a href="<?php echo $continue_link ?>">
     		<img src="<?php echo IMAGEURL ?>ps_image/back.png" align="absmiddle" width="22" height="22" alt="Back" border="0" />
      		<?php echo $VM_LANG->_PHPSHOP_CONTINUE_SHOPPING; ?>
     		</a>
     	</span>
 		<?php
    }
        
        
   	if (!defined('_MIN_POV_REACHED')) { ?>
       
      
           <span style="font-weight:bold;"><?php echo $VM_LANG->_PHPSHOP_CHECKOUT_ERR_MIN_POV2 . " ".$CURRENCY_DISPLAY->getFullValue($_SESSION['minimum_pov']) ?></span>
       <?php
   	}
   	else {
 
	?>
 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <span class="componentheading"><a href="<?php $sess->purl( $mm_action_url . "index.php?page=checkout.index&ssl_redirect=1"); ?>">
	     	<img src="<?php echo IMAGEURL ?>ps_image/forward.png" align="absmiddle" width="22" height="22" alt="Forward" border="0" />
	      	<?php echo $VM_LANG->_PHPSHOP_CHECKOUT_TITLE ?>
	     	</a>
	    </span>
 
		<?php
 	}
 ?>
<br style="clear:both;" /><br />

<?php
// End if statement
}
?>

