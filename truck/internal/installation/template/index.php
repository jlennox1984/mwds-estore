<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{LANG_TAG}" lang="{LANG_TAG}" dir="{LANG_DIR}" >
	<head>
		<jdoc:include type="head" />

		<?php if($this->direction == 'rtl') : ?>
			<link href="template/css/template_rtl.css" rel="stylesheet" type="text/css" />
		<?php else : ?>
			<link href="template/css/template.css" rel="stylesheet" type="text/css" />
		<?php endif; ?>

		<script type="text/javascript" src="includes/js/installation.js"></script>
		<script type="text/javascript" src="../includes/js/joomla/common.js"></script>
		<script type="text/javascript" src="../includes/js/moofx/moo.fx.js"></script>
		<script type="text/javascript" src="../includes/js/moofx/moo.fx.pack.js"></script>
		<script type="text/javascript" src="template/js/moo.fx.effect.js"></script>
		<script type="text/javascript" src="template/js/validation.js"></script>
	</head>
	<body>
		<div id="header1">
			<div id="header2">
				<div id="header3">
					<div id="version"><?php echo JText::_('Version#') ?></div>
					<span><?php echo JText::_('Installation') ?></span>
				</div>
			</div>
		</div>
		<div id="content-box">
			<div id="content-pad">
				<jdoc:include type="installation" />

			</div>
		</div>
		<div id="footer1">
			<div id="footer2">
				<div id="footer3"></div>
			</div>
		</div>

		<div id="copyright"><a href="http://www.joomla.org" target="_blank">Joomla!</a>
			<?php echo JText::_('ISFREESOFTWARE') ?>
		</div>
		<script type="text/javascript">
			init_moofx();
		</script>
	</body>
</html>
