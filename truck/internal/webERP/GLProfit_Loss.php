<?php

/* $Revision: 1.11 $ */

$PageSecurity = 8;

include ('includes/session.inc');
$title = _('Profit and Loss');
include('includes/SQL_CommonFunctions.inc');
include('includes/AccountSectionsDef.inc'); // This loads the $Sections variable


if ($_POST['FromPeriod'] > $_POST['ToPeriod']){
	prnMsg(_('The selected period from is actually after the period to') . '! ' . _('Please reselect the reporting period'),'error');
	$_POST['SelectADifferentPeriod']='Select A Different Period';
}

if ((! isset($_POST['FromPeriod']) AND ! isset($_POST['ToPeriod'])) OR isset($_POST['SelectADifferentPeriod'])){

	include('includes/header.inc');
	echo "<FORM METHOD='POST' ACTION=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	
	if (Date('m') > $_SESSION['YearEnd']){
		/*Dates in SQL format */
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')));
	} else {
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')-1));
	}

	/*Show a form to allow input of criteria for profit and loss to show */
	echo '<CENTER><TABLE><TR><TD>'._('Select Period From').":</TD><TD><SELECT Name='FromPeriod'>";

	$sql = 'SELECT periodno, lastdate_in_period FROM periods ORDER BY periodno DESC';
	$Periods = DB_query($sql,$db);


	while ($myrow=DB_fetch_array($Periods,$db)){
		if(isset($_POST['FromPeriod']) AND $_POST['FromPeriod']!=''){
			if( $_POST['FromPeriod']== $myrow['periodno']){
				echo '<OPTION SELECTED VALUE=' . $myrow['periodno'] . '>' .MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<OPTION VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			}
		} else {
			if($myrow['lastdate_in_period']==$DefaultFromDate){
				echo '<OPTION SELECTED VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<OPTION VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			}
		}
	}

	echo '</SELECT></TD></TR>';
	if (!isset($_POST['ToPeriod']) OR $_POST['ToPeriod']==''){
		$sql = 'SELECT MAX(periodno) FROM periods';
		$MaxPrd = DB_query($sql,$db);
		$MaxPrdrow = DB_fetch_row($MaxPrd);

		$DefaultToPeriod = (int) ($MaxPrdrow[0]-1);
	} else {
		$DefaultToPeriod = $_POST['ToPeriod'];
	}

	echo '<TR><TD>' . _('Select Period To') . ":</TD><TD><SELECT Name='ToPeriod'>";

	$RetResult = DB_data_seek($Periods,0);

	while ($myrow=DB_fetch_array($Periods,$db)){

		if($myrow['periodno']==$DefaultToPeriod){
			echo '<OPTION SELECTED VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		} else {
			echo '<OPTION VALUE =' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		}
	}
	echo '</SELECT></TD></TR>';

	echo '<TR><TD>'._('Detail Or Summary').":</TD><TD><SELECT Name='Detail'>";
		echo "<OPTION SELECTED VALUE='Summary'>"._('Summary');
		echo "<OPTION SELECTED VALUE='Detailed'>"._('All Accounts');
	echo '</SELECT></TD></TR>';

	echo '</TABLE>';

	echo "<INPUT TYPE=SUBMIT Name='ShowPL' Value='"._('Show Statement of Profit and Loss')."'></CENTER>";
	echo "<CENTER><INPUT TYPE=SUBMIT Name='PrintPDF' Value='"._('PrintPDF')."'></CENTER>";

	/*Now do the posting while the user is thinking about the period to select */

	include ('includes/GLPostings.inc');

} else if (isset($_POST['PrintPDF'])) {
	
	include('includes/PDFStarter.php');
	$PageNumber = 0;
	$FontSize = 10;
	$pdf->addinfo('Title', _('Profit and Loss') );
	$pdf->addinfo('Subject', _('Profit and Loss') );
	$line_height = 12;

	$NumberOfMonths = $_POST['ToPeriod'] - $_POST['FromPeriod'] + 1;

	if ($NumberOfMonths > 12){
		include('includes/header.inc');
		echo '<P>';
		prnMsg(_('A period up to 12 months in duration can be specified') . ' - ' . _('the system automatically shows a comparative for the same period from the previous year') . ' - ' . _('it cannot do this if a period of more than 12 months is specified') . '. ' . _('Please select an alternative period range'),'error');
		include('includes/footer.inc');
		exit;
	}

	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['ToPeriod'];
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$PeriodToDate = MonthAndYearFromSQLDate($myrow[0]);


	$SQL = 'SELECT accountgroups.sectioninaccounts, 
			accountgroups.groupname,
			chartdetails.accountcode ,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwd ELSE 0 END) AS firstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwdbudget ELSE 0 END) AS firstprdbudgetbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['FromPeriod'] - 12) . ' THEN chartdetails.bfwd ELSE 0 END) AS lyfirstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['ToPeriod']-12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lylastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwdbudget + chartdetails.budget ELSE 0 END) AS lastprdbudgetcfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=1
		GROUP BY accountgroups.sectioninaccounts,
			accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			accountgroups.sequenceintb
		ORDER BY accountgroups.sectioninaccounts, 
			accountgroups.sequenceintb, 
			chartdetails.accountcode';

	$AccountsResult = DB_query($SQL,$db);
	if (DB_error_no($db) != 0) {
		$title = _('Profit and Loss') . ' - ' . _('Problem Report') . '....';
		include('includes/header.inc');
		prnMsg( _('No general ledger accounts were returned by the SQL because') . ' - ' . DB_error_msg($db) );
		echo '<BR><A HREF="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</A>';
		if ($debug == 1){
			echo '<BR>'. $SQL;
		}
		include('includes/footer.inc');
		exit;
	}
	
	include('includes/PDFProfitAndLossPageHeader.inc');

	$Section = '';
	$SectionPrdActual = 0;
	$SectionPrdLY = 0;
	$SectionPrdBudget = 0;

	$ActGrp = '';
	$GrpPrdActual = 0;
	$GrpPrdLY = 0;
	$GrpPrdBudget = 0;

	while ($myrow = DB_fetch_array($AccountsResult)){

		// Print heading if at end of page
		if ($YPos < ($Bottom_Margin)){
			include('includes/PDFProfitAndLossPageHeader.inc');
		}
		
		if ($myrow['groupname'] != $ActGrp){

			if ($ActGrp != ''){

				if ($_POST['Detail'] == 'Detailed'){
					$ActGrpLabel = $ActGrp . ' ' . _('total');
				} else {
					$ActGrpLabel = $ActGrp;
				}

				if ($Section == 1){ /*Income */
					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$ActGrpLabel);
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(-$GrpPrdActual),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(-$GrpPrdBudget),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(-$GrpPrdLY),'right');
					$YPos -= (2 * $line_height);
				} else { /*Costs */
					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$ActGrpLabel);
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($GrpPrdActual),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($GrpPrdBudget),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($GrpPrdLY),'right');
					$YPos -= (2 * $line_height);
				}
			}
			$GrpPrdLY = 0;
			$GrpPrdActual = 0;
			$GrpPrdBudget = 0;
		}

		if ($myrow['sectioninaccounts'] != $Section){

			$pdf->selectFont('./fonts/Helvetica-Bold.afm');
			$FontSize =10;
			if ($Section != ''){
				$pdf->line($Left_Margin+310, $YPos+$line_height,$Left_Margin+500, $YPos+$line_height);
				$pdf->line($Left_Margin+310, $YPos,$Left_Margin+500, $YPos);
				if ($Section == 1) { /*Income*/

					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$Section]);
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(-$SectionPrdActual),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(-$SectionPrdBudget),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(-$SectionPrdLY),'right');
					$YPos -= (2 * $line_height);
					
					$TotalIncome = -$SectionPrdActual;
					$TotalBudgetIncome = -$SectionPrdBudget;
					$TotalLYIncome = -$SectionPrdLY;
				} else {
					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$Section]);
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($SectionPrdActual),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($SectionPrdBudget),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($SectionPrdLY),'right');
					$YPos -= (2 * $line_height);
				}
				if ($Section == 2){ /*Cost of Sales - need sub total for Gross Profit*/
					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Gross Profit'));
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($TotalIncome - $SectionPrdActual),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($TotalBudgetIncome - $SectionPrdBudget),'right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($TotalLYIncome - $SectionPrdLY),'right');
					$pdf->line($Left_Margin+310, $YPos+$line_height,$Left_Margin+500, $YPos+$line_height);
					$pdf->line($Left_Margin+310, $YPos,$Left_Margin+500, $YPos);
					$YPos -= (2 * $line_height);

					if ($TotalIncome != 0){
						$PrdGPPercent = 100 *($TotalIncome - $SectionPrdActual) / $TotalIncome;
					} else {
						$PrdGPPercent = 0;
					}
					if ($TotalBudgetIncome != 0){
						$BudgetGPPercent = 100 * ($TotalBudgetIncome - $SectionPrdBudget) / $TotalBudgetIncome;
					} else {
						$BudgetGPPercent = 0;
					}
					if ($TotalLYIncome != 0){
						$LYGPPercent = 100 * ($TotalLYIncome - $SectionPrdLY) / $TotalLYIncome;
					} else {
						$LYGPPercent = 0;
					}
					$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Gross Profit Percent'));
					$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($PrdGPPercent,1) . '%','right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($BudgetGPPercent,1) . '%','right');
					$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($LYGPPercent,1). '%','right');
					$YPos -= (2 * $line_height);
				}
			}
			$SectionPrdLY = 0;
			$SectionPrdActual = 0;
			$SectionPrdBudget = 0;

			$Section = $myrow['sectioninaccounts'];

			if ($_POST['Detail'] == 'Detailed'){
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$myrow['sectioninaccounts']]);
				$YPos -= (2 * $line_height);
			}
			$FontSize =8;
			$pdf->selectFont('./fonts/Helvetica.afm');
		}

		if ($myrow['groupname'] != $ActGrp){
			$ActGrp = $myrow['groupname'];
			if ($_POST['Detail'] == 'Detailed'){
				$FontSize =10;
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$myrow['groupname']);
				$YPos -= (2 * $line_height);
				$FontSize =8;
				$pdf->selectFont('./fonts/Helvetica.afm');
			}
		}

		$AccountPeriodActual = $myrow['lastprdcfwd'] - $myrow['firstprdbfwd'];
		$AccountPeriodLY = $myrow['lylastprdcfwd'] - $myrow['lyfirstprdbfwd'];
		$AccountPeriodBudget = $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];
		$PeriodProfitLoss += $AccountPeriodActual;
		$PeriodBudgetProfitLoss += $AccountPeriodBudget;
		$PeriodLYProfitLoss += $AccountPeriodLY;

		$GrpPrdLY +=$AccountPeriodLY;
		$GrpPrdActual +=$AccountPeriodActual;
		$GrpPrdBudget +=$AccountPeriodBudget;

		$SectionPrdLY +=$AccountPeriodLY;
		$SectionPrdActual +=$AccountPeriodActual;
		$SectionPrdBudget +=$AccountPeriodBudget;

		if ($_POST['Detail'] == _('Detailed')) {
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,60,$FontSize,$myrow['accountcode']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+60,$YPos,190,$FontSize,$myrow['accountname']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($AccountPeriodActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($AccountPeriodBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($AccountPeriodLY),'right');
			$YPos -= $line_height;
		}
	}
	//end of loop

	if ($ActGrp != ''){

		if ($_POST['Detail'] == 'Detailed'){
			$ActGrpLabel = $ActGrp . ' '._('total');
		} else {
			$ActGrpLabel = $ActGrp;
		}

		if ($Section == 1){ /*Income */
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$ActGrpLabel);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(-$GrpPrdActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(-$GrpPrdBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(-$GrpPrdLY),'right');
			$YPos -= (2 * $line_height);
		} else { /*Costs */
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$ActGrpLabel);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($GrpPrdActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($GrpPrdBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($GrpPrdLY),'right');
			$YPos -= (2 * $line_height);
		}
	}

	if ($Section != ''){

		$pdf->selectFont('./fonts/Helvetica-Bold.afm');
		$pdf->line($Left_Margin+310, $YPos+10,$Left_Margin+500, $YPos+10);
		$pdf->line($Left_Margin+310, $YPos,$Left_Margin+500, $YPos);
		
		if ($Section == 1) { /*Income*/
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$Section]);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(-$SectionPrdActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(-$SectionPrdBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(-$SectionPrdLY),'right');
			$YPos -= (2 * $line_height);
			
			$TotalIncome = -$SectionPrdActual;
			$TotalBudgetIncome = -$SectionPrdBudget;
			$TotalLYIncome = -$SectionPrdLY;
		} else {
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,60,$FontSize,$Sections[$Section]);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($SectionPrdActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($SectionPrdBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($SectionPrdLY),'right');
			$YPos -= (2 * $line_height);
		}
		if ($Section == 2){ /*Cost of Sales - need sub total for Gross Profit*/
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,60,$FontSize,_('Gross Profit'));
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format($TotalIncome - $SectionPrdActual),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format($TotalBudgetIncome - $SectionPrdBudget),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format($TotalLYIncome - $SectionPrdLY),'right');
			$YPos -= (2 * $line_height);
			
			$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(100*($TotalIncome - $SectionPrdActual)/$TotalIncome,1) . '%','right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(100*($TotalBudgetIncome - $SectionPrdBudget)/$TotalBudgetIncome,1) . '%','right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(100*($TotalLYIncome - $SectionPrdLY)/$TotalLYIncome,1). '%','right');
			$YPos -= (2 * $line_height);
		}
	}

	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,60,$FontSize,_('Profit').' - '._('Loss'));
	$LeftOvers = $pdf->addTextWrap($Left_Margin+310,$YPos,70,$FontSize,number_format(-$PeriodProfitLoss),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+370,$YPos,70,$FontSize,number_format(-$PeriodBudgetProfitLoss),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+430,$YPos,70,$FontSize,number_format(-$PeriodLYProfitLoss),'right');
	
	$pdf->line($Left_Margin+310, $YPos+$line_height,$Left_Margin+500, $YPos+$line_height);
	$pdf->line($Left_Margin+310, $YPos,$Left_Margin+500, $YPos);	
	
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);
	
	if ($len <= 20){
		$title = _('Print Profit and Loss Error');
		include('includes/header.inc');
		echo '<p>';
		prnMsg( _('There were no entries to print out for the selections specified') );
		echo '<BR><A HREF="'. $rootpath.'/index.php?' . SID . '">'. _('Back to the menu'). '</A>';
		include('includes/footer.inc');
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=CustomerList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Stream();
	}
	exit;
	
} else {

	include('includes/header.inc');
	echo "<FORM METHOD='POST' ACTION=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	echo "<INPUT TYPE=HIDDEN NAME='FromPeriod' VALUE=" . $_POST['FromPeriod'] . "><INPUT TYPE=HIDDEN NAME='ToPeriod' VALUE=" . $_POST['ToPeriod'] . '>';

	$NumberOfMonths = $_POST['ToPeriod'] - $_POST['FromPeriod'] + 1;

	if ($NumberOfMonths >12){
		echo '<P>';
		prnMsg(_('A period up to 12 months in duration can be specified') . ' - ' . _('the system automatically shows a comparative for the same period from the previous year') . ' - ' . _('it cannot do this if a period of more than 12 months is specified') . '. ' . _('Please select an alternative period range'),'error');
		include('includes/footer.inc');
		exit;
	}

	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['ToPeriod'];
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$PeriodToDate = MonthAndYearFromSQLDate($myrow[0]);


	$SQL = 'SELECT accountgroups.sectioninaccounts, 
			accountgroups.groupname,
			chartdetails.accountcode ,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwd ELSE 0 END) AS firstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwdbudget ELSE 0 END) AS firstprdbudgetbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['FromPeriod'] - 12) . ' THEN chartdetails.bfwd ELSE 0 END) AS lyfirstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['ToPeriod']-12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lylastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwdbudget + chartdetails.budget ELSE 0 END) AS lastprdbudgetcfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=1
		GROUP BY accountgroups.sectioninaccounts,
			accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			accountgroups.sequenceintb
		ORDER BY accountgroups.sectioninaccounts, 
			accountgroups.sequenceintb, 
			chartdetails.accountcode';

	$AccountsResult = DB_query($SQL,$db,_('No general ledger accounts were returned by the SQL because'),_('The SQL that failed was'));

	echo '<CENTER><FONT SIZE=4 COLOR=BLUE><B>' . _('Statement of Profit and Loss for the'). ' ' . $NumberOfMonths . ' ' . _('months to'). ' ' . $PeriodToDate . '</B></FONT><BR>';

	/*show a table of the accounts info returned by the SQL
	Account Code ,   Account Name , Month Actual, Month Budget, Period Actual, Period Budget */

	echo '<TABLE CELLPADDING=2>';

	if ($_POST['Detail']=='Detailed'){
		$TableHeader = "<TR>
				<TD class='tableheader'>"._('Account')."</TD>
				<TD class='tableheader'>"._('Account Name')."</TD>
				<TD COLSPAN=2 class='tableheader'>"._('Period Actual')."</TD>
				<TD COLSPAN=2 class='tableheader'>"._('Period Budget')."</TD>
				<TD COLSPAN=2 class='tableheader'>"._('Last Year').'</TD>
				</TR>';
	} else { /*summary */
		$TableHeader = "<TR>
				<TD COLSPAN=2 class='tableheader'></TD>
				<TD COLSPAN=2 class='tableheader'>"._('Period Actual')."</TD>
				<TD COLSPAN=2 class='tableheader'>"._('Period Budget')."</TD>
				<TD COLSPAN=2 class='tableheader'>"._('Last Year')."</TD>
				</TR>";
	}


	echo $TableHeader;
	$j = 1;
	$k=0; //row colour counter
	$Section='';
	$SectionPrdActual= 0;
	$SectionPrdLY 	 = 0;
	$SectionPrdBudget= 0;

	$ActGrp ='';
	$GrpPrdActual	= 0;
	$GrpPrdLY 	= 0;
	$GrpPrdBudget 	= 0;



	while ($myrow=DB_fetch_array($AccountsResult)) {

		if ($myrow['groupname']!= $ActGrp){

			if ($GrpActual+$GrpBudget+$GrpPrdActual+$GrpPrdBudget !=0){

				if ($_POST['Detail']=='Detailed'){
					echo '<TR>
						<TD COLSPAN=2></TD>
						<TD COLSPAN=6><HR></TD>
					</TR>';
					$ActGrpLabel = $ActGrp . ' ' . _('total');
				} else {
					$ActGrpLabel = $ActGrp;
				}

				if ($Section ==1){ /*Income */
					printf('<TR>
						<TD COLSPAN=2><FONT SIZE=2>%s </FONT></td>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						</TR>',
						$ActGrpLabel,
						number_format(-$GrpPrdActual),
						number_format(-$GrpPrdBudget),
						number_format(-$GrpPrdLY));
				} else { /*Costs */
					printf('<TR>
						<TD COLSPAN=2><FONT SIZE=2>%s </FONT></td>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						</TR>',
						$ActGrpLabel,
						number_format($GrpPrdActual),
						number_format($GrpPrdBudget),
						number_format($GrpPrdLY));
				}

			}
			$GrpPrdLY =0;
			$GrpPrdActual =0;
			$GrpPrdBudget =0;


			$j++;

		}

		if ($myrow['sectioninaccounts']!= $Section){

			if ($SectionPrdLY+$SectionPrdActual+$SectionPrdBudget !=0){
				if ($Section==1) { /*Income*/

					echo '<TR>
						<TD COLSPAN=3></TD>
      						<TD><HR></TD>
						<TD></TD>
						<TD><HR></TD>
						<TD></TD>
						<TD><HR></TD>
					</TR>';

					printf('<TR>
					<TD COLSPAN=2><FONT SIZE=4>%s</FONT></td>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					</TR>',
					$Sections[$Section],
					number_format(-$SectionPrdActual),
					number_format(-$SectionPrdBudget),
					number_format(-$SectionPrdLY));
					$TotalIncome = -$SectionPrdActual;
					$TotalBudgetIncome = -$SectionPrdBudget;
					$TotalLYIncome = -$SectionPrdLY;
				} else {
					echo '<TR>
					<TD COLSPAN=2></TD>
      					<TD><HR></TD>
					<TD></TD>
					<TD><HR></TD>
					<TD></TD>
					<TD><HR></TD>
					</TR>';
					printf('<TR>
					<TD COLSPAN=2><FONT SIZE=4>%s</FONT></td>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					<TD></TD>
					<TD ALIGN=RIGHT>%s</TD>
					</TR>',
					$Sections[$Section],
					number_format($SectionPrdActual),
					number_format($SectionPrdBudget),
					number_format($SectionPrdLY));
				}
				if ($Section==2){ /*Cost of Sales - need sub total for Gross Profit*/
					echo '<TR>
						<TD COLSPAN=2></TD>
						<TD COLSPAN=6><HR></TD>
					</TR>';
					printf('<TR>
						<TD COLSPAN=2><FONT SIZE=4>'._('Gross Profit').'</FONT></td>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						<TD></TD>
						<TD ALIGN=RIGHT>%s</TD>
						</TR>',
					number_format($TotalIncome - $SectionPrdActual),
					number_format($TotalBudgetIncome - $SectionPrdBudget),
					number_format($TotalLYIncome - $SectionPrdLY));

					if ($TotalIncome !=0){
						$PrdGPPercent = 100*($TotalIncome - $SectionPrdActual)/$TotalIncome;
					} else {
						$PrdGPPercent =0;
					}
					if ($TotalBudgetIncome !=0){
						$BudgetGPPercent = 100*($TotalBudgetIncome - $SectionPrdBudget)/$TotalBudgetIncome;
					} else {
						$BudgetGPPercent =0;
					}
					if ($TotalLYIncome !=0){
						$LYGPPercent = 100*($TotalLYIncome - $SectionPrdLY)/$TotalLYIncome;
					} else {
						$LYGPPercent = 0;
					}
					echo '<TR>
						<TD COLSPAN=2></TD>
						<TD COLSPAN=6><HR></TD>
					</TR>';
					printf('<TR>
						<TD COLSPAN=2><FONT SIZE=2><I>'._('Gross Profit Percent').'</I></FONT></td>
						<TD></TD>
						<TD ALIGN=RIGHT><I>%s</I></TD>
						<TD></TD>
						<TD ALIGN=RIGHT><I>%s</I></TD>
						<TD></TD>
						<TD ALIGN=RIGHT><I>%s</I></TD>
						</TR><TR><TD COLSPAN=6> </TD></TR>',
						number_format($PrdGPPercent,1) . '%',
						number_format($BudgetGPPercent,1) . '%',
						number_format($LYGPPercent,1). '%');
					$j++;
				}
			}
			$SectionPrdLY =0;
			$SectionPrdActual =0;
			$SectionPrdBudget =0;

			$Section = $myrow['sectioninaccounts'];

			if ($_POST['Detail']=='Detailed'){
				printf('<TR>
					<td COLSPAN=6><FONT SIZE=4 COLOR=BLUE><B>%s</B></FONT></TD>
					</TR>',
					$Sections[$myrow['sectioninaccounts']]);
			}
			$j++;

		}



		if ($myrow['groupname']!= $ActGrp){
			$ActGrp = $myrow['groupname'];
			if ($_POST['Detail']=='Detailed'){
				printf('<TR>
					<td COLSPAN=6><FONT SIZE=2 COLOR=BLUE><B>%s</B></FONT></TD>
					</TR>',
					$myrow['groupname']);
			}
		}

		$AccountPeriodActual = $myrow['lastprdcfwd'] - $myrow['firstprdbfwd'];
		$AccountPeriodLY = $myrow['lylastprdcfwd'] - $myrow['lyfirstprdbfwd'];
		$AccountPeriodBudget = $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];
		$PeriodProfitLoss += $AccountPeriodActual;
		$PeriodBudgetProfitLoss += $AccountPeriodBudget;
		$PeriodLYProfitLoss += $AccountPeriodLY;

		$GrpPrdLY +=$AccountPeriodLY;
		$GrpPrdActual +=$AccountPeriodActual;
		$GrpPrdBudget +=$AccountPeriodBudget;

		$SectionPrdLY +=$AccountPeriodLY;
		$SectionPrdActual +=$AccountPeriodActual;
		$SectionPrdBudget +=$AccountPeriodBudget;

		if ($_POST['Detail']==_('Detailed')){

			if ($k==1){
				echo "<tr bgcolor='#CCCCCC'>";
				$k=0;
			} else {
				echo "<tr bgcolor='#EEEEEE'>";
				$k++;
			}

			$ActEnquiryURL = "<A HREF='$rootpath/GLAccountInquiry.php?" . SID . '&Period=' . $_POST['ToPeriod'] . '&Account=' . $myrow['accountcode'] . "&Show=Yes'>" . $myrow['accountcode'] . '<A>';

			if ($Section ==1){
				$PrintString = '<td>%s</td>
						<td>%s</td>
						<TD></TD>
						<td ALIGN=RIGHT>%s</td>
						<TD></TD>
						<td ALIGN=RIGHT>%s</td>
						<TD></TD>
						<td ALIGN=RIGHT>%s</td>
						</tr>';
			} else {
				$PrintString = '<td>%s</td>
						<td>%s</td>
						<td ALIGN=RIGHT>%s</td>
						<TD></TD>
						<td ALIGN=RIGHT>%s</td>
						<TD></TD>
						<td ALIGN=RIGHT>%s</td>
						<TD></TD>
						</tr>';
			}

			printf($PrintString,
				$ActEnquiryURL,
				$myrow['accountname'],
				number_format($AccountPeriodActual),
				number_format($AccountPeriodBudget),
				number_format($AccountPeriodLY)
				);


			$j++;
			If ($j == 18){
				$j=1;
				echo $TableHeader;
			}
		}
	}
	//end of loop


	if ($GrpActual+$GrpBudget+$GrpPrdActual+$GrpPrdBudget !=0){

		if ($_POST['Detail']=='Detailed'){
			echo '<TR>
			<TD COLSPAN=2></TD>
			<TD COLSPAN=6><HR></TD>
			</TR>';
			$ActGrpLabel = $ActGrp . ' '._('total');
		} else {
			$ActGrpLabel = $ActGrp;
		}

		if ($Section ==1){ /*Income */
			printf('<TR>
			<TD COLSPAN=2><FONT SIZE=2>%s '._('total').'</FONT></td>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			</TR>',
			$ActGrpLabel,
			number_format(-$GrpPrdActual),
			number_format(-$GrpPrdBudget),
			number_format(-$GrpPrdLY));
		} else { /*Costs */
			printf('<TR>
				<TD COLSPAN=2><FONT SIZE=2>%s '._('total').'</FONT></td>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				</TR>',
				$ActGrpLabel,
				number_format($GrpPrdActual),
				number_format($GrpPrdBudget),
				number_format($GrpPrdLY));
		}
	}

	if ($SectionPrdLY+$SectionPrdActual+$SectionPrdBudget !=0){

		if ($Section==1) { /*Income*/
			echo '<TR>
				<TD COLSPAN=2></TD>
				<TD></TD>
      				<TD><HR></TD>
				<TD></TD>
				<TD><HR></TD>
				<TD></TD>
				<TD><HR></TD>
				</TR>';
			printf('<TR>
			<TD COLSPAN=2><FONT SIZE=4>%s</FONT></td>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			<TD></TD>
			<TD ALIGN=RIGHT>%s</TD>
			</TR>',
			$Sections[$Section],
			number_format(-$SectionPrdActual),
			number_format(-$SectionPrdBudget),
			number_format(-$SectionPrdLY));
			$TotalIncome = -$SectionPrdActual;
			$TotalBudgetIncome = -$SectionPrdBudget;
			$TotalLYIncome = -$SectionPrdLY;
		} else {
			echo '<TR>
				<TD COLSPAN=2></TD>
      				<TD><HR></TD>
				<TD></TD>
				<TD><HR></TD>
				<TD></TD>
				<TD><HR></TD>
				</TR>';
			printf('<TR>
				<TD COLSPAN=2><FONT SIZE=4>%s</FONT></td>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				</TR>',
				$Sections[$Section],
				number_format($SectionPrdActual),
				number_format($SectionPrdBudget),
				number_format($SectionPrdLY));
		}
		if ($Section==2){ /*Cost of Sales - need sub total for Gross Profit*/
			echo '<TR>
				<TD COLSPAN=2></TD>
				<TD COLSPAN=6><HR></TD>
			</TR>';
			printf('<TR>
				<TD COLSPAN=2><FONT SIZE=4>'._('Gross Profit').'</FONT></td>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				<TD></TD>
				<TD ALIGN=RIGHT>%s</TD>
				</TR>',
			number_format($TotalIncome - $SectionPrdActual),
			number_format($TotalBudgetIncome - $SectionPrdBudget),
			number_format($TotalLYIncome - $SectionPrdLY));

			echo '<TR>
				<TD COLSPAN=2></TD>
				<TD COLSPAN=6><HR></TD>
			</TR>';
			printf('<TR>
				<TD COLSPAN=2><FONT SIZE=2><I>'._('Gross Profit Percent').'</I></FONT></td>
				<TD></TD>
				<TD ALIGN=RIGHT><I>%s</I></TD>
				<TD></TD>
				<TD ALIGN=RIGHT><I>%s</I></TD>
				<TD></TD>
				<TD ALIGN=RIGHT><I>%s</I></TD>
				</TR>',
			number_format(100*($TotalIncome - $SectionPrdActual)/$TotalIncome,1) . '%',
			number_format(100*($TotalBudgetIncome - $SectionPrdBudget)/$TotalBudgetIncome,1) . '%',
			number_format(100*($TotalLYIncome - $SectionPrdLY)/$TotalLYIncome,1). '%');
			$j++;
		}
	}

	if ($_POST['Detail']==_('Detailed')){
		printf('<TR>
			<td COLSPAN=6><FONT SIZE=4 COLOR=BLUE><B>%s</B></FONT></TD>
			</TR>',
			$Sections[$myrow['sectioninaccounts']]);
	}



	echo '<TR>
		<TD COLSPAN=2></TD>
		<TD COLSPAN=6><HR></TD>
		</TR>';

	printf("<tr bgcolor='#ffffff'>
		<td COLSPAN=2><FONT SIZE=4 COLOR=BLUE><B>"._('Profit').' - '._('Loss')."</B></FONT></td>
		<TD></TD>
		<td ALIGN=RIGHT>%s</td>
		<TD></TD>
		<td ALIGN=RIGHT>%s</td>
		<TD></TD>
		<td ALIGN=RIGHT>%s</td>
		</tr>",
		number_format(-$PeriodProfitLoss),
		number_format(-$PeriodBudgetProfitLoss),
		number_format(-$PeriodLYProfitLoss)
		);

	echo '<TR>
		<TD COLSPAN=2></TD>
		<TD COLSPAN=6><HR></TD>
		</TR>';

	echo '</TABLE>';
	echo "<INPUT TYPE=SUBMIT Name='SelectADifferentPeriod' Value='"._('Select A Different Period')."'></CENTER>";
}
echo '</FORM>';
include('includes/footer.inc');

?>
