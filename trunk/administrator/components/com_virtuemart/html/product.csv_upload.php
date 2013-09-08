<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
*
* @version $Id: product.csv_upload.php 617 2007-01-04 19:43:08Z soeren_nb $
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

require_once( CLASSPATH . "ps_csv.php" );
$ps_csv =& new ps_csv();
sort($ps_csv->supported_fields);
if ( (float)substr(phpversion(), 0, 3) >= 4.3) {
	$show_fec = true;
	$cols = 4;
}
else {
	$show_fec = false;
	$cols = 2;
}
// Check if there is any file left in the cache folder
if (isset($vars["preview"]) && strtolower($vars["preview"]) == "cancel") {
	if (file_exists($vars['upload_file_name'])) unlink($vars['upload_file_name']);
}
?>
<img src="
<?php echo IMAGEURL ?>ps_image/csv.gif" alt="CSV Upload" border="0" />
<span class="sectionname"><?php echo $VM_LANG->_PHPSHOP_PRODUCT_CSV_UPLOAD ?></span>
<br />
<?php
$tabs = new mShopTabs(0, 1, "_csv");
$tabs->startPane("uploadform-pane");
$tabs->startTab( $VM_LANG->_PHPSHOP_CSV_IMPORT_EXPORT, "uploadform" );
?>
<table class="adminform" border="0">
	<tr>
		<td rowspan="2" width="50%">
		<table style="border-right: 1px solid;" class="adminform">
			<tr>
				<th colspan="<?php echo $cols; ?>">
					<?php echo $VM_LANG->_PHPSHOP_CSV_SETTINGS ?>
				</th>
			</tr>
			<tr>
				<td valign="top" width="15%" align="right">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="adminForm" enctype="multipart/form-data"> 
					<input type="hidden" name="func" value="product_csv" /> 
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="page" value="product.mycsv" />
					<input type="hidden" name="option" value="com_virtuemart" /> 
					<input type="hidden" name="no_html" value="0" />
					<?php echo $VM_LANG->_PHPSHOP_CSV_DELIMITER ?>:
				</td>
				<td valign="top" width="5%"><input type="radio"
					name="csv_delimiter" checked="checked" value="^" /> <span
					class="sectionname">^</span><br />
				<input type="radio" name="csv_delimiter" value=";" /> <span
					class="sectionname">;</span><br />
				<input type="radio" name="csv_delimiter" value="," /> <span
					class="sectionname">,</span><br />
				<input type="radio" name="csv_delimiter" value="" /> <input
					type="text" name="csv_delimiter_custom" id="csv_delimiter_custom" value="" /></td>
					<?php
					if( $show_fec ) { ?>
				<td valign="top" width="10%" align="right"><?php echo $VM_LANG->_PHPSHOP_CSV_ENCLOSURE ?>:</td>
				<td valign="top" width="15%"><input type="radio"
					name="csv_enclosurechar" checked="checked" value='~' /> <span
					class="sectionname">~</span><br />
				<input type="radio" name="csv_enclosurechar" value="'" /> <span
					class="sectionname">'</span><br />
				<input type="radio" name="csv_enclosurechar" value='"' /> <span
					class="sectionname">"</span><br />
				<input type="radio" name="csv_enclosurechar" value="" /> none<br />
				<input type="radio" name="csv_enclosurechar" value="" /> <input
					type="text" name="csv_enclosurechar_custom" value="" /></td>
					<?php
					}
					?>
			</tr>
			<tr>
				<th colspan="<?php echo $cols; ?>"><?php echo $VM_LANG->_PHPSHOP_CSV_UPLOAD_SETTINGS ?></th>
			</tr>
			<tr>
				<td colspan="<?php echo $cols; ?>">
					<select id="upload_type" name="upload_type">
						<option value ="NormalUpload" selected="selected"><?php echo $VM_LANG->_PHPSHOP_CSV_REGULAR_UPLOAD; ?></option>
						<option value ="PriceListUploadOnly"><?php echo $VM_LANG->_PHPSHOP_CSV_PRICE_LIST_ONLY; ?></option>
						<option value ="MultiplePricesUpload"><?php echo $VM_LANG->_PHPSHOP_CSV_MULTIPLE_PRICES_UPLOAD; ?></option>
						<option value ="ProductTypeUpload"><?php echo $VM_LANG->_PHPSHOP_CSV_PRODUCT_TYPE_UPLOAD; ?></option>
						<option value ="ProductTypeParametersUpload"><?php echo $VM_LANG->_PHPSHOP_CSV_PRODUCT_TYPE_PARAMETERS_UPLOAD; ?></option>
						<option value ="ProductTypeXrefUpload"><?php echo $VM_LANG->_PHPSHOP_CSV_PRODUCT_TYPE_XREF_UPLOAD; ?></option>
						<option value ="ProductTypeDetailUpload"><?php echo $VM_LANG->_PHPSHOP_CSV_PRODUCT_TYPE_DETAIL_UPLOAD; ?></option>
						<option value ="EmptyDatabase"><?php echo $VM_LANG->_PHPSHOP_CSV_EMPTY_DATABASE; ?></option>
					</select>
				</td>
			<tr>
				<td colspan="<?php echo $cols/2; ?>"> <input type="checkbox" id="skip_first_line"
					name="skip_first_line" value="Y" onclick="javascript: disable('skip_first_line');" /><label for="skip_first_line"><?php echo $VM_LANG->_PHPSHOP_CSV_SKIP_FIRST_LINE; ?></label>
				</td>
				<td colspan="<?php echo $cols/2; ?>"> <input type="checkbox"
					id="overwrite_existing_data" name="overwrite_existing_data"
					value="Y" checked="checked" /><label for="overwrite_existing_data"><?php echo $VM_LANG->_PHPSHOP_CSV_OVERWRITE_EXISTING_DATA; ?></label>
				</td>
			</tr>
			<tr>
				<td colspan="<?php echo $cols/2; ?>"> <input type="checkbox" id="import_config_csv_file"
					name="import_config_csv_file" value="Y" onclick="javascript: disable('import_config_csv_file');" />
					<label for="import_config_csv_file"><?php echo $VM_LANG->_PHPSHOP_CSV_IMPORT_CONFIG_CSV_FILE; ?></label></td>
				<td colspan="<?php echo $cols/2; ?>"> <input type="checkbox" id="skip_default_value"
					name="skip_default_value" value="Y" /><label
					for="skip_default_value"><?php echo $VM_LANG->_PHPSHOP_CSV_SKIP_DEFAULT_VALUE; ?></label>
				</td>
			</tr>
			<tr>
				<td colspan="<?php echo $cols/2; ?>">
					<input type="checkbox" id="collect_debug_info" name="collect_debug_info" value="Y" />
					<label for="collect_debug_info"><?php echo $VM_LANG->_PHPSHOP_CSV_COLLECT_DEBUG_INFO; ?></label>
				</td>
				<td colspan="<?php echo $cols/2; ?>">
					<input type="checkbox" id="show_preview" name="show_preview" value="Y" />
					<label for="show_preview"><?php echo $VM_LANG->_PHPSHOP_CSV_SHOW_PREVIEW; ?></label>
				</td>
			</tr>
			<tr>
				<th colspan="<?php echo $cols; ?>"><?php echo $VM_LANG->_PHPSHOP_CSV_UPLOAD_FILE ?></th>
			</tr>
			<tr>
				<td align="center" colspan="<?php echo $cols; ?>"> <input type="file" name="file" id="file" />
				<br />
				<a href="#"
				onclick="javascript: if (CheckDelete()) {document.adminForm.no_html.value='';document.adminForm.local_csv_file.value='';submitbutton();}">
				<img alt="Import" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/upload_f2.png"
				align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_SUBMIT_FILE ?></a></td>
			</tr>
			<tr>
				<td align="center" colspan="<?php echo $cols; ?>">
				<hr />
				</td>
			</tr>
			<tr>
				<th colspan="<?php echo $cols; ?>"><?php echo $VM_LANG->_PHPSHOP_CSV_FROM_DIRECTORY ?></th>
			</tr>
			<tr>
				<td align="center" colspan="<?php echo $cols; ?>"> <input type="text" size="60"
					value="<?php echo realpath($mosConfig_absolute_path."/media") ?>" name="local_csv_file" /><br />
				<a href="#"
				onclick="javascript: if (CheckDelete()) {document.adminForm.func.value='product_csv'; document.adminForm.no_html.value='';submitbutton();}">
				<img alt="Import" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/upload_f2.png"
				align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_FROM_SERVER ?></a></td>
			</tr>
		</table>
		</td>
		<th align="center" width="50%"><?php echo $VM_LANG->_PHPSHOP_CSV_EXPORT_TO_FILE ?></th>
	</tr>
	<tr>
		<td valign="top"><strong><?php echo $VM_LANG->_PHPSHOP_CSV_SELECT_FIELD_ORDERING ?></strong><br />
		<br />
		<input type="radio" id="use_standard_order_yes"
			name="use_standard_order" value="Y" /><label
			for="use_standard_order_yes"><?php echo $VM_LANG->_PHPSHOP_CSV_DEFAULT_ORDERING ?></label>&nbsp;&nbsp; <input type="radio"
			id="use_standard_order_no" name="use_standard_order"
			checked="checked" value="N" /><label for="use_standard_order_no"><?php echo $VM_LANG->_PHPSHOP_CSV_CUSTOMIZED_ORDERING ?></label>
		<br />
		<br />
		<input type="checkbox" id="include_column_headers"
			name="include_column_headers" value="Y" /><label
			for="include_column_headers"><?php echo $VM_LANG->_PHPSHOP_CSV_INCLUDE_COLUMN_HEADERS; ?></label> <br />
		<br />
		<a href="#"
			onclick="javascript: document.adminForm.func.value='export_csv'; document.adminForm.no_html.value='1';submitbutton();document.adminForm.func.value='product_csv';">
		<img alt="Export" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/backup.png"
		align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_SUBMIT_EXPORT ?></a></td>
	</tr>
