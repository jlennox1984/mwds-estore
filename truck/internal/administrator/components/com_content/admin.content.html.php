<?php
/**
* @version		$Id: admin.content.html.php 6291 2007-01-16 04:40:06Z Jinx $
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
 * HTML View class for the Content component
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.0
 */
class ContentView
{
	/**
	* Writes a list of the articles
	* @param array An array of article objects
	*/
	function showContent( &$rows, &$lists, $page, $redirect )
	{
		global $mainframe;

		// Initialize variables
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		//Ordering allowed ?
		$ordering = ($lists['order'] == 'section_name' && $lists['order_Dir'] == 'ASC');

		JCommonHTML::loadOverlib();
		?>
		<form action="index.php?option=com_content" method="post" name="adminForm">

			<table>
				<tr>
					<td width="100%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_( 'Filter by title or enter article ID' );?>"/>
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

			<table class="adminlist" cellspacing="1">
			<thead>
				<tr>
					<th width="5">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th width="5">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
					</th>
					<th class="title">
						<?php JCommonHTML::tableOrdering( 'Title', 'c.title', $lists ); ?>
					</th>
					<th width="1%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Published', 'c.state', $lists ); ?>
					</th>
					<th nowrap="nowrap" width="1%">
						<?php JCommonHTML::tableOrdering( 'Front Page', 'frontpage', $lists ); ?>
					</th>
					<th width="80">
						<a href="javascript:tableOrdering('section_name','DESC');" title="<?php echo JText::_( 'Order by' ); ?> <?php echo JText::_( 'Order' ); ?>">
							<?php echo JText::_( 'Order' ); ?>
						</a>
					</th>
					<th width="1%">
						<?php JCommonHTML::saveorderButton( $rows ); ?>
					</th>
					<th width="7%">
						<?php JCommonHTML::tableOrdering( 'Access', 'groupname', $lists ); ?>
					</th>
					<th width="2%" class="title">
						<?php JCommonHTML::tableOrdering( 'ID', 'c.id', $lists ); ?>
					</th>
					<th class="title" width="8%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Section', 'section_name', $lists ); ?>
					</th>
					<th  class="title" width="8%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Category', 'cc.name', $lists ); ?>
					</th>
					<th  class="title" width="8%" nowrap="nowrap">
						<?php JCommonHTML::tableOrdering( 'Author', 'author', $lists ); ?>
					</th>
					<th align="center" width="10">
						<?php JCommonHTML::tableOrdering( 'Date', 'c.created', $lists ); ?>
					</th>
					<th align="center" width="10">
						<?php JCommonHTML::tableOrdering( 'Hits', 'c.hits', $lists ); ?>
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
			$nullDate = $db->getNullDate();
			for ($i=0, $n=count( $rows ); $i < $n; $i++)
			{
				$row = &$rows[$i];

				$link 	= 'index.php?option=com_content&sectionid='. $redirect .'&task=edit&hidemainmenu=1&cid[]='. $row->id;

				$row->sect_link = ampReplace( 'index.php?option=com_sections&task=edit&hidemainmenu=1&cid[]='. $row->sectionid );
				$row->cat_link 	= ampReplace( 'index.php?option=com_categories&task=edit&hidemainmenu=1&cid[]='. $row->catid );

				$now = date( 'Y-m-d H:i:s' );
				if ( $now <= $row->publish_up && $row->state == 1 ) {
					$img = 'publish_y.png';
					$alt = JText::_( 'Published' );
				} else if ( ( $now <= $row->publish_down || $row->publish_down == $nullDate ) && $row->state == 1 ) {
					$img = 'publish_g.png';
					$alt = JText::_( 'Published' );
				} else if ( $now > $row->publish_down && $row->state == 1 ) {
					$img = 'publish_r.png';
					$alt = JText::_( 'Expired' );
				} else if ( $row->state == 0 ) {
					$img = 'publish_x.png';
					$alt = JText::_( 'Unpublished' );
				} else if ( $row->state == -1 ) {
					$img = 'disabled.png';
					$alt = JText::_( 'Archived' );
				}
				$times = '';
				if (isset($row->publish_up)) {
					if ($row->publish_up == $nullDate) {
						$times .= "<tr><td>". JText::_( 'Start: Always' ) ."</td></tr>";
					} else {
						$times .= "<tr><td>". JText::_( 'Start' ) .": ". $row->publish_up ."</td></tr>";
					}
				}
				if (isset($row->publish_down)) {
					if ($row->publish_down == $nullDate) {
						$times .= "<tr><td>". JText::_( 'Finish: No Expiry' ) ."</td></tr>";
					} else {
						$times .= "<tr><td>". JText::_( 'Finish' ) .": ". $row->publish_down ."</td></tr>";
					}
				}

				if ( $user->authorize( 'com_users', 'manage' ) ) {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$linkA 	= 'index.php?option=com_users&task=edit&hidemainmenu=1&cid[]='. $row->created_by;
						$author = '<a href="'. ampReplace( $linkA ) .'" title="'. JText::_( 'Edit User' ) .'">'. $row->author .'</a>';
					}
				} else {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$author = $row->author;
					}
				}

