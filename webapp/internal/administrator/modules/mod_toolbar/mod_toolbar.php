<?php
/**
* @version		$Id: mod_toolbar.php 6138 2007-01-02 03:44:18Z eddiea $
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

//Import the JToolBar library
jimport('joomla.html.toolbar');

// Get the JComponent instance of JToolBar
$bar = & JToolBar::getInstance('JComponent');

// Render the toolbar
echo $bar->render('JComponent');
?>