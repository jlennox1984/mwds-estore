<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require( $mosConfig_absolute_path.'/components/com_joomlaxplorer/configuration.jx.php' );

if( !$frontend_enabled || empty( $subdir ) || $subdir == '/' || $subdir == '\\' ) {
	echo _NOT_EXIST;
	return;
}

$GLOBALS["home_dir"] = $mosConfig_absolute_path . $subdir;
// the url corresponding with the home directory: (no trailing '/')
$GLOBALS["home_url"] = $mosConfig_live_site.'/downloads';

require( $mosConfig_absolute_path.'/components/com_joomlaxplorer/joomlaxplorer.init.php');
include( $mosConfig_absolute_path.'/components/com_joomlaxplorer/joomlaxplorer.list.php');

if( !empty($GLOBALS['ERROR'])) {
	echo '<h2>'.$GLOBALS['ERROR'].'</h2>';
	return;
}

$database->setQuery( 'SELECT id, name FROM `#__menu` WHERE link LIKE \'%option=com_joomlaxplorer%\' ORDER BY `id` LIMIT 1');
$database->loadObject( $res );
if( is_object( $res )) {
	$name = $res->name;
}
else {
	$name = '';
}

if( $name || $dir ) {
	$mainframe->setPageTitle( $name.' - '.$dir );
}
$action = mosGetParam( $_REQUEST, 'action', 'list');
$item = mosGetParam( $_REQUEST, 'item', '');

// Here we allow *download* and *directory listing*, nothing more, nothing less
switch( $action ) {
	case 'download':
		require _QUIXPLORER_PATH . "/.include/fun_down.php";
	  	@ob_end_clean(); // get rid of cached unwanted output
	  	download_item($dir, $item);
	  	ob_start(false); // prevent unwanted output
	  	exit;
	case 'list':
	default:
		list_dir($dir);
		break;
}

// A small nice footer. Remove if you don't want to give credit to the developer.
echo '<br style="clear:both;"/>
	<small>
	<a class="title" href="'.$GLOBALS['jx_home'].'" target="_blank">powered by joomlaXplorer</a>
	</small>
	';
	
?>
