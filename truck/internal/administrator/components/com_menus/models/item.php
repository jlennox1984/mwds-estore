<?php
/**
 * @version		$Id: item.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Menus
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights
 * reserved.
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
 * @subpackage	Menus
 * @author Andrew Eddie
 */
class MenusModelItem extends JModel
{
	/** @var object JTable object */
	var $_table = null;

	/** @var object JTable object */
	var $_url = null;

	/**
	 * Overridden constructor
	 * @access	protected
	 */
	function __construct()
	{
		parent::__construct();
		$url = JRequest::getVar('url', array(), '', 'array');
		if (isset($url['option']))
		 {
			$this->_url = 'index.php?option='.$url['option'];
			unset($url['option']);
			if (count($url)) {
				foreach ($url as $k => $v)
				{
					$this->_url .= '&'.$k.'='.$v;
				}
			}
		}
	}

	function &getItem()
	{
		static $item;
		if (isset($item)) {
			return $item;
		}

		$table =& $this->_getTable();

		// Load the current item if it has been defined
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		if ($cid[0]) {
			$table->load($cid[0]);
		}

		// Override the current item's type field if defined in the request
		if ($type = JRequest::getVar('type', false)) {
			$table->type = $type;
		}

		// Override the current item's menutype field if defined in the request
		if ($menu_type = JRequest::getVar('menutype', false)) {
			$table->menutype = $menu_type;
		}

		switch ($table->type)
		{
			case 'separator':
				$table->link = null;
				$table->componentid = 0;
				break;
			case 'url':
				$table->componentid = 0;
				break;
			case 'menulink':
				$table->componentid = 0;
				break;
			case 'component':
				// Override the current item's link field if defined in the request
				if (!is_null($this->_url)) {
					$table->link = $this->_url;
				}
				$url = str_replace('index.php?', '', $table->link);
				$url = str_replace('&amp;', '&', $url);
				$table->linkparts = null;
				parse_str($url, $table->linkparts);

				$db = &$this->getDBO();
				if ($component = @$table->linkparts['option']) {
					$query = "SELECT `id`" .
							"\n FROM `#__components`" .
							"\n WHERE `link` <> ''" .
							"\n AND `parent` = 0" .
							"\n AND `option` = '".$db->getEscaped($component)."'";
					$db->setQuery( $query );
					$table->componentid = $db->loadResult();
				}
				break;
		}

		$item = clone($table);
		return $item;
	}

	function &getExpansion()
	{
		$item				= &$this->getItem();
		$return['option']	= JRequest::getVar('expand');
		$menutype			= JRequest::getVar('menutype');

		if ($return['option'])
		{
			require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_menus'.DS.'classes'.DS.'ilink.php');
			$handler		= new iLink($return['option'], $item->id, $menutype);
			$return['html'] = $handler->getTree();
			return $return;
		} else {
			$return['html'] = null;
		}
		return $return;
	}

	function &getUrlParams()
	{
		// Get the state parameters
		$item	=& $this->getItem();
		$params	= new JParameter('');

		if ($state =& $this->_getStateXML())
		{
			if (is_a($state, 'JSimpleXMLElement'))
			{
				$sp =& $state->getElementByPath('url');
				$params->setXML($sp);
				if (isset($item->linkparts) && is_array($item->linkparts)) {
					$params->loadArray($item->linkparts);
				}
			}
		}
		return $params;
	}

	function &getStateParams()
	{
		// Get the state parameters
		$item	=& $this->getItem();
		$params	= new JParameter($item->params);

		if ($state =& $this->_getStateXML())
		{
			if (is_a($state, 'JSimpleXMLElement'))
			{
				$sp =& $state->getElementByPath('params');
				$params->setXML($sp);
			}
		}
		return $params;
	}

	function &getAdvancedParams()
	{
		// Get the state parameters
		$item	=& $this->getItem();
		$params	= new JParameter($item->params);

		if ($state =& $this->_getStateXML())
		{
			if (is_a($state, 'JSimpleXMLElement'))
			{
				$ap =& $state->getElementByPath('advanced');
				$params->setXML($ap);
			}
		}
		return $params;
	}

	function getStateName()
	{
		$name = null;
		if ($state =& $this->_getStateXML())
		{
			if (is_a($state, 'JSimpleXMLElement'))
			{
				$sn =& $state->getElementByPath('name');
				if ($sn) {
					$name = $sn->data();
				}
			}
		}
		return JText::_($name);
	}

	function getStateDescription()
	{
		$description = null;
		if ($state =& $this->_getStateXML())
		{
			if (is_a($state, 'JSimpleXMLElement'))
			{
				$sd =& $state->getElementByPath('description');
				if ($sd) {
					$description = $sd->data();
				}
			}
		}
		return JText::_($description);
	}

