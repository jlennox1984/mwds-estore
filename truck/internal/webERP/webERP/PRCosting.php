<?php

/* $Revision: 1.10 $ */

$PageSecurity = 11;

include('includes/session.inc');
$title = _('Production Runs Weighted Costing');
/* Session started in header.inc for password checking and authorisation level check */
include('includes/header.inc');
include('includes/SQL_CommonFunctions.inc');

if ($_GET['NewProductionRunCosting']=='Yes'){
	unset($_SESSION['ProductionRunCosting']->LineItems);
	unset($_SESSION['ProductionRunCosting']);
}

if (!isset($_GET['SelectedProductionRunCosting'])){

	echo '<BR>';
	prnMsg( _('This page is expected to be called with the production run number to show the costing for'), 'error');
	include ("includes/footer.inc");
	exit;
}

$ShipmentHeaderSQL = "SELECT productionruncosting.supplierid,
				workcentres.description,
				productionruncosting.eta,
				productionruncosting.other,
				productionruncosting.otherref,
				productionruncosting.closed
			FROM productionruncosting INNER JOIN workcentres
				ON productionruncosting.supplierid = workcentres.code
			WHERE productionruncosting.prref = " . $_GET['SelectedProductionRunCosting'];

$ErrMsg = _('Production Run').' '. $_GET['SelectedProductionRunCosting'] . ' ' . _('cannot be retrieved because a database error occurred');
$GetShiptHdrResult = DB_query($ShipmentHeaderSQL,$db, $ErrMsg);
if (DB_num_rows($GetShiptHdrResult)==0) {
	echo '<BR>';
	prnMsg( _('Production Run') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('could not be located in the database') , 'error');
	include ("includes/footer.inc");
	exit;
}

$HeaderData = DB_fetch_array($GetShiptHdrResult);
echo '<BR>';
echo '<CENTER><TABLE>
	<TR>
		<TD><B>'. _('Production Run') .': </TD>
		<TD><B>' . $_GET['SelectedProductionRunCosting'] . '</B></TD>
		<TD><B>'. _('From').' ' . $HeaderData['suppname'] . '</B></TD>
	</TR>';

echo '<TR><TD>' . _('Note'). ': </TD>
	<TD>' . $HeaderData['other'] . '</TD>
	<TD>'. _('Other Ref'). ': </TD>
	<TD>' . $HeaderData['otherref'] . '</TD></TR>';

echo '<TR><TD>' . _('Expected Completion Date (ETA)') . ': </TD>
	<TD>' . ConvertSQLDate($HeaderData['eta']) . '</TD></TR>';

echo '</TABLE>';

/*Get the total non-stock item production run charges */

$sql = "SELECT SUM(value) FROM productionruncostingcharges WHERE transtype<>40 AND prno=0 AND prref =" . $_GET['SelectedProductionRunCosting'];

$ErrMsg = _('Production Run ') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('general costs cannot be retrieved from the database');
$GetShiptCostsResult = DB_query($sql,$db, $ErrMsg);
if (DB_num_rows($GetShiptCostsResult)==0) {
	echo '<BR>';
	prnMsg ( _('No General Cost Records exist for Production Run ') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('in the database'), 'error');
	include ('includes/footer.inc');
	exit;
}

$myrow = DB_fetch_row($GetShiptCostsResult);

$TotalCostsToApportion = $myrow[0];

/*Get the total quantities */

$sql = "SELECT SUM( productionruns.prodrunqtyrecd ) AS totalqty FROM productionruns LEFT JOIN productionruncostingcharges ON productionruns.stockno = productionruncostingcharges.stockid AND productionruns.prref = productionruncostingcharges.prref WHERE productionruns.prref =" . $_GET['SelectedProductionRunCosting'];

$ErrMsg = _('Production Run ') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('total quantities cannot be retrieved from the database');
$GetShiptQtyResult = DB_query($sql,$db, $ErrMsg);
if (DB_num_rows($GetShiptQtyResult)==0) {
	echo '<BR>';
	prnMsg ( _('No Invoiced Quantities exist for Production Run ') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('in the database'), 'error');
	include ('includes/footer.inc');
	exit;
}

$myrow = DB_fetch_row($GetShiptQtyResult);

$TotalQty = $myrow[0];

/*Now Get the total of stock items invoiced against the production run */

$sql = "SELECT SUM(value) FROM productionruncostingcharges WHERE ((stockid<>'' AND transtype=40) OR (prno<>0)) AND prref =" . $_GET['SelectedProductionRunCosting'];

