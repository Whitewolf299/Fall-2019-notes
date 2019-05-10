<?php
	$db_conn_str = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
							(HOST = cedar.humboldt.edu)
							(PORT = 1521))
							(CONNECT_DATA = (SID = STUDENT)))";
							
		$connection = oci_connect('sjb747','SPo98765',$db_conn_str);
			
			if(	! $connection)
			{
				exit;
			}
		
			$fname = strip_tags($_POST['fname']);
			$lname = strip_tags($_POST['lname']);
			$email = strip_tags($_POST['email']);
			$notes = strip_tags($_POST['notes']);
			$stories = strip_tags($_POST['height']);
			$rooms = strip_tags($_POST['numrms']);
			$price = strip_tags($_POST['parish']);
			$bname = strip_tags($_POST['bname']);
			
			$insert_building_str = 'insert into sjb747_building
									values
									(:new_bname, 
									:new_fname,
									:new_lname,
									:new_email,
									:new_notes,
									:new_height,
									:new_numrms,
									:new_parish)';
									
			new_build_stmt oci_parse($connection, $insert_building_str);
			

			oci_bind_by_name(new_build_stmt,":new_bname",$bname);
			oci_bind_by_name(new_build_stmt,":new_fname",$fname);
			oci_bind_by_name(new_build_stmt,":new_lname",$lname);
			oci_bind_by_name(new_build_stmt,":new_email",$email);
			oci_bind_by_name(new_build_stmt,":new_notes",$notes);
			oci_bind_by_name(new_build_stmt,":new_height",$height);
			oci_bind_by_name(new_build_stmt,":new_numrms",$rooms);
			oci_bind_by_name(new_build_stmt,":new_parish",$price);

			$num_inserted = oci_execute($new_build_stmt, OCI_DEFAULT);
			
			if ($num_inserted == 0)
			{
				?>
				<p style="color : white"> Sorry, no row inserted! </p>
				<?php
			}
			else
			{
				?>
				<p> HOORAY! 1 row inserted! </p>
				<?php
  
				oci_commit($connection);
			}
				oci_free_statement($new_build_stmt);
				oci_close($connection);
			
		}
	?>
	</body>
	</html>