<?php
/* $Revision: 1.17 $ */
// Display demo user name and password within login form if $allow_demo_mode is true
include ('includes/LanguageSetup.php');
$allow_demo_mode = True;
$AllowCompanySelectionBox = false;
if ($allow_demo_mode == True AND !isset($demo_text)) {
	$demo_text = _('login as user') .': <i>' . _('admin') . '</i><BR>' ._('with password') . ': <i>' . _('admin') . '</i>';
} elseif (!isset($demo_text)) {
	$demo_text = _('Please login here');
}

?>

<HTML>
<HEAD>
    <TITLE><?php echo $_SESSION['CompanyRecord']['coyname'];?></TITLE>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo _('ISO-8859-1'); ?>" />
<!--    <link rel="stylesheet" href="css/<?php echo $theme;?>/login.css" type="text/css" />  -->
	<link rel="stylesheet" href="../vtiger_crm/themes/blue/style.css" type="text/css" />
	<style type="text/css">@import url("../vtiger_crm/themes/blue/style.css");</style>

</HEAD>

<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	
	<table width="100%" height="88%" border="0">
<tr><td align="center" valign="middle">

<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0">
<tbody><tr>

<td colspan="3">
<table cellpadding="0" width="75%" cellspacing="0" border="0" align="center"> <!-- style="border: 1px solid #5BBFFA" -->
<tr>
                 
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="loginform" method="post" id="form">
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
<td width="35%" valign ="top">
	<table width="100%" align="left" valign ="top" cellspacing="0" cellpadding="10" align="center">

        <tr>
        <td style="border-bottom: 1px dotted #000"><h4 style="margin: 0;pdiing:0;"><font face="Verdana, Arial, Helvetica, sans-serif">Mahsie Demo ERP Module Login</strong></font></h4></td></tr>
	<tr><td><strong>Administrator Account -</strong></td></tr>
	<tr><td><strong>username:</strong> admin</td></tr>
	<tr><td><strong>password:</strong> admin</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><strong>Employee Account</strong> -</td></tr>

	<tr><td><strong>username:</strong> user</td></tr>
	<tr><td><strong>password:</strong> wenerp</td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
        </table></td>
	<td bgcolor="#FFFFFF" width="1"><img src='includes/images/spacer.gif'></td>
<td width="35%" valign ="top">

			<table width="100%" align="left" valign ="top" cellspacing="0" cellpadding="10" align="center">
        <tr>
        <td style="border-bottom: 1px dotted #000"><h4 style="margin: 0;pdiing:0;"><font face="Verdana, Arial, Helvetica, sans-serif">About this module:</strong></font></h4></td></tr>
	<tr><td>This enterprise resource planning module is based on webERP 3.05.  It functions as a normal installation, but it is deeply integrated with VTiger CRM 4.24.  The programs are integrated in the following ways:<br /><br />

Accounts / Customers, branches<br /><br />
Products / Inventory<br /><br />
Pricebooks / Pricelists<br /><br />
Salespersons<br /><br />
Warehouse Locations<br /><br />
Shippers<br /><br />
Currencies<br /><br />
Taxes<br /><br />

</td></tr>


        </table>


</td>
<td bgcolor="#FFFFFF" width="1"><img src='includes/images/spacer.gif'></td>
<td width="35%" valign ="top"><table align="center" valign ="top" cellpadding="10" cellspacing="0" border="0" width="100%">
			<tr><td style="border-bottom: 1px dotted #000"><h4 style="margin: 0;pdiing:0;"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>User Log-in</strong></font></td></h4></tr>

			<input type="hidden" name="CompanyNameField" value="devel_erp">
			
	<tr>

    </td>
</td>
	<td><b>
	User Name:		</b><br>
		<input type="text" size='20' name="UserNameEntryField"  value="">

		</td>
	</tr>
	<tr>

		</td>
	<td><b>
	Password:	</b><br>
	<input type="password" size='20' name="Password" value="">
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
	<input title="Login [Alt+L]" accesskey="Login [Alt+L]" class="button" type="submit" name="SubmitUser" value=">><?php echo _('Login'); ?>" style="width:100; height:25;">
	</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </td>

	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
	</form>
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
<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Best viewed in IE 5.0+, Netscape 7.0+,Opera 7.01+ & Mozilla 1.5+ with 1024x768 resolution</font></td>
<td width="15%">&nbsp;</td></tr>
</tbody></table></td></tr></table>


	
	
    <script language="JavaScript" type="text/javascript">
    //<![CDATA[
            <!--
            document.forms[0].CompanyField.select();
            document.forms[0].CompanyField.focus();
            //-->
    //]]>
    </script>
</body>
</html>
