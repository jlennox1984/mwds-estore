<?php

/* $Revision: 1.22 $ */

	echo '<BR><BR>';
	echo '</TD>';
	echo '</TR>';
	echo '</TABLE>';

	echo '</TD>';
/*Do the borders */
	echo '<TD BGCOLOR="#555555" COLSPAN="3"></TD></TR>';
	echo '<TR BGCOLOR="#555555"><TD  COLSPAN="3"></TD></TR>';
	echo '<TR BGCOLOR="#555555"><TD COLSPAN="5"><FONT SIZE="1">&nbsp;</FONT></TD></TR>';
	
	echo '</TABLE>';
	
	if ($DefaultClock==12) {
		$hour=date('g:i a');
	} else {
		$hour=date('H:i');
	}
	
	echo '<FONT SIZE=2>' .ucfirst(strftime('%A ')). date($_SESSION['DefaultDateFormat'] . ' | '  . $hour) . '</FONT>';
	
	
	
	echo '</BODY>';
	echo '</HTML>';

?>