$ErrMsg = _('Production Run ') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('Item costs cannot be retrieved from the database');
$GetShiptCostsResult = DB_query($sql,$db);
if (DB_error_no($db) !=0 OR DB_num_rows($GetShiptCostsResult)==0) {
	echo '<BR>';
	prnMsg ( _('No Item Cost Records exist for Production Run') . ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('in the database'), 'error');
	include ('includes/footer.inc');
	exit;
}

$myrow = DB_fetch_row($GetShiptCostsResult);

$TotalInvoiceValueOfShipment = $myrow[0];

/*Now get the lines on the production run */

	$LineItemsSQL = "SELECT productionruns.prno,
				productionruns.stockno,
				stockmaster.description,
				productionruns.prodrunqty,
				productionruns.prodrunqtyrecd,
				productionruns.bomunitcost,
				stockmaster.materialcost AS stdcost,
				SUM(productionruncostingcharges.value) AS invoicedcharges
				FROM productionruns LEFT JOIN productionruncostingcharges
					ON ((productionruns.stockno = productionruncostingcharges.stockid)
						OR (productionruns.prno = productionruncostingcharges.prno))
					AND productionruns.prref=productionruncostingcharges.prref
					INNER JOIN stockmaster ON productionruns.stockno = stockmaster.stockid
			WHERE productionruns.prref=" . $_GET['SelectedProductionRunCosting'] . "
			GROUP BY productionruns.prno,
				productionruns.stockno,
				stockmaster.description,
				productionruns.prodrunqtyrecd,
				productionruns.prodrunqtyrecd,
				productionruns.bomunitcost";

$ErrMsg = _('The lines on the Production Run could not be retrieved from the database');
$LineItemsResult = db_query($LineItemsSQL,$db, $ErrMsg);
	




/*echo '<p>TTTTT';
		echo $SpecSQL;
echo 'SSSSS';
		echo $costspec;
		echo '</p>';*/
		echo '<TABLE CELLPADDING=2 COLSPAN=7 BORDER=0>';

