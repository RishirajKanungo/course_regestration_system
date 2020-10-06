<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Faculty Information';
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

if(isset($_GET["f_id"])) {
    $faculty_id = $_GET["f_id"];
    $fquery = "SELECT * FROM faculty f JOIN users u ON f.uid = u.UID WHERE f.uid = '$faculty_id'";
    $fdata = mysqli_query($dbc, $fquery);
    if(mysqli_num_rows($fdata) != 1) {
        echo "<center> This faculty doesn't exist. If you think this is an error, please contact the System Administrator.</center><br>";
    }
    else {
        $frow = mysqli_fetch_array($fdata);
        if($_SESSION['typeUser'] == 5 || $_SESSION['typeUser'] == 6 || $_SESSION['typeUser'] == 3) {            
            $home_url = 'index.php';
            header('Location: ' . $home_url);
        }
        else if ($_SESSION['typeUser'] == 4) {
            $username_err = $pass_err = $fname_err = $lname_err = $email_err = $phone_err = "";
            $f_id = $frow['uid'];
            if(isset($_POST)) {
                if(isset($_POST['delete'])) {
                    //get account_id first
                    $a_id_query = "SELECT * from users u JOIN faculty f ON u.UID = f.uid WHERE f.uid = '$f_id'";
                    $a_id_data = mysqli_query($dbc, $a_id_query);
                    $a_id_row = mysqli_fetch_array($a_id_data);
                    $a_id = $a_id_row['uid'];

                    //1. change their sections to f_id = NULL 2. delete from faculty 3. delete from account
                    $sections_query = "SELECT * FROM section WHERE f_id = '$f_id'";
                    $sections_data = mysqli_query($dbc, $sections_query);
                    while($section_row = mysqli_fetch_array($sections_data)) {
                        $sec_id = $section_row['uid'];
                        mysqli_query($dbc, "UPDATE section SET f_id = NULL WHERE uid = '$sec_id'");
                    }
                    mysqli_query($dbc, "DELETE from faculty where uid = '$f_id'");
                    mysqli_query($dbc, "DELETE from users where uid = '$a_id'");
                }
                if(isset($_POST['submit'])) {
                    $new_username = $password = $fname = $lname = $email = $phone = "";
                    $valid_input = true;

                    if(empty($_POST['username'])) {
                        $username_err = "Username is required";
                        $valid_input = false;
                    } 
                    else {
                        //username must be longer than 2 digits, less than 33 digits, and contain at least one letter - uppercase gets converted to lower case
                        $new_username = strtolower(test_input($_POST['username']));
                        if($new_username != $frow['username']) {
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
                        else {
                            
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
                                if($email != $frow['email']) {
                                    $email_query = mysqli_query($dbc, "select * from users where email = '$email'");
                                    if(mysqli_num_rows($email_query) > 0) {
                                        $email_err = "Sorry, that email is already taken.";
                                        $valid_input = false;
                                    }
                                }
                            } 
                        }
                    }
                    
                    if($valid_input) {
                        echo "<center>Your updates have been completed</center> <br>";
                        $a_id_query = "SELECT * from users u JOIN faculty f ON u.UID = f.uid WHERE f.uid = '$f_id'";
                        $a_id_data = mysqli_query($dbc, $a_id_query);
                        $a_id_row = mysqli_fetch_array($a_id_data);
                        $a_id = $a_id_row['uid'];
                        //update faculty info
                        $fquery = "UPDATE users SET username = '$new_username', password = '$password', fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$a_id'";
                        mysqli_query($dbc, $fquery);
                    }
                    else {
                        echo "<center> Your updates could not be completed. </center> <br>";
                    }
                }
            }
            //get updated information
            $fquery = "SELECT * FROM faculty f JOIN users u ON f.uid = u.UID WHERE f.uid = '$faculty_id'";
            $fdata = mysqli_query($dbc, $fquery);
            if(mysqli_num_rows($fdata) < 1 || mysqli_num_rows($fdata) > 1) {
                //uhh yikes
                echo "<center>This faculty member does not exist. </center><br>";
            }
            else {
                $frow = mysqli_fetch_array($fdata);
                $eight_digit_f_id = str_pad($f_id, 8, "0", STR_PAD_LEFT);
                $url = $_SERVER['PHP_SELF']."?f_id=".$f_id;
?>
		<br>
		<div class="container">
                <form method="post" action="<?php echo $url; ?>">
                <h4>Faculty Personal Information</h4>
                <div class="form-row">
                <div class="col">
                    <label>Faculty ID: </label>  
                    <input disabled type="text" class="form-control form-group" value="<?php echo $eight_digit_f_id ?>"/>
                </div>
                <div class="col">
                    <label>Username: </label>
                    <input type="text" name="username" class="form-control form-group" value="<?php echo $frow['username'] ?>" />
                    <span class="error"><?php echo $username_err?></span>
                </div>
                <div class="col">
                    <label>Password: </label>
                    <input type="text" name="password" class="form-control form-group" value="<?php echo $frow['password'] ?>" />
                    <span class="error"><?php echo $pass_err?></span>
		</div>
		</div>
		<div class="form-row">
                <div class="col">
                    <label>First Name: </label>
                    <input type="text" name="fname" class="form-control form-group" value="<?php echo $frow['fname'] ?>" />
                    <span class="error"><?php echo $fname_err?></span>
                </div>
                <div class="col">
                    <label>Last Name: </label>
                    <input type="text" name="lname" class="form-control form-group" value="<?php echo $frow['lname'] ?>" />
                    <span class="error"><?php echo $lname_err?></span>
                </div>
                <div class="col">
                    <label>Email: </label>
                    <input type="text" name="email" class="form-control form-group" value="<?php echo $frow['email'] ?>" />
                    <span class="error"><?php echo $email_err?></span>
		</div>
		</div>
           		<input type="submit" style="float:right;" class="btn btn-primary center-block" name = "submit" value="Update"/>
                    	<input type="submit" style="float:right; margin-right:50px;" class="btn btn-primary center-block" name = "delete" value = "Delete Faculty"/>
		</form>
		</div>
                <?php
                //add anything else? display what courses they're teaching? teach another course? idk
            }
        }
        else {
            $home_url = 'index.php';
            header('Location: ' . $home_url);
        }
    }
}
else {
    if($_SESSION['role'] == "systemadmin") {
        echo "<center> This faculty doesn't exist.</center><br>";
    }
    else {
        $home_url = 'index.php';
        header('Location: ' . $home_url);
    }
}
?>
