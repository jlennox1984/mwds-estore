<?php
/**
* @version		$Id: view.html.php 6289 2007-01-16 03:00:10Z Jinx $
* @package		Joomla
* @subpackage	Weblinks
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class UserViewUser extends JView
{
	function display( $tpl = null)
	{
		global $mainframe, $Itemid;
		
		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		$user =& JFactory::getUser();

		$pathway =& $mainframe->getPathWay();

		// Get the paramaters of the active menu item
		$menus	= &JMenu::getInstance();
		$menu	= $menus->getItem($Itemid);

		// Add breadcrumb
		$pathway->setItemName(1, 'User');
		$pathway->addItem( $menu->name, '' );
		
		$this->assignRef('user'   , $user);
		
		parent::display($tpl);
	}
	
	function _displayForm($tpl = null)
	{
		global $mainframe, $Itemid;
		
		$user =& JFactory::getUser();
		
		// Get the paramaters of the active menu item
		$menus	= &JMenu::getInstance();
		$menu	= $menus->getItem($Itemid);
		
		// Set page title
		$mainframe->setPageTitle( $menu->name );

		// check to see if Frontend User Params have been enabled
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		$check = $usersConfig->get('frontend_userparams');
		
		if ($check == '1' || $check == 1 || $check == NULL) 
		{
			$params = $user->getParameters();
			if( $user->authorize( 'mydetails', 'manage' ) ){
				$params->loadSetupFile(JPATH_ADMINISTRATOR . '/components/com_users/users.xml');
			} else if ( $user->authorize( 'mydetails', 'author' ) ){
				$params->loadSetupFile(JPATH_ADMINISTRATOR . '/components/com_users/users_author.xml');
			} else if ( $user->authorize( 'mydetails', 'registered' ) ){
				$params->loadSetupFile(JPATH_ADMINISTRATOR . '/components/com_users/users_registered.xml');
			}
		}

		$this->assignRef('user'  , $user);
		$this->assignRef('params', $params);
		
		parent::display($tpl);
	}
}
?>