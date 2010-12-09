<?php
/**
* @version		$Id: admin.templates.html.php 6219 2007-01-08 23:23:09Z louis $
* @package		Joomla
* @subpackage	Templates
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* @package		Joomla
* @subpackage	Templates
*/
class TemplatesView
{
	/**
	* @param array An array of data objects
	* @param object A page navigation object
	* @param string The option
	*/
	function showTemplates(& $rows, & $lists, & $page, $option, & $client)
	{
		global $mainframe;

		$limitstart = JRequest :: getVar('limitstart', '0', '', 'int');

		$user = & JFactory :: getUser();

		if (isset ($row->authorUrl) && $row->authorUrl != '') {
			$row->authorUrl = str_replace('http://', '', $row->authorUrl);
		}

		JCommonHTML :: loadOverlib();
?>
		<script language="javascript" type="text/javascript">
		<!--
		function showInfo(name, dir) {
			var pattern = /\b \b/ig;
			name = name.replace(pattern,'_');
			name = name.toLowerCase();
			var src = '<?php echo  ($client->id == 1 ? $mainframe->getSiteURL().'/administrator' : $mainframe->getSiteURL() );?>/templates/'+dir+'/template_thumbnail.png';
			var html=name;
			html = '<br /><img border="1" src="'+src+'" name="imagelib" alt="<?php echo JText::_( 'No preview available' ); ?>" width="206" height="145" />';
			return overlib(html, CAPTION, name)
		}
		-->
		</script>

		<form action="index.php" method="post" name="adminForm">

			<table class="adminlist">
			<thead>
				<tr>
					<th width="5" class="title">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th class="title" colspan="2">
						<?php echo JText::_( 'Name' ); ?>
					</th>
					<?php

		if ($client->id == 1) {
?>
						<th width="5%">
							<?php echo JText::_( 'Default' ); ?>
						</th>
						<?php

		} else {
?>
						<th width="5%">
							<?php echo JText::_( 'Default' ); ?>
						</th>
						<th width="5%">
							<?php echo JText::_( 'Assigned' ); ?>
						</th>
						<?php

		}
?>
					<th width="10%" align="center">
						<?php echo JText::_( 'Version' ); ?>
					</th>
					<th width="15%" class="title">
						<?php echo JText::_( 'Date' ); ?>
					</th>
					<th width="25%"  class="title">
						<?php echo JText::_( 'Author' ); ?>
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
		for ($i = 0, $n = count($rows); $i < $n; $i++) {
			$row = & $rows[$i];

			$author_info = @ $row->authorEmail . '<br />' . @ $row->authorUrl;
?>
				<tr class="<?php echo 'row'. $k; ?>">
					<td>
						<?php echo $page->getRowOffset( $i ); ?>
					</td>
					<td width="5">
					<?php

			if ($row->checked_out && $row->checked_out != $user->get('id')) {
?>
							&nbsp;
							<?php

			} else {
?>
							<input type="radio" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->directory; ?>" onclick="isChecked(this.checked);" />
							<?php

			}
?>
					</td>
					<td>
						<a href="index.php?option=com_templates&amp;task=edit&amp;cid[]=<?php echo $row->directory;?>&amp;client=<?php echo $client->id;?>&amp;hidemainmenu=1" onmouseover="showInfo('<?php echo $row->name;?>','<?php echo $row->directory; ?>')" onmouseout="return nd();">
							<?php echo $row->name;?></a>
					</td>
					<?php

			if ($client->id == 1) {
?>
						<td align="center">
							<?php

				if ($row->published == 1) {
?>
							<img src="templates/khepri/images/menu/icon-16-default.png" alt="<?php echo JText::_( 'Published' ); ?>" />
								<?php

				} else {
?>
								&nbsp;
								<?php

				}
?>
						</td>
						<?php

			} else {
?>
						<td align="center">
							<?php

				if ($row->published == 1) {
?>
								<img src="templates/khepri/images/menu/icon-16-default.png" alt="<?php echo JText::_( 'Default' ); ?>" />
								<?php

				} else {
?>
								&nbsp;
								<?php

				}
?>
						</td>
						<td align="center">
							<?php

				if ($row->assigned == 1) {
?>
								<img src="images/tick.png" alt="<?php echo JText::_( 'Assigned' ); ?>" />
								<?php

				} else {
?>
								&nbsp;
								<?php

				}
?>
						</td>
						<?php

			}
?>
					<td align="center">
						<?php echo $row->version; ?>
					</td>
					<td>
						<?php echo $row->creationdate; ?>
					</td>
					<td>
						<span onmouseover="return overlib('<?php echo $author_info; ?>', CAPTION, '<?php echo JText::_( 'Author Information' ); ?>', BELOW, LEFT);" onmouseout="return nd();">
							<?php echo @$row->author != '' ? $row->author : '&nbsp;'; ?>
						</span>
					</td>
				</tr>
				<?php

		}
?>
			</tbody>
			</table>

	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="client" value="<?php echo $client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
	</form>
	<?php

	}

