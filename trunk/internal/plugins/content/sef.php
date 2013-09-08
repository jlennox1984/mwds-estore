<?php
/**
* @version		$Id: sef.php 6138 2007-01-02 03:44:18Z eddiea $
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

$mainframe->registerEvent( 'onPrepareContent', 'pluginSEF' );

/**
* Converting internal relative links to SEF URLs
*
* <b>Usage:</b>
* <code><a href="...relative link..."></code>
*/
function pluginSEF( &$row, &$params, $page=0 )
{
	global $mainframe;

	// check to see of SEF is enabled
	if(!$mainframe->getCfg('sef')) {
		return true;
	}

	// simple performance check to determine whether bot should process further
	if ( JString::strpos( $row->text, 'href="' ) === false ) {
		return true;
	}

	$plugin =& JPluginHelper::getPlugin('content', 'sef');

	// check whether plugin has been unpublished
	if ( !$plugin->published ) {
		return true;
	}

	// define the regular expression for the bot
	$regex = "#href=\"(.*?)\"#s";

	// perform the replacement
	$row->text = preg_replace_callback( $regex, 'contentSEF_replacer', $row->text );

	return true;
}
/**
* Replaces the matched tags
* @param array An array of matches (see preg_match_all)
* @return string
*/
function contentSEF_replacer( &$matches )
{
	// original text that might be replaced
	$original = 'href="'. $matches[1] .'"';

	// array list of non http/https	URL schemes
	$url_schemes = array( 'data:', 'file:', 'ftp:', 'gopher:', 'imap:', 'ldap:', 'mailto:', 'news:', 'nntp:', 'telnet:', 'javascript:', 'irc:' );

	foreach ( $url_schemes as $url )
	{
		// disable bot from being applied to specific URL Scheme tag
		if ( JString::strpos($matches[1], $url) !== false )
		{
			return $original;
		}
	}

	// will only process links containing 'index.php?option
	if ( JString::strpos( $matches[1], 'index.php?option' ) !== false )
	{
		$uriLocal	=& JFactory::getURI();
		$uriHREF	=& JFactory::getURI($matches[1]);

		//disbale bot from being applied to external links
		if($uriLocal->getHost() !== $uriHREF->getHost() && !is_null($uriHREF->getHost()))
		{
			return $original;
		}

		if ($qstring = $uriHREF->getQuery())
		{
			$qstring = '?' . $qstring;
		}
		if ($anchor = $uriHREF->getFragment())
		{
			$anchor = '#' . $anchor;
		}
		return 'href="'. JURI::resolve( 'index.php' . $qstring ) . $uriHREF->getFragment() .'"';
	}
	else
	{
		return $original;
	}
}
?>