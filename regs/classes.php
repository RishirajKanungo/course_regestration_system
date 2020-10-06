<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Classes';
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
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
if(empty($_SESSION['typeUser'])) {
    //not logged in
	$home_url = 'logout.php';
    header('Location: ' . $home_url);	
}

if($_SESSION['typeUser'] == 6) {

    //default page - shows all sections they're teaching, filter by course
    if(!isset($_GET) || !(isset($_GET['sec_id']))) {
        $courses = array();
        $f_course_query = "SELECT DISTINCT c.dept, c.cno, c.title, c.uid FROM faculty f JOIN section s ON f.uid = s.f_id JOIN courses c ON c.uid = s.c_id WHERE f.uid = '".$_SESSION['uid']."' AND s.semester = 'Spring' AND s.year = '2020' ORDER BY c.dept, c.cno";
        $f_course_data = mysqli_query($dbc, $f_course_query);
        if(mysqli_num_rows($f_course_data) < 1) {
            //this prof doesn't exist or there's multiple of them? shouldn't get here
            echo "<center>You aren't teaching any courses.</center><br>";
        }
        else {
            while($f_course_row = mysqli_fetch_array($f_course_data)) {
                $dept_num = $f_course_row['dept']." ".$f_course_row['cno'];
                $c_id = $f_course_row['uid'];
                $courses[$c_id] = $dept_num;
            }
        }
        if(empty($courses)) {
            echo "You're not currently teaching any courses. <br>";
        }
        else {
            
            ?>
         
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!--Add back if want to allow searching by something else
                    <label for="search_course"></label>
                    <input type="text" id="search_course" name="search_course"> -->
		<label style="margin-left:50px" for="filter_course">Filter:</label>
                    <select class="form=control" name="filter_course">
                    <option value="all" id = "all">All</option>
                    <?php
                    foreach($courses as $c_id=>$dept_num) {
                        echo '<option name="' .$c_id. '" id = "'.$c_id.'" value = "'.$c_id.'">' . $dept_num . '</option>';
                    }
                    ?>
                    </select>
		<input type="submit" class="btn btn-primary center-block" name="search_button" value="Search">
		</form>
			<!-- add if want to add a view past semesters or view all button 
                    <td width = "25%" align="right">
                <input type = "submit" name = "submit_grade_updates" value = "Submit Grade Updates">
                </td>   -->
            <?php
            $display_courses = array();
            $display_courses = $courses;


            if(isset($_POST) && isset($_POST['search_button'])) {
                if($_POST['filter_course'] != "all") {
                    foreach($display_courses as $c_id => $dept_num) {
                        if($c_id != $_POST['filter_course']) {
                            unset($display_courses[$c_id]);
                        }
                    }    
                }  
            }

            //display the sections
            foreach($display_courses as $c_id=>$dept_num) {
                $c_query = "SELECT * FROM courses WHERE uid = '".$c_id."'";
                $c_data = mysqli_query($dbc, $c_query);
                if(mysqli_num_rows($c_data) != 1) {
                    //error
                    continue;
                }
                $c_row = mysqli_fetch_array($c_data);
                echo '<div style="padding:0px 50px";><table>';
                echo '<th><h5> ' .$c_row['dept'].' '.$c_row['cno']. ': '.$c_row['title'].'</h5></th>';
            	echo '</table><table>'; 
                $f_sec_query = "SELECT * FROM faculty f JOIN section s ON f.uid = s.f_id JOIN courses c ON s.c_id = c.uid WHERE f.uid = '".$_SESSION['uid']."' AND c.uid = '".$c_row['uid'] ."' AND s.semester = 'Spring' AND s.year = '2020' ORDER BY s.section_num";
                $f_sec_data = mysqli_query($dbc, $f_sec_query);
                if(mysqli_num_rows($f_sec_data) < 1) {
                    //shouldn't get here
                    echo "No current sections <br>";
                }
                else {
                    while($f_sec_row = mysqli_fetch_array($f_sec_data)) {
                        $section_num = $f_sec_row['section_num'];
                        $section_id = $f_sec_row['uid'];
                        echo "<tr><td><a href = './classes.php?sec_id=$section_id'>Section $section_num</a></td></tr>";
                    }
                }
                echo '</table></div><br>';

            }

        }
    }
    //non-default page - this is what shows once they've clicked on one of their sections!
    else {
        //make sure this isn't hacked, ie is a number & no escape chars
        $sec_id = $_GET['sec_id'];
        //sanity check - query for the section, make sure it exists
        $sec_query = "SELECT * FROM section s JOIN courses c ON c.uid = s.c_id WHERE s.uid = '$sec_id' AND s.f_id = '".$_SESSION['uid']."'";
       // JOIN takes ON sec_id = section_id JOIN student ON student_id = stu_id WHERE section_id = '$sec_id'";
        $sec_data = mysqli_query($dbc, $sec_query);
        if(mysqli_num_rows($sec_data) != 1) {
            echo "<center>You are not able to see this section, if it exists.<br>Please contact the System Administrator if you think this is a mistake.</center><br>";
        }
        else {
            $url = $_SERVER['PHP_SELF']."?sec_id=".$sec_id;
            ?>
                <form method="post" action="<?php echo $url; ?>">
                    <label style="margin-left:50px" for="search_by">Search by:</label>
                        <select id = "search_by" name = "search_by">
                            <option value = "full_name">Full Name</option>
                            <option value = "student_id">Student ID#</option>
                        </select>
                    <label for="search_user"></label>
                        <input type="text" id="search_user" name="search_user">
                    <input type="submit" class="btn btn-light btn-lg" name="search_user_button" value="Search">
                    <input type="submit" class="btn btn-light btn-lg" name="view_all_button" value="View All Students">
                <input type = "submit" class="btn btn-light btn-lg" style="float: right;" name = "submit_grade_updates" value = "Submit Grade Updates">
            <?php
            if (isset($_POST['submit_grade_updates'])) {	
                foreach($_POST as $info=>$grade) {	
                    //update the db with the new grades
                    if (strpos($info, "&") == false) {
                        continue;
                    }
                    $updateTakesInfo = explode ("&", $info);
                    $stu_id = $updateTakesInfo[0];
                    $sec_id = $updateTakesInfo[1];
                    $update_query = "update transcript set grade = '$grade' where sec_id = '$sec_id' and uid = '$stu_id';";
                    mysqli_query($dbc, $update_query);
                }   
            }
            //get search query
            if(isset($_POST['search_user_button'])) {
                if($_POST['search_by'] == "full_name") {
                    if(strpos($_POST['search_user'], " ") !== false) {
                        $name = explode(" ", $_POST['search_user']);
                        $stu_query = "SELECT * FROM transcript t JOIN student s ON s.uid = t.uid JOIN users u ON u.uid = s.uid WHERE t.status = 'Web Registered' AND t.sec_id = '$sec_id' AND u.fname = '$name[0]' AND u.lname = '$name[1]'";
                    }
                    else {
                        //if no space, assume they only entered the first name
                        $assumed_fname = $_POST['search_user'];
                        $stu_query = "SELECT * FROM transcript t JOIN student s ON s.uid = t.uid JOIN users u ON u.uid = s.uid WHERE t.sec_id = '$sec_id' AND t.status = 'Web Registered' AND u.fname = '$assumed_fname'";
                    }
                }
                else if ($_POST['search_by'] == "student_id") {
                    $student_id = $_POST['search_user'];
                    $stu_query = "SELECT * FROM transcript t JOIN student s ON s.uid = t.uid JOIN users u ON u.uid = s.uid WHERE t.sec_id = '$sec_id' AND t.status = 'Web Registered' AND s.uid = '$student_id'";
                }
            } 
            else if(isset($_POST['view_all_button'])) {
                $stu_query = "SELECT * FROM transcript t JOIN student s ON s.uid = t.uid JOIN users u ON u.uid = s.uid WHERE t.status = 'Web Registered' AND t.sec_id = '$sec_id'";
            }
            else {
                $stu_query = "SELECT * FROM transcript t JOIN student s ON s.uid = t.uid JOIN users u ON u.uid = s.uid WHERE t.status = 'Web Registered' AND t.sec_id = '$sec_id'";
            }

	    $sec_row = mysqli_fetch_array($sec_data);
	    echo '<div style="padding:0px 50px; margin-top:20px;">';
            echo '<table><th colspan="3"><h5>' .$sec_row['dept'].' '.$sec_row['cno']. ': '.$sec_row['title'].' (Section '.$sec_row['section_num'].')</h5></th>';

            //get the students
            //$stu_query = "SELECT * FROM takes JOIN student ON stu_id = student_id JOIN account ON a_id = account_id WHERE sec_id = '$sec_id'";
            $stu_data = mysqli_query($dbc, $stu_query);
            if(mysqli_num_rows($stu_data) < 1) {
                echo "There are no students who match that search query.";
            }
            else {
                while($stu_row = mysqli_fetch_array($stu_data)) {
                    //print student name, link to their student page, current grade
                    $student_id = $stu_row['uid'];
                    echo '<tr><td>'.$stu_row['fname'].' '.$stu_row['lname'].'</td><td>';
                    //echo 'Name: '.$stu_row['fname'].' '.$stu_row['lname'].'<br>';
                    if($stu_row['grade'] == "IP") {
                        //allow to update grade
                        ?>
                        <label for = "grade" >Input grade: </label>
                            <select id = "grade" name = "<?php echo ''.$stu_row['uid'].'&'.$stu_row['sec_id'] ?>">
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
                        
                        <?php
                        echo '<br>';
                    }
                    else {
                        echo 'Grade: '.$stu_row['grade'].'<br>';
                    }
                    echo "</td><td><a href = './person.php?s_id=$student_id'>View Student Information and Transcript</a></td>";
                    echo '</table></div>';
                }
            }
        }
        

    }
}
//non-faculty don't have classes page
else {
    //FIXME: redirect somewhere?
    $home_url = 'index.php';
    header('Location: ' . $home_url);
}
?>