	function previewTemplate($template, $showPositions, $client, $option)
	{
		global $mainframe;

		$tp = intval($showPositions);
		$url = $client->id ? JURI::base() : $mainframe->getSiteURL();
?>
		<style type="text/css">
		.previewFrame {
			border: none;
			width: 95%;
			height: 600px;
			padding: 0px 5px 0px 10px;
		}
		</style>

		<table class="adminform">
			<tr>
				<th width="50%" class="title">
					<?php echo JText::_( 'Site Preview' ); ?>
				</th>
				<th width="50%" style="text-align:right">
					<?php echo JHTML::Link($url.'index.php?tp='.$tp.'&amp;template='.$template, JText::_( 'Open in new window' ), array('target' => '_blank')); ?>
				</th>
			</tr>
			<tr>
				<td width="100%" valign="top" colspan="2">
					<?php echo JHTML::Iframe($url.'index.php?tp='.$tp.'&amp;template='.$template,'previewFrame',  array('class' => 'previewFrame')) ?>
				</td>
			</tr>
		</table>
		<?php

	}

	/**
	* @param string Template name
	* @param string Source code
	* @param string The option
	*/
	function editTemplate($row, $lists, & $params, $option, & $client)
	{
		JCommonHTML :: loadOverlib();
?>
		<form action="index.php" method="post" name="adminForm">

		<div class="col50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Details' ); ?></legend>

				<table class="admintable">
				<tr>
					<td valign="top" class="key">
						<?php echo JText::_( 'Name' ); ?>:
					</td>
					<td>
						<strong>
							<?php echo JText::_($row->name); ?>
						</strong>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo JText::_( 'Description' ); ?>:
					</td>
					<td>
						<?php echo JText::_($row->description); ?>
					</td>
				</tr>
				</table>
			</fieldset>

			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Menu Assignment' ); ?></legend>
				<script type="text/javascript">
					function allselections() {
						var e = document.getElementById('selections');
							e.disabled = true;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = true;
							e.options[i].selected = true;
						}
					}
					function disableselections() {
						var e = document.getElementById('selections');
							e.disabled = true;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = true;
							e.options[i].selected = false;
						}
					}
					function enableselections() {
						var e = document.getElementById('selections');
							e.disabled = false;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = false;
						}
					}
				</script>
				<table class="admintable" cellspacing="1">
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Menus' ); ?>:
						</td>
						<td>
							<?php if ($client->id == 1) {
									echo JText::_('Cannot assign administrator template');
								  } elseif ($row->pages == 'all') {
									echo JText::_('Cannot assign default template');
								  } elseif ($row->pages == 'none') { ?>
							<label for="menus-none"><input id="menus-none" type="radio" name="menus" value="none" onclick="disableselections();" checked="checked" /><?php echo JText::_( 'None' ); ?></label>
							<label for="menus-select"><input id="menus-select" type="radio" name="menus" value="select" onclick="enableselections();" /><?php echo JText::_( 'Select From List' ); ?></label>
							<?php } else { ?>
							<label for="menus-none"><input id="menus-none" type="radio" name="menus" value="none" onclick="disableselections();" /><?php echo JText::_( 'None' ); ?></label>
							<label for="menus-select"><input id="menus-select" type="radio" name="menus" value="select" onclick="enableselections();" checked="checked" /><?php echo JText::_( 'Select From List' ); ?></label>
							<?php } ?>
						</td>
					</tr>
					<?php if ($row->pages != 'all' && $client->id != 1) : ?>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Menu Selection' ); ?>:
						</td>
						<td>
							<?php echo $lists['selections']; ?>
							<?php if ($row->pages == 'none') { ?>
							<script type="text/javascript">disableselections();</script>
							<?php } ?>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			</fieldset>
		</div>

		<div class="col50">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>

				<table class="admintable">
				<tr>
					<td>
						<?php

		if (!is_null($params)) {
			echo $params->render();
		} else {
			echo '<i>' . JText :: _('No Parameters') . '</i>';
		}
