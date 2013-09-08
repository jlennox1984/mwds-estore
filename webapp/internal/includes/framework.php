<?php
/**
* @version		$Id: framework.php 6138 2007-01-02 03:44:18Z eddiea $
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

/*
 * Joomla! system checks
 */

@set_magic_quotes_runtime( 0 );

if (!file_exists( JPATH_CONFIGURATION . DS . 'configuration.php' ) || (filesize( JPATH_CONFIGURATION . DS . 'configuration.php' ) < 10)) {
	header( 'Location: installation/index.php' );
	exit();
}

/*
 * Joomla! system startup
 */

// System includes
require_once( JPATH_LIBRARIES		. DS . 'loader.php' );
require_once( JPATH_CONFIGURATION	. DS . 'configuration.php' );

//clean the request
jimport( 'joomla.common.abstract.object' );
jimport( 'joomla.environment.request' );
// ALERT! DO NOT CALL JRequest::clean ANY LATER IN EXECUTION!
JRequest::clean();

// System configuration
$CONFIG = new JConfig();

if (@$CONFIG->error_reporting === 0) {
	error_reporting( 0 );
} else if (@$CONFIG->error_reporting > 0) {
	error_reporting( $CONFIG->error_reporting );
}

define( 'JDEBUG', $CONFIG->debug );

unset( $CONFIG );

/*
 * Joomla! framework loading
 */

// Include object abstract class
jimport( 'joomla.common.compat.compat' );

// System profiler
if (JDEBUG) {
	jimport( 'joomla.utilities.profiler' );
	$_PROFILER =& JProfiler::getInstance( 'Application' );
}

// Joomla! library imports;

jimport( 'joomla.environment.response'   );
jimport( 'joomla.application.application' );
jimport( 'joomla.application.event' );
jimport( 'joomla.application.plugin.helper' );
jimport( 'joomla.application.menu' );
jimport( 'joomla.database.table' );
jimport( 'joomla.user.user');
jimport( 'joomla.environment.uri' );
jimport( 'joomla.factory' );
jimport( 'joomla.html.html' );
jimport( 'joomla.utilities.array' );
jimport( 'joomla.utilities.error' );
jimport( 'joomla.utilities.functions' );
jimport( 'joomla.utilities.utility' );
jimport( 'joomla.utilities.string' );
jimport( 'joomla.version' );


JDEBUG ? $_PROFILER->mark( 'afterLoadFramework' ) : null;
?>