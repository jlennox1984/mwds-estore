<?php
/**
 * @version		$Id: view.html.php 6276 2007-01-14 17:26:10Z predator $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport( 'joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class ContentViewArticle extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $Itemid;

		$user		=& JFactory::getUser();
		$document	=& JFactory::getDocument();
		$dispatcher	=& JEventDispatcher::getInstance();
		$pathway	=& $mainframe->getPathWay();

		// Initialize variables
		$article	=& $this->get('Article');
		$params		=& $article->parameters;

		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		if($this->getLayout() == 'pagebreak') {
			$this->_displayPagebreak($tpl);
			return;
		}

		if (($article->id == 0))
		{
			$id = JRequest::getVar( 'id' );
			return JError::raiseError( 404, JText::sprintf( 'Article # not found', $id ) );
		}

		$linkOn		= null;
		$linkText	= null;

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Handle BreadCrumbs

		if (!empty ($Itemid))
		{
			// Section
			if (!empty ($article->section)) {
				$pathway->addItem($article->section, sefRelToAbs('index.php?option=com_content&amp;view=section&amp;id='.$article->sectionid.'&amp;Itemid='.$Itemid));
			}
			// Category
			if (!empty ($article->category)) {
				$pathway->addItem($article->category, sefRelToAbs('index.php?option=com_content&amp;view=category&amp;&amp;id='.$article->catid.'&amp;Itemid='.$Itemid));
			}
		}
		// Article
		$pathway->addItem($article->title, '');

		// Handle Page Title
		$document->setTitle($article->title);

		// Handle metadata
		$document->setDescription( $article->metadesc );
		$document->setMetadata('keywords', $article->metakey);

		$mdata = new JParameter($article->metadata);
		$mdata = $mdata->toArray();
		foreach ($mdata as $k => $v) {
			if ($v) {
				$document->setMetadata($k, $v);
			}
		}

		// If there is a pagebreak heading or title, add it to the page title
		if (isset ($article->page_title)) {
			$document->setTitle($article->title.' '.$article->page_title);
		}

		// Create a user access object for the current user
		$access = new stdClass();
		$access->canEdit	= $user->authorize('action', 'edit', 'content', 'all');
		$access->canEditOwn	= $user->authorize('action', 'edit', 'content', 'own');
		$access->canPublish	= $user->authorize('action', 'publish', 'content', 'all');

		// Process the content plugins
		JPluginHelper::importPlugin('content');
		$results = $dispatcher->trigger('onPrepareContent', array (& $article, & $params, $limitstart));

		if ($params->get('readmore') || $params->get('link_titles'))
		{
			if ($params->get('intro_only'))
			{
				// Check to see if the user has access to view the full article
				if ($article->access <= $user->get('aid', 0))
				{
					$linkOn = sefRelToAbs("index.php?option=com_content&amp;view=article&amp;id=".$article->slug."&amp;Itemid=".$Itemid);

					if (@$article->readmore) {
						// text for the readmore link
						$linkText = JText::_('Read more...');
					}
				}
				else
				{
					$linkOn = sefRelToAbs("index.php?option=com_registration&amp;task=register");

					if (@$article->readmore) {
						// text for the readmore link if accessible only if registered
						$linkText = JText::_('Register to read more...');
					}
				}
			}
		}
		$mod_date = '';
		if (intval($article->modified) != 0) {
			$article->mod_date = JHTML::Date($article->modified);
		}
		if (intval($article->created) != 0) {
			$article->created = JHTML::Date($article->created);
		}

		$article->readmore_link = $linkOn;
		$article->readmore_text = $linkText;

		$article->event = new stdClass();
		$results = $dispatcher->trigger('onAfterDisplayTitle', array ($article, &$params, $limitstart));
		$article->event->afterDisplayTitle = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onBeforeDisplayContent', array (& $article, & $params, $limitstart));
		$article->event->beforeDisplayContent = trim(implode("\n", $results));

		$results = $dispatcher->trigger('onAfterDisplayContent', array (& $article, & $params, $limitstart));
		$article->event->afterDisplayContent = trim(implode("\n", $results));

		$this->assignRef('article', $article);
		$this->assignRef('params' , $params);
		$this->assignRef('user'   , $user);
		$this->assignRef('access' , $access);

		parent::display($tpl);
	}

	function getIcon($type, $attribs = array())
	{
		 global $Itemid, $mainframe;

		$url	= '';
		$text	= '';

		$article = &$this->article;

		switch($type)
		{
			case 'pdf' :
			{
				$url	= 'index.php?option=com_content&amp;view=article&amp;id='.$article->id.'&amp;format=pdf';
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

				// checks template image directory for image, if non found default are loaded
				if ($this->params->get('icons')) {
					$text = JAdminMenus::ImageCheck('pdf_button.png', '/images/M_images/', NULL, NULL, JText::_('PDF'), JText::_('PDF'));
				} else {
					$text = JText::_('PDF').'&nbsp;';
				}

				$attribs['title']	= '"'.JText::_( 'PDF' ).'"';
				$attribs['onclick'] = "\"window.open('".$url."','win2','".$status."'); return false;\"";

			} break;

			case 'print' :
			{
				$url	= 'index.php?option=com_content&amp;view=article&amp;id='.$article->id.'&amp;tmpl=component&amp;Itemid='.$Itemid.'&amp;page='.@ $this->request->limitstart;
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';

				// checks template image directory for image, if non found default are loaded
				if ( $this->params->get( 'icons' ) ) {
					$text = JAdminMenus::ImageCheck( 'printButton.png', '/images/M_images/', NULL, NULL, JText::_( 'Print' ), JText::_( 'Print' ) );
				} else {
					$text = JText::_( 'ICON_SEP' ) .'&nbsp;'. JText::_( 'Print' ) .'&nbsp;'. JText::_( 'ICON_SEP' );
				}

				$attribs['title']	= '"'.JText::_( 'Print' ).'"';
				$attribs['onclick'] = "\"window.open('".$url."','win2','".$status."'); return false;\"";

			} break;

			case 'email' :
			{
				$url	= 'index.php?option=com_mailto&amp;tmpl=component&amp;link='.urlencode( JRequest::getURI());
				$status = 'width=400,height=300,menubar=yes,resizable=yes';

				if ($this->params->get('icons')) 	{
					$text = JAdminMenus::ImageCheck('emailButton.png', '/images/M_images/', NULL, NULL, JText::_('Email'), JText::_('Email'));
				} else {
					$text = '&nbsp;'.JText::_('Email');
				}

				$attribs['title']	= '"'.JText::_( 'Email ' ).'"';
				$attribs['onclick'] = "\"window.open('".$url."','win2','".$status."'); return false;\"";

			} break;

			case 'edit' :
			{
				if ($this->params->get('popup')) {
					return;
				}
				if ($article->state < 0) {
					return;
				}
				if (!$this->access->canEdit && !($this->access->canEditOwn && $article->created_by == $this->user->get('id'))) {
					return;
				}

				JCommonHTML::loadOverlib();

				$url = 'index.php?option=com_content&amp;view=article&amp;layout=form&amp;id='.$article->id.'&amp;Itemid='.$Itemid.'&amp;Returnid='.$Itemid;
				$text = JAdminMenus::ImageCheck('edit.png', '/images/M_images/', NULL, NULL, JText::_('Edit'), JText::_('Edit'). $article->id );

				if ($article->state == 0) {
					$overlib = JText::_('Unpublished');
				} else {
					$overlib = JText::_('Published');
				}
				$date = JHTML::Date($article->created);
				$author = $article->created_by_alias ? $article->created_by_alias : $article->author;

				$overlib .= '<br />';
				$overlib .= $article->groups;
				$overlib .= '<br />';
				$overlib .= $date;
				$overlib .= '<br />';
				$overlib .= $author;

				$attribs['onmouseover'] = "\"return overlib('".$overlib."', CAPTION, '".JText::_( 'Edit Item' )."', BELOW, RIGHT)\"";
				$attribs['onmouseover'] = "\"return nd();\"";

			} break;
		}


		return JHTML::Link($url, $text, $attribs);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $Itemid;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();

		// Make sure you are logged in
		if ($user->get('aid', 0) < 1) {
			JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
			return;
		}

		// Initialize variables
		$article	=& $this->get('Article');
		$params		=& $article->parameters;
		$isNew		= ($article->id < 1);

		// At some point in the future this will come from a request object
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$returnid	= JRequest::getVar('Returnid', $Itemid, '', 'int');

		// Add the Calendar includes to the document <head> section
		JCommonHTML::loadCalendar();

		if ($isNew)
		{
			// TODO: Do we allow non-sectioned articles from the frontend??
			$article->sectionid = JRequest::getVar('sectionid', 0, '', 'int');
		}

		// Get the lists
		$lists = $this->_buildEditLists();

		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Ensure the row data is safe html
		jimport('joomla.filter.output');
		JOutputFilter::objectHTMLSafe( $article);

		// Build the page title string
		$title = $article->id ? JText::_('Edit') : JText::_('New');

		// Set page title
		$document->setTitle($title);

		// get pathway
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');

		// Unify the introtext and fulltext fields and separated the fields by the {readmore} tag
		if (JString::strlen($article->fulltext) > 1) {
			$article->text = $article->introtext."<hr id=\"system-readmore\" />".$article->fulltext;
		} else {
			$article->text = $article->introtext;
		}

		$this->set('returnid',	$returnid);
		$this->set('article',	$article);
		$this->set('params',	$params);
		$this->set('lists',		$lists);
		$this->set('editor',	$editor);
		$this->set('user',		$user);

		parent::display($tpl);
	}

	function _buildEditLists()
	{
		// Get the article and database connector from the model
		$article = & $this->get('Article');
		$db 	 = & JFactory::getDBO();

		// Select List: Categories
		$lists['catid'] = JAdminMenus::ComponentCategory('catid', $article->sectionid, intval($article->catid));

		// Select List: Category Ordering
		$query = "SELECT ordering AS value, title AS text"."\n FROM #__content"."\n WHERE catid = $article->catid"."\n ORDER BY ordering";
		$lists['ordering'] = JAdminMenus::SpecificOrdering($article, $article->id, $query, 1);

		// Radio Buttons: Should the article be published
		$lists['state'] = JHTMLSelect::yesnoList('state', '', $article->state);

		// Radio Buttons: Should the article be added to the frontpage
		$query = "SELECT content_id"."\n FROM #__content_frontpage"."\n WHERE content_id = $article->id";
		$db->setQuery($query);
		$article->frontpage = $db->loadResult();

		$lists['frontpage'] = JHTMLSelect::yesnoList('frontpage', '', (boolean) $article->frontpage);

		// Select List: Group Access
		$lists['access'] = JAdminMenus::Access($article);

		return $lists;
	}

	function _displayPagebreak($tpl)
	{
		global $mainframe;
		$mainframe->setPageTitle(JText::_('PGB ARTICLE PAGEBRK'));

		parent::display($tpl);
	}
}
?>