if (db_num_rows($LineItemsResult) > 0) {

	if (isset($_POST['Close'])){
		while ($myrow=DB_fetch_array($LineItemsResult)){
                      
                }
                DB_data_seek($LineItemsResult,0);
 	}
 	


        if (isset($_POST['Close'])){
        /*Set up a transaction to buffer all updates or none */
		$result = DB_query('BEGIN',$db);
		$PeriodNo = GetPeriod(Date('d/m/Y'), $db);
        }
		//echo '<p>TTTTT';
		//echo LineItemsSQL;
		//echo '</p>';
        echo '<TABLE CELLPADDING=2 COLSPAN=7 BORDER=0>';

	$TableHeader = '<TR><TD class="tableheader">' . _('Order') . '</TD>
				<TD class="tableheader">'. _('Item'). '</TD>
				<TD class="tableheader">'. _('Quantity'). '<BR>'. _('Ordered'). '</TD>
				<TD class="tableheader">'. _('Quantity'). '<BR>'. _('Produced'). '</TD>
				<TD class="tableheader">CDN<BR>'. _('BOM Unit Cost'). '</TD>
				<TD class="tableheader">'. _('Projected Cost'). '</TD>
				<TD class="tableheader">'. _('Local Cost'). '</TD>
				<TD class="tableheader">'. _('Prod. Run'). '<BR>'. _('Charges'). '</TD>
				<TD class="tableheader">'. _('Prod. Run'). '<BR>'. _('Unit Cost'). '</TD>
				<TD class="tableheader">'. _('Existing'). '<BR>'. _('Std Cost'). '</TD>
				<TD class="tableheader">'. _('Variance'). '</TD>
				<TD class="tableheader">'. _('Variance'). ' %</TD>
				<TD class="tableheader">'. _('New'). '<BR>'. _('Weighted Cost'). '</TD>
				</TR>';
	echo  $TableHeader;

	/*show the line items on the production run with the value invoiced and shipt cost */

	$k=0; //row colour counter
	$RowCounter =0;

	while ($myrow=DB_fetch_array($LineItemsResult)) {
	
	
/*
$myrowspec=DB_fetch_array($LineItemsResult);
*/

$SpecSQL = "SELECT SUM(productionrundetails.actcostunit) as costspec
			FROM productionrundetails WHERE productionrundetails.prno = " . $myrow['prno'] . "
			GROUP BY productionrundetails.prno";

$ErrMsg = _('The lines on the Production Run could not be retrieved from the database');
$SpecResult = db_query($SpecSQL,$db, $ErrMsg);
$myrowspec1=DB_fetch_array($SpecResult);
$costspec1 = $myrowspec1['costspec'];
$stk = $myrow['stockno'];

$stksql = "SELECT bom.parent,
			bom.component,
			stockmaster.description,
			stockmaster.decimalplaces,
			stockmaster.materialcost+stockmaster.overheadcost as standardcost,
			bom.quantity,
			bom.quantity * (stockmaster.materialcost+ stockmaster.overheadcost) AS componentcost
		FROM bom INNER JOIN stockmaster ON bom.component = stockmaster.stockid
		WHERE bom.parent = '" . $stk . "'
		AND bom.effectiveafter < Now()
		AND bom.effectiveto > Now()";

	$ErrMsg = _('The bill of material could not be retrieved because');
	$stkResult = DB_query ($stksql,$db,$ErrMsg);
	$stkCost = 0;

		while ($stkrow=DB_fetch_array($stkResult)) {
            $stkCost += $stkrow['componentcost'];
			}//end of page full new headings if}//end of while
		




		if ($RowCounter==15){
			echo $TableHeader;
			$RowCounter =0;
		}
		$RowCounter++;
		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}


$sql5b ='SELECT SUM( stockmaster.materialcost + stockmaster.overheadcost ) AS stdcost
FROM stockmaster WHERE stockid = "' . $myrow['stockno'] . '"';
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity on hand could not be retrieved from the database');
				$DbgMsg = _('The following SQL to retrieve the total stock quantity was used');
				$Result5b = DB_query($sql5b, $db, $ErrMsg, $DbgMsg);
				$QtyRow5b = DB_fetch_row($Result5b);
				$StdCost5b = $QtyRow5b[0];




		if ($TotalInvoiceValueOfShipment>0){
	//		$PortionOfCharges = $TotalCostsToApportion *($myrow['invoicedcharges']/$TotalInvoiceValueOfShipment);
			$PortionOfCharges = $TotalCostsToApportion *($myrow['prodrunqtyrecd']/$TotalQty);
		} else {
			$PortionOfCharges = 0;
		}

		if ($myrow['prodrunqtyrecd']>0){
	//	prnMsg(_('step 0a ') . $ItemShipmentCost,'info');

			$ItemShipmentCost = ($myrow['invoicedcharges']+$PortionOfCharges)/$myrow['prodrunqtyrecd'];
			// prnMsg(_('step 0b ') . $ItemShipmentCost,'info');

		} else {
			$ItemShipmentCost =0;
			// prnMsg(_('step 0c ') . $ItemShipmentCost,'info');

		}

		if ($ItemShipmentCost !=0){
			$Variance = $StdCost5b - $ItemShipmentCost;
		} else {
			$Variance =0;
		}

		if ($myrow['stdcost']>0 ){
			$VariancePercentage = number_format(($Variance*100)/$StdCost5b);
		} else {
			$VariancePercentage =0;
		}


		if ( isset($_POST['Close']) AND $Variance !=0){
		
		$you = $_SESSION['CompanyRecord']['gllink_stock'];
	//	prnMsg(_('GLINK  ') . $you,'info');


                        if ($_SESSION['CompanyRecord']['gllink_stock']==1){
                              $StockGLCodes = GetStockGLCode($myrow['stockno'],$db);
                        }

                        /*GL journals depend on the costing method used currently:
                             Standard cost - the price variance between the exisitng system cost and the production run cost is taken as a variance
                             to the price varaince account
                             Weighted Average Cost - the price variance is taken to the stock account and the cost updated to ensure the GL
                             stock account ties up to the stock valuation
                        */

                     /* Do the WAvg journal and cost update */
                               	/*
                                First off figure out the new weighted average cost Need the following data:

                                How many in stock now
				The quantity being costed here - $myrow['prodrunqtyrecd']
				The cost of these items - $ItemShipmentCost
				*/

				$sql ='SELECT SUM(quantity) FROM locstock WHERE stockid="' . $myrow['stockno'] . '"';
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity on hand could not be retrieved from the database');
				$DbgMsg = _('The following SQL to retrieve the total stock quantity was used');
				$Result = DB_query($sql, $db, $ErrMsg, $DbgMsg);
				$QtyRow = DB_fetch_row($Result);
				$TotalQuantityOnHand = $QtyRow[0];


				/*The cost adjustment is the price variance / the total quantity in stock
				But that's only provided that the total quantity in stock is > the quantity charged on this invoice
                                */

                                $WriteOffToVariances =0;

                                if ($myrow['prodrunqtyrecd'] > $TotalQuantityOnHand){

                                             /*So we need to write off some of the variance to variances and
                                             only the balance of the quantity in stock to go to stock value */

					     $WriteOffToVariances =  ($myrow['prodrunqtyrecd'] - $TotalQuantityOnHand)
                                                                                       * ($ItemShipmentCost - $myrow['bomunitcost']);
                                 }


                               if ($_SESSION['CompanyRecord']['gllink_stock']==1){

				   /* If the quantity on hand is less the amount charged on this invoice then some must have been sold
                                       and the price variance on these must be written off to price variances*/
//	prnMsg(_('step one  ') . $you,'info');


                                       if ($myrow['prodrunqtyrecd'] > $TotalQuantityOnHand){
// prnMsg(_('step one  A') . $you,'info');

                                            $sql = "INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
              					VALUES (31,
	           					" . $_GET['SelectedProductionRunCosting'] . ",
		        				'" . Date('Y-m-d') . "',
			        			" . $PeriodNo . ",
				         		" . $StockGLCodes['purchpricevaract'] . ",
					         	'" . $myrow['stockno'] . ' ' . _('production run cost') . ' ' .  number_format($ItemShipmentCost,2) . _('production run quantity > stock held - variance write off') . "',
                                                         " . $WriteOffToVariances . ")";

                                            $ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL entry for the production run variance posting for'). ' ' . $myrow['stockno'] . ' '. _('could not be inserted into the database because');
											// prnMsg(_('step 1 ') . $sql,'info');

	       		                    $result = DB_query($sql,$db, $ErrMsg,'',TRUE);

	                                }
        				/*Now post any remaining price variance to stock rather than price variances */
                                        $sql = "INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
              					VALUES (31,
	           					" . $_GET['SelectedProductionRunCosting'] . ",
		        		    		'" . Date('Y-m-d') . "',
			        			" . $PeriodNo . ",
				         		" . $StockGLCodes['stockact'] . ",
					         	'" . $myrow['stockno'] . ' ' . _('production run avg cost adjt') . "',
                                                         " . ($myrow['prodrunqtyrecd'] *($ItemShipmentCost - $myrow['bomunitcost'])
                                                                                    - $WriteOffToVariances) . ")";

                                        $ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL entry for the production run average cost adjustment for'). ' ' . $myrow['stockno'] . ' '. _('could not be inserted into the database because');
										// prnMsg(_('step 2 ') . $sql,'info');

       		                        $result = DB_query($sql,$db, $ErrMsg,'',TRUE);

                                } /* end of average cost GL stuff */


				/*Now to update the stock cost with the new weighted average */

				/*Need to consider what to do if the cost has been changed manually between receiving
                                the stock and entering the invoice - this code assumes there has been no cost updates
                                made manually and all the price variance is posted to stock.

				A nicety or important?? */
// prnMsg(_('step two') . $you,'info');

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The cost could not be updated because');
				$DbgMsg = _('The following SQL to update the cost was used');




				$CostIncrement = ($myrow['prodrunqtyrecd'] *($ItemShipmentCost - $myrow['stdcost']) - $WriteOffToVariances) / $TotalQuantityOnHand;
	 								
									// prnMsg(_('Cost Increment  ') . $CostIncrement . ' - ' .  $myrow['prodrunqtyrecd'] . ' -- ' . $ItemShipmentCost . ' --- ' . $myrow['stdcost'] . ' --- ' . $WriteOffToVariances . ' --- ' . $TotalQuantityOnHand,'info');

                              	$sql = 'UPDATE stockmaster SET lastcost=materialcost+overheadcost,
                                                                   materialcost=materialcost+' . $CostIncrement . ' WHERE stockid="' . $myrow['stockno'] . '"';
																   // prnMsg(_('step 6 ') . $sql,'info');

				$Result = DB_query($sql, $db, $ErrMsg, $DbgMsg,'',TRUE);
					
/*					$sql = 'UPDATE stockmaster SET lastcost=materialcost+overheadcost,
								materialcost=' . $ItemShipmentCost . ' WHERE stockid="' . $myrow['stockno'] . '"';
					$Result = DB_query($sql, $db, $ErrMsg, $DbgMsg,'',TRUE);
                           */     
				/* End of Weighted Average Costing Code */


                      

                         if ($_SESSION['CompanyRecord']['gllink_stock']==1){
                        /*we always need to reverse entries relating to the GRN suspense during delivery and entry of production run charges */
                              $sql = "INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount)
				VALUES (31,
					" . $_GET['SelectedProductionRunCosting'] . ",
					'" . Date('Y-m-d') . "',
					" . $PeriodNo . ",
					" . $_SESSION['CompanyRecord']['grnact'] . ",
					'" . $myrow['stockno'] . ' ' ._('prodrun cost') . ' ' .  number_format($ItemShipmentCost,2) . ' x ' . _('Qty recd') . ' ' . $myrow['quantityrecd'] . "', " . ($Variance * $myrow['quantityrecd']) . ")";

			      $ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The credit GL entry for the production run variance posting for') . ' ' . $myrow['stockno'] . ' ' . _('could not be inserted because');
// prnMsg(_('step 3 ') . $sql,'info');

			      $result = DB_query($sql,$db, $ErrMsg,'',TRUE);
                         }

        		if ( $_POST['UpdateCost'] == 'Yes' ){ /*Only ever a standard costing option
			                                      Weighted average costing implies cost updates taking place automatically */

				$QOHResult = DB_query("SELECT SUM(quantity) FROM locstock WHERE stockid ='" . $myrow['stockno'] . "'",$db);
				$QOHRow = DB_fetch_row($QOHResult);
				$QOH=$QOHRow[0];


                                if ($_SESSION['CompanyRecord']['gllink_stock']==1){
				   $CostUpdateNo = GetNextTransNo(35, $db);
       				   $PeriodNo = GetPeriod(Date("d/m/Y"), $db);

				   $ValueOfChange = $QOH * ($ItemShipmentCost - $myrow['bomunitcost']);

				   $SQL = "INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount)
						VALUES (35,
							" . $CostUpdateNo . ",
							'" . Date('Y-m-d') . "',
							" . $PeriodNo . ",
							" . $StockGLCodes['adjglact'] . ",
							'" . _('Production of') . ' ' . $myrow['stockno'] . " " . _('cost was') . ' ' . $myrow['bomunitcost'] . ' ' . _('changed to') . ' ' . number_format($ItemShipmentCost,2) . ' x ' . _('QOH of') . ' ' . $QOH . "', " . (-$ValueOfChange) . ")";
				   $ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL credit for the production run stock cost adjustment posting could not be inserted because'). ' ' . DB_error_msg($db);
// prnMsg(_('step 4 ') . $sql,'info');

				   $Result = DB_query($SQL,$db, $ErrMsg,'',TRUE);

				   $SQL = "INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount)
						VALUES (35,
							" . $CostUpdateNo . ",
							'" . Date('Y-m-d') . "',
							" . $PeriodNo . ",
							" . $StockGLCodes['stockact'] . ",
							'" . _('Production of') . ' ' . $myrow['stockno'] .  ' ' . _('cost was') . ' ' . $myrow['bomunitcost'] . ' ' . _('changed to') . ' ' . number_format($ItemShipmentCost,2) . ' x ' . _('QOH of') . ' ' . $QOH . "', " . $ValueOfChange . ")";
				   $ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GL debit for stock cost adjustment posting could not be inserted because') .' '. DB_error_msg($db);
// prnMsg(_('step 5 ') . $sql,'info');

				   $Result = DB_query($SQL,$db, $ErrMsg,'',TRUE);

                                } /*end of GL entries for a standard cost update */

                                /* Only the material cost is important for imported items */
				$sql = "UPDATE stockmaster SET materialcost=" . $ItemShipmentCost . ",
								overheadcost=0,
								lastcost=" . $myrow['bomunitcost'] . "
						WHERE stockid='" . $myrow['stockno'] . "'";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The production run cost details for the stock item could not be updated because'). ': ' . DB_error_msg($db);

				$result = DB_query($sql,$db, $ErrMsg,'',TRUE);
// prnMsg(_('step 7 ') . $sql,'info');

			} // end of update cost code
		} // end of Close shipment item updates

$projcost = $myrow['prodrunqty'] * $stkCost;
$projcost1 += $projcost;
$mainstock = $myrow['stockno'];
/* Order/  Item / Qty Inv/  FX price/ Local Val/ Portion of chgs/ Shipt Cost/ Std Cost/ Variance/ Var %   
number_format($myrow['unitprice'],2)*/

$sql5a ='SELECT SUM( stockmaster.materialcost + stockmaster.overheadcost ) AS stdcost
FROM stockmaster WHERE stockid = "' . $myrow['stockno'] . '"';
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity on hand could not be retrieved from the database');
				$DbgMsg = _('The following SQL to retrieve the total stock quantity was used');
				$Result5a = DB_query($sql5a, $db, $ErrMsg, $DbgMsg);
				$QtyRow5a = DB_fetch_row($Result5a);
				$StdCost5 = $QtyRow5a[0];
$NewCost = $StdCost5 + $CostIncrement;



$sql5 ='SELECT SUM(quantity) FROM locstock WHERE stockid="' . $myrow['stockno'] . '"';
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The quantity on hand could not be retrieved from the database');
				$DbgMsg = _('The following SQL to retrieve the total stock quantity was used');
				$Result5 = DB_query($sql5, $db, $ErrMsg, $DbgMsg);
				$QtyRow5 = DB_fetch_row($Result5);
				$TotalQuantityOnHand5 = $QtyRow5[0];


$NewUnitCost = (($myrow['prodrunqtyrecd'] *$ItemShipmentCost) + ($StdCost5 * $TotalQuantityOnHand5))/($TotalQuantityOnHand5 + $myrow['prodrunqtyrecd']);

	echo '<TD>' . $myrow['prno'] . '</TD>
		<TD>' . $myrow['stockno'] . ' - ' . $myrow['description'] . '</TD>
		<TD ALIGN=RIGHT>' . number_format($myrow['prodrunqty']) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($myrow['prodrunqtyrecd']) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($myrow['bomunitcost'],2) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($projcost) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($myrow['invoicedcharges']) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($PortionOfCharges) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($ItemShipmentCost,4) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($StdCost5,4) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($Variance,2) . '</TD>
		<TD ALIGN=RIGHT>' . $VariancePercentage . '</TD>
		<TD ALIGN=RIGHT>' . number_format($NewUnitCost,4) . '</TD>
		</TR>';
    }
}
echo '<TR><TD COLSPAN=5 ALIGN=RIGHT><FONT COLOR=BLUE><B>'. _('Total Charges'). '</B></FONT></TD>
	<TD ALIGN=RIGHT>' . number_format($projcost1) . '</TD>
	<TD ALIGN=RIGHT>' . number_format($TotalInvoiceValueOfShipment) . '</TD>
	<TD ALIGN=RIGHT>' . number_format($TotalCostsToApportion) .'</TD></TR>';