</table>
</form>
<?php
$tabs->endTab();
$tabs->startTab( $VM_LANG->_PHPSHOP_CONFIG, "field_list" );
?>
<h2><?php echo $VM_LANG->_PHPSHOP_CSV_CONFIGURATION_HEADER ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="toolbar"
	onclick="document.fieldUpdate.submit();" style="cursor:pointer;"
	onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('saveForm','','<?php echo $mosConfig_live_site ?>/administrator/images/save_f2.png',1);"><img
	src="<?php echo $mosConfig_live_site."/administrator/images/save.png" ?>" name="saveForm" align="center" border="0" /> &nbsp;&nbsp;<?php echo $VM_LANG->_PHPSHOP_CSV_SAVE_CHANGES ?></a>
</h2>
<div style="font-size: 1.3em; text-align: center;"><?php echo $VM_LANG->_PHPSHOP_CSV_MINIMAL_FIELDS; ?></div>
<br />
<table class="adminlist">
	<tr>
		<th>#</th>
		<th><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_NAME ?></th>
		<th><?php echo $VM_LANG->_PHPSHOP_CSV_DEFAULT_VALUE ?></th>
		<th><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_ORDERING ?></th>
		<th><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_REQUIRED ?></th>
		<th><?php echo $VM_LANG->_PHPSHOP_DELETE ?></th>
	</tr>
	<form name="fieldUpdate" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
		<input type="hidden" name="option" value="com_virtuemart" /> 
		<input type="hidden" name="func" value="csvFieldUpdate" /> 
		<input type="hidden" name="page" value="product.csv_upload" />
		<?php if (@$_REQUEST['pshop_mode'] == "admin") {?> 
			<input type="hidden" name="pshop_mode" value="admin" />
		<?php
		}
		$db->query( "SELECT * FROM #__{vm}_csv ORDER BY field_ordering" );
		$i = 1;
		while( $db->next_record() ) { ?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td>
		<?php
		if ( in_array( $db->f("field_name"), $ps_csv->reserved_words )){
			echo "<input type=\"hidden\" name=\"field[$i][_name]\" value=\"".$db->f("field_name")."\" />";
			echo "<select name=\"field[".$i."][_name]\" disabled=disabled>";
		}
		else echo "<select name=\"field[".$i."][_name]\">";

		foreach ($ps_csv->supported_fields as $fieldname) {
			echo "<option value=\"".$fieldname."\"";
			if($db->f("field_name")==$fieldname) echo "selected=\"selected\"";
			echo ">".$fieldname."</option>";
		}
		echo "</select>";
		?></td>
		<td><input type="text" name="field[<?php echo $i ?>][_default_value]"
		value="<?php $db->p( "field_default_value") ?>" /></td>
		<td><input type="text" name="field[<?php echo $i ?>][_ordering]" value="<?php $db->p( "field_ordering") ?>"
		size="4" /></td>
		<td><?php
		if( in_array( $db->f( "field_name"), $ps_csv->reserved_words ))
		echo $VM_LANG->_PHPSHOP_ADMIN_CFG_YES."<input type=\"hidden\" name=\"field[$i][_required]\" value=\"Y\" />\n";
		else {
			?> <select name="field[<?php echo $i ?>][_required]">
			<option value="Y"<?php if($db->f( "field_required")=="Y") echo "selected=\"selected\"" ?>><?php echo $VM_LANG->_PHPSHOP_ADMIN_CFG_YES ?></option>
			<option value="N"<?php if($db->f( "field_required")=="N") echo "selected=\"selected\"" ?>><?php echo $VM_LANG->_PHPSHOP_ADMIN_CFG_NO ?></option>
		</select>
		<?php
		}
		?></td>
		<td><?php
		if( !in_array( $db->f( "field_name"), $ps_csv->reserved_words )) { ?> <a class="toolbar"
			href="index2.php?option=com_virtuemart&page=<?php echo $_REQUEST['page'] ?>&func=csvFieldDelete&field_id=<?php echo $db->f("field_id") ?>"
		onclick="return confirm('<?php echo $VM_LANG->_PHPSHOP_DELETE_MSG ?>');" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('Delete<?php echo $i ?>','','<?php echo IMAGEURL ?>ps_image/delete_f2.gif',1);"><img src="<?php echo IMAGEURL ?>ps_image/delete.gif" alt="Delete this record" name="Delete<?php echo $i ?>" align="middle" border="0"/>
            </a>
            <?php
		}
		?></td>
	</tr>
	<input type="hidden" name="field[<?php echo $i ?>][_id]" value="<?php $db->p("field_id") ?>" /> <?php
		}
		?>
	</form>
