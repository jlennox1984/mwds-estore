<?php

/* $Revision: 1.00 $ */

/* Weighted Cost Functions */


Function getInvTotal ($StockID, &$db){

/* Functions related to calculating Weighted Cost instead of a fixed standard cost

*/

/*Gets the GL Codes relevant to the stock item account from the stock category record */
	$QuerySQL = "SELECT SUM(locstock.quantity) FROM locstock, locations WHERE locstock.loccode = locations.loccode AND locstock.stockid = '" . $StockID . "'";

	$ErrMsg =  _('The inventory total could not be retreived because');
	$GetStkResult = DB_query($QuerySQL, $db, $ErrMsg);

	$InvTotal = DB_fetch_array($GetStkResult);
	return $InvTotal;
}

Function getWeightedCost($InvTotal,$StandardCost,$InvQty,$PriceVar,$db)

{

$NewInvTotal=$InvTotal+$InvQty;
$InvPrice=$StandardCost+$PriceVar;
$WeightedCost=($InvTotal*$StandardCost+($InvQty*$InvPrice))/$NewInvTotal);
 return $WeightedCost;

}
?>