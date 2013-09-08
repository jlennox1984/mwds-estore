<?php

/* $Revision: 1.18 $ */

$PageSecurity = 2;
include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

if(!isset($_GET['ShiptRef']) && !isset($_POST['ShiptRef'])){
        $title = _('Select a Shipment');
        include('includes/header.inc');
        echo '<div align=center><br><br><br>';
        prnMsg( _('Select a Shipment Number to Print before calling this page') , 'error');
        echo '<BR><BR><BR><table class="table_index">
		<tr><td class="menu_group_item">
                <li><a href="'. $rootpath . '/Shipt_Select.php?'.SID .'">' . _('Outstanding Shipments') . '</a></li>
                </td></tr></table></DIV><BR><BR><BR>';
        include('includes/footer.inc');
        exit();

	echo '<CENTER><BR><BR><BR>' . _('This page must be called with a shipment number to print');
	echo '<BR><A HREF="'. $rootpath . '/index.php?' . SID . '">' . _('Back to the menu') . '</A></CENTER>';
	exit;
}

if (isset($_GET['ShiptRef'])){
	$ShiptRef = $_GET['ShiptRef'];
} elseif (isset($_POST['ShiptRef'])){
	$ShiptRef = $_POST['ShiptRef'];
}

$title = _('Print Shipment Number').' '. $ShiptRef;

$ViewingOnly = 0;
if (isset($_GET['ViewingOnly']) && $_GET['ViewingOnly']!='') {
	$ViewingOnly = $_GET['ViewingOnly'];
} elseif (isset($_POST['ViewingOnly']) && $_POST['ViewingOnly']!='') {
	$ViewingOnly = $_POST['ViewingOnly'];
}


if (isset($_POST['DoIt'])  AND ($_POST['PrintOrEmail']=='Print' || $ViewingOnly==1) ){
	$MakePDFThenDisplayIt = True;
} elseif (isset($_POST['DoIt']) AND $_POST['PrintOrEmail']=='Email' AND strlen($_POST['EmailTo'])>6){
	$MakePDFThenEmailIt = True;
}

if (isset($ShiptRef) && $ShiptRef != "" && $ShiptRef > 0){
	//Check this up front. Note that the myrow recordset is carried into the actual make pdf section
	/*retrieve the order details from the database to print */
	$ErrMsg = _('There was a problem retrieving the item assembly header details for Shipment Number'). ' ' . $ShiptRef .
			' ' . _('from the database');
	$sql = "SELECT shipments.supplierid,
       				suppliers.suppname,
				shipments.eta,
				suppliers.currcode,
				shipments.vessel,
				shipments.voyageref,
				shipments.closed,
				shipments.dateprinted,
				shipments.allowprint,
				shipments.initiator,
				shipments.comments,
				shipments.requisitionno,
				shipments.initdate,
				shipments.reqdate 
				FROM shipments INNER JOIN suppliers
					ON shipments.supplierid = suppliers.supplierid
				WHERE shipments.shiptref = " . $ShiptRef;
	$result=DB_query($sql,$db, $ErrMsg);

	if (DB_num_rows($result)==0){ /*There is ony one order header returned */

		$title = _('Print Shipment Error');
		include('includes/header.inc');
		echo '<div align=center><br><br><br>';
		prnMsg( _('Unable to Locate Shipment Number') . ' : ' . $ShiptRef . ' ', 'error');
		echo '<BR><BR><BR><table class="table_index">
			<tr><td class="menu_group_item">
	                <li><a href="'. $rootpath . '/Shipt_Select.php?'.SID .'">' . _('Shipment Inquiry') . '</a></li>
                	</td></tr></table></DIV><BR><BR><BR>';
		include('includes/footer.inc');
		exit();

	} elseif (DB_num_rows($result)==1){ /*There is ony one order header returned */

	   $POHeader = DB_fetch_array($result);
	   if ($ViewingOnly==0) {
		   if ($POHeader['allowprint']==0){
			  $title = _('Shipment Already Printed');
			  include('includes/header.inc');
			  echo '<P>';
			  prnMsg( _('Shipment number').' ' . $ShiptRef . ' '.
				_('has previously been printed') . '. ' . _('It was printed on'). ' ' .
				ConvertSQLDate($POHeader['dateprinted']) . '<BR>'.
				_('To re-print the item assembly it must be modified to allow a reprint'). '<BR>'.
				_('This check is there to ensure that duplicate item assemblies are not sent to the work centre	resulting in several production runs of the same supplies'), 'warn');
           echo '<BR><table class="table_index">
                <tr><td class="menu_group_item">
 					 <LI><A HREF="' . $rootpath . '/Ship_PDFShipment.php?' . SID . 'ShiptRef=' . $ShiptRef . '&ViewingOnly=1">'.
				_('Print This Shipment as a Copy'). '</A>
 				<LI><A HREF="' . $rootpath . '/Shipments.php?' . SID . 'ModifyOrderNumber=' . $ShiptRef . '">'.
				_('Modify the Shipment to allow a real reprint'). '</A>' .
			  	'<LI><A HREF="'. $rootpath .'/PR_SelectProductionRun.php?' . SID . '">'.
				_('Select another item assembly'). '</A>'.
			  	'<LI><A HREF="' . $rootpath . '/index.php?' . SID . '">'. _('Back to the menu').'</A>';
			  echo '</body</html>';
			  include('includes/footer.inc');
			  exit;
		   }//AllowedToPrint
	   }//not ViewingOnly
	}// 1 valid record
}//if there is a valid order number

