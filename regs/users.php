<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Users';
require_once('header.php');
require_once('../connectvars.php');
?>
<head>
    <link rel="stylesheet" type="text/css" href="../apps/portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<style>
.borderless td, .borderless th {
        border: none;
}
.error{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
}
span{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
}    
input[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
    margin-right: 50px;
}
input[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
}
</style>
<br>
<div class="container">
<?php
//connect to db
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(empty($_SESSION['typeUser'])) {
	//not logged in
	echo "Please log in <br>";	
	$home_url = 'logout.php';
    header('Location: ' . $home_url);
}
//if logged in as student
else if ($_SESSION['typeUser'] == 5) {
	$home_url = 'index.php';
    header('Location: ' . $home_url);
}
//if logged in as gs
else if ($_SESSION['typeUser'] == 6 || $_SESSION['typeUser'] == 7 || $_SESSION['typeUser'] == 3) {
	//create the buttons for search and view by category
	//select all the courses in which students are enrolled
	$num_per_page = 5;
	$c_option_query = "SELECT DISTINCT c.uid, c.dept, c.cno FROM transcript t, courses c WHERE c.uid = t.cno"; 
	$c_option_data = mysqli_query($dbc, $c_option_query);
	?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="search_by">Search by:</label>
				<select id = "search_by" name = "search_by">
					<option value = "full_name">Student Name</option>
					<option value = "student_id">Student ID #</option>
					<option value = "degree_type">Degree (MS or PhD)</option>
					<option value = "admit_year">Admit Year</option>
				</select>
			<label for="search_user"></label>
				<input type="text" id="search_user" name="search_user">
			<input type="submit" name="search_user_button" class="btn btn-primary center-block" value="Search">
		<label for = "search_course">Filter by course:</label>
			<select id = "search_course" name = "search_course">
			<?php
			while($c_option_row = mysqli_fetch_array($c_option_data)) {
				$dept_num = $c_option_row['dept']." ".$c_option_row['cno'];
				echo '<option name="' .$c_option_row['uid']. '" id = "'.$c_option_row['uid'].'" value = "'.$c_option_row['uid'].'">' . $dept_num . '</option>';
			}
			?>
			</select>
		<input type="submit" id="search_course_button" name="search_course_button" class="btn btn-primary center-block" value = "Filter">
	<?php
	if(isset($_POST['search_user_button'])) {
		//just searching by user
		if(!empty($_POST['search_user'])) {
			if($_POST['search_by'] == "full_name") {
				if(strpos($_POST['search_user'], " ") !== false) {
					$name = explode(" ", $_POST['search_user']);
					$query = "select * from student s join users u on u.UID = s.uid where u.fname = '$name[0]' and u.lname = '$name[1]'";
				}
				else {
					//if no space, assume they only entered the first name
					$assumed_fname = $_POST['search_user'];
					$query = "select * from student s join users u on u.UID  = s.uid where u.fname = '$assumed_fname'";
				}
			} else if ($_POST['search_by'] == "student_id") {
				$student_id = $_POST['search_user'];
				$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid WHERE s.uid = '$student_id'";
			} else if ($_POST['search_by'] == "degree_type") {
				$degree_type = $_POST['search_user'];
				$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid WHERE s.degree = '$degree_type'";
			} else if ($_POST['search_by'] == "admit_year") {
				$admit_year = $_POST['search_user'];
				$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid WHERE s.admit_year = '$admit_year'";
			}
		}
		else {
			//loser! don't hit search without entering anything
			$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid WHERE s.uid = 0";
		}
	}
	else if(isset($_POST['search_course_button'])) {
		//display only students enrolled in sections of that class
		$query = "SELECT * from student s JOIN users u ON u.UID  = s.uid JOIN transcript t ON t.uid = s.uid JOIN courses c ON t.cno = c.uid WHERE c.uid = '".$_POST['search_course']."'";

	}
	else {
		//special functionality for paging
		if(isset($_GET['p']) && $_GET['p'] > 0) {
			$next_page = $_GET['p'] + 1;
			$range = ($num_per_page*$_GET['p']);
			$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid ORDER BY u.lname ASC, u.fname ASC LIMIT $range, $num_per_page";	
		}
		else {
			$next_page = 1;
			$query = "SELECT * FROM student s JOIN users u ON u.UID = s.uid ORDER BY u.lname ASC, u.fname ASC LIMIT $num_per_page";	
		}
	}

	$all_students_data = mysqli_query($dbc, $query);
	echo '<tr></table>';
    if (mysqli_num_rows($all_students_data) ==  0) {
		echo "No students match that search.<br>";
	}
    else {
	    	echo '<h4>User List</h4>';
		echo '<table>';
		echo '<tr><th>Name</th>';
		echo '<th>Student ID</th>';
		echo '<th>Addition Information</th>';
		while ($s_row = mysqli_fetch_array($all_students_data)) {  
			$student_id = $s_row['uid'];
			echo '<tr><td>' . $s_row['fname'] . ' ' . $s_row['lname'] . '</td>';
			echo '<td>Student ID: '.$s_row['UID'].'</td>';
			echo "<td><a href = './student.php?s_id=$student_id'>View Student Info and Update Grades</a> </td>";
		}
		echo '</table>';
	}
	//next page option
	if(isset($next_page)) {
		$total_query = "SELECT COUNT(*) AS total FROM student";
		$total_data = mysqli_query($dbc, $total_query);
		$total_row = mysqli_fetch_array($total_data);

		if ($total_row['total'] > $num_per_page*$next_page) {
			echo "<center><a href = './users.php?p=$next_page'>Next Page</a></center><br>";
		}
		if($next_page > 2) {
			$prev_page = $next_page - 2;
			echo "<center><a href = './users.php?p=$prev_page'>Previous Page</a></center><br>";
		}
		else if ($next_page == 2) {
			echo "<center><a href = './users.php'>Previous Page</a></center><br>";	
		}
	}

}
else if ($_SESSION['typeUser'] = 4) {
	$num_per_page = 5;
	$page_role = "all";
	if(isset($_POST['create_new_user'])) {
                //redirect to new user page
                $home_url = 'newuser.php';
                header('Location: ' . $home_url);
        }
	?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<label for="search_by">Search by:</label>
				<select id = "search_by" name = "search_by">
					<option value = "full_name">Full Name</option>
					<option value = "account_id">Account ID#</option>
					<option value = "faculty_id">Faculty ID#</option>
					<option value = "student_id">Student ID#</option>
				</select>
			<label for="search_user"></label>
				<input type="text" id="search_user" name="search_user"/>
			<input type="submit" class="btn btn-primary center-block" name="search_user_button" value="Search"/>
			<label for="view_by_role">View by Role:</label>
				<select id = "view_by_role" name = "view_by_role">
					<option value = 5>Student</option>
					<option value = 6>Faculty</option>
					<option value = 3>Graduate Secretary</option>
					<option value = 4>System Adminstrator</option>
				</select>
				<input type="submit" class="btn btn-primary center-block" name="viewbyrole_button" value="View"/>
			<input type = "submit" style="float:right; margin-right:0px;" class="btn btn-primary center-block" name = "create_new_user" value = "Create New User"/>
		</form>
	<?php
	if(isset($_POST['viewbyrole_button'])) {
		$role_to_view = $_POST['view_by_role'];
		if($role_to_view == 3 || $role_to_view == 4 || $role_to_view == 5 || $role_to_view == 6) {
			$page_role = $role_to_view;
			if(isset($_GET) && isset($_GET['p']) && $_GET['p'] > 0) {
				$range = ($num_per_page*$_GET['p']);
				$user_query = "SELECT * FROM users WHERE typeUser = '$role_to_view' ORDER BY lname ASC, fname ASC LIMIT $range, $num_per_page";
				$next_page = $_GET['p'] + 1;
			}
			else {
				$user_query = "SELECT * FROM users WHERE typeUser = '$role_to_view' ORDER BY lname ASC, fname ASC LIMIT $num_per_page";
				$next_page = 1;
			}
		}
		else {
			//should not get here
			$user_query = "";
		}
	}
	else if (isset($_POST['search_user_button'])) {
		if($_POST['search_by'] == "full_name") {
			if(strpos($_POST['search_user'], " ") !== false) {
				$name = explode(" ", $_POST['search_user']);
				$user_query = "SELECT * from users where fname = '$name[0]' and lname = '$name[1]'";
			}
			else {
				//if no space, assume they just entered the first name
				$assumed_fname = $_POST['search_user'];
				$user_query = "SELECT * from users where fname = '$assumed_fname'";
			}
		}
		else if ($_POST['search_by'] == "account_id") {
			$account_id = $_POST['search_user'];
			$user_query = "SELECT * from users where uid = '$account_id'";
		}
		else if ($_POST['search_by'] == "student_id") {
			$student_id = $_POST['search_user'];
			$user_query = "SELECT * from users u join student s on u.UID = s.uid where s.uid = '$student_id'";
		}
		else if ($_POST['search_by'] == "faculty_id") {
			$faculty_id = $_POST['search_user'];
			$user_query = "SELECT * from users u join faculty f on u.UID = f.uid where f.uid = '$faculty_id'";
		}
		else {
			$user_query = "SELECT * FROM users ORDER BY lname ASC, fname ASC LIMIT $num_per_page";
		}
	}
	else {
		if(isset($_GET) && isset($_GET['r'])) {
			$page_role = $_GET['r'];
			//what page
			if(isset($_GET['p']) && $_GET['p'] > 0) {
				$next_page = $_GET['p'] + 1;
				$range = ($num_per_page*$_GET['p']);
				if($_GET['r'] != "all") {
					$user_query = "SELECT * FROM users WHERE typeUser = '".$_GET['r']."' ORDER BY lname ASC, fname ASC LIMIT $range, $num_per_page";
				}
				else {
					$user_query = "SELECT * FROM users  ORDER BY lname ASC, fname ASC LIMIT $range, $num_per_page";
				}
			}
			//no page, but still have a role
			else {
				$next_page = 1;
				if($_GET['r'] != "all") {
					$user_query = "SELECT * FROM users  WHERE typeUser = '".$_GET['r']."' ORDER BY lname ASC, fname ASC LIMIT $num_per_page";
				}
				else {
					$user_query = "SELECT * FROM users ORDER BY lname ASC, fname ASC LIMIT $num_per_page";
				}
			}
		}
		//don't have role or page, this is just the default "all"
		else {
			$next_page = 1;
			$user_query = "SELECT * FROM users ORDER BY lname ASC, fname ASC LIMIT $num_per_page";
		}
	}

	$all_users = mysqli_query($dbc, $user_query);
	
	if (mysqli_num_rows($all_users) <=  0) {
		echo '<fieldset>';
		echo "No user matches that search.<br>";
	}
	else {
		echo '<table>';
		echo '<th>Name</th>';
		echo '<th>Unique ID</th>';
		echo '<th>Additional Information</th>';
		while($current_user = mysqli_fetch_array($all_users)) {
			$role = $current_user['typeUser'];
			$account_id = $current_user['UID'];
			if ($current_user['fname'] != null) {
				echo '<tr><td>' . $current_user['fname'] . ' ' . $current_user['lname'] . '</td>';
			}
			else {
				echo '<tr><td>  ' . $current_user['username'] . ' (No name inputted)</td>';
			}
			//display student/faculty/account id depending on the user
			if($current_user['typeUser'] == 5) {
				$get_student_query = mysqli_query($dbc, "select * from student where uid = '$account_id'");
				$get_student_id = mysqli_fetch_array($get_student_query);
				$student_id = $get_student_id['uid'];
				//make student id 8 digits
				$student_id = str_pad($student_id, 8, "0", STR_PAD_LEFT);
				echo '<td>Student ID: '.$student_id .'</td>';
				echo "<td><a href = './person.php?s_id=$student_id'>View/Edit Personal Information</a> </td>";
			}
			else if($current_user['typeUser'] == 6) {
				$get_faculty_query = mysqli_query($dbc, "select * from faculty where uid = '$account_id'");
				$get_faculty_id = mysqli_fetch_array($get_faculty_query);
				$faculty_id = $get_faculty_id['uid'];
				//make faculty id 8 digits
				$faculty_id = str_pad($faculty_id, 8, "0", STR_PAD_LEFT);
				echo '<td>Faculty ID: '.$faculty_id .'</td>';
				echo "<td><a href = './person.php?f_id=$faculty_id'>View/Edit Personal Information</a> </td>";
			}
			else {
				$account_id_display = str_pad($account_id, 8, "0", STR_PAD_LEFT);
				echo '<td>Account ID: '.$account_id_display.'</td>';
				echo "<td><a href = './person.php?a_id=$account_id'>View/Edit Personal Information</a> </td>";
			}
			echo '<tr>';
		}
		echo '</table><br>';
		if(isset($next_page)) {
			if($page_role == "all") {
				$total_query = "SELECT COUNT(*) AS total FROM users";
			}
			else {
				$total_query = "SELECT COUNT(*) AS total FROM users WHERE typeUser = '$page_role'";
			}
			$total_data = mysqli_query($dbc, $total_query);
			$total_row = mysqli_fetch_array($total_data);

			if ($total_row['total'] > $num_per_page*$next_page) {
				echo "<center><a href = './users.php?r=$page_role&p=$next_page'>Next Page</a></center><br>";
			}
			if($next_page > 2) {
				$prev_page = $next_page - 2;
				echo "<center><a href = './users.php?r=$page_role&p=$prev_page'>Previous Page</a></center><br>";
			}
			else if ($next_page == 2) {
				//echo "hello?";
				if($page_role != "all") {
					echo "<center><a href = './users.php?r=$page_role'>Previous Page</a></center><br>";
				}
				else {
					echo "<center><a href = './users.php'>Previous Page</a></center><br>";

				}
			}
		}

	}
}
echo '</div>';
?>
