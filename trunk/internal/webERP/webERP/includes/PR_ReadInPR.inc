<?php
/* $Revision: 1.12 $ */
/*PR_ReadInProduction.inc is used by the modify existing PR code in PR_Header.php and also by xxx.php */

       if (isset($_SESSION['PR'])){
              unset ($_SESSION['PR']->LineItems);
              unset ($_SESSION['PR']);
       }

       Session_register('PR');
       Session_register('RequireSupplierSelection');
       Session_register('ExistingPR');


       $_SESSION['ExistingPR']=$_GET['ModifyPRNumber'];
       $_SESSION['RequireSupplierSelection'] = 0;
       $_SESSION['PR'] = new ProductionRun;

       $_SESSION['PR']->GLLink = $_SESSION['CompanyRecord']['gllink_stock'];

/*read in all the guff from the selected PR into the PR Production Run Class variable  */

       $OrderHeaderSQL = 'SELECT productionruns.comments, 
				productionruns.initdate, 
				productionruns.reqdate, 
				productionruns.dateprinted, 
				productionruns.workadd1, 
				productionruns.workadd2, 
				productionruns.workadd3, 
				productionruns.workadd4, 
				productionruns.workadd5, 
				productionruns.workadd6, 
				productionruns.allowprint, 
				productionruns.requisitionno, 
				productionruns.workcentre, 
				workcentres.code,
				workcentres.description,
				productionruns.initiator,  
				productionruns.stockno,  
				productionruns.prodrunqty,  
				productionruns.mancosts,  
				productionruns.othercosts,  
				productionruns.prodrunqtyrecd,
				productionruns.bomunitcost, 
				productionruns.prref
			FROM productionruns
				LEFT JOIN workcentres ON productionruns.workcentre=workcentres.code
			WHERE productionruns.prno = ' . $_GET['ModifyPRNumber'];
	   $ErrMsg =  _('The production run cannot be retrieved because');
       $DbgMsg =  _('The SQL statement that was used and failed was');
       $GetPRHdrResult = DB_query($OrderHeaderSQL,$db,$ErrMsg,$DbgMsg);
$_SESSION['Test']=DB_num_rows($GetPRHdrResult)==1;
    	
	if (DB_num_rows($GetPRHdrResult)==1) {

              $myrow = DB_fetch_array($GetPRHdrResult);
			  
			  
              $_SESSION['PR']->PRNo = $_GET['ModifyPRNumber'];
              $_SESSION['PR']->Orig_InitDate = ConvertSQLDate($myrow['initdate']);
              $_SESSION['PR']->ReqDate = ConvertSQLDate($myrow['reqdate']);
              $_SESSION['PR']->AllowPrintPO = $myrow['allowprint'];
              $_SESSION['PR']->DateProductionRunPrinted = ConvertSQLDate($myrow['dateprinted']);
              $_SESSION['PR']->Comments = $myrow['comments'];
              $_SESSION['PR']->Workcentre = $myrow['workcentre'];
              $_SESSION['PR']->SupplierID = $myrow['code'];
              $_SESSION['PR']->SupplierName = $myrow['description'];
              $_SESSION['PR']->Initiator = $myrow['initiator'];
              $_SESSION['PR']->RequisitionNo = $myrow['requisitionno'];
              $_SESSION['PR']->WorkAdd1 = $myrow['workadd1'];
              $_SESSION['PR']->WorkAdd2 = $myrow['workadd2'];
              $_SESSION['PR']->WorkAdd3 = $myrow['workadd3'];
              $_SESSION['PR']->WorkAdd4 = $myrow['workadd4'];
              $_SESSION['PR']->WorkAdd5 = $myrow['workadd5'];
              $_SESSION['PR']->WorkAdd6 = $myrow['workadd6'];
              $_SESSION['PR']->StockNo = $myrow['stockno'];
              $_SESSION['PR']->OrdQty = $myrow['prodrunqty'];
              $_SESSION['PR']->ManCosts = $myrow['mancosts'];
              $_SESSION['PR']->OtherCosts = $myrow['othercosts'];
              $_SESSION['PR']->RecdQty = $myrow['prodrunqtyrecd'];
			  $_SESSION['PR']->BomUnitCost = $myrow['bomunitcost'];
			$_SESSION['PR']->PRRef = $myrow['prref'];

/*now populate the line PO array with the production run details records */




              $LineItemsSQL = 'SELECT prdetailitem, itemcode,
				stockmaster.description,
				processdate,
				itemdescription,
				glcode,
				accountname,
				qtyprocessed,
				unitcost,
				bomunitcost,
				units,
				quantityord,
				quantityrecd,
				prref,
				jobref,
				stdcostunit,
				stockmaster.controlled,
				stockmaster.serialised,
				stockmaster.decimalplaces
				FROM productionrundetails LEFT JOIN stockmaster
					ON productionrundetails.itemcode=stockmaster.stockid
					LEFT JOIN chartmaster
					ON productionrundetails.glcode=chartmaster.accountcode
				WHERE productionrundetails.completed=0
					AND productionrundetails.prno =' . $_GET['ModifyPRNumber'] . "
				ORDER BY prdetailitem";

	      $ErrMsg =  _('The lines on the production run cannot be retrieved because');
	      $DbgMsg =  _('The SQL statement that was used to retrieve the production run lines was');
              $LineItemsResult = db_query($LineItemsSQL,$db,$ErrMsg,$DbgMsg);

	      if (db_num_rows($LineItemsResult) > 0) {

                while ($myrow=db_fetch_array($LineItemsResult)) {

					 if (is_null($myrow['glcode'])){
						$GLCode = '';
					 } else {
						$GLCode = $myrow['glcode'];
					 }
					 if (is_null($myrow['units'])){
						$Units = _('each');
					 } else {
						$Units = $myrow['units'];
					 }
					 if (is_null($myrow['itemcode'])){
						$StockID = '';
					 } else {
						$StockID = $myrow['itemcode'];
					 }

					$_SESSION['PR']->add_to_order($_SESSION['PR']->LinesOnPR+1,
							$StockID,
							$myrow['controlled'],
							$myrow['serialised'],
							$myrow['quantityord'],
							stripslashes($myrow['itemdescription']),
							$myrow['unitcost'],
							$myrow['bomunitcost'],
							$Units,
							$GLCode,
							ConvertSQLDate($myrow['processdate']),
							$myrow['prref'],
							$myrow['jobref'],
							$myrow['qtyprocessed'],
							$myrow['quantityrecd'],
							$myrow['accountname'],
							$myrow['decimalplaces']);

				    $_SESSION['PR']->LineItems[$_SESSION['PR']->LinesOnPR]->PRDetailRec = $myrow['prdetailitem'];
	                $_SESSION['PR']->LineItems[$_SESSION['PR']->LinesOnPR]->StandardCost = $myrow['stdcostunit'];  /*Needed for receiving goods and GL interface */
             } /* line PO from production run details */
      } //end is there were lines on the order
   } // end if there was a header for the order
?>