				$access 	= JCommonHTML::AccessProcessing( $row, $i, $row->state );
				$checked 	= JCommonHTML::CheckedOutProcessing( $row, $i );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td align="center">
						<?php echo $checked; ?>
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
						if ( $row->checked_out && ( $row->checked_out != $user->get('id') ) ) {
							echo $row->title;
						} else if ($row->state == -1) {
							echo htmlspecialchars($row->title, ENT_QUOTES);
							echo ' [ '. JText::_( 'Archived' ) .' ]';
						} else {
							?>
							<a href="<?php echo ampReplace( $link ); ?>">
								<?php echo htmlspecialchars($row->title, ENT_QUOTES); ?></a>
							<?php
						}
						?>
					</td>
					<?php
					if ( $times ) {
						?>
						<td align="center" onmouseover="return overlib('<table><?php echo $times; ?></table>', CAPTION, '<?php echo JText::_( 'Publish Information' ); ?>', BELOW, RIGHT);" onmouseout="return nd();">
							<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->state ? 'unpublish' : 'publish' ?>')">
								<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
						</td>
						<?php
					}
					?>
					<td align="center">
						<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','toggle_frontpage')" title="<?php echo ( $row->frontpage ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>">
							<img src="images/<?php echo ( $row->frontpage ) ? 'tick.png' : ( $row->state != -1 ? 'publish_x.png' : 'disabled.png' );?>" width="16" height="16" border="0" alt="<?php echo ( $row->frontpage ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>" /></a>
					</td>
					<td class="order" colspan="2">
						<span><?php echo $page->orderUpIcon( $i, ($row->catid == @$rows[$i-1]->catid), 'orderup', 'Move Up', $ordering); ?></span>
						<span><?php echo $page->orderDownIcon( $i, $n, ($row->catid == @$rows[$i+1]->catid), 'orderdown', 'Move Down', $ordering ); ?></span>
						<?php $disabled = $ordering ?  '' : '"disabled=disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?> class="text_area" style="text-align: center" />
					</td>
					<td align="center">
						<?php echo $access;?>
					</td>
					<td>
						<?php echo $row->id; ?>
					</td>
						<td>
							<a href="<?php echo $row->sect_link; ?>" title="<?php echo JText::_( 'Edit Section' ); ?>">
								<?php echo $row->section_name; ?></a>
						</td>
					<td>
						<a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>">
							<?php echo $row->name; ?></a>
					</td>
					<td>
						<?php echo $author; ?>
					</td>
					<td nowrap="nowrap">
						<?php echo JHTML::Date( $row->created, DATE_FORMAT_LC4 ); ?>
					</td>
					<td nowrap="nowrap" align="center">
						<?php echo $row->hits ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>
			<?php JCommonHTML::ContentLegend(); ?>

