<?php
/**
* @version		$Id: category.php 6138 2007-01-02 03:44:18Z eddiea $
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
 * Renders a category element
 *
 * @author 		Johan Janssens <johan.janssens@joomla.org>
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElement_Category extends JElement
{
   /**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Category';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db = &JFactory::getDBO();

		$section	= $node->attributes('section');
		$class		= $node->attributes('class');
		if (!$class) {
			$class = "inputbox";
		}

		if (!isset ($section)) {
			// alias for section
			$section = $node->attributes('scope');
			if (!isset ($section)) {
				$section = 'content';
			}
		}

		if ($section == 'content') {
			// This might get a conflict with the dynamic translation - TODO: search for better solution
			$query = "SELECT c.id, CONCAT_WS( '/',s.title, c.title ) AS title" .
				"\n FROM #__categories AS c" .
				"\n LEFT JOIN #__sections AS s ON s.id=c.section" .
				"\n WHERE c.published = 1" .
				"\n AND s.scope = '$section'" .
				"\n ORDER BY c.title";
		} else {
			$query = "SELECT c.id, c.title" .
				"\n FROM #__categories AS c" .
				"\n WHERE c.published = 1" .
				"\n AND c.section = '$section'" .
				"\n ORDER BY c.title";
		}
		$db->setQuery($query);
		$options = $db->loadObjectList();
		array_unshift($options, JHTMLSelect::option('0', '- '.JText::_('Select Category').' -', 'id', 'title'));

		return JHTMLSelect::genericList($options, ''.$control_name.'['.$name.']', 'class="'.$class.'"', 'id', 'title', $value, $control_name.$name );
	}
}
?>