?>
					</td>
				</tr>
				</table>
			</fieldset>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="id" value="<?php echo $row->directory; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="1" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
		</form>
		<?php
	}

	function editTemplateSource($template, & $content, $option, & $client)
	{
		$template_path = $client->path . '/templates/' . $template . '/index.php';
?>
		<form action="index.php" method="post" name="adminForm">

		<?php echo JText::_( 'This file is' ); ?>:
		<strong><?php echo is_writable($template_path) ? '<font color="green"> '. JText::_( 'Writeable' ) .'</font>' : '<font color="red"> '. JText::_( 'Unwriteable' ) .'</font>' ?></strong>
		<?php

		jimport('joomla.filesystem.path');
		if (JPath::canCHMOD($template_path)) {
			if (is_writable($template_path)) {
?>
					<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
					<label for="disable_write"><?php echo JText::_( 'Make unwriteable after saving' ); ?></label>
				<?php

			} else {
?>
					<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
					<label for="enable_write"><?php echo JText::_( 'Override write protection while saving' ); ?></label>
				<?php

			} // if
		} // if
?>

		<table class="adminform">
		<tr>
			<th>
				<?php echo $template_path; ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $content; ?></textarea>
			</td>
		</tr>
		</table>

		<div class="clr"></div>

		<input type="hidden" name="id" value="<?php echo $template; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
		</form>
		<?php
	}

	function chooseCSSFiles($template, $t_dir, $t_files, $option, & $client)
	{
?>
		<form action="index.php" method="post" name="adminForm">

		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="220">
				<span class="componentheading">&nbsp;</span>
			</td>
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="5%" align="left">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="85%" align="left">
				<?php echo $t_dir; ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Writeable' ); ?>/<?php echo JText::_( 'Unwriteable' ); ?>
			</th>
		</tr>
		<?php

		$k = 0;
		for ($i = 0, $n = count($t_files); $i < $n; $i++) {
			$file = & $t_files[$i];
?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td width="5%">
					<input type="radio" id="cb<?php echo $i;?>" name="filename" value="<?php echo '/templates/'. $template .'/css/'. $file; ?>" onClick="isChecked(this.checked);" />
				</td>
				<td width="85%">
					<?php echo $file; ?>
				</td>
				<td width="10%">
					<?php echo is_writable($t_dir .'/'. $file) ? '<font color="green"> '. JText::_( 'Writeable' ) .'</font>' : '<font color="red"> '. JText::_( 'Unwriteable' ) .'</font>' ?>
				</td>
			</tr>
		<?php

			$k = 1 - $k;
		}
?>
		</table>
		<input type="hidden" name="id" value="<?php echo $template; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="1" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
		</form>
		<?php

	}

	/**
	* @param string Template name
	* @param string Source code
	* @param string The option
	*/
	function editCSSSource($template, $filename, & $content, $option, & $client)
	{

		$css_path = $client->path . $filename;

?>
		<form action="index.php" method="post" name="adminForm">

		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="260">
				<span class="componentheading"><?php echo JText::_( 'template_css.css is' ); ?> :
				<b><?php echo is_writable($css_path) ? '<font color="green"> '. JText::_( 'Writeable' ) .'</font>' : '<font color="red"> '. JText::_( 'Unwriteable' ) .'</font>' ?></b>
				</span>
			</td>
			<?php

		jimport('joomla.filesystem.path');
		if (JPath::canCHMOD($css_path))
		{
			if (is_writable($css_path))
			{
				?>
				<td>
					<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
					<label for="disable_write"><?php echo JText::_( 'Make unwriteable after saving' ); ?></label>
				</td>
				<?php

			} else {
				?>
				<td>
					<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
					<label for="enable_write"><?php echo JText::_( 'Override write protection while saving' ); ?></label>
				</td>
				<?php

			} // if
		} // if
		?>
		</tr>
		</table>

		<table class="adminform">
		<tr>
			<th>
				<?php echo $css_path; ?>
			</th>
		</tr>
		<tr>
			<td>
				<textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $content; ?></textarea>
			</td>
		</tr>
		</table>


		<input type="hidden" name="id" value="<?php echo $template; ?>" />
		<input type="hidden" name="filename" value="<?php echo $filename; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="client" value="<?php echo $client->id;?>" />
		</form>
		<?php
	}

	/**
	* @param array
	* @param string The option
	*/
	function editPositions(& $positions, $option)
	{

		$rows = 25;
		$cols = 2;
		$n = $rows * $cols;
?>
		<form action="index.php" method="post" name="adminForm">

		<div id="pane-document">
			<table class="adminform">
			<tr>
			<?php

		for ($c = 0; $c < $cols; $c++) {
?>
				<th width="25">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th  class="title">
					<?php echo JText::_( 'Position' ); ?>
				</th>
				<th  class="title">
					<?php echo JText::_( 'Description' ); ?>
				</th>
				<?php

		}
?>
			</tr>
			<tfoot>
			<tr>
				<th colspan="6">
					&nbsp;
				</th>
			</tr>
			</tfoot>
			<?php

		$i = 1;
		$k = 0;
		for ($r = 0; $r < $rows; $r++) {
?>
				<tr class="<?php echo "row$k"; ?>">
				<?php

			for ($c = 0; $c < $cols; $c++) {
?>
					<td align="center">
						<label for="position<?php echo $i; ?>">
							<?php echo $i; ?>.
						</label>
					</td>
					<td>
						<input type="text" name="position[<?php echo $i; ?>]" id="position<?php echo $i; ?>" value="<?php echo @$positions[$i-1]->position; ?>" size="10" maxlength="50" />
					</td>
					<td>
						<input type="text" name="description[<?php echo $i; ?>]" value="<?php echo htmlspecialchars( @$positions[$i-1]->description ); ?>" size="40" maxlength="255" />
					</td>
					<?php

				$i++;
				$k = 1 - $k;
			}
?>
				</tr>
				<?php

		}
?>
			</table>
		</div>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php

	}
}
?>