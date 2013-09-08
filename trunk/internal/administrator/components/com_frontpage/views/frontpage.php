<?php
/**
* @version		$Id: frontpage.php 6182 2007-01-05 18:37:54Z Jinx $
* @package		Joomla
* @subpackage	Content
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

/**
* @package		Joomla
* @subpackage	Content
*/
class FrontpageView
{
	/**
	* Writes a list of the articles
	* @param array An array of content objects
	*/
	function showList( &$rows, $page, $option, $lists )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');

		$user 		=& JFactory::getUser();
		$db 		=& JFactory::getDBO();
		$nullDate 	= $db->getNullDate();

		//Ordering allowed ?
		$ordering = (($lists['order'] == 'fpordering'));

		JCommonHTML::loadOverlib();
		?>
		<form action="index.php?option=com_frontpage" method="post" name="adminForm">

			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
						<button onclick="getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
					<td nowrap="nowrap">
						<?php
						echo $lists['sectionid'];
						echo $lists['catid'];
						echo $lists['authorid'];
						echo $lists['state'];
						?>
					</td>
				</tr>
			</table>

			<table class="adminlist">
			<thead>
				<tr>
					<th width="5">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th width="20">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
					</th>
					<th class="title">
						<?php JCommonHTML::tableOrdering( 'Title', 'c.title', $lists ); ?>
					</th>
					<th width="10%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Published', 'c.state', $lists ); ?>
					</th>
					<th width="80" nowrap="nowrap">
						<a href="javascript:tableOrdering('fpordering','ASC');" title="<?php echo JText::_( 'Order by' ); ?> <?php echo JText::_( 'Order' ); ?>">
							<?php echo JText::_( 'Order' ); ?>
						</a>
		 			</th>
					<th width="1%">
						<?php JCommonHTML::saveorderButton( $rows ); ?>
					</th>
					<th width="8%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Access', 'groupname', $lists ); ?>
					</th>
					<th width="2%" class="title" align="center" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'ID', 'c.id', $lists ); ?>
					</th>
					<th width="10%" class="title">
						<?php JCommonHTML::tableOrdering( 'Section', 'sect_name', $lists ); ?>
					</th>
					<th width="10%" class="title">
						<?php JCommonHTML::tableOrdering( 'Category', 'cc.name', $lists ); ?>
					</th>
					<th width="10%" class="title">
						<?php JCommonHTML::tableOrdering( 'Author', 'author', $lists ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<td colspan="13">
					<?php echo $page->getListFooter(); ?>
				</td>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$link = ampReplace( 'index.php?option=com_content&task=edit&hidemainmenu=1&cid[]='. $row->id );

				$now = date( 'Y-m-d H:i:s' );
				if ( $now <= $row->publish_up && $row->state == '1' ) {
					$img = 'publish_y.png';
					$alt = JText::_( 'Published' );
				} else if (($now <= $row->publish_down || $row->publish_down == $nullDate) && $row->state == '1') {
					$img = 'publish_g.png';
					$alt = JText::_( 'Published' );
				} else if ( $now > $row->publish_down && $row->state == '1' ) {
					$img = 'publish_r.png';
					$alt = JText::_( 'Expired' );
				} elseif ( $row->state == "0" ) {
					$img = "publish_x.png";
					$alt = JText::_( 'Unpublished' );
				}

				$times = '';
				if ( isset( $row->publish_up ) ) {
						if ( $row->publish_up == $nullDate) {
							$times .= '<tr><td>'. JText::_( 'Start: Always' ) .'</td></tr>';
						} else {
							$times .= '<tr><td>'. JText::_( 'Start' ) .': '. $row->publish_up .'</td></tr>';
						}
				}
				if ( isset( $row->publish_down ) ) {
						if ($row->publish_down == $nullDate) {
							$times .= '<tr><td>'. JText::_( 'Finish: No Expiry' ) .'</td></tr>';
						} else {
						$times .= '<tr><td>'. JText::_( 'Finish' ) .': '. $row->publish_down .'</td></tr>';
						}
				}

				$access 	= JCommonHTML::AccessProcessing( $row, $i );
				$checked 	= JCommonHTML::CheckedOutProcessing( $row, $i );

				if ( $user->authorize( 'com_users', 'manage' ) ) {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$linkA 	= ampReplace( 'index.php?option=com_users&task=editA&hidemainmenu=1&id='. $row->created_by );
						$author = '<a href="'. $linkA .'" title="'. JText::_( 'Edit User' ) .'">'. $row->author .'</a>';
					}
				} else {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$author = $row->author;
					}
				}

				// section handling
				if ($row->sectionid) {
					$row->sect_link = ampReplace( 'index.php?option=com_sections&task=edit&hidemainmenu=1&id='. $row->sectionid );
					$title_sec		= JText::_( 'Edit Section' );
				} 
				
				// category handling
				if ($row->catid) {
					$row->cat_link 	= ampReplace( 'index.php?option=com_categories&task=edit&hidemainmenu=1&id='. $row->catid );
					$title_cat		= JText::_( 'Edit Category' );
				} 
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo $checked; ?>
					</td>
					<td>
						<?php
						if ( $row->checked_out && ( $row->checked_out != $user->get('id') ) ) {
							echo $row->title;
						} else {
							?>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Content' ); ?>">
								<?php echo $row->title; ?></a>
							<?php
						}
						?>
					</td>
					<?php
					if ( $times ) {
						?>
						<td align="center">
							<a href="javascript:void(0);" onmouseover="return overlib('<table><?php echo $times; ?></table>', CAPTION, '<?php echo JText::_( 'Publish Information' ); ?>', BELOW, RIGHT);" onmouseout="return nd();" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? 'unpublish' : 'publish' ?>')">
								<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt;?>" /></a>
						</td>
						<?php
					}
					?>
					<td class="order" colspan="2">
						<span><?php echo $page->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
						<span><?php echo $page->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
						<?php $disabled = $ordering ?  '' : '"disabled=disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->fpordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
					</td>
					<td align="center">
						<?php echo $access;?>
					</td>
					<td align="center">
						<?php echo $row->id;?>
					</td>
					<td>
						<a href="<?php echo $row->sect_link; ?>" title="<?php echo $title_sec; ?>">
							<?php echo $row->sect_name; ?></a>
					</td>
					<td>
						<a href="<?php echo $row->cat_link; ?>" title="<?php echo $title_cat; ?>">
							<?php echo $row->name; ?></a>
					</td>
					<td>
						<?php echo $author; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>
			<?php
			JCommonHTML::ContentLegend();
			?>
		</div>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}
}
?>
