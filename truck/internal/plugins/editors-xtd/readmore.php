<?php
/**
* @version		$Id: readmore.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent( 'onCustomEditorButton', 'pluginReadmoreButton' );

/**
* readmore button
* @return array A two element array of ( imageName, textToInsert )
*/
function pluginReadmoreButton($name)
{
	global $mainframe, $option;

	$doc 		=& JFactory::getDocument();
	$template 	= $mainframe->getTemplate();

	$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
	// button is not active in specific content components
	switch ( $option )
	{
		case 'com_sections':
		case 'com_categories':
		case 'com_modules':
			$button = array( false );
			break;

		default:
			$editor 	=& JFactory::getEditor();
			$getContent = $editor->getContent($name);
			$present = "Already Exists";
			$js = "
			function insertReadmore() {
				var content = $getContent
				if (content.match(/<hr id=\"system-readmore\" \/>/)) {
					alert('$present');
					return false;
				} else {
					jInsertEditorText('<hr id=\"system-readmore\" />');
				}
			}
			";

			$css = "\t.button1-left .readmore { background: url($url/plugins/editors-xtd/readmore.png) 100% 0 no-repeat; }";
			$doc->addStyleDeclaration($css);
			$doc->addScriptDeclaration($js);
			$button = array( "insertReadmore()", JText::_('Readmore'), 'readmore' );
			break;
	}

	return $button;
}
?>