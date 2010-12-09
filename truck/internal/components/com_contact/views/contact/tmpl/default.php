<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if ( $this->params->get( 'page_title' ) && !$this->contact->params->get( 'popup' ) ) : ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php echo $this->params->get( 'header' ); ?>
</div>
<?php endif; ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php if ( $this->contact->params->get( 'drop_down' ) && count( $this->contacts ) > 1) : ?>
<tr>
	<td colspan="2" align="center">
		<br />
		<form method="post" name="selectForm" target="_top" id="selectForm">
		<?php echo JText::_( 'Select Contact' ); ?>:
			<br />
			<?php echo JHTMLSelect::genericList($this->contacts, 'contact_id', 'class="inputbox" onchange="this.form.submit()"', 'id', 'name', $this->contact->id);?>
			<option type="hidden" name="option" value="com_contact" />
			<option type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
		</form>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->name && $this->contact->params->get( 'name' ) ) : ?>
<tr>
	<td width="100%" class="contentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->contact->name; ?>
	</td>
</tr>
<?php endif; ?>
<?php if ( $this->contact->con_position && $this->contact->params->get( 'position' ) ) : ?>
<tr>
	<td colspan="2">
	<?php echo $this->contact->con_position; ?>
		<br /><br />
	</td>
</tr>
<?php endif; ?>
<tr>
	<td>
		<table border="0" width="100%">
		<tr>
			<td></td>
			<td rowspan="2" align="right" valign="top">
			<?php if ( $this->contact->image && $this->contact->params->get( 'image' ) ) : ?>
				<div style="float: right;">
					<img src="images/stories/<?php echo $this->contact->image; ?>" align="middle" alt="<?php echo JText::_( 'Contact' ); ?>" />
				</div>
			<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->loadTemplate('address'); ?>
			</td>
		</tr>
		</table>
	</td>
	<td>&nbsp;</td>
</tr>
<?php if ( $this->contact->params->get( 'vcard' ) ) : ?>
<tr>
	<td colspan="2">
	<?php echo JText::_( 'Download information as a' );?>
		<a href="index2.php?option=com_contact&amp;task=vcard&amp;contact_id=<?php echo $this->contact->id; ?>&amp;format=raw">
		<?php echo JText::_( 'VCard' );?>
		</a>
	</td>
</tr>
<?php endif;

if ( $this->contact->params->get('email_form') )
	echo $this->loadTemplate('form');
?>
</table>