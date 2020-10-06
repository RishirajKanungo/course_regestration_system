<?php
session_start();
$page_title = 'New Section';
require_once('header.php');
require_once('../connectvars.php');

if(!(isset($_SESSION['typeUser']))) {
	header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php');
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
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
}

$msg = "";
$year_err = $day_err = $start_err = $end_err = $sect_num_err = $course_id_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $year = $day = $start = $end = $sect_num = $course_id = "";
        $valid_input = true;

	if(empty($_POST['section_num'])) {
                $sect_num_err = "Section Number is required";
                $valid_input = false;
        } else {
                $sect_num = test_input($_POST['section_num']);
                if(!preg_match("/^[0-9]{1,2}[:.,-]?$/", $sect_num)) {
                        $sect_num_err = "Only inputs with up to 2 digits are allowed";
                        $valid_input = false;
                }
        }

        if(empty($_POST['year'])) {
                $year_err = "Year is required";
                $valid_input = false;
        } else {
                $year = test_input($_POST['year']);
                if(!preg_match("/^[0-9]{4}$/", $year)) {
                        $year_err = "Only inputs with 4 digits are allowed";
                        $valid_input = false;
                }
        }

        if(empty($_POST['start_time'])) {
                $start_err = "Start time is required";
                $valid_input = false;
        } else {
                $start = test_input($_POST['start_time']);
                if(!preg_match("/(?:[01][0-9]|2[0-3]):[0-5][0-9]/", $start)) {
                        $start_err = "Time should be in 23:59 format";
                        $valid_input = false;
                }
        }

        if(empty($_POST['end_time'])) {
                $end_err = "End time is required";
                $valid_input = false;
        } else {
                $end = test_input($_POST['end_time']);
                if(!preg_match("/(?:[01][0-9]|2[0-3]):[0-5][0-9]/", $end)) {
                        $end_err = "Time should be in 23:59 format";
                        $valid_input = false;
                }
        }


        if($valid_input) {
		$course_id = $_POST['course_id'];
		$sem = $_POST['semester'];
		$day = $_POST['day'];
		if($_POST['f_id'] != "") {
			$f_id = $_POST['f_id'];
			$query = "INSERT INTO section (section_num, semester, year, class_day, start_time, end_time, c_id, f_id) VALUES ('$sect_num', '$sem', '$year', '$day', '$start', '$end', '$course_id', '$f_id')";
		} else {
			$query = "INSERT INTO section (section_num, semester, year, class_day, start_time, end_time, c_id) VALUES ('$sect_num', '$sem', '$year', '$day', '$start', '$end', '$course_id')";
		}
                $result = mysqli_query($dbc, $query);
                if ($result) {
                        $msg = "You have succesfully created a new section";
                } else {
                        $msg = "Error: please try again";
                }
        }
}
?>
<br>
<div class="container">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<h4>New Section</h4>
        <div class="form-row">
	<div class="col-md-2">
		<label>Course Tag:</label><br>
<?php
	$course_query = "SELECT uid, dept, cno FROM courses ORDER BY dept ASC, cno ASC";
$courses = mysqli_query($dbc, $course_query);
	echo '<select id="course_id" name="course_id">';
	while ($course = mysqli_fetch_array($courses)) {
		echo '<option value="' . $course['uid'] . '">' . $course['dept'] . $course['cno'] . '</option>';
	}
	echo '</select>';
?>
	</div>
	<div class="col">
                <label>Section Number:</label>
                <input type="text" class="form-control form-group" name="section_num">
                <span class="error"><?php echo $sect_num_err?></span>
        </div>
        <div class="col">
                <label>Year:</label>
                <input type="text" class="form-control form-group" name="year"/>
                <span class="error"><?php echo $year_err?></span>
        </div>
        <div class="col-md-2">
                <label>Semester:</label><br>
               	<select id="semester" name="semester">
                        <option value="Fall">Fall</option>
                        <option value="Spring">Spring</option>
                        <option value="Summer">Summer</option>
                </select>
	</div>
	</div>
	<div class="form-row">
        <div class="col-md-2">
                <label>Class Day:</label><br>
                <select id="day" name="day">
                        <option value ="M">Monday</option>
                        <option value="T">Tuesday</option>
                        <option value="W">Wednesday</option>
                        <option value="R">Thursday</option>
                        <option value="F">Friday</option>
                </select>
        </div>
        <div class="col">
                <label>Start Time:</label>
                <input type="text" class="form-control form-group" name="start_time"/>
                <span class="error"><?php echo $start_err?></span>
        </div>
        <div class="col">
                <label>End Time:</label>
                <input type="text"class="form-control form-group" name="end_time"/>
                <span class="error"><?php echo $end_err?></span>
        </div>
	<div class="col-md-2">
		<label>Faculty:</label><br>
		<select id="f_id" name="f_id">
			<option value=""></option>
<?php 
	$get_fac = "SELECT * FROM faculty f, users u WHERE f.uid = u.UID";
	$fac = mysqli_query($dbc, $get_fac);
	while ($faculty = mysqli_fetch_array($fac)) {
		$f_id = $faculty['uid'];
		$f_lname = $faculty['lname'];
		$f_fname = $faculty['fname'];
		echo '<option value=' . $f_id . '>' . $f_fname . ' '. $f_lname . '</option>';
	}
?>
		</select>
	</div>
	</div>
		<?php echo  $msg; ?>
                <input type="submit" style="float:right;" class="btn btn-primary center-block" name="submit" value="Submit">
</form>
</div>
