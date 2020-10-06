<?php

session_start();
$page_title = 'Course Catalog';
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
</style>
<br>
<?php
if(!(isset($_SESSION['typeUser']))) {
	header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/login.php');
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
}

$msg = "";
$coursenum_err = $dept_err = $title_err = $credits_err = $description_err = "";

if (isset($_POST['edit']) || isset($_POST['submit'])) {

	if(isset($_POST['submit'])) {
        $coursenum = $dept = $title = $credits = $description = "";

        $valid_input = true;

        if(empty($_POST['coursenum'])) {
                $coursenum_err = "Course number is required";
                $valid_input = false;
        } else {
                $coursenum = test_input($_POST['coursenum']);
                if(!preg_match("/^\d{4}$/", $coursenum)) {
                        $coursenum_err = "Only numbers of 4 characters length are allowed";
                        $valid_input = false;
                }
        }

        if(empty($_POST['coursedept'])) {
                $dept_err = "Department is required";
                $valid_input = false;
        } else {
                $dept = strtoupper(test_input($_POST['coursedept']));
                if(!preg_match("/^[a-zA-Z]{4}$/", $dept)) {
                        $dept_err = "Only 4 characters length are allowed";
                        $valid_input = false;
                }
        }

        if(empty($_POST['title'])) {
                $title_err = "Title is required";
                $valid_input = false;
        } else {
                $title = $_POST['title'];
        }

        if(empty($_POST['credits'])) {
                $credits_err = "Credits is required";
                $valid_input = false;
        } else {
                $credits = test_input($_POST['credits']);
                if(!preg_match("/^\d{1}/", $credits)) {
                        $credits_err = "Credits can only be between 1-9";
                        $valid_input = false;
                }
        }

        if($valid_input) {
                $query = "UPDATE courses SET cno = '$coursenum', dept = '$dept', title = '$title', credits = '$credits' WHERE cno LIKE '$coursenum' AND dept LIKE '$dept'";
                $result = mysqli_query($dbc, $query);
		if ($result) {
                        $msg = "You have succesfully updated the course";
                } else {
                        $msg = "Error: please try again";
		}
	}
	}	
	if(isset($_POST['edit'])) {
		$_SESSION['edit_dept'] = $_POST['coursedept'];
	}	
	$dept = $_SESSION['edit_dept'];
	if(isset($_POST['edit'])) {
		$_SESSION['edit_coursenum'] = $_POST['coursenum'];
	}
	$course_num = $_SESSION['edit_coursenum'];
	$get_course_query = "SELECT * FROM courses WHERE dept LIKE '$dept' AND cno LIKE '$course_num'";
	$result = mysqli_query($dbc, $get_course_query);
	$course = mysqli_fetch_assoc($result);
?>
	<div class="container">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<h4 style="display:inline">Edit Course</h4>
	<div class="form-row">
	<div class="col">
		<label>Course Number:</label> 
        	<input type="text" class="form-control form-group" name="coursenum" value="<?php echo $course['cno'] ?>"/>
        	<span class="error"><?php echo $coursenum_err?></span>
	</div>
	<div class="col">
		<label>Department:</label>
        	<input type="text" class="form-control form-group" name="coursedept" value="<?php echo $course['dept'] ?>"/>
        	<span class="error"><?php echo $dept_err?></span>
	</div>
	<div class="col">
		<label>Title:</label>
        	<input type="text" class="form-control form-group" name="title" value="<?php echo $course['title'] ?>"/>
        	<span class="error"><?php echo $title_err?></span>
	</div>
	<div class="col">
		<label>Credits:</label>
       		<input type="text" class="form-control form-group" name="credits" value="<?php echo $course['credits'] ?>"/>
        	<span class="error"><?php echo $credits_err?></span>
	</div>
	</div>
		<?php echo '<span align="center">'. $msg . '</span>' ?>
        	<input style="float:right; margin-right:0px;" type="submit" class="btn btn-light btn-lg" name="submit" value="Submit"/>
	</form>
	</div>
<?php
} else {
	$msg = "";
	if (isset($_POST['delete'])) {
		$dept = $_POST['coursedept'];
		$coursenum = $_POST['coursenum'];
		$courseid = $_POST['courseid'];
		$delete_prereq_query = "DELETE FROM prereq WHERE c_id LIKE '$courseid' OR prereq_id LIKE '$courseid'";
		mysqli_query($dbc, $delete_prereq_query);
		$delete_takes_query = "DELETE FROM transcript WHERE cno LIKE '$courseid'";
		mysqli_query($dbc, $delete_takes_query);
		$delete_section_query = "DELETE FROM section WHERE c_id LIKE '$courseid'";
		mysqli_query($dbc, $delete_section_query);
		$delete_course_query = "DELETE FROM courses WHERE dept LIKE '$dept' AND cno LIKE '$coursenum'";
		$result = mysqli_query($dbc, $delete_course_query);
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
if($_SESSION['typeUser'] == "4" || $_SESSION['typeUser'] == 7) {
	echo $msg;
	echo '<a style="float: right;" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/newcourse.php">';
	echo '<input class="btn btn-light btn-lg" type="button" value="Add new course?">';
	echo '</a>';
}

echo '<br>';
if(isset($_POST['search'])) {
	$dept_course_num = $_POST['coursename'];
	$all_courses_query = "SELECT * FROM courses WHERE CONCAT(dept, cno) LIKE '%" . $dept_course_num . "%'";
} else if (isset($_POST['view'])) {
	$dept = $_POST['dept'];
	$all_courses_query = "SELECT * FROM courses WHERE dept LIKE '$dept'";
} else {	
	$all_courses_query = "SELECT * FROM courses ORDER BY dept ASC, cno ASC";
}

$courses = mysqli_query($dbc, $all_courses_query);
if (!$courses) {
    printf("Error: %s\n", mysqli_error($dbc));
    exit();
}
while ($course = mysqli_fetch_array($courses)) {
	echo '<form method="post" action='. $_SERVER['PHP_SELF'] . '>';
	echo '<div style="padding:0px 50px; margin-top: 10px;";><fieldset>';
	echo '<table cellpadding="10" width=100%>';
	echo '<th><h5>' . $course['dept'] . $course['cno'] . ' ' . $course['title'] . '</h5></th></table><table class="table borderless">';
	echo '<tr><td widht=90%>Credit Hours: '. $course['credits'] . '</td>';
	$c_id = $course['uid'];
	$get_pre_req = "SELECT * FROM prereq WHERE c_id LIKE '$c_id'";
	$pre_reqs = mysqli_query($dbc, $get_pre_req);
	$pre_req_stmt = "";
	$got_prereq = false;
	while ($prereq = mysqli_fetch_array($pre_reqs)) {
		$got_prereq = true;
		$another_course_id = $prereq['prereq_id'];
		$get_course = "SELECT * FROM courses WHERE uid LIKE '$another_course_id'";
		$course_result = mysqli_query($dbc, $get_course);
		while ($name = mysqli_fetch_array($course_result)) {
			$pre_req_stmt = $pre_req_stmt . $name['dept'].$name['cno'] . ", ";
		}
	}
	$check_sec_query = "SELECT * FROM section WHERE c_id = " . $course['uid'];
	$got_sec = mysqli_query($dbc, $check_sec_query);
	if(mysqli_num_rows($got_sec) != 0) {
	echo "<td><a href = './sections.php?c_id=$c_id'>Sections</a></td>";
	} else {
	echo "<td>No sections offered for this course</td>";
	}
	if( $_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 7) {
 		echo '<td width=5% align="right"><input class="btn btn-light btn-lg" type="submit" name="edit" value="Edit"></td>';
                 echo '<td width=5% align="right"><input class="btn btn-light btn-lg" type="submit" name="delete" value="Delete"></td>';
	}
	if($got_prereq) {
		if($_SESSION['typeUser'] == 4 || $_SESSION['typeUser'] == 7) {
			echo '<tr><td colspan="4">Pre-requisites: ' . substr($pre_req_stmt, 0, -2) . '</td></tr>';
		} else {
			echo '<tr><td colspan="2">Pre-requisites: ' . substr($pre_req_stmt, 0, -2) . '</td></tr>';
		}
	}
	echo '</table></fieldset></div><br>';
	echo '<input type="hidden" name="coursedept" value=' . $course['dept'] . '>';
	echo '<input type="hidden" name="coursenum" value=' . $course['cno'] . '>';
	echo '<input type="hidden" name="courseid" value=' . $course['uid'] . '>';
	echo '</form>';
}
}
?>
