<form action="index.php?option=com_installer&amp;task=manage&amp;type=components" method="post" name="adminForm">
	<?php if ($this->state->get('message')) : ?>
		<?php echo $this->loadTemplate('message'); ?>
	<?php endif; ?>
	<?php if (count($this->items)) : ?>
	<table class="adminlist" cellspacing="1">
		<thead>
			<tr>
				<th class="title" width="10px"><?php echo JText::_( 'Num' ); ?></th>
				<th class="title" nowrap="nowrap"><?php echo JText::_( 'Currently Installed' ); ?></th>
				<th class="title" width="5%" align="center"><?php echo JText::_( 'Enabled' ); ?></th>
				<th class="title" width="10%" align="center"><?php echo JText::_( 'Version' ); ?></th>
				<th class="title" width="15%"><?php echo JText::_( 'Date' ); ?></th>
				<th class="title" width="25%"><?php echo JText::_( 'Author' ); ?></th>
			</tr>
		</thead>
		<tfoot>
			<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
		</tfoot>
		<tbody>
		<?php for ($i=0, $n=count($this->items), $rc=0; $i < $n; $i++, $rc = 1 - $rc) : ?>
			<?php
				$this->loadItem($i);
				echo $this->loadTemplate('item');
			?>
		<?php endfor; ?>
		</tbody>
	</table>
	<?php else : ?>
		<?php echo JText::_( 'There are no custom components installed' ); ?>
	<?php endif; ?>

	<input type="hidden" name="task" value="manage" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="option" value="com_installer" />
	<input type="hidden" name="type" value="components" />
</form>
