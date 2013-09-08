<?php

/* $Revision: 1.15 $ */

$PageSecurity = 4;
include('includes/DefinePRClass.php');
include('includes/session.inc');

if (isset($_GET['ModifyPRNumber'])) {
	$title = _('Modify Item Assembly') . ' IA' . $_GET['ModifyPRNumber'];
	$_GET['PRNumber']=$_GET['ModifyPRNumber'];
} else {
	$title = _('Item Assembly Entry');
}

include('includes/header.inc');
include('includes/SQL_CommonFunctions.inc');

/*Page is called with NewPR=Yes when a new order is to be entered
the session variable that holds all the PO data $_SESSION['PR'] is unset to allow
all new details to be created */

if (isset($_GET['NewPR']) and isset($_SESSION['PR'])){
     unset($_SESSION['PR']);
     $_SESSION['ExistingPR']=0;
}
if (isset($_POST['Commit']))
{ /*User wishes to commit the Item Assembly to the database */
	$tot_no_prod = $_REQUEST['rowcountspec'];
//		prnMsg(_('row count ') . ' req ' . $_REQUEST['rowcountspec'] . ' post ' . $BOMCount . ' ');

 $sql = 'BEGIN';
 $result = DB_query($sql,$db);

	$_SESSION['PR']->Workcentre=$_POST['WorkCentre'];
	$_SESSION['PR']->WorkAdd1 = $_POST['WorkAdd1'];
	$_SESSION['PR']->WorkAdd2 = $_POST['WorkAdd2'];
	$_SESSION['PR']->WorkAdd3 = $_POST['WorkAdd3'];
	$_SESSION['PR']->WorkAdd4 = $_POST['WorkAdd4'];
	$_SESSION['PR']->WorkAdd5 = $_POST['WorkAdd5'];
	$_SESSION['PR']->WorkAdd6 = $_POST['WorkAdd6'];
	$_SESSION['PR']->Initiator = $_POST['Initiator'];
		$_SESSION['PR']->Orig_InitDate = $_POST['InitDate'];
	//$_SESSION['PR']->ReqDate = $_POST['ReqDate'];
	//$_SESSION['PR']->StockNo = $_POST['StockNo'];
	//$_SESSION['PR']->StockNo = 999999999;
	$_SESSION['PR']->OrdQty = $_POST['OrdQty'];
	$_SESSION['PR']->ManCosts = $_POST['ManCosts'];
	$_SESSION['PR']->OtherCosts = $_POST['OtherCosts'];
	//$_SESSION['PR']->OrdQty = 999999;
	$_SESSION['PR']->RecdQty = $_POST['RecdQty'];
	$_SESSION['PR']->RequisitionNo = $_POST['Requisition'];
	$_SESSION['PR']->ExRate = $_POST['ExRate'];
	$_SESSION['PR']->Comments = $_POST['Comments'];

	if ($_POST['RePrint']==1)
	{

		$_SESSION['PR']->AllowPrintPR=1;

		$sql = 'UPDATE productionruns
			SET productionruns.allowprint=1
			WHERE productionruns.prno=' . $_SESSION['PR']->PRNo;

		$ErrMsg = _('An error occurred updating the Item Assembly to allow reprints') . '. ' . _('The error says');
		$updateResult = DB_query($sql,$db,$ErrMsg);
	
	}


	// prnMsg( _('SUCCESS - First step reached') . $_SESSION['PR']->PRNo,'info');



	$delflag=0;
	
	//prnMsg( _('delflag ') . $delflag,'info');


	$InputError=0; /*Start off assuming the best */
	
//	} elseif ($_SESSION['PR']->WorkAdd2=='' OR strlen($_SESSION['PR']->WorkAdd2)<3){
//	      prnMsg( _('The Item Assembly can not be committed to the database because there is no suburb address specified'),'error');
//	      $InputError=1;
	 /* elseif ($_SESSION['PR']->Workcentre=='' OR ! isset($_SESSION['PR']->Workcentre)){
	      prnMsg( _('The Item Assembly can not be committed to the database because there is no warehouse specified to book any stock items into'),'error');
	      $InputError=1;
	} elseif ($_SESSION['PR']->LinesOnPR <=0){
	     prnMsg( _('The Item Assembly can not be committed to the database because there are no lines entered on this run'),'error');
	     $InputError=1;
	} */

	if ($InputError!=1)
	{
	
	
		 if ($_SESSION['ExistingPR']==0)
		 { /*its a new order to be inserted */
		
			// prnMsg( _('new record '),'info');

		     /*Insert to Item Assembly header record */
		     $sql = "INSERT INTO productionruns (comments,
							initdate,
							reqdate,
							initiator,
							requisitionno,
							workcentre,
							workadd1,
							workadd2,
							workadd3,
							workadd4,
							workadd5,
							workadd6,
							stockno,
							prodrunqty,
							mancosts,
							othercosts)
				VALUES(
				'" . DB_escape_string($_SESSION['PR']->Comments) . "',
				'" . FormatDateForSQL($_SESSION['PR']->Orig_InitDate) . "',
				'" . FormatDateForSQL($_POST['ReqDate']) . "',
				'" . $_SESSION['PR']->Initiator . "',
				'" . $_SESSION['PR']->RequisitionNo . "',
				'" . $_SESSION['PR']->Workcentre . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd1) . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd2) . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd3) . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd4) . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd5) . "',
				'" . DB_escape_string($_SESSION['PR']->WorkAdd6) . "',
				'" . $_SESSION['PR']->StockNo . "',
				'" . $_SESSION['PR']->OrdQty . "',
				'" . $_SESSION['PR']->ManCosts . "',
				'" . $_SESSION['PR']->OtherCosts . "'
				)";
//			REMOVED FROM SQL ABOVE -- '" . Date("Y-m-d") . "',
				
			$ErrMsg =  _('The Item Assembly header record could not be inserted into the database because');
			$DbgMsg = _('The SQL statement used to insert the Item Assembly header record and failed was');
		//prnMsg( _('FAILED') . $_SESSION['PR']->PRNo . ' -- ' . $_SESSION['PR']->OrdQty . ' -- ' . $_REQUEST['ProdRunItem'] . ' -- ' . $_POST['ProdRunItem'] . ' -- ' . $_POST['StockNo'],'warn');

			$result = DB_query($sql,$db,$ErrMsg,$DbgMsg,true);
 	prnMsg( _('new PR sql ') . $sql,'info');

		     /*Get the auto increment value of the Item Assembly number created from the SQL above */
		     $_SESSION['PR']->PRNo = DB_Last_Insert_ID($db,'productionruns','prno');


	
	/*Insert the Item Assembly detail records */
	
			for($i=1; $i<=$tot_no_prod; $i++)
			{
			
				// $query = 'BEGIN';
				//	 $bomresult = DB_query($query,$db);
			
			
					$include_var = 'include'.$i;
					$bom_id_var = 'stockid'.$i;
					$desc_var = 'description'.$i;
					$glcode_var = 'glcode'.$i;
					$quantityord_var = 'bomqty'.$i;
					$unitcost_var = 'unitcost'.$i;
					$bomunitcost_var = 'bomunitcost'.$i;
					$qtyperunit_var = 'qtyperunit'.$i;
					$bomtotal_var = 'bomtotal'.$i;
					$prlineno_var = 'prlineno'.$i;
			// $tot_no_prod = $_REQUEST['rowcountspec'];
					
					
					$include = $_REQUEST[$include_var];
					$bom_id = $_REQUEST[$bom_id_var];
					$desc = $_REQUEST[$desc_var];
					$glcode = $_REQUEST[$glcode_var];
					$quantityord = $_REQUEST[$quantityord_var];
					$unitcost = $_REQUEST[$unitcost_var];
					$bomtotal = $_REQUEST[$bomtotal_var];
					$bomunitcost = $_REQUEST[$bomunitcost_var];
					$qtyperunit = $_REQUEST[$qtyperunit_var];
					$prlineno = $_REQUEST[$prlineno_var];
					$test = $_POST[$include_var];
					// prnMsg( _('TESTING VARS 1 - BOM ID VAR') . $bom_id_var . ' DIRECT' . $_REQUEST['stockid1'] . ' CONTRIVED' . $bom_id,'info');
	//						prnMsg( _('echo include ') . $include,'info');
					//		prnMsg( _('echo include2 ') . $test ,'info');

					   if ($include==true)
					   	{			
						 $sql ="insert into productionrundetails (prno, itemcode, orddate, itemdescription, glcode, unitcost, quantityord, parent, bomtotal, prlineno,qtyperunit,bomunitcost)
						 VALUES (
						 '" . $_SESSION['PR']->PRNo ."',
						 '" . $bom_id ."',
						 '" . FormatDateForSQL($_SESSION['PR']->Orig_InitDate) ."',
						 '" . DB_escape_string($desc) ."',
						 '" . $glcode ."',
						 '" . $unitcost ."',
						 '" . $quantityord ."',
						 '" . $_SESSION['PR']->StockNo ."',
						 '" . $bomtotal . "',
						 '" . $prlineno . "',
						 '" . $qtyperunit . "',
						 '" . $bomunitcost . "'
						 )";
						 
						$ErrMsg = _('One of the purchase order detail records could not be updated because');
							$DbgMsg = _('The SQL statement used to update the purchase order detail record that failed was');
							$result =DB_query($sql,$db,$ErrMsg,$DbgMsg,true);
								prnMsg( _('new PR sql2 ') . $sql,'info');

							prnMsg( _('SUCCESS - Item Assembly IA') . $_SESSION['PR']->PRNo . ' created','info');
		
			//	 	 $query = 'COMMIT';
			//		 $bomresult = DB_query($query,$db);
			
			// prnMsg( _('insert PR detail ') . $bom_id . $desc,'info');

					 	}
			
				} 
		 
		 
		 
		
		 
			$ErrMsg = _('One of the Item Assembly detail records could not be updated because');
				$DbgMsg = _('The SQL statement used to update the Item Assembly detail record that failed was');
//				$result =DB_query($sql,$db,$ErrMsg,$DbgMsg,true);
		//		prnMsg( _('end new record '),'info');

//	 	 $query = 'COMMIT';
//		 $bomresult = DB_query($query,$db);
	     

		} 
			
		else 
		
		{ /*its a new order to be inserted */
			$q1=$_SESSION['PR']->StockNo;
			$q1a=$_SESSION['PR']->Special999;
			$q1c=$_POST['StockNo'];
			$q1d=$_REQUEST['StockNo'];
			$q1e=$_REQUEST['ProdRunItem'];
			
			$q2 = $q1;
			if ((!isset($q2)) || ($q2 == '') || (strlen($q2)<2))
			{$q2 = $q1a;}
			if ((!isset($q2)) || ($q2 == '') || (strlen($q2)<2))
			 {$q2 = $q1e;}
			 if ((!isset($q2)) || ($q2 == '') || (strlen($q2)<2)) {
			 	prnMsg( _('FAILED:  stock id not set correctly - inform administrator of error ') . $q2,'warn');
	//			prnMsg( _('FAILED: post stockno ') . $q1c . 'request stockno ' .  $q1d. 'request stockno ' .  'session stockno ' . $q1a . 'session special ' .$q1b . 'request prodrunitem ' .$q1e,'warn');
				exit;
				  }
			
		     /*Insert to Item Assembly header record */
		     $sql = "UPDATE productionruns SET
						 comments = '" . DB_escape_string($_SESSION['PR']->Comments) . "',
							initdate='" . FormatDateForSQL($_SESSION['PR']->Orig_InitDate) . "',
							reqdate='" . FormatDateForSQL($_POST['ReqDate']) . "',
							initiator='" . $_SESSION['PR']->Initiator . "',
							requisitionno='" . $_SESSION['PR']->RequisitionNo . "',
							workcentre='" . $_SESSION['PR']->Workcentre . "',
							workadd1='" . DB_escape_string($_SESSION['PR']->WorkAdd1) . "',
							workadd2='" . DB_escape_string($_SESSION['PR']->WorkAdd2) . "',
							workadd3='" . DB_escape_string($_SESSION['PR']->WorkAdd3) . "',
							workadd4='" . DB_escape_string($_SESSION['PR']->WorkAdd4) . "',
							workadd5='" . DB_escape_string($_SESSION['PR']->WorkAdd5) . "',
							workadd6='" . DB_escape_string($_SESSION['PR']->WorkAdd6) . "',
							stockno='" . $q2 . "',
							prodrunqty='" . $_SESSION['PR']->OrdQty . "',
							mancosts='" . $_SESSION['PR']->ManCosts . "',
							othercosts='" . $_SESSION['PR']->OtherCosts . "'
							WHERE productionruns.prno=" . $_SESSION['PR']->PRNo;
//			REMOVED FROM SQL ABOVE -- '" . Date("Y-m-d") . "',
				
			$ErrMsg =  _('The Item Assembly header record could not be updated into the database because');
			$DbgMsg = _('The SQL statement used to update the Item Assembly header record and failed was');
		//prnMsg( _('FAILED') . $_SESSION['PR']->PRNo . ' -- ' . $_SESSION['PR']->OrdQty . ' -- ' . $_REQUEST['ProdRunItem'] . ' -- ' . $_POST['ProdRunItem'] . ' -- ' . $_POST['StockNo'],'warn');

			$result = DB_query($sql,$db,$ErrMsg,$DbgMsg,true);
			
			prnMsg( _('SUCCESS - Item Assembly IA') . $_SESSION['PR']->PRNo . ' updated','info');
		
 			// prnMsg( _('update record ') . $sql,'info');
			
// prnMsg( _('variables ') . $q1 . 'other ' . $q1a,'info');

		     /*Get the auto increment value of the Item Assembly number created from the SQL above */
		    // $_SESSION['PR']->PRNo = DB_Last_Insert_ID($db,'productionruns','prno');


	
	/*Insert the Item Assembly detail records */
			if (!($q1a == $q1))
			{
				$sqldel="DELETE FROM productionrundetails WHERE prno='" . $_SESSION['PR']->PRNo . "'";
						$resultdel = DB_query($sqldel,$db);
						$delflag = 1;
						$t1 = $_SESSION['PR']->StockNo;
						$t2 = $_SESSION['PR']->Special999;
						$t3=$_POST['Special999'];
				// prnMsg( _('deleting subrecords '),'info');
			// prnMsg( _('variables ') . $q1 . 'other ' . $t2 . ' post ' . $t3,'info');

			}   else
			
			{
				$delflag = 0;
	//			prnMsg(_('delflag equals 0'),'info');
			}
			
			for($i=1; $i<=$tot_no_prod; $i++)
			
			{

			// $query = 'BEGIN';
			//	 $bomresult = DB_query($query,$db);
		
				$include_var = 'include'.$i;
				$bom_id_var = 'stockid'.$i;
				$desc_var = 'description'.$i;
				$glcode_var = 'glcode'.$i;
				$quantityord_var = 'bomqty'.$i;
				$unitcost_var = 'unitcost'.$i;
				$bomunitcost_var = 'bomunitcost'.$i;
					$qtyperunit_var = 'qtyperunit'.$i;
					$bomtotal_var = 'bomtotal'.$i;
				$prlineno_var = 'prlineno'.$i;
				
		// $tot_no_prod = $_REQUEST['rowcountspec'];
				
				
				$include = $_REQUEST[$include_var];
				$bom_id = $_REQUEST[$bom_id_var];
				$desc = $_REQUEST[$desc_var];
				$glcode = $_REQUEST[$glcode_var];
				$quantityord = $_REQUEST[$quantityord_var];
				$unitcost = $_REQUEST[$unitcost_var];
				$bomtotal = $_REQUEST[$bomtotal_var];
				$prlineno = $_REQUEST[$prlineno_var];
				$bomunitcost = $_REQUEST[$bomunitcost_var];
					$qtyperunit = $_REQUEST[$qtyperunit_var];
					
				
				//prnMsg( _('TESTING VARS 1 - BOM ID VAR') . $bom_id_var . ' DIRECT' . $_REQUEST['stockid1'] . ' CONTRIVED' . $bom_id,'info');
		
				if($delflag==1)
				{
			 		// prnMsg( _('insert update details '),'info');
		
				if($include==true)
					{
					 $sql ="insert into productionrundetails (prno, itemcode, orddate, itemdescription, glcode, unitcost, quantityord, parent, bomtotal, prlineno,qtyperunit,bomunitcost)
					 VALUES (
					 '" . $_SESSION['PR']->PRNo ."',
					 '" . $bom_id ."',
					 '" . FormatDateForSQL($_SESSION['PR']->Orig_InitDate) ."',
					 '" . DB_escape_string($desc) ."',
					 '" . $glcode ."',
					 '" . $unitcost ."',
					 '" . $quantityord ."',
					 '" . $_SESSION['PR']->StockNo ."',
					 '" . $bomtotal . "',
					 '" . $prlineno . "',
					 '" . $qtyperunit ."',
					 '" . $bomunitcost ."'
					 )";
					//prnMsg( _('delflag equals 1') . $sql,'info');
		 		 $result = DB_query($sql,$db);
				//  prnMsg( _('SUCCESS - Item Assembly ') . $_SESSION['PR']->PRNo . ' created','info');
		
				}
				}	
				
				else
				
				{
				//prnMsg( _('insert update detail delflag equals not 1'),'info');
		
				if($include==true)
					{
					
				 $sql ="UPDATE productionrundetails SET
				 itemcode='" . $bom_id ."',
				 orddate='" . FormatDateForSQL($_SESSION['PR']->Orig_InitDate) ."',
				 itemdescription='" . DB_escape_string($desc) ."',
				 glcode='" . $glcode ."',
				 unitcost='" . $unitcost ."',
				 quantityord='" . $quantityord ."',
				 parent='" . $_SESSION['PR']->StockNo ."',
				 bomtotal='" . $bomtotal . "',
				 qtyperunit = '" . $qtyperunit ."',
				  bomunitcost = '" . $bomunitcost ."'
				 WHERE productionrundetails.prlineno= '" . $prlineno . "'
				 AND productionrundetails.prno='" . $_SESSION['PR']->PRNo ."'";
				// 	prnMsg( _('delflag equals not 1') . $sql,'info');
		
						 $result = DB_query($sql,$db);
						 
						}
				} 
			}		 
		 
		}
		$sql = 'COMMIT';
		 $result = DB_query($sql,$db);

			
		 unset($_SESSION['PR']); /*Clear the PO data to allow a newy to be input*/
		 echo "<BR><BR><A HREF='$rootpath/PR_Header.php?" . SID . "&NewOrder=Yes'>" . _('Enter A New Item Assembly') . '</A>';
		 echo "<BR><A HREF='$rootpath/PR_SelectProductionRun.php?" . SID . "'>" . _('Select An Outstanding Item Assembly') . '</A>';
		 exit;

	}
}