echo '</TABLE></CENTER><HR>';


echo '<TABLE COLSPAN=2 WIDTH=100%><TR><TD VALIGN=TOP>'; // put this production run charges side by side in a table (major table 2 cols)
/*
$sql = "SELECT suppliers.suppname,
		supptrans.suppreference,
		systypes.typename,
		supptrans.trandate,
		supptrans.rate,
		suppliers.currcode,
		productionruncostingcharges.stockid,
		productionruncostingcharges.value,
		supptrans.transno,
		supptrans.supplierno
	FROM supptrans INNER JOIN productionruncostingcharges
		ON productionruncostingcharges.transtype=supptrans.type
		AND productionruncostingcharges.transno=supptrans.transno
	INNER JOIN suppliers
		ON suppliers.supplierid=supptrans.supplierno
	INNER JOIN systypes ON systypes.typeid=supptrans.type
	WHERE productionruncostingcharges.stockid<>''
	AND productionruncostingcharges.prref=" . $_GET['SelectedProductionRunCosting'] . "
	ORDER BY supptrans.supplierno,
		supptrans.transno,
		productionruncostingcharges.stockid";
*/

$sql="SELECT productionrundetails.prdetailitem, productionruns.prno, productionrundetails.itemcode, productionrundetails.itemdescription, productionrundetails.processdate, productionrundetails.glcode, productionrundetails.qtyprocessed, productionrundetails.unitcost, stockmaster.units, productionrundetails.quantityord, productionrundetails.quantityrecd, productionrundetails.stdcostunit, productionrundetails.actcostunit, stockmaster.materialcost+stockmaster.overheadcost as stdcost, productionruns.workcentre, suppliers.suppname, suppliers.supplierid FROM productionrundetails INNER JOIN stockmaster ON productionrundetails.itemcode=stockmaster.stockid INNER JOIN productionruns ON productionrundetails.prno=productionruns.prno JOIN suppliers on suppliers.supplierid=productionruns.supplierno WHERE productionrundetails.prref=" . $_GET['SelectedProductionRunCosting'];


