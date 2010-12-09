<?php
/* $Revision: 1.5 $ */
/* Definition of the Shipment class to hold all the information for production run costing*/

Class ProductionRunCosting {

	Var $PRRef; /*unqique identifier for the shipment */

	var $LineItems; /*array of objects of class LineDetails using the product id as the pointer */
	var $SupplierID;
	var $OtherRef;
	var $Other;
	var $ETA;
	var $WorkCentre;
	var $Closed;

	function ProductionRunCosting(){
	/*Constructor function initialises a new ProductionRunCosting object */
		$this->LineItems = array();
		$this->AccumValue =0;
		$this->Closed =0;
	}

	function add_to_shipment($PRDetailItem,
					$PRNo,
					$StockID,
					$ItemDescr,
					$QtyInvoiced,
					$UnitPrice,
					$UOM,
					$DelDate,
					$QuantityOrd,
					$QuantityRecd,
					$WorkCentre,
					$StdCostUnit,
					&$db){

		$this->LineItems[$PRDetailItem]= new LineDetails($PRDetailItem,$PRNo,$StockID,$ItemDescr, $QtyInvoiced, $UnitPrice, $UOM, $DelDate, $QuantityOrd, $QuantityRecd, $WorkCentre, $StdCostUnit);

		$sql = "UPDATE productionrundetails SET prref = " . $this->PRRef . " 
			WHERE prno = " . $PRDetailItem;
		$ErrMsg = _('There was an error updating the purchase order detail record to make it part of shipment') . ' ' . $PRRef . ' ' . _('the error reported was');
		$result = DB_query($sql, $db, $ErrMsg);
prnMsg(_('Here is the update query ') . $sql,'warn');
		
		$sql1 = "UPDATE productionruns SET prref = " . $this->PRRef . " 
			WHERE prno = " . $PRDetailItem;
		$ErrMsg = _('There was an error updating the purchase order master record to make it part of shipment') . ' ' . $PRRef . ' ' . _('the error reported was');
		$result1 = DB_query($sql1, $db, $ErrMsg);
prnMsg(_('Here is the update query ') . $sql1,'warn');
		Return 1;
	}


	function remove_from_shipment($PRDetailItem,&$db){

		if ($this->LineItems[$PRDetailItem]->QtyInvoiced==0){

			unset($this->LineItems[$PRDetailItem]);
			$sql = "UPDATE productionrundetails SET prref = 0 WHERE prdetailitem=" . $PRDetailItem;
			$Result = DB_query($sql,$db);
		$sql1 = "UPDATE productionruns SET prref = 0 WHERE prno=" . $PRDetailItem;
			$Result1 = DB_query($sql1,$db);
		} else {
			prnMsg(_('This shipment line has a quantity invoiced and already charged to the shipment - it cannot now be removed'),'warn');
		}
	}

} /* end of class defintion */

Class LineDetails {

	Var $PRDetailItem;
	Var $PRNo;
	Var $StockID;
	Var $ItemDescription;
	Var $QtyInvoiced;
	Var $UnitPrice;
	Var $UOM;
	Var $DelDate;
	Var $QuantityOrd;
	Var $QuantityRecd;
	Var $WorkCentre;
	Var $StdCostUnit;


	function LineDetails ($PRDetailItem, $PRNo, $StockID, $ItemDescr, $QtyInvoiced, $UnitPrice, $UOM, $DelDate, $QuantityOrd, $QuantityRecd, $StdCostUnit, $WorkCentre){

	/* Constructor function to add a new LineDetail object with passed params */
		$this->PRDetailItem = $PRDetailItem;
		$this->PRNo = $PRNo;
		$this->StockID =$StockID;
		$this->ItemDescription = $ItemDescr;
		$this->QtyInvoiced = $QtyInvoiced;
		$this->DelDate = $DelDate;
		$this->UnitPrice = $UnitPrice;
		$this->UOM = $UOM;
		$this->QuantityRecd = $QuantityRecd;
		$this->QuantityOrd = $QuantityOrd;
		$this->StdCostUnit = $StdCostUnit;
		$this->WorkCentre = $WorkCentre;
	}
}

?>
