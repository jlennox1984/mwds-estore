<?php
/**
* @version		$Id: toolbar.plugins.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Plugins
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
* @package		Joomla
* @subpackage	Plugins
*/
class TOOLBAR_modules {
	/**
	* Draws the menu for Editing an existing module
	*/
	function _EDIT() {
		$cid = JRequest::getVar( 'cid', array(0));

		$text = $cid[0] ? JText::_('Edit') : JText::_('New');

		JMenuBar::title( JText::_( 'Plugin' ) .': <small><small>[' .$text. ']</small></small>', 'plugin.png' );
		JMenuBar::save();
		JMenuBar::apply();
		if ( $cid[0] ) {
			// for existing items the button is renamed `close`
			JMenuBar::cancel( 'cancel', 'Close' );
		} else {
			JMenuBar::cancel();
		}
		JMenuBar::help( 'screen.plugins.edit' );
	}

	function _DEFAULT() {
		JMenuBar::title( JText::_( 'Plugin Manager' ), 'plugin.png' );
		JMenuBar::publishList();
		JMenuBar::unpublishList();
		JMenuBar::editListX();
		JMenuBar::help( 'screen.plugins' );
	}
}
?>