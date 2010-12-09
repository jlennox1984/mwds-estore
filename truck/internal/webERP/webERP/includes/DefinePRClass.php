<?php
/* $Revision: 1.11 $ */
/* Definition of the ProductionRun class to hold all the information for a production run and delivery
*/

Class ProductionRun {

	var $LineItems; /*array of objects of class LineDetails using the product id as the pointer */
	var $Initiator;
	var $RequisitionNo;
	var $WorkAdd1;
	var $WorkAdd2;
	var $WorkAdd3;
	var $WorkAdd4;
	var $WorkAdd5;
	var $WorkAdd6;
	var $Comments;
	var $WorkCentre;
	Var $Managed;
	var $Orig_InitDate;
	var $StockNo;
	var $QtyOrdered;
	var $OrdQty;
	var $RecdQty;
	var $ManCosts;
	var $OtherCosts;
	var $StockNo;
	var $PRNo;
	var $PRRef;
	var $BomUnitCost;
	var $QtyProduced;
	var $PRNo; /*Only used for modification of existing orders otherwise only established when order committed */
	var $LinesOnPR;
	var $PrintedProductionRun;
	var $Special999;
	var $DateProductionRunPrinted;
	var $total;
	var $GLLink; /*Is the GL link to stock activated only checked when order initiated or reading in for modification */

	function ProductionRun(){
	/*Constructor function initialises a new production run object */
		$this->LineItems = array();
		$this->total=0;
		$this->LinesOnPR=0;
	}

	function add_to_order($LineNo,
				$StockID,
				$Serialised,
				$Controlled,
				$Qty,
				$ItemDescr,
				$UnitCost,
				$BomUnitCost,
				$UOM,
				$GLCode,
				$ReqDate,
				$PRRef,
				$JobRef,
				$QtyInv=0,
				$QtyRecd=0,
				$GLActName='',
				$DecimalPlaces=2){

		if ($Qty!=0 && isset($Qty)){

			$this->LineItems[$LineNo] = new LineDetails($LineNo,
								$StockID,
								$Serialised,
								$Controlled,
								$Qty,
								$ItemDescr,
								$UnitCost,
								$BomUnitCost,
								$UOM,
								$GLCode,
								$ReqDate,
								$PRRef,
								$JobRef,
								$QtyInv,
								$QtyRecd,
								$GLActName,
								$DecimalPlaces);
			$this->LinesOnPR++;
			Return 1;
		}
		Return 0;
	}

	function update_order_item($LineNo,
				$Qty,
				$UnitCost,
				$BomUnitCost,
				$ItemDescription,
				$GLCode,
				$GLAccountName,
				$ReqDate,
				$PRRef,
				$JobRef ){

			$this->LineItems[$LineNo]->ItemDescription = $ItemDescription;
			$this->LineItems[$LineNo]->Quantity = $Qty;
			$this->LineItems[$LineNo]->UnitCost = $UnitCost;
			$this->LineItems[$LineNo]->BomUnitCost = $BomUnitCost;
			$this->LineItems[$LineNo]->GLCode = $GLCode;
			$this->LineItems[$LineNo]->GLAccountName = $GLAccountName;
			$this->LineItems[$LineNo]->ReqDate = $ReqDate;
			$this->LineItems[$LineNo]->PRRef = $PRRef;
			$this->LineItems[$LineNo]->JobRef = $JobRef;
	//		$this->LineItems[$LineNo]->Price = $UnitCost;
	}

	function remove_from_order(&$LineNo){
		 $this->LineItems[$LineNo]->Deleted = True;
	}


	function Any_Already_Received(){
		/* Checks if there have been deliveries or invoiced entered against any of the line items */
		if (count($this->LineItems)>0){
		   foreach ($this->LineItems as $OrderedItems) {
			if ($OrderedItems->QtyReceived !=0 || $OrderedItems->QtyInvoiced !=0){
				return 1;
			}
		   }
		}
		return 0;
	}

	function Some_Already_Received($LineNo){
		/* Checks if there have been deliveries or amounts invoiced against a specific line item */
		if (count($this->LineItems)>0){
		   if ($this->LineItems[$LineNo]->QtyReceived !=0 || $this->LineItems[$LineNo]->QtyInvoiced !=0){
			return 1;
		   }
		}
		return 0;
	}
} /* end of class defintion */

Class LineDetails {
/* PurchOrderDetails */
	Var $LineNo;
	Var $PRDetailRec;
	Var $StockID;
	Var $ItemDescription;
	Var $DecimalPlaces;
	Var $GLCode;
	Var $GLActName;
	Var $Quantity;
	Var $UnitCost;
	Var $BomUnitCost;
	Var $Units;
	Var $ReqDate;
	Var $QtyInv;
	Var $QtyReceived;
	Var $StandardCost;
	var $PRRef;
	Var $JobRef;
	Var $ReceiveQty;
	Var $Deleted;

	Var $Controlled;
	Var $Serialised;

	Var $SerialItems;  /*An array holding the batch/serial numbers and quantities in each batch*/

	function LineDetails ($LineNo, $StockItem, $Controlled, $Serialised, $Qty, $ItemDescr,  $UCost, $BomCost, $UOM, $GLCode, $ReqDate, $PRRef =0, $JobRef, $QtyInv, $QtyRecd, $GLActName, $DecimalPlaces){

	/* Constructor function to add a new LineDetail object with passed params */
		$this->LineNo = $LineNo;
		$this->StockID =$StockItem;
		$this->Controlled = $Controlled;
		$this->Serialised = $Serialised;
		$this->StkModClass = $StkModClass;
		$this->DecimalPlaces=$DecimalPlaces;
		$this->ItemDescription = $ItemDescr;
		$this->Quantity = $Qty;
		$this->ReqDate = $ReqDate;
		$this->UnitCost = $UCost;
		$this->BomUnitCost = $BomCost;
		$this->Units = $UOM;
		$this->QtyReceived = $QtyRecd;
		$this->QtyInv = $QtyInv;
		$this->GLCode = $GLCode;
		$this->JobRef = $JobRef;
		$this->PRRef = $PRRef;
		$this->Completed = $Completed;
		$this->GLActName = $GLActName;
		$this->ReceiveQty =0;	/*initialise these last two only */
		$this->StandardCost =0;
		$this->Deleted=False;
		$this->SerialItems = array(); /*if Controlled then need to populate this later */
		$this->SerialItemsValid=false;
	}
}

?>
