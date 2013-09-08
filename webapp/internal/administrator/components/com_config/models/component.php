<?php
/**
 * @version		$Id: component.php 6257 2007-01-11 22:03:46Z friesengeist $
 * @package		Joomla
 * @subpackage	Config
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport( 'joomla.application.component.model' );

/**
 * @package		Joomla
 * @subpackage	Config
 */
class ConfigModelComponent extends JModel
{
	/**
	 * Get the params for the configuration variables
	 */
	function &getParams()
	{
		static $instance;

		if ($instance == null)
		{
			$component	= JRequest::getVar( 'component' );

			$table =& JTable::getInstance('component');
			$table->loadByOption( $component );

			// work out file path
			if ($path = JRequest::getVar( 'path' )) {
				$path = JPath::clean( JPATH_SITE.DS.$path, false );
				JPath::check( $path );
			} else {
				$option	= preg_replace( '#\W#', '', $table->option );
				$path	= JPATH_ADMINISTRATOR . '/components/' . $option . '/config.xml';
			}

			if (file_exists( $path )) {
				$instance = new JParameter( $table->params, $path );
			} else {
				$instance = new JParameter( $table->params );
			}
		}
		return $instance;
	}
}
?>