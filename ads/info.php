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
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$query = "SELECT * FROM users WHERE uid='" . $_SESSION['user_id'] . "'";
    	$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);
		echo '<table id="t01">';
		echo '<tr><th>First Name</th><th>Middle Initial</th><th>Last name</th><th>Address</th><th>Email</th><th>Date of Birth</th>';

		if($_SESSION['acc_type'] == 5){ //Student
			echo '<th>GPA</th><th>Faculty Advisor</th><th>Degree</th></tr>';
			//Put all data from row into table
			echo '<td>'.$row["fname"].'</td><td>'.$row["minit"].'</td><td>'.$row["lname"].'</td><td>'.$row["address"].'</td><td>'.$row["email"].'</td><td>'.$row["dob"].'</td>';
			$query = "SELECT * FROM student WHERE uid='" . $_SESSION['user_id'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			//Put rest of data into table

			$query2 = "SELECT fname, lname FROM users WHERE uid='" . $row['advisor'] . "'";
			$data2 = mysqli_query($dbc, $query2);
			$row2 = mysqli_fetch_array($data2);
			echo '<td>'.$row["gpa"].'</td><td>'.$row2["fname"].' '.$row2["lname"].'</td><td>'.$row["degree"].'</td></tr>';
		}
		else if ($_SESSION['acc_type'] == 8){ //Alumni
			echo '<th>GPA</th><th>Graduation Year</th><th>Degree Completed</th></tr>';
			//Put data from user into table
			echo '<td>'.$row["fname"].'</td><td>'.$row["minit"].'</td><td>'.$row["lname"].'</td><td>'.$row["address"].'</td><td>'.$row["email"].'</td><td>'.$row["dob"].'</td>';
			$query = "SELECT * FROM alumni WHERE uid='" . $_SESSION['user_id'] . "'";
			$data = mysqli_query($dbc, $query);
			$row = mysqli_fetch_array($data);
			echo '<td>'.$row["gpa"].'</td><td>'.$row["gradyear"].'</td><td>'.$row["degree"].'</td></tr>';
		}
		else if ($_SESSION['acc_type'] == 6){ //Faculty advisor
			echo '</tr><tr><td>'.$row["fname"].'</td><td>'.$row["minit"].'</td><td>'.$row["lname"].'</td><td>'.$row["address"].'</td><td>'.$row["email"].'</td><td>'.$row["dob"].'</td></tr>';
		}
		else if ($_SESSION['acc_type'] == 3){ //Graduation Secretary
			//Put data from user into table
			echo '</tr><tr><td>'.$row["fname"].'</td><td>'.$row["minit"].'</td><td>'.$row["lname"].'</td><td>'.$row["address"].'</td><td>'.$row["email"].'</td><td>'.$row["dob"].'</td></tr>';
		}
		else if ($_SESSION['acc_type'] == 4){ //System admin
			//Nothing additional 
			echo '</tr><tr><td>'.$row["fname"].'</td><td>'.$row["minit"].'</td><td>'.$row["lname"].'</td><td>'.$row["address"].'</td><td>'.$row["email"].'</td><td>'.$row["dob"].'</td></tr>';
		}
		
		echo '</table>';
	}
	echo '<br>';
	echo '<form action="editinfo.php">';
	echo '<input type="submit" class="button" value="Edit Personal Information">';
	echo '</form>';
	require_once('footer.php');

?>
