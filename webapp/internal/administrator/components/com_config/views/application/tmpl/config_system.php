<fieldset class="adminform">
	<legend><?php echo JText::_( 'System Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">

		<tbody>
			<tr>
				<td width="185" class="key">
					<?php echo JText::_( 'Secret Word' ); ?>
				</td>
				<td>
					<strong><?php echo $row->secret; ?></strong>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Path to Log-folder' ); ?>::<?php echo JText::_( 'TIPLOGFOLDER' ); ?>">
						<?php echo JText::_( 'Path to Log-folder' ); ?>
					</span>
				</td>
				<td>
					<input class="text_area" type="text" size="50" name="log_path" value="<?php echo $row->log_path; ?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo JText::_( 'Enable Legacy Mode' ); ?>
				</td>
				<td>
					<?php echo $lists['legacy']; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<?php echo JText::_( 'Enable XML-RPC' ); ?>
				</td>
				<td>
					<?php echo $lists['xmlrpc_server']; ?>
				</td>
			</tr>
			<tr>
			<td class="key">
				<?php echo JText::_( 'Help Server' ); ?>
			</td>
			<td>
				<?php echo $lists['helpsites']; ?>
				<button onclick="submitbutton('refreshhelp')"><?php echo JText::_( 'Refresh' ); ?></button>
			</td>
		</tr>
		</tbody>
	</table>
</fieldset>
