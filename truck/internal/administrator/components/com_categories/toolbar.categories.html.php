<?php
/**
* @version		$Id: toolbar.categories.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Categories
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
* @subpackage	Categories
*/
class TOOLBAR_categories {
	/**
	* Draws the menu for Editing an existing category
	* @param int The published state (to display the inverse button)
	*/
	function _EDIT()
	{
		$cid = JRequest::getVar( 'cid', array(0));

		$text = ( $cid[0] ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JMenuBar::title( JText::_( 'Category' ) .': <small><small>[ '. $text.' ]</small></small>', 'categories.png' );
		JMenuBar::save();
		JMenuBar::apply();
		if ($cid[0]) {
			// for existing articles the button is renamed `close`
			JMenuBar::cancel( 'cancel', 'Close' );
		} else {
			JMenuBar::cancel();
		}
		JMenuBar::help( 'screen.categories.edit' );
	}

	/**
	* Draws the menu for Moving existing categories
	* @param int The published state (to display the inverse button)
	*/
	function _MOVE() {

		JMenuBar::title( JText::_( 'Move Category' ) );
		JMenuBar::save( 'movesave' );
		JMenuBar::cancel();
	}

	/**
	* Draws the menu for Copying existing categories
	* @param int The published state (to display the inverse button)
	*/
	function _COPY() {

		JMenuBar::title( JText::_( 'Copy Category' ) );
		JMenuBar::save( 'copysave' );
		JMenuBar::cancel();
	}

	/**
	* Draws the menu for Editing an existing category
	*/
	function _DEFAULT()
	{
		$section = JRequest::getVar( 'section' );

		JMenuBar::title( JText::_( 'Category Manager' ) .': <small><small>[ '. JText::_(JString::substr($section, 4)).' ]</small></small>', 'categories.png' );
		JMenuBar::publishList();
		JMenuBar::unpublishList();
		if ( $section == 'content' || ( $section > 0 ) ) {
			JMenuBar::customX( 'moveselect', 'move.png', 'move_f2.png', 'Move', true );
			JMenuBar::customX( 'copyselect', 'copy.png', 'copy_f2.png', 'Copy', true );
		}
		JMenuBar::deleteList();
		JMenuBar::editListX();
		JMenuBar::addNewX();
		JMenuBar::help( 'screen.categories' );
	}
}
?>