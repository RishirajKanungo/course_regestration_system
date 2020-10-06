<?php

session_start();
$page_title = 'Sections';
require_once('header.php');
require_once('../connectvars.php');
?>
<html>
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
    font-size: 18px;
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
input[type=button] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
    font-size: 18px;
    margin-right: 50px;
}
input[type=button]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    padding: 5px;
}
</style>
<br>
<?php
if(!(isset($_SESSION['typeUser']))) {
        header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '../login.php');
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
}

$msg = "";
$year_err = $sem_err = $day_err = $start_err = $end_err = "";

if (isset($_POST['edit']) || isset($_POST['submit'])) {
    if(isset($_POST['submit'])) {
        $year = $sem = $day = $start = $end = "";
        $valid_input = true;

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
		$sem = $_POST['semester'];
		$day = $_POST['day'];
		$sectionid = $_POST['sectionid'];
		if($_POST['f_id'] !== '') {
			$f_id = $_POST['f_id'];
			$query = "UPDATE section SET year = '$year', semester = '$sem', class_day = '$day', start_time = '$start', end_time = '$end', f_id = '$f_id' WHERE uid LIKE '$sectionid'";
		} else {
                	$query = "UPDATE section SET year = '$year', semester = '$sem', class_day = '$day', start_time = '$start', end_time = '$end' WHERE uid LIKE '$sectionid'";
		}	
		$result = mysqli_query($dbc, $query);
                if ($result) {
                        $msg = "You have succesfully updated the section";
                } else {
                        $msg = "Error: please try again";
                }
        }
    }
        if(isset($_POST['edit'])) {
                $_SESSION['sedit_section'] = $_POST['sectionid'];
		$_SESSION['sedit_dept'] = $_POST['coursedept'];
		$_SESSION['sedit_coursenum'] = $_POST['coursenum'];
	}
        $sect = $_SESSION['sedit_section'];
        $dept = $_SESSION['sedit_dept'];
	$coursenum = $_SESSION['sedit_coursenum'];
        $get_section_query = "SELECT * FROM section s WHERE s.uid = " . $sect;
        $result = mysqli_query($dbc, $get_section_query);
        $section = mysqli_fetch_assoc($result);