$ChargesResult = DB_query($sql,$db);

echo '<FONT COLOR=BLUE SIZE=2>' . _('Production Run Charges Against Materials'). '</FONT>';
echo '<TABLE CELLPADDING=2 COLSPAN=6 BORDER=0>';

$TableHeader = '<TR>
		<TD class="tableheader">'. _('Item'). '</TD>
		<TD class="tableheader">'. _('Description'). '</TD>
		<TD class="tableheader">'. _('BOM Projected'). '</TD>
		<TD class="tableheader">'. _('Actual Qty'). '</TD>
		<TD class="tableheader">'. _('Date'). '</TD>
		<TD class="tableheader">'. _('Unit Cost'). '</TD>
		<TD class="tableheader">'. _('Amount Charged'). '<BR>'. _('to COGS'). '</TD></TR>';

echo  $TableHeader;

/*show the line items on the production run with the value invoiced and shipt cost */

$k=0; //row colour counter
$RowCounter =0;
$TotalItemShipmentChgs =0;

while ($myrow=db_fetch_array($ChargesResult)) {

$sqlrecipe="select quantity from bom where component='" . $myrow['itemcode'] . "' and parent='" . $mainstock . "'";
$recipeResult = DB_query($sqlrecipe,$db);

$recipe1=db_fetch_array($recipeResult);
$recipe = $recipe1['quantity'];
$basecost = $myrow['actcostunit']*$recipe;

	if ($RowCounter==15){
		echo $TableHeader;
		$RowCounter =0;
	}
	$RowCounter++;
	$RowTotal=0;
	$RowTotal=$myrow['quantityrecd']*$myrow['actcostunit'];
	if ($k==1){
		echo '<tr bgcolor="#CCCCCC">';
		$k=0;
	} else {
		echo '<tr bgcolor="#EEEEEE">';
		$k=1;
	}
/*' . $myrow['suppreference'] . '   . number_format($myrow['value'])*/
	echo '<TD>' . $myrow['itemcode'] . '</TD>
		<TD>' . $myrow['itemdescription'] . '</TD>
		<TD>' .$myrow['quantityord'] . '</TD>
		<TD>' .-$myrow['quantityrecd'] . '</TD>
		<TD>' . ConvertSQLDate($myrow['processdate']) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($basecost,4) . '</TD>
		<TD ALIGN=RIGHT>' . number_format(-$RowTotal,2) . '</TD></TR>';

	$TotalItemShipmentChgs += -$RowTotal;
	$TotalUnitCost += $basecost;
}

