<?php
/**
* @version		$Id: controller.php 6235 2007-01-10 08:04:47Z friesengeist $
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
 * Base class for a Joomla Controller
 *
 * Controller (controllers are where you put all the actual code) Provides basic
 * functionality, such as rendering views (aka displaying templates).
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Application
 * @author		Johan Janssens <johan.janssens@joomla.org>
 * @author		Louis Landry <louis.landry@joomla.org>
 * @author 		Andrew Eddie
 * @since		1.5
 */
class JController extends JObject
{
	/**
	 * The name of the controller
	 *
	 * @var		array
	 * @access protected
	 */
	var $_name = null;

	/**
	 * Array of class methods
	 *
	 * @var	array
	 * @access protected
	 */
	var $_methods 	= null;

	/**
	 * Array of class methods to call for a given task.
	 *
	 * @var	array
	 * @access protected
	 */
	var $_taskMap 	= null;

	/**
	 * Current or most recent task to be performed.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_task 		= null;

	/**
	 * The mapped task that was performed.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_doTask 	= null;

	/**
	 * The set of search directories for resources (views or models).
	 *
	 * @var array
	 * @access protected
	 */
	var $_path = array(
		'model'	=> array(),
		'view'	=> array()
	);

	/**
	 * URL for redirection.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_redirect 	= null;

	/**
	 * Redirect message.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_message 	= null;

	/**
	 * Redirect message type.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_messageType 	= null;

	/**
	 * ACO Section for the controller.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_acoSection 		= null;

	/**
	 * Default ACO Section value for the controller.
	 *
	 * @var	string
	 * @access protected
	 */
	var $_acoSectionValue 	= null;

	/**
	 * An error message.
	 *
	 * @var string
	 * @access protected
	 */
	var $_error;

	/**
	 * Constructor.
	 *
	 * @access	protected
	 * @param	array An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'default_task', 'model_path', and
	 * 'view_path' (this list is not meant to be comprehensive).
	 * @since	1.5
	 */
	function __construct( $config = array() )
	{
		//Initialize private variables
		$this->_redirect	= null;
		$this->_message		= null;
		$this->_messageType = 'message';
		$this->_taskMap		= array();
		$this->_methods		= array();
		$this->_data		= array();

		// Get the methods only for the final controller class
		$thisMethods	= get_class_methods( get_class( $this ) );
		$baseMethods	= get_class_methods( 'JController' );
		$methods		= array_diff( $thisMethods, $baseMethods );

		// Add default display method
		$methods[] = 'display';

		// Iterate through methods and map tasks
		foreach ( $methods as $method ) {
			if ( substr( $method, 0, 1 ) != '_' ) {
				$this->_methods[] = strtolower( $method );
				// auto register public methods as tasks
				$this->_taskMap[strtolower( $method )] = $method;
			}
		}

		//Set the controller name
		if ( empty( $this->_name ) )
		{
			if ( isset( $config['name'] ) )
			{
				$this->_name = $config['name'];
			}
			else
			{
				$r = null;
				if ( !preg_match( '/(.*)Controller/i', get_class( $this ), $r ) ) {
					JError::raiseError(
						500, JText::_(
							'JController::__construct() :'
							.' Can\'t get or parse class name.'
						)
					);
				}
				$this->_name = strtolower( $r[1] );
			}
		}

		// If the default task is set, register it as such
		if ( isset( $config['default_task'] ) ) {
			$this->registerDefaultTask( $config['default_task'] );
		} else {
			$this->registerDefaultTask( 'display' );
		}

		// set the default model search path
		if ( isset( $config['model_path'] ) ) {
			// user-defined dirs
			$this->_setPath( 'model', $config['model_path'] );
		} else {
			$this->_setPath( 'model', null );
		}

		// set the default view search path
		if ( isset( $config['view_path'] ) ) {
			// user-defined dirs
			$this->_setPath( 'view', $config['view_path'] );
		} else {
			$this->_setPath( 'view', null );
		}
	}

