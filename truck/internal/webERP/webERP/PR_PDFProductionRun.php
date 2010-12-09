<?php

/* $Revision: 1.18 $ */

$PageSecurity = 2;
include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

if(!isset($_GET['PRNo']) && !isset($_POST['PRNo'])){
        $title = _('Select a Item Assembly');
        include('includes/header.inc');
        echo '<div align=center><br><br><br>';
        prnMsg( _('Select an Item Assembly Number to Print before calling this page') , 'error');
        echo '<BR><BR><BR><table class="table_index">
		<tr><td class="menu_group_item">
                <li><a href="'. $rootpath . '/PR_SelectProductionRun.php?'.SID .'">' . _('Outstanding Item Assemblies') . '</a></li>
                <li><a href="'. $rootpath . '/PR_SelectProductionRun.php?'. SID .'">' . _('Item Assembly Inquiry') . '</a></li>
                </td></tr></table></DIV><BR><BR><BR>';
        include('includes/footer.inc');
        exit();

	echo '<CENTER><BR><BR><BR>' . _('This page must be called with an item assembly number to print');
	echo '<BR><A HREF="'. $rootpath . '/index.php?' . SID . '">' . _('Back to the menu') . '</A></CENTER>';
	exit;
}

if (isset($_GET['PRNo'])){
	$PRNo = $_GET['PRNo'];
} elseif (isset($_POST['PRNo'])){
	$PRNo = $_POST['PRNo'];
}

$title = _('Print Item Assembly Number').' '. $PRNo;

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

