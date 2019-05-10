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

    <?php
        /* include required PHP functions */

        require_once("hsu_conn.php");
    ?>

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

                <label for="dept_num"> Building Adress: </label>
                <input type="text" name="deptnum" id="dept_num" 
                       required="required" />

                <label for="dept_name"> Building Name: </label>
                <input type="text" name="deptname" id="dept_name" 
                       required="required" />

                <label for="dept_loc"> Building Height(in stories): </label>
                <input type="text" name="deptloc" id="dept_loc" 
                       required="required" />
					   
				<label for="dept_loc"> Number of rooms: </label>
                <input type="text" name="deptloc" id="dept_loc" 
                       required="required" />

				<label for="price_range">Possible Price Range</label>
				<select id="price_range" name="pricerange" required = "required">
					<option value="default">--------</option>
					<option value="10-99">10,000 - 99,000</option>
					<option value="100-249">100,000 - 249,000</option>
					<option value="250-499">250,000 - 499,000</option>
					<option value="500+">500,000+</option>
				</select><br/><br/>
            
				<label for="dept_loc"> Building Height(in stories): </label>
                <input type="text" name="deptloc" id="dept_loc" 
                       required="required" />			
			
			</fieldset>

            <div class="submit">
                <input type="submit" value="Add to Dept" />
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

        $conn = hsu_conn($username, $password);

        // if I REACH here, I must have connected!

        // grab the department info for the new department
        //     (client assures me these never contain tags!)

        $new_dept_num = strip_tags($_POST['deptnum']);
        $new_dept_name = strip_tags($_POST['deptname']);
        $new_dept_loc = strip_tags($_POST['deptloc']);

        // INSTEAD of building the insert w/concatenation,
        //    I will use bind variables:

        $insert_dept_str = 'insert into dept
                            values
                            (:new_dept_num, :new_dept_name, :new_dept_loc)';

        $insert_stmt = oci_parse($conn, $insert_dept_str);

        // need to GIVE each bind variable a value before I execute

        oci_bind_by_name($insert_stmt, ':new_dept_num', $new_dept_num);
        oci_bind_by_name($insert_stmt, ':new_dept_name', $new_dept_name);
        oci_bind_by_name($insert_stmt, ':new_dept_loc', $new_dept_loc);

        // insert, update, and delete return the number of rows
        //    affected when they are executed

        $num_inserted = oci_execute($insert_stmt, OCI_DEFAULT);

        if ($num_inserted == 0)
        {
            ?>
            <p> Sorry, no row inserted! </p>
            <?php
        }
        else
        {
            ?>
            <p> HOORAY! 1 row inserted! </p>
            <?php
  
            oci_commit($conn);
        }

        // free and close!

        oci_free_statement($insert_stmt);
        oci_close($conn);
    }

    require_once("328footer.html");             
?>

</body> 
</html> 