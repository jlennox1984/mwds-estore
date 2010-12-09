<?php
/**
* @version		$Id: toolbar.messages.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Messages
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

/**
* @package		Joomla
* @subpackage	Messages
*/
class TOOLBAR_messages
{
	function _VIEW() {

		JMenuBar::title(  JText::_( 'View Private Message' ), 'inbox.png' );
		JMenuBar::customX('reply', 'restore.png', 'restore_f2.png', 'Reply', false );
		JMenuBar::deleteList();
		JMenuBar::cancel();
	}

	function _EDIT() {

		JMenuBar::title(  JText::_( 'Write Private Message' ), 'inbox.png' );
		JMenuBar::save( 'save', 'Send' );
		JMenuBar::cancel();
		JMenuBar::help( 'screen.messages.edit' );
	}

	function _CONFIG() {
		JMenuBar::title(  JText::_( 'Private Messaging Configuration' ), 'inbox.png' );
		JMenuBar::save( 'saveconfig' );
		JMenuBar::cancel( 'cancelconfig' );
		JMenuBar::help( 'screen.messages.conf' );
	}

	function _DEFAULT() {
		JMenuBar::title(  JText::_( 'Private Messaging' ), 'inbox.png' );
		JMenuBar::deleteList();
		JMenuBar::addNewX();
		JMenuBar::custom('config', 'config.png', 'config_f2.png', 'Settings', false, false);
		JMenuBar::help( 'screen.messages.inbox' );
	}
}
?>