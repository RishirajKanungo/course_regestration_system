<?php
session_start();
$page_title = 'Personal Information';
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
}
button[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
</style>
<br>
<?php
$error_msg = "";
$missing_courses = "";
$conflict_courses = "";
$newquery = "Select s.uid as suid, s.*, c.* from section s join courses c on s.c_id = c.uid where s.semester = 'Spring' and s.year = 2020";

if (isset($_SESSION['typeUser'])) {
?>
    <div class="container">
    <h3>Look-Up Class To Add</h3>
    <form method="post" style="display: inline-block;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h6 style="display: inline-block;">Subject</h6>
    <select name="dept" id="dept">
    <?php
        // populate with the possible departments 
        $dquery = "SELECT DISTINCT dept FROM courses";
        $ddata = mysqli_query($dbc, $dquery);
        // display those classes
        while ($drow = mysqli_fetch_array($ddata)) {      
        ?>
		<option value="<?php echo $drow['dept']?>"><?php echo $drow['dept']?></option>;
    	<?php } ?>
	</select> 
    <button value="S" style="padding: 5px; display:inine-block;" name="form" type="submit" class="btn btn-primary center-block">Course Search</button>
</form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch ($_POST['form']) {
            case "S":
                $newquery = "Select * from section s join courses c on s.c_id = c.uid where s.semester = 'Spring' and s.year = 2020 and c.dept = '" . $_POST['dept'] . "'";
            break;
            case "R":
                // attempt to register for a new course
                if (!empty($_POST['sec'])) {
                    $error_msg = "";
                    $valid = "true";
                    // find the course
                    $query = "SELECT * FROM section s, courses c WHERE s.c_id = c.uid AND s.uid = '" . $_POST['sec'] . "'";    
                    $data = mysqli_query($dbc, $query);
                    $newcourse = mysqli_fetch_array($data);
                            
                    // check to make sure the class has not been previously taken by the student 
                    $tquery = "SELECT * FROM transcript WHERE uid = '" . $_SESSION['uid'] . "' AND cno = '" . $newcourse['c_id'] . "'";
                    $tdata = mysqli_query($dbc, $tquery);
                    // the course has never been taken by the student 
                    if(mysqli_num_rows($tdata) < 1) {
                        // check to make sure they have the necessary prerequisites to take the course
                        $pquery = "SELECT * FROM prereq WHERE c_id = '" . $newcourse['c_id'] . "'";
                        $pdata = mysqli_query($dbc, $pquery);
            
                        while ($prereq = mysqli_fetch_array($pdata)) {
                            // checks that the course is finished (has a grade of not IP) in order to be a prerequisite
                            $tquery = "SELECT * FROM transcript WHERE grade NOT IN ('IP', 'F') AND uid = '" . $_SESSION['uid'] . "' AND cno = '" . $prereq['prereq_id'] . "'";
                            $tdata = mysqli_query($dbc, $tquery);
    
                            if(mysqli_num_rows($tdata) < 1) {
                                $pnamequery = "SELECT * FROM courses WHERE uid = " . $prereq['prereq_id'];
                                $pnamedata = mysqli_query($dbc, $pnamequery);
                                $pname = mysqli_fetch_array($pnamedata);

                                $valid = "false";
                                $missing_courses = $missing_courses . " " . $pname['dept'] . " " . $pname['cno'] . " (" . $pname['title'] . ")";
                                $error_msg = "Error! Missing necessary prerequisites: " . $missing_courses;
                            }
                        }
                        if ($valid == "true") {
                            // TODO: FIX TO ACCOUNT FOR SEMESTERS IN THE FUTURE
                            // check to make sure there are not time conflicts with other courses currently in progress
                            $tquery = "SELECT * FROM transcript t join section s on s.uid = t.sec_id WHERE s.class_day = '" . $newcourse['class_day'] . "' AND t.uid = '" . $_SESSION['uid'] . "' AND t.grade = 'IP'";
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
                                    $namequery = "SELECT * FROM courses c WHERE uid = " . $ccourse['c_id'];
                                    $namedata = mysqli_query($dbc, $namequery);
                                    $cname = mysqli_fetch_array($namedata);

                                    $valid = "false";
                                    $conflict_courses = $conflict_courses . " " . $cname['dept'] . " " . $cname['cno'] . " (" . $cname['title'] . ")";
                                    $error_msg = "Error! Time conflicts with course(s): " . $conflict_courses;
                                }
                            }
                            if ($valid == "true") {
                // Insert course into takes
                $sec_id = $_POST['sec'];
                $iquery = "INSERT INTO transcript (status, sec_id, uid, cno, grade, dept) VALUES ('Advising Hold', " . $sec_id . ", " . $_SESSION['uid'] . ", " . $newcourse['c_id'] . ", 'IP', '" . $newcourse['dept'] . "')";
                mysqli_query($dbc, $iquery);
			    }
                        }        
                    }
                    else {
                        $error_msg = "Error adding class, duplicate course found.";
                        $valid = "false";
                    }
                    // TODO:
                    // - later on may need to check for room capacity and the like 
                    if (empty($error_msg)){
                // redirect to registration page
                        //$home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/registration.php';
			    //header('Location: ' . $home_url);
			$error_msg = "Course is added to schedule.";
                    }    
                }
            break;
        }
    }

    // Display the available sections for this semester
    $data = mysqli_query($dbc, $newquery);

    // display the class sections
?>
    <p class="error" style="display: inline"><?php echo $error_msg ?></p>
	<form method="post" style="display: inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <button value="R" name="form" type="submit" style="display: inline-block; float: right; padding: 5px;" class="btn btn-primary center-block">Add Class</button>
    <table>
        <tr>
            <th>Select</th>
            <th>Department</th>
            <th>Course</th>
            <th>Section</th>
            <th>Credits</th>
            <th>Title</th>
            <th>Days</th>
            <th>Time</th>
            <th>Instructor</th>
        </tr>
    <?php
    while ($row = mysqli_fetch_array($data)) { 
        // query for the professor of the course
        $pquery = "Select fname, lname from faculty f, users u, section s where s.uid = '". $row['uid']."' and u.UID = f.uid and f.uid = s.f_id";
        $pdata = mysqli_query($dbc, $pquery);
        if(mysqli_num_rows($pdata) == 1) {
            $pfdata = mysqli_fetch_array($pdata);
            $prof = $pfdata['fname'] . " " .  $pfdata['lname'];
        }
        else{
            $pfdata = mysqli_fetch_array($pdata);
            $prof = "TBD";
        }

       ?>
        <tr>
            <td><input type="radio" name="sec" value="<?php echo $row['suid']?>"></input></td>
	    <td><?php echo $row['dept']?></td>
            <td><?php echo $row['cno']?></td>
            <td><?php echo $row['section_num']?></td>
            <td><?php echo $row['credits']?></td>
            <td><?php echo $row['title']?></td>
            <td><?php echo $row['class_day']?></td>
            <td><?php echo $row['start_time']?> - <?php echo $row['end_time']?></td>
            <td><?php echo $prof?></td>
        </tr></div>
        <?php
    }
    ?>
    </table><br>
    </form>
    <?php
}
else {
    $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php';
    header('Location: ' . $home_url);
}
?>
