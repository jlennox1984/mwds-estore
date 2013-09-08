<?php
/**
* @version		$Id: menutypes.php 4033 2006-06-14 23:21:36Z eddieajau $
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Menu Types table
 *
 * @package 	Joomla.Framework
 * @subpackage		Table
 * @since	1.0
 */
class JTableMenuTypes extends JTable
{
	/** @var int Primary key */
	var $id					= null;
	/** @var string */
	var $menutype			= null;
	/** @var string */
	var $title				= null;
	/** @var string */
	var $description		= null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param database A database connector object
	 */
	function __construct( &$db ) {
		parent::__construct( '#__menu_types', 'id', $db );
	}

	/**
	 * @return boolean
	 */
	function check()
	{
		if (strstr($this->menutype, '\'')) {
			$this->_error = JText::_( 'The menu name cannot contain a \'', true );
			return false;
		}

		// correct spurious data
		if (trim( $this->title) == '') {
			$this->title = $this->menutype;
		}
		return true;
	}
}
?>
