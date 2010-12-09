<?php defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );$iso = split( '=', _ISO );echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require($GLOBALS[mosConfig_absolute_path]."/templates/" . $GLOBALS[cur_template] . "/mysplitcssmenu.php"); ?>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html;><?php echo _ISO; ?>" />
<?php if ( $my->id ) { initEditor(); } ?>
<?php echo "<link rel=\"stylesheet\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/css/template_css.css\" type=\"text/css\"/>" ; ?><?php echo "<link rel=\"shortcut icon\" href=\"$GLOBALS[mosConfig_live_site]/templates/$GLOBALS[cur_template]/favicon.ico\" />" ; ?>
</head>
<body>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="topcontainer"><div id="navcontainer">
      <table height="35" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <td><img src="<?php echo $GLOBALS[mosConfig_live_site]?>/templates/<?php echo $GLOBALS[cur_template]?>/images/menucontainer_left.gif" border="0" width="10" height="35" /></td>
          <td class="topmenucontainer"><div id="topmenu"><?php echo $mycssPSPLITmenu_content; ?></div></td>
          <td><img src="<?php echo $GLOBALS[mosConfig_live_site]?>/templates/<?php echo $GLOBALS[cur_template]?>/images/menucontainer_right.gif" border="0" width="10" height="35" /></td>
        </tr>
      </table>
    </div></td>
  </tr>
    <tr>
    <td class="headercontainer"><table width="680" border="0" align="center" cellpadding="0" cellspacing="0" class="header">
      <tr>
        <td height="20" align="center" class="submenucontainer"><?php echo $mycssSSPLITmenu_content; ?></td>
      </tr>
      <tr>
        <td><div id="sitenamecontainer"><?php echo $mosConfig_sitename; ?></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="middlecontainer"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="maincontenttable">
      <tr>
        <td>          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
            <?php if(mosCountModules( "top")) { ?>
			<tr>
              <td><?php mosLoadModules ( 'top',-2 ); ?></td>
            </tr>
			<?php } ?>
		 	<?php if(mosCountModules( "user1")) { ?>
			<tr>
              <td><?php mosLoadModules ( 'user1',-2 ); ?></td>
            </tr>
			<?php } ?>
		 	<?php if(mosCountModules( "user2")) { ?>
			<tr>
              <td><?php mosLoadModules ( 'user2',-2 ); ?></td>
            </tr>
			<?php } ?>
            <tr>
              <td class="mainbodycontainer"><?php mosMainBody(); ?></td>
            </tr>
			<?php if(mosCountModules( "bottom")) { ?>
			<tr>
              <td class="bottommodulescontainer"><?php mosLoadModules ( 'bottom',-2 ); ?></td>
            </tr>
			<?php } ?>
          </table></td>
        <td width="170" class="leftmodulescontainer">
		<?php mosLoadModules ( 'left' ); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr class="bottomcontainer">
    <td align="center" class="middlecontainer"><table width="680" border="0" cellpadding="0" cellspacing="0" class="footercontainer">
      <tr>
        <td><?php include_once('includes/footer.php'); ?></td>
      </tr>
      <tr>
        <td class="mtf">Design by <a href="http://www.mambotf.com" target="_blank">Mambo Template Factory </a></td>
      </tr>
    </table></td>
  </tr>

</table>
</body>
</html>