<?php
/**
* @version		$Id: admin.installer.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Installer
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize('com_installer', 'installer')) {
	$mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));
}

require_once( JPATH_COMPONENT.DS.'controller.php' );

$controller = new InstallerController( array('default_task' => 'installform') );
$controller->execute( JRequest::getVar('task') );
$controller->redirect();
?>