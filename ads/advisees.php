<?php
	// Start the session
	session_start();

	// Insert the page header
	//$page_title = 'Welcome!';
	require_once('header.php');

	require_once('connectvars.php');
	// Show the navigation menu
  	require_once('navmenu.php');
	
  	if (isset($_SESSION['user_id'])) {
		echo '<table id="t01">';
		echo '<tr><th>First Name</th><th>Middle Initial</th><th>Last name</th><th>Email</th><th>Degree</th><th>GPA</th><th>UID</th></tr>';
		if (isset($_SESSION['acc_type'])){
            //Get student info
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		    $query = "SELECT uid, degree, gpa FROM student WHERE advisor='" . $_SESSION['user_id'] . "'";
    	    $data = mysqli_query($dbc, $query);
			while ($row = mysqli_fetch_array($data)) {            
				$degree = $row['degree'];
            	$gpa = $row['gpa'];
            	//Get basic info
            	$query2 = "SELECT uid, fname, minit, lname, email FROM users WHERE uid='" . $row['uid'] . "'";
    	    	$data2 = mysqli_query($dbc, $query2);
            	$row2 = mysqli_fetch_array($data2);
				echo '<tr><td>' . $row2['fname'] . ' </td><td>' . $row2['minit'] . ' </td><td>' . $row2['lname'] . ' </td><td>' . $row2['email'] . ' </td><td>' . $degree . ' </td><td>' . $gpa . ' </td><td>' . $row2['uid'] . ' </td></tr>';
			}
            echo '</table>';
        }
    }

    ?>

<?php
	require_once('footer.php');
?>
