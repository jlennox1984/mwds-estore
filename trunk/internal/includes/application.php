<?php
/**
* @version		$Id: application.php 6257 2007-01-11 22:03:46Z friesengeist $
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

jimport('joomla.application.component.helper');

/**
* Joomla! Application class
*
* Provide many supporting API functions
*
* @package		Joomla
* @final
*/
class JSite extends JApplication
{
	/**
	 * The pathway store (for breadcrumb generation).
	 *
	 * @var object  JPathWay object
	 * @access protected
	 */
	var $_pathway = null;

	/**
	* Class constructor
	*
	* @access protected
	* @param integer A client id
	*/
	function __construct()
	{
		parent::__construct(0);
	}

	/**
	* Initialise the application.
	*
	* @access public
	*/
	function initialise( $options = array())
	{
		// if a language was specified it has priority
		// otherwise use user or default language settings
		if (empty($options['language'])) {
			$user = & JFactory::getUser();
			$options['language'] = $user->getParam( 'language', $this->getCfg('lang_site') );
		}

		//One last check to make sure we have something
		if (empty($options['language'])) {
			$options['language'] = 'en-GB';
		}

		$config = & JFactory::getConfig();
		if ($config->getValue('config.legacy')) {
			jimport('joomla.common.legacy');
		}

		parent::initialise($options);
	}

	/**
	* Execute the application
	*
	* @access public
	*/
	function execute($component)
	{
		// Build the application pathway
		$this->_createPathWay();

		$document =& JFactory::getDocument();

		switch($document->getType())
		{
			case 'html':
				//set metadata
				$document->setMetaData( 'keywords', $this->getCfg('MetaKeys') );

				$user =& JFactory::getUser();
				if ( $user->get('id') ) {
					$document->addScript( 'includes/js/joomla/common.js');
					$document->addScript( 'includes/js/joomla.javascript.js');
				}
				break;

			default: break;
		}


		$document->setTitle( $this->getCfg('sitename' ));
		$document->setDescription( $this->getCfg('MetaDesc') );

		$contents = JComponentHelper::renderComponent($component, array('outline' => JRequest::getVar('tp', 0 )));
		$document->setBuffer( $contents, 'component');
	}

	/**
	* Display the application.
	*
	* @access public
	*/
	function display( $component )
	{
		$template	= JRequest::getVar( 'template', $this->getTemplate(), 'default', 'string' );
		$file 		= JRequest::getVar( 'tmpl', 'index', '', 'string'  );

		$user =& JFactory::getUser();
		
		if ($this->getCfg('offline') && $user->get('gid') < '23' ) {
			$file = 'offline';
		}

		$params = array(
			'template' 	=> $template,
			'file'		=> $file.'.php',
			'directory'	=> JPATH_BASE.DS.'templates',
			'outline' => JRequest::getVar('tp', 0 )
		);

		$document =& JFactory::getDocument();
		$document->display( $this->getCfg('caching_tmpl'), $params);
	}

   /**
	* Check if the user can access the application
	*
	* @access public
	*/
	function authorize($itemid)
	{
		//TODO :: should we show a login screen here ?
		$menus =& JMenu::getInstance();
		if(!$menus->authorize($itemid, JFactory::getUser())) {
			JError::raiseError( 403, JText::_('Not Authorised') );
		}
	}

	/**
	* Login authentication function
	*
	* @param string The username
	* @param string The password
	* @access public
	* @see JApplication::login
	*/
	function login($username=null, $password=null, $remember=null)
	{
		$username = trim( JRequest::getVar( 'username', $username, 'post' ) );
		$password = trim( JRequest::getVar( 'passwd', $password, 'post' ) );
		$remember = JRequest::getVar( 'remember', $remember, 'post' );

		return parent::login($username, $password, $remember);
	}

	/**
	* Logout authentication function
	*
	* @access public
	* @see JApplication::login
	*/
	function logout($return = null) {
		return parent::logout();
	}

	/**
	* Set Page Title
	*
	* @param string $title The title for the page
	* @since 1.5
	*/
	function setPageTitle( $title=null ) {

		$site = $this->getCfg('sitename');

		if($this->getCfg('offline')) {
			$site .= ' [Offline]';
		}

		$document=& JFactory::getDocument();
		$document->setTitle( $site.' - '.$title);
	}

	/**
	* Get Page title
	*
	* @return string The page title
	* @since 1.5
	*/
	function getPageTitle()
	{
		$document=& JFactory::getDocument();
		return $document->getTitle();
	}

	/**
	 * Set the configuration
	 *
	 * @access public
	 * @param string	The path to the configuration file
	 * @param string	The type of the configuration file
	 * @since 1.5
	 */
	function loadConfiguration($file, $type = 'config')
	{
		parent::loadConfiguration($file, $type);

		$registry =& JFactory::getConfig();
		$registry->setValue('config.live_site', substr_replace(JURI::base(), '', -1, 1));
		$registry->setValue('config.absolute_path', JPATH_SITE);


		// Create the JConfig object
		$config = new JConfig();

		if ( $config->legacy == 1 )
		{
			//Insert configuration values into global scope (for backwards compatibility)
			foreach (get_object_vars($config) as $k => $v) {
				$name = 'mosConfig_'.$k;
				$GLOBALS[$name] = $v;
			}
			$GLOBALS['mosConfig_live_site']		= substr_replace(JURI::base(), '', -1, 1);
			$GLOBALS['mosConfig_absolute_path']	= JPATH_SITE;
		}
	}

