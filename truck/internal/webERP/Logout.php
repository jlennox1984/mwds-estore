<?php
/* $Revision: 1.14 $ */
$PageSecurity =1;

include('includes/session.inc');

?>
<html>
<head>
    <title><?php echo $_SESSION['CompanyRecord']['coyname'];?> - <?php echo _('Log Off'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo _('ISO-8859-1'); ?>" />
    <link rel="stylesheet" href="css/<?php echo $theme;?>/login.css" type="text/css" />
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 
 
	<table width="100%" height="88%" border="0">
<tr><td align="center" valign="middle">

<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0">
<tbody><tr>

<td colspan="3">
<table cellpadding="0" width="75%" cellspacing="0" border="0" align="center"> <!-- style="border: 1px solid #5BBFFA" -->
<tr>
                 
<td bgcolor="#C9EBFF" align="left" width="11" height="15"><img src='includes/images/login_left.gif'> </td>
<td bgcolor="#C9EBFF"> </td>
<td bgcolor="#C9EBFF" align="right"><img src='includes/images/login_right.gif'> </td></tr>
<tr>
<td bgcolor="#C9EBFF"> </td>

<td valign="top" bgcolor="#C9EBFF">
<!--
<img src='include/images/vtiger-crm.gif'>-->
</td>
<td bgcolor="#C9EBFF"> </td>

</tr>
<tr>
<td bgcolor="#C9EBFF"> </td>
<td bgcolor="#C9EBFF">

<table width="100%" align="left" border="0" cellspacing="4" cellpadding="0" align="center">
<tr>
<td valign ="top"><table align="center" valign ="top" cellpadding="10" cellspacing="0" border="0" width="100%">
			<tr><td style="border-bottom: 1px dotted #000; text-align: center;"><h4 style="margin: 0; padding:0;"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>User Logout</strong></font></td></h4></tr>

			
	<tr>

    </td>
</td>
	<td style="text-align: center;"><b>
	<?php echo _('Thank you for using Mahsie ERP'); ?><br /><br />
				<?php echo $_SESSION['CompanyRecord']['coyname'];?>
											<br />
											<a href=" <?php echo $rootpath;?>/index.php"><b><?php echo _('Click here to Login Again'); ?></b></a>

		</td>
	</tr>
	<tr>

		</td>
	<td>
	</td>
	</tr>
	<tr>
		</td>

	<td>

	</td>
	</tr>
	<tr>
	<td>

	</td>
	</tr>
	<tr>
	<td align="right"><b>
	
	</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>

	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
	</td>
</table></td>
<td bgcolor="#C9EBFF"> </td>
</tr>
<tr>

<td align="left" valign="bottom" width="11" height="15"><img src='includes/images/login_botleft.gif'></td>
<td bgcolor="#C9EBFF"> </td>
<td bgcolor="#C9EBFF" align="right" valign="bottom"><img src='includes/images/login_botright.gif'></td>
</tr>

</table>
</tr>
<tr><td width="15%">&nbsp;</td>
<td align="center"></td>
<td width="15%">&nbsp;</td></tr>
</tbody></table></td></tr></table>




















</body>
</html>

<?php
	// Cleanup
	session_start();
	session_unset();
	session_destroy();
?>
</body>
</html>


