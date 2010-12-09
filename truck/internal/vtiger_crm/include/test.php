<?php
$tmp1 = "00000123";
echo substr($tmp1, -5, 5);    // bcdef
echo "<br>";
echo substr($tmp1, -5, 6);  // bcd
echo "<br>";
echo substr($tmp1, -3, 5);  // abcd
echo "<br>";
echo substr($tmp1, -1, 5);  // abcdef
echo "<br>";
echo substr($tmp1, -1, 3); // f


?>