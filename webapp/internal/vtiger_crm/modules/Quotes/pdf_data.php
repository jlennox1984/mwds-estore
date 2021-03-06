<?php
/*
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *   (c) 2005 Matthew Brichacek <mmbrich@fosslabs.com>
 *
 *
 *   Additions/Changes
 *
 *   (c) 2005 OpenCRM
 *    - Total and Tax labels taken from language files
 */

require_once('modules/Quotes/Quote.php');

$focus = new Quote();
$focus->retrieve_entity_info($_REQUEST['record'],"Quotes");
$account_name = getAccountName($focus->column_fields[account_id]);
$account_id = $focus->column_fields[account_id];
$quote_id=$_REQUEST['record'];
$contact_name = getContactName($focus->column_fields["contact_id"]);
$subject = $focus->column_fields["subject"];

// Quote Information
$valid_till = $focus->column_fields["validtill"];
$bill_street = $focus->column_fields["bill_street"];
$bill_street2 = $focus->column_fields["bill_street2"];
$bill_city = $focus->column_fields["bill_city"];
$bill_state = $focus->column_fields["bill_state"];
$bill_code = $focus->column_fields["bill_code"];
$bill_country = $focus->column_fields["bill_country"];

$ship_street = $focus->column_fields["ship_street"];
$ship_street2 = $focus->column_fields["ship_street2"];
$ship_city = $focus->column_fields["ship_city"];
$ship_state = $focus->column_fields["ship_state"];
$ship_code = $focus->column_fields["ship_code"];
$ship_country = $focus->column_fields["ship_country"];

$conditions = $focus->column_fields["terms_conditions"];
$description = $focus->column_fields["description"];
$quote_status = $focus->column_fields["quotestage"];


// Company information
$add_query = "select * from organizationdetails";
$result = $adb->query($add_query);
$num_rows = $adb->num_rows($result);

if($num_rows == 1)
{
                $org_name = $adb->query_result($result,0,"organizationame");
                $org_address = $adb->query_result($result,0,"address");
                $org_city = $adb->query_result($result,0,"city");
                $org_state = $adb->query_result($result,0,"state");
                $org_country = $adb->query_result($result,0,"country");
                $org_code = $adb->query_result($result,0,"code");
                $org_phone = $adb->query_result($result,0,"phone");
                $org_fax = $adb->query_result($result,0,"fax");
                $org_website = $adb->query_result($result,0,"website");

                $logo_name = $adb->query_result($result,0,"logoname");
}

//getting the Total Array
$price_subtotal = $currency_symbol.number_format($focus->column_fields["hdnSubTotal"],2,'.',',');
$price_discount = $currency_symbol.number_format($focus->column_fields["hdnDiscountTotal"],2,'.',',');
$price_tax = $currency_symbol.number_format($focus->column_fields["txtTax"],2,'.',',');
//$price_adjustment = $currency_symbol.number_format($focus->column_fields["txtAdjustment"],2,'.',',');
$price_adjustment = $currency_symbol.number_format($focus->column_fields["freightcost"],2,'.',',');
$price_freighttax = $currency_symbol.number_format($focus->column_fields["freighttax"],2,'.',',');
$price_total = $currency_symbol.number_format($focus->column_fields["hdnGrandTotal"],2,'.',',');

//getting the Product Data
$query="select stockmaster.description,stockmaster.stockid,stockmaster.unit_price,stockmaster.longdescription,quotesproductrel.* from quotesproductrel inner join stockmaster on stockmaster.productid=quotesproductrel.productid where quoteid=".$quote_id;

global $result;
$result = $adb->query($query);
$num_products=$adb->num_rows($result);
for($i=0;$i<$num_products;$i++) {
                $product_name[$i]=$adb->query_result($result,$i,'description');
                $prod_description[$i]=$adb->query_result($result,$i,'longdescription');
                $stock_id[$i]=$adb->query_result($result,$i,'stockid');
                $product_id[$i]=$adb->query_result($result,$i,'productid');
                $qty[$i]=$adb->query_result($result,$i,'quantity');
		$disc[$i]=$adb->query_result($result,$i,'discount');
	
                $unit_price[$i]= $currency_symbol.number_format($adb->query_result($result,$i,'unit_price'),2,'.',',');
                $list_price[$i]= $currency_symbol.number_format($adb->query_result($result,$i,'listprice'),2,'.',',');
                $list_pricet[$i]= $adb->query_result($result,$i,'listprice');
                $prod_total[$i]= $qty[$i]*$list_pricet[$i]-($qty[$i]*$list_pricet[$i]*$disc[$i]);
			 $discountpercent= $disc[$i]*100;
				  $discountpercent .="%";


                $product_line[] = array( "Product Name"    => $stock_id[$i],                                "Description"  => $product_name[$i],
                                "Qty"     => $qty[$i],
                                "List Price"      => $list_price[$i],
                                "Discount %" => $discountpercent,
                                "Total" => $currency_symbol.number_format($prod_total[$i],2,'.',','));
}



		$temp1 = "Freight";
		$temp2 = "Disc. Total";
        $total[]=array("Discount %" => $temp2,
                "Total" => $price_discount);

        $total[]=array("Discount %" => $app_strings['LBL_SUB_TOTAL'],
                "Total" => $price_subtotal);

        $total[]=array("Discount %" => $app_strings['LBL_TAX'],
                "Total" => $price_tax);

        $total[]=array("Discount %" => $temp1,
                "Total" => $price_adjustment);

        $total[]=array("Discount %" => $app_strings['LBL_FREIGHTTAX'],
                "Total" => $price_freighttax);

        $total[]=array("Discount %" => $app_strings['LBL_GRAND_TOTAL'],
                "Total" => $price_total);

?>
