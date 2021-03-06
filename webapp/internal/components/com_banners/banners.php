<?php
/**
 * @version		$Id: banners.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package  Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights
 * reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the com_content helper library
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new BannersController( array('default_task' => 'click') );

// Perform the Request task
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();
?>