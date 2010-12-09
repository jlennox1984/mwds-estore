<?php
/**
 * @version		$Id: admin.modules.php 6219 2007-01-08 23:23:09Z louis $
 * @package		Joomla
 * @subpackage	Modules
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

// Make sure the user is authorized to view this page
$user = & JFactory::getUser();
if (!$user->authorize( 'com_modules', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

jimport( 'joomla.application.component.controller' );

/**
 * @package		Joomla
 * @subpackage	Modules
 */
class ModulesHelper
{
	function ReadModuleXML( &$rows  )
	{
		foreach ($rows as $i => $row)
		{
			if ($row->module == '')
			{
				$rows[$i]->name 	= 'custom';
				$rows[$i]->module 	= 'custom';
				$rows[$i]->descrip 	= 'Custom created module, using Module Manager `New` function';
			}
			else
			{
				$data = JApplicationHelper::parseXMLInstallFile( $row->path.DS.$row->file);

				if ( $data['type'] == 'module' )
				{
					$rows[$i]->name		= $data['name'];
					$rows[$i]->descrip	= $data['description'];
				}
			}
		}
	}
}

/**
 * @package		Joomla
 * @subpackage	Modules
 */
class ModulesController extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );

		// Register Extra tasks
		$this->registerTask( 'apply', 			'save' );
		$this->registerTask( 'unpublish', 		'publish' );
		$this->registerTask( 'orderup', 		'reorder' );
		$this->registerTask( 'orderdown', 		'reorder' );
		$this->registerTask( 'accesspublic', 	'access' );
		$this->registerTask( 'accessregistered','access' );
		$this->registerTask( 'accessspecial',	'access' );
	}

	/**
	 * Compiles a list of installed or defined modules
	 */
	function view()
	{
		global $mainframe;

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$option	= 'com_modules';

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order', 		'filter_order', 	'm.position' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'' );
		$filter_state 		= $mainframe->getUserStateFromRequest( $option.'filter_state', 		'filter_state', 	'*' );
		$filter_position 	= $mainframe->getUserStateFromRequest( $option.'filter_position', 	'filter_position', 	0 );
		$filter_type	 	= $mainframe->getUserStateFromRequest( $option.'filter_type', 		'filter_type', 		0 );
		$filter_assigned 	= $mainframe->getUserStateFromRequest( $option.'filter_assigned',	'filter_assigned',	0 );
		$search 			= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 			'' );
		$search 			= $db->getEscaped( trim( JString::strtolower( $search ) ) );

		$limit		= $mainframe->getUserStateFromRequest( $option.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0 );

		$where[] = 'm.client_id = '.$client->id;

		$joins[] = 'LEFT JOIN #__users AS u ON u.id = m.checked_out';
		$joins[] = 'LEFT JOIN #__groups AS g ON g.id = m.access';
		$joins[] = 'LEFT JOIN #__modules_menu AS mm ON mm.moduleid = m.id';

		// used by filter
		if ( $filter_assigned ) {
			$joins[] = 'LEFT JOIN #__templates_menu AS t ON t.menuid = m.id';
			$where[] = "t.template = '$filter_assigned'";
		}
		if ( $filter_position ) {
			$where[] = "m.position = '$filter_position'";
		}
		if ( $filter_type ) {
			$where[] = "m.module = '$filter_type'";
		}
		if ( $search ) {
			$where[] = "LOWER( m.title ) LIKE '%$search%'";
		}
		if ( $filter_state ) {
			if ( $filter_state == 'P' ) {
				$where[] = "m.published = 1";
			} else if ($filter_state == 'U' ) {
				$where[] = "m.published = 0";
			}
		}

		$where 		= "\n WHERE " . implode( ' AND ', $where );
		$join 		= "\n " . implode( "\n ", $joins );
		$orderby 	= "\n ORDER BY $filter_order $filter_order_Dir, m.ordering ASC";

		// get the total number of records
		$query = "SELECT COUNT(*)"
		. "\n FROM #__modules AS m"
		. $where
		;
		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$query = "SELECT m.*, u.name AS editor, g.name AS groupname, MIN(mm.menuid) AS pages"
		. "\n FROM #__modules AS m"
		. $join
		. $where
		. "\n GROUP BY m.id"
		. $orderby
		;
		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum()) {
			echo $db->stderr();
			return false;
		}

		// get list of Positions for dropdown filter
		$query = "SELECT t.position AS value, t.position AS text"
		. "\n FROM #__template_positions as t"
		. "\n LEFT JOIN #__modules AS m ON m.position = t.position"
		. "\n WHERE m.client_id = $client->id"
		. "\n GROUP BY t.position"
		. "\n ORDER BY t.position"
		;
		$positions[] = JHTMLSelect::option( '0', '- '. JText::_( 'Select Position' ) .' -' );
		$db->setQuery( $query );
		$positions = array_merge( $positions, $db->loadObjectList() );
		$lists['position']	= JHTMLSelect::genericList( $positions, 'filter_position', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', "$filter_position" );

		// get list of Positions for dropdown filter
		$query = "SELECT module AS value, module AS text"
		. "\n FROM #__modules"
		. "\n WHERE client_id = $client->id"
		. "\n GROUP BY module"
		. "\n ORDER BY module"
		;
		$db->setQuery( $query );
		$types[] 		= JHTMLSelect::option( '0', '- '. JText::_( 'Select Type' ) .' -' );
		$types 			= array_merge( $types, $db->loadObjectList() );
		$lists['type']	= JHTMLSelect::genericList( $types, 'filter_type', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', "$filter_type" );

		// state filter
		$lists['state']	= JCommonHTML::selectState( $filter_state );

		// template assignment filter
		$query = "SELECT DISTINCT(template) AS text, template AS value" .
				"\nFROM #__templates_menu" .
				"\nWHERE client_id = " . $client->id;
		$db->setQuery( $query );
		$assigned[]		= JHTMLSelect::option( '0', '- '. JText::_( 'Select Template' ) .' -' );
		$assigned 		= array_merge( $assigned, $db->loadObjectList() );
		$lists['assigned']	= JHTMLSelect::genericList( $assigned, 'filter_assigned', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', "$filter_assigned" );

		// table ordering
		if ( $filter_order_Dir == 'DESC' ) {
			$lists['order_Dir'] = 'ASC';
		} else {
			$lists['order_Dir'] = 'DESC';
		}
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		require_once( JApplicationHelper::getPath( 'admin_html' ) );
		HTML_modules::view( $rows, $client, $pageNav, $lists );
	}

	/**
	* Compiles information to add or edit a module
	* @param string The current GET/POST option
	* @param integer The unique id of the record to edit
	*/
	function copy()
	{
		// Initialize some variables
		$db 	=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		$row 	=& JTable::getInstance('module');

		// load the row from the db table
		$row->load( (int) $cid[0] );
		$row->title 		= JText::sprintf( 'Copy of', $row->title );
		$row->id 			= 0;
		$row->iscore 		= 0;
		$row->published 	= 0;

		if (!$row->check()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		if (!$row->store()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		$row->checkin();

		$row->reorder( "position='".$row->position."' AND client_id=".$client->id );

		$query = "SELECT menuid"
		. "\n FROM #__modules_menu"
		. "\n WHERE moduleid = ".(int) $cid[0]
		;
		$db->setQuery( $query );
		$rows = $db->loadResultArray();

		foreach ($rows as $menuid)
		{
			$query = "INSERT INTO #__modules_menu"
			. "\n SET moduleid = ".(int) $row->id.", menuid = ".(int) $menuid
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				return JError::raiseWarning( 500, $row->getError() );
			}
		}

		$msg = JText::sprintf( 'Module Copied', $row->title );
		$this->setRedirect( 'index.php?option=com_modules&amp;client='. $client->id, $msg );
	}

	/**
	 * Saves the module after an edit form submit
	 */
	function save()
	{
		global $mainframe;

		$cache = & JFactory::getCache();
		$cache->cleanCache( 'com_content' );

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$post	= JRequest::get( 'post' );
		// fix up special html fields
		$post['content'] = JRequest::getVar( 'content', '', 'post', 'string', JREQUEST_ALLOWRAW );

		$row =& JTable::getInstance('module');

		if (!$row->bind( $post, 'selections' )) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		if (!$row->check()) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		// if new item, order last in appropriate group
		if (!$row->id) {
			$where = 'position='.$db->Quote( $row->position ).' AND client_id='.(int) $client->id ;
			$row->ordering = $row->getNextOrder ( $where );
		}

		if (!$row->store()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		$row->checkin();

		$menus = JRequest::getVar( 'menus', '', 'post' );
		$selections = JRequest::getVar( 'selections', array(), 'post', 'array' );

		// delete old module to menu item associations
		$query = "DELETE FROM #__modules_menu"
		. "\n WHERE moduleid = $row->id"
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $row->getError() );
		}

		// check needed to stop a module being assigned to `All`
		// and other menu items resulting in a module being displayed twice
		if ( $menus == 'all' ) {
			// assign new module to `all` menu item associations
			$query = "INSERT INTO #__modules_menu"
			. "\n SET moduleid = $row->id, menuid = 0"
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				return JError::raiseWarning( 500, $row->getError() );
			}
		}
		else
		{
			foreach ($selections as $menuid)
			{
				// this check for the blank spaces in the select box that have been added for cosmetic reasons
				if ( (int) $menuid >= 0 ) {
					// assign new module to menu item associations
					$query = "INSERT INTO #__modules_menu"
					. "\n SET moduleid = $row->id, menuid = $menuid"
					;
					$db->setQuery( $query );
					if (!$db->query()) {
						return JError::raiseWarning( 500, $row->getError() );
					}
				}
			}
		}

		$this->setMessage( JText::_( 'Item saved' ) );
		switch ($this->getTask())
		{
			case 'apply':
				$this->setRedirect( 'index.php?option=com_modules&amp;client='. $client->id .'&amp;task=edit&amp;hidemainmenu=1&amp;id='. $row->id );
				break;
		}
	}

	/**
	* Compiles information to add or edit a module
	* @param string The current GET/POST option
	* @param integer The unique id of the record to edit
	*/
	function edit( )
	{
		// Initialize some variables
		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();

		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$module = JRequest::getVar( 'module' );
		$id 	= JRequest::getVar( 'id', 0, 'method', 'int' );
		$cid 	= JRequest::getVar( 'cid', array( $id ), 'method', 'array' );

		$lists 	= array();
		$row 	=& JTable::getInstance('module');
		// load the row from the db table
		$row->load( (int) $cid[0] );
		// fail if checked out not by 'me'
		if ($row->isCheckedOut( $user->get('id') ))
		{
			$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );
			return JError::raiseWarning( 500, JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The module' ), $row->title ) );
		}

		$row->content = htmlspecialchars( str_replace( '&amp;', '&', $row->content ) );

		if ( $cid[0] ) {
			$row->checkout( $user->get('id') );
		}
		// if a new record we must still prime the JTableModel object with a default
		// position and the order; also add an extra item to the order list to
		// place the 'new' record in last position if desired
		if ($cid[0] == 0) {
			$row->position 	= 'left';
			$row->showtitle = true;
			$row->published = 1;
			//$row->ordering = $l;

			$moduleType 	= JRequest::getVar( 'module' );
			$row->module 	= $moduleType;
		}

		if ($client->id == 1)
		{
			$where 				= 'client_id = 1';
			$lists['client_id'] = 1;
			$path				= 'mod1_xml';
		}
		else
		{
			$where 				= 'client_id = 0';
			$lists['client_id'] = 0;
			$path				= 'mod0_xml';
		}

		$query = "SELECT position, ordering, showtitle, title"
		. "\n FROM #__modules"
		. "\n WHERE $where"
		. "\n ORDER BY ordering"
		;
		$db->setQuery( $query );
		if ( !($orders = $db->loadObjectList()) ) {
			echo $db->stderr();
			return false;
		}

		$query = "SELECT position, description"
		. "\n FROM #__template_positions"
		. "\n WHERE position <> ''"
		. "\n ORDER BY position"
		;
		$db->setQuery( $query );
		// hard code options for now
		$positions = $db->loadObjectList();

		$orders2 	= array();
		$pos 		= array();
		foreach ($positions as $position) {
			$orders2[$position->position] = array();
			$pos[] = JHTMLSelect::option( $position->position, $position->description );
		}

		$l = 0;
		$r = 0;
		for ($i=0, $n=count( $orders ); $i < $n; $i++) {
			$ord = 0;
			if (array_key_exists( $orders[$i]->position, $orders2 )) {
				$ord =count( array_keys( $orders2[$orders[$i]->position] ) ) + 1;
			}

			$orders2[$orders[$i]->position][] = JHTMLSelect::option( $ord, $ord.'::'.addslashes( $orders[$i]->title ) );
		}

		// build the html select list
		$pos_select 		= 'onchange="changeDynaList(\'ordering\',orders,document.adminForm.position.options[document.adminForm.position.selectedIndex].value, originalPos, originalOrder)"';
		$active 			= ( $row->position ? $row->position : 'left' );
		$lists['position'] 	= JHTMLSelect::genericList( $pos, 'position', 'class="inputbox" size="1" '. $pos_select, 'value', 'text', $active );

		// get selected pages for $lists['selections']
		if ( $cid[0] ) {
			$query = "SELECT menuid AS value"
			. "\n FROM #__modules_menu"
			. "\n WHERE moduleid = $row->id"
			;
			$db->setQuery( $query );
			$lookup = $db->loadObjectList();
			if (empty( $lookup )) {
				$lookup = array( JHTMLSelect::option( '-1' ) );
				$row->pages = 'none';
			} elseif (count($lookup) == 1 && $lookup[0]->value == 0) {
				$row->pages = 'all';
			} else {
				$row->pages = null;
			}
		} else {
			$lookup = array( JHTMLSelect::option( 0, JText::_( 'All' ) ) );
			$row->pages = 'all';
		}

		if ( $row->access == 99 || $row->client_id == 1 || $lists['client_id'] ) {
			$lists['access'] 			= 'Administrator';
			$lists['showtitle'] 		= 'N/A <input type="hidden" name="showtitle" value="1" />';
			$lists['selections'] 		= 'N/A';
		} else {
			if ( $client->id == '1' ) {
				$lists['access'] 		= 'N/A';
				$lists['selections'] 	= 'N/A';
			} else {
				$lists['access'] 		= JAdminMenus::Access( $row );

				$selections				= JAdminMenus::MenuLinkOptions();
				$lists['selections']	= JHTMLSelect::genericList( $selections, 'selections[]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $lookup, 'selections' );
			}
			$lists['showtitle'] = JHTMLSelect::yesnoList( 'showtitle', 'class="inputbox"', $row->showtitle );
		}

		// build the html select list for published
		$lists['published'] = JHTMLSelect::yesnoList( 'published', 'class="inputbox"', $row->published );

		$row->description = '';

		$lang =& JFactory::getLanguage();
		if ( $client->id != '1' ) {
			$lang->load( trim($row->module), JPATH_SITE );
		} else {
			$lang->load( trim($row->module) );
		}

		// xml file for module
		if ($row->module == 'custom') {
			$xmlfile = JApplicationHelper::getPath( $path, 'mod_custom' );
		} else {
			$xmlfile = JApplicationHelper::getPath( $path, $row->module );
		}

		$data = JApplicationHelper::parseXMLInstallFile($xmlfile);
		if ($data)
		{
			foreach($data as $key => $value) {
				$row->$key = $value;
			}
		}

		$model	= &$this->getModel('module');
		$model->setState( 'id',			$cid[0] );
		$model->setState( 'clientId',	$client->id );

		// get params definitions
		$params = new JParameter( $row->params, $xmlfile, 'module' );

		require_once( JApplicationHelper::getPath( 'admin_html' ) );
		HTML_modules::edit( $model, $row, $orders2, $lists, $params, $client );
	}

	/**
	* Displays a list to select the creation of a new module
	*/
	function add()
	{
		global $mainframe;

		// Initialize some variables
		$modules	= array();
		$client		= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

		// path to search for modules
		if ($client->id == '1') {
			$path = JPATH_ADMINISTRATOR .DS.'modules'.DS;
		} else {
			$path = JPATH_ROOT .DS.'modules'.DS;
		}

		$i = 1;
		jimport('joomla.filesystem.folder');
		$dirs = JFolder::folders( $path );

		foreach ($dirs as $dir)
		{
			if(substr($dir, 0, 4) == 'mod_') {
				$file 			= JFolder::files( $path . $dir, '^([_A-Za-z]*)\.xml$' );

				$files_php[] 	= $file[0];

				$modules[$i]->file 		= $file[0];
				$modules[$i]->module 	= str_replace( '.xml', '', $file[0] );
				$modules[$i]->path 		= $path . $dir;
				$i++;
			}
		}

		ModulesHelper::ReadModuleXML( $modules, $client );

		// sort array of objects alphabetically by name
		JArrayHelper::sortObjects( $modules, 'name' );

		require_once( JApplicationHelper::getPath( 'admin_html' ) );
		HTML_modules::add( $modules, $client );
	}

	/**
	* Deletes one or more modules
	*
	* Also deletes associated entries in the #__module_menu table.
	* @param array An array of unique category id numbers
	*/
	function remove()
	{
		global $mainframe;

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		$cids = implode( ',', $cid );

		$query = "SELECT id, module, title, iscore, params"
		. "\n FROM #__modules WHERE id IN ($cids)"
		;
		$db->setQuery( $query );
		if (!($rows = $db->loadObjectList())) {
			return JError::raiseError( 500, $db->getErrorMsg() );
		}

		// remove mappings first (lest we leave orphans)
		$query = "DELETE FROM #__modules_menu"
			. "\n WHERE moduleid IN ( $cids )"
			;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseError( 500, $db->getErrorMsg() );
		}
		// remove module
		$query = "DELETE FROM #__modules"
			. "\n WHERE id IN ($cids)"
			;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseError( 500, $db->getErrorMsg() );
		}

		$this->setMessage( JText::sprintf( 'Items removed', count( $cid ) ) );
	}

	/**
	* Publishes or Unpublishes one or more modules
	*/
	function publish()
	{
		global $mainframe;

		// Initialize some variables
		$db 	=& JFactory::getDBO();
		$user 	=& JFactory::getUser();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cache = & JFactory::getCache();
		$cache->cleanCache( 'com_content' );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task	= $this->getTask();
		$publish	= ($task == 'publish');

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		$cids = implode( ',', $cid );

		$query = "UPDATE #__modules"
		. "\n SET published = " . intval( $publish )
		. "\n WHERE id IN ( $cids )"
		. "\n AND ( checked_out = 0 OR ( checked_out = " .$user->get('id'). " ) )"
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $db->getErrorMsg() );
		}

		if (count( $cid ) == 1) {
			$row =& JTable::getInstance('module');
			$row->checkin( $cid[0] );
		}
	}

	/**
	 * Cancels an edit operation
	 */
	function cancel()
	{
		global $mainframe;

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$row =& JTable::getInstance('module');
		// ignore array elements
		$row->bind(JRequest::get('post'), 'selections params' );
		$row->checkin();
	}

	/**
	 * Moves the order of a record
	 */
	function reorder()
	{
		global $mainframe;

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task	= $this->getTask();
		$inc	= ($task == 'orderup' ? -1 : 1);

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		$row =& JTable::getInstance('module');
		$row->load( (int) $cid[0] );

		$row->move( $inc, 'position = '.$db->Quote( $row->position ).' AND client_id='.(int) $client->id  );
	}

	/**
	 * Changes the access level of a record
	 */
	function access()
	{
		global $mainframe;

		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task	= JRequest::getVar( 'task' );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		switch ( $task )
		{
			case 'accesspublic':
				$access = 0;
				break;

			case 'accessregistered':
				$access = 1;
				break;

			case 'accessspecial':
				$access = 2;
				break;
		}

		$row =& JTable::getInstance('module');
		$row->load( (int) $cid[0] );
		$row->access = $access;

		if ( !$row->check() ) {
			JError::raiseWarning( 500, $row->getError() );
		}
		if ( !$row->store() ) {
			JError::raiseWarning( 500, $row->getError() );
		}
	}

	/**
	 * Saves the orders of the supplied list
	 */
	function saveOrder()
	{
		// Initialize some variables
		$db		=& JFactory::getDBO();
		$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$this->setRedirect( 'index.php?option=com_modules&amp;client='.$client->id );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, 'No items selected' );
		}

		$total		= count( $cid );
		$order 		= JRequest::getVar( 'order', array(0), 'post', 'array' );
		$row 		=& JTable::getInstance('module');
		$groupings = array();

		// update ordering values
		for ($i = 0; $i < $total; $i++)
		{
			$row->load( (int) $cid[$i] );
			// track postions
			$groupings[] = $row->position;

			if ($row->ordering != $order[$i])
			{
				$row->ordering = $order[$i];
				if (!$row->store()) {
					return JError::raiseWarning( 500, $db->getErrorMsg() );
				}
			}
		}

		// execute updateOrder for each parent group
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$row->reorder("position = '$group' AND client_id = $client->id");
		}

		$this->setMessage = JText::_( 'New ordering saved' );
	}

	function preview()
	{
		global $mainframe;
		$mainframe->setPageTitle(JText::_('Module Preview'));

		require_once( JApplicationHelper::getPath( 'admin_html' ) );
		HTML_modules::preview( );
	}
}

// Create the controller
$controller = new ModulesController( array( 'default_task' => 'view' ) );

// Perform the Request task
$controller->execute( JRequest::getVar('task', 'view') );

// Redirect if set by the controller
$controller->redirect();
