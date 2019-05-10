function start()
         {
            var button = document.getElementById( "calculateButton1" );
            button.addEventListener( "click", calculateGrade, false );
         } // end function start

         function calculateGrade()
         {
			var points = 0;
			var q1 = document.getElementById( "q1" ).value;
			var q2 = document.getElementById( "q2" ).value;
			var q3 = document.getElementById( "q3" ).value;
			var q4 = document.getElementById( "q4" ).value;
			var q5 = document.getElementById( "q5" ).value;
			var q6 = document.getElementById( "q6" ).value;
			q6 = q6.toLowerCase(q6);
			
			if (document.getElementById("q1").checked == true)
			{
				points = points + 1;
			}
			
			if (document.getElementById("q2").checked == true)
			{
				points = points + 1;
			}
			
			if (document.getElementById("q3").checked == true)
			{
				points = points + 1;
			}
			
			if (document.getElementById("q4").checked == true)
			{
				points = points + 1;
			}
			
			if (document.getElementById("q5").checked == true)
			{
				points = points + 1;
			}
			
			if (q6 == "istanbul" || q6 == "constantinople")
			{
				points = points + 1;
			}
			
			document.getElementById( "result" ).innerHTML = "Score: " + points + "/6";
			document.getElementById( "score" ).innerHTML = points;
         
		 }

         window.addEventListener( "load", start, false );