echo '<A HREF="'. $rootpath . '/PR_SelectProductionRun.php?' . SID . '">'. _('Back to Item Assemblies'). '</A> <BR>';

/*The page can be called with ModifyPRNumber=x where x is a Item Assembly number
The page then looks up the details of order x and allows these details to be modified */

if ($_GET['ModifyPRNumber']!=''){
	  include ('includes/PR_ReadInPR.inc');
	  $special999 = $_SESSION['PR']->StockNo;
	  $_SESSION['PR']->Special999 = $special999;
	  
}

if (isset($_POST['CancelPR']) AND $_POST['CancelPR']!='') { /*The cancel button on the header screen - to delete order */
	$OK_to_delete = 1;	 //assume this in the first instance

	if(!isset($_SESSION['ExistingPR']) OR $_SESSION['ExistingPR']!=0) { //need to check that not already dispatched or invoiced by the supplier

		if($_SESSION['PR']->Any_Already_Received()==1){
			$OK_to_delete =0;
			prnMsg( _('This Item Assembly cannot be cancelled because some of it has already been processed') . '. ' . _('The line item quantities may be modified to quantities more than already processed') . '. ' . _('Quantities cannot be reduced below the quantity already processed'),'warn');
		}

	}

	if ($OK_to_delete==1){
		unset($_SESSION['PR']->LineItems);
		unset($_SESSION['PR']);
		$_SESSION['PR'] = new ProductionRun;
		$_SESSION['RequireSupplierSelection'] = 1;

		if($_SESSION['ExistingPR']!=0){

			$SQL = 'DELETE FROM productionrundetails WHERE productionrundetails.prno =' . $_SESSION['ExistingPR'];
			$ErrMsg = _('The Item Assembly detail lines could not be deleted because');
			$DelResult=DB_query($SQL,$db,$ErrMsg);

			$SQL = 'DELETE FROM productionruns WHERE productionruns.prno=' . $_SESSION['ExistingPR'];
			$ErrMsg = _('The order header could not be deleted because');
			$DelResult=DB_query($SQL,$db,$ErrMsg);
		 }
	}
}

