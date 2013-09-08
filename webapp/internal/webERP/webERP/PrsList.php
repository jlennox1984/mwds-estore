<?php

/* $Revision: 1.7 $ */

$PageSecurity = 2;
include ('includes/session.inc');
$title = _('Item Assemblies Open Inquiry');
include('includes/header.inc');


if (!isset($_GET['SupplierID']) OR !isset($_GET['SupplierName'])){
	echo '<P>';
	prnMsg( _('This page must be given the supplier code to look for shipments for'), 'error');
	include('includes/footer.inc');
	exit;
}

$SQL = "SELECT prno,
		stockno,
		prodrunqty,
		reqdate,
		supplierno,
		suppliers.suppname,
		comments
	FROM productionruns
	INNER JOIN suppliers ON suppliers.supplierid=productionruns.supplierno
	WHERE completed=0";
//	WHERE supplierno='" . $_GET['SupplierID'] . "'";
$ErrMsg = _('No Item Assemblies were returned from the database because'). ' - '. DB_error_msg($db);
$ShiptsResult = DB_query($SQL,$db, $ErrMsg);

if (DB_num_rows($ShiptsResult)==0){
       prnMsg(_('There are no open Item Assemblies'),'warn');
	include('includes/footer.inc');
       exit;
}

/*show a table of the shipments returned by the SQL */

echo '<CENTER><FONT SIZE=4 COLOR=BLUE>'. _('Open Item Assemblies'). '</FONT><BR>
	<TABLE CELLPADDING=2 COLSPAN=2>';
echo '<TR>
		<TD class="tableheader">'. _('Reference'). '</TD>
		<TD class="tableheader">'. _('Item'). '</TD>
		<TD class="tableheader">'. _('Supplier'). '</TD>
		<TD class="tableheader">'. _('Comments'). '</TD>
		<TD class="tableheader">'. _('ETA'). '</TD></TR>';

$j = 1;
$k = 0; //row colour counter

while ($myrow=DB_fetch_array($ShiptsResult)) {
       if ($k==1){
              echo '<tr bgcolor="#CCCCCC">';
              $k=0;
       } else {
              echo '<tr bgcolor="#EEEEEE">';
              $k=1;
       }

       printf('<td >%s</td>
       		<td >%s</td>
       		<td >%s</td>
       		<td>%s</td>
		<td>%s</td>
		</tr>',
		$myrow['prno'],
		$myrow['stockno'],
		$myrow['suppname'],
		$myrow['comments'],
		$myrow['prodrunqty'],
		ConvertSQLDate($myrow['reqdate']));

       $j++;
       If ($j == 12){
		$j=1;
		$TableHeader;
       }
}
//end of while loop

echo '</TABLE></CENTER>';

include('includes/footer.inc');

?>