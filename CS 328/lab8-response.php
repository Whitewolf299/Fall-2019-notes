
<!DOCTYPE html>
<html>


<!--
    by:
    last modified:

    you can run this using the URL:

-->


<body>

    <ul>
		<li>  Your first name is: <?php echo strip_tags($_POST['fname']); ?>. <br> </li>
		<li> Your last name is:  <?php echo strip_tags($_POST['lname']); ?>. <br> </li>
		<li>  Your email is:  <?php echo strip_tags($_POST['email']) ?> <br> </li>
		<li> Your phone number is:  <?php echo strip_tags($_POST['fone'])?> <br> </li>
		<li> Your gender is: <?php echo strip_tags($_POST['gender']); ?>. <br><br> </li>
		
		
		<li> Your damage submitted is:  <br></li>
		<?php echo strip_tags($_POST['damage1']); ?> <br>
		<?php echo strip_tags($_POST['damage2']); ?> <br>
		<?php echo strip_tags($_POST['damage3']); ?> <br>
		<?php echo strip_tags($_POST['damage4']); ?> <br>
		<?php echo strip_tags($_POST['damage5']); ?> <br>
		<?php echo strip_tags($_POST['damage6']); ?> <br><br>
		
		<li> The notes you submitted are:  <?php echo strip_tags($_POST['notes']); ?> . <br><br></li>
		<li> The coverage you selected was:  <?php echo strip_tags($_POST['coverage']); ?> . <br></li>
	</ul>
		

</body>
</html>