if (!isset($_SESSION['PR'])){
	/* It must be a new order being created $_SESSION['PR'] would be set up from the Item Assembly modification code above if a modification to an existing order. Also $ExistingPR would be set to 1. The delivery check screen is where the details of the Item Assembly are either updated or inserted depending on the value of ExistingPR */

	Session_register('PR');
//	Session_register('RequireSupplierSelection');
	Session_register('ExistingPR');

	$_SESSION['ExistingPR']=0;
	$_SESSION['PR'] = new ProductionRun;
	$_SESSION['PR']->AllowPrintPR = 1; /*Of course cos the Item Assembly aint even started !!*/
	$_SESSION['PR']->GLLink = $_SESSION['CompanyRecord']['gllink_stock'];

//	if ($_SESSION['PR']->SupplierID=='' OR !isset($_SESSION['PR']->SupplierID)){

/* a session variable will have to maintain if a supplier has been selected for the Item Assembly or not the session variable supplierID holds the supplier code already as determined from user id /password entry  */
//		$_SESSION['RequireSupplierSelection'] = 1;
//	} else {
	//	$_SESSION['RequireSupplierSelection'] = 0;
//	}
//}

//if ($_POST['ChangeSupplier']!=''){

/* change supplier only allowed with appropriate permissions - button only displayed to modify is AccessLevel >10  (see below)*/
//	if ($_SESSION['PR']->Any_Already_Received()==0){
//		$_SESSION['RequireSupplierSelection']=1;
//	} else {
//		echo '<BR><BR>';
//		prnMsg(_('Cannot modify the supplier of the Item Assembly once some of the Item Assembly has been processed'),'warn');
//	}
//}
/*
if (isset($_POST['SearchSuppliers'])){

	If (strlen($_POST['Keywords'])>0 AND strlen($_POST['SuppCode'])>0) {
		$msg=_('Supplier name keywords have been used in preference to the supplier code extract entered');
	}
	If ($_POST['Keywords']=='' AND $_POST['SuppCode']=='') {
		$msg=_('At least one Supplier Name keyword OR an extract of a Supplier Code must be entered for the search');
	} else {
		If (strlen($_POST['Keywords'])>0) {
		//insert wildcard characters in spaces

			$i=0;
			$SearchString = '%';
			while (strpos($_POST['Keywords'], ' ', $i)) {
				$wrdlen=strpos($_POST['Keywords'],' ',$i) - $i;
				$SearchString=$SearchString . substr($_POST['Keywords'],$i,$wrdlen) . '%';
				$i=strpos($_POST['Keywords'],' ',$i) +1;
			}
			$SearchString = $SearchString. substr($_POST['Keywords'],$i).'%';
			$SQL = "SELECT suppliers.supplierid, 
					suppliers.suppname, 
					suppliers.currcode 
				FROM suppliers 
				WHERE suppliers.suppname " . LIKE . " '$SearchString'
				ORDER BY suppliers.suppname";

		} elseif (strlen($_POST['SuppCode'])>0){
			$SQL = "SELECT suppliers.supplierid, 
					suppliers.suppname, 
					suppliers.currcode 
				FROM suppliers 
				WHERE suppliers.supplierid " . LIKE . " '%" . $_POST['SuppCode'] . "%'
				ORDER BY suppliers.supplierid";
		}

		$ErrMsg = _('The searched supplier records requested cannot be retrieved because');
		$result_SuppSelect = DB_query($SQL,$db,$ErrMsg);

		if (DB_num_rows($result_SuppSelect)==1){
			$myrow=DB_fetch_array($result_SuppSelect);
			$_POST['Select'] = $myrow['supplierid'];
		} elseif (DB_num_rows($result_SuppSelect)==0){
			prnMsg( _('No supplier records contain the selected text') . ' - ' . _('please alter your search criteria and try again'),'info');
		}*/
//	} /*one of keywords or SuppCode was more than a zero length string */
//} /*end of if search for supplier codes/names */


//if ($_POST['Select']) {

/*will only be true if page called from supplier selection form or set because only one supplier record returned from a search
 so parse the $Select string into supplier code and branch code */
/*
	$sql = "SELECT suppliers.suppname,
			suppliers.currcode,
			currencies.rate
		FROM suppliers INNER JOIN currencies
		ON suppliers.currcode=currencies.currabrev
		WHERE supplierid='" . $_POST['Select'] . "'";

	$ErrMsg = _('The supplier record of the supplier selected') . ': ' . $_POST['Select'] . ' ' . _('cannot be retrieved because');
	$DbgMsg = _('The SQL used to retrieve the supplier details and failed was');
	$result =DB_query($sql,$db,$ErrMsg,$DbgMsg);


	$myrow = DB_fetch_row($result);
	$_SESSION['PR']->SupplierID = $_POST['Select'];
	$_SESSION['RequireSupplierSelection'] = 0;
	$_SESSION['PR']->SupplierName = $myrow[0];
	$_SESSION['PR']->CurrCode = $myrow[1];
	$_SESSION['PR']->ExRate = $myrow[2];
	$_POST['ExRate'] = $myrow[2];
}

*/
/*
if ($_SESSION['RequireSupplierSelection'] ==1 OR !isset($_SESSION['PR']->SupplierID) OR $_SESSION['PR']->SupplierID=='' ) {

	echo '<BR><BR><FONT SIZE=3><B>' . _('Supplier Selection') . "</B></FONT><BR>
	<FORM ACTION='" . $_SERVER['PHP_SELF'] . '?' . SID . "' METHOD=POST>";
	if (strlen($msg)>1){
//		prnMsg($msg,'warn');
	}
*/
/*	echo '<TABLE CELLPADDING=3 COLSPAN=4>
	<TR>
	<TD><FONT SIZE=1>' . _('Enter text in the supplier name') . ":</FONT></TD>
	<TD><INPUT TYPE='Text' NAME='Keywords' SIZE=20	MAXLENGTH=25></TD>
	<TD><FONT SIZE=3><B>" . _('OR') . '</B></FONT></TD>
	<TD><FONT SIZE=1>' . _('Enter text extract in the supplier code') . ":</FONT></TD>
	<TD><INPUT TYPE='Text' NAME='SuppCode' SIZE=15	MAXLENGTH=18></TD>
	</TR>
	</TABLE>
	<CENTER><INPUT TYPE=SUBMIT NAME='SearchSuppliers' VALUE=" . _('Search Now') . ">
	<INPUT TYPE=SUBMIT ACTION=RESET VALUE='" . _('Reset') . "'></CENTER>";

	If ($result_SuppSelect) {

		echo '<BR><CENTER><TABLE CELLPADDING=3 COLSPAN=7 BORDER=1>';

		$tableheader = "<TR>
				<TD class='tableheader'>" . _('Code') . "</TD>
				<TD class='tableheader'>" . _('Supplier Name') . "</TD>
				<TD class='tableheader'>" . _('Currency') . '</TD>
				</TR>';

		echo $tableheader;

		$j = 1;
		$k = 0; //row counter to determine background colour

		while ($myrow=DB_fetch_array($result_SuppSelect)) {

			if ($k==1){
				echo "<tr bgcolor='#CCCCCC'>";
				$k=0;
			} else {
				echo "<tr bgcolor='#EEEEEE'>";
				$k++;
			}

			printf("<td><INPUT TYPE=SUBMIT NAME='Select' VALUE='%s'</td>
				<td>%s</td>
				<td>%s</td>
				</tr>",
				$myrow['supplierid'],
				$myrow['suppname'],
				$myrow['currcode']);

			$j++;
			If ($j == 11){
				$j=1;
				echo $tableheader;
			}
//end of page full new headings if
		}
//end of while loop

		echo '</TABLE></CENTER>';

	}
//end if results to show
*/
//end if RequireSupplierSelection
} 

