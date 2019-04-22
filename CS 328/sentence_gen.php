<!DOCTYPE html>

<html>

<body>

<?php
 $noun = array('boy', 'girl','cow', 'watermelon',
 'Samsung Note', 'tree', 'tractor', 'iPhone', 'car',
 'chicken', 'pen', 'chair', 'potato');

$verb = array('kissed', 'fried', 'dropped', 'wrote with',
 'called on', 'chopped', 'fed', 'sat on', 'skinned',
 'exploded', 'drove', 'ruined');

echo "The " . $noun[rand(0, count($noun) - 1)] . " "
		.$verb[rand(0, count($verb) - 1)] . " the " .
		$noun[rand(0, count($noun) - 1)];

?>
</body>

</html>