	/**
	 * Execute a task by triggering a method in the derived class.
	 *
	 * @access	public
	 * @param	string The task to perform. If no matching task is found, the
	 * '__default' task is executed, if defined.
	 * @return	mixed|false The value returned by the called method, false in
	 * error case.
	 * @since	1.5
	 */
	function execute( $task )
	{
		$this->_task = $task;

		$task = strtolower( $task );
		if (isset( $this->_taskMap[$task] ))
		{
			// We have a method in the map to this task
			$doTask = $this->_taskMap[$task];
		}
		else if (isset( $this->_taskMap['__default'] ))
		{
			// Didn't find the method, but we do have a default method
			$doTask = $this->_taskMap['__default'];
		}
		else
		{
			// Don't have a default method either...
			return JError::raiseError( 404, JText::_('Task ['.$task.'] not found') );
		}

		// Record the actual task being fired
		$this->_doTask = $doTask;

		// Time to make sure we have access to do what we want to do...
		if ($this->authorize( $doTask ))
		{
			// Yep, lets do it already
			return $this->$doTask();
		}
		else
		{
			// No access... better luck next time
			return JError::raiseError( 403, JText::_('Access Forbidden') );
		}
	}

	/**
	 * Authorization check
	 *
	 * @access	public
	 * @param	string	$task	The ACO Section Value to check access on
	 * @return	boolean	True if authorized
	 * @since	1.5
	 */
	function authorize( $task )
	{
		// Only do access check if the aco section is set
		if ($this->_acoSection)
		{
			// If we have a section value set that trumps the passed task ???
			if ($this->_acoSectionValue)
			{
				// We have one, so set it and lets do the check
				$task = $this->_acoSectionValue;
			}
			// Get the JUser object for the current user and return the authorization boolean
			$user = & JFactory::getUser();
			return $user->authorize( $this->_acoSection, $task );
		}
		else
		{
			// Nothing set, nothing to check... so obviously its ok :)
			return true;
		}
	}

	/**
	 * Typical view method for MVC based architecture
	 *
	 */
	function display()
	{
		$document =& JFactory::getDocument();

		$viewType	= $document->getType();
		$viewName	= JRequest::getVar( 'view', $this->_name );
		$viewLayout = JRequest::getVar( 'layout', 'default' );

		$view = & $this->getView( $viewName, $viewType);

		// Get/Create the model
		if ($model = & $this->getModel($viewName))
		{
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}

		// Set the layout
		$view->setLayout($viewLayout);

		// Display the view
		$view->display();
	}

