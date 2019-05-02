function start()
{
	var contents2 = '<h1>Are you a true gamer?</h1>' +
      '<form name="form" action = "#">' +
	  '<fieldset  style=" width:800px; padding:30px">' +
         '<label>1. What game had the first ever easter egg? </label><br>' +
			'<input type="radio" id="q1a1" name="firstGame" value="incorrect"> Halo Reach<br>' +
			'<input type="radio" id="q1a2" name="firstGame" value="incorrect"> Crash Bandicoot<br>' +
			'<input type="radio" id="q1a3" name="firstGame" value="incorrect star"> Shotgun Farmers<br>' +
			'<input type="radio" id="q1a4" name="firstGame" value="correct"> Atari Adventure <br> <br>' +
		'<label>2. Who created Mario : </label><br>' +
			'<input type="radio" id="q2a1" name="mostTime" value="incorrect"> The Dude<br>' +
			'<input type="radio" id="q2a2" name="mostTime" value="correct">Shigeru Miyamoto<br>' +
			'<input type="radio" id="q2a3" name="mostTime" value="incorrect"> Barak Obama<br>' +
			'<input type="radio" id="q2a4" name="mostTime" value="incorrect"> My Uncle who works for Nintendo<br> <br>' +
		'<label>3. What is the Konami Code? : </label><br>' +
			'<input type="radio" id="q3a1" name="whatsNew" value="correct"> UP UP DOWN DOWN LEFT RIGHT LEFT RIGHT A A B A START .<br>' +
			'<input type="radio" id="q3a2" name="whatsNew" value="incorrect"> UP UP UP LEFT DOWN DOWN DOWN LEFT UP UP UP LEFT RIGHT<br>' +
			'<input type="radio" id="q3a3" name="whatsNew" value="incorrect"> Hold down until it blue screens<br>' +
			'<input type="radio" id="q3a4" name="whatsNew" value="incorrect"> Up.<br> <br>' +
		'<label>4. From what game is Master Chief from? </label><br>' +
			'<input type="radio" id="q4a1" name="chief" value="correct"> Halo<br>' +
			'<input type="radio" id="q4a2" name="chief" value="incorrect"> Mario<br>' +
			'<input type="radio" id="q4a3" name="chief" value="correct"> Super Smash Bros.<br><br>' +
		'<label>5. What is the Nintendo game "Duck Hunt" about.</label><br>' +
			'<input type="radio" id="q5a1" name="duckHunt" value="correct"> Hunting Ducks<br>' +
			'<input type="radio" id="q5a2" name="duckHunt" value="incorrect"> NOT Huntng Ducks<br><br>' +
		'<label>6. Who is green mario? </label><br>' +
			'<input type="radio" id="q6a1" name="greenMario" value="incorrect"> JackSepticEye<br>' +
			'<input type="radio" id="q6a2" name="greenMario" value="correct"> Luigie<br>' +
			'<input type="radio" id="q6a3" name="greenMario" value="incorrect"> Bowser<br><br>' +
		
		'<label>7. Fill in the blank: </label><br>' +
			'<p> What is your favorite game : <input type="text" id="q7a1" name="favorite" placeholder="Enter answer here..."></p>' +
			'<br>' +
            '<input id = "submitButton" onClick="validateForm()" type="button" value="Submit">' +
			'</fieldset>' +
      '</form>';

	document.getElementById("quiz").innerHTML = contents2;
	
}

window.onload = function(){start();}; 

function validateForm()
{
	var multipleChoice1 = document.forms["form"]["firstGame"].value;
	var multipleChoice2 = document.forms["form"]["mostTime"].value;
	var multipleChoice3 = document.forms["form"]["whatsNew"].value;
	var multipleChoice4 = document.forms["form"]["chief"].value;
	var trueFalse1 = document.forms["form"]["duckHunt"].value;
	var trueFalse2 = document.forms["form"]["greenMario"].value;
	var fillIn = document.forms["form"]["favorite"].value;
	
	
	if(multipleChoice1 == "" || multipleChoice2 == "" || multipleChoice3 == "" || multipleChoice4 == "" || trueFalse1 == "" || trueFalse2 == "" || fillIn == "")
	{
		alert("Please fill in all areas of the quiz!");
	}
	else
	{
		gradeQuiz(multipleChoice1, multipleChoice2, multipleChoice3, multipleChoice4, trueFalse1, trueFalse2, fillIn);
	}

	
}

function gradeQuiz(ans1, ans2, ans3, ans4, ans5, ans6, ans7)
{
	var score = 0;
	
	if(ans1 == "correct")
		score++;
	
	if(ans2 == "correct")
		score++;
		
	if(ans3 == "correct")
		score++;
	
	if(ans4 == "correct")
		score++;
	
	if(ans5 == "correct")
		score++;
	
	if(ans6 == "correct")
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





