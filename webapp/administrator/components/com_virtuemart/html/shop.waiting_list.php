<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: shop.waiting_list.php 686 2007-02-20 07:32:54Z soeren_nb $
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

require_once (CLASSPATH. 'ps_product.php' );
$ps_product = new ps_product;
?>


<form action="<?php echo $mm_action_url ?>index.php" method="post" name="waiting">
<input type="hidden" name="option" value="<?php echo $option ?>" />
<input type="hidden" name="func" value="waitinglistadd" />
<?php echo $VM_LANG->_PHPSHOP_WAITING_LIST_MESSAGE ?>
<br />
<br />

<input type="text" class="inputbox" name="notify_email" value="<?php echo $my->email ?>" />
&nbsp;&nbsp;

<input type="submit" class="button" name="waitinglistadd" value="<?php echo $VM_LANG->_PHPSHOP_WAITING_LIST_NOTIFY_ME ?>" />

<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
<input type="hidden" name="page" value="shop.waiting_thanks" />

</form>
