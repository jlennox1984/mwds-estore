<?php
/**
* @version		$Id: module.php 6257 2007-01-11 22:03:46Z friesengeist $
* @package		Joomla.Framework
* @subpackage	Document
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * JDocument Module renderer
 *
 * @author		Johan Janssens <johan.janssens@joomla.org>
 * @package		Joomla.Framework
 * @subpackage	Document
 * @since		1.5
 */
class JDocumentRenderer_Module extends JDocumentRenderer
{
	/**
	 * Renders a module script and returns the results as a string
	 *
	 * @access public
	 * @param string 	$name		The name of the module to render
	 * @param array 	$params		Associative array of values
	 * @return string	The output of the script
	 */
	function render( $module, $params = array(), $content = null )
	{
		if (!is_object($module))
		{
			$module =& JModuleHelper::getModule($module);

			if (!is_object($module))
			{
				if (is_null($content)) {
					return '';
				}
				else
				{
					/**
					 * If module isn't found in the database but data has been pushed in the buffer
					 * we want to render it
					 */
					$tmp = $module;
					$module = new stdClass();
					$module->params = null;
					$module->module = $tmp;
					$module->id = 0;
					$module->user = 0;
				}
			}
		}

		// get the user and configuration object
		$user =& JFactory::getUser();
		$conf =& JFactory::getConfig();

		// set the module content
		if (!is_null($content)) {
			$module->content = $content;
		}

		//get module parameters
		$mod_params = new JParameter( $module->params );

		$cache =& JFactory::getCache( $module->module );

		$cache->setCaching( $mod_params->get( 'cache', 0 ) && $conf->getValue( 'config.caching' ) );
		$cache->setLifeTime( $mod_params->get( 'cache_time', $conf->getValue( 'config.cachetime' ) ) );
		$cache->setCacheValidation(true);

		return $cache->callId( "JModuleHelper::renderModule", array( $module, $params ), $module->id. $user->get('aid', 0) );
	}
}
?>
