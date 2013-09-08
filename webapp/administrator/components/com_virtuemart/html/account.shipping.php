<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: account.shipping.php 617 2007-01-04 19:43:08Z soeren_nb $
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

$mainframe->setPageTitle( $VM_LANG->_PHPSHOP_USER_FORM_SHIPTO_LBL );

require_once( CLASSPATH.'ps_product_category.php');
$pathway = "<a class=\"pathway\" href=\"".$sess->url( SECUREURL ."index.php?page=account.index")."\" title=\"".$VM_LANG->_PHPSHOP_ACCOUNT_TITLE."\">"
      .$VM_LANG->_PHPSHOP_ACCOUNT_TITLE."</a> ".ps_product_category::pathway_separator().' '
      .$VM_LANG->_PHPSHOP_USER_FORM_SHIPTO_LBL;
$mainframe->appendPathWay( $pathway );
//echo "<div>$pathway</div><br/>";
      
$q  = "SELECT * FROM #__{vm}_user_info WHERE ";
$q .= "(address_type='ST' OR address_type='st') ";
$q .= "AND user_id='" . $auth["user_id"] . "'";
$db->query($q);
?>
<fieldset>
   <legend class="sectiontableheader"><?php echo $VM_LANG->_PHPSHOP_USER_FORM_SHIPTO_LBL ?></legend>
   <br/><br/>
   <div><?php echo $VM_LANG->_PHPSHOP_ACC_BILL_DEF; ?></div>
   <br/>
<?php
  while( $db->next_record() ) {
?>
   <div>
   -<a href="<?php $sess->purl(SECUREURL . "index.php?next_page=account.shipping&page=account.shipto&user_info_id=" . $db->f("user_info_id")); ?>">
   <?php echo $db->f("address_type_name"); ?></a>
   </div>
   <br/>
<?php
  }
?>
   <br/><br/>
   <div>
      <a class="button" href="<?php $sess->purl(SECUREURL . "index.php?page=account.shipto&next_page=account.shipping"); ?>"><?php echo $VM_LANG->_PHPSHOP_USER_FORM_ADD_SHIPTO_LBL ?></a>
   </div>
</fieldset>
<!-- Body ends here -->
