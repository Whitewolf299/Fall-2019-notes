<!DOCTYPE html>

<html>

<body>

<?php

$states = "California Georgia Indiana Louisiana Minnesota Texas Virginia";
$statesArray1 = [];
         if ( preg_match( "/\b([a-zA-Z]*nia)\b/i", $states, $match ) )
            print( "<p>Word found ending in '':nia " .
               $match[ 1 ] . "</p>" )
			   $statesArray1[0] = $match[1];

?>
</body>

</html>
