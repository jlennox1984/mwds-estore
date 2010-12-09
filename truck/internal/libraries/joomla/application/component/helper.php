<?php
/**
* @version		$Id: helper.php 6226 2007-01-09 07:56:26Z louis $
* @package		Joomla.Framework
* @subpackage	Application
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
* Component helper class
*
* @static
* @author		Johan Janssens <johan.janssens@joomla.org>
* @package		Joomla.Framework
* @subpackage	Application
* @since		1.5
*/
class JComponentHelper
{
	/**
	 * Get the component info
	 *
	 * @access public
	 * @param string $name 	The component name
	 * @return object A JComponent object
	 */
	function &getInfo( $name )
	{
		static $instances;

		if (!isset( $instances[$name] ))
		{
			$db = &JFactory::getDBO();

			$query = 'SELECT *' .
					' FROM #__components' .
					' WHERE parent = 0';
			$db->setQuery( $query );
			$instances = $db->loadObjectList( 'option' );
		}

		if (isset( $instances[$name] ))
		{
			$result = &$instances[$name];
		}
		else
		{
			$result				= new stdClass();
			$result->enabled	= true;
			$result->params		= null;
		}

		return $result;
	}

	/**
	 * Checks if the component is enabled
	 *
	 * @access public
	 * @param string $name The component name
	 * @return boolean
	 */
	function isEnabled( $name )
	{
		global $mainframe;

		$component = &JComponentHelper::getInfo( $name );
		return ($component->enabled | $mainframe->isAdmin());
	}

	/**
	 * Gets the parameter object for the component
	 *
	 * @access public
	 * @param string $name The component name
	 * @return object A JParameter object
	 */
	function &getParams( $name )
	{
		static $instances;
		if (!isset( $instances[$name] ))
		{
			$component = &JComponentHelper::getInfo( $name );
			$instances[$name] = new JParameter($component->params);
		}
		return $instances[$name];
	}

	function renderComponent($name = null, $params = array())
	{
		global $mainframe, $option;

		if(empty($name)) {
			return;
		}

		$outline	= isset($params['outline']) ? $params['outline'] : false;
		$task		= JRequest::getVar( 'task' );

		// Build the component path
		$file = substr( $name, 4 );

		// Define component path
		define( 'JPATH_COMPONENT',					JPATH_BASE.DS.'components'.DS.$name);
		define( 'JPATH_COMPONENT_SITE',				JPATH_SITE.DS.'components'.DS.$name);
		define( 'JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR.DS.'components'.DS.$name);

		// get component path
		if ( $mainframe->isAdmin() && is_file(JPATH_COMPONENT.DS.'admin.'.$file.'.php') ) {
			$path = JPATH_COMPONENT.DS.'admin.'.$file.'.php';
		} else {
			$path = JPATH_COMPONENT.DS.$file.'.php';
		}

		// If component disabled throw error
		if (!JComponentHelper::isEnabled( $name ) || !file_exists($path)) {
			JError::raiseError( 404, JText::_('Component Not Found') );
		}

		// Handle legacy globals if enabled
		if ($mainframe->getCfg('legacy'))
		{
			// Include legacy globals
			global $my, $database, $id, $acl, $task;

			// For backwards compatibility extract the config vars as globals
			$registry =& JFactory::getConfig();
			foreach (get_object_vars($registry->toObject()) as $k => $v)
			{
				$varname = 'mosConfig_'.$k;
				$$varname = $v;
			}
			$contentConfig = &JComponentHelper::getParams( 'com_content' );
			foreach (get_object_vars($contentConfig->toObject()) as $k => $v)
			{
				$varname = 'mosConfig_'.$k;
				$$varname = $v;
			}
			$usersConfig = &JComponentHelper::getParams( 'com_users' );
			foreach (get_object_vars($usersConfig->toObject()) as $k => $v)
			{
				$varname = 'mosConfig_'.$k;
				$$varname = $v;
			}
		}

		// Load common language files
		$lang =& JFactory::getLanguage();
		$lang->load($name);

		// Handle template preview outlining
		$contents = null;
		if($outline && !$mainframe->isAdmin())
		{
			$doc	=& JFactory::getDocument();
			$css	= ".com-preview-info { padding: 2px 4px 2px 4px; border: 1px solid black; position: absolute; background-color: white; color: red;opacity: .80; filter: alpha(opacity=80); -moz-opactiy: .80; }";
			$css	.= ".com-preview-wrapper { background-color:#eee;  border: 1px dotted black; color:#700; opacity: .50; filter: alpha(opacity=50); -moz-opactiy: .50;}";
			$doc->addStyleDeclaration($css);

			$contents .= "
			<div class=\"com-preview\">
			<div class=\"com-preview-info\">".JText::_('Component')."[".$name."]</div>
			<div class=\"com-preview-wrapper\">";
		}

		// Execute the component
		ob_start();
		require_once $path;
		$contents = ob_get_contents();
		ob_end_clean();

		// Build the component toolbar
		jimport( 'joomla.application.helper' );
		if (($path = JApplicationHelper::getPath( 'toolbar' )) && $mainframe->isAdmin()) {
			require_once( JPATH_ADMINISTRATOR .'/includes/menubar.html.php' );
			include_once( $path );
		}

		// Close template preview outlining if enabled
		if($outline && !$mainframe->isAdmin()) {
			$contents .= "</div></div>";
		}

		return $contents;
	}
}
?>
