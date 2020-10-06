<?php
//FIXME: regex for lname is straight up broken
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Student Information';
require_once('header.php');
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../apps/portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<style>
input[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
}
input[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
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
</style>
<br>
<?php
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if(empty($_SESSION['typeUser'])) {
	//not logged in
	$home_url = 'logout.php';
    header('Location: ' . $home_url);	
}
else if($_SESSION['typeUser'] == 5) {
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
else if ($_SESSION['typeUser'] == 7 || $_SESSION['typeUser'] == 6 || $_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 3) {
    //figure out which student this is
    if(isset($_GET["s_id"]))
    {
    	//$street_address = $new_username = $password = $fname = $lname = $email = $major = $degree = $student_id = "";
	$username_err = $pass_err = $fname_err = $lname_err = $email_err = $street_address_err = $major_err = $degree_err = $grade_err = "";
        $student_id = $_GET["s_id"];
        if ($_SESSION['typeUser'] == 6) {

            //if the faculty are teaching this student
            $f_id = $_SESSION['uid'];
    
            $squery = "SELECT * from users u JOIN student s ON u.UID = s.uid JOIN transcript t ON s.uid = t.uid JOIN section se ON se.uid = t.sec_id JOIN courses c ON t.cno = c.uid WHERE s.uid = '$student_id' AND se.f_id = '$f_id'";
            $sdata = mysqli_query($dbc, $squery);
	    
	    $squery = "SELECT * from users u JOIN student s ON u.UID = s.uid WHERE s.uid = '$student_id'";
            $sdata = mysqli_query($dbc, $squery);
            $srow = mysqli_fetch_array($sdata);
                
            $advisor = $srow['advisor'];
            $fquery = "SELECT * FROM users WHERE UID = '$advisor'";
            $fdata = mysqli_query($dbc, $fquery);   
	    
	    $check_in_class_query = "SELECT * FROM transcript t, section s WHERE s.f_id = '$f_id' AND s.uid = t.sec_id AND t.uid = '$student_id'";
	    $ccdata = mysqli_query($dbc, $check_in_class_query);
	    if(mysqli_num_rows($sdata) < 1 && mysqli_num_rows($ccdata) > 0) {
                echo "<center>You are not teaching this student and can't view their information.</center><br>";
            }
            else {
                ?>
		<br>
		<div class="container">
		<h4>Student Personal Information</h4>
		<div class="row">
			<div class="col">First Name: </div>
                    	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['fname'] ?>"/></div>                
		</div>
		<div class="row">
                        <div class="col">Last Name: </div>
                   	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['lname'] ?>"/></div>                 
                </div>
                <div class="row">
                        <div class="col">Email: </div>
                    	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['email'] ?>"/></div>                 
                </div>
                <div class="row">
                        <div class="col">Degree: </div>
                    	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['degree'] ?>"/></div>
                </div>
                <div class="row">
                        <div class="col">Admit Year: </div>
                    	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['admit_year'] ?>"/></div>
                </div>
                <div class="row">
                        <div class="col">Major: </div>
                    	<div class="col-10"><input disabled type="text" class="form-control form-group" value="<?php echo $srow['major'] ?>"/></div>
                </div>
<?php
		if(mysqli_num_rows($fdata) == 1) {
			$frow = mysqli_fetch_array($fdata);
			echo '<div class="row">';
			echo '<div class="col">Advisor: </div>';
			echo '<div class="col-10"><input disabled type="text" class="form-control form-group" value=' . $frow['fname'] . " " . $frow['lname'] . '/></div>';
			echo '</div>';
		} else {
			echo '<div class="row">';
                        echo '<div class="col">Advisor: </div>';
                        echo '<div class="col-10"><input disabled type="text" class="form-control form-group" value="No Advisor"/></div>';
                        echo '</div>';
		}
		if($advisor == $_SESSION['uid'] || mysqli_num_rows($ccdata) > 0) {
			echo '<div class="row">';
                	echo "<div class='col' align='center'><a href='./transcript.php?s_id=$student_id'>View Transcript</a></strong></div>";
			echo "</div>";
		}
		echo "<br>";
		$test = mysqli_fetch_array($ccdata);
                //show courses enrolled in
                $courses_query = "SELECT * from transcript t JOIN section s ON t.sec_id = s.uid JOIN courses c ON t.cno = c.uid WHERE t.uid = '$student_id'";
                $courses_data = mysqli_query($dbc, $courses_query);
                //shouldn't get here
                if(mysqli_num_rows($courses_data) < 1) {
                    echo "<h4>Not enrolled in any courses.</h4>";
                }
                else {
                    echo "<h4>Currently Enrolled in:</h4><table>";
                    while($courses_row = mysqli_fetch_array($courses_data)) {
                        echo "<tr>";
                        echo "<td>".$courses_row['status']."</td><td>".$courses_row['dept']."".$courses_row['cno']." ".$courses_row['title']."</td><td>Section #".$courses_row['section_num']."</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </table>
                <?php
            }
    
        }
        if($_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 7 || $_SESSION['typeUser'] == 3) {
            if(isset($_POST)) {
                if(isset($_POST['delete']) && $_SESSION['typeUser'] == 4) {
                    //get account_id first
                    $a_id_query = "SELECT * from users u JOIN student s ON u.UID = s.uid WHERE s.uid = '$student_id'";
                    $a_id_data = mysqli_query($dbc, $a_id_query);
                    $a_id_row = mysqli_fetch_array($a_id_data);
                    $a_id = $a_id_row['uid'];

                    //delete everywhere they appear in 1) takes, 2) student, 3) account
                    mysqli_query($dbc, "DELETE from transcript where uid = '$student_id'");
                    mysqli_query($dbc, "DELETE from student where uid = '$student_id'");
                    mysqli_query($dbc, "DELETE from users where uid = '$a_id'");
                }
                if(isset($_POST['submit'])) {                    
                    $new_username = $password = $fname = $lname = $email = $street_address = $major = "";
                    $valid_input = true;

                    if(empty($_POST['new_username'])) {
                        $username_err = "Username is required";
                        $valid_input = false;
                    } 
                    else {
                        //username must be longer than 2 digits, less than 33 digits, and contain at least one letter - uppercase gets converted to lower case
                        $new_username = strtolower(test_input($_POST['new_username']));
                        if($new_username != $_POST['current_username']) {
                            if(ctype_alnum($new_username)) {
                                if(strlen($new_username) <= 32 && strlen($new_username) >= 3 && preg_match("/[a-z]/i", $new_username)) {
                                    $username_query = mysqli_query($dbc, "select * from users where username = '$new_username'");
                                    if(mysqli_num_rows($username_query) > 0) {
                                        $username_err = "Sorry, that username is already taken.";
                                        $valid_input = false;
                                    }
                                }
                                else {
                                    if(strlen($new_username) > 32) {
                                        $username_err = "Username is too long - keep it to less than 33 characters.";
                                    }
                                    else if(strlen($new_username) < 3) {
                                        $username_err = "Username is too short - make sure it's at least 3 characters.";
                                    }
                                    else if(!preg_match("/[a-z]/i", $new_username)) {
                                        $username_err = "Username must have at least one letter.";
                                    }
                                    $valid_input = false;
                                }
                            }
                            else {
                                $username_err = "Only letters/numbers are allowed.";
                                $valid_input = false;
                            }
                        }
                    }

                    if(empty($_POST['password'])) {
                        $pass_err = "Password is required";
                        $valid_input = false;
                    }
                    else {
                        //restriction on password?
                        $password = test_input($_POST['password']);
                        if(strlen($password) < 4) {
                            $pass_err = "Password must be at least 4 characters long.";
                            $valid_input = false;
                        }
                    }
                    if(empty($_POST['fname'])) {
                        $fname_err = "First name is required.";
                        $valid_input = false;
                    }
                    else {
                        $fname = test_input($_POST['fname']);
                        if(strlen($fname) > 32) {
                            $fname_err = "Last name is too long - make sure it's less than 33 characters.";
                            $valid_input = false;
                        }
                        else {
                            $pattern = '/^[a-z ,.\'-]+$/i';
                            if(!preg_match($pattern, $fname)) {
                                $fname_err = "Name contains forbidden special characters (only letters and  ,.'- allowed)";
                                $valid_input = false;
                            }
                        
                        }
                    }
                    if(empty($_POST['lname'])) {
                        $lname_err = "Last name is required.";
                        $valid_input = false;
                    }
                    else {
                        $lname = test_input($_POST['lname']); 
                        if(strlen($lname) > 32) {
                            $lname_err = "Last name is too long - make sure it's less than 33 characters.";
                            $valid_input = false;
                        }
                        else {
                            $pattern = '/^[a-z ,.\'-]+$/i';
                            if(!preg_match($pattern, $lname)) {
                                $lname_err = "Name contains forbidden special characters (only letters and  ,.'- allowed)";
                                $valid_input = false;
                            }
                        }
                    }
                    if(empty($_POST['email'])) {
                        $email_err = "Email is required.";
                        $valid_input = false;
                    }
                    else {
                        $email = test_input($_POST['email']); 
                        if(strlen($email) > 50) {
                            $email_err = "Email is too long - make sure it's less than 51 characters.";
                            $valid_input = false;
                        }
                        else {
                            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $email_err = "Invalid email format";
                                $valid_input = false;
                            }
                            else {
                                //check for unique
                                $email_query = mysqli_query($dbc, "select * from users where email = '$email'");
                                if(mysqli_num_rows($email_query) > 1) {
                                    $email_err = "Sorry, that email is already taken.";
                                    $valid_input = false;
                                }
                                else if(mysqli_num_rows($email_query) == 1) {
                                    $email_data = mysqli_fetch_array($email_query);
                                    if($email_data['username'] != $_POST['current_username']) {
                                        $email_err = "Sorry, that email is already taken.";
                                        $valid_input = false;
                                    }
                                }
                                
                            } 
                        }
                    }
                    if(empty($_POST['street_address'])) {
                        $street_address_err = "Street address is required.";
                        $valid_input = false;
                    }
                    else {
                        $street_address = test_input($_POST['street_address']);
                        $pattern = '/^[a-zA-Z0-9 -.,:]+$/';
                        if(strlen($street_address) > 255) {
                            $street_address_err = "Street address is too long - make sure it's less than 256 characters.";
                            $valid_input = false;
                        }
                        else if(!preg_match($pattern, $street_address)) {
                            $street_address_err = "Street address must only contain letters, numbers, spaces, and these special characters: -.,:";
                            $valid_input = false;
                        } 
                        else if(!((preg_match("/[a-z]/i", $street_address) && preg_match("/[0-9]/i", $street_address)))) {
                            $street_address_err = "Street address must contain at least one letter and one number.";
                            $valid_input = false;
                        }
                    }
                    if(empty($_POST['degree'])) {
                        //would only get here if backend hack
                        $degree_err = "Degree is required.";
                        $valid_input = false;
                    }
                    else {
                        $degree = $_POST['degree'];
                        if($degree !== "MS" && $degree !== "PhD") {
                            $degree_err = "Degree must be MS or PhD.";
			    $valid_input = false;
                        }
                    }
                    //major is not a required field
                    if(!empty($_POST['major'])) {
                        $major = test_input($_POST['major']);
                        if(strlen($major) > 32) {
                            $major_err = "Major is too long - make sure it's less than 33 characters.";
                            $valid_input = false;
                        }
                        else if(!preg_match('/^[a-z .\-]+$/i', $major)) {
                            $major_err = "Major must only contain letters and spaces.";
                            $valid_input = false;
                        }
		    }
                    //check for backend threat on grades
                    foreach($_POST as $info=>$grade) {
                        //update the db with the new grades
                        if (strpos($info, "&") == false) {
                            continue;
                        }
                        if ($grade != "NA" && $grade != "IP" && $grade != "A" && $grade != "A-" && $grade != "B+" && $grade != "B" && $grade != "B-" && $grade != "C+" && $grade != "C" && $grade != "F") {
                            $grade_err = "Grade changes must be entered as one of the following: NA, IP, A, A-, B+, B, B-, C+, C, F.";
                            $valid_input = false;
                        }
		    }	
                    if($valid_input) {
                        echo "<script>alert('Your updates have been completed')</script>";
			
                        $a_id_query = "SELECT * from users u JOIN student s ON s.uid = u.UID WHERE s.uid = '$student_id'";
                        $a_id_data = mysqli_query($dbc, $a_id_query);
                        $a_id_row = mysqli_fetch_array($a_id_data);
                        $a_id = $a_id_row['uid'];

                        $uquery = "UPDATE users SET address='$street_address', username = '$new_username', password = '$password', fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$a_id'";
			mysqli_query($dbc, $uquery);
                        $squery = "UPDATE student SET major = '$major', degree = '$degree' WHERE uid = '$student_id'";
                        mysqli_query($dbc, $squery);
			if($_POST['advisor'] !== "NA") {
				$advisor = $_POST['advisor'];
				$aquery = "UPDATE student SET advisor = '$advisor' WHERE uid = '$a_id'";
				mysqli_query($dbc, $aquery);
			}

                        foreach($_POST as $info=>$grade) {
                            //update the db with the new grades
                            if (strpos($info, "&") == false) {
                                continue;
                            }
                            if($grade != "NA") {
                                $updateTakesInfo = explode ("&", $info);
                                $sec_id = $updateTakesInfo[1];
                                $grade_query = "UPDATE transcript SET grade = '$grade' WHERE sec_id = '$sec_id' AND uid = '$student_id';";
                                mysqli_query($dbc, $grade_query);
                            }
                        } 
                    }  
                }
            }
            //form for administrators about this student
            $squery = "SELECT * from users u JOIN student s ON u.UID = s.uid WHERE s.uid = '$student_id'";
            $sdata = mysqli_query($dbc, $squery);
            if(mysqli_num_rows($sdata) != 1) {
                //uhh yikes
                echo "<center>This student does not exist. Please contact the System Administrator if you think there is a mistake.</center><br>";
            }
            else {
                $srow = mysqli_fetch_array($sdata);
                $s_id = str_pad($srow['uid'], 8, "0", STR_PAD_LEFT);
                $url = $_SERVER['PHP_SELF']."?s_id=".$student_id;
                ?> 
                <form method="post" action="<?php echo $url; ?>">
		<div class="container">
		<h4>Student Personal Information</h4>
                <div class="row">
		<div class="col">
			<label for="studentid">Student ID: </label>
			<input disabled type="text" class="form-control form-group" value="<?php echo $s_id ?>"/>
                </div>
                <div class="col">
                    	<label for="username">Username:</label>
                    	<input type="text" name="new_username" class="form-control form-group" value="<?php echo $srow['username'] ?>" />
                    	<input type="hidden" id="current_username" name="current_username" value="<?php echo $srow['username']; ?>"/>
                    	<span class="error"><?php echo $username_err?></span>
                </div>
                <div class="col">
                  	<label for="password">Password:</label>
                    	<input type="text" name="password" class="form-control form-group" value="<?php echo $srow['password'] ?>" />
                    	<span class="error"><?php echo $pass_err?></span>
		</div>
		</div>
		<div class="row">
                <div class="col">
                    	<label for="fname">First Name: </label>
                    	<input type="text" name="fname" class="form-control form-group" value="<?php echo $srow['fname'] ?>" />
                    	<span class="error"><?php echo $fname_err?></span>
                </div>
                <div class="col">
                    	<label for="lname">Last Name: </label>
                    	<input type="text" name="lname" class="form-control form-group" value="<?php echo $srow['lname'] ?>" />
                    	<span class="error"><?php echo $lname_err?></span>
		</div>
		</div>
		<div class="row">
                <div class="col">
                    	<label for="email">Email: </label>
                    	<input type="text" name="email" class="form-control form-group" value="<?php echo $srow['email'] ?>" />
                    	<span class="error"><?php echo $email_err?></span>
                </div>
                <div class="col">
                    	<label for="saddress">Address: </label>
                    	<input type="text" name="street_address" class="form-control form-group" value="<?php echo $srow['address'] ?>" />
                    	<span class="error"><?php echo $street_address_err?></span>
		</div>
		</div>
		<div class="row">
                <div class="col-md-1">
                    	<label for="degree">Degree: </label><br>
<?php if($srow['degree']  === "MS") { ?>
                   	<select id = "degree" name = "degree">
		                <option value ="MS">MS</option>
		                <option value ="PhD">PhD</option>
			</select>
<?php } else { ?>
			<select id = "degree" name = "degree">
                                <option value ="PhD">PhD</option>
                                <option value ="MS">MS</option>
			</select>
<?php } ?>
			<span class="error"><?php echo $degree_err?></span>
                </div>
                <div class="col">
                    	<label for="year">Admit Year: </label>
                    	<input disabled type="text"  class="form-control form-group" value="<?php echo $srow['admit_year'] ?>"/>
                </div>
                <div class="col">
                    	<label for="major">Major: </label>
                    	<input type="text" name="major"  class="form-control form-group" value="<?php echo $srow['major'] ?>" />
                   	<span class="error"> <?php echo $major_err?></span>
		</div>
		</div>
                <?php
                echo "<div class='row'>";
                echo "<div class='col' align='center'><a href = './transcript.php?s_id=$student_id'>View Transcript</a></div>";
		echo "</div>";
		$fac_id = $srow['advisor'];
		$get_fac_query = "SELECT * FROM users u WHERE u.uid = '$fac_id'";
		$fac_data = mysqli_query($dbc, $get_fac_query);
		$f_row = mysqli_fetch_array($fac_data);
?>		
		<h4>Mentor</h4>
                <div class='form-row'>
                <div class='col'>
			<label for="advisor">Advisor: </label>
			<input disabled type="text" name="advisortext" class="form-control form-group" value="<?php echo $f_row['fname'] . " " . $f_row['lname'] ?>"/>

<?php if($_SESSION['typeUser'] == 3) { ?>
			<label>Change to: </label>
			<select id="advisor" name="advisor">
<?php
		if(mysqli_num_rows($fac_data) < 1) {
			echo '<option value="NA">No advisor</option>';
		} else {
			echo '<option value="' . $f_row['UID'] . '">' . $f_row['fname'] . " " . $f_row['lname']. '</option>';
		}
		$get_all_fac_query = "SELECT * FROM faculty f, users u WHERE f.uid = u.UID ORDER BY fname ASC, lname ASC";
		$all_fac_data = mysqli_query($dbc, $get_all_fac_query);
		while($fac_row = mysqli_fetch_array($all_fac_data)) {
			if($f_row['UID'] == $fac_row['UID']) {
				continue;
			}
			echo '<option value="' . $fac_row['UID'] . '">' . $fac_row['fname'] . " " . $fac_row['lname']. '</option>';
		}
?>
			</select>    

<?php } ?>
                </div>
                </div>
		<br>
<?php
                //show courses (allow to update grades)
                $courses_query = "SELECT t.uid AS suid, s.uid AS seuid, t.*, s.*, c.* from transcript t JOIN section s ON t.sec_id = s.uid JOIN courses c ON s.c_id = c.uid WHERE t.uid = '$student_id'";
                $courses_data = mysqli_query($dbc, $courses_query);
                if(mysqli_num_rows($courses_data) < 1) {
                    echo "<h4>Not enrolled in any courses.</h4>";
                }
                else {
                    echo "<h4>Currently Enrolled in:</h4>";
                    echo "<table>";
                    while($courses_row = mysqli_fetch_array($courses_data)) {
			    echo "<tr>";
			    echo "<td>".$courses_row['status']."</td>";
                        echo "<td>".$courses_row['dept']." ".$courses_row['cno']."</td>";
                        echo "<td>Current Grade: ".$courses_row['grade']."</td>";
			if($_SESSION['typeUser'] == 3) {
			?>
                            <td><select id = "grade" name = "<?php echo ''.$courses_row['suid'].'&'.$courses_row['seuid'] ?>">
                                <option value = "NA">No Change</option>
                                <option value = "IP">IP</option>
                                <option value = "A">A</option>
                                <option value = "A-">A-</option>
                                <option value = "B+">B+</option>
                                <option value = "B">B</option>
                                <option value = "B-">B-</option>
                                <option value = "C+">C+</option>
                                <option value = "C">C</option>
                                <option value = "F">F</option>
                            </select>
                            <span class="error"><?php echo $grade_err?></td>
			<?php
			}
                        echo "</tr>";
                    }
                }
                ?>
		</table>
		<br>
		<input type="submit" style="float: right;" class="btn btn-light btn-lg" name = "submit" value="Update">
                <?php
                if($_SESSION['typeUser'] == 4) {
                    echo "<input type='submit' style='float: right; margin-right:50px;' class='btn btn-light btn-lg' name='delete' value = 'Delete Student'></td>";
                }
                ?>
                </div></form>
                <?php
            }    
        }
    }
    else {
        echo "<center>Sorry, this student doesn't exist</center><br>";
    }
}
?>
