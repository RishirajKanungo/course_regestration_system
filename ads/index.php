<?php
	// Start the session
	session_start();
	// Insert the page header
	//$page_title = 'Welcome!';
	require_once('header.php');

	require_once('connectvars.php');
	// Show the navigation menu
	require_once('navmenu.php');

	
	echo '<div class="index">';
	
  	if (isset($_SESSION['user_id'])) {
		if (isset($_SESSION['acc_type'])){
			echo '<table id="t02">';
			if($_SESSION['acc_type'] == 0){ //Student
				//echo '<tr><td>Currently signed in as:<b> Student</b></td></tr><tr></tr>';
				echo '<tr><td><a href="transcript.php" style="color:black;">View Transcipt</a></td></tr>';
				echo '<tr><td><a href="info.php" style="color:black;"> View/Edit Personal Information</a></td></tr>';
				echo '<tr><td><a href="form1.php" style="color:black;">Fill Out Form One</a></td></tr>';
				echo '<tr><td><a href="gradapp.php" style="color:black;">Apply For Graduation</a></td></tr>';
				echo '</table>';	
			}
			else if($_SESSION['acc_type'] == 5){ //Alumni
				echo '<table><tr><td><a href="transcript.php" style="color:black;">View Transcript</a></td></tr>';
				echo '<tr><td><a href="info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
			}
			else if($_SESSION['acc_type'] == 6){ //Faculty advisor
				echo '<tr><td><a href="gradstatus.php" style="color:black;">Check Advisee Graduation Status</a></td></tr>';
				echo '<tr><td><a href="transcript.php" style="color:black;">Show Advisees Transcripts</a></td></tr>';
				echo '<tr><td><a href="viewform1.php" style="color:black;">Check Advisees Form1s</a></td></tr>';
				echo '<tr><td><a href="form1approval.php" style="color:black;">Approve Form Ones</a></td></tr>';
				echo '<tr><td><a href="thesisapproval.php" style="color:black;">Approve PhD Theses</a></td></tr>';
				echo '<tr><td><a href="advisees.php" style="color:black;">Show Advisees</a></td></tr>';
				echo '<tr><td><a href="info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
			}
			else if($_SESSION['acc_type'] == 3){ //Grad Secretary
				echo '<tr><td><a href="gradstatus.php" style="color:black;">Check Graduation Status</a></td></tr>';
				echo '<tr><td><a href="transcript.php" style="color:black;">View Transcipts</a></td></tr>';
				echo '<tr><td><a href="form1approval.php" style="color:black;">View Form Ones</a></td></tr>';
				echo '<tr><td><a href="gradapproval.php" style="color:black;">Approve Graduation Applications</a></td></tr>';
				echo '<tr><td><a href="assignadvisor.php" style="color:black;">Assign Faculty Advisors</a></td></tr>';
				echo '<tr><td><a href="info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
			}
			else if($_SESSION['acc_type'] == 4){	//Sys Admin
				echo '<tr><td><a href="createnewuser.php" style="color:black;">Create New User</a></td></tr>';
				echo '<tr><td><a href="transcript.php" style="color:black;">View Transcipts</a></td></tr>';
				echo '<tr><td><a href="gradstatus.php" style="color:black;">Check Graduation Status</a></td></tr>';
				echo '<tr><td><a href="form1approval.php" style="color:black;">Approve Form Ones</a></td></tr>';
				echo '<tr><td><a href="thesisapproval.php" style="color:black;">Approve PhD Theses</a></td></tr>';
				echo '<tr><td><a href="gradapproval.php" style="color:black;">Approve Graduation Applications</a></td></tr>';
				echo '<tr><td><a href="assignadvisor.php" style="color:black;">Assign Faculty Advisors</a></td></tr>';
				echo '<tr><td><a href="info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
			}

			echo '</table>';

		}
		else{
			echo'Account error. Please contact system administrator';
		}
		echo '</div>';
	}

?>

<?php
	require_once('footer.php');
	if (isset($_SESSION['gpacalc']))
	if (!($_SESSION['gpacalc'])){
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$query = "SELECT uid, account FROM user WHERE account=1 OR account=2";
    	$data = mysqli_query($dbc, $query);
		while ($row = mysqli_fetch_array($data)){
			$query2 = "SELECT grade FROM transcript WHERE uid='" . $row['uid'] . "'";
			$data2 = mysqli_query($dbc, $query2);
			$totalClasses = 0.00;
			$totalCred = 0.00;
			if ($data2)
			while ($row2 = mysqli_fetch_array($data2)){
				$totalClasses++;
				if ($row2['grade'] == 'A+' || $row2['grade'] == 'A')
					$totalCred += 4.00;
				else if ($row2['grade'] == 'A-')
					$totalCred += 3.70;
				else if ($row2['grade'] == 'B+')
					$totalCred += 3.30;
				else if ($row2['grade'] == 'B')
					$totalCred += 3.00;
				else if ($row2['grade'] == 'B-')
					$totalCred += 2.70;	
				else if ($row2['grade'] == 'C+')
					$totalCred += 2.30;	
				else if ($row2['grade'] == 'C')
					$totalCred += 2.00;
				else if ($row2['grade'] == 'C-')
					$totalCred += 1.70;	
				else if ($row2['grade'] == 'D+')
					$totalCred += 1.30;
				else if ($row2['grade'] == 'D')
					$totalCred += 1.00;	
				else if ($row2['grade'] == 'D-')
					$totalCred += 0.70;	
				else if ($row2['grade'] == 'IP')
					$totalClasses--;
			}
			if ($totalClasses != 0.00){
				$gpa = $totalCred/$totalClasses;
				if ($row['account'] == 1){
					$query3 = "UPDATE student SET gpa='".$gpa."' WHERE uid='" . $row['uid'] . "'";
				}
				else
					$query3 = "UPDATE alumni SET gpa='".$gpa."' WHERE uid='" . $row['uid'] . "'";
				$data3 = mysqli_query($dbc, $query3);
			}
		}
		$_SESSION['gpacalc'] = true;
	}
?>
