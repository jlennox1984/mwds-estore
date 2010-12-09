<?php
/**
* @version		$Id: text.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Articles
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Renders a calendar element
 *
 * @author 		Louis Landry
 * @package 	Joomla
 * @subpackage	Articles
 * @since		1.5
 */
class JElement_Calendar extends JElement
{
   /**
	* Element name
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Calendar';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$format = ( $node->attributes('format') ? $node->attributes('format') : '%Y-%m-%d %H:%M:%S' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );

		return '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.htmlspecialchars($value).'" '.$class.' />'.
			   '<input name="reset" type="reset" class="button" onclick="return showCalendar(\''.$control_name.$name.'\', \'y-mm-dd\');" value="..." />';
	}
}
?>