if (isset($PRNo) && $PRNo != "" && $PRNo > 0){
	//Check this up front. Note that the myrow recordset is carried into the actual make pdf section
	/*retrieve the order details from the database to print */
	$ErrMsg = _('There was a problem retrieving the item assembly header details for Item Assembly Number'). ' ' . $PRNo .
			' ' . _('from the database');
	$sql = "SELECT
			productionruns.comments,
			productionruns.initdate,
			productionruns.reqdate,
			productionruns.dateprinted,
			productionruns.workcentre,
			productionruns.workadd1,
			productionruns.workadd2,
			productionruns.workadd3,
			productionruns.workadd4,
			productionruns.workadd5,
			productionruns.workadd6,
			productionruns.contact,
			productionruns.allowprint,
			productionruns.stockno,
			productionruns.prodrunqty,
			productionruns.mancosts,
			productionruns.requisitionno,
			productionruns.initiator
		FROM productionruns 
		WHERE productionruns.prno = " . $PRNo;
	$result=DB_query($sql,$db, $ErrMsg);

	if (DB_num_rows($result)==0){ /*There is ony one order header returned */

		$title = _('Print Item Assembly Error');
		include('includes/header.inc');
		echo '<div align=center><br><br><br>';
		prnMsg( _('Unable to Locate Item Assembly Number') . ' : ' . $PRNo . ' ', 'error');
		echo '<BR><BR><BR><table class="table_index">
			<tr><td class="menu_group_item">
	                <li><a href="'. $rootpath . '/PR_SelectProductionRun.php?'.SID .'">' . _('Outstanding Item Assemblies') . '</a></li>
        	        <li><a href="'. $rootpath . '/PR_SelectProductionRun.php?'. SID .'">' . _('Item Assembly Inquiry') . '</a></li>
                	</td></tr></table></DIV><BR><BR><BR>';
		include('includes/footer.inc');
		exit();

	} elseif (DB_num_rows($result)==1){ /*There is ony one order header returned */

	   $POHeader = DB_fetch_array($result);
	   if ($ViewingOnly==0) {
		   if ($POHeader['allowprint']==0){
			  $title = _('Item Assembly Already Printed');
			  include('includes/header.inc');
			  echo '<P>';
			  prnMsg( _('Item assembly number').' ' . $PRNo . ' '.
				_('has previously been printed') . '. ' . _('It was printed on'). ' ' .
				ConvertSQLDate($POHeader['dateprinted']) . '<BR>'.
				_('To re-print the item assembly it must be modified to allow a reprint'). '<BR>'.
				_('This check is there to ensure that duplicate item assemblies are not sent to the work centre	resulting in several production runs of the same supplies'), 'warn');
           echo '<BR><table class="table_index">
                <tr><td class="menu_group_item">
 					 <LI><A HREF="' . $rootpath . '/PR_PDFProductionRun.php?' . SID . 'PRNo=' . $PRNo . '&ViewingOnly=1">'.
				_('Print This Item Assembly as a Copy'). '</A>
 				<LI><A HREF="' . $rootpath . '/PR_Header.php?' . SID . 'ModifyOrderNumber=' . $PRNo . '">'.
				_('Modify the item assembly to allow a real reprint'). '</A>' .
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

	$pdf->addinfo('Title', _('Item Assembly') );
	$pdf->addinfo('Subject', _('Item Assembly Number').' ' . $_GET['PRNo']);

	$line_height=16;
	   /* Then there's an order to print and its not been printed already (or its been flagged for reprinting)
	   Now ... Has it got any line items */

	   $PageNumber = 1;
	   $ErrMsg = _('There was a problem retrieving the line details for order number') . ' ' . $PRNo . ' ' .
			_('from the database');
	   $sql = "SELECT itemcode,
	   			processdate,
				itemdescription,
				actcostunit,
				units,
				quantityord,
				decimalplaces
			FROM productionrundetails LEFT JOIN stockmaster
				ON productionrundetails.itemcode=stockmaster.stockid
			WHERE prno =" . $PRNo;
	   $result=DB_query($sql,$db);
$FontSize=10;
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

		include('includes/PR_PDFPRPageHeader.inc');

		$YPos-=$line_height;
		
		$sql2 = "SELECT locationname, location from workcentres, locations where workcentres.location=locations.loccode and loccode='" . $POHeader['workcentre'] . "'";	
		$DisplayDelDate = ConvertSQLDate($POHeader['processdate'],2);
			
$LocnNameResult = DB_query($sql2,$db);
$LocnNameRow = DB_fetch_row($LocnNameResult);
$locationname = $LocnNameRow[0];
		 
		 
		$OrderTotal = 0;

		while ($POLine=DB_fetch_array($result)){

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
				$DisplayPrice = "----";
			}
			$DisplayDelDate = ConvertSQLDate($POLine['processdate'],2);
			if ($_POST['ShowAmounts']=='Yes'){
				$DisplayLineTotal = number_format($POLine['unitprice']*$POLine['quantityord'],2);
			} else {
				$DisplayLineTotal = "----";
			}

			$OrderTotal += ($POLine['unitprice']*$POLine['quantityord']);

			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300,$YPos,85,$FontSize,$DisplayQty, 'right');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+3,$YPos,37,$FontSize,$POLine['units'], 'left');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+3+37,$YPos,60,$FontSize,$POHeader['reqdate'], 'left');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+40+60,$YPos,85,$FontSize,$DisplayPrice, 'right');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64+300+85+40+60+85,$YPos,85,$FontSize,$DisplayLineTotal, 'right');
			//$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64,$YPos,300,$FontSize,$POHeader['itemcode'], 'left');
			if (strlen($LeftOvers)>1){
				$LeftOvers = $pdf->addTextWrap($Left_Margin+1+64,$YPos-$line_height,300,$FontSize,$LeftOvers, 'left');
				$YPos-=$line_height;
			}

			if ($YPos-$line_height <= $Bottom_Margin){
		        /* We reached the end of the page so finsih off the page and start a newy */
				$PageNumber++;
				include ('includes/PR_PDFPRPageHeader.inc');
			} //end if need a new page headed up

			/*increment a line down for the next line item */
			$YPos -= $line_height;

		} //end while there are line items to print out

		if ($YPos-$line_height <= $Bottom_Margin){ // need to ensure space for totals
		        $PageNumber++;
			include ('includes/PR_PDFPRPageHeader.inc');
		} //end if need a new page headed up


		if ($_POST['ShowAmounts']=='Yes'){
			$DisplayOrderTotal = number_format($OrderTotal,2);
		} else {
			$DisplayOrderTotal = "----";
		}
		
		$pdf->setFont('Helvetica', 'B', 12); 
		$YPos = $Bottom_Margin + (4*$line_height);
		$pdf->addText(310,$YPos+ ($line_height*5), 12, _('Total (excl tax)'). ' ' . $POHeader['currcode'] . ': ');
		$LeftOvers = $pdf->addTextWrap(485,$YPos+ ($line_height*5)-4,95,14,'$' . $total, 'right');

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
	$mail->setText( _('Please find herewith our item assembly number').' ' . $PRNo);
	$mail->setSubject( _('Item Assembly Number').' ' . $PRNo);
	$mail->addAttachment($attachment, 'ItemAssembly.pdf', 'application/pdf');
	$mail->setFrom($_SESSION['CompanyRecord']['coyname'] . "<" . $_SESSION['CompanyRecord']['email'] .">");
	$result = $mail->send(array($_POST['EmailTo']));
	if ($result==1){
		$failed = false;
		echo '<P>';
		prnMsg( _('Item assembly'). ' ' . $PRNo.' ' . _('has been emailed to') .' ' . $_POST['EmailTo'] . ' ' . _('as directed'), 'success');
	} else {
		$failed = true;
		echo '<P>';
		prnMsg( _('Emailing Item assembly'). ' ' . $PRNo.' ' . _('to') .' ' . $_POST['EmailTo'] . ' ' . _('failed'), 'error');
	}

    }

    if ($ViewingOnly==0 && !$failed) {
	$sql = "UPDATE productionruns 
			SET allowprint=0, 
				dateprinted='" . Date('Y-m-d') . "' 
			WHERE productionruns.prno=" .$PRNo;
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
	echo '<INPUT TYPE=HIDDEN NAME="PRNo" VALUE="'. $PRNo. '">';
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

	echo '<TR><TD>'. _('Show Amounts on the Item Assembly'). '</TD><TD>
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
			WHERE productionruns.prno=$PRNo";
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
				_('You must first set up supplier contacts before emailing an item assembly'), 'error');
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