//else {
// everything below here only do if a supplier is selected

	echo "<FORM ACTION='" . $_SERVER['PHP_SELF'] . '?' . SID . "' METHOD=POST>";

	echo '<CENTER>' . _('Item Assembly') . ': <FONT COLOR=BLUE SIZE=4><B>IA' . $_SESSION['PR']->PRNo . ' ' . $_SESSION['PR']->SupplierName . '</U> </B></FONT> - ' . _('All amounts stated in CDN')  . '<BR><BR>';

	/*Set up form for entry of order header stuff */

	if(($_POST['WorkCentre']=='' OR !isset($_POST['WorkCentre'])) AND (isset($_SESSION['PR']->Workcentre) AND $_SESSION['PR']->Workcentre!='')){
	    /*The session variables are set but the form variables have been lost
	    need to restore the form variables from the session */
	    $_POST['WorkCentre']=$_SESSION['PR']->Workcentre;
	    $_POST['WorkAdd1']=$_SESSION['PR']->WorkAdd1;
	    $_POST['WorkAdd2']=$_SESSION['PR']->WorkAdd2;
	    $_POST['WorkAdd3']=$_SESSION['PR']->WorkAdd3;
	    $_POST['WorkAdd4']=$_SESSION['PR']->WorkAdd4;
	    $_POST['WorkAdd5']=$_SESSION['PR']->WorkAdd5;
	    $_POST['WorkAdd6']=$_SESSION['PR']->WorkAdd6;
	    $_POST['InitDate']=$_SESSION['PR']->Orig_InitDate;
	    $_POST['ReqDate']=$_SESSION['PR']->ReqDate;
	    $_POST['StockNo']=$_SESSION['PR']->StockNo;
		$_POST['OrdQty']=$_SESSION['PR']->OrdQty;
		$_POST['ManCosts']=$_SESSION['PR']->ManCosts;
		$_POST['OtherCosts']=$_SESSION['PR']->OtherCosts;
		$_POST['RecdQty']=$_SESSION['PR']->RecdQty;
		$_POST['Initiator']=$_SESSION['PR']->Initiator;
	    $_POST['Requisition']=$_SESSION['PR']->RequisitionNo;
	    $_POST['ExRate']=$_SESSION['PR']->ExRate;
	    $_POST['Special999']=$_SESSION['PR']->Special999;
	    $_POST['Comments']=$_SESSION['PR']->Comments;
	}

	echo '<TABLE BORDER=1>
		<TR>
			<TD><FONT COLOR=BLUE SIZE=4><B>' . _('Manufacturing Facility') . '</B></FONT></TD>
			<TD><FONT COLOR=BLUE SIZE=4><B>' . _('Item Assembly Initiation Details') . '</B></FONT></TD>
		</TR>
		<TR><TD>';
	/*nested table level1 */
	  echo '<TABLE>
	  		<TR>
				<TD>' . _('Work Centre') . ':</TD>
				<TD><SELECT NAME=WorkCentre>';

	  $sql = 'SELECT code, location, description FROM workcentres';
	  $LocnResult = DB_query($sql,$db);

	  while ($LocnRow=DB_fetch_array($LocnResult)){
		 if ($_POST['WorkCentre'] == $LocnRow['code'] OR ($_POST['WorkCentre']=='' AND $LocnRow['code']==$_SESSION['UserStockLocation'])){
			 echo "<OPTION SELECTED Value='" . $LocnRow['code'] . "'>" . $LocnRow['description'];
		 } else {
			 echo "<OPTION Value='" . $LocnRow['code'] . "'>" . $LocnRow['description'];
		 }
	  }
	  echo '</SELECT> 
		<INPUT TYPE=SUBMIT NAME="LookupDeliveryAddress" VALUE="' ._('Lookup Address') . '"></TD>
	  	</TR>';

	 if (!isset($_POST['WorkCentre']) OR $_POST['WorkCentre']==''){ /*If this is the first time the form loaded set up defaults */
	     $_POST['WorkCentre'] = $_SESSION['UserStockLocation'];
	     $sql = "SELECT deladd1, 
	     			deladd2, 
				deladd3, 
				deladd4, 
				deladd5, 
				deladd6
			FROM locations 
			WHERE loccode=(SELECT location from workcentres where code='" . $_POST['WorkCentre'] . "')";
	     $LocnAddrResult = DB_query($sql,$db);
	     if (DB_num_rows($LocnAddrResult)==1){
		  $LocnRow = DB_fetch_row($LocnAddrResult);
		  $_POST['WorkAdd1'] = $LocnRow[0];
		  $_POST['WorkAdd2'] = $LocnRow[1];
		  $_POST['WorkAdd3'] = $LocnRow[2];
		  $_POST['WorkAdd4'] = $LocnRow[3];
		  $_POST['WorkAdd5'] = $LocnRow[4];
		  $_POST['WorkAdd6'] = $LocnRow[5];
		  $_SESSION['PR']->Workcentre= $_POST['WorkCentre'];
		  $_SESSION['PR']->WorkAdd1 = $_POST['WorkAdd1'];
		  $_SESSION['PR']->WorkAdd2 = $_POST['WorkAdd2'];
		  $_SESSION['PR']->WorkAdd3 = $_POST['WorkAdd3'];
		  $_SESSION['PR']->WorkAdd4 = $_POST['WorkAdd4'];
		  $_SESSION['PR']->WorkAdd5 = $_POST['WorkAdd5'];
		  $_SESSION['PR']->WorkAdd6 = $_POST['WorkAdd6'];

	     } else { /*The default location of the user is crook */
		  
	     }
	  } elseif (isset($_POST['LookupDeliveryAddress'])){

	      $sql = "SELECT deladd1, 
	     			deladd2, 
				deladd3, 
				deladd4, 
				deladd5, 
				deladd6
			FROM locations 
			WHERE loccode=(SELECT location from workcentres where code='" . $_POST['WorkCentre'] . "')";

	      $LocnAddrResult = DB_query($sql,$db);
	      if (DB_num_rows($LocnAddrResult)==1){
		  $LocnRow = DB_fetch_row($LocnAddrResult);
		  $_POST['WorkAdd1'] = $LocnRow[0];
		  $_POST['WorkAdd2'] = $LocnRow[1];
		  $_POST['WorkAdd3'] = $LocnRow[2];
		  $_POST['WorkAdd4'] = $LocnRow[3];
		  $_POST['WorkAdd5'] = $LocnRow[4];
		  $_POST['WorkAdd6'] = $LocnRow[5];
		  $_SESSION['PR']->Workcentre= $_POST['WorkCentre'];
		  $_SESSION['PR']->WorkAdd1 = $_POST['WorkAdd1'];
		  $_SESSION['PR']->WorkAdd2 = $_POST['WorkAdd2'];
		  $_SESSION['PR']->WorkAdd3 = $_POST['WorkAdd3'];
		  $_SESSION['PR']->WorkAdd4 = $_POST['WorkAdd4'];
		  $_SESSION['PR']->WorkAdd5 = $_POST['WorkAdd5'];
		  $_SESSION['PR']->WorkAdd6 = $_POST['WorkAdd6'];
	      }
	  }
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 1') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd1 SIZE=41 MAXLENGTH=40 Value='" . $_POST['WorkAdd1'] . "'></TD>
		</TR>";
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 2') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd2 SIZE=41 MAXLENGTH=40 Value='" . $_POST['WorkAdd2'] . "'></TD>
		</TR>";
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 3') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd3 SIZE=41 MAXLENGTH=40 Value='" . $_POST['WorkAdd3'] . "'></TD>
		</TR>";
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 4') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd4 SIZE=41 MAXLENGTH=40 Value='" . $_POST['WorkAdd4'] . "'></TD>
		</TR>";
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 5') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd5 SIZE=21 MAXLENGTH=20 Value='" . $_POST['WorkAdd5'] . "'></TD>
		</TR>";
	  echo '<TR><TD>' . _('Deliver to') . ' - ' . _('Address 6') . ":</TD>
	  		<TD><INPUT TYPE=text NAME=WorkAdd6 SIZE=16 MAXLENGTH=15 Value='" . $_POST['WorkAdd6'] . "'></TD>
		</TR>";
	   echo '</TABLE>'; /* end of sub table */

	  {
	  echo '</TD><TD>'; /*sub table nested */

	  echo '<TABLE><TR><TD>' . _('Initiated Date (d-m-y)') . ':</TD><TD>';
	  if ($_SESSION['ExistingPR']!=0){ 
//		echo ConvertSQLDate($_SESSION['PR']->Orig_InitDate);
		$date1 = $_POST['InitDate'];
		$date2 = date('$date1 dmY');
		echo "<INPUT TYPE=TEXT NAME='InitDate' SIZE=11 MAXLENGTH=10 VALUE=" . $date1 . ">";
	  } else {
	  	/* DefaultDateFormat defined in config.php */
		// echo Date($_SESSION['DefaultDateFormat']);
		 echo "<INPUT TYPE=TEXT NAME='InitDate' SIZE=11 MAXLENGTH=10 VALUE=" . Date($_SESSION['DefaultDateFormat']) . ">";
	  }

	  echo '</TD></TR>';
	  
	  echo '<TR><TD>' . _('Requested Date (d-m-y)') . ':</TD><TD>';
	  if ($_SESSION['ExistingPR']!=0){ 
//		echo ConvertSQLDate($_SESSION['PR']->Orig_InitDate);
		$date1a = $_POST['ReqDate'];
		$date2a = date('$date1a dmY');
		echo "<INPUT TYPE=TEXT NAME='ReqDate' SIZE=11 MAXLENGTH=10 VALUE=" . $date1a . ">";
	  } else {
	  	/* DefaultDateFormat defined in config.php */
		// echo Date($_SESSION['DefaultDateFormat']);
		 echo "<INPUT TYPE=TEXT NAME='ReqDate' SIZE=11 MAXLENGTH=10 VALUE=" . Date($_SESSION['DefaultDateFormat']) . ">";
	  }

	  echo '</TD></TR>';
	  
	  
	  
	  
	  echo '<TR><TD>' . _('Initiated By') . ":</TD>
	  		<TD><INPUT TYPE=TEXT NAME='Initiator' SIZE=11 MAXLENGTH=10 VALUE=" . $_POST['Initiator'] . "></TD>
		</TR>";
	  echo '<TR><TD>' . _('Requistion Ref') . ":</TD><TD><INPUT TYPE=TEXT NAME='Requisition' SIZE=16 MAXLENGTH=15 VALUE=" . $_POST['Requisition'] . '></TD>
	  	</TR>';

  

	//  echo '<TR><TD>' . _('Exchange Rate') . ":</TD>
	 // 		<TD><INPUT TYPE=TEXT NAME='ExRate' SIZE=16 MAXLENGTH=15 VALUE=" . $_POST['ExRate'] . '></TD>
	//	</TR>';
	  echo '<TR><TD>' . _('Date Printed') . ':</TD><TD>';

	  if (isset($_SESSION['PR']->DateProductionRunPrinted) AND strlen($_SESSION['PR']->DateProductionRunPrinted)>6){
	     echo ConvertSQLDate($_SESSION['PR']->DateProductionRunPrinted);
	     $Printed = True;
	  } else {
	     $Printed = False;
	     echo _('Not yet printed');
	  }

	  if ($_SESSION['PR']->AllowPrintPR==0 AND $_POST['RePrint']!=1){
	     echo '<TR><TD>' . _('Allow Reprint') . ":</TD><TD><SELECT NAME='RePrint'><OPTION SELECTED VALUE=0>" . _('No') . "<OPTION VALUE=1>" . _('Yes') . '</SELECT></TD></TR>';
	  } elseif ($Printed) {
	     echo "<TR><TD COLSPAN=2 ALIGN=CENTER><A target='_blank'  HREF='$rootpath/PR_PDFProductionRun.php?" . SID . "PRNo=" . $_SESSION['ExistingPR'] . "'>" . _('Reprint Now') . '</A></TD></TR>';
	  }
	  echo '</TD></TR></TABLE>'; /*end of sub table */
	  }
 	  echo '</TD></TR><TR><TD VALIGN=TOP COLSPAN=2>' . _('Item to Manufacture ');
	  echo'<SELECT NAME=ProdRunItem>';

	  $sql9 = 'SELECT stockid, description, labourcost FROM stockmaster where stockid like "F%" and discontinued=0';
	  $ProdRunItemResult = DB_query($sql9,$db);

	  while ($ProdRunItemRow=DB_fetch_array($ProdRunItemResult)){
		 if ($_POST['StockNo'] == $ProdRunItemRow['stockid'] OR $_POST['ProdRunItem'] == $ProdRunItemRow['stockid'] OR ($_POST['StockNo']=='' AND $ProdRunItemRow['stockid']==$_SESSION['PR']->StockNo)){
			 echo "<OPTION SELECTED Value='" . $ProdRunItemRow['stockid'] . "'>" . $ProdRunItemRow['description'];
		 }  else {
			 echo "<OPTION Value='" . $ProdRunItemRow['stockid'] . "'>" . $ProdRunItemRow['description'];
		 }
	  }
	  echo '</SELECT>';
	//  $_POST['StockNo'] = $_POST['ProdRunItem'];
	//   echo $_GET['ProdRunItem'] . " -- " . $_SESSION['PR']->StockNo . " -- " . $_POST['StockNo'] . " -- " . $_POST['ProdRunItem'] . " -- " . $_SESSION['ProdRunItem'];
