<?php

/* $Revision: 1.17 $ */


$PageSecurity = 8;
include ('includes/session.inc');
$title = _('General Ledger Account Inquiry');
include('includes/header.inc');
include('includes/GLPostings.inc');

if (isset($_POST['Account'])){
	$SelectedAccount = $_POST['Account'];
} elseif (isset($_GET['Account'])){
	$SelectedAccount = $_GET['Account'];
}

if (isset($_POST['Period'])){
	$SelectedPeriod = $_POST['Period'];
} elseif (isset($_GET['Period'])){
	$SelectedPeriod = $_GET['Period'];
}

echo "<FORM METHOD='POST' ACTION=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

/*Dates in SQL format for the last day of last month*/
$DefaultPeriodDate = Date ('Y-m-d', Mktime(0,0,0,Date('m'),0,Date('Y')));

/*Show a form to allow input of criteria for TB to show */
echo '<CENTER><TABLE>
        <TR>
         <TD>'._('Account').":</TD>
         <TD><SELECT Name='Account'>";
         $sql = 'SELECT accountcode, accountname FROM chartmaster ORDER BY accountcode';
         $Account = DB_query($sql,$db);
         while ($myrow=DB_fetch_array($Account,$db)){
            if($myrow['accountcode'] == $SelectedAccount){
   	        echo '<OPTION SELECTED VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountcode'] . ' ' . $myrow['accountname'];
	    } else {
		echo '<OPTION VALUE=' . $myrow['accountcode'] . '>' . $myrow['accountcode'] . ' ' . $myrow['accountname'];
	    }
         }
         echo '</SELECT></TD></TR>
         <TR>
         <TD>'._('For Period range').':</TD>
         <TD><SELECT Name=Period[] multiple>';
	 $sql = 'SELECT periodno, lastdate_in_period FROM periods';
	 $Periods = DB_query($sql,$db);
         $id=0;
         while ($myrow=DB_fetch_array($Periods,$db)){

            if($myrow['periodno'] == $SelectedPeriod[$id]){
              echo '<OPTION SELECTED VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            $id++;
            } else {
              echo '<OPTION VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            }

         }
         echo "</SELECT></TD>
        </TR>
</TABLE><P>
<INPUT TYPE=SUBMIT NAME='Show' VALUE='"._('Show Account Transactions')."'><input NAME='BudgetSetup' type='submit' value='Setup Budget'></CENTER>";

	

/* End of the Form  rest of script is what happens if the show button is hit*/

if (isset($_POST['BudgetSetup'])){
	
	
	/*  Need to insert some new periods */

		$GetPrdSQL = 'SELECT MAX(lastdate_in_period), MAX(periodno) FROM periods';
		$GetPrdResult = DB_query($GetPrdSQL,$db);
		$myrow = DB_fetch_row($GetPrdResult);

		$Date_array = explode('-', $myrow[0]);

		$LastPeriodEnd = mktime(0,0,0,$Date_array[1]+1,0,$Date_array[0]);
		$LastPeriodNo = $myrow[1];

		$today  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
		$limit  = mktime(0, 0, 0, date("m")  , date("d")+530, date("Y"));
	if ($LastPeriodEnd > $limit)
	{prnMsg(_('Budget Setup cancelled, already more than two years projected. ') . ' ' ,'');
	exit;}
	
		
	for($i=1; $i<=12; $i++)
	{
/* The date of the last period added is less than the transaction date */

				$MonthOfLastPeriod = Date('m', $LastPeriodEnd);
				If ($MonthOfLastPeriod ==12) {
					$LastPeriodEnd =  Mktime(0,0,0,2,0,Date('Y',$LastPeriodEnd)+1);
				} else {
					$LastPeriodEnd = Mktime(0,0,0,($MonthOfLastPeriod +2),0,Date('Y',$LastPeriodEnd));
				}

				$LastPeriodNo = $LastPeriodNo + 1;

				$GetPrdSQL = 'INSERT INTO periods (periodno, lastdate_in_period) VALUES (' . $LastPeriodNo . ", '" . Date('Y/m/d', $LastPeriodEnd) . "')";
				$ErrMsg = _('An error occurred in adding a new period number');
				$GetPrdResult = DB_query($GetPrdSQL, $db, $ErrMsg);

				$sql = 'INSERT INTO chartdetails (accountcode, period)
						SELECT chartmaster.accountcode, periods.periodno
							FROM chartmaster
								CROSS  JOIN periods
						WHERE ( chartmaster.accountcode, periods.periodno ) NOT 
							IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';
							
				$InsNewChartDetails = DB_query($sql,$db,'','','',false); /*dont trap errors - chart details records created only as required - duplicate messages ignored */

			}
			
	
	
	
	
	
	
	
	
	prnMsg(_('Budget Setup ') . ' ' ,'success');
	$_POST['Show'] = TRUE;
	
	
if (isset($_POST['Show'])){

	if (!isset($SelectedPeriod)){
		prnMsg(_('A period or range of periods must be selected from the list box'),'info');
		include('includes/footer.inc');
		exit;
	}
	}
	
}
	





if (isset($_POST['Show'])){

	if (!isset($SelectedPeriod)){
		prnMsg(_('A period or range of periods must be selected from the list box'),'info');
		include('includes/footer.inc');
		exit;
	}
	/*Is the account a balance sheet or a profit and loss account */
	$result = DB_query("SELECT pandl
				FROM accountgroups
				INNER JOIN chartmaster ON accountgroups.groupname=chartmaster.group_
				WHERE chartmaster.accountcode=$SelectedAccount",$db);
	$PandLRow = DB_fetch_row($result);
	if ($PandLRow[0]==1){
		$PandLAccount = True;
	}else{
		$PandLAccount = False; /*its a balance sheet account */
	}

	$FirstPeriodSelected = min($SelectedPeriod);
	$LastPeriodSelected = max($SelectedPeriod);

 	$sql="SELECT *, chartmaster.accountname,
	(chartdetails.period -12) AS test,
							(
							SELECT actual FROM chartdetails ly
							WHERE ly.accountcode = $SelectedAccount
							AND ly.period = test
							) as lyactual 
			 from chartdetails
			INNER JOIN chartmaster on chartmaster.accountcode = chartdetails.accountcode 
			WHERE chartdetails.accountcode = $SelectedAccount
			AND period>=$FirstPeriodSelected
		AND period<=$LastPeriodSelected
		ORDER BY period";
	$ErrMsg = _('The transactions for account') . ' ' . $SelectedAccount . ' ' . _('could not be retrieved because') ;
	$TransResult = DB_query($sql,$db,$ErrMsg);
$TransCount = DB_num_rows ($TransResult);
				echo '<p>row count ' . $TransCount . '<input type="hidden" name="rowcountspec" value="' . $TransCount . '"></p>';


if ($PandLAccount==True) {
		$RunningTotal = 0;
		$RunningBTotal = 0;
		$test5 = 0;
		$culmBudgetVar = 0;
		$PeriodBudget = 0;
	} else {
	       // added to fix bug with Brought Forward Balance always being zero
					$sql = "SELECT *,
	(chartdetails.period -12) AS test,
							(
							SELECT actual FROM chartdetails ly
							WHERE ly.accountcode = $SelectedAccount
							AND ly.period = test
							) as lyactual 
					FROM chartdetails 
					WHERE chartdetails.accountcode= $SelectedAccount 
					AND chartdetails.period=" . $FirstPeriodSelected; 
					
				$ErrMsg = _('The chart details for account') . ' ' . $SelectedAccount . ' ' . _('could not be retrieved');
				$ChartDetailsResult = DB_query($sql,$db,$ErrMsg);
				$ChartDetailRow = DB_fetch_array($ChartDetailsResult);
				$ChartDetailCount = DB_num_rows ($ChartDetailsResult);
				
				// --------------------
				
		$RunningTotal =$ChartDetailRow['bfwd'];
		$test1=$ChartDetailRow['actual'];
		$test2=$ChartDetailRow['budget'];
		$test3=$ChartDetailRow['lyactual'];
		$test4=$ChartDetailRow['periodno'];
		
		if ($RunningTotal < 0 ){ //its a credit balance b/fwd
			echo "<table><TR bgcolor='#FDFEEF'>
				<TD COLSPAN=11><B>" . _('Brought Forward Balance') . '</B><TD>
				</TD></TD>
				<TD ALIGN=RIGHT><B>' . number_format(-$RunningTotal,2) . '</B></TD>
				<TD></TD>
				</TR>';
		} else { //its a debit balance b/fwd
			echo "<table><TR bgcolor='#FDFEEF'>
				<TD COLSPAN=11><B>" . _('Brought Forward Balance') . '</B></TD>
				<TD ALIGN=RIGHT><B>' . number_format($RunningTotal,2) . '</B></TD>
				<TD COLSPAN=2></TD>
				</TR>';
		}
		
		$RunningBTotal =$ChartDetailRow['bfwdbudget'];
		if ($RunningBTotal < 0 ){ //its a credit balance b/fwd
			echo "<TR bgcolor='#FDFEEF'>
				<TD COLSPAN=11><B>" . _('Brought Forward Budget Balance') . '</B><TD>
				</TD></TD>
				<TD ALIGN=RIGHT><B>' . number_format(-$RunningBTotal,2) . '</B></TD>
				<TD></TD>
				</TR>';
		} else { //its a debit balance b/fwd
			echo "<TR bgcolor='#FDFEEF'>
				<TD COLSPAN=11><B>" . _('Brought Forward Budget Balance') . '</B></TD>
				<TD ALIGN=RIGHT><B>' . number_format($RunningBTotal,2) . '</B></TD>
				<TD COLSPAN=2></TD>
				</TR></table>';
		}
	}

			
	echo '<table>';

	$TableHeader = "<tr><td colspan='7' class='tableheader'> </td><td class='tableheader' align='center' colspan='8'>" . _('Revised Budget Figures') . "</TD><td colspan='3' class='tableheader'> </td></tr>
			<TR>
			<TD class='tableheader'>" . _('Month') . "</TD>
			<TD class='tableheader'>" . _('Actual') . "</TD>
			<TD class='tableheader'>" . _('Last Fiscal Yr') . "</TD>
			<TD class='tableheader'>" . _('Variance Last Fiscal Yr to Actual') . "</TD>
			<TD class='tableheader'>" . _('Budget') . "</TD>
			<TD class='tableheader'>" . _('Variance Budget to Actual') . "</TD>
			<TD class='tableheader'>" . _('Culmulative Budget Variance') . "</TD>
			<TD class='tableheader'>" . _('Q1') . "</TD>
			<TD class='tableheader'>" . _('To Actual') . "</TD>
			<TD class='tableheader'>" . _('Q2') . "</TD>
			<TD class='tableheader'>" . _('To Actual') . "</TD>
			<TD class='tableheader'>" . _('Q3') . "</TD>
			<TD class='tableheader'>" . _('To Actual') . "</TD>
			<TD class='tableheader'>" . _('Q4') . "</TD>
			<TD class='tableheader'>" . _('To Actual') . "</TD>
			<TD class='tableheader'>" . _('Period Actual') . "</TD>
			<TD class='tableheader'>" . _('Period Budget') . "</TD>
			<TD class='tableheader'>" . _('Period Last Fiscal Yr') . '</TD>
			</TR>';

	echo $TableHeader;

	
	$PeriodTotal = 0;
	$PeriodNo = -9999;
	$ShowIntegrityReport = False;
	$j = 1;
	$k=0; //row colour counter

	while ($myrow=DB_fetch_array($TransResult)) {

		if ($myrow['periodno']!=$PeriodNo){
			if ($PeriodNo!=-9999){ //ie its not the first time around
				/*Get the ChartDetails balance b/fwd and the actual movement in the account for the period as recorded in the chart details - need to ensure integrity of transactions to the chart detail movements. Also, for a balance sheet account it is the balance carried forward that is important, not just the transactions*/

				$sql = "SELECT * , periods.lastdate_in_period, periods.periodno, (periods.periodno -12) AS test,
						(chartdetails.period -12) AS test,
							(
							SELECT actual FROM chartdetails ly
							WHERE ly.accountcode = " . $PeriodNo . "
							AND ly.period = test
							) as lyactual 
						FROM chartdetails
						INNER JOIN periods ON periods.periodno = chartdetails.period
						WHERE chartdetails.accountcode =" . $PeriodNo; 
					
				$ErrMsg = _('The chart details for account') . ' ' . $SelectedAccount . ' ' . _('could not be retrieved');
				$ChartDetailsResult = DB_query($sql,$db,$ErrMsg);
				$ChartDetailRow = DB_fetch_array($ChartDetailsResult);
				
				
	
				
				
				
				echo "<TR bgcolor='#FDFEEF'>
					<TD COLSPAN=3><B>" . _('Total for period') . ' ' . $PeriodNo . '</B></TD>';
				if ($PeriodTotal < 0 ){ //its a credit balance b/fwd
					echo '<TD></TD>
						<TD ALIGN=RIGHT><B>' . number_format(-$PeriodTotal,2) . '</B></TD>
						<TD></TD>
						</TR>';
				} else { //its a debit balance b/fwd
					echo '<TD ALIGN=RIGHT><B>' . number_format($PeriodTotal,2) . '</B></TD>
						<TD COLSPAN=2></TD>
						</TR>';
				}
				$IntegrityReport .= '<BR>' . _('Period') . ': ' . $PeriodNo  . _('Account movement per transaction') . ': '  . number_format($PeriodTotal,2) . ' ' . _('Movement per ChartDetails record') . ': ' . number_format($ChartDetailRow['actual'],2) . ' ' . _('Period difference') . ': ' . number_format($PeriodTotal -$ChartDetailRow['actual'],3);
				
				if (ABS($PeriodTotal -$ChartDetailRow['actual'])>0.01){
					$ShowIntegrityReport = True;
				}
			}
			$PeriodNo = $myrow['periodno'];
			$PeriodTotal = 0;
			$test10 = $myrow['lyactual'];
		}
$test1=$myrow['actual'];
		$test2=$myrow['budget'];
		$test3=$myrow['lyactual'];
		$test4=$sql;
		$test5+=$myrow['actual'];
		$test6=$myrow['bfwdbudget'];
		$lyPeriodTotal += $test3;
	//	echo "<tr><td colspan=14><p>" . $test1 . ' -2-- ' . $test2 . ' --3--' . $test3 . ' ---5-' . $test5 . ' ----6 ' . $test6 . ' 
	//			</p></td></tr>';
		if ($k==1){
			echo "<tr bgcolor='#CCCCCC'>";
			$k=0;
		} else {
			echo "<tr bgcolor='#EEEEEE'>";
			$k++;
		}
		$lyRunningTotal = 0;
		$lyTotal = 0;
		$RunningTotal += $myrow['actual'];
		$RunningBTotal += $myrow['budget'];
		$PeriodTotal += $myrow['actual'];
		
		if (is_null($myrow['lyactual']))
		{$lyTotal = 0;} else {
		$lyTotal = number_format($myrow['lyactual'],2);}
		$lyRunningTotal += $lyTotal;
		
		if($myrow['actual']>=0){
			$ActualAmount = number_format($myrow['actual'],2);
			} else {
			$ActualAmount = number_format(-$myrow['actual'],2);
			}

		if($myrow['budget']>=0){
			$BudgetAmount = number_format($myrow['budget'],2);
			} else {
			$BudgetAmount = number_format(-$myrow['budget'],2);
			
		}
		
//$Variance = $BudgetAmount-$ActualAmount;
//if ($Variance == "" || $Variance == 0)
//	{
			if ($myrow['actual']<=0)
			{
			 $Actual1 = $myrow['actual']*(-1);
			 $Budget1 = $myrow['budget']*(-1);
			 $Variance = $Budget1 - $Actual1;
			}
			else
			{
			 $Variance = $Budget1 - $Actual1;
			}
	    $Variance1 = number_format($Variance,2);
		
		
		
		
					$sql = "SELECT lastdate_in_period FROM periods 
					WHERE periods.periodno=" . $myrow['period']; 
					
				$ErrMsg = _('The Period dates') . ' ' . $myrow['period'] . ' ' . _('could not be retrieved');
				$PeriodResult = DB_query($sql,$db,$ErrMsg);
				$PeriodRow = DB_fetch_array($PeriodResult);
				$PeriodNo2 = $myrow['period'];	
				$ActualAmount = $myrow['actual'];
				$BudgetAmount = $myrow['budget'];
				$lyTotal = $myrow['lyactual'];
				$BudgetVar = $ActualAmount - $BudgetAmount;
				$culmBudgetVar += $BudgetVar;
		$PeriodBudget += $BudgetAmount;
		
		$q1 = $myrow['budget1'];
		$q2 = $myrow['budget2'];
		$q3 = $myrow['budget3'];
		$q4 = $myrow['budget4'];
		
		if (is_null($q1))
		{$q1diff = "-";}
		else {$q1diff = $ActualAmount - $q1;}
		if (is_null($q2))
		{$q2diff = "-";}
		else {$q2diff = $ActualAmount - $q2;}
		if (is_null($q3))
		{$q3diff = "-";}
		else {$q3diff = $ActualAmount - $q3;}
		if (is_null($q4))
		{$q4diff = "-";}
		else {$q4diff = $ActualAmount - $q4;}
		
		
		
				$PeriodText = MonthAndYearFromSQLDate($PeriodRow['lastdate_in_period']);
				if (is_null($test3))
				{$varly = NULL; }
				else { $varly = $ActualAmount - $test3; }

		printf("<td>%s<input type=\"hidden\" name=\"periodid%s\" value=\"%s\"></td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td><input name=\"budget%s\" type=\"text\" size=\"5\" value=\"%s\"></td>
			<td ALIGN=RIGHT>%s</td>
			<td ALIGN=RIGHT>%s</td>
			<td><input name=\"q1budget%s\" type=\"text\" size=\"5\" value=\"%s\"></td>
			<td>%s</td>
			<td><input name=\"q2budget%s\" type=\"text\" size=\"5\" value=\"%s\"></td>
			<td>%s</td>
			<td><input name=\"q3budget%s\" type=\"text\" size=\"5\" value=\"%s\"></td>
			<td>%s</td>
			<td><input name=\"q4budget%s\" type=\"text\" size=\"5\" value=\"%s\"></td>
			<td>%s</td>
			<td ALIGN=RIGHT>%s</td>
			<td ALIGN=RIGHT>%s</td>
			<td ALIGN=RIGHT>%s</td>		
			</tr>",
			$PeriodText,
			$j,
			$PeriodNo2,
			$ActualAmount,
			$test3,
			$varly,
			$j,
			$BudgetAmount,
			$BudgetVar,
			$culmBudgetVar,
			$j,
			$q1,
			$q1diff,
			$j,
			$q2,
			$q2diff,
			$j,
			$q3,
			$q3diff,
			$j,
			$q4,
			$q4diff,
			$test5,
			$PeriodBudget,
			$lyPeriodTotal);


		$j++;

		If ($j == 18){
			echo $TableHeader;
			$j=1;
		}
		
	}

	echo "<TR bgcolor='#FDFEEF'><TD COLSPAN=3><B>";
	if ($PandLAccount==True){
		echo _('Total Period Movement');
	} else { /*its a balance sheet account*/
		echo _('Balance C/Fwd');
	}
	echo '</B></TD>';

	if ($RunningTotal >0){
		echo '<TD ALIGN=RIGHT><B>' . number_format(($RunningTotal),2) . '</B></TD><TD COLSPAN=2></TD></TR>';
	}else {
		echo '<TD></TD><TD ALIGN=RIGHT><B>' . number_format((-$RunningTotal),2) . '</B></TD><TD COLSPAN=2></TD></TR>';
	}
		echo '<tr><td colspan=6><input NAME="BudgetUpdate" type="submit" value="Update Budget">';
		echo '</td></tr>';


	echo '</table>';
	
} /* end of if Show button hit */





if (isset($_POST['BudgetUpdate'])){
		prnMsg(_('Budget Update ') . ' ' ,'success');

	$tot_no_prod = $_REQUEST['rowcountspec'];
		prnMsg(_('row count ') . ' ' . $_REQUEST['rowcountspec'] . ' ');
prnMsg(_('account code ') . ' ' . $_REQUEST['Account'] . ' ');

for($i=1; $i<=$tot_no_prod; $i++)
{
	
	        $period_id_var = 'periodid'.$i;
        $budget_id_var = 'budget'.$i;
        $q1_var = 'q1budget'.$i;
        $q2_var = 'q2budget'.$i;
        $q3_var = 'q3budget'.$i;
        $q4_var = 'q4budget'.$i;
        
 
        
        $period_id = $_REQUEST[$period_id_var];
        $budget_id = $_REQUEST[$budget_id_var];
        if ($_REQUEST[$q1_var] == 0)
		{$q1_id = "NULL";}
		else
		{$q1_id = $_REQUEST[$q1_var];}
        if ($_REQUEST[$q2_var] == 0)
		{$q2_id = "NULL";}
		else
		{$q2_id = $_REQUEST[$q2_var];}
        
        if ($_REQUEST[$q3_var] == 0)
		{$q3_id = "NULL";}
		else
		{$q3_id = $_REQUEST[$q3_var];}
        
        if ($_REQUEST[$q4_var] == 0)
		{$q4_id = "NULL";}
		else
		{$q4_id = $_REQUEST[$q4_var];}
        
		
		   

         $query ="update chartdetails set budget =" . $budget_id . ", budget1 =  " . $q1_id . ", budget2 =  " . $q2_id . ", budget3 =  " . $q3_id . ", budget4 =  " . $q4_id . " 
         		   where period='" . $period_id . "'  
         		   and accountcode = ". $_REQUEST['Account'];
 
//		updateStk($prod_id,$qty);
     $result = mysql_query($query, $connection);
$result = DB_query($query,$db,$ErrMsg,$DbgMsg);
//   echo $query;
//   echo "<br>q1 id " . $q1_id . " q1 var " . $q1_var . " q1 request " .  $_REQUEST[$q1_var] . "<br>";

}

$sql_max = 'SELECT MAX(periodno) FROM periods';
	$MaxPrd = DB_query($sql_max,$db);
	$MaxPrdrow = DB_fetch_row($MaxPrd);
$sql_min = 'SELECT MIN(periodno) FROM periods';
	$MinPrd = DB_query($sql_min,$db);
	$MinPrdrow = DB_fetch_row($MinPrd);

	for ($i=$MinPrdrow[0];$i<=$MaxPrdrow[0];$i++){

$sql_upd='SELECT accountcode, period, budget, actual, bfwd, bfwdbudget FROM chartdetails WHERE period ='. $i;

		$ErrMsg = _('Could not retrieve the ChartDetail records because');
		$result_upd = DB_query($sql_upd,$db,$ErrMsg);

		while ($myrow_upd=DB_fetch_array($result_upd)){

			$CFwd = $myrow_upd['bfwd'] + $myrow_upd['actual'];
			$CFwdBudget = $myrow_upd['bfwdbudget'] + $myrow_upd['budget'];

		//	echo '<BR>' . _('Account Code') . ': ' . $myrow_upd['accountcode'] . ' ' . _('Period') .': ' . $myrow_upd['period'];

			$sql_upd1 = 'UPDATE chartdetails SET bfwd=' . $CFwd . ', bfwdbudget=' . $CFwdBudget . ' WHERE period=' . ($myrow_upd['period'] +1) . ' AND  accountcode = ' . $myrow_upd['accountcode'];

			$ErrMsg =_('Could not update the chartdetails record because');
			$updresult = DB_query($sql_upd1,$db,$ErrMsg);
		}
}
//echo $sql_upd1;

	prnMsg(_('SUCCESS'),'info');
//	$sql = "UPDATE chartdetails
//				SET budget='" . $_POST['budget'] . "'
//				WHERE period='" . $ChartDetailRow['period'] . "'
//				AND accountcode = " . $ChartDetailRow['accountcode'];
// $result = mysql_query($sql, $connection);
//  $result = DB_query($sql,$db,$ErrMsg,$DbgMsg);
//					

// stick an echo in here:
// echo $sql;
	
//	exit;
		
	}
if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible

	if (strpos($_POST['SectionName'],'&')>0 OR strpos($_POST['SectionName'],"'")>0) {
		$InputError = 1;
		prnMsg( _('The account section name cannot contain the character') . " '&' " . _('or the character') ." '",'error');
	} elseif (isset($_POST['SectionID']) && (!is_long((int) $_POST['SectionID']))) {
		$InputError = 1;
		prnMsg( _('The section number must be an integer'),'error');
	}

	if ($_POST['SelectedSectionID']!='' AND $InputError !=1) {

		/*SelectedSectionID could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/

		$sql = "UPDATE accountsection
				SET sectionname='" . $_POST['SectionName'] . "'
				WHERE sectionid = " . $_POST['SelectedSectionID'];

		$msg = _('Record Updated');
	} elseif ($InputError !=1) {

	/*SelectedSectionID is null cos no item selected on first time round so must be adding a record must be submitting new entries in the new account section form */

		$sql = "INSERT INTO accountsection (
					sectionid,
					sectionname )
			VALUES (
				" . $_POST['SectionID'] . ",
				'" . $_POST['SectionName'] ."'
				)";
		$msg = _('Record inserted');
	}

	if ($InputError!=1){
		//run the SQL from either of the above possibilites
		$result = DB_query($sql,$db);
		prnMsg($msg,'success');
	}
	unset ($_POST['SelectedSectionID']);
	unset ($_POST['SectionID']);
	unset ($_POST['SectionName']);

}

if ($ShowIntegrityReport){

	prnMsg( _('There are differences between the sum of the transactions and the recorded movements in the ChartDetails table') . '. ' . _('A log of the account differences for the periods report shows below'),'warn');
	echo '<P>'.$IntegrityReport;
}
echo "</FORM>";
include('includes/footer.inc');
?>
