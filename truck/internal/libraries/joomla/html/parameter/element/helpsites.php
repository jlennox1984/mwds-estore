<?php
/**
* @version		$Id: helpsites.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Renders a helpsites element
 *
 * @author 		Johan Janssens <johan.janssens@joomla.org>
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElement_Helpsites extends JElement
{
   /**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Helpsites';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport('joomla.i18n.help');

		$helpsites 				= JHelp::createSiteList(JPATH_ADMINISTRATOR.DS.'help'.DS.'helpsites-15.xml', $value);
		array_unshift($helpsites, JHTMLSelect::option('', JText::_('local')));

		return JHTMLSelect::genericList($helpsites, ''.$control_name.'['.$name.']', ' class="inputbox"', 'value', 'text', $value, $control_name.$name );
	}
}
?>