//	     echo $_SESSION['PR']->StockNo . " -- " . $_POST['StockNo'];
	    $aa1=$_POST['StockNo'];
	    $aa2=$_GET['ProdRunItem'];
	    $aa3=$_SESSION['PR']->StockNo;
//		$_REQUEST['ProdRunItem']=$_SESSION['PR']->StockNo;
	   $aa4=$_REQUEST['ProdRunItem'];
	   $_SESSION['PR']->StockNo=$aa4;
		
//  prnMsg(_('The bill of material for  part ') . ' - ' . _(' ' . ' 1 ' .  $aa1  . ' 2 ' .  $aa2  . ' 3 ' .  $aa3 . ' 4 ' .  $aa4 ),'info');

	 if ( (isset($_POST['StockNo'])) && (strlen($_POST['StockNo'])>3) )
	 {
	 if ($_SESSION['PR']->ManCosts=='0.0000' || $_SESSION['PR']->ManCosts==''){ 

 			  $mancostsql="SELECT labourcost from stockmaster where stockid='" . $_POST['StockNo'] . "'";
			  	$ErrMsg =  _('The labout costs cannot be retrieved because');
       			$DbgMsg =  _('The SQL statement that was used and failed was');

			  $mancostresult = DB_query($mancostsql,$db,$ErrMsg,$DbgMsg);
			  $mancostrow = DB_fetch_array($mancostresult);
			  $_POST['ManCosts'] = $mancostrow['labourcost'];
			  if ($_POST['ManCosts']=='0.0000' || $_POST['ManCosts']=='' || $_POST['ManCosts']<0.00001)
			  {$_POST['ManCosts'] = '0.0000';}
		
			} 	
			
		} 


		echo 'Qty: <input name="OrdQty" type="text" value="' . $_POST['OrdQty'] .'"> &nbsp;&nbsp;&nbsp;&nbsp; Labour Cost: <input name="ManCosts" type="text" value="' . $_POST['ManCosts'] .'"> &nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE=SUBMIT NAME="LookupBOM" VALUE="' ._('Lookup BOM') . '"> </TD>
	  	</TR>';
		
		
	 if (!isset($_POST['StockNo']) OR $_POST['StockNo']==''){ /*If this is the first time the form loaded set up defaults */
	 		
			$c1=$_POST['StockNo'];
			$c2=$_REQUEST['ProdRunItem'];
			
//  prnMsg(_('The bill of material for  part ') . ' - ' . _(' ' . ' 1 ' .  $c1  . ' 2 ' .  $c2  . ' 3 ' .  $aa3 . ' 4 ' .  $aa4 ),'info');

	//    $aa5=$_POST['StockNo'];
	     
	  //   $_SESSION['ProdRunItem'] = $_REQUEST['ProdRunItem'];
	//	  $_POST['ProdRunItem'] = $_SESSION['ProdRunItem'];
	    
	     $sql7 = "SELECT bom.parent,
			bom.component,
			stockmaster.description,
			stockmaster.decimalplaces,
			stockmaster.materialcost+stockmaster.overheadcost as standardcost,
			bom.quantity,
			bom.quantity * (stockmaster.materialcost+  stockmaster.overheadcost) AS componentcost
		FROM bom INNER JOIN stockmaster ON bom.component = stockmaster.stockid
		WHERE bom.parent = '" . $_REQUEST['ProdRunItem'] . "'
		AND bom.effectiveafter < Now()
		AND bom.effectiveto > Now()";
	$BOMResult = DB_query ($sql7,$db,$ErrMsg);
	$BOMCount = DB_num_rows ($BOMResult);
	$updatespecial = 0;

} else {
		
			$c1=$_POST['StockNo'];
			$c2=$_REQUEST['ProdRunItem'];
			
//  prnMsg(_('The bill of material for  part ') . ' - ' . _(' ' . ' 1 ' .  $c1  . ' 2 ' .  $c2  . ' 3 ' .  $aa3 . ' 4 ' .  $aa4 ),'info');

	//    $aa5=$_POST['StockNo'];
	     
	  //   $_SESSION['ProdRunItem'] = $_REQUEST['ProdRunItem'];
	//	  $_POST['ProdRunItem'] = $_SESSION['ProdRunItem'];
	    
	     $sql7 = "SELECT parent,
			prno,
			itemcode as component,
			itemdescription as description,
			unitcost as componentcost,
			quantityord,
			bomtotal,
			actbomunitcost as actstandardcost,
			bomunitcost as standardcost,
			(quantityrecd * -1) as actquantity,
			qtyperunit as quantity
		FROM productionrundetails
		WHERE prno = '" . $_SESSION['PR']->PRNo . "'";
		$updatespecial = 1;
	$BOMResult = DB_query ($sql7,$db,$ErrMsg);
	$BOMCount = DB_num_rows ($BOMResult);
	
}
	$ErrMsg = _('The bill of material could not be retrieved because');
	$t1 = $_SESSION['PR']->Special999;
	$t2 = $_POST['Special999'];
	 