echo '<TR><TD COLSPAN=5 ALIGN=RIGHT><FONT COLOR=BLUE><B>'. _('Total Charges Against Production Run Materials'). ':</B></FONT></TD>
	<TD ALIGN=RIGHT>' . number_format($TotalUnitCost,4) . '</TD><TD ALIGN=RIGHT>' . number_format($TotalItemShipmentChgs,2) . '</TD></TR>';

echo '</TABLE>';

echo '</TD><TD VALIGN=TOP>'; //major table

/* Now the production run freight/duty etc general charges */

$sql = "SELECT suppliers.suppname,
		supptrans.suppreference,
		systypes.typename,
		supptrans.trandate,
		supptrans.rate,
		suppliers.currcode,
		productionruncostingcharges.stockid,
		productionruncostingcharges.value
	FROM supptrans INNER JOIN productionruncostingcharges
		ON productionruncostingcharges.transtype=supptrans.type
		AND productionruncostingcharges.transno=supptrans.transno
	INNER JOIN suppliers
		ON suppliers.supplierid=supptrans.supplierno
	INNER JOIN systypes
		ON systypes.typeid=supptrans.type
	WHERE productionruncostingcharges.prref=" . $_GET['SelectedProductionRunCosting'] . "
	ORDER BY supptrans.supplierno,
		supptrans.transno";

