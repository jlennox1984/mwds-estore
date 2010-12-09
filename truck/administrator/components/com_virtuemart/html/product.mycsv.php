<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: product.mycsv.php 617 2007-01-04 19:43:08Z soeren_nb $
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
global $mosConfig_cachepath;
if (!defined('_PSHOP_ADMIN')) $my_path = "includes/js/ThemeOffice/";
else $my_path = "../includes/js/ThemeOffice/";

if (isset($vars["show_preview"]) && strtoupper($vars["show_preview"]) == "Y") {
	if (empty($vars['preview_only'])) { ?>
		<div style="width: 40%; float: right;">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="adminForm" enctype="multipart/form-data"> 
			<input type="hidden" name="func" value="product_csv" /> 
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="page" value="product.mycsv" />
			<input type="hidden" name="option" value="com_virtuemart" /> 
			<input type="hidden" name="no_html" value="0" />
			<input type="hidden" name="csv_delimiter" value="<?php echo $vars["csv_delimiter"]; ?>" />
			<input type="hidden" name="csv_delimiter_custom" value="<?php echo $vars["csv_delimiter_custom"]; ?>" />
			<input type="hidden" name="collect_debug_info" value="<?php echo $vars["collect_debug_info"]; ?>" />
			<?php
			$vars["csv_enclosurechar"] = str_replace("\\","", $vars["csv_enclosurechar"]);
			if ($vars["csv_enclosurechar"] == "\"") { ?> 
				<input type="hidden" name="csv_enclosurechar" value='<?php echo $vars["csv_enclosurechar"]; ?>' />
			<?php }
			else { ?>
				<input type="hidden" name="csv_enclosurechar" value="<?php echo $vars["csv_enclosurechar"]; ?>" />
			<?php } ?>
			<input type="hidden" name="csv_enclosurechar_custom" value='<?php echo $vars["csv_enclosurechar_custom"]; ?>' />
			<input type="hidden" name="overwrite_existing_data" value="<?php echo $vars["overwrite_existing_data"]; ?>" />
			<input type="hidden" name="upload_type" value="<?php echo $vars["upload_type"]; ?>" />
			<?php
			if (isset($vars["import_config_csv_file"])) { ?>
				<input type="hidden" name="import_config_csv_file" value="<?php echo $vars["import_config_csv_file"]; ?>" />
			<?php }
			if (isset($vars["skip_first_line"])) { ?>
				<input type="hidden" name="skip_first_line" value="<?php echo $vars["skip_first_line"]; ?>" />
			<?php } ?>
			<input type="hidden" name="show_preview" value="" />
			<input type="hidden" name="was_preview" value="Y" />
			<?php
			// Check if it is a local file or uploaded file
			if (isset($_FILES['file']['name']) && !empty($_FILES["file"]["type"])) { ?> 
				<input type="hidden" name="local_csv_file" value="<?php echo $mosConfig_cachepath."/".basename($_FILES['file']['name']);?>" />
			<?php }
			else { ?> 
				<input type="hidden" name="local_csv_file" value="<?php echo $vars["local_csv_file"];?>" />
			<?php } ?>
			<input type="hidden" name="use_standard_order" value="<?php echo $vars["use_standard_order"]; ?>" />
			<a href="#" onclick="javascript: submitbutton();">
			<img alt="Import" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/upload_f2.png" align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_CONTINUE_UPLOAD ?></a>
		</form>
		</div>
	<?php }
	else echo $vars['preview_only']; ?>
	<div style="width: 40%; float: left;">	
		<img src="<?php echo $my_path ?>query.png" />
		<?php if (isset($_FILES['file']['name']) && !empty($_FILES["file"]["type"])) { ?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="preview_cancel" enctype="multipart/form-data"> 
				<input type="hidden" name="pshop_mode" value="admin" />
				<input type="hidden" name="page" value="product.csv_upload" />
				<input type="hidden" name="option" value="com_virtuemart" />
				<input type="hidden" name="preview" value="cancel" />
				<input type="hidden" name="upload_file_name" value="<?php echo $mosConfig_cachepath."/".basename($_FILES['file']['name']);?>" />
				<input type="hidden" name="func" value="" />
			</form>
			<a href="#" onclick="javascript: document.preview_cancel.submit();"><?php echo $VM_LANG->_PHPSHOP_CSV_CANCEL_UPLOAD; ?></a>
		<?php }
		else { ?>
			<a href="<?php $sess->purl($_SERVER['PHP_SELF'] . "?pshop_mode=admin&amp;page=product.csv_upload"); ?>">
			<?php echo $VM_LANG->_PHPSHOP_CSV_CANCEL_UPLOAD; ?></a>
		<?php } ?>
	</div>
	<div style="width: 100%; float: left; overflow: auto;">
	<?php
	echo $vars['preview'];
	?>
	</div>
	<?php
}
else {
	?>
	<div style="text-align: left; width: 30%;" class="message"><?php echo $VM_LANG->_PHPSHOP_CSV_OUTPUT_CSV_UPLOAD_MESSAGES ?></div>
	<br />
	<div style="width: 99%">
		<div style="float: left; width: 20%; border: 1px solid #000000; margin-right: 5%;">
			<table style="width: 100%;">
			<tr style="background-color: #DFDFDF;"><td>&nbsp;</td><td><?php echo $VM_LANG->_PHPSHOP_CSV_OUTPUT_COUNT ?></td></tr>
			<?php
			$total = 0;
			foreach ($vars['csv_stats'] as $action => $stats) {
				$action = strtoupper("_PHPSHOP_CSV_OUTPUT_".$action);
				?>
				<tr style="background-color: #EFEFEF;"><td><?php echo $VM_LANG->$action; ?></td><td><?php echo $stats['count']; ?></td></tr>
				<?php $total = $total + $stats['count']; ?>
			<?php } ?>
			<tr style="background-color: #DFDFDF;"><td><?php echo $VM_LANG->_PHPSHOP_CSV_OUTPUT_TOTAL ?></td><td><?php echo $total; ?></td></tr>
			</table>
		</div>
		<div style="float: left; text-align: left; align: center; width: 40%; height: 250px; overflow: auto;";>
			<?php
			foreach ($vars['csv_stats'] as $action => $stats) {
				$action = strtoupper("_PHPSHOP_CSV_OUTPUT_".$action);
				echo "<div style=\"text-align: center; background-color: #EFEFEF;\">".$VM_LANG->$action."</div>";
				echo $stats['message'];
				echo "<br />";
			}
			?>
		</div>
		<div style="float: left; width: 100%; margin-top: 1.0em;">
			<?php echo $VM_LANG->_PHPSHOP_CSV_OUTPUT_FILE_IMPORTED ?><br />
			<img src="<?php echo $my_path ?>query.png" /><a href="<?php $sess->purl($_SERVER['PHP_SELF'] . "?pshop_mode=admin&page=product.csv_upload"); ?>"><?php echo $VM_LANG->_PHPSHOP_PRODUCT_CSV_UPLOAD ?></a>
		</div>
		<?php if (isset($vars['csv_debug']['message'])) {?>
			<div style="float: left; width: 100%; text-align: left; margin-top: 1.0em;">
				<?php echo $vars['csv_debug']['message']; ?>
			</div>
		<?php } ?>
	</div>
	<script type="text/javascript">
		function switchMenu(obj) {
			var el = document.getElementById(obj);
			if ( el.style.display != 'none' ) {
				el.style.display = 'none';
			}
			else {
			el.style.display = '';
			}
		}
	</script>
	<?php
}
?>