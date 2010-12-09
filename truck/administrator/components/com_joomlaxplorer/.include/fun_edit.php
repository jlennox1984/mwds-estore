<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_edit.php, released on 2003-03-31.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	File-Edit Functions
	
	Have Fun...
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------
function savefile($file_name) {			// save edited file
	if( get_magic_quotes_gpc() ) {
		$code = stripslashes($GLOBALS['__POST']["code"]);
	}
	else {
		$code = $GLOBALS['__POST']["code"];
	}
	
	$res = jx_File::file_put_contents( $file_name, $code );
	
	if( $res==false || PEAR::isError( $res )) {
		$err = basename($file_name).": ".$GLOBALS["error_msg"]["savefile"];
		if( PEAR::isError( $res ) ) {
			$err .= $res->getMessage();
		}
		show_error( $err );
	}
	
}
//------------------------------------------------------------------------------
function edit_file($dir, $item) {		// edit file
	if(($GLOBALS["permissions"]&01)!=01) 
	  show_error($GLOBALS["error_msg"]["accessfunc"]);
	$fname = get_abs_item($dir, $item);
	if(!get_is_file($fname)) 
	  show_error($item.": ".$GLOBALS["error_msg"]["fileexist"]);
	if(!get_show_item($dir, $item)) 
	  show_error($item.": ".$GLOBALS["error_msg"]["accessfile"]);	
	
	if(isset($GLOBALS['__POST']["dosave"]) && $GLOBALS['__POST']["dosave"]=="yes") {
		// Save / Save As
		$item=basename(stripslashes($GLOBALS['__POST']["fname"]));
		$fname2=get_abs_item($dir, $item);
		if(!isset($item) || $item=="") 
		  show_error($GLOBALS["error_msg"]["miscnoname"]);
		if($fname!=$fname2 && @jx_File::file_exists($fname2)) 
		  show_error($item.": ".$GLOBALS["error_msg"]["itemdoesexist"]);
		savefile($fname2);
		$fname=$fname2;
		if( !empty( $GLOBALS['__POST']['return_to'])) {
			$return_to = urldecode($GLOBALS['__POST']['return_to']);
			mosRedirect( $return_to );
		}
		elseif( !empty( $GLOBALS['__POST']['return_to_dir'])) {
			mosRedirect( $_SERVER['PHP_SELF'].'?option=com_joomlaxplorer&dir='.$dir, 'The File '.$item.' was saved.');
		}
	}
	
	// header
	$s_item=get_rel_item($dir,$item);	if(strlen($s_item)>50) $s_item="...".substr($s_item,-47);
	show_header($GLOBALS["messages"]["actedit"].": /".$s_item);
	
	// Wordwrap (works only in IE)
?><script language="JavaScript1.2" type="text/javascript">
<!--
	function chwrap() {
		if(document.editfrm.wrap.checked) {
			document.editfrm.code.wrap="soft";
		} else {
			document.editfrm.code.wrap="off";
		}
	}
// -->
</script><?php

	// Form
	echo "<br/><form name=\"editfrm\" id=\"editfrm\" method=\"post\" action=\"".make_link("edit",$dir,$item)."\">\n";
	if( !empty( $GLOBALS['__GET']['return_to'])) {
		$close_action = 'window.location=\''.urldecode($GLOBALS['__GET']['return_to']).'\';';
		echo "<input type=\"hidden\" name=\"return_to\" value=\"". $GLOBALS['__GET']['return_to']."\" />\n";
	}
	else {
		$close_action = 'window.location=\''. make_link('list',$dir,NULL)."'";
	}
	echo "
<table class=\"adminform\">
	<tr>
		<td style=\"text-align: center;\">
			<input type=\"button\" value=\"".$GLOBALS["messages"]["btnsave"]."\" onclick=\"document.editfrm.submit();\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"reset\" value=\"".$GLOBALS["messages"]["btnreset"]."\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type=\"button\" value=\"".$GLOBALS["messages"]["btnclose"]."\" onclick=\"javascript:$close_action\" />
		</td>
	</tr>
	<tr>
		<td >
			<div style=\"width:70%;text-align: center;float:left;\">
				<input type=\"checkbox\" value=\"1\" name=\"return_to_dir\" id=\"return_to_dir\" />
				<label for=\"return_to_dir\">".$GLOBALS["messages"]["returndir"]."</label>
			</div>
			<div style=\"width: 20%;float:right;\">".$GLOBALS["messages"]["line"]."
				: <input type=\"text\" name=\"txtLine\" class=\"inputbox\" size=\"6\" onchange=\"setCaretPosition(document.editfrm.code, this.value);return false;\">&nbsp;&nbsp;&nbsp;".$GLOBALS["messages"]["column"]."
          		: <input type=\"text\" name=\"txtColumn\" class=\"inputbox\" size=\"6\" readonly=\"readonly\">
          </div>
		</td>
	</tr>
	<tr><td>";

	echo "<input type=\"hidden\" name=\"dosave\" value=\"yes\" />\n";
	
	// Show File In TextArea
	$content = jx_File::file_get_contents( $fname );
	if( get_magic_quotes_runtime()) {
		$content = stripslashes( $content );
	}
	$content = htmlspecialchars( $content );
	
	echo "<div id=\"editorarea\">
		<textarea style=\"width:95%;\" name=\"code\" rows=\"25\" cols=\"120\" wrap=\"off\" onmouseup=\"updatePosition(this)\" onmousedown=\"updatePosition(this)\" onkeyup=\"updatePosition(this)\" onkeydown=\"updatePosition(this)\" onfocus=\"updatePosition(this)\">";
	echo $content;
	echo "</textarea></div><br/>";
	
	echo "
	</td>
	</tr>
	<tr>
		<td align=\"right\">
			<label for=\"wrap\">".$GLOBALS["messages"]["wordwrap"].":</label>
			<input type=\"checkbox\" id=\"wrap\" name=\"wrap\" onclick=\"javascript:chwrap();\" value=\"1\">
		</td>		
	</tr>
	<tr>
		<td align=\"right\">
			<label for=\"fname\">".$GLOBALS["messages"]["copyfile"]."</label>
			<input type=\"text\" name=\"fname\" value=\"".$item."\" size=\"40\" />
		</td>
	</tr>
</table>
<br/>";
	
	echo "
</form>
<br/>\n";
	
?><script language="JavaScript1.2" type="text/javascript">
<!--
if(document.editfrm) document.editfrm.code.focus();

//http://www.bazon.net/mishoo/home.epl?NEWS_ID=1345
function doGetCaretPosition (textarea) {

	var txt = textarea.value;
	var len = txt.length;
	var erg = txt.split("\n");
	var pos = -1;
	if(typeof textarea.selectionStart != "undefined") { // FOR MOZILLA
		pos = textarea.selectionStart;
	}
	else if(typeof document.selection != "undefined") { // FOR MSIE
		range_sel = document.selection.createRange();
		range_obj = textarea.createTextRange();
		range_obj.moveToBookmark(range_sel.getBookmark());
		range_obj.moveEnd('character',textarea.value.length);
		pos = len - range_obj.text.length;
	}
	if(pos != -1) {
		var ind = 0;
		for(;erg.length;ind++) {
			len = erg[ind].length + 1;
			if(pos < len)
			break;
			pos -= len;
		}
		ind++; pos++;
		return [ind, pos]; // ind = LINE, pos = COLUMN

	}
}
/**
* This function allows us to change the position of the caret
* (cursor) in the textarea
* Various workarounds for IE, Firefox and Opera are included
* Firefox doesn't count empty lines, IE does...
*/
function setCaretPosition( textarea, linenum ) {
	if (isNaN(linenum)) {
		updatePosition( textarea );
		return;
	}
	var txt = textarea.value;
	var len = txt.length;
	var erg = txt.split("\n");
		
	var ind = 0;
	var pos = 0;
	var nonempty = -1;
	var empty = -1;
	for(;ind < linenum;ind++) {
		/*alert( "Springe zu Zeile: "+linenum
				+"\naktuelle Zeile: "+ (ind+1) 
				+ "\naktuelle Position: "+pos 
				+ "\nText in dieser Zeile: "+erg[ind]);*/
		if( !erg[ind] && pos < len ) { empty++; pos++; continue; }
		else if( !erg[ind] ) break;
		pos += erg[ind].length;
		nonempty++;
	}
	try {
		pos -= erg[ind-1].length;	
	} catch(e) {}
	
	textarea.focus();
	
	if(textarea.setSelectionRange)
	{
		pos += nonempty;
		textarea.setSelectionRange(pos,pos);
	}
	else if (textarea.createTextRange) {
		pos -= empty;
		var range = textarea.createTextRange();
		range.collapse(true);
		range.moveEnd('character', pos);
		range.moveStart('character', pos);
		
		range.select();
	}
}
/** 
* Updates the Position Indicator fields
*/
function updatePosition(textBox) {
	var posArray = doGetCaretPosition(textBox);
    document.forms[0].txtLine.value = posArray[0];
    document.forms[0].txtColumn.value = posArray[1];
}
// -->
</script><?php
}
//------------------------------------------------------------------------------
?>