	/**
	 * Gets the componet table object related to this menu item
	 */
	function &getComponent()
	{
		$item		=& $this->getItem();
		$id			= $item->componentid;
		$component	= & JTable::getInstance( 'component');
		$component->load( $id );
		return $component;
	}

	function store()
	{
		// Initialize variables
		$db		=& JFactory::getDBO();
		$row	=& $this->getItem();
		$post	= $this->_state->get( 'request' );

		switch ($post['type'])
		{
			case 'separator':
				break;
			case 'url':
				break;
			case 'menulink':
				$post['link'] = $post['params']['menu_item'];
				break;
			case 'component':
				break;
		}
		if (!$row->bind( $post )) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			return false;
		}

		if ($row->id > 0)
		{
			// existing item
			$query		= 'SELECT menutype FROM #__menu WHERE id = '.(int) $row->id;
			$this->_db->setQuery( $query );
			$oldType	= $this->_db->loadResult();
			if ($oldType != $row->menutype) {
				// moved to another menu, disconnect the old parent
				$row->parent = 0;
			}
		}
		else
		{
			// if new item order last in appropriate group
			$where = "menutype = '" . $row->menutype . "' AND published >= 0 AND parent = ".$row->parent;
			$row->ordering = $row->getNextOrder ( $where );
		}

		$row->name = ampReplace( $row->name );

		if (is_array($post['urlparams']))
		{
			$pos = strpos( $row->link, '?' );
			if ($pos !== false)
			{
				$prefix = substr( $row->link, 0, $pos );
				$query	= substr( $row->link, $pos+1 );

				$temp = array();
				parse_str( $query, $temp );
				$temp2 = array_merge( $temp, $post['urlparams'] );

				$temp3 = array();
				foreach ($temp2 as $k => $v)
				{
					$temp3[] = $k.'='.$v;
				}
				$url = null;
				$row->link = $prefix . '?' . implode( '&', $temp3 );
			}
		}

