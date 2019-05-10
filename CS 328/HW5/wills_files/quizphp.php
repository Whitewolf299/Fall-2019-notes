<?php

$ans1 = $_POST["ans1"];
$ans2 = $_POST["ans2"];
$ans3 = $_POST["ans3"];
$ans4 = $_POST["ans4"];
$ans5 = $_POST["ans5"];
$ans6 = $_POST["ans6"];
$ans7 = $_POST["ans7"];
$score = 0;
settype($score, "integer");


	
	if($ans1 == "Atari Adventure")
		$score++;
	
	if($ans2 == "Shigeru Miyamoto")
		$score++;
		
	if($ans3 == "correct")
		$score++;
	
	if($ans4 == "Halo")
		$score++;
	
	if($ans5 == "Hunting Ducks")
		$score++;
	
	if($ans6 == "Luigie")
		$score++;


$username = $_POST["username"];
$password = $_POST["password"];

$db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        $conn = oci_connect($username, $password, $db_conn_str);
if (! $conn)
{
	echo "Could not connect";
	exit;
}

$sql_insert = "insert into score values(:username, :ans1, 
  :ans2, :ans3, :ans4, :ans5, :ans6, :ans7, :score)"; 
  
  $compiled = oci_parse($conn, $sql_insert);
  
  oci_bind_by_name($compiled, ":username", $username);
  oci_bind_by_name($compiled, ":ans1", $ans1);
  oci_bind_by_name($compiled, ":ans2", $ans2);
  oci_bind_by_name($compiled, ":ans3", $ans3);
  oci_bind_by_name($compiled, ":ans4", $ans4);
  oci_bind_by_name($compiled, ":ans5", $ans5);
  oci_bind_by_name($compiled, ":ans6", $ans6);
  oci_bind_by_name($compiled, ":ans7", $ans7);
  oci_bind_by_name($compiled, ":score", $score);

oci_execute($compiled);

echo "Information should be submitted";
echo $score;

header("http://nrs-projects.humboldt.edu/~");
oci_close($conn); 
?>
<a href="http://nrs-projects.humboldt.edu/~">Back to Quiz</a>