</table>
<br />
<a style="cursor:pointer;" onclick="addField();" class="toolbar"
	onmouseout="MM_swapImgRestore();" onmouseover="MM_swapImage('newField','','<?php echo $mosConfig_live_site."/administrator/images/new_f2.png" ?>',1);">
<img src="<?php echo $mosConfig_live_site."/administrator/images/new.png" ?>" name="newField" border="0" /> &nbsp;<?php echo $VM_LANG->_PHPSHOP_CSV_NEW_FIELD ?> </a>
<form name="fieldAdd" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> <input
	type="hidden" name="option" value="com_virtuemart" /> <input
	type="hidden" name="func" value="csvFieldAdd" /> <input type="hidden"
	name="page" value="product.csv_upload" />
<div id="newfieldspace"></div>
</form>
<?php
$tabs->endTab();
$tabs->startTab($VM_LANG->_PHPSHOP_CSV_AVAILABLE_FIELDS, "available_fields");
?>
<div style="text-align: left;">
<div style="font-size: 1.3em;"><?php echo $VM_LANG->_PHPSHOP_CSV_AVAILABLE_FIELDS_USE; ?></div>
<?php
foreach ($ps_csv->supported_fields as $id => $fieldname) {
	echo "<hr>";
	echo "<div style=\"color: #FF0000; font-size: 1.2em;\">";
	echo $fieldname;
	echo "</div>";
	echo "<div>";
	$string = strtoupper("_PHPSHOP_CSV_EXPLANATION_".$fieldname);
	if (isset($VM_LANG->$string)) {
		echo $VM_LANG->$string;
	}
	echo "</div>";
}
?></div>
<?php
$tabs->endTab();
$tabs->startTab( $VM_LANG->_PHPSHOP_CSV_DOCUMENTATION, "doc-page" );
?>
<div align="left"><br />
<?php
echo "<div>";
echo $VM_LANG->_PHPSHOP_CSV_EXPLANATION_DOCUMENTATION;
echo "</div>";
echo "<hr />";
echo "<div style=\"color: #FF0000; font-size: 1.2em;\">";
echo $VM_LANG->_PHPSHOP_CSV_UPLOAD_SETTINGS;
echo "</div>";
echo "<div>";
echo $VM_LANG->_PHPSHOP_CSV_EXPLANATION_UPLOAD_SETTINGS;
echo "</div>";
echo "<hr />";
echo "<div>";
echo $VM_LANG->_PHPSHOP_CSV_EXPLANATION_DOCUMENTATION_PRODUCT_TYPES;
echo "</div>";
echo "<hr />";
echo "<div>";
echo $VM_LANG->_PHPSHOP_CSV_EXPLANATION_DOCUMENTATION_EMPTY_DATABASE;
echo "</div>";
echo "<hr />";
echo "<div>";
echo $VM_LANG->_PHPSHOP_CSV_EXPLANATION_DOCUMENTATION_MULTIPLE_PRICES_UPLOAD;
echo "</div>";
echo "<hr />";
?>
</div>
<?php
$tabs->endTab();
$tabs->endPane();
?>
<script type="text/javascript">
function disable(from) {
	if (from == "skip_first_line") {
		if (!document.adminForm.import_config_csv_file.disabled) {
			document.adminForm.import_config_csv_file.disabled=true;
		}
		else {
			document.adminForm.import_config_csv_file.disabled=false;
		}
	}
	else if (from == "import_config_csv_file") {
		if (!document.adminForm.skip_first_line.disabled) {
			document.adminForm.skip_first_line.disabled=true;
		}
		else {
			document.adminForm.skip_first_line.disabled=false;
		}
	}
}
function CheckDelete() {
	if (document.adminForm.upload_type.value == "EmptyDatabase") {
		return confirm('Are you sure you want to empty the database?')
	}
	else return true;
}
function CheckFieldOrder(from) {
	if (from.value == 0) {
		alert('Field value order should be greater than 0.');
		// fieldname = 'field[0>][_ordering]';
		// document.adminForm.fieldname.focus();
		document.adminForm.elements['field\[0\>\]\[_ordering\]'].focus();
		return false;
	}
	else return true;
}
function addField() {
	if( !called ) {
	  document.getElementById( 'newfieldspace').innerHTML += '<a onclick="document.fieldAdd.submit();" class="toolbar" style="cursor:pointer;" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage(\'saveForm2\',\'\',\'<?php echo $mosConfig_live_site ?>/administrator/images/save_f2.png\',1);"><img src="<?php echo $mosConfig_live_site."/administrator/images/save.png" ?>" name="saveForm2" align="center"  border="0" />'
	  +'&nbsp;&nbsp;<?php echo $VM_LANG->_PHPSHOP_CSV_SAVE_CHANGES ?></a>';
	}
	document.getElementById( 'newfieldspace').innerHTML += '<table class="adminForm"><tr>'
		// Retrieve only the fields that are not already used
		<?php
		$already_configured = array();
		$db_already_configured = new ps_DB;
		$q = "SELECT field_name FROM #__{vm}_csv";
		$db_already_configured->query($q);
		// $already_configured = $db_already_configured->loadAssocList();
		while ($db_already_configured->next_record()) {
			$already_configured[] = $db_already_configured->f("field_name");
		}
        $options = "";
        foreach ($ps_csv->supported_fields as $fieldname) {
		       	if (!in_array($fieldname, $already_configured)) { 
		       		$options .= "<option value=\"".$fieldname."\">".$fieldname."</option>";
		        }
       	}
       	?>
       +' <td><select name="field['+fieldNum+'>][_name]"><?php echo $options;?></select><br/><span class="smallgrey"><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_NAME ?></span></td>'
       +' <td><input type="text" name="field['+fieldNum+'>][_default_value]" /><br/><span class="smallgrey"><?php echo $VM_LANG->_PHPSHOP_CSV_DEFAULT_VALUE ?></span></td>'
       +' <td><input type="text" name="field['+fieldNum+'>][_ordering]" size="4" onchange="CheckFieldOrder(this);" /><br/><span class="smallgrey"><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_ORDERING ?></span></td>'
       +' <td align="right"><select name="field['+fieldNum+'>][_required]">'
       +'       <option value="Y" selected="selected"><?php echo $VM_LANG->_PHPSHOP_ADMIN_CFG_YES ?></option>'
       +'       <option value="N"><?php echo $VM_LANG->_PHPSHOP_ADMIN_CFG_NO ?></option>'
       +'     </select><br/>&nbsp;&nbsp;&nbsp;<span class="smallgrey"><?php echo $VM_LANG->_PHPSHOP_CSV_FIELD_REQUIRED ?></span>'
       +' </td></tr></table>';
  called = true;
  fieldNum++;
}
var called = false;
var fieldNum = 0;
</script>