		if (!$row->check())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			return false;
		}

		if (!$row->store())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			return false;
		}

		$row->checkin();
		$row->reorder( 'menutype='.$db->Quote( $row->menutype ).' AND parent='.(int)$row->parent );

		return true;
	}

	/**
	 * Delete one or more menu items
	 * @param mixed int or array of id values
	 */
	function delete( $ids )
	{
		if (!is_array( $ids )) {
			$ids = array( $ids );
		}

		$db = &$this->getDBO();

		if (count( $ids ))
		{
			// Delete associated module and template mappings
			$where = 'WHERE menuid = ' . implode( ' OR menuid = ', $ids );

			$query = 'DELETE FROM #__modules_menu '
				. $where;
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError( $menuTable->getErrorMsg() );
				return false;
			}

			$query = 'DELETE FROM #__templates_menu '
				. $where;
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError( $menuTable->getErrorMsg() );
				return false;
			}

			// Set any alias menu types to not point to missing menu items
			$query = 'UPDATE #__menu SET link = 0 WHERE type = \'menulink\' AND (link = '.implode( ' OR id = ', $ids ).')';
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError( $db->getErrorMsg() );
				return false;
			}

			// Delete the menu items
			$where = 'WHERE id = ' . implode( ' OR id = ', $ids );

			$query = 'DELETE FROM #__menu ' . $where;
			$db->setQuery( $query );
			if (!$db->query()) {
				$this->setError( $db->getErrorMsg() );
				return false;
			}
		}
		return true;
	}

	/**
	 * Delete menu items by type
	 */
	function deleteByType( $type = '' )
	{
		$db = &$this->getDBO();

		$query = 'SELECT id' .
				' FROM #__menu' .
				' WHERE menutype = ' . $db->Quote( $type );
		$db->setQuery( $query );
		$ids = $db->loadResultArray();

		if ($db->getErrorNum())
		{
			$this->setError( $db->getErrorMsg() );
			return false;
		}

		return $this->delete( $ids );
	}

	/**
	 * Returns the internal table object
	 * @return JTable
	 */
	function &_getTable()
	{
		if ($this->_table == null) {
			$this->_table =& JTable::getInstance( 'menu');
		}
		return $this->_table;
	}

	function &_getStateXML()
	{
		static $xml;

		if (isset($xml)) {
			return $xml;
		}
		$xml = null;
		$xmlpath = null;
		$item 	= &$this->getItem();

		switch ($item->type)
		{
			case 'separator':
				$xmlpath = JPATH_BASE.DS.'components'.DS.'com_menus'.DS.'models'.DS.'metadata'.DS.'separator.xml';
				break;
			case 'url':
				$xmlpath = JPATH_BASE.DS.'components'.DS.'com_menus'.DS.'models'.DS.'metadata'.DS.'url.xml';
				break;
			case 'menulink':
				$xmlpath = JPATH_BASE.DS.'components'.DS.'com_menus'.DS.'models'.DS.'metadata'.DS.'menulink.xml';
				break;
			case 'component':
			default:
				if (isset($item->linkparts['view']))
				{
					// View is set... so we konw to look in view file
					if (isset($item->linkparts['layout'])) {
						$layout = $item->linkparts['layout'];
					} else {
						$layout = 'default';
					}
					$lpath = JPATH_ROOT.DS.'components'.DS.$item->linkparts['option'].DS.'views'.DS.$item->linkparts['view'].DS.'tmpl'.DS.$layout.'.xml';
					$vpath = JPATH_ROOT.DS.'components'.DS.$item->linkparts['option'].DS.'views'.DS.$item->linkparts['view'].DS.'metadata.xml';
					if (file_exists($lpath)) {
						$xmlpath = $lpath;
					} elseif (file_exists($vpath)) {
						$xmlpath = $vpath;
					}
				}
				if (!$xmlpath && isset($item->linkparts['option'])) {
					$xmlpath = JPATH_ROOT.DS.'components'.DS.$item->linkparts['option'].DS.'metadata.xml';
					if(!file_exists($xmlpath)) {
						$xmlpath = JApplicationHelper::getPath('com_xml', $item->linkparts['option']);
					}
				}
				break;
		}

		if (file_exists($xmlpath))
		{
			$xml =& JFactory::getXMLParser('Simple');
			if ($xml->loadFile($xmlpath)) {
				$this->_xml = &$xml;
				$document =& $xml->document;

				/*
				 * HANDLE NO OPTION CASE
				 */
				$menus =& $document->getElementByPath('menu');
				if (is_a($menus, 'JSimpleXMLElement') && $menus->attributes('options') == 'none') {
					$xml =& $menus->getElementByPath('state');
				} else {
					$xml =& $document->getElementByPath('state');
				}

				// Handle error case... path doesn't exist
				if (!is_a($xml, 'JSimpleXMLElement')) {
					return $document;
				}

				/*
				 * HANDLE A SWITCH IF IT EXISTS
				 */
				if ($switch = $xml->attributes('switch'))
				{
					$default = $xml->attributes('default');
					// Handle switch
					$switchVal = (isset($item->linkparts[$switch]))? $item->linkparts[$switch] : 'default';
					$found = false;

					foreach ($xml->children() as $child) {
						if ($child->name() == $switchVal) {
							$xml =& $child;
							$found = true;
							break;
						}
					}

					if (!$found) {
						foreach ($xml->children() as $child) {
							if ($child->name() == $default) {
								$xml =& $child;
								break;
							}
						}
					}
				}

				/*
				 * HANDLE INCLUDED PARAMS
				 */
				$children = $xml->children();
				if (count($children) == 1)
				{
					if ($children[0]->name() == 'include') {
						$ret =& $this->_getIncludedParams($children[0]);
						if ($ret) {
							$xml =& $ret;
						}
					}
				}

				if ($switch = $xml->attributes('switch'))
				{
					$default = $xml->attributes('default');
					// Handle switch
					$switchVal = ($item->linkparts[$switch])? $item->linkparts[$switch] : 'default';
					$found = false;

					foreach ($xml->children() as $child) {
						if ($child->name() == $switchVal) {
							$xml =& $child;
							$found = true;
							break;
						}
					}

					if (!$found) {
						foreach ($xml->children() as $child) {
							if ($child->name() == $default) {
								$xml =& $child;
								break;
							}
						}
					}
				}
			}
		}
		return $xml;
	}

	function &_getIncludedParams($include)
	{
		$tags	= array();
		$state	= null;
		$source	= $include->attributes('source');
		$path	= $include->attributes('path');
		$item 	= &$this->getItem();

		preg_match_all( "/{([A-Za-z\-_]+)}/", $source, $tags);
		if (isset($tags[1])) {
			for ($i=0;$i<count($tags[1]);$i++) {
				$source = str_replace($tags[0][$i], @$item->linkparts[$tags[1][$i]], $source);
			}
		}

		// load the source xml file
		if (file_exists( JPATH_ROOT.$source ))
		{
			$xml = & JFactory::getXMLParser('Simple');

			if ($xml->loadFile(JPATH_ROOT.$source)) {
				$document = &$xml->document;
				$state = $document->getElementByPath($path);
			}
		}
		return $state;
	}


}
?>