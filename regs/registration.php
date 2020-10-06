<?php
session_start();
$page_title = 'Registration';
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
button[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    float: right;
    margin: 5px;
}
button[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    float: right;
    margin: 5px;
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
input[type=number] {
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=number]:hover {
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
select {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
</style>
<br>
<?php
$error_msg = "";

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// makes sure the user is a student
if ($_SESSION['typeUser'] == 5){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valid = true;
        switch ($_POST['form']) {            
            // registering for classes
            case "R":
                $missing_courses = "";
                $conflict_courses = "";
                // check if the user wants to drop any classes
                $query = "SELECT sec_id, cno FROM transcript WHERE uid = '" . $_SESSION['uid'] . "' AND grade = 'IP'";
                $data = mysqli_query($dbc, $query);

		$delete_course = false;
                while ($row = mysqli_fetch_array($data)) {
                    if ($_POST[$row['cno']] == "drop"){
                        // remove the class from takes
                        $delete = "DELETE FROM transcript WHERE uid = '" . $_SESSION['uid'] . "' AND cno = '" . $row['cno'] . "'";
			mysqli_query($dbc, $delete);
			$delete_course = true;
                    }
                }

		if ($delete_course) {
			$error_msg = "Selected courses are dropped";
			$valid = "false";
		}
		else if (empty(trim($_POST['courseid'])) || empty(trim($_POST['sec_num'])) ){ 
            		$error_msg = "Please enter required fields.";
                        $valid = "false";
                }
                else {
                    // make sure the course exists
                    $query = "SELECT * FROM section s JOIN courses c ON c.uid = s.c_id WHERE semester = 'Spring' AND year = '2020' AND 
                        c.uid = '" . $_POST['courseid'] . "' AND dept = '". $_POST['dept'] . "' AND s.section_num = '" . 
                         $_POST['sec_num'] . "'";
                    $data = mysqli_query($dbc, $query);
                    // if there is not one row, the input was invalid
                    if(mysqli_num_rows($data) == 1) {
                        $newcourse = mysqli_fetch_array($data);
                        
                        // check to make sure the class has not been previously taken by the student 
                        $tquery = "SELECT * FROM transcript WHERE uid = '" . $_SESSION['uid'] . "' AND c_id = '" . $newcourse['c_id'] . "'";
                        $tdata = mysqli_query($dbc, $tquery);
                        // the course has never been taken by the student 
                        if(mysqli_num_rows($tdata) < 1) {
                            // check to make sure they have the necessary prerequisites to take the course
                            $pquery = "SELECT * FROM prereq WHERE c_id = '" . $newcourse['c_id'] . "'";
                            $pdata = mysqli_query($dbc, $pquery);
        
                            while ($prereq = mysqli_fetch_array($pdata)) {
                                // checks that the course is finished (has a grade of not IP) in order to be a prerequisite
                                $tquery = "SELECT * FROM transcript WHERE grade NOT IN ('IP', 'F') AND uid = '" . $_SESSION['uid'] . "' AND c_id = '" . $prereq['prereq_id'] . "'";
                                $tdata = mysqli_query($dbc, $tquery);
        
                                if(mysqli_num_rows($tdata) < 1) {
                                    $pnamequery = "SELECT * FROM courses WHERE uid = " . $prereq['prereq_id'];
                                    $pnamedata = mysqli_query($dbc, $pnamequery);
                                    $pname = mysqli_fetch_array($pnamedata);

                                    $valid = "false";
                                    $missing_courses = $missing_courses . " " . $pname['dept'] . " " . $pname['course_num'] . " (" . $pname['title'] . ")";
                                    $error_msg = "Error! Missing necessary prerequisite(s): " . $missing_courses;
                                }
                            }
                            if ($valid == "true") {
                                // check to make sure there are not time conflicts with other courses currently in progress
                                $tquery = "SELECT * FROM transcript t join section s on t.sec_id = s.uid WHERE class_day = '" . $newcourse['class_day'] . "' AND t.uid = '" . $_SESSION['uid'] . "' AND grade = 'IP'";
                                $tdata = mysqli_query($dbc, $tquery);

                                // check for time conflicts
                                while ($ccourse = mysqli_fetch_array($tdata)) {
                                    $flag = 0;
                                    if ($newcourse['start_time'] == $ccourse['start_time']){
                                        $flag = 1;
                                    }
                                    if ($newcourse['start_time'] == "15:00") {
                                        if (($ccourse['start_time'] == "16:00") || ($ccourse['start_time'] == "15:30")) {
                                            $flag = 1;
                                        }
                                    }
                                    else if ($newcourse['start_time'] == "15:30"){
                                        if (($ccourse['start_time'] == "15:00") || ($ccourse['start_time'] == "16:00")) {
                                            $flag = 1;
                                        }
                                    }
                                    else if ($newcourse['start_time'] == "16:00"){
                                        if (($ccourse['start_time'] == "15:00") || ($ccourse['start_time'] == "15:30") || ($ccourse['start_time'] == "18:00")) {
                                            $flag = 1;
                                        }
                                    }
                                    else if ($newcourse['start_time'] == "18:00"){
                                        if (($ccourse['start_time'] == "15:30") || ($ccourse['start_time'] == "16:00")) {
                                            $flag = 1;
                                        }
                                    }
                                    if ($flag == 1) {
                                        $namequery = "SELECT * FROM course WHERE uid = " . $ccourse['c_id'];
                                        $namedata = mysqli_query($dbc, $namequery);
                                        $cname = mysqli_fetch_array($namedata);

                                        $valid = "false";

                                        $conflict_courses = $conflict_courses . " " . $cname['dept'] . " " . $cname['cno'] . " (" . $cname['title'] . ")";
                                        $error_msg = "Error! Time conflicts with course(s): " . $conflict_courses;
                                    }
                                }
                                if ($valid == "true") {
                                    // Insert course into takes
                                    $iquery = "INSERT INTO transcript(status, sec_id, uid, cno, grade) values ('Advising Hold', " . $newcourse['section_id'] . ", " . $_SESSION['uid'] . ", " . $newcourse['c_id'] . ", 'IP')";
                                    mysqli_query($dbc, $iquery);
                                }
                            }
                        }
                        else {
                            // repeat course, invalid input
                            $error_msg = "Error adding class, duplicate course found.";
                            $valid = "false";
                        }
                    }
                    else {
                        $error_msg = "Error adding class, invalid input.";
                        $valid = "false";
                    }
                    // TODO:
                    // - later on may need to check for room capacity and the like 
                }
                break;
        }
	if ($valid == "true") {
            $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/registration.php';
            header('Location: ' . $home_url);
        }
    }
    
    if (!isset($_SESSION['term'])){
        $_SESSION['term'] = "Spring 2020";
    }
    if ($_SESSION['typeUser'] == 5) {
        // Add the table to display the classes 
        // wrapping the table with a form to account for adding/dropping classes
?>
	<div class="container">
        <h3>Current Schedule: <?php echo $_SESSION['term']?></h3>
        <form method="post" style="display:inline;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <table>
            <tr>
                <th>Status</th>
                <th>Action</th>
                <th>Department</th>
                <th>Course</th>
                <th>Section</th>
                <th>Credits</th>
                <th>Title</th>
                <th>Day</th>
                <th>Time</th>
            </tr>
        </table>
        <?php 
        // query for the current classes being taken
        $query = "SELECT cno, status FROM transcript WHERE uid = '" . $_SESSION['uid'] . "' AND grade = 'IP'";
        $data = mysqli_query($dbc, $query);

        echo "<table border='1'>";
        // display those classes
        while ($row = mysqli_fetch_array($data)) {
            // query for the class information 
            $cquery = "select * from section s join courses c on s.c_id = c.uid where s.c_id = " . $row['cno'];
            $cdata = mysqli_query($dbc, $cquery);
            $course = mysqli_fetch_array($cdata);            
        ?>
            <tr>
	    <td><?php echo $row['status']?></td>
                <td>
                        <select name="<?php echo $row['cno']?>" id="<?php echo $row['cno']?>"/>
                            <option value="none"></option>
                            <option value="drop">Web Drop</option>
                </td>
                <td><?php echo $course['dept']?></td>
                <td><?php echo $course['cno']?></td>
                <td><?php echo $course['section_num']?></td>
                <td><?php echo $course['credits']?></td>
                <td><?php echo $course['title']?></td>
                <td><?php echo $course['class_day']?></td>
                <td><?php echo $course['start_time']?> - <?php echo $course['end_time']?></td>
            </tr>
        <?php 
        }
        ?>
        </table>
        <br></br>
	<button value="R" class="btn btn-light btn-lg" name="form" type="submit">Submit Changes</button>
	</form>
        <form method="get" action="lookupclass.php" style="display:inline;">
	<button name="form" style="float:left;" class="btn btn-light btn-lg" type="submit">Look-Up Classes To Add</button> 
	</form>
                </div>
		</tr>
            </div><p align="center" class="error"><?php echo $error_msg?></p></div>
        <?php           
    }
}
// if not a student, redirects to index html
else {
    $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php';
    header('Location: ' . $home_url);
}
?>