$ChargesResult = DB_query($sql,$db);

echo '<FONT COLOR=BLUE SIZE=2>'._('Invoiced Charges').'</FONT>';
//echo '<P>';
//echo $sql;
//echo '</p>';
echo '<TABLE CELLPADDING=2 COLSPAN=5 BORDER=0>';

$TableHeader = '<TR>
		<TD class="tableheader">'. _('Supplier'). '</TD>
		<TD class="tableheader">'. _('Type'). '</TD>
		<TD class="tableheader">'. _('Stock ID'). '</TD>
		<TD class="tableheader">'. _('Ref'). '</TD>
		<TD class="tableheader">'. _('Date'). '</TD>
		<TD class="tableheader">'. _('Local Amount'). '<BR>'. _('Charged'). '</TD></TR>';

echo  $TableHeader;

/*show the line items on the production run with the value invoiced and shipt cost */

$k=0; //row colour counter
$RowCounter =0;
$TotalGeneralShipmentChgs =0;

while ($myrow=db_fetch_array($ChargesResult)) {

	if ($RowCounter==15){
		echo $TableHeader;
		$RowCounter =0;
	}
	$RowCounter++;

	if ($k==1){
		echo '<tr bgcolor="#CCCCCC">';
		$k=0;
	} else {
		echo '<tr bgcolor="#EEEEEE">';
		$k=1;
	}

	echo '<TD>' . $myrow['suppname'] . '</TD>
		<TD>' .$myrow['typename'] . '</TD>
		<TD>' .$myrow['stockid'] . '</TD>
		<TD>' . $myrow['suppreference'] . '</TD>
		<TD>' . ConvertSQLDate($myrow['trandate']) . '</TD>
		<TD ALIGN=RIGHT>' . number_format($myrow['value']) . '</TD></TR>';

	$TotalGeneralShipmentChgs += $myrow['value'];

}

