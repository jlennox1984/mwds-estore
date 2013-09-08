<?php defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if ( $my->id ) { initEditor(); } ?>
<meta http-equiv="Content-Type" content="text/html;><?php echo _ISO; ?>" />
<?php mosShowHead(); ?>
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/template_css.css\" type=\"text/css\"/>" ; ?>
<!--[if lte IE 6]>
<link href="<?php echo JURL_SITE;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_ie_only.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php echo "<link rel=\"shortcut icon\" href=\"$GLOBALS[mosConfig_live_site]/images/favicon.ico\" />" ; ?>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0"><tr><td>
	<table class="toptable" cellpadding="0" cellspacing="0"><tr><td class="datebox">

	<span class="small">
	<?php
	$tag = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
	$monat = array("Januar","Februar","M&auml;rz","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember");

	$akt_tag = date(w);
	$akt_tagzahl = date(j);
	$akt_monat = date(n) - 1;
	$akt_jahr = date(Y);
	$akt_stunde = date(H);
	$akt_minute = date(i);
	$akt_swatch = date(B);

	$heute = $tag[$akt_tag].", ".$akt_tagzahl.". ".$monat[$akt_monat]." ".$akt_jahr;
	$uhrzeit = $akt_stunde.":".$akt_minute;

	echo $heute."";
	?>
	</span>

	</td></tr></table>
</td></tr>
<tr><td>
	<table cellpadding="0" cellspacing="0" class="maintable" align="center">
		<tr>
			<td class="headerimage">
				<table cellpadding="0" cellspacing="0"><tr><td class="titel">
				<div style="padding: 3px;"><?php echo $mosConfig_sitename; ?></div>
				</td></tr></table>
			</td>
		</tr>
		<tr>
		<td class="pathway">
		<span class="pathway">&nbsp;&nbsp;Sie sind hier:&nbsp;&nbsp;<?php include "pathway.php"; ?></span>
		</td>
	</tr>
	<tr>
		<td>
		<!--CONTENT-->
		
		<table cellpadding="3" style="margin-top:2px; margin-left:0px;"><tr>
			<td class="leftcol" valign="top">
			<?php mosLoadModules ( 'left' ); ?>
			</td>
			<td class="rightcol" valign="top">
			<?php include ("mainbody.php"); ?>
			</td>
		</tr></table>
		<!--EOF CONTENT-->
		</td>
	</tr>
</table>
</body>
</html>
