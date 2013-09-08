<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$GLOBALS['jx_home'] = 'http://developer.joomla.org/sf/projects/joomlaxplorer';

define ( "_QUIXPLORER_PATH", $mosConfig_absolute_path."/administrator/components/com_joomlaxplorer" );
define ( "_QUIXPLORER_URL", $mosConfig_live_site."/administrator/components/com_joomlaxplorer" );

$GLOBALS['ERROR'] = '';

$GLOBALS['__GET']	=&$_GET;
$GLOBALS['__POST']	=&$_POST;
$GLOBALS['__SERVER']	=&$_SERVER;
$GLOBALS['__FILES']	=&$_FILES;

if( file_exists(_QUIXPLORER_PATH."/_lang/$mosConfig_lang.php"))
  require _QUIXPLORER_PATH."/_lang/$mosConfig_lang.php";
else
  require _QUIXPLORER_PATH."/_lang/english.php";
  
if( file_exists(_QUIXPLORER_PATH."/_lang/".$mosConfig_lang."_mimes.php"))
  require _QUIXPLORER_PATH."/_lang/".$mosConfig_lang."_mimes.php";
else
  require _QUIXPLORER_PATH."/_lang/english_mimes.php";
  
// the filename of the QuiXplorer script: (you rarely need to change this)
if($_SERVER['SERVER_PORT'] == 443 ) {
	$GLOBALS["script_name"] = "https://".$GLOBALS['__SERVER']['HTTP_HOST'].$GLOBALS['__SERVER']["PHP_SELF"];
}
else {
	$GLOBALS["script_name"] = "http://".$GLOBALS['__SERVER']['HTTP_HOST'].$GLOBALS['__SERVER']["PHP_SELF"];
}
@session_start();
if( !isset( $_REQUEST['dir'] )) {
	$dir = $GLOBALS['dir'] = mosGetParam( $_SESSION,'jx_dir', '' );
}
else {
	$dir = $GLOBALS['dir'] = $_SESSION['jx_dir'] = mosGetParam( $_REQUEST, "dir" );
}


if( strstr( $mosConfig_absolute_path, "/" )) {
	$GLOBALS["separator"] = "/";
}
else {
	$GLOBALS["separator"] = "\\";
}
// Get Sort
if(isset($GLOBALS['__GET']["order"])) {
	$GLOBALS["order"]=stripslashes($GLOBALS['__GET']["order"]);
}
else {
	$GLOBALS["order"]="name";
}
if($GLOBALS["order"]=="") {
	$GLOBALS["order"]=="name";
}

// Get Sortorder (yes==up)
if(isset($GLOBALS['__GET']["srt"])) {
	$GLOBALS["srt"]=stripslashes($GLOBALS['__GET']["srt"]);
}
else {
	$GLOBALS["srt"]="yes";
}
if($GLOBALS["srt"]=="") {
	$GLOBALS["srt"]=="yes";
}
  
// show hidden files in QuiXplorer: (hide files starting with '.', as in Linux/UNIX)
$GLOBALS["show_hidden"] = true;

// filenames not allowed to access: (uses PCRE regex syntax)
$GLOBALS["no_access"] = "^\.ht";

// user permissions bitfield: (1=modify, 2=password, 4=admin, add the numbers)
$GLOBALS["permissions"] = 1;

$GLOBALS['file_mode'] = 'file';

require _QUIXPLORER_PATH."/.config/mimes.php";
require _QUIXPLORER_PATH."/_lib/File_Operations.php";
require _QUIXPLORER_PATH."/.include/fun_extra.php";
require _QUIXPLORER_PATH."/.include/header.php";
require _QUIXPLORER_PATH."/.include/footer.php";
require _QUIXPLORER_PATH."/.include/error.php";

//------------------------------------------------------------------------------

$abs_dir=get_abs_dir($GLOBALS["dir"]);
if(!file_exists($GLOBALS["home_dir"])) {
  if(!file_exists($GLOBALS["home_dir"].$GLOBALS["separator"])) {
	if(!empty($GLOBALS["require_login"])) {
		$extra="<a href=\"".make_link("logout",NULL,NULL)."\">".
			$GLOBALS["messages"]["btnlogout"]."</A>";
	} 
	else {
		$extra=NULL;
	}
	$GLOBALS['ERROR'] = $GLOBALS["error_msg"]["home"];
  }
}
if(!down_home($abs_dir)) show_error($GLOBALS["dir"]." : ".$GLOBALS["error_msg"]["abovehome"]);
if(!is_dir($abs_dir))
  if(!is_dir($abs_dir.$GLOBALS["separator"]))
	$GLOBALS['ERROR'] = $abs_dir." : ".$GLOBALS["error_msg"]["direxist"];
//------------------------------------------------------------------------------