?>
	<div class="container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" value=<?php echo $section['uid']?> name="sectionid">
        <h4>Edit Section</h4>
	<div class="form-row">
        <div class="col">
                <label>Course:</label>
                <input class="form-control form-group" disabled type="text" value="<?php echo $dept . $coursenum ?>"/>
        </div>
        <div class="col">
                <label>Year:</label>
		<input class="form-control form-group" type="text" name="year" value="<?php echo $section['year'] ?>"/>
                <span class="error"><?php echo $year_err?></span>
        </div>
        <div class="col-md-1">
                <label>Semester:</label><br>
                <?php if($section['semester'] === "Fall") { ?>
		<select id="semester" name="semester">
			<option value="Fall">Fall</option>
			<option value="Spring">Spring</option>
			<option value="Summer">Summer</option>
		</select>
		<?php } else if ($section['semester'] === "Spring") { ?> 
		<select id="semester" name="semester">
                        <option value="Spring">Spring</option>
                        <option value="Fall">Fall</option>
                        <option value="Summer">Summer</option>
                </select>
		<?php } else if ($section['semester'] === "Summer") { ?>
		<select id="semester" name="semester">
                        <option value="Summer">Summer</option>
                        <option value="Fall">Fall</option>
                        <option value="Spring">Spring</option>
                </select>
                <?php }  ?>
	</div>
	</div>
	<div class="form-row">
	<div class="col-md-2">
                <label>Class Day:</label>
                <?php if($section['class_day'] === "M") { ?>
                <select id="day" name="day">
			<option value ="M">Monday</option>
			<option value="T">Tuesday</option>
			<option value="W">Wednesday</option>
			<option value="R">Thursday</option>
			<option value="F">Friday</option>
		</select>
		<?php } else if($section['class_day'] === "T") { ?>
                <select id="day" name="day">
                        <option value="T">Tuesday</option>
                        <option value="W">Wednesday</option>
                        <option value="R">Thursday</option>
			<option value="F">Friday</option>
			<option value ="M">Monday</option>
		</select>
		<?php } else if($section['class_day'] === "W") { ?>
                <select id="day" name="day">
                        <option value="W">Wednesday</option>
                        <option value="R">Thursday</option>
			<option value="F">Friday</option>
			<option value ="M">Monday</option>
			<option value="T">Tuesday</option>
		</select>
		<?php } else if($section['class_day'] === "R") { ?>
                <select id="day" name="day">
                        <option value="R">Thursday</option>
			<option value="F">Friday</option>
			<option value ="M">Monday</option>
                        <option value="T">Tuesday</option>
                        <option value="W">Wednesday</option>
		</select>
		<?php } else if($section['class_day'] === "F") { ?>
                <select id="day" name="day">
			<option value="F">Friday</option>
			<option value ="M">Monday</option>
                        <option value="T">Tuesday</option>
                        <option value="W">Wednesday</option>
			<option value="R">Thursday</option>
		</select>
		<?php } ?>
        </div>
        <div class="col">
                <label>Start Time:</label>
             	<input type="text" class="form-control form-group" name="start_time" value="<?php echo $section['start_time'] ?>"/>
                <span class="error"><?php echo $start_err?></span>
	</div>
        <div class="col">
                <label>End Time:</label>
		<input type="text" class="form-control form-group" name="end_time" value="<?php echo $section['end_time'] ?>"/>
		<span class="error"><?php echo $end_err?>
	</div>
	</div>
	<div class="form-row">
	<div class="col">
                <label>Faculty:</label>
		<label>
			<?php if($section['f_id'] === null) { 
				echo "";
	} else {
				$get_cfac = "SELECT * FROM faculty f, users u, section s WHERE f.uid = u.UID AND f.uid = s.f_id AND s.uid = " . $sect;
				$cfacu = mysqli_query($dbc, $get_cfac);
				while($cfac = mysqli_fetch_array($cfacu)) {
				echo $cfac['fname'] . " " .$cfac['lname']; }} ?>
		</label>
		<select id="f_id" name="f_id">
                        <option value=''></option>
<?php
        $get_fac = "SELECT * FROM faculty f, users u WHERE f.uid = u.UID";
        $fac = mysqli_query($dbc, $get_fac);
        while ($faculty = mysqli_fetch_array($fac)) {
		$f_id = $faculty['uid'];
		$f_fname = $faculty['fname'];
		$f_lname = $faculty['lname'];
                echo '<option value=' . $f_id . '>' . $f_fname . ' ' . $f_lname . '</option>';
        }
?>
                </select>
        </div>
        </div>
               <input style="float: right;" class="btn btn-primary center-block" type="submit" name="submit" value="Submit">
	</form>
	<?php echo $msg; ?>
	</div>
