<?php
/**
* @version		$Id: view.html.php 6290 2007-01-16 04:06:06Z Jinx $
* @package		Joomla
* @subpackage	Registration
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
 * HTML View class for the Registration component
 *
 * @author		David Gal <david.gal@joomla.org>
 * @package		Joomla
 * @subpackage	Registration
 * @since 1.0
 */
class RegistrationViewLostpass extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		$breadcrumbs =& $mainframe->getPathWay();
		$breadcrumbs->addItem( JText::_( 'Lost your Password?' ));
		
		parent::display($tpl);
	}
}
?>