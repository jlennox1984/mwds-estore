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

     The Original Code is init.php, released on 2003-03-31.

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
	Main File
	
	Have Fun...
------------------------------------------------------------------------------*/
//------------------------------------------------------------------------------

// Vars
if(isset($_SERVER)) {
	$GLOBALS['__GET']	=&$_GET;
	$GLOBALS['__POST']	=&$_POST;
	$GLOBALS['__SERVER']	=&$_SERVER;
	$GLOBALS['__FILES']	=&$_FILES;
} 
elseif(isset($HTTP_SERVER_VARS)) {
	$GLOBALS['__GET']	=&$HTTP_GET_VARS;
	$GLOBALS['__POST']	=&$HTTP_POST_VARS;
	$GLOBALS['__SERVER']	=&$HTTP_SERVER_VARS;
	$GLOBALS['__FILES']	=&$HTTP_POST_FILES;
} 
else {
	die("<strong>ERROR: Your PHP version is too old</strong><br/>".
	"You need at least PHP 4.0.0 to run joomlaXplorer; preferably PHP 4.4.4 or higher.");
}
//------------------------------------------------------------------------------

// Default Dir
if(isset($GLOBALS['__GET']["dir"])) 
  $GLOBALS["dir"]=stripslashes($GLOBALS['__GET']["dir"]);
else 
  $GLOBALS["dir"]="";
if($GLOBALS["dir"]==".") 
  $GLOBALS["dir"]=="";

// Get Item
if(isset($GLOBALS['__GET']["item"])) 
  $GLOBALS["item"]=stripslashes($GLOBALS['__GET']["item"]);
else 
  $GLOBALS["item"]="";

// Get Sort
if(isset($GLOBALS['__GET']["order"])) 
  $GLOBALS["order"]=stripslashes($GLOBALS['__GET']["order"]);
else 
  $GLOBALS["order"]="name";
if($GLOBALS["order"]=="") 
  $GLOBALS["order"]=="name";

// Get Sortorder (yes==up)
if(isset($GLOBALS['__GET']["srt"])) 
  $GLOBALS["srt"]=stripslashes($GLOBALS['__GET']["srt"]);
else 
  $GLOBALS["srt"]="yes";
if($GLOBALS["srt"]=="") 
  $GLOBALS["srt"]=="yes";
// Get Language
if(isset($GLOBALS['__GET']["lang"])) 
  $GLOBALS["lang"]=$GLOBALS["language"]=$GLOBALS['__GET']["lang"];
elseif(isset($GLOBALS['__POST']["lang"])) 
  $GLOBALS["lang"]=$GLOBALS["language"]=$GLOBALS['__POST']["lang"];
//------------------------------------------------------------------------------

/** @var $GLOBALS['file_mode'] Can be 'file' or 'ftp' */
if( !isset( $_REQUEST['file_mode'] ) && !empty($_SESSION['file_mode'] )) {
	$GLOBALS['file_mode'] = mosGetParam( $_SESSION, 'file_mode', 'file' );
}
else {
	if( @$_REQUEST['file_mode'] == 'ftp' && @$_SESSION['file_mode'] == 'file') {
		if( empty( $_SESSION['ftp_login']) && empty( $_SESSION['ftp_pass'])) {
			mosRedirect( 'index2.php?option=com_joomlaxplorer&action=ftp_authentication' );
		}
		else {
			$GLOBALS['file_mode'] = $_SESSION['file_mode'] = mosGetParam( $_REQUEST, 'file_mode', 'file' );
		}
	}
	elseif( isset( $_REQUEST['file_mode'] )) {
		$GLOBALS['file_mode'] = $_SESSION['file_mode'] = mosGetParam( $_REQUEST, 'file_mode', 'file' );
	}
	else {
		$GLOBALS['file_mode'] = mosGetParam( $_SESSION, 'file_mode', 'file' );
	}
}

// Necessary files

require _QUIXPLORER_PATH."/.config/conf.php";
if( file_exists(_QUIXPLORER_PATH."/_lang/".$GLOBALS["language"].".php")) {
	require _QUIXPLORER_PATH."/_lang/".$GLOBALS["language"].".php";
}
else {
	require _QUIXPLORER_PATH."/_lang/english.php";
}
if( file_exists(_QUIXPLORER_PATH."/_lang/".$GLOBALS["language"]."_mimes.php")) {
	require _QUIXPLORER_PATH."/_lang/".$GLOBALS["language"]."_mimes.php";
}
else {
	require _QUIXPLORER_PATH."/_lang/english_mimes.php";
}

require _QUIXPLORER_PATH."/.config/mimes.php";
require _QUIXPLORER_PATH."/_lib/File_Operations.php";
require _QUIXPLORER_PATH."/.include/fun_extra.php";
require _QUIXPLORER_PATH."/.include/header.php";
require _QUIXPLORER_PATH."/.include/footer.php";
require _QUIXPLORER_PATH."/.include/error.php";


//------------------------------------------------------------------------------

/** @global Net_FTP $GLOBALS['FTPCONNECTION'] */
$GLOBALS['FTPCONNECTION'] = '';

if( jx_isFTPMode() ) {
	// Try to connect to the FTP server.    	HOST,   PORT, TIMEOUT
	$url = parse_url( $mosConfig_live_site );
	$GLOBALS['FTPCONNECTION'] = new Net_FTP( $url['host'], 21, 20 );
	$res = $GLOBALS['FTPCONNECTION']->connect();
	if( PEAR::isError( $res )) {
		echo $res->getMessage();
		$GLOBALS['file_mode'] = $_SESSION['file_mode'] = 'file';
	}
	else {
		if( empty( $_SESSION['ftp_login']) && empty( $_SESSION['ftp_pass'])) {
			mosRedirect( 'index2.php?option=com_joomlaxplorer&action=ftp_authentication&file_mode=file' );
		}
		$login_res = $GLOBALS['FTPCONNECTION']->login( $_SESSION['ftp_login'], $_SESSION['ftp_pass'] );
		if( PEAR::isError( $res )) {
			echo $login_res->getMessage();
			$GLOBALS['file_mode'] = $_SESSION['file_mode'] = 'file';
		}	
	}
	
}
//------------------------------------------------------------------------------
if($GLOBALS["require_login"]) {	// LOGIN

	require _QUIXPLORER_PATH."/.include/login.php";
	
	if($GLOBALS["action"]=="logout") {
		logout();
	} else {
		login();
	}
}
//------------------------------------------------------------------------------
$abs_dir=get_abs_dir($GLOBALS["dir"]);
if(!file_exists($GLOBALS["home_dir"])) {
  if(!file_exists($GLOBALS["home_dir"].$GLOBALS["separator"])) {
	if($GLOBALS["require_login"]) {
		$extra="<a href=\"".make_link("logout",NULL,NULL)."\">".
			$GLOBALS["messages"]["btnlogout"]."</A>";
	} 
	else $extra=NULL;
	show_error($GLOBALS["error_msg"]["home"]." (".$GLOBALS["home_dir"].")",$extra);
  }
}
if(!down_home($abs_dir)) show_error($GLOBALS["dir"]." : ".$GLOBALS["error_msg"]["abovehome"]);
if(!get_is_dir($abs_dir))
  if(!get_is_dir($abs_dir.$GLOBALS["separator"]))
	show_error($abs_dir." : ".$GLOBALS["error_msg"]["direxist"]);
//------------------------------------------------------------------------------
?>