<?php
} else {
        $msg = "";
        if (isset($_POST['delete'])) {
                $sectionid = $_POST['sectionid'];
		$delete_takes_query = "DELETE FROM transcript WHERE uid LIKE '$sectionid'";
		mysqli_query($dbc, $delete_takes_query);
		$delete_section_query = "DELETE FROM section WHERE uid LIKE '$sectionid'";
                $result = mysqli_query($dbc, $delete_section_query);
                if($result) {
                        $msg = "You have succesfully deleted the course";
                } else {
                        $msg = "Error: please try again";
                }
        }
    $all_depts_query = "SELECT DISTINCT(dept) FROM courses";
    $depts = mysqli_query($dbc, $all_depts_query);
?>
      <form method="post" style="display: inline;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <label style="margin-left:50px" for="coursename">Search: </label>
          <input type="text" id="coursename" name="coursename">
          <input class="btn btn-light btn-lg" type="submit" name="search" value="Search">
        </form>
        <form method="post" style="display: inline;" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <label for="dept">Filter:</label>
          <select id="dept" name="dept">
          <?php
          while ($dept = mysqli_fetch_array($depts)) {
            echo '<option "value="' . $dept['dept'] . '">' . $dept['dept'] . '</option>';
          }
          ?>
          </select>
          <input class="btn btn-light btn-lg" type="submit" name="view" value="View">
        </form>
<?php 
    if($_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 7) {
?>
               <?php echo '<a href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/newsection.php">' ?>
               <input style="float: right;" class="btn btn-light btn-lg" type="button" value="Add new section?">
        </a>
<?php 
    }
    if(isset($_POST['search'])) {
            $dept_course_num = $_POST['coursename'];
            $all_courses_query = "SELECT * FROM courses WHERE CONCAT(dept, cno) LIKE '%" . $dept_course_num . "%'";
    } else if (isset($_POST['view'])) {
            $dept = $_POST['dept'];
            $all_courses_query = "SELECT * FROM courses WHERE dept LIKE '$dept'";
    } else if (isset($_GET['c_id'])) {
    	    $c_id = $_GET['c_id'];
	    $all_courses_query = "SELECT * FROM courses WHERE uid LIKE '$c_id'";
    } else {
            $all_courses_query = "SELECT * FROM courses ORDER BY dept ASC, cno ASC";
    }

    $courses = mysqli_query($dbc, $all_courses_query);

    echo $msg . '<br>';
    while ($course = mysqli_fetch_array($courses)) {
        // update to only reflect section that are being offered in this sem/year
        $course_id = $course['uid'];
        $section_query = "SELECT * FROM section WHERE c_id LIKE '$course_id' ORDER BY CASE WHEN class_day='M' THEN 1 WHEN class_day='T' THEN 2 WHEN class_day='W' THEN 3 WHEN class_day='R' THEN 4 WHEN class_day='F' THEN 5 END ASC, start_time ASC";
        $sections = mysqli_query($dbc, $section_query);
        if (mysqli_num_rows($sections) == 0) {
            continue;
        }
        echo '<div style="padding: 0px 50px;"><fieldset>';
	echo '<table cellpadding="10" style="margin-top: 10px;" width=100%>';
	echo '<th><h5>' . $course['dept'] . $course['cno'] . ' ' . $course['title'] . '</h5></th></table><table class="table borderless">';
        while ($section = mysqli_fetch_array($sections)) {
		$display_day = "";
		if ($section['class_day'] == "M") { 
			$display_day = "Monday";
		} else if ($section['class_day'] == "T") { 
                        $display_day = "Tuesday";
                } else if ($section['class_day'] == "W") { 
                        $display_day = "Wednesday";
                } else if ($section['class_day'] == "R") { 
                        $display_day = "Thursday";
		} else {
			$display_day = "Friday";
		}
		echo '<form method="post" action='. $_SERVER['PHP_SELF'] . '>';
	    echo '<tr><td align="left" width=20%>Section No: ' . $section['section_num'] . '</td>'; 
	    echo '<td align="left" width=20%> Day: ' . $display_day . '</td>';
	    echo '<td align="left"> Time: ' . $section['start_time'] . ' - ' . $section['end_time']  . '</td>';
	 if($_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 7) {
	    echo '<td width=10% align="right"><input class="btn btn-light btn-lg" type="submit" name="edit" value="Edit"></td>';
            echo '<td width=10% align="right"><input class="btn btn-light btn-lg" type="submit" name="delete" value="Delete"></td>';
	 }
	    echo '</tr>';
            echo '<input type="hidden" name="coursedept" value=' . $course['dept'] . '>';
            echo '<input type="hidden" name="coursenum" value=' . $course['cno'] . '>';
            echo '<input type="hidden" name="sectionid" value=' . $section['uid'] . '>';
            echo '</form>';
        }
        echo '</table></fieldset></div><br>';
    }
}
?>
