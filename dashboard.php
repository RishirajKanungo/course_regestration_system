<!-- database connection -->
<?php 
    // Start the session
    session_start();

    // Include db connection vars 
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html>
<head>
    <title> Applicant Portal </title>
    <link rel="stylesheet" type="text/css" href="apps/portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<style>
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
input[type=button] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=button]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
a[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
a[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
table {
    margin-bottom: 50px;
}
.bg {
    background-image: url('images/hero.jpg');
    height: 100%;
}
.bgw {
    background-color: white;
}
body, html {
    height:100%;
}

}
</style>

<?php
// Set type user of logged in user session var 
$typeUser = $_SESSION['typeUser']; 

// Set UID of logged from user session var 
$uid = $_SESSION['uid']; 
$_SESSION['user_id'] = $_SESSION['uid'];
$_SESSION['acc_type'] = $_SESSION['typeUser'];

if (isset($_SESSION['user_id'])) {
	if (isset($_SESSION['acc_type'])){
			echo '<div class="bg">';
			echo '<div style="padding-top: 50px;" class="container">';
			echo '<h4 style="font-weight: bold; color: white;" align="center">Dashboard</h4>';
			if($_SESSION['acc_type'] == 5){ //Student
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Advising</th>';
				//echo '<tr><td>Currently signed in as:<b> Student</b></td></tr><tr></tr>';
				echo '<tr><td><a href="ads/info.php" style="color:black;"> View/Edit Personal Information</a></td></tr>';
				echo '<tr><td><a href="ads/form1.php" style="color:black;">Fill Out Form One</a></td></tr>';
				echo '<tr><td><a href="ads/gradapp.php" style="color:black;">Apply For Graduation</a></td></tr>';
				echo '</table></div>';

				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Registration</th>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/personalinfo.php">Personal Information</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/registration.php">Registration</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/schedule.php">Schedule</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/transcript.php">Transcript</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/courses.php">Course Catalog</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/sections.php">Sections</a></td></tr>';
				echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 0){ //Applicant
				echo '<div class="bgw"><table>';
				
				echo '</table></div>';
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Applications</th>';
				echo '<tr><td><a href="apps/applicant.php" style="color:black;">Check Applications</a></td></tr>';
                                echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 1){ //Faculty reviewer
				echo '<div class="bgw"><table>';
				
				echo '</table></div>';
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Applications</th>';
				echo '<tr><td><a href="apps/reviewer.php" style="color:black;">Check Applications</a></td></tr>';
                                echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 8){ //Alumni
				echo '<div class="bgw"><table>';
				echo '<tr><td><a href="ads/transcript.php" style="color:black;">View Transcript</a></td></tr>';
				echo '<tr><td><a href="ads/info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
				echo '</table></div>';
                                
                                echo '<div class="bgw"><table>';
                                echo '<th class="text-center">Advising</th>';
                                echo '</table></div>';  
			}
			else if($_SESSION['acc_type'] == 6){ //Faculty advisor
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Advising</th>';
				echo '<tr><td><a href="ads/gradstatus.php" style="color:black;">Check Advisee Graduation Status</a></td></tr>';
				echo '<tr><td><a href="ads/transcript.php" style="color:black;">Show Advisees Transcripts</a></td></tr>';
				echo '<tr><td><a href="ads/viewform1.php" style="color:black;">Check Advisees Form1s</a></td></tr>';
				echo '<tr><td><a href="ads/form1approval.php" style="color:black;">Approve Form Ones</a></td></tr>';
				echo '<tr><td><a href="ads/thesisapproval.php" style="color:black;">Approve PhD Theses</a></td></tr>';
				echo '<tr><td><a href="ads/advisees.php" style="color:black;">Show Advisees</a></td></tr>';
				echo '<tr><td><a href="ads/info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
				echo '</table></div>';
                                
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Apps</th>';
				echo '<tr><td><a href="apps/reviewer.php" style="color:black;">Check Applications</a></td></tr>';
                                echo '</table></div>';
                                
                                echo '<div class="bgw"><table>';
				echo '<th class="text-center">Registration</th>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/personalinfo.php">Personal Information</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/advisee.php">Advisees</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/users.php">Users</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/classes.php">Classes</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/courses.php">Course Catalog</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/sections.php">Sections</a></td></tr>';
                                echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 3){ //Grad Secretary
				echo '<div class="bgw"><table>';
				
				echo '</table></div>';
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Applications</th>';
				echo '<tr><td><a href="apps/reviewer.php" style="color:black;">Check Applications</a></td></tr>';
                                echo '</table></div>';
                                
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Advising</th>';
				echo '<tr><td><a href="ads/gradstatus.php" style="color:black;">Check Graduation Status</a></td></tr>';
				echo '<tr><td><a href="ads/transcript.php" style="color:black;">View Transcipts</a></td></tr>';
				echo '<tr><td><a href="ads/form1approval.php" style="color:black;">View Form Ones</a></td></tr>';
				echo '<tr><td><a href="ads/gradapproval.php" style="color:black;">Approve Graduation Applications</a></td></tr>';
				echo '<tr><td><a href="ads/assignadvisor.php" style="color:black;">Assign Faculty Advisors</a></td></tr>';
				echo '<tr><td><a href="ads/info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
                                echo '</table></div>';
                                
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Registration</th>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/users.php">Users</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/courses.php">Course Catalog</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/sections.php">Sections</a></td></tr>';
				echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 4){	//Sys Admin
				echo '<div class="bgw"><table>';
				echo '<tr><td><a href="ads/createnewuser.php" style="color:black;">Create New User</a></td></tr>';
				echo '<tr><td><a href="ads/transcript.php" style="color:black;">View Transcipts</a></td></tr>';
				echo '<tr><td><a href="ads/gradstatus.php" style="color:black;">Check Graduation Status</a></td></tr>';
				echo '<tr><td><a href="ads/form1approval.php" style="color:black;">Approve Form Ones</a></td></tr>';
				echo '<tr><td><a href="ads/thesisapproval.php" style="color:black;">Approve PhD Theses</a></td></tr>';
				echo '<tr><td><a href="ads/gradapproval.php" style="color:black;">Approve Graduation Applications</a></td></tr>';
				echo '<tr><td><a href="ads/assignadvisor.php" style="color:black;">Assign Faculty Advisors</a></td></tr>';
				echo '<tr><td><a href="ads/info.php" style="color:black;">View/Edit Personal Information</a></td></tr>';
				echo '</table></div>';
                                
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Advising</th>';
                                echo '</table></div>';
                                
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Registration</th>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/users.php">Users</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/courses.php">Course Catalog</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/sections.php">Sections</a></td></tr>';
                                echo '</table></div>';
			}
			else if($_SESSION['acc_type'] == 7) {   //Registrar
				echo '<div class="bgw"><table>';
				echo '<th class="text-center">Registration</th>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/users.php">Users</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/courses.php">Course Catalog</a></td></tr>';
				echo '<tr><td><a style="color:black;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/regs/sections.php">Sections</a></td></tr>';
				echo '</table></div>';
			}
			echo '</table>';
			echo '</div>';
			echo '</div>';
		}
}
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
