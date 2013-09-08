<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

# module parameter settings
  
  $width         = $params->def( 'width', '150' );
  $height        = $params->def( 'height', '174' );

$content = "<TABLE width=\"100%\" border=1 cellPadding=0 cellSpacing=0 bgcolor= #666666 >
<TBODY>
<TR>
<TD><CENTER>
<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='$width' height='$height' id='calc' align='middle'>
<param name='movie' value='calc/calc.swf?' />
<param name='quality' value='high' />
<param name='menu' value='false' />
<param name='wmode' value='transparent' />
<embed src='calc/calc.swf?' quality='high' wmode='transparent' menu='false' width='$width' height='$height' name='calc' align='middle' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
</object>
</CENTER>
</TD>
</TR>
</TBODY>
</TABLE>";
 
?>