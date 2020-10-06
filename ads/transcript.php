<?php
	// Start the session
	session_start();

	// Insert the page header
	//$page_title = 'Welcome!';
	require_once('header.php');

	require_once('connectvars.php');
	// Show the navigation menu
  	require_once('navmenu.php');

	echo '<table id="t01" class="center">';

	if($_SESSION['acc_type'] == 8 || $_SESSION['acc_type'] ==5) {
		
		echo '<tr><th>Department</th><th>Course Number</th><th>Grade</th><th>Semester</th></tr>';
		
		if ($_SESSION['acc_type'] == 5)
			$query = "select gpa FROM student WHERE uid='" . $_SESSION['user_id'] . "'";
		else
			$query = "select gpa FROM alumni WHERE uid='" . $_SESSION['user_id'] . "'";

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $data = mysqli_query($dbc, $query);
		$gpadata = mysqli_fetch_array($data);


		$query = "select fname, lname FROM users WHERE uid='" . $_SESSION['user_id'] . "'";
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                //echo $query;
                $data = mysqli_query($dbc, $query);
                $namedata = mysqli_fetch_array($data);


		$query = "SELECT * FROM transcript t, section s WHERE t.sec_id = s.uid &&t.uid='" . $_SESSION['user_id'] . "'";

                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                //echo $query;
                $data = mysqli_query($dbc, $query);
                //$row = mysqli_fetch_array($data)

                echo "User id : ". $_SESSION['user_id'] . " Name : ". $namedata['fname'] . " ". $namedata['lname'] . " GPA : " . $gpadata['gpa'];
                while($row = mysqli_fetch_array($data)) {
			if($row['cno'] > 1000)	
                        echo "<tr><td>".$row['dept'] . "</td><td>".  $row['cno'] . "</td><td>".  $row['grade'] . "</td><td>".  $row['semester'] . " " . $row['year'] ."</td></tr>";        
                }	

		
	}
	if($_SESSION['acc_type'] == 6){
                $query = "SELECT * FROM student s, users a WHERE a.uid = s.uid AND advisor='" . $_SESSION['user_id'] . "'";
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				$data = mysqli_query($dbc, $query);
				$lastid = '0';
                while($uid = mysqli_fetch_array($data)){
					if($lastid != $uid['uid']) {
						$lastid = $uid['uid'];
						echo '</table>';
						echo "User id:".$uid[0]." Name: " . $uid['fname'] . " " . $uid['lname'] . " GPA:" . $uid['gpa'];
						echo '<table id="t01">';
						echo '<tr><th>Department</th><th>Course Number</th><th>Grade</th><th>Semester</th></tr>';

					}

                       	$query = "SELECT * FROM transcript t, semester s WHERE t.semesterid = s.semesterid &&t.uid='" . $uid[0] . "'";
						$dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                        $data1 = mysqli_query($dbc1, $query);

                        while($row = mysqli_fetch_array($data1)) {
				if($row['cno'] > 1000)	
                        	echo "<tr><td>".$row['dept'] . "</td><td>".  $row['cno'] . "</td><td>".  $row['grade'] . "</td><td>".  $row['semester'] . " ". $row['year'] ."</td></tr>";        
                	}
                        echo "<br />";
                }

	
	}

	if($_SESSION['acc_type'] == 3 || $_SESSION['acc_type'] == 4){


                $query = "SELECT * FROM section m, transcript t, users a, student s Having t.sec_id= m.uid AND t.uid = a.uid AND a.uid = s.uid ORDER BY t.uid ASC";/*orders it so its somewhat neat also can't see alumni transcripts*/
                $dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $data1 = mysqli_query($dbc1, $query);
				$lastid = '0';
                        while($row = mysqli_fetch_array($data1)) {
			      if($lastid != $row['uid']) {
			      	 $lastid = $row['uid'];
				 	echo '</table>';
					echo "User id : $lastid Name: " . $row['fname'] . " " . $row['lname'] . " GPA:" . $row['gpa'] . "<br />";
			      	 echo '<table id="t01">';
			      	 echo '<th>Department</th><th>Course Number</th><th>Grade</th><th>Semester</th></tr>';

			      }   
			    if($row['cno'] > 1000){	
			       echo "</td><td>".$row['dept'] . "</td><td>".  $row['cno'] . "</td><td>";
			       echo $row['grade'] . "</td><td>".  $row['semester'] . " ".$row['year'] ."</td></tr>";
			    }
                	}
        }


	
	echo '</table>';
    require_once('footer.php');
?>
