<?php
/**
 * @version		$Id: view.php 6138 2007-01-02 03:44:18Z eddiea $
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

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML Article Element View class for the Content component
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class ContentViewElement extends JView
{
	function display()
	{
		global $mainframe;

		// Initialize variables
		$url 		= $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
		$db			= &JFactory::getDBO();
		$nullDate	= $db->getNullDate();

		$document	= & JFactory::getDocument();
		$document->setTitle('Article Selection');
		$document->addScript($url.'includes/js/joomla/modal.js');
		$document->addStyleSheet($url.'includes/js/joomla/modal.css');

		$template = $mainframe->getTemplate();
		$document->addStyleSheet("templates/$template/css/general.css");

		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');

		$lists = $this->_getLists();

		//Ordering allowed ?
		$ordering = ($lists['order'] == 'section_name' && $lists['order_Dir'] == 'ASC');

		$rows = &$this->get('List');
		$page = &$this->get('Pagination');
		JCommonHTML::loadOverlib();
		?>
		<form action="index.php?option=com_content&amp;task=element&amp;tmpl=component" method="post" name="adminForm">

			<table>
				<tr>
					<td width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
						<button onclick="getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
					<td nowrap="nowrap">
						<?php
						echo $lists['sectionid'];
						echo $lists['catid'];
						?>
					</td>
				</tr>
			</table>

			<table class="adminlist" cellspacing="1">
			<thead>
				<tr>
					<th width="5">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th class="title">
						<?php JCommonHTML::tableOrdering( 'Title', 'c.title', $lists ); ?>
					</th>
					<th width="7%">
						<?php JCommonHTML::tableOrdering( 'Access', 'groupname', $lists ); ?>
					</th>
					<th width="2%" class="title">
						<?php JCommonHTML::tableOrdering( 'ID', 'c.id', $lists ); ?>
					</th>
					<th class="title" width="15%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Section', 'section_name', $lists ); ?>
					</th>
					<th  class="title" width="15%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Category', 'cc.name', $lists ); ?>
					</th>
					<th align="center" width="10">
						<?php JCommonHTML::tableOrdering( 'Date', 'c.created', $lists ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<td colspan="15">
					<?php echo $page->getListFooter(); ?>
				</td>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++)
			{
				$row = &$rows[$i];

				$link 	= '';
				$date	= JHTML::Date( $row->created, DATE_FORMAT_LC4 );
				$access	= JCommonHTML::AccessProcessing( $row, $i, $row->state );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
						<?php
						if ( $row->title_alias ) {
							?>
							<td>
							<?php
						}
						else{
							echo "<td>";
						}
						?>
						<a onclick="window.parent.jSelectArticle('<?php echo $row->id; ?>', '<?php echo addSlashes($row->title); ?>');">
							<?php echo htmlspecialchars($row->title, ENT_QUOTES); ?>
						</a>
					</td>
					<td align="center">
						<?php echo $row->groupname;?>
					</td>
					<td>
						<?php echo $row->id; ?>
					</td>
						<td>
							<?php echo $row->section_name; ?>
						</td>
					<td>
						<?php echo $row->name; ?>
					</td>
					<td nowrap="nowrap">
						<?php echo $date; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}

	function _getLists()
	{
		global $mainframe;

		// Initialize variables
		$db		= &JFactory::getDBO();
		$filter	= null;

		// Get some variables from the request
		$sectionid			= JRequest::getVar( 'sectionid', -1, '', 'int' );
		$redirect			= $sectionid;
		$option				= JRequest::getVar( 'option' );
		$filter_order		= $mainframe->getUserStateFromRequest("articleelement.filter_order", 'filter_order', '');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest("articleelement.filter_order_Dir", 'filter_order_Dir', '');
		$filter_state		= $mainframe->getUserStateFromRequest("articleelement.filter_state", 'filter_state', '*');
		$catid				= $mainframe->getUserStateFromRequest("articleelement.catid", 'catid', 0);
		$filter_authorid	= $mainframe->getUserStateFromRequest("articleelement.filter_authorid", 'filter_authorid', 0);
		$filter_sectionid	= $mainframe->getUserStateFromRequest("articleelement.filter_sectionid", 'filter_sectionid', -1);
		$limit				= $mainframe->getUserStateFromRequest('limit', 'limit', $mainframe->getCfg('list_limit'));
		$limitstart			= $mainframe->getUserStateFromRequest("articleelement.limitstart", 'limitstart', 0);
		$search				= $mainframe->getUserStateFromRequest("articleelement.search", 'search', '');
		$search				= $db->getEscaped(trim(JString::strtolower($search)));

		// get list of categories for dropdown filter
		$query = "SELECT cc.id AS value, cc.title AS text, section" .
				"\n FROM #__categories AS cc" .
				"\n INNER JOIN #__sections AS s ON s.id = cc.section ".$filter .
				"\n ORDER BY s.ordering, cc.ordering";
		$lists['catid'] = JContentHelper::filterCategory($query, $catid);

		// get list of sections for dropdown filter
		$javascript = 'onchange="document.adminForm.submit();"';
		$lists['sectionid'] = JAdminMenus::SelectSection('filter_sectionid', $filter_sectionid, $javascript);

		// table ordering
		if ($filter_order_Dir == 'DESC') {
			$lists['order_Dir'] = 'ASC';
		} else {
			$lists['order_Dir'] = 'DESC';
		}
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;

		return $lists;
	}
}
?>