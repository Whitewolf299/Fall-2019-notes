<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo inserting a new department,
    committing that change, and
    setting Oracle bind variables from PHP

    by: Peter Johnson
    adapted by: Sharon Tuttle
    last modified: 2018-03-08
-->

<head>  
    <title> committing and binding </title>
    <meta charset="utf-8" />
	
	

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css" 
          type="text/css" rel="stylesheet" />
    <link href="lect08-2.css" type="text/css"
          rel="stylesheet" />
</head> 

<body> 

    <h1>Enter Admin  </h1>

    <?php
    // when first called, show an enter-dept-info form

    if (! array_key_exists("username", $_POST))
    {
        // if there is no username in the $_POST array,
        //     they need a login form
        ?>

        <form method="post"
              action="<?= htmlentities($_SERVER['PHP_SELF'],
                                       ENT_QUOTES) ?>">
        <fieldset>
            <fieldset>
                <legend> Enter Oracle username/password: 
                    </legend>

                <label for="user_name"> Username: </label>
                <input type="text" name="username" id="user_name" /> 

                <label for="pass_word"> Password: </label>
                <input type="password" name="password" 
                       id="pass_word" />
            </fieldset>
            <fieldset>
                <legend> Building Details </legend>

                <label for="adress"> Building Adress: </label>
                <input type="text" name="adress" id="adress" 
                       required="required" />

                <label for="build_name"> Building Name: </label>
                <input type="text" name="buildname" id="build_name" 
                       required="required" />

                <label for="build_height"> Building Height(in stories): </label>
                <input type="number" name="height" id="height" 
                       required="required" />
					   
				<label for="dept_loc"> Number of rooms: </label>
                <input type="text" name="buildrooms" id="build_rooms" 
                       required="required" />

				<label for="price_range">Possible Price Range</label>
				<select id="price_range" name="pricerange" required = "required">
					<option value="default">--------</option>
					<option value="10-99">10,000 - 99,000</option>
					<option value="100-249">100,000 - 249,000</option>
					<option value="250-499">250,000 - 499,000</option>
					<option value="500+">500,000+</option>
				</select><br/><br/>
            
				<label for="f_name">First Name : </label>
                <input type="text" name="fname" id="f_name" 
                       required="required" />	
				
				<label for="l_name">Last Name : </label>
                <input type="text" name="lname" id="l_name" 
                       required="required" />
				
				<label for="email">Email : </label>
                <input type="text" name="email" id="email" 
                       required="required" />
				
				<label for="adress"> Architect id: </label>
                <input type="number" name="architectid" id="arch_id" 
                       required="required" />
			
			</fieldset>

            <div class="submit">
                <input type="submit" value="submit" />
				<input type="reset" value="Reset" />
                </div>
        </fieldset>
        </form>
        
        <?php
    }
        
    // otherwise, try to log in and insert a new department
 
    else     
    {
        // get username and password
        // (ALL I am doing with these is logging in with them...)

        $username = strip_tags($_POST['username']);
        $password = $_POST['password'];

        	$db_conn_str = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
							(HOST = cedar.humboldt.edu)
							(PORT = 1521))
							(CONNECT_DATA = (SID = STUDENT)))";
							
		$conn = oci_connect($username, $password,$db_conn_str);

        // if I REACH here, I must have connected!

        // grab the building and personal info for the new building

        $new_build_adress = strip_tags($_POST['adress']);
        $new_build_name = strip_tags($_POST['buildname']);
        $new_height = strip_tags($_POST['height']);
		$new_build_rooms = strip_tags($_POST['buildrooms']);
		$new_price = strip_tags($_POST['pricerange']);
		$new_first_name = strip_tags($_POST['fname']);
		$new_last_name = strip_tags($_POST['lname']);
		$new_email = strip_tags($_POST['email']);
		$new_id = strip_tags($_POST['architectid']);


        // INSTEAD of building the insert w/concatenation,
        //    I will use bind variables:
		
		
        $insert_build_str = 'insert into sjb747_building(architect_id, adress, b_name, height) 
                            values
                            (:new_id , "1850 wabash ave", "WillyWolly", 4)';
							
		$insert_personal_str = 'insert into sjb747_architect
								values
								(3, :new_f_name, :new_l_name, :new_email)';
								
								echo $insert_build_str;

        $insert_stmt = oci_parse($conn, $insert_build_str);

        // need to GIVE each bind variable a value before I execute
		oci_bind_by_name($insert_stmt, ':new_id', $new_id);
        oci_bind_by_name($insert_stmt, ':new_adress', $new_build_adress);
  //      oci_bind_by_name($insert_stmt, ':new_building_name', $new_build_name);
  //      oci_bind_by_name($insert_stmt, ':new_height', $new_build_name);
       // oci_bind_by_name($insert_stmt, ':new_rooms', $new_build_rooms);
		
		$num_inserted += oci_execute($insert_stmt, OCI_DEFAULT);
		
		
		$insert_stmt = oci_parse($conn, $insert_personal_str);
		
		oci_bind_by_name($insert_stmt, ':new_id', $new_id);
		oci_bind_by_name($insert_stmt, ':new_f_name', $new_first_name);
		oci_bind_by_name($insert_stmt, ':new_l_name', $new_last_name);
		oci_bind_by_name($insert_stmt, ':new_email', $new_email);
        // insert, update, and delete return the number of rows
        //    affected when they are executed

        $num_inserted += oci_execute($insert_stmt, OCI_DEFAULT);

        if ($num_inserted == 0)
        {
            ?>
            <p> Sorry, no row inserted! </p>
            <?php
        }
        else
        {
            ?>
            <p> You have listed your building!! </p>
            <?php
  
            oci_commit($conn);
        }

        // free and close!

        oci_free_statement($insert_stmt);
        oci_close($conn);
    }

            
?>

</body> 
</html> 