<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Student Information';
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
if (isset($_GET)) {
    //sanity check - probably shouldn't get to f_id or s_id being set
    if (isset($_GET['f_id'])) {
        $home_url = 'faculty.php?f_id='.$_GET['f_id'];
        header('Location: ' . $home_url);
    }
    else if (isset($_GET['s_id'])) {
        $home_url = 'student.php?s_id='.$_GET['s_id'];
        header('Location: ' . $home_url);
    }
    else if (isset($_GET['a_id'])) {
        //figure out who they are
        $a_id = $_GET['a_id'];
        $aquery = "SELECT * FROM users WHERE uid = '$a_id'";
        $adata = mysqli_query($dbc, $aquery);
        if (mysqli_num_rows($adata) != 1) {
            echo "<center> This user doesn't exist. Please contact the System Administrator if you think this is a mistake.</center><br>";
        }
        else {
            $arow = mysqli_fetch_array($adata);
            if ($arow['typeUser'] == 5) {
                $squery = "SELECT * FROM users u JOIN student s ON u.uid = s.uid WHERE u.uid = '$a_id'";
                $sdata = mysqli_query($dbc, $squery);
                if(mysqli_num_rows($sdata) != 1) {
                    $home_url = 'student.php';
                    header('Location: ' . $home_url);
                }
                else {
                    $srow = mysqli_fetch_array($sdata);
                    $home_url = 'student.php?s_id='.$srow['uid'];
                    header('Location: ' . $home_url);
                }
            }
            else if ($arow['typeUser'] == 6) {
                $fquery = "SELECT * FROM users u JOIN faculty f ON u.uid = f.uid WHERE u.uid = '$a_id'";
                $fdata = mysqli_query($dbc, $fquery);
                if(mysqli_num_rows($fdata) != 1) {
                    $home_url = 'faculty.php';
                    header('Location: ' . $home_url);
                }
                else {
                    $frow = mysqli_fetch_array($fdata);
                    $home_url = 'faculty.php?f_id='.$frow['faculty_id'];
                    header('Location: ' . $home_url);
                }
            }
            else if ($arow['typeUser'] == 3 || $arow['typeUser'] == 4) {
                if($_SESSION['typeUser'] == 3) {
                    $home_url = 'index.php';
                    header('Location: ' . $home_url);
                }
                //only systemadmin can see
                else if($_SESSION['typeUser'] == 4) {
                    $username_err = $pass_err = $fname_err = $lname_err = $email_err = "";
                    $a_id = $arow['UID'];
                    $eight_digit_a_id = str_pad($a_id, 8, "0", STR_PAD_LEFT);
                    if(isset($_POST['delete'])) {
                        //delete from account
                        $dquery = "DELETE FROM user WHERE uid = '$a_id'";
                        mysqli_query($dbc, $dquery);
                    }
                    if(isset($_POST['submit'])) {
                        $new_username = $password = $fname = $lname = $email = "";
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
                                $fname_err = "First name is too long - make sure it's less than 33 characters.";
                                $valid_input = false;
                            }
                            else {
                                $pattern = '/^[a-z ,.\'-]+$/i';
                                if(!preg_match($pattern, $fname)) {
                                    $lname_err = "Name contains forbidden special characters (only letters and  ,.'- allowed)";
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

                        if($valid_input) {
                            echo "<center>Your updates have been completed</center> <br>";
                            //update info
                            $uquery = "UPDATE users SET username = '$new_username', password = '$password', fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$a_id'";
                            mysqli_query($dbc, $uquery);
                        }
                    }
                    //get updated information
                    $aquery = "SELECT * FROM users WHERE uid = '$a_id'";
                    $adata = mysqli_query($dbc, $aquery);
                    if(mysqli_num_rows($adata) < 1 || mysqli_num_rows($adata) > 1) {
                        //uhh yikes
                        echo "<center>This account does not exist.</center><br>";
                    }
                    else {
                        $arow = mysqli_fetch_array($adata);
                        $eight_digit_a_id = str_pad($a_id, 8, "0", STR_PAD_LEFT);
                        $url = $_SERVER['PHP_SELF']."?a_id=".$a_id;
?>
			<div class="container">
                        <form method="post" action="<?php echo $url; ?>">
                        <h4>Personal Information</h4>
                        <div class="form-row">
                        <div class="col">
                            <label>Account ID: </label>
			    <input disabled type="submit"? class="form-control form-group" value="<?php echo $eight_digit_a_id ?>"/>
                        </div>
                        <div class="col">
                            <label>Role: </label>
                            <?php if($arow['typeUser'] == 3) echo '<input disabled type="submit"? class="form-control form-group" value= "Graduate Secretary">';
                                        else if($arow['typeUser'] == 4) echo '<input disabled type="submit"? class="form-control form-group" value= "System Administrator">'; ?>
			</div>
			</div>
			<div class="form-row">
                        <div class="col">
                            <label>Username: </label>
                            <input type="text" name="new_username" class="form-control form-group" value="<?php echo $arow['username'] ?>" />
                            <input type="hidden" id="current_username" name="current_username" value="<?php echo $arow['username']; ?>">
                            <span class="error"><?php echo $username_err?></span>
                        </div>
                        <div class="col">
                            <label>Password: </label>
                            <input type="text" name="password" class="form-control form-group" value="<?php echo $arow['password'] ?>" />
                            <span class="error"><?php echo $pass_err?></span>
			</div>
			</div>
			<div class="form-row">            
			<div class="col">
                            <label>First Name: </label>
                            <input type="text" name="fname" class="form-control form-group"  value="<?php echo $arow['fname'] ?>" />
                            <span class="error"> <?php echo $fname_err?></span>
                        </div>
                        <div class="col">
                            <label>Last Name: </label>
                            <input type="text" name="lname" class="form-control form-group"  value="<?php echo $arow['lname'] ?>" />
                            <span class="error"><?php echo $lname_err?></span>
                        </div>
                        <div class="col">
                            <label>Email: </label>
                            <input type="text" name="email" class="form-control form-group"  value="<?php echo $arow['email'] ?>" />
                            <span class="error"><?php echo $email_err?></span>
			</div>
			</div>
                            <input type="submit" name = "submit" class="btn btn-primary center-block" style="float:right;" value="Update"/>
                  	
                        <?php
                        //can't delete systemadmins
                        if($arow['typeUser'] == 3) {
                            echo "<input type='submit' name = 'delete' class='btn btn-primary center-block' value = 'Delete User'/>";
                        }
                        ?>
			</form>
			</div>
                        <?php
                    }
                }
                else {
                    $home_url = 'index.php';
                    header('Location: ' . $home_url);	
                }
            }
        }
    }
    else {
        $home_url = 'index.php';
        header('Location: ' . $home_url);	
    }
}
else {
    $home_url = 'index.php';
    header('Location: ' . $home_url);	
}
?>
