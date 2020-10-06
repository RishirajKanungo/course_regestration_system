<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Personal Information';
require_once('header.php');
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(empty($_SESSION['typeUser'])) {
	//not logged in
	$home_url = 'logout.php';
    header('Location: ' . $home_url);
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<html>
<head>
    <title> Application </title>
    <link rel="stylesheet" type="text/css" href="../apps/portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
</style>
<body>
<br>
<?php
$pass_err = $fname_err = $lname_err = $email_err = $major_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //if logged in as gs/sysadmin
    $valid_input = false;
    if(!empty($_POST['submit'])) {
        $password = $fname = $lname = $email = $major = "";
        $valid_input = true;
        if(empty($_POST['password'])) {
            $pass_err = "Password is required";
            $valid_input = false;
        }
        else {
            //restriction on password?
            $password = $_POST['password'];
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
                $fname_err = "First name is too long - make sure it's less than 33 characters.";
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
                $lname_err = "Email is too long - make sure it's less than 51 characters.";
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
                        $email_err = "Sorry, that email is already taken!";
                        $valid_input = false;
                    }
                    else if(mysqli_num_rows($email_query) == 1) {
                        $email_data = mysqli_fetch_array($email_query);
                        if($email_data['username'] != $_POST['username']) {
                            $email_err = "Sorry, that email is already taken.";
                            $valid_input = false;
                        }
                    }
		} 
                }
            }
        }
        if($_SESSION['typeUser'] == 5) {
		//student-specific check
            if(!empty($_POSt['major'])) {
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
        }
        if($valid_input) {
            echo "<center>Your updates have been completed.</center> <br>";
            $uquery = "UPDATE users SET password = '$password', fname = '$fname', lname = '$lname', email = '$email' WHERE UID = '".$_SESSION['uid']."'";
            mysqli_query($dbc, $uquery);
	    if($_SESSION['typeUser'] == 5) {
		$major = $_POST['major'];
                $squery = "UPDATE student SET major = '$major' WHERE uid = '".$_SESSION['uid']."'";
                mysqli_query($dbc, $squery);
            }
            else if ($_SESSION['typeUser'] == 6) {
                //update the database -- nothing faculty specific
            }
        }
    
}
if (($_SESSION['typeUser'] == 5) || ($_SESSION['typeUser'] == 6)) {
    // retrieve the information from the account with the id specified
    $query = "SELECT * FROM users WHERE UID = '" . $_SESSION['uid'] . "'";
    $data = mysqli_query($dbc, $query);
	// makes sure the query was valid
	if (mysqli_num_rows($data) == 1) { 
        $row = mysqli_fetch_array($data);
        ?>
        
        <div class="container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h4>Personal Information</h4><br>
            <div class="form-row">
                <div class="col">
                    <label for="username">Username: </label>
                    <input disabled type="text" name="username" class="form-control form-group" value="<?php echo $row['username']; ?>"/>
                    <input type="hidden" name="username" class="form-control form-group" value="<?php echo $row['username']; ?>"/>
                </div>
                <div class="col">
                    <label for="password">Password: *</label>
                    <input type="text" name="password" class="form-control form-group" value="<?php echo $row['password'] ?>"/>
                    <span class="error"><?php echo $pass_err?></span>
                </div>
                <div class="col">
                    <label for="fname">First Name: *</label>
                    <input type="text" name="fname" class="form-control form-group" value="<?php echo $row['fname'] ?>" />
                    <span class="error"><?php echo $fname_err?></span>
                </div>
                <div class="col">
                    <label for="lname">Last Name: *</label>
                    <input type="text" name="lname" class="form-control form-group" value="<?php echo $row['lname'] ?>" />
                    <span class="error"><?php echo $lname_err?></span>
                </div>
                <div class="col">
                    <label for="email">Email: *</label>
                    <input type="text" name="email" class="form-control form-group" value="<?php echo $row['email'] ?>" />
                    <span class="error"><?php echo $email_err?></span>
                </div>
            </div>
        <?php
    }
    if($_SESSION['typeUser'] == "5") {
        $squery = "SELECT * FROM student s JOIN users u ON s.uid = u.UID WHERE u.UID = '" . $_SESSION['uid'] . "'";
        $sdata = mysqli_query($dbc, $squery);
	    // makes sure the query was valid
	    if (mysqli_num_rows($sdata) == 1) { 
            $srow = mysqli_fetch_array($sdata);
            $s_id = str_pad($srow['uid'], 8, "0", STR_PAD_LEFT);
?>
            <h4>Degree Information</h4><br>
            <div class="form-row">
                <div class="col">
                    <label for="studentid">Student ID: </label>
                    <!--<td><b><?php echo $s_id ?></b><br/></td>-->
                    <input disabled type="text" id="student_id" name="student_id" class="form-control form-group" value="<?php echo $srow['uid']; ?>"/>
                    <input type="hidden" id="student_id" name="student_id" class="form-control form-group" value="<?php echo $srow['uid']; ?>"/>
                </div>
                <div class="col">
                    <label for="degree">Degree: </label>
                    <input disabled type="text" id="degree" name="degree" class="form-control form-group" value="<?php echo $srow['degree'] ?>"/>
                    <input type="hidden" id="degree" name="degree" class="form-control form-group" value="<?php echo $srow['degree'] ?>"/>
                </div>
                <div class="col">
                    <label for="admityear">Admit Year: </label>
                    <input disabled type="text" id="admityear" name="admityear" class="form-control form-group" value="<?php echo $srow['admit_year'] ?>"/>
                    <input type="hidden" id="admityear" name="admityear" class="form-control form-group" value="<?php echo $srow['admit_year'] ?>"/>
                </div>
                <div class="col">
                    <label for="major">Major: </label>
                    <input type="text" name="major" id="major" name="major" class="form-control form-group" value="<?php echo $srow['major'] ?>" />
                    <span class="error"><?php echo $major_err?></span>
                </div>
            </div>
            <?php
        }
    }
    else if($_SESSION['typeUser'] == 6) {
        $fquery = "SELECT * FROM faculty f JOIN users u ON f.uid = u.UID WHERE u.UID = '" . $_SESSION['uid'] . "'";
        $fdata = mysqli_query($dbc, $fquery);
	    // makes sure the query was valid
	    if (mysqli_num_rows($fdata) == 1) { 
            $frow = mysqli_fetch_array($fdata);
            ?>
            <div class="form-row">
                <div class="col">
                    <label for="facultyid">Faculty ID: </label>
                    <!--<td><b><?php echo $frow['uid'] ?></b></td>-->
                    <input disabled type="text" id="faculty_id" name="student_id" class="form-control form-group" value="<?php echo $frow['uid']; ?>"/>
                </div>
            </div>
            <?php 
        }
    }   
}
else {
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
?>
<div class="form-row">
    <div class="col" align="right">
       <input type="submit" class="btn btn-primary center-block" name = "submit" value="Update">
    </div>
</div>
</form>
</div>
</body>
</html>
