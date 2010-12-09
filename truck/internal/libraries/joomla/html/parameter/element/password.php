<?php
/**
* @version		$Id: password.php 6138 2007-01-02 03:44:18Z eddiea $
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
 * Renders a password element
 *
 * @author 		Louis Landry <louis.landry@joomla.org>
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElement_Password extends JElement {
   /**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Password';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="text_area"' );

		return '<input type="password" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" '.$class.' '.$size.' />';
	}
}
?>
