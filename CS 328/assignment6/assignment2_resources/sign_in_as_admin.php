<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<!--
    demo connecting from PHP on nrs-projects
    to the Oracle student database on cedar

    adapted from an example by Peter Johnson
    adapted by: Sharon Tuttle
    last modified: 2019-03-28

    you can run this using the URL:
http://nrs-projects.humboldt.edu/~st10/s19cs328/328lect09-2/try-oracle.php
-->

<head>
    <title> Connecting to Oracle! </title>
    <meta charset="utf-8" />

    <?php
       ini_set('display_errors', 1);
       error_reporting(E_ALL);
    ?>

    <link href=
        "http://nrs-projects.humboldt.edu/~st10/styles/normalize.css"
        type="text/css" rel="stylesheet" />

    <link href="try-oracle.css" type="text/css"   
          rel="stylesheet" />
</head>

<body>
<h1> Connecting PHP to Oracle </h1>

<?php
    // do you need to ask for username and password?

    if ( ! array_key_exists("username", $_POST) )
    {
        // no username in $_POST? they need a login
        //     form!
        ?>
  
        <form method="post" 
              action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                        ENT_QUOTES) ?>">
        <fieldset>
            <legend> Please enter Oracle username/password: 
                </legend>

            <label for="username"> Username: </label>
            <input type="text" name="username" id="username" /> 

            <label for="password"> Password: </label>
            <input type="password" name="password" 
                   id="password" />

            <div class="submit">
                <input type="submit" value="Log in" />
            </div>
        </fieldset>
        </form>
    <?php
    }      

    else
    {
        // being paranoid, I am stripping tags from
        //    the username, just in case

        $username = strip_tags($_POST["username"]);

        // the ONLY thing I am doing with the given password
        //    is using it to try to log into Oracle - SO
        //    I hope this is OK:

        $password = $_POST["password"];

        $db_conn_str = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                    (HOST = cedar.humboldt.edu)
                                    (PORT = 1521))
                               (CONNECT_DATA = (SID = STUDENT)))";

        $conn = oci_connect($username, $password, $db_conn_str);

        // exit if could not connect

        if (! $conn)
        {
        ?>
            <p> Could not log into Oracle, sorry </p>

            <?php
            require_once("328footer.html");
            exit;
        }
 
        // if I reach here -- I connected!!

        // set up my select statement, and execute it

        $empl_query_str = 'select empl_last_name, hiredate,
                           salary, commission
                           from empl
                           order by empl_last_name';

        $empl_stmt = oci_parse($conn, $empl_query_str);
   
        oci_execute($empl_stmt, OCI_DEFAULT);
        ?>

        <table>
        <caption> Employee information </caption>
        <tr> <th scope="col"> Employee Name </th>
             <th scope="col"> Date of Hire </th>
             <th scope="col"> Salary </th>
             <th scope="col"> Commission </th>
        </tr>

        <?php
        while (oci_fetch($empl_stmt))
        {
            $curr_empl_name = oci_result($empl_stmt, "EMPL_LAST_NAME");
            $curr_hiredate = oci_result($empl_stmt, "HIREDATE");
            $curr_salary = oci_result($empl_stmt, "SALARY");
            $curr_commission = oci_result($empl_stmt, "COMMISSION");

            if ($curr_commission === NULL)
            {
                $curr_commission = "no commission";
            }
            ?>

            <tr> <td> <?= $curr_empl_name ?> </td>
                 <td> <?= $curr_hiredate ?> </td>
                 <td class="numeric"> <?= $curr_salary ?> </td>
                 <td class="numeric"> <?= $curr_commission ?> </td>
            </tr>
            <?php
        }
        ?>
        </table>

        <?php
        // remember to FREE your statement objects,
        //     and CLOSE YOUR CONNECTION!!!!!!!!!!!!!

        oci_free_statement($empl_stmt);
        oci_close($conn);
    }
    ?>

    <hr />

    <p>
        Validate by pasting .xhtml copy's URL into<br />
        <a href="https://html5.validator.nu/">
            https://html5.validator.nu/
        </a>
    </p>

    <p>
        <a href=
           "http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
            <img src="http://jigsaw.w3.org/css-validator/images/vcss"
                 alt="Valid CSS3!" height="31" width="88" />
        </a>
    </p>

</body>
</html>
	