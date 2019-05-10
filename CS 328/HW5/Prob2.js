function start()
{
	            var button = document.getElementById( "calculateButton1" );
            button.addEventListener( "click", calculateGrade, false );

}

start(); 

function gradeQuiz()
{
	var score = 0;
	var ans1 = document.getElementByName( "firstGame" ).value;
	var ans2 = document.getElementByName( "mostTime" ).value;
	var ans3 = document.getElementByName( "whatsNew" ).value;
	var ans4 = document.getElementByName( "chief" ).value;
	var ans5 = document.getElementByName( "duckHunt" ).value;
	var ans6 = document.getElementByName( "greenMario" ).value;
	var ans7 = document.getElementByName( "favorite" ).value;
	
	if(ans1 == "Atari Adventure")
		score++;
	
	if(ans2 == "Shigeru Miyamoto")
		score++;
		
	if(ans3 == "correct")
		score++;
	
	if(ans4 == "Halo")
		score++;
	
	if(ans5 == "Hunting Ducks")
		score++;
	
	if(ans6 == "Luigie")
		score++;
	
	
	if(score >= 5)
	{
		document.getElementById("quiz").innerHTML = "<h1> Quiz Graded </h1>" + "<p> Congration! You done it! Your grade is: " + score 
			+ "/6 Praise Be your gaming wisdom you legend!!!<br>" + ans7 +  "? I like that gem too.</p>"  +'<input id = "retryButton" onClick="start()" type="button" value="Retry">';
	}
	else if(score == 3)
	{
		document.getElementById("quiz").innerHTML = "<h1> Quiz Graded </h1>" + "<p> Your grade is: " + score 
			+ "6 You have played some games but have not earned the rank of master." + ans7 +  "? That game is alright.</p>"  +'<input id = "retryButton" onClick="start()" type="button" value="Retry">';
	}
	else
	{
		document.getElementById("quiz").innerHTML = "<h1> Quiz Graded </h1>" + "<p> Phony! Your grade is: " + score 
			+ "/6 You are a NOOB!!!!!!!!!! " + ans7 +  "?  I dont really perfer that game.</p>"  +'<input id = "retryButton" onClick="start()" type="button" value="Retry">';
	}
	
}