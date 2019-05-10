
<?php
$name = $_POST["name"];
$ans1 = $_POST["firstGame"];
$ans2 = $_POST["mostTime"];
$ans3 = $_POST["whatsNew"];
$ans4 = $_POST["chief"];
$ans5 = $_POST["duckHunt"];
$ans6 = $_POST["greenMario"];
$ans7 = $_POST["favorite"];
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
  
  oci_bind_by_name($compiled, ":username", $name);
  oci_bind_by_name($compiled, ":ans1", $ans1);
  oci_bind_by_name($compiled, ":ans2", $ans2);
  oci_bind_by_name($compiled, ":ans3", $ans3);
  oci_bind_by_name($compiled, ":ans4", $ans4);
  oci_bind_by_name($compiled, ":ans5", $ans5);
  oci_bind_by_name($compiled, ":ans6", $ans6);
  oci_bind_by_name($compiled, ":ans7", $ans7);
  oci_bind_by_name($compiled, ":score", $score);

oci_execute($compiled);
echo "Information should be submitted <br>";

	if($score >= 5)
	{
		echo "YEET! You done it! Your grade is : ";
		echo $score;
		echo "/6 <br> Praise Be your gaming wisdom you legend!!! <br> ";
		echo $ans7;  
		echo "? I like that game too.<br>";
	}
	else if(score == 3)
	{
		echo "yay! You did it! Your grade is : ";
		echo $score;
		echo "/6 <br> You know enough to get by <br> ";
		echo $ans7;  
		echo "? I havent tried that game yet.<br>";
	}
	else
	{
		echo "Quiz Graded. <br>"; 
		echo "your score is : ";  
		echo $score; 
		echo "/6  >:("; 
		echo "You like ";
		echo ans7;
		echo "? My Mom always told me if i dont have anything ice o say dont say anything at all...";
		echo "<br> ...and, well you got your score.<br>";
	}
echo "Information should be submitted";

header("http://nrs-projects.humboldt.edu/~sjb747/328hw6_2/quizphp.php");
oci_close($conn); 
?>
<a href="http://nrs-projects.humboldt.edu/~sjb747/328hw6_2/quiz.html">Back to Quiz</a>