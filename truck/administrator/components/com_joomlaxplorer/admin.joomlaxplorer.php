<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** joomlaXplorer
* This is a component with full access to the filesystem of your joomla Site
* I wouldn't recommend to let in Managers
* allowed: Superadministrator
**/
if (!$acl->acl_check( 'administration', 'config', 'users', $my->usertype )) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}
// The joomlaXplorer version number
$GLOBALS['jx_version'] = '1.5.0';
$GLOBALS['jx_home'] = 'http://developer.joomla.org/sf/projects/joomlaxplorer';
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is index.php, released on 2003-04-02.

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
Author: soeren, The QuiX project( quix@free.fr, http://www.quix.tk, http://quixplorer.sourceforge.net)

Comment:
	joomlaXplorer 1.5.0
	Main File
	
	Have Fun...
------------------------------------------------------------------------------*/
define ( "_QUIXPLORER_PATH", $mosConfig_absolute_path."/administrator/components/com_joomlaxplorer" );
define ( "_QUIXPLORER_FTPTMP_PATH", $mosConfig_absolute_path."/administrator/components/com_joomlaxplorer/_ftptmp" );
define ( "_QUIXPLORER_URL", $mosConfig_live_site."/administrator/components/com_joomlaxplorer" );
global $action;

//------------------------------------------------------------------------------
umask(0002); // Added to make created files/dirs group writable
//------------------------------------------------------------------------------
require _QUIXPLORER_PATH . "/.include/init.php";	// Init
//------------------------------------------------------------------------------

if( !isset( $_REQUEST['dir'] ) ) {

	$dir = mosGetParam( $_SESSION,'jx_'.$GLOBALS['file_mode'].'dir', '' );
	$try_this = jx_isFTPMode() ? '/'.$dir : $GLOBALS['home_dir'].'/'.$dir;
	if( !jx_File::file_exists( $try_this )) {
		$dir = '';
	}
}
else {
	$dir = $_SESSION['jx_'.$GLOBALS['file_mode'].'dir'] = mosGetParam( $_REQUEST, "dir" );
}

if( jx_isFTPMode() && $dir != '' ) {
	$GLOBALS['FTPCONNECTION']->cd( $dir );
}

$action = stripslashes(mosGetParam( $_REQUEST, "action" ));
if( $action == "post" )
  $action = mosGetParam( $_REQUEST, "do_action" );
elseif( empty( $action ))
  $action = "list";

if( $action != "arch" && $action != "download") {
	echo '
<script type="text/javascript" src="components/com_joomlaxplorer/_style/opacity.js"></script>
<script type="text/javascript" src="components/com_joomlaxplorer/_js/mootools.ajax.js"></script>
';
}

$item = mosGetParam( $_REQUEST, "item" );
switch($action) {		// Execute action
//------------------------------------------------------------------------------
  // EDIT FILE
  case "edit":
	  require _QUIXPLORER_PATH . "/.include/fun_edit.php";
	  edit_file($dir, $item);
  break;
  // VIEW FILE
  case 'view':
  	require _QUIXPLORER_PATH . "/.include/fun_view.php";
  	jx_show_file($dir, $item);
  	break;
//------------------------------------------------------------------------------
  // DELETE FILE(S)/DIR(S)
  case "delete":
	  require _QUIXPLORER_PATH . "/.include/fun_del.php";
	  del_items($dir);
  break;
//------------------------------------------------------------------------------
  // COPY/MOVE FILE(S)/DIR(S)
  case "copy":	case "move":
	  require _QUIXPLORER_PATH ."/.include/fun_copy_move.php";
	  copy_move_items($dir);
  break;
  // RENAME FILE(S)/DIR(S)
  case "rename":
	  require _QUIXPLORER_PATH ."/.include/fun_rename.php";
	  rename_item($dir, $item);
  break;
//------------------------------------------------------------------------------
  // DOWNLOAD FILE
  case "download":
	  require _QUIXPLORER_PATH . "/.include/fun_down.php";
	  @ob_end_clean(); // get rid of cached unwanted output
	  download_item($dir, $item);
	  ob_start(false); // prevent unwanted output
	  exit;
  break;
//------------------------------------------------------------------------------
  // UPLOAD FILE(S)
  case "upload":
	  require _QUIXPLORER_PATH . "/.include/fun_up.php";
	  upload_items($dir);
  break;
//------------------------------------------------------------------------------
  // CREATE DIR/FILE
  case "mkitem":
	  require _QUIXPLORER_PATH ."/.include/fun_mkitem.php";
	  make_item($dir);
  break;
//------------------------------------------------------------------------------
  // CHMOD FILE/DIR
  case "chmod":
	  require _QUIXPLORER_PATH ."/.include/fun_chmod.php";
	  chmod_item($dir, $GLOBALS["item"]);
  break;
//------------------------------------------------------------------------------
  // SEARCH FOR FILE(S)/DIR(S)
  case "search":
	  require _QUIXPLORER_PATH ."/.include/fun_search.php";
	  search_items($dir);
  break;
//------------------------------------------------------------------------------
  // CREATE ARCHIVE
  case "arch":
	  require _QUIXPLORER_PATH . "/.include/fun_archive.php";
	  archive_items($dir);
  break;
//------------------------------------------------------------------------------
  // EXTRACT ARCHIVE
  case "extract":
	  require _QUIXPLORER_PATH . "/.include/fun_archive.php";
	  extract_item($dir, $item);
  break;
//------------------------------------------------------------------------------
  // USER-ADMINISTRATION
  case "admin":
	  require _QUIXPLORER_PATH . "/.include/fun_admin.php";
	  show_admin($dir);
  break;
//------------------------------------------------------------------------------
  // joomla System Info
  case 'sysinfo':
	  require _QUIXPLORER_PATH . "/.include/fun_system_info.php";
  break;
//------------------------------------------------------------------------------
	// FTP LOGIN
  case 'ftp_authentication':
  	$ftp_login = mosGetParam( $_POST, 'ftp_login_name', '' );
  	$ftp_pass = mosGetParam( $_POST, 'ftp_login_pass', '' );
  	require( _QUIXPLORER_PATH.'/.include/fun_ftpauthentication.php' );
  	ftp_authentication( $ftp_login, $ftp_pass );
  	break;
//------------------------------------------------------------------------------
	// BOOKMARKS
  case 'modify_bookmark':
  	$task = mosGetParam( $_REQUEST, 'task' );
  	require( _QUIXPLORER_PATH.'/.include/fun_bookmarks.php' );
  	modify_bookmark( $task, $dir );
  	
  	break;
  	
//------------------------------------------------------------------------------
  case 'show_error':
  	show_error('');
  	break;
//------------------------------------------------------------------------------
  // DEFAULT: LIST FILES & DIRS
  case "list":
  default:
	  require _QUIXPLORER_PATH . "/.include/fun_list.php";
	  list_dir($dir);
//------------------------------------------------------------------------------
}				// end switch-statement
//------------------------------------------------------------------------------
show_footer();
// Disconnect from ftp server
if( jx_isFTPMode() ) {
	$GLOBALS['FTPCONNECTION']->disconnect();
}
//------------------------------------------------------------------------------
?>
