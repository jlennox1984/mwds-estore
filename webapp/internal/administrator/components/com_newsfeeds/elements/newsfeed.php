<?php
/**
* @version		$Id: newsfeed.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Renders a newsfeed selection element
 *
 * @author 		Andrew Eddie <andrew.eddie@jamboworks.com>
 * @package 	Newsfeeds
 * @subpackage		Parameter
 * @since		1.5
 */

class JElement_Newsfeed extends JElement
{
   /**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Newsfeed';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();

		$query = "SELECT a.id, c.title, a.name"
		. "\n FROM #__newsfeeds AS a"
		. "\n INNER JOIN #__categories AS c ON a.catid = c.id"
		. "\n WHERE a.published = 1"
		. "\n ORDER BY a.catid, a.name"
		;
		$db->setQuery( $query );
		$options = $db->loadObjectList( );

		$n = count( $options );
		for ($i = 0; $i < $n; $i++)
		{
			$options[$i]->text = $options[$i]->title . '-' . $options[$i]->name;
		}

		array_unshift($options, JHTMLSelect::option('0', '- '.JText::_('Select Feed').' -', 'id', 'text'));

		return JHTMLSelect::genericList($options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'text', $value, $control_name.$name );
	}
}
?>