If ($MakePDFThenDisplayIt OR $MakePDFThenEmailIt){

	$PaperSize = 'letter';

	include('includes/PDFStarter.php');

	$pdf->addinfo('Title', _('Shipment') );
	$pdf->addinfo('Subject', _('Shipment Number').' ' . $_GET['ShiptRef']);

	$line_height=16;
	   /* Then there's an order to print and its not been printed already (or its been flagged for reprinting)
	   Now ... Has it got any line items */

	   $PageNumber = 1;
	   $ErrMsg = _('There was a problem retrieving the line details for order number') . ' ' . $ShiptRef . ' ' .
			_('from the database');
	   $sql = "SELECT purchorderdetails.podetailitem,
	      				purchorders.orderno,
					purchorderdetails.itemcode,
					purchorderdetails.itemdescription,
					purchorderdetails.deliverydate,
					purchorderdetails.glcode,
					purchorderdetails.qtyinvoiced,
					purchorderdetails.unitprice,
					stockmaster.units,
					stockmaster.kgs,
					purchorderdetails.quantityord,
					purchorderdetails.quantityrecd,
					purchorderdetails.stdcostunit,
					stockmaster.materialcost+stockmaster.overheadcost as stdcost,
					purchorders.intostocklocation
				FROM purchorderdetails INNER JOIN stockmaster
					ON purchorderdetails.itemcode=stockmaster.stockid
				INNER JOIN purchorders
					ON purchorderdetails.orderno=purchorders.orderno
				WHERE purchorderdetails.shiptref=" . $ShiptRef;
	   $result=DB_query($sql,$db);

$LeftOvers = $pdf->addTextWrap($Left_Margin+1,$YPos,64,$FontSize,$POHeader['stockno'], 'left');
			$sql2 = "SELECT locationname, location from workcentres, locations where workcentres.location=locations.loccode and loccode='" . $POHeader['workcentre'] . "'";	
$LocnNameResult = DB_query($sql2,$db);
$LocnNameRow = DB_fetch_row($LocnNameResult);
$locationname = $LocnNameRow[0];
			$sql3 = "SELECT description, labourcost from stockmaster where stockid='" . $POHeader['stockno'] . "'";	
$StockNameResult = DB_query($sql3,$db);
$StockNameRow = DB_fetch_row($StockNameResult);
$stockname = $StockNameRow[0];
$labourcost = $StockNameRow[1];
$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+3+37,$YPos,60,$FontSize,$stockname, 'left');



	   if (DB_num_rows($result)>0){
	   /*Yes there are line items to start the ball rolling with a page header */

		include('includes/Ship_PDFShiptPageHeader.inc');

		$YPos-=$line_height;
		
		$sql2 = "SELECT locationname, location from workcentres, locations where workcentres.location=locations.loccode and loccode='" . $POHeader['workcentre'] . "'";	
		$DisplayDelDate = ConvertSQLDate($POHeader['processdate'],2);
			
$LocnNameResult = DB_query($sql2,$db);
$LocnNameRow = DB_fetch_row($LocnNameResult);
$locationname = $LocnNameRow[0];
		 
		 
		$OrderTotal = 0;
		

		while ($POLine=DB_fetch_array($result)){
		
			$UnitWeight = number_format($POLine['kgs'],3);
			$DisplayQtySupplied=$POLine['quantityord'];
			$Weight1 = $UnitWeight * $DisplayQtySupplied;
			$TotalWeight += $Weight1;
			$TotalWeightP = $TotalWeight*2.20462262 ;
			$TotalWeight2 = number_format($TotalWeightP,2);
			
			$TotalPieces += $DisplayQtySupplied;
			$Weight = number_format($Weight1,3);

			$sql = "SELECT supplierdescription 
				FROM purchdata 
				WHERE stockid='" . $POLine['itemcode'] . "' 
				AND supplierno ='" . $POHeader['supplierno'] . "'";
			$SuppDescRslt = DB_query($sql,$db);
	
			$ItemDescription='';

			if (DB_error_no($db)==0){
				if (DB_num_rows($SuppDescRslt)==1){
					$SuppDescRow = DB_fetch_row($SuppDescRslt);
					if (strlen($SuppDescRow[0])>2){
						$ItemDescription = $SuppDescRow[0];
					}
				}
			}
			if (strlen($ItemDescription)<2){
				$ItemDescription = $POLine['itemdescription'];
			}

			$DisplayQty = number_format($POLine['quantityord'],$POLine['decimalplaces']);
			if ($_POST['ShowAmounts']=='Yes'){
				$DisplayPrice = number_format($POLine['unitprice'],2);
			} else {
				$DisplayPrice = " ";
			}
			$DisplayDelDate = ConvertSQLDate($POLine['processdate'],2);
			if ($_POST['ShowAmounts']=='Yes'){
				$DisplayLineTotal = number_format($POLine['unitprice']*$POLine['quantityord'],2);
			} else {
				$DisplayLineTotal = " ";
			}

			$OrderTotal += ($POLine['unitprice']*$POLine['quantityord']);

			$LeftOvers = $pdf->addTextWrap($Left_Margin+280,$YPos,85,$FontSize,$DisplayQty, 'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+410,$YPos,37,$FontSize,$POLine['units'], 'left');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+3+37,$YPos,60,$FontSize,$POHeader['reqdate'], 'left');
			
		if ($_POST['ShowAmounts']=='Yes'){
			
			$LeftOvers = $pdf->addTextWrap($Left_Margin+390,$YPos,85,$FontSize,$DisplayPrice, 'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+465,$YPos,85,$FontSize,$DisplayLineTotal, 'right');
			} else {
			$DisplayLineTotal = " ";
			$DisplayPrice = " ";
			$LeftOvers = $pdf->addTextWrap($Left_Margin+390,$YPos,85,$FontSize,$DisplayPrice, 'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+465,$YPos,85,$FontSize,$DisplayLineTotal, 'right');
		}
		$LeftOvers = $pdf->addTextWrap(32,$YPos,300,$FontSize,$POLine['itemcode'], 'left');
			$LeftOvers = $pdf->addTextWrap(80,$YPos,300,$FontSize,$ItemDescription, 'left');
			if (strlen($LeftOvers)>1){
				$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64,$YPos-$line_height,300,$FontSize,$LeftOvers, 'left');
				$YPos-=$line_height;
			}

			if ($YPos-$line_height <= $Bottom_Margin){
		        /* We reached the end of the page so finsih off the page and start a newy */
				$PageNumber++;
				include ('includes/Ship_PDFShiptPageHeader.inc');
			} //end if need a new page headed up

			/*increment a line down for the next line item */
			$YPos -= $line_height;

		} //end while there are line items to print out

		if ($YPos-$line_height <= $Bottom_Margin){ // need to ensure space for totals
		        $PageNumber++;
			include ('includes/Ship_PDFShiptPageHeader.inc');
		} //end if need a new page headed up


		if ($_POST['ShowAmounts']=='Yes'){
			$DisplayOrderTotal = number_format($OrderTotal,2);
		} else {
			$DisplayOrderTotal = "----";
		}
		
$YPos-=$line_height*3;
$pdf->setFont('Helvetica', 'B', 12); 
		
		$LeftOvers = $pdf->addTextWrap($Left_Margin+5, $YPos,250,$FontSize,'Comments:  ', 'left');
$pdf->setFont('Helvetica', '', 10); 
		
		$LeftOvers = $pdf->addTextWrap($Left_Margin+65, $YPos,250,$FontSize,$POHeader['comments'], 'left');


		$pdf->setFont('Helvetica', 'B', 12); 
		$YPos = $Bottom_Margin + (4*$line_height);
		
		if ($_POST['ShowAmounts']=='Yes'){
			$pdf->addText(310,$YPos+ ($line_height*5), 12, _('Total (excl tax)'). ' ' . $POHeader['currcode'] . ': ');
			$LeftOvers = $pdf->addTextWrap(485,$YPos+ ($line_height*5)-4,95,14,'$' . $DisplayOrderTotal, 'right');
		} 
			$pdf->setFont('Helvetica', 'B', 12); 
 
		$LeftOvers = $pdf->addTextWrap($Left_Margin+5,$YPos+ ($line_height*7),170,12, _('Total Weight (KG)') . ' :   ','left');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+5,$YPos+ ($line_height*6),170,12, _('Total Weight (LBS)') . ' :   ','left');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+15,$YPos+ ($line_height*7),170,12, $TotalWeight,'right');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+15,$YPos+ ($line_height*6),170,12,$TotalWeight2,'right');
		$TotalPieces = $pdf->addTextWrap($Left_Margin+5,$YPos+ ($line_height*5),250,12, _('Piece Count (this delivery)') . ' :   ' . $TotalPieces,'left');



	} /*end if there are order details to show on the order*/
    //} /* end of check to see that there was an order selected to print */
