<?php
/**
 * @version		$Id: client.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

/**
 * @package		Joomla
 * @subpackage	Banners
 */
class BannersViewClients
{
	function setClientsToolbar()
	{
		JMenuBar::title( JText::_( 'Banner Client Manager' ), 'generic.png' );
		JMenuBar::deleteList( '', 'remove' );
		JMenuBar::editListX( 'edit' );
		JMenuBar::addNewX( 'add' );
		JMenuBar::help( 'screen.banners.client' );
	}

	function clients( &$rows, &$pageNav, &$lists )
	{
		BannersViewClients::setClientsToolbar();
		$user =& JFactory::getUser();
		JCommonHTML::loadOverlib();
		?>
		<form action="index.php" method="post" name="adminForm">

			<table>
			<tr>
				<td align="left" width="100%">
					<?php echo JText::_( 'Filter' ); ?>:
					<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
					<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
					<button onclick="getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
				</td>
				<td nowrap="nowrap">
				</td>
			</tr>
			</table>

			<table class="adminlist">
			<thead>
			<tr>
				<th width="20">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
				</th>
				<th nowrap="nowrap" class="title">
					<?php JCommonHTML::tableOrdering( 'Client Name', 'a.name', $lists ); ?>
				</th>
				<th nowrap="nowrap" class="title" width="35%">
					<?php JCommonHTML::tableOrdering( 'Contact', 'a.contact', $lists ); ?>
				</th>
				<th align="center" nowrap="nowrap" width="5%">
					<?php JCommonHTML::tableOrdering( 'No. of Active Banners', 'bid', $lists ); ?>
				</th>
				<th width="1%" nowrap="nowrap">
					<?php JCommonHTML::tableOrdering( 'ID', 'a.cid', $lists ); ?>
				</th>
			</tr>
			</thead>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$row->id 		= $row->cid;
				$link 			= ampReplace( 'index.php?option=com_banners&c=client&task=edit&cid[]='. $row->id );

				$checked 		= JCommonHTML::CheckedOutProcessing( $row, $i );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td>
						<?php echo $checked; ?>
					</td>
					<td>
						<?php
						if ( $row->checked_out && ( $row->checked_out != $user->get('id') ) ) {
							echo $row->name;
						} else {
							?>
							<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'Edit Banner Client' ); ?>">
								<?php echo $row->name; ?></a>
							<?php
						}
						?>
					</td>
					<td>
						<?php echo $row->contact; ?>
					</td>
					<td align="center">
						<?php echo $row->nbanners;?>
					</td>
					<td align="center">
						<?php echo $row->cid; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			<tfoot>
				<td colspan="6">
					<?php echo $pageNav->getListFooter(); ?>
				</td>
			</tfoot>
			</table>

		<input type="hidden" name="c" value="client" />
		<input type="hidden" name="option" value="com_banners" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
		</form>
		<?php
	}

	function setClientToolbar()
	{
		$cid = JRequest::getVar( 'cid', array(), 'method', 'array');

		JMenuBar::title( empty( $cid ) ? JText::_( 'New Banner Client' ) : JText::_( 'Edit Banner Client' ), 'generic.png' );
		JMenuBar::save( 'save' );
		JMenuBar::apply('apply');
		JMenuBar::cancel( 'cancel' );
		JMenuBar::help( 'screen.banners.client.edit' );
	}

	function client( &$row )
	{
		BannersViewClients::setClientToolbar();
		JRequest::setVar( 'hidemainmenu', 1 );
		jimport('joomla.filter.output');
		JOutputFilter::objectHTMLSafe( $row, ENT_QUOTES, 'extrainfo' );
		?>
		<script language="javascript" type="text/javascript">
		<!--
		function submitbutton(pressbutton)
		{
			var form = document.adminForm;
			if (pressbutton == 'cancelclient')
			{
				submitform( pressbutton );
				return;
			}
			// do field validation
			if (form.name.value == "")
			{
				alert( "<?php echo JText::_( 'Please fill in the Client Name.', true ); ?>" );
			}
			else if (form.contact.value == "")
			{
				alert( "<?php echo JText::_( 'Please fill in the Contact Name.', true ); ?>" );
			}
			else if (form.email.value == "")
			{
				alert( "<?php echo JText::_( 'Please fill in the Contact Email.', true ); ?>" );
			}
			else if (!isEmail( form.email.value ))
			{
				alert( "<?php echo JText::_( 'Please provide a valid Contact Email.', true ); ?>" );
			}
			else
			{
				submitform( pressbutton );
			}
		}
		//-->
		</script>

		<form action="index.php" method="post" name="adminForm">

		<div class="col50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

				<table class="admintable">
					<tr>
						<td width="20%" nowrap="nowrap">
							<label for="name">
								<?php echo JText::_( 'Client Name' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="name" id="name" size="40" maxlength="60" value="<?php echo $row->name; ?>" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">
							<label for="contact">
								<?php echo JText::_( 'Contact Name' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="contact" id="contact" size="40" maxlength="60" value="<?php echo $row->contact; ?>" />
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap">
							<label for="email">
								<?php echo JText::_( 'Contact Email' ); ?>:
							</label>
						</td>
						<td>
							<input class="inputbox" type="text" name="email" id="email" size="40" maxlength="60" value="<?php echo $row->email; ?>" />
						</td>
					</tr>
					</table>
			</fieldset>
		</div>

		<div class="col50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Extra Info' ); ?></legend>

				<table class="admintable">
				<tr>
					<td width="100%" valign="top">
						<textarea class="inputbox" name="extrainfo" id="extrainfo" cols="40" rows="10" style="width:90%"><?php echo str_replace('&','&amp;',$row->extrainfo);?></textarea>
					</td>
				</tr>
				</table>
			</fieldset>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="c" value="client" />
		<input type="hidden" name="option" value="com_banners" />
		<input type="hidden" name="cid" value="<?php echo $row->cid; ?>" />
		<input type="hidden" name="client_id" value="<?php echo $row->cid; ?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
	}
}