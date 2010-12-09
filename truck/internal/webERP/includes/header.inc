<?php

/* $Revision: 1.29 $ */
	// Titles and screen header
	// Needs the file config.php loaded where the variables are defined for
	//  $rootpath
	//  $title - should be defined in the page this file is included with

	if (!headers_sent()){
		header('Content-type: text/html; charset=' . _('ISO-8859-1'));
	}
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
	
	
	echo '<HTML><HEAD><TITLE>' . $title . '</TITLE>';
	echo '<link REL="shortcut icon" HREF="'. $rootpath.'/favicon.ico">';
	echo '<link REL="icon" HREF="' . $rootpath.'/favicon.ico">';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _('ISO-8859-1') . '">';
	echo '<LINK HREF="'.$rootpath. '/css/'. $_SESSION['Theme'] .'/default.css" REL="stylesheet" TYPE="text/css">';
	/*
	echo '<script src="' . $rootpath .'/includes/num_date.js" language="JavaScript"></script>';
	*/
	
	echo '</HEAD>';

	echo '<BODY>';
		

	if ($title AND substr($title,0,4) != 'Help') {
		echo '<table height="25" width="100%" border="0" cellspacing="0" cellpadding="0">';
		echo '<TR>';
		echo '<td width="57%"class="topStrip" height="5"><img src="../vtiger_crm/themes/blue/images/blank.gif"></td>';
		echo '<td rowspan="2" class="topStrip" style="border-bottom:none" nowrap height="21" width="14" valign="bottom">';
		echo '<img src="../vtiger_crm/themes/blue/images/topcut.gif" width="14" height="16"></td>';
		echo '<td width="450" rowspan="2" class="topStrip" nowrap height="21"><table border="0" cellpadding="0" cellspacing="0"><tr><td><div align="right">';


		echo '<A class="headerlink" ACCESSKEY="1" HREF="' .  $rootpath . '/index.php?' . SID . '"><U>1</U>. ' . _('Main Menu') . '</A>&nbsp;&nbsp;</div></td><td><div align="right">';

		if (count($_SESSION['AllowedPageSecurityTokens'])>1){

			echo '<A class="headerlink" ACCESSKEY="2" HREF="' .  $rootpath . '/SelectCustomer.php?' . SID . '"><U>2</U>. ' . _('Customers') . '</A>&nbsp;&nbsp;</div></td><td><div align="right">';

			echo '<A class="headerlink" ACCESSKEY="3" HREF="' .  $rootpath . '/SelectProduct.php?' . SID . '"><U>3</U>. ' . _('Items') . '</A>&nbsp;&nbsp;</div></td><td><div align="right">';

			echo '<A class="headerlink" ACCESSKEY="4" HREF="' .  $rootpath . '/SelectSupplier.php?' . SID . '"><U>4</U>. ' . _('Suppliers') . '</A>&nbsp;&nbsp;</div></td><td><div align="right">';

			echo '<img src="css/professional/images/help.gif" align="absmiddle" border="0" hspace="4"><A class="headerlink" TARGET="_blank" ACCESSKEY="8" HREF="' .  $rootpath . '/doc/Manual/ManualContents.php?' . SID . '">. ' . _('Manual') . '</A>&nbsp;&nbsp;</div></td><td><div align="right">';

		}

		echo "<img src=\"css/professional/images/logout.gif\" align=\"absmiddle\" border=\"0\" hspace=\"4\"><A class=\"headerlink\" ACCESSKEY=\"0\" HREF=\"" . $rootpath . '/Logout.php?' . SID . "\" onclick=\"return confirm('" . _('Are you sure you wish to logout?') . "');\"> "  . _('Logout') . '</A></div></td></tr></table></td>'; 
		
		echo '</tr><tr><td height="16" style="background-color: #FFFFFF;"><div align="center"><font size="1" color="#000000"><strong>';
		echo 'Welcome <A style="font-size: 10px; font-weight: bold; color: #000000;" HREF="' .  $rootpath . '/UserSettings.php?' . SID . '">' . $_SESSION['UsersRealName'] . '</A>';
		echo '<BR>' . $title . ' ';
		echo '</TD></TR>
		<tr><td colspan="3" style="background-color: #ffffff;">&nbsp;<br /><br /></td></tr></TABLE>';

	}

?>