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

require_once( JPATH_COMPONENT.DS.'views'.DS.'component'.DS.'view.php' );

/**
 * Note: this view is intended only to be opened in a popup
 * @package		Joomla
 * @subpackage	Config
 */
class ConfigControllerComponent extends JController
{
	/**
	 * Custom Constructor
	 */
	function __construct( $default = array())
	{
		$default['default_task'] = 'edit';
		parent::__construct( $default );

		$this->registerTask( 'apply', 'save' );
	}

	/**
	 * Show the configuration edit form
	 * @param string The URL option
	 */
	function edit()
	{
		JRequest::setVar('tmpl', 'component'); //force the component template
		$component = JRequest::getVar( 'component' );

		if (empty( $component ))
		{
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}

		$model = $this->getModel('Component' );
		$table =& JTable::getInstance('component');

		if (!$table->loadByOption( $component ))
		{
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}

		$view = new ConfigViewComponent( );
		$view->assignRef('component', $table);
		$view->setModel( $model, true );
		$view->display();
	}

	/**
	 * Save the configuration
	 */
	function save()
	{
		$component = JRequest::getVar( 'component' );

		$table =& JTable::getInstance('component');
		if (!$table->loadByOption( $component ))
		{
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}

		$post = JRequest::get( 'post' );
		$post['option'] = $component;
		$table->bind( $post );

		// pre-save checks
		if (!$table->check()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		// save the changes
		if (!$table->store()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		//$this->setRedirect( 'index.php?option=com_config', $msg );
		$this->edit();
	}

	/**
	 * Cancel operation
	 */
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}
}
?>