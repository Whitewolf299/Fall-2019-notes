<!DOCTYPE html>

<html>

<body>

<?php

$states = "California Georgia Indiana Louisiana Minnesota Texas Virginia";
$statesArray2 = [];
$statesArray1 = [];
$statesArrayNia = [];

         if ( preg_match( "/\b([a-zA-Z]*nia)\b/i", $states, $match));
		 
			array_push($statesArray1, $match[0]);
			
         if ( preg_match( "/\b(G[a-zA-Z]*a)\b/i", $states, $match));
			array_push($statesArray1, $match[0]);
			
			echo " <br/></p> The states in StatesArray1 : "; 
			
		foreach($statesArray1 as $item)
		{
			echo $item;
		}
		
		foreach($statesArray1 as $state)
		{
			array_push($statesArray2, $state);
		}
		
		array_push($statesArray2, 	"West Virginia", 
									"North Carolina",
									"South Carolina",
									"New York",
									"New Mexico",
									"New Jersey");

		 
		 
		 echo "<br/> Number of states in statessArray2 : ";
		 echo count($statesArray2);
		 
		 $stateArrayNia = [];
		 
		 foreach($statesArray2 as $state)
		 {
			if($state[0] == 'N' || substr($state, -3) == 'nia')
			{
				array_push($statesArrayNia, $state);
			}
		 }
		 
		 echo "<br/><br/> The contents of stateArrayNia" ; 
		 
		 foreach($statesArrayNia as $state)
		 {
			 echo "<br/>";
			echo $state;
		 }
		 

?>
</body>

</html>
