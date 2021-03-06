<?php
/**
* @version		$Id: mod_unread.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
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

$db =& JFactory::getDBO();
$query = "SELECT COUNT(*)"
. "\n FROM #__messages"
. "\n WHERE state = 0"
. "\n AND user_id_to = " .$user->get('id')
;
$db->setQuery( $query );
$unread = $db->loadResult();

if ($unread) {
	echo "<a href=\"index.php?option=com_messages\" style=\"color: red; text-decoration: none;  font-weight: bold\">$unread <img src=\"images/mail.png\" align=\"middle\" border=\"0\" alt=\"". JText::_( 'Mail' ) ."\" /></a>";
} else {
	echo "<a href=\"index.php?option=com_messages\" style=\"color: black; text-decoration: none;\">$unread <img src=\"images/nomail.png\" align=\"middle\" border=\"0\" alt=\"". JText::_( 'Mail' ) ."\" /></a>";
}
?>