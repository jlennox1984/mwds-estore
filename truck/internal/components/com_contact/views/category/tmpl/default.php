<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if ( $this->params->get( 'page_title' ) ) : ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php if ($this->category->name) :
	echo $this->params->get('header').' - '.$this->category->name;
else :
	echo $this->params->get('header');
endif; ?>
</div>
<?php endif; ?>
<div class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php if ($this->category->image || $this->category->description) : ?>
	<div class="contentdescription<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php if ($this->params->get('image') != -1 && $this->params->get('image') != '') : ?>
		<img src="images/stories/<?php echo $this->params->get('image'); ?>" align="<?php echo $this->params->get('image_align'); ?>" hspace="6" alt="<?php echo JText::_( 'Contacts' ); ?>" />
	<?php elseif ($this->category->image) : ?>
		<img src="images/stories/<?php echo $this->category->image; ?>" align="<?php echo $this->category->image_position; ?>" hspace="6" alt="<?php echo JText::_( 'Contacts' ); ?>" />
	<?php endif; ?>
	<?php echo $this->params->get('description_text', $this->category->description); ?>
	</div>
<?php endif; ?>
<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>
<form action="index.php" method="post" name="adminForm">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<thead>
		<tr>
			<td align="right" colspan="6">
			<?php if ($this->params->get('display')) :
				echo JText::_('Display Num') .'&nbsp;';
				echo $this->pagination->getLimitBox();
			endif; ?>
			</td>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td align="center" colspan="6" class="sectiontablefooter<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php echo $this->pagination->getPagesLinks(); ?>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php if ($this->params->get( 'headings' )) : ?>
		<tr>
			<td width="5" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php echo JText::_('Num'); ?>
			</td>
			<td height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php JCommonHTML::tableOrdering( 'Name', 'cd.name', $this->lists ); ?>
			</td>
			<?php if ( $this->params->get( 'position' ) ) : ?>
			<td height="20" class="sectiontableheader<?php echo  $this->params->get( 'pageclass_sfx' ); ?>">
				<?php JCommonHTML::tableOrdering( 'Position', 'cd.con_position', $this->lists ); ?>
			</td>
			<?php endif; ?>
			<?php if ( $this->params->get( 'email' ) ) : ?>
			<td height="20" width="20%" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php echo JText::_( 'Email' ); ?>
			</td>
			<?php endif; ?>
			<?php if ( $this->params->get( 'telephone' ) ) : ?>
			<td height="20" width="15%" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
				<?php echo JText::_( 'Phone' ); ?>
			</td>
			<?php endif; ?>
			<?php if ( $this->params->get( 'fax' ) ) : ?>
				<td height="20" width="15%" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
					<?php echo JText::_( 'Fax' ); ?>
				</td>
			<?php endif; ?>
		</tr>
	<?php endif; ?>
	<?php echo $this->loadTemplate('items'); ?>
</tbody>
</table>

<input type="hidden" name="option" value="com_contact" />
<input type="hidden" name="catid" value="<?php echo $this->category->id;?>" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
</form>
</div>