$YPos = $Bottom_Margin +  (4*$line_height);
		$pdf->setFont('Helvetica', 'B', 12); 
    
$pdf->addText(35,$YPos+ ($line_height*4), 11, _('Authorizing Signature'). ' :');
$pdf->addText(310,$YPos+ ($line_height*4), 11, _('Received By'). ' :');
$pdf->addText(310,$YPos+ ($line_height*2)-10, 11, _('Received Date'). ' :');

$pdf->setFont('Helvetica', 'B', 8); 
$pdf->addText(35,$YPos+ $line_height-20, 8, _('Trailer #'). ' :');
$pdf->addText($Page_Width/7+23,$YPos+ $line_height-20, 8, _('Good Condition'). ' :');
$pdf->addText($Page_Width*2/7+13,$YPos+ $line_height-20, 8, _('No Evidence of'). ' :');
$pdf->addText($Page_Width*2/7+13,$YPos+ $line_height-30, 8, _('Tampering'). ' :');
$pdf->addText($Page_Width*3/7+9,$YPos+ $line_height-20, 8, _('No Debris'). ' :');
$pdf->addText($Page_Width*4/7+2,$YPos+ $line_height-20, 8, _('No Odours'). ' :');
$pdf->addText($Page_Width*5/7-3,$YPos+ $line_height-20, 8, _('No Infestation'). ' :');
$pdf->addText($Page_Width*6/7-8,$YPos+ $line_height-20, 8, _('No Water'). ' :');
$pdf->line($Left_Margin, $YPos+ ($line_height*4)+10, ($Page_Width/2), $YPos+ ($line_height*4)+10);
$pdf->line($Page_Width/2, $YPos+ ($line_height*4)+10, $Page_Width/2, $Bottom_Margin+70);
$pdf->line(($Page_Width/2), $YPos+ ($line_height*4)+10, $Page_Width-$Right_Margin, $YPos+ ($line_height*4)+10);
$pdf->line($Left_Margin, $YPos+ ($line_height-10),$Page_Width-$Right_Margin, $YPos+ ($line_height-10));		
$pdf->line($Page_Width/7+20, $YPos+ $line_height-10, $Page_Width/7+20, $Bottom_Margin);
$pdf->line($Page_Width*2/7+10, $YPos+ $line_height-10, $Page_Width*2/7+10, $Bottom_Margin);
$pdf->line($Page_Width*3/7+5, $YPos+ $line_height-10, $Page_Width*3/7+5, $Bottom_Margin);
$pdf->line($Page_Width*4/7-1, $YPos+ $line_height-10, $Page_Width*4/7-1, $Bottom_Margin);
$pdf->line($Page_Width*5/7-6, $YPos+ $line_height-10, $Page_Width*5/7-6, $Bottom_Margin);
$pdf->line($Page_Width*6/7-11, $YPos+ $line_height-10, $Page_Width*6/7-11, $Bottom_Margin);

    //failed var to allow us to print if the email fails.
    $failed = false;
    if ($MakePDFThenDisplayIt){

    	$buf = $pdf->output();
    	$len = strlen($buf);
    	header('Content-type: application/pdf');
    	header('Content-Length: ' . $len);
    	header('Content-Disposition: inline; filename=ItemAssembly.pdf');
    	header('Expires: 0');
    	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    	header('Pragma: public');

    	$pdf->stream();

    } else { /* must be MakingPDF to email it */

    	$pdfcode = $pdf->output();
	$fp = fopen( $_SESSION['reports_dir'] . '/ItemAssembly.pdf','wb');
	fwrite ($fp, $pdfcode);
	fclose ($fp);

	include('includes/htmlMimeMail.php');

	$mail = new htmlMimeMail();
	$attachment = $mail->getFile($_SESSION['reports_dir'] . '/ItemAssembly.pdf');
	$mail->setText( _('Please find herewith our item assembly number').' ' . $ShiptRef);
	$mail->setSubject( _('Shipment Number').' ' . $ShiptRef);
	$mail->addAttachment($attachment, 'ItemAssembly.pdf', 'application/pdf');
	$mail->setFrom($_SESSION['CompanyRecord']['coyname'] . "<" . $_SESSION['CompanyRecord']['email'] .">");
	$result = $mail->send(array($_POST['EmailTo']));
	if ($result==1){
		$failed = false;
		echo '<P>';
		prnMsg( _('Item assembly'). ' ' . $ShiptRef.' ' . _('has been emailed to') .' ' . $_POST['EmailTo'] . ' ' . _('as directed'), 'success');
	} else {
		$failed = true;
		echo '<P>';
		prnMsg( _('Emailing Item assembly'). ' ' . $ShiptRef.' ' . _('to') .' ' . $_POST['EmailTo'] . ' ' . _('failed'), 'error');
	}

    }

    if ($ViewingOnly==0 && !$failed) {
	
	/*$sql = "UPDATE salesorders SET printedpackingslip=1, datepackingslipprinted='" . Date('Y-m-d') . "' WHERE salesorders.orderno=" .$_GET['TransNo'];
	$result = DB_query($sql,$db); */

	
	$sql = "UPDATE shipments 
			SET allowprint=0, 
				dateprinted='" . Date('Y-m-d') . "' 
			WHERE shipments.shiptref=" .$ShiptRef;
	$result = DB_query($sql,$db);
    }

} /* There was enough info to either print or email the item assembly */
 else { /*the user has just gone into the page need to ask the question whether to print the order or email it to the supplier */

	include ('includes/header.inc');
	echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD=POST>';

	if ($ViewingOnly==1){
		echo '<INPUT TYPE=HIDDEN NAME="ViewingOnly" VALUE=1>';
	}
	echo '<BR><BR>';
	echo '<INPUT TYPE=HIDDEN NAME="ShiptRef" VALUE="'. $ShiptRef. '">';
	echo '<DIV ALIGN=CENTER><TABLE><TR><TD>'. _('Print or Email the Order'). '</TD><TD>
		<SELECT NAME="PrintOrEmail">';

	if (!isset($_POST['PrintOrEmail'])){
		$_POST['PrintOrEmail'] = 'Print';
	}

	if ($_POST['PrintOrEmail']=='Print'){
		echo '<OPTION SELECTED VALUE="Print">'. _('Print');
		echo '<OPTION VALUE="Email">' . _('Email');
	} else {
		echo '<OPTION VALUE="Print">'. _('Print');
		echo '<OPTION SELECTED VALUE="Email">'. _('Email');
	}
	echo '</SELECT></TD></TR>';

	echo '<TR><TD>'. _('Show Amounts on the Shipment'). '</TD><TD>
		<SELECT NAME="ShowAmounts">';
		
	if (!isset($_POST['ShowAmounts'])){
		$_POST['ShowAmounts'] = 'Yes';
	}

	if ($_POST['ShowAmounts']=='Yes'){
		echo '<OPTION SELECTED VALUE="Yes">'. _('Yes');
		echo '<OPTION VALUE="No">' . _('No');
	} else {
		echo '<OPTION VALUE="Yes">'. _('Yes');
		echo '<OPTION SELECTED VALUE="No">'. _('No');
	}
	
	echo '</SELECT></TD></TR>';
	if ($_POST['PrintOrEmail']=='Email'){
		$ErrMsg = _('There was a problem retrieving the contact details for the supplier');
		$SQL = "SELECT suppliercontacts.contact,
				suppliercontacts.email
			FROM suppliercontacts INNER JOIN productionruns
			ON suppliercontacts.supplierid=productionruns.supplierno
			WHERE productionruns.prno=$ShiptRef";
		$ContactsResult=DB_query($SQL,$db, $ErrMsg);

		if (DB_num_rows($ContactsResult)>0){
			echo '<TR><TD>'. _('Email to') .':</TD><TD><SELECT NAME="EmailTo">';
			while ($ContactDetails = DB_fetch_array($ContactsResult)){
				if (strlen($ContactDetails['email'])>2 AND strpos($ContactDetails['email'],'@')>0){
					if ($_POST['EmailTo']==$ContactDetails['email']){
						echo '<OPTION SELECTED VALUE="' . $ContactDetails['email'] . '">' . $ContactDetails['Contact'] . ' - ' . $ContactDetails['email'];
					} else {
						echo '<OPTION VALUE="' . $ContactDetails['email'] . '">' . $ContactDetails['contact'] . ' - ' . $ContactDetails['email'];
					}
				}
			}
			echo '</SELECT></TD></TR></TABLE>';
		} else {
			echo '</TABLE><BR>';
			prnMsg ( _('There are no contacts defined for the supplier of this item assembly') . '. ' .
				_('You must first set up supplier contacts before emailing a shipment'), 'error');
			echo '<BR>';
		}
	} else {
		echo '</TABLE>';
	}
	echo '<BR><INPUT TYPE=SUBMIT NAME="DoIt" VALUE="' . _('OK') . '">';
	echo '</DIV></FORM>';
	include('includes/footer.inc');
}
?>