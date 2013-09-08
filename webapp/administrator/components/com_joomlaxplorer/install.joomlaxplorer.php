<?php
/**
* @version $Id: install.joomlaxplorer.php,v 1.1 2005/11/08 18:21:38 soeren Exp $
* @package joomlaXplorer
* @copyright (C) 2005 Quixplorer Team; Soeren
* @license GNU / GPL
* @author soeren
* joomlaXplorer is Free Software
*/
function com_install(){
	global $database;

	$database->setQuery( "SELECT id FROM #__components WHERE admin_menu_link = 'option=com_joomlaxplorer'" );
	$id = $database->loadResult();

	//add new admin menu images
	$database->setQuery( "UPDATE #__components SET admin_menu_img = '../administrator/components/com_joomlaxplorer/_img/joomla_x_icon.png', admin_menu_link = 'option=com_joomlaxplorer' WHERE id=$id");
	$database->query();
}
?>