	/**
	 * Redirects the browser or returns false if no redirect is set.
	 *
	 * @access	public
	 * @return	boolean	False if no redirect exists.
	 * @since	1.5
	 */
	function redirect()
	{
		if ($this->_redirect) {
			global $mainframe;
			$mainframe->redirect( $this->_redirect, $this->_message, $this->_messageType );
		}
		return false;
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @access	public
	 * @param	string	The model name.
	 * @param	string	The class prefix. Optional.
	 * @return	object	The model.
	 * @since	1.5
	 */
	function &getModel( $name, $prefix = '' )
	{
		global $Itemid;

		if ( empty( $prefix ) ) {
			$prefix = $this->_name . 'Model';
		}

		if ( $model = & $this->_createModel( $name, $prefix ) )
		{
			// task is a reserved state
			$model->setState( 'task', $this->_task );

			// Get menu item information if Itemid exists
			if ( isset( $Itemid ) )
			{
				$menu		= & JMenu::getInstance();
				$item		= & $menu->getItem( $Itemid );
				$params		= new JParameter( $item->params );

				// Set Default State Data
				$model->setState( 'parameters.menu', $params );
			}
		}
		return $model;
	}

	/**
	 * Adds to the stack of controller model paths in LIFO order.
	 *
	 * @static
	 * @param string|array The directory (string), or list of directories
	 * (array) to add.
	 * @return void
	 */
	function addModelPath( $path )
	{
		$this->_addPath( 'model', $path );
	}

	/**
	 * Gets the available tasks in the controller.
	 * @access	public
	 * @return	array Array[i] of task names.
	 * @since	1.5
	 */
	function getTasks()
	{
		return $this->_methods;
	}

	/**
	 * Get the last task that is or was to be performed.
	 *
	 * @access	public
	 * @return  string The task that was or is being performed.
	 * @since	1.5
	 */
	function getTask()
	{
		return $this->_task;
	}

	/**
	 * Method to get a reference to the current view and load it if necessary.
	 *
	 * @access	public
	 * @param 	string	The view name. Optional, defaults to the controller
	 * name.
	 * @param 	string	The view type. Optional.
	 * @param 	string	The class prefix. Optional.
	 * @return	object	Reference to the view or an error.
	 * @since	1.5
	 */
	function &getView( $name = '', $type = '', $prefix = '' )
	{
		static $views;

		if ( !isset( $views ) ) {
			$views = array();
		}

		if ( empty( $name ) ) {
			$name = $this->_name;
		}

		if ( empty( $prefix ) ) {
			$prefix = $this->_name . 'View';
		}

		if ( empty( $views[$name] ) )
		{
			if ( $view = & $this->_createView( $name, $prefix, $type ) )
			{
				$views[$name] = & $view;
			}
			else
			{
				$result = JError::raiseError(
					500, JText::_( 'View not found [name, type, prefix]:' )
						. ' ' . $name . ',' . $type . ',' . $prefix
				);
				return $result;
			}
		}

		return $views[$name];
	}

	/**
	 * Add one or more view paths to the controller's stack, in LIFO order.
	 *
	 * @static
	 * @param string|array The directory (string), or list of directories
	 * (array) to add.
	 * @return void
	 */
	function addViewPath( $path )
	{
		$this->_addPath( 'view', $path );
	}

	/**
	 * Register (map) a task to a method in the class.
	 *
	 * @access	public
	 * @param	string	The task.
	 * @param	string	The name of the method in the derived class to perform
	 * for this task.
	 * @return	void
	 * @since	1.5
	 */
	function registerTask( $task, $method )
	{
		if ( in_array( strtolower( $method ), $this->_methods ) ) {
			$this->_taskMap[strtolower( $task )] = $method;
		} else {
			JError::raiseError( 404, JText::_( 'Method not found:' ) . $method );
		}
	}


	/**
	 * Register the default task to perform if a mapping is not found.
	 *
	 * @access	public
	 * @param	string The name of the method in the derived class to perform if
	 * a named task is not found.
	 * @return	void
	 * @since	1.5
	 */
	function registerDefaultTask( $method )
	{
		$this->registerTask( '__default', $method );
	}

	/**
	 * Get the error message.
	 * @return string The error message.
	 * @since 1.5
	 */
	function getError() {
		return $this->_error;
	}

	/**
	 * Set the error message.
	 * @param string The error message.
	 * @return string The new error message.
	 * @since 1.5
	 */
	function setError( $message )
	{
		$this->_error = $message;
		return $this->_error;
	}

	/**
	 * Sets the internal message that is passed with a redirect
	 * @param	string	The message
	 */
	function setMessage( $text )
	{
		$this->_message = $text;
	}

	/**
	 * Set a URL for browser redirection.
	 *
	 * @access	public
	 * @param	string URL to redirect to.
	 * @param	string	Message to display on redirect. Optional, defaults to
	 * value set internally by controller, if any.
	 * @param	string	Message type. Optional, defaults to 'message'.
	 * @return	void
	 * @since	1.5
	 */
	function setRedirect( $url, $msg = null, $type = 'message' )
	{
		$this->_redirect = $url;
		if ( $msg !== null )
		{
			// controller may have set this directly
			$this->_message	= $msg;
		}
		$this->_messageType	= $type;
	}

	/**
	 * Sets the access control levels.
	 *
	 * @access	public
	 * @param string The ACO section (eg, the component).
	 * @param string The ACO section value (if using a constant value).
	 * @return	void
	 * @since	1.5
	 */
	function setAccessControl( $section, $value = null )
	{
		$this->_acoSection = $section;
		$this->_acoSectionValue = $value;
	}

	/**
	 * Method to load and return a model object.
	 *
	 * @access	private
	 * @param	string  The name of the model.
	 * @param	string	Optional model prefix.
	 * @return	mixed	Model object on success; error object or null on
	 * failure.
	 * @since	1.5
	 */
	function &_createModel( $name, $prefix = '')
	{
		$result = null;

		// Clean the model name
		$modelName		= preg_replace( '#\W#', '', $name );
		$classPrefix	= preg_replace( '#\W#', '', $prefix );

		// Build the model class name
		$modelClass = $classPrefix . $modelName;

		if ( !class_exists( $modelClass ) )
		{
			jimport( 'joomla.filesystem.path' );
			$path = JPath::find(
				$this->_path['model'],
				$this->_createFileName( 'model', array( 'name' => $modelName ) )
			);
			if ( $path )
			{
				require $path;
				if ( !class_exists( $modelClass ) )
				{
					$result = JError::raiseWarning(
						0,
						JText::_( 'Model class not found [class, file]:' )
						. ' ' . $modelClass . ', ' . $path
					);
					return $result;
				}
			}
			else
			{
				return $result;
			}
		}

		$result = new $modelClass();
		return $result;
	}

	/**
	 * Method to load and return a view object. This method first looks in the
	 * current template directory for a match, and failing that uses a default
	 * set path to load the view class file.
	 *
	 * Note the "name, prefix, type" order of parameters, which differs from the
	 * "name, type, prefix" order used in related public methods.
	 *
	 * @access	private
	 * @param	string	The name of the view.
	 * @param	string	Optional prefix for the view class name.
	 * @return	mixed	View object on success; null or error result on failure.
	 * @since	1.5
	 */
	function &_createView( $name, $prefix = '', $type = '' )
	{
		$result = null;

		// Clean the view name
		$viewName	 = preg_replace( '#\W#', '', $name );
		$classPrefix = preg_replace( '#\W#', '', $prefix );
		$viewType	 = preg_replace( '#\W#', '', $type );

		// Build the view class name
		$viewClass = $classPrefix . $viewName;

		if ( !class_exists( $viewClass ) )
		{
			jimport( 'joomla.filesystem.path' );
			$path = JPath::find(
				$this->_path['view'],
				$this->_createFileName(
					'view', array( 'name' => $viewName, 'type' => $viewType) )
			);
			if ( $path )
			{
				require_once $path;

				if ( !class_exists( $viewClass ) )
				{
					$result = JError::raiseError(
						500, JText::_( 'View class not found [class, file]:' )
						. ' ' . $viewClass . ', ' . $path );
					return $result;
				}
			}
			else
			{
				return $result;
			}
		}

		$result = new $viewClass();
		return $result;
	}

   /**
	* Sets an entire array of search paths for resources.
	*
	* @access protected
	* @param	string	The type of path to set, typically 'view' or 'model'.
	* @param	string|array	The new set of search paths. If null or false,
	* resets to the current directory only.
	*/
	function _setPath( $type, $path )
	{
		// clear out the prior search dirs
		$this->_path[$type] = array();

		// always add the fallback directories as last resort
		switch ( strtolower($type) )
		{
			case 'view': {
				// the current directory
				$this->_addPath( $type, JPATH_COMPONENT . DS . 'views' );
			}
			break;

			case 'model': {
				// the current directory
				$this->_addPath( $type, JPATH_COMPONENT . DS . 'models' );
			}
			break;
		}

		// actually add the user-specified directories
		$this->_addPath( $type, $path );
	}

   /**
	* Adds to the search path for templates and resources.
	*
	* @access protected
	* @param string The path type (e.g. 'model', 'view'.
	* @param string|array The directory or stream to search.
	* @return void
	*/
	function _addPath( $type, $path )
	{
		// just force path to array
		settype( $path, 'array' );

		// loop through the path directories
		foreach ( $path as $dir )
		{
			// no surrounding spaces allowed!
			$dir = trim( $dir );

			// add trailing separators as needed
			if ( substr( $dir, -1 ) != DIRECTORY_SEPARATOR ) {
				// directory
				$dir .= DIRECTORY_SEPARATOR;
			}

			// add to the top of the search dirs
			array_unshift( $this->_path[$type], $dir );
		}
	}

	/**
	 * Create the filename for a resource.
	 *
	 * @access	private
	 * @param	string	The resource type to create the filename for.
	 * @param	array	An associative array of filename information. Optional.
	 * @return	string	The filename.
	 * @since 1.5
	 */
	function _createFileName( $type, $parts = array() )
	{
		$filename = '';

		switch ( $type )
		{
			case 'view' :
			{
				if ( !empty( $parts['type'] ) ) {
					$parts['type'] = '.' . $parts['type'];
				}

				$filename = strtolower( $parts['name'] ) . DS . 'view'
					. $parts['type'] . '.php';
			}
			break;

			case 'model' : {
				 $filename = strtolower( $parts['name'] ) . '.php';
			}
			break;

		}

		return $filename;
	}

}
?>
