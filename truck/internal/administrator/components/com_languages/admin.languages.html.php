<?php
/**
* @version		$Id: admin.languages.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Languages
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
* @subpackage	Languages
*/
class HTML_languages {

	function showLanguages( &$rows, &$page, $option, &$client )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');
		$user =& JFactory::getUser();

		JCommonHTML::loadOverlib();
		?>
		<form action="index.php" method="post" name="adminForm">

			<table class="adminlist">
			<thead>
			<tr>
				<th width="20">
					<?php echo JText::_( 'Num' ); ?>
				</th>
				<th width="30">
				&nbsp;
				</th>
				<th width="25%" class="title">
					<?php echo JText::_( 'Language' ); ?>
				</th>
				<th width="5%">
					<?php echo JText::_( 'Published' ); ?>
				</th>
				<th width="10%">
					<?php echo JText::_( 'Version' ); ?>
				</th>
				<th width="10%">
					<?php echo JText::_( 'Date' ); ?>
				</th>
				<th width="20%">
					<?php echo JText::_( 'Author' ); ?>
				</th>
				<th width="25%">
					<?php echo JText::_( 'Author Email' ); ?>
				</th>
			</tr>
			</thead>
			<tfoot>
				<td colspan="8">
					<?php echo $page->getListFooter(); ?>
				</td>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td width="20">
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td width="20">
						<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->language; ?>" onclick="isChecked(this.checked);" />
					</td>
					<td width="25%">
						<?php echo $row->name;?>
					</td>
					<td width="5%" align="center">
						<?php
						if ($row->published == 1) {	 ?>
							<img src="images/tick.png" alt="<?php echo JText::_( 'Published' ); ?>" />
							<?php
						} else {
							?>
							&nbsp;
						<?php
						}
					?>
					</td>
					<td align="center">
						<?php echo $row->version; ?>
					</td>
					<td align="center">
						<?php echo $row->creationdate; ?>
					</td>
					<td align="center">
						<?php echo $row->author; ?>
					</td>
					<td align="center">
						<?php echo $row->authorEmail; ?>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
			</table>
		</div>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
		<?php
	}
}
?>