		<input type="hidden" name="option" value="com_content" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}


	/**
	* Writes a list of the articles
	* @param array An array of article objects
	*/
	function showArchive( &$rows, $section, &$lists, $pageNav, $option, $all=NULL, $redirect )
	{
		// Initialize variables
		$user	= &JFactory::getUser();
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if (pressbutton == 'remove') {
				if (document.adminForm.boxchecked.value == 0) {
					alert("<?php echo JText::_( 'VALIDSELECTIONLISTSENDTRASH', true ); ?>");
				} else if ( confirm("<?php echo JText::_( 'VALIDTRASHSELECTEDITEMS', true ); ?>")) {
					submitform('remove');
				}
			} else {
				submitform(pressbutton);
			}
		}
		</script>
		<form action="index.php?option=com_content&amp;task=showarchive&amp;sectionid=0" method="post" name="adminForm">

		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<input type="button" value="<?php echo JText::_( 'Go' ); ?>" class="button" onclick="this.form.submit();" />
				<input type="button" value="<?php echo JText::_( 'Reset' ); ?>" class="button" onclick="getElementById('search').value='';this.form.submit();" />
			</td>
			<td nowrap="nowrap">
				<?php
				if ( $all ) {
					echo $lists['sectionid'];
				}
				echo $lists['catid'];
				echo $lists['authorid'];
				?>
			</td>
		</tr>
		</table>

		<div id="tablecell">
			<table class="adminlist">
			<tr>
				<th width="5">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
				</th>
				<th class="title">
					<?php JCommonHTML::tableOrdering( 'Title', 'c.title', $lists, 'showarchive' ); ?>
				</th>
				<th width="3%"  class="title">
					<?php JCommonHTML::tableOrdering( 'ID', 'c.id', $lists, 'showarchive' ); ?>
				</th>
				<th width="15%"  class="title">
					<?php JCommonHTML::tableOrdering( 'Section', 'sectname', $lists, 'showarchive' ); ?>
				</th>
				<th width="15%"  class="title">
					<?php JCommonHTML::tableOrdering( 'Category', 'cc.name', $lists, 'showarchive' ); ?>
				</th>
				<th width="15%"  class="title">
					<?php JCommonHTML::tableOrdering( 'Author', 'author', $lists, 'showarchive' ); ?>
				</th>
				<th align="center" width="10">
					<?php JCommonHTML::tableOrdering( 'Date', 'c.created', $lists, 'showarchive' ); ?>
				</th>
			</tr>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$row->cat_link 	= ampReplace( 'index.php?option=com_categories&task=edit&hidemainmenu=1&cid[]='. $row->catid );
				$row->sec_link 	= ampReplace( 'index.php?option=com_sections&task=edit&hidemainmenu=1&cid[]='. $row->sectionid );

				if ( $user->authorize( 'com_users', 'manage' ) ) {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$linkA 	= ampReplace( 'index.php?option=com_users&task=edit&hidemainmenu=1&cid[]='. $row->created_by );
						$author = '<a href="'. $linkA .'" title="'. JText::_( 'Edit User' ) .'">'. $row->author .'</a>';
					}
				} else {
					if ( $row->created_by_alias ) {
						$author = $row->created_by_alias;
					} else {
						$author = $row->author;
					}
				}

				?>
				<tr class="<?php echo "row$k"; ?>">
					<td>
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td width="20">
						<?php echo JHTML::idBox( $i, $row->id ); ?>
					</td>
					<td>
						<?php echo $row->title; ?>
					</td>
					<td>
						<?php echo $row->id; ?>
					</td>
					<td>
						<a href="<?php echo $row->sec_link; ?>" title="<?php echo JText::_( 'Edit Section' ); ?>">
							<?php echo $row->sectname; ?></a>
					</td>
					<td>
						<a href="<?php echo $row->cat_link; ?>" title="<?php echo JText::_( 'Edit Category' ); ?>">
							<?php echo $row->name; ?></a>
					</td>
					<td>
						<?php echo $author; ?>
					</td>
					<td nowrap="nowrap">
						<?php echo JHTML::Date( $row->created, JText::_( 'DATE_FORMAT_LC4' ) ); ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			<tfoot>
				<td colspan="8">
					<?php echo $pageNav->getListFooter(); ?>
				</td>
			</tfoot>
			</table>
		</div>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $section->id;?>" />
		<input type="hidden" name="task" value="showarchive" />
		<input type="hidden" name="returntask" value="showarchive" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="redirect" value="<?php echo $redirect;?>" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}


	/**
	* Writes the edit form for new and existing article
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param JTableContent The category object
	* @param string The html for the groups select list
	*/
	function editContent( &$row, $section, &$lists, &$sectioncategories, &$params, $option, &$form )
	{
		jimport('joomla.html.pane');
		jimport('joomla.filter.output');
		JOutputFilter::objectHTMLSafe( $row );

		$db		=& JFactory::getDBO();
		$editor =& JFactory::getEditor();
		$pane	=& JPane::getInstance('sliders');

		JCommonHTML::loadOverlib();
		JCommonHTML::loadCalendar();
		?>
		<script language="javascript" type="text/javascript">
		<!--
		var sectioncategories = new Array;
		<?php
		$i = 0;
		foreach ($sectioncategories as $k=>$items) {
			foreach ($items as $v) {
				echo "sectioncategories[".$i++."] = new Array( '$k','".addslashes( $v->id )."','".addslashes( $v->name )."' );\n\t\t";
			}
		}
		?>

		function submitbutton(pressbutton)
		{
			var form = document.adminForm;

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "<?php echo JText::_( 'Please select a Menu', true ); ?>" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "<?php echo JText::_( 'Please enter a Name for this menu item', true ); ?>" );
					return;
				}
			}

			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (form.title.value == ""){
				alert( "<?php echo JText::_( 'Article must have a title', true ); ?>" );
			} else if (form.sectionid.value == "-1"){
				alert( "<?php echo JText::_( 'You must select a Section.', true ); ?>" );
			} else if (form.catid.value == "-1"){
				alert( "<?php echo JText::_( 'You must select a Category.', true ); ?>" );
 			} else if (form.catid.value == ""){
 				alert( "<?php echo JText::_( 'You must select a Category.', true ); ?>" );
			} else {
				<?php
				echo $editor->save( 'text' );
				?>
				submitform( pressbutton );
			}
		}
		//-->
		</script>

		<form action="index.php" method="post" name="adminForm">

		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top">
				<?php ContentView::_displayArticleDetails( $row, $lists, $params ); ?>
				<table class="adminform">
				<tr>
					<td>
						<?php
						// parameters : areaname, content, width, height, cols, rows
						echo $editor->display( 'text',  $row->text , '100%', '550', '75', '20' ) ;
						echo $editor->getButtons('text');
						?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" width="320" style="padding: 7px 0 0 5px">
			<?php
				ContentView::_displayArticleStats($row, $lists, $params);

				$title = JText::_( 'PARAMBASIC' );
				$pane->startPane("content-pane");
				$pane->startPanel( $title, "detail-page" );

				echo $form->render('details');
				//ContentView::_paneDetails(  $row, $lists, $params );

				$title = JText::_( 'PARAMADVANCED' );
				$pane->endPanel();
				$pane->startPanel( $title, "params-page" );

				echo $form->render('params', 'advanced');
				//ContentView::_paneParameters( $row, $lists, $params );

				$title = JText::_( 'Metadata Information' );
				$pane->endPanel();
				$pane->startPanel( $title, "metadata-page" );

				echo $form->render('meta', 'metadata');
				//ContentView::_paneMetaInfo( $row, $lists, $params );

				$pane->endPanel();
				$pane->endPane();
			?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="version" value="<?php echo $row->version; ?>" />
		<input type="hidden" name="mask" value="0" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
		<?php
		JHTML::keepAlive();
	}


	/**
	* Form to select Section/Category to move item(s) to
	* @param array An array of selected objects
	* @param int The current section we are looking at
	* @param array The list of sections and categories to move to
	*/
	function moveSection( $cid, $sectCatList, $option, $sectionid, $items )
	{
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectcat' )) {
				alert( "<?php echo JText::_( 'Please select something', true ); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>

		<form action="index.php" method="post" name="adminForm">

		<table class="adminform">
		<tr>
			<td  valign="top" width="40%">
			<strong><?php echo JText::_( 'Move to Section/Category' ); ?>:</strong>
			<br />
			<?php echo $sectCatList; ?>
			<br /><br />
			</td>
			<td  valign="top">
			<strong><?php echo JText::_( 'Items being Moved' ); ?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ($cid as $id) {
			echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}



	/**
	* Form to select Section/Category to copys item(s) to
	*/
	function copySection( $option, $cid, $sectCatList, $sectionid, $items  )
	{
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectcat' )) {
				alert( "<?php echo JText::_( 'VALIDSELECTSECTCATCOPYITEMS', true ); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<form action="index.php" method="post" name="adminForm">

		<table class="adminform">
		<tr>
			<td  valign="top" width="40%">
			<strong><?php echo JText::_( 'Copy to Section/Category' ); ?>:</strong>
			<br />
			<?php echo $sectCatList; ?>
			<br /><br />
			</td>
			<td  valign="top">
			<strong><?php echo JText::_( 'Items being copied' ); ?>:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="sectionid" value="<?php echo $sectionid; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ($cid as $id) {
			echo "\n<input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		</form>
		<?php
	}

	function previewContent()
	{
		$document	=& JFactory::getDocument();
		$editor		=& JFactory::getEditor();

		$document->addScript('../includes/js/joomla/caption.js');

		?>
		<script>
		var form = window.top.document.adminForm
		var title = form.title.value;

		var alltext = window.top.<?php echo $editor->getContent('text') ?>;
		alltext = alltext.replace('<hr id=\"system-readmore\" \/>', '');
		</script>



		<table align="center" width="90%" cellspacing="2" cellpadding="2" border="0">
			<tr>
				<td class="contentheading" colspan="2"><script>document.write(title);</script></td>
			</tr>
		<tr>
			<script>document.write("<td valign=\"top\" height=\"90%\" colspan=\"2\">" + alltext + "</td>");</script>
		</tr>
		</table>
		<?php
	}

	/**
	* Renders pagebreak options
	*
	*/
	function insertPagebreak()
	{
		?>
		<script type="text/javascript">
			function insertPagebreak()
			{
				// Get the pagebreak title
				var title = document.getElementById("title").value;
				if (title != '') {
					title = "title=\""+title+"\" ";
				}

				// Get the pagebreak toc alias -- not inserting for now
				// don't know which attribute to use...
				var alt = document.getElementById("alt").value;
				if (alt != '') {
					alt = "alt=\""+alt+"\" ";
				}

				var tag = "<hr class=\"system-pagebreak\" "+title+" "+alt+"/>";

				window.parent.jInsertEditorText(tag);
				return false;
			}
		</script>

		<form>
		<table width="100%" align="center">
			<tr width="40%">
				<td class="key" align="right">
					<label for="title">
						<?php echo JText::_( 'PGB PAGE TITLE' ); ?>
					</label>
				</td>
				<td>
					<input type="text" id="title" name="title" />
				</td>
			</tr>
			<tr width="60%">
				<td class="key" align="right">
					<label for="alias">
						<?php echo JText::_( 'PGB TOC ALIAS PROMPT' ); ?>
					</label>
				</td>
				<td>
					<input type="text" id="alt" name="alt" />
				</td>
			</tr>
		</table>
		</form>
		<button onclick="insertPagebreak();window.top.document.popup.hide();"><?php echo JText::_( 'PGB INS PAGEBRK' ); ?></button>
		<?php
	}

	function _paneDetails(&$row, &$lists, &$params )
	{
		?>
		<table>
		<tr>
			<td>
				<label for="created_by">
					<?php echo JText::_( 'Author' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $lists['created_by']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="created_by_alias">
					<?php echo JText::_( 'Author Alias' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="created_by_alias" id="created_by_alias" size="30" maxlength="100" value="<?php echo $row->created_by_alias; ?>" class="inputbox" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="access">
					<?php echo JText::_( 'Access Level' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $lists['access']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="created">
					<?php echo JText::_( 'Created Date' ); ?>
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="created" id="created" size="25" maxlength="19" value="<?php echo JHTML::Date($row->created, "%Y-%m-%d %H:%M:%S"); ?>" />
				<input name="reset" type="reset" class="button" onclick="return showCalendar('created', 'y-mm-dd');" value="..." />
			</td>
		</tr>
		<tr>
			<td>
				<label for="publish_up">
					<?php echo JText::_( 'Start Publishing' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="publish_up" id="publish_up" size="25" maxlength="19" value="<?php echo JHTML::Date($row->publish_up, "%Y-%m-%d %H:%M:%S"); ?>" />
				<input type="reset" class="button" value="..." onclick="return showCalendar('publish_up', 'y-mm-dd');" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="publish_down">
					<?php echo JText::_( 'Finish Publishing' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="publish_down" id="publish_down" size="25" maxlength="19" value="<?php echo $row->publish_down;  ?>" />
				<input type="reset" class="button" value="..." onclick="return showCalendar('publish_down', 'y-mm-dd');" />
			</td>
		</tr>
		</table>
		<?php
	}

	function _paneMetaInfo( &$row, &$lists, &$params )
	{
		?>
		<table>
		<tr>
			<td>
				<label for="metadesc">
					<?php echo JText::_( 'Description' ); ?>:
				</label>
				<br />
				<textarea class="inputbox" cols="40" rows="5" name="metadesc" id="metadesc" style="width:300px;"><?php echo str_replace('&','&amp;',$row->metadesc); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="metakey">
					<?php echo JText::_( 'Keywords' ); ?>:
				</label>
				<br />
				<textarea class="inputbox" cols="40" rows="5" name="metakey" id="metakey" style="width:300px;"><?php echo str_replace('&','&amp;',$row->metakey); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="button" value="<?php echo JText::_( 'Add Sect/Cat/Title' ); ?>" onclick="f=document.adminForm;if(document.adminForm.sectionid.options[document.adminForm.sectionid.selectedIndex].text != '<?php echo '- '.JText::_('Select Section').' -'; ?>') { if(getSelectedText('adminForm','catid') != '<?php echo JText::_('Uncategorized'); ?>') {f.metakey.value=document.adminForm.sectionid.options[document.adminForm.sectionid.selectedIndex].text+', '+getSelectedText('adminForm','catid')+', '+f.title.value+f.metakey.value; } }" />
			</td>
		</tr>
		</table>
		<?php
	}

	function _paneParameters( &$row, &$lists, &$params )
	{
		?>
		<table>
		<tr>
			<td>
				<?php echo JText::_( 'DESCPARAMCONTROLWHATSEE' ); ?>
				<br /><br />
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $params->render();?>
			</td>
		</tr>
		</table>
		<?php
	}

	function _displayArticleDetails(&$row, &$lists, &$params )
	{
		?>
		<table  class="adminform">
		<tr>
			<td>
				<label for="title">
					<?php echo JText::_( 'Title' ); ?>
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="title" id="title" size="40" maxlength="255" value="<?php echo $row->title; ?>" />
			</td>
			<td>
				<label>
					<?php echo JText::_( 'Published' ); ?>
				</label>
			</td>
			<td>
				<?php echo $lists['state']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="title_alias">
					<?php echo JText::_( 'Title Alias' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="title_alias" id="title_alias" size="40" maxlength="255" value="<?php echo $row->title_alias; ?>" />
			</td>
			<td>
				<label>
				<?php echo JText::_( 'Frontpage' ); ?>
				</label>
			</td>
			<td>
				<?php echo $lists['frontpage']; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="sectionid">
					<?php echo JText::_( 'Section' ); ?>
				</label>
			</td>
			<td>
				<?php echo $lists['sectionid']; ?>
			</td>
			<td>
				<label for="catid">
					<?php echo JText::_( 'Category' ); ?>
				</label>
			</td>
			<td>
				<?php echo $lists['catid']; ?>
			</td>
		</tr>
		</table>
		<?php
	}

	function _displayArticleStats(&$row, &$lists, &$params)
	{
		$db =& JFactory::getDBO();

		$create_date 	= null;
		$nullDate 		= $db->getNullDate();

		// used to hide "Reset Hits" when hits = 0
		if ( !$row->hits ) {
			$visibility = 'style="display: none; visibility: hidden;"';
		} else {
			$visibility = '';
		}

		?>
		<table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
		<?php
		if ( $row->id ) {
		?>
		<tr>
			<td>
				<strong><?php echo JText::_( 'Article ID' ); ?>:</strong>
			</td>
			<td>
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td>
				<strong><?php echo JText::_( 'State' ); ?></strong>
			</td>
			<td>
				<?php echo $row->state > 0 ? JText::_( 'Published' ) : ($row->state < 0 ? JText::_( 'Archived' ) : JText::_( 'Draft Unpublished' ) );?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo JText::_( 'Hits' ); ?></strong>
			</td>
			<td>
				<?php echo $row->hits;?>
				<span <?php echo $visibility; ?>>
					<input name="reset_hits" type="button" class="button" value="<?php echo JText::_( 'Reset' ); ?>" onclick="submitbutton('resethits');" />
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo JText::_( 'Revised' ); ?></strong>
			</td>
			<td>
				<?php echo $row->version;?> <?php echo JText::_( 'times' ); ?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo JText::_( 'Created' ); ?></strong>
			</td>
			<td>
				<?php
				if ( $row->created == $nullDate ) {
					echo JText::_( 'New document' );
				} else {
					echo JHTML::Date( $row->created,  DATE_FORMAT_LC2);
				}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php echo JText::_( 'Modified' ); ?></strong>
			</td>
			<td>
				<?php
					if ( $row->modified == $nullDate ) {
						echo JText::_( 'Not modified' );
					} else {
						echo JHTML::Date( $row->modified, DATE_FORMAT_LC2);
					}
				?>
			</td>
		</tr>
		</table>
		<?php
	}
}
?>
