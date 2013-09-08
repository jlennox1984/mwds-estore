<?php
/**
* @version		$Id: toolbar.content.html.php 6257 2007-01-11 22:03:46Z friesengeist $
* @package		Joomla
* @subpackage	Content
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
* @subpackage	Content
*/
class TOOLBAR_content
{
	function _EDIT()
	{
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$cid = intval($cid[0]);

		$text = ( $cid ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JMenuBar::title( JText::_( 'Article' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );
		JMenuBar::preview( 'index.php?option=com_content&id='.$cid.'&tmpl=component', true );
		JMenuBar::save();
		JMenuBar::apply();
		if ( $cid ) {
			// for existing articles the button is renamed `close`
			JMenuBar::cancel( 'cancel', 'Close' );
		} else {
			JMenuBar::cancel();
		}
		JMenuBar::help( 'screen.content.edit' );
	}
/*
	function _ARCHIVE() {

		JMenuBar::title( JText::_( 'Archive Manager' ), 'addedit.png' );
		JMenuBar::unarchiveList();
		JMenuBar::custom( 'remove', 'delete.png', 'delete_f2.png', 'Trash', false );
		JMenuBar::help( 'screen.content.archive' );
	}
*/
	function _MOVE() {

		JMenuBar::title( JText::_( 'Move Articles' ), 'move_f2.png' );
		JMenuBar::custom( 'movesectsave', 'save.png', 'save_f2.png', 'Save', false );
		JMenuBar::cancel();
	}

	function _COPY() {

		JMenuBar::title( JText::_( 'Copy Articles' ), 'copy_f2.png' );
		JMenuBar::custom( 'copysave', 'save.png', 'save_f2.png', 'Save', false );
		JMenuBar::cancel();
	}

	function _DEFAULT() {
		global $filter_state;

		$user =& JFactory::getUser();

		JMenuBar::title( JText::_( 'Article Manager' ), 'addedit.png' );
		if ($filter_state == 'A' || $filter_state == NULL) {
			JMenuBar::unarchiveList();
		}
		if ($filter_state != 'A') {
			JMenuBar::archiveList();
		}
		JMenuBar::publishList();
		JMenuBar::unpublishList();
		JMenuBar::customX( 'movesect', 'move.png', 'move_f2.png', 'Move' );
		JMenuBar::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
		JMenuBar::trash();
		JMenuBar::editListX();
		JMenuBar::addNewX();
		if ($user->get('gid') == 25) {
			JMenuBar::configuration('com_content', '450');
		}
		JMenuBar::help( 'screen.content' );
	}
}
?>