<?php
/**
* @version		$Id: hidden.php 6138 2007-01-02 03:44:18Z eddiea $
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
 * Renders a SQL element
 *
 * @author 		Sam Moffatt <sam.moffatt@joomla.org>
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElement_SQL extends JElement {
   /**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'SQL';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db			= & JFactory::getDBO();
		$db->setQuery($node->attributes('query'));
		return JHTMLSelect::genericList($db->loadObjectList(), ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', $name, $value, $control_name.$name);
	}
}
?>