	/**
	* Get the template
	*
	* @return string The template name
	* @since 1.0
	*/
	function getTemplate()
	{
		global $Itemid;

		static $templates;

		if (!isset ($templates))
		{
			$templates = array();

			// Load template entries for each menuid
			$db =& JFactory::getDBO();
			$query = "SELECT template, menuid"
				. "\n FROM #__templates_menu"
				. "\n WHERE client_id = 0"
				;
			$db->setQuery( $query );
			$templates = $db->loadObjectList('menuid');
		}

		if ($template = $this->getUserState( 'setTemplate' ))
		{
			// ok, allows for an override of the template from a component
			// eg, $mainframe->setTemplate( 'solar-flare-ii' );
		}
		else if (!empty($Itemid) && (isset($templates[$Itemid]))) {
			$template = $templates[$Itemid];
		} else {
			$template = $templates[0];
		}

		return $template->template;
	}

	/**
	 * Overrides the default template that would be used
	 *
	 * @param string The template name
	 */
	function setTemplate( $template )
	{
		if (is_dir( JPATH_SITE . '/templates/' . $template )) {
			$this->setUserState( 'setTemplate', $template );
		}
	}

	/**
	 * Return a reference to the JPathWay object.
	 *
	 * @access public
	 * @return object JPathway.
	 * @since 1.5
	 */
	function &getPathWay()
	{
		return $this->_pathway;
	}

	/**
	 * Create a JPathWay object and set the home/component items of the pathway.
	 *
	 * @access private
	 * @return object JPathway.
	 * @since 1.5
	 */
	function &_createPathWay()
	{
		global $option, $Itemid;

		//Load the pathway object
		jimport( 'joomla.application.pathway' );

		// Create a JPathWay object
		$this->_pathway = new JPathWay();

		// Initialize variables
		$IIDstring = null;

		// Add the home item to the pathway
		$this->_pathway->addItem( JText::_('Home'), 'index.php' );

		// Get the actual component name
		if (substr($option, 0, 4) == 'com_') {
			$comName = substr($option, 4);
		} else {
			$comName = $option;
		}
		// Handle the ItemID
		if ($Itemid) {
			$IIDstring = '&Itemid='.$Itemid;
		}

		$this->_pathway->addItem( $comName, 'index.php?option='.$option.$IIDstring);

		return $this->_pathway;
	}
}

/**
 * @package		Joomla
 * @static
 */
class JSiteHelper
{
	/**
	 * Gets the current menu item
	 *
	 * @static
	 * @return	object	Reference to the current menu item, an an empty menu object if none set
	 * @since	1.5
	 */
	function &getActiveMenuItem()
	{
		global $Itemid;
		$menu	= &JMenu::getInstance();
		$result = &$menu->getItem( $Itemid );
		return $result;
	}

	/**
	 * Gets the parameter object for the current menu
	 *
	 * @static
	 * @return	object	A JParameter object
	 * @since	1.5
	 */
	function &getMenuParams()
	{
		$item = &JSiteHelper::getActiveMenuItem();
		$params = new JParameter( $item->params );
		return $params;
	}

	/**
	 * Return the application itemid
	 *
	 * @access public
	 * @return string Option
	 * @since 1.5
	 */
	function findItemid()
	{
		$itemid = JRequest::getVar( 'Itemid', 0, '', 'int' );
		$option = strtolower(JRequest::getVar('option', null));

		$menus =& JMenu::getInstance();
		if(!is_object($menus->getItem($itemid)) || $itemid === 0)
		{
			$item	=& $menus->getDefault();
			$itemid	= $item->id;
		}

		return JRequest::setVar( 'Itemid', $itemid );
	}

	/**
	 * Return the application option string [main component]
	 *
	 * @access public
	 * @return string Option
	 * @since 1.5
	 */
	function findOption()
	{
		$option = strtolower(JRequest::getVar('option', null));

		if(empty($option))
		{
			$menu =& JMenu::getInstance();
			$item =& $menu->getItem(JSiteHelper::findItemid());

			$component =& JTable::getInstance( 'component');
			$component->load($item->componentid);

			$option = $component->option;

			// Lets set any request variables from the menu item url
			$parts = parse_url($item->link);
			if ($parts['query']) {
				$vars = array();
				parse_str($parts['query'], $vars);
				foreach ($vars as $k => $v) {
					JRequest::setVar($k, $v);
				}
			}
		}

		//provide backwards compatibility for frontpage component
		if($option == 'com_frontpage') {
			$option = 'com_content';
			JRequest::setVar('task', 'frontpage');
		}

		return JRequest::setVar('option', $option);
	}
}
?>