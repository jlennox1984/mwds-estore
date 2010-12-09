<?php
/**
* @version		$Id: admin.login.php 6227 2007-01-09 10:28:41Z louis $
* @package		Joomla
* @subpackage	Joomla.Extensions
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

switch ( JRequest::getVar('task'))
{
	case 'login' :
		LoginController::login();
		break;

	case 'logout' :
		LoginController::logout();
		break;

	default :
		LoginController::display();
		break;
}


/**
 * Static class to hold controller functions for the Login component
 *
 * @static
 * @author		Johan Janssens <johan.janssens@joomla.org>
 * @package		Joomla
 * @subpackage	Login
 * @since		1.5
 */

class LoginController
{
	function display()
	{
		global $mainframe, $Itemid, $option;

		$document =& JFactory::getDocument();
		echo $document->getBuffer('module', 'login', array('style' => 'rounded', 'id' => 'section-box'));
	}

	function login()
	{
		global $mainframe;

		$username	= JRequest::getVar( 'username' );
		$password	= JRequest::getVar( 'password' );

		$result = $mainframe->login($username, $password);

		if (!JError::isError($result)) {
			$mainframe->redirect('index.php');
		}

		LoginController::display();
	}

	function logout()
	{
		global $mainframe;

		$result = $mainframe->logout();

		if (!JError::isError($result)) {
			$mainframe->redirect('index.php');
		}

		LoginController::display();
	}
}