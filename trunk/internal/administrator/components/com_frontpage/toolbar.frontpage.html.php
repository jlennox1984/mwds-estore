<?php
/**
* @version		$Id: toolbar.frontpage.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Content
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

/**
* @package		Joomla
* @subpackage	Content
*/
class TOOLBAR_FrontPage
{
	function _DEFAULT() {

		JMenuBar::title( JText::_( 'Frontpage Manager' ), 'frontpage.png' );
		JMenuBar::archiveList();
		JMenuBar::publishList();
		JMenuBar::unpublishList();
		JMenuBar::custom('remove','delete.png','delete_f2.png','Remove', true);
		JMenuBar::help( 'screen.frontpage' );
	}
}
?>