echo '<TR>
	<TD ALIGN=RIGHT COLSPAN=4><FONT COLOR=BLUE><B>'. _('Total General Production Run Charges'). ':</B></FONT></TD>
	<TD ALIGN=RIGHT>' . number_format($TotalGeneralShipmentChgs) . '</TD></TR>';

echo '</TABLE>';

echo '</TD></TR></TABLE>'; //major table close

if ( isset($_GET['Close'])) { /* Only an opportunity to confirm user wishes to close */

// if the page was called with Close=Yes then show options to confirm OK to c
	echo '<HR><CENTER><FORM METHOD="POST" ACTION="' . $_SERVER['PHP_SELF'] .'?' . SID .'&SelectedProductionRunCosting=' . $_GET['SelectedProductionRunCosting'] . '">';

        if ($_SESSION['WeightedAverageCosting']==0){
        /* We are standard costing - so show the option to update costs - under W. Avg cost updates are implicit */
        	echo _('Update Standard Costs') .':<SELECT NAME="UpdateCost">
	        <OPTION SELECTED VALUE="Yes">'. _('Yes') . '
		<OPTION VALUE="No">'. _('No').'</SELECT>';
        }
	echo '<BR><BR><INPUT TYPE=SUBMIT NAME="Close" VALUE="'. _('Confirm OK to Close'). '">';
	echo '</FORM>';
}

if ( isset($_POST['Close']) ){ /* OK do the production run close journals */

/*Inside a transaction need to:
 1 . compare production run costs against standard x qty received and take the variances off to the GL GRN supsense account and variances - this is done in the display loop

 2. If UpdateCost=='Yes' then do the cost updates and GL entries.

 3. Update the production run to completed

 1 and 2 done in the display loop above only 3 left*/

/*also need to make sure the purchase order lines that were on this production run are completed so no more can be received in against the order line 
*/
        $result = DB_query('UPDATE productionruns
                                   SET completed=1
                            WHERE prref = ' . $_GET['SelectedProductionRunCosting'],
                            $db,
                            _('Could not complete the purchase order lines on this production run'),
                            '',
                            TRUE);

        $result = DB_query('UPDATE productionruncosting
                                   SET closed=1
                            WHERE prref = ' . $_GET['SelectedProductionRunCosting'],
                            $db,
                            _('Could not complete the purchase order lines on this production run'),
                            '',
                            TRUE);

	
	$result = DB_query('COMMIT',$db);

	echo '<BR><BR>';
	prnMsg( _('Production Run '). ' ' . $_GET['SelectedProductionRunCosting'] . ' ' . _('has been closed') );
	if ($_SESSION['CompanyRecord']['gllink_stock']==1) {
		echo '<BR>';
		prnMsg ( _('All variances were posted to the general ledger') );
	}
	If ($_POST['UpdateCost']=='Yes'){
		echo '<BR>';
		prnMsg ( _('All production run items have had their standard costs updated') );
	}
}

include('includes/footer.inc');
?>