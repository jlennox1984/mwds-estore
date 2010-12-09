<?php
/**
* @version		$Id: framework.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Installation
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

/*
 * Joomla! system checks
 */

error_reporting( E_ALL );
@set_magic_quotes_runtime( 0 );

if (!file_exists( JPATH_CONFIGURATION . DS . 'configuration.php' ) || (filesize( JPATH_CONFIGURATION . DS . 'configuration.php' ) < 10)) {
	// TODO: Throw 500 error
	header( 'Location: ../installation/index.php' );
	exit();
}

/*
 * Joomla! system startup
 */

// System includes
require_once( JPATH_LIBRARIES		. DS . 'loader.php' );

// Clean the request before anything else is loaded
jimport( 'joomla.common.abstract.object' );
jimport( 'joomla.environment.request' );
// TODO: Check why there is a problem here
//JRequest::clean();

require_once( JPATH_LIBRARIES		. DS . 'loader.php' );

// File includes
define( 'JPATH_INCLUDES', dirname(__FILE__) );

/*
 * Joomla! framework loading
 */

// Include object abstract class
jimport( 'joomla.common.compat.compat' );

// Joomla! library imports
jimport( 'joomla.application.application' );
jimport( 'joomla.application.event' );
jimport( 'joomla.application.plugin.helper' );
jimport( 'joomla.database.table' );
jimport( 'joomla.environment.uri' );
jimport( 'joomla.user.user' );
jimport( 'joomla.factory' );
jimport( 'joomla.filesystem.*' );
jimport( 'joomla.i18n.language' );
jimport( 'joomla.utilities.string' );
jimport( 'joomla.utilities.error' );
?>