/*				echo '<TR><TD VALIGN=TOP COLSPAN=2>Manufacturing Costs <input name="ManCosts" type="text" value="' . $_POST['ManCosts'] .'"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input name="OtherCosts" type="text" value="' . $_POST['OtherCosts'] .'"> </TD></TR>';

echo '<TR><TD VALIGN=TOP COLSPAN=2>sql7 ' . $sql7 . '"></TD></TR>';
*/

	if (DB_num_rows($BOMResult)==0){
		prnMsg(_('The bill of material for this part is not set up') . ' - ' . _('there are no components defined for it' ),'warn');
	} else {
//$_POST['StockNo'] = $_GET['ProdRunItem'];
//	     $_SESSION['ProdRunItem'] = $_REQUEST['ProdRunItem'];
//		  $_POST['ProdRunItem'] = $_SESSION['ProdRunItem'];
	    
		echo "<TR><TD VALIGN=TOP COLSPAN=2><TABLE CELLPADDING=2 BORDER=2>";
		$TableHeader = '<TR>
				<TD class=tableheader><input type="hidden" name="rowcountspec" value="' . $BOMCount . '">' . _('Select') . '</TD>
				<TD class=tableheader>' . _('Component') . '</TD>
				<TD class=tableheader>' . _('Description') . '</TD>
				<TD class=tableheader>' . _('Quantity Per Unit') . '</TD>
				<TD class=tableheader>' . _('Projected Unit Cost') . '</TD>
				<TD class=tableheader>' . _('Recorded Unit Cost') . '</TD>
				<TD class=tableheader>' . _('Total Unit Cost') . '</TD>
				<TD class=tableheader>' . _('Projected Quantity') . '</TD>
				<TD class=tableheader>' . _('Actual Quantity') . '</TD>
				<TD class=tableheader>' . _('Projected Run Cost') . '</TD>
				<TD class=tableheader>' . _('Actual Total Run Cost') . '</TD>
				</TR>';

		echo $TableHeader;

		$j = 1;
		$k=0; //row colour counter

		$TotalCost = 0;
		$ActCost = 0;
		$TotalQty = $_POST['OrdQty'];

		while ($myrow=DB_fetch_array($BOMResult)) {

			if ($k==1){
				echo "<tr bgcolor='#CCCCCC'><td><input name='include" . $j ."' type='checkbox' value='true' checked></td>";
				$k=0;
			} else {
				echo "<tr bgcolor='#EEEEEE'><td><input name='include" . $j ."' type='checkbox' value='true' checked></td>";
				$k=1;
			}
			//$hiddenitem = "<input type='hidden' name='bom" . $j. "' "
			$ComponentLink = " " . $myrow['component'] . " ";
			$TotalBOMQty = $TotalQty * $myrow['quantity'];
			$TotalBOMCost = $TotalBOMQty * $myrow['standardcost'];
			$ActBOMCost = 1*$myrow['actquantity'] * $myrow['actstandardcost'];
			
			if ($updatespecial == 1)
			{//$myrow['standardcost']=$myrow['quantity']*$myrow['standardcost']/$TotalQty;
			 $TotalBOMQty = $myrow['quantityord'];
			 $TotalBOMCost = $myrow['bomtotal'];
			$ActBOMCost = $myrow['actquantity'] * $myrow['actstandardcost'];
			
			}
			/* Component Code  Description                 Quantity            Std Cost*                Total Cost */
			printf("<td><input type=\"hidden\" name=\"stockid%s\" value=\"%s\">%s</td>
				<td><input type=\"hidden\" name=\"description%s\" value=\"%s\">%s</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"qtyperunit%s\" value=\"%.4f\">%.4f</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"bomunitcost%s\" value=\"%s\">%.4f</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"unitcost%s\" value=\"%s\">%.4f</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"actunitcost%s\" value=\"%s\">%.4f</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"bomqty%s\" value=\"%s\">%s</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"actqty%s\" value=\"%s\">%s</td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"bomtotal%s\" value=\"%s\">%.4f<input type=\"hidden\" name=\"prlineno%s\" value=\"%s\"></td>
				<td ALIGN=RIGHT><input type=\"hidden\" name=\"acttotal%s\" value=\"%s\">%.4f</td>
				</tr>",
				$j,
				$myrow['component'],
				$ComponentLink,
				$j,
				$myrow['description'],
				$myrow['description'],
				$j,
				$myrow['quantity'],
				$myrow['quantity'],
				$j,
				$myrow['standardcost'],
				$myrow['standardcost'],
				$j,
				$myrow['actstandardcost'],
				$myrow['actstandardcost'],
				$j,
				$myrow['componentcost'],
				$myrow['componentcost'],
				$j,
				$TotalBOMQty,
				$TotalBOMQty,
				$j,
				$myrow['actquantity'],
				$myrow['actquantity'],
				$j,
				$TotalBOMCost,
				$TotalBOMCost,
				$j,
				$j,
				$j,
				$ActBOMCost,
				$ActBOMCost);
			
			$TotalCost += $myrow['componentcost'];
			$TotalPRCost += $TotalBOMCost;
			$ActPRCost += $ActBOMCost;

			$j++;
			If ($j == 12){
				$j=1;
				echo $TableHeader;
			}//end of page full new headings if}//end of while
		}

		echo '<TR>
			<TD COLSPAN=6 ALIGN=RIGHT><B>' . _('Total ') . '</B></TD>
			<TD ALIGN=RIGHT><B>' . number_format($TotalCost,4) . '</B></TD>
			<TD COLSPAN=2></TD>
			<TD ALIGN=RIGHT><B>' .  number_format($TotalPRCost,2) . '</B></TD>
		<TD ALIGN=RIGHT><B>' .  number_format($ActPRCost,2) . '</B></TD>
		</TR>';
		$bbb1 = $_SESSION['PR']->StockNo;
		$_POST['StockNo']=$aa4;
		$bbb2 = $_POST['StockNo'];
	/*	echo '<TR>
			<TD COLSPAN=4 ALIGN=RIGHT><B>' . _('debug') . '</B></TD>
			<TD ALIGN=RIGHT><B>' . $bbb1 . '</B></TD>
			<TD></TD><TD>' .  $bbb2 . '</TD>
		</TR>'; */
		echo '</TABLE>';
		
				
	}

	  
	  
	  
	  
	  
	  
	  
	  
	  
	  echo '</TD></TR><TR><TD VALIGN=TOP COLSPAN=2>' . _('Comments');
	  echo ":<textarea name='Comments' cols=70 rows=2>" . $_POST['Comments'] . '</textarea>';
	  echo '</TD></TR></TABLE>'; /* end of main table */
	  echo "<INPUT TYPE=SUBMIT NAME='Commit' VALUE='" . _('Setup Item Assembly') . "'>";
	  echo "<INPUT TYPE=SUBMIT NAME='CancelPR' VALUE='" . _("Cancel and Delete The Whole Item Assembly") . "'>";

//} /*end of if supplier selected */

echo '</form>';
include('includes/footer.inc');
?>