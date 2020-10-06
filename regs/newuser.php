<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'New User';
require_once('header.php');
require_once('../connectvars.php');
//connect to db
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
<br>
<?php
//use this? lol
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$msg = "";
$username_err = $pass_err = $student_or_faculty_id_err = $fname_err = $lname_err = $role_err = $email_err = $degree_err = $major_err = $admit_year_err = "";

//redirect back to certain pages?
if(empty($_SESSION['typeUser'])) {
	//not logged in
	echo "<center>Please log in </center> <br>";
	$home_url = 'logout.php';
    	header('Location: ' . $home_url);	
}
else if ($_SESSION['typeUser'] == 5) {
	$home_url = 'index.php';
	header('Location: ' . $home_url);
}
//if logged in as faculty
else if ($_SESSION['typeUser'] == 6) {
	//redirect to students page?
	$home_url = 'index.php';
    	header('Location: ' . $home_url);
}
//if logged in as gs
else if ($_SESSION['typeUser'] == 3) {
	//redirect to students page?
	$home_url = 'index.php';
	header('Location: ' . $home_url);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //if logged in as gs/sysadmin
    $valid_input = true;
    if ($_SESSION['typeUser'] == 4) {
        $username = $password = $fname = $lname = $student_or_faculty_id = $email = $admit_year = $major = "";
        $valid_input = true;

        //error checking
        if(empty($_POST['username'])) {
                $username_err = "Username is required";
                $valid_input = false;
        } 
        else {
                //check if the username is already in the db
                $username = test_input($_POST['username']);
                $username_query = mysqli_query($dbc, "select * from users where username = '$username'");
                if(mysqli_num_rows($username_query) > 0) {
                    $username_err = "Unique username is required";
                    $valid_input = false;
                }
	}
        if(empty($_POST['password'])) {
                $pass_err = "Password is required";
                $valid_input = false;
        } 
        else {
                $password = test_input($_POST['password']);
                if(strlen($password) < 4) {
                        $pass_err = "Password must be at least 4 characters long.";
                        $valid_input = false;
                }
	}
        if(empty($_POST['student_or_faculty_id'])) {
                if($_POST['typeUser'] == 5 || $_POST['typeUser'] == 6) {
                        $student_or_faculty_id_err = "ID is required for Faculty/Student";
                        $valid_input = false;
                }
        } 
        else {
                //check if the id is already in the db
                $student_or_faculty_id = test_input($_POST['student_or_faculty_id']);
                if(strlen($student_or_faculty_id) != 8) {
                        $student_or_faculty_id_err = "ID must be 8 digits long.";
                        $valid_input = false;
                }
                else if (!ctype_digit($student_or_faculty_id)) {
                        $student_or_faculty_id_err = "ID must consist of only numbers.";
                        $valid_input = false;
                }
                if($_POST['typeUser'] == 5) {
                        $student_id = $student_or_faculty_id;
                        $student_id_query = mysqli_query($dbc, "select * from student where uid = '$student_id'");
                        if(mysqli_num_rows($student_id_query) > 0 ) {
                                $student_or_faculty_id_err = "Unique student ID is required";
                                $valid_input = false;
                        }

                }
                else if($_POST['typeUser'] == 6) {
                        $faculty_id = $student_or_faculty_id;
                        $faculty_id_query = mysqli_query($dbc, "select * from faculty where uid = '$faculty_id'");
                        if(mysqli_num_rows($faculty_id_query) > 0 ) {
                                $student_or_faculty_id_err = "Unique faculty ID is required";
                                $valid_input = false;
                        }
                }
        }
        if(empty($_POST['fname'])) {
                $fname_err = "First name is required.";
                $valid_input = false;
        }
        else {
                $fname = test_input($_POST['fname']);
		if(strlen($fname) > 32) {
                        $fname_err = "Fist name is too long - make sure it's less than 33 characters.";
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
                            $email_err = "Sorry, that email is already taken.";
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
        if(empty($_POST['admit_year'])) {
		//are they a student?
		if($_POST['typeUser'] == 5) {
			$admit_year_err = "Admit year is required for students.";
			$valid_input = false;
		}
        }
        else {
                $admit_year = test_input($_POST['admit_year']);
                if(strlen($admit_year) != 4 || !ctype_digit($admit_year)) {
                        $admit_year_err = "Admit year must be entered as a four digit number.";
                        $valid_input = false;  
                }
        }
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
        if(empty($_POST['degree'])) {
		//would only get here if backend hack
		if($_POST['typeUser'] == 5) {
                	$degree_err = "Degree is required for students.";
			$valid_input = false;
		}
        }
	else {
		$degree = test_input($_POST['degree']);
		if($_POST['typeUser'] == 5 && !($degree == "MS" || $degree == "PhD")) {
			$degree_err = "For students, degree must be MS or PhD.";
			$valid_input = false;
		}
	}

    }
    else {
	$home_url = 'index.php';
	header('Location: ' . $home_url);
    }

    if($valid_input) {
        //yay! add to database
        $role = $_POST['typeUser'];
	//create account
        mysqli_query($dbc, "insert into users(username, password, fname, lname, email, typeUser, ssn, address) values('$username', '$password', '$fname', '$lname', '$email', '$role', '123456789', 'Test Drive')");
        //get account_id
        $get_account_info_query = mysqli_query($dbc, "select * from users where username = '$username'");
        $account_info = mysqli_fetch_array($get_account_info_query);
        $account_id = $account_info['UID'];
        //create student
        if($role == 5) {
                mysqli_query($dbc, "insert into student(uid, degree, major, admit_year) values('$account_id', '$degree', '$major', '$admit_year')");
        }
        else if ($role == 6) {
                mysqli_query($dbc, "insert into faculty(uid) values('$account_id')");
        }
        echo "<center>New user created successfully!</center> <br>";
    }

}

?>
<div class="container">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
<h4>New User</h4>
<h5>Account Information</h5>
<div class="form-row">
<div class="col-md-2">
        <label>Role: </label><br>
	<select id = "typeUser" name = "typeUser">
		<option value = "5">Student</option>
		<option value = "6">Faculty</option>
		<option value = "3">Graduate Secretary</option>
	</select>
        <span class="error"><?php echo $role_err?></span>
</div>
<div class="col">
        <label>Username: </label>
        <input type="text" class="form-control form-group" name="username" value="<?php if (!empty($username)) echo $username; ?>"/>
        <span class="error"><?php echo $username_err?></span>
</div>
<div class="col">
        <label>Password: </label>
        <input type="text" class="form-control form-group" name="password" value="<?php if (!empty($password)) echo $password; ?>"/>
        <span class="error"><?php echo $pass_err?></span>
</div>
<div class="col">
        <label>Student/Faculty ID: </label>
        <input type="text" class="form-control form-group" name="student_or_faculty_id" value="<?php if (!empty($student_or_faculty_id)) echo $student_or_faculty_id; ?>"/>
        <span class="error"><?php echo $student_or_faculty_id_err?></span>
</div>
</div>
<h5>Personal Information</h5>
<div class="form-row">
<div class="col">
        <label>First Name: </label>
        <input type="text" class="form-control form-group" name="fname" value="<?php if (!empty($fname)) echo $fname; ?>"/>
        <span class="error"><?php echo $fname_err?></span>
</div>
<div class="col">
        <label>Last Name: </label>
        <input type="text" class="form-control form-group" name="lname"value="<?php if (!empty($lname)) echo $lname; ?>"/>
        <span class="error"><?php echo $lname_err?></span>
</div>
<div class="col">
        <label>Email: </label>
        <input type="text" class="form-control form-group" name="email"value="<?php if (!empty($email)) echo $email; ?>"/>
        <span class="error"><?php echo $email_err?></span>
</div>
</div>
<h5>Degree Information (Students Only)</h5>
<div class="form-row">
<div class="col-md-1">
        <label>Degree: </label>
	<select id = "degree" name = "degree">
		<option value = "MS">MS</option>
		<option value = "PhD">PhD</option>
	</select>
        <span class="error"><?php echo $degree_err?></span>
</div>
<div class="col">
        <label>Admit Year: </label>
        <input type="text" class="form-control form-group" name="admit_year" value = "<?php if (!empty($admit_year)) echo $admit_year; ?>"/>
        <span class="error"><?php echo $admit_year_err?></span>
</div>
<div class="col">
        <label>Major: </label>
        <input type="text" class="form-control form-group" name="major"value = "<?php if (!empty($major)) echo $major; ?>"/>
        <span class="error"><?php echo $major_err?></span>
</div>
</div>
<?php
echo $msg;
?>
	<input type="submit" class="btn btn-primary center-block" style="float:right;" value="Submit"/>

</form>
</div>
