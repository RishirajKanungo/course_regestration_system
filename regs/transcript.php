<?php
session_start();
$page_title = 'Transcript';
require_once('header.php');
require_once('../connectvars.php');
?>
<html>
<head>
    <title> Applicant Portal </title>
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
input[name=view]:hover {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=view] {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=edit]:hover {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=edit] {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
</style>

<?php 

$totalCreditHours = 0;
$totalQualityPoints = 0;
$sem_gpa = "NA";
$cum_gpa = "NA";

function gpaPoints($grade, $credits)
{
    switch ($grade) {
        case "A":
            return 4.0 * $credits;
        break;
        case "A-":
            return 3.7 * $credits;
        break;
        case "B+":
            return 3.3 * $credits;
        break;
        case "B":
            return 3.0 * $credits;
        break;
        case "B-":
            return 2.7 * $credits;
        break;
        case "C+":
            return 2.3 * $credits;
        break;
        case "C":
            return 2.0 * $credits;
        break;
        case "F":
            return 0;
        break;
    }
}
echo "<br>";
// check the user is logged in 
if (isset($_SESSION['uid'])) {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // user requesting transcript is a student
    if ($_SESSION['typeUser'] == 5) {
        $student = $_SESSION['uid'];
    }
    else {
        // check to make sure the GET request goes through
        if (isset($_GET['s_id'])) {
            $student = $_GET['s_id'];
        }
        else {
            // redirect to index.php
            $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '../login.php';
            header('Location: ' . $home_url);
        }
    }
    
    $squery = "Select * from student where uid = '" . $student . "'";
    $sdata = mysqli_query($dbc, $squery);
    $stud = mysqli_fetch_array($sdata);
    $major = $stud['major'];
    if ($major == ""){
        $major = "undecided";
    }
    ?>
    <div class="container">
	<h3>Student Information</h3>
    <table>
        <tr>
            <th>Degree: </th>
            <th>Major: </th>
        </tr>
        <tr>
            <td><?php echo $stud['degree']?></td>
            <td><?php echo $major?></td>
        </tr>
    </table>
    <br>
    <h3>Institution Credit</h3>

    <?php 
    // Query for the previous terms the student had taken classes in
    $query = "select distinct s.year from section s join transcript t on s.uid = t.sec_id where t.uid = '" . $student . "' order by s.year ASC";
    $data = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($data)) {
        //query for the Fall semester
        $fquery = "select * from section s join transcript t join courses c on t.cno = c.uid and s.uid = t.sec_id where t.status = 'Web Registered' AND  t.uid = '" . $student . "' AND s.year = '" . $row['year'] . "' AND s.semester = 'Fall'";
        $fdata = mysqli_query($dbc, $fquery);
        $cred_sum = 0;
        $qualityPoints = 0;
        $sem_hours = 0;

        if(mysqli_num_rows($fdata) > 0) { 
        ?>
            <h4>Term: Fall <?php echo $row['year']?></h4>
            <table width=70%>
                <tr>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Grade</th>
                    <th>Credit Hours</th>
                </tr>
            <?php   
            while ($course = mysqli_fetch_array($fdata)) {   
                if ($course['grade'] != "IP") {
                    $cred_sum = $cred_sum + $course['credits']; 
                    $qualityPoints = $qualityPoints +  gpaPoints($course['grade'], $course['credits']);
                }
                $sem_hours = $sem_hours + $course['credits'];
            ?>
                <tr>
                    <td><?php echo $course['dept']?></td>
                    <td><?php echo $course['cno']?></td>
                    <td><?php echo $course['title']?></td>
                    <td><?php echo $course['grade']?></td>
                    <td><?php echo $course['credits']?></td>
                </tr>
            <?php 
            $totalCreditHours = $totalCreditHours + $cred_sum;
            $totalQualityPoints = $totalQualityPoints + $qualityPoints; 
            $sem_gpa = "NA";
            if ($cred_sum != 0) {
                $sem_gpa = $qualityPoints / $cred_sum;
            }
            if ($totalCreditHours != 0) {
                $cum_gpa = $totalQualityPoints / $totalCreditHours;                
            } 
            
            } 
            ?>
                </table>
                <br><br>
                <h4>Total Credit Hours: <?php echo $sem_hours?></h4>
                <h4>Semester GPA: <?php echo $sem_gpa?></h4>
                <h4>Cumulative GPA: <?php echo $cum_gpa?><h4>
        <?php
        }

        //query for the spring semester
        $fquery = "select * from section s, transcript t, courses c where t.status = 'Web Registered' and t.cno = c.uid and s.uid = t.sec_id and t.uid = '" . $student . "' AND s.year = '" . $row['year'] . "' AND s.semester = 'Spring'";
        $fdata = mysqli_query($dbc, $fquery);
        $cred_sum = 0;
        $qualityPoints = 0;
        $sem_hours = 0;

        if(mysqli_num_rows($fdata) > 0) {                             
        ?>        
            <h6>Term: Spring <?php echo $row['year']?></h6>
            <table width=70%>
                <tr>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Grade</th>
                    <th>Credit Hours</th>
                </tr>
            <?php   
            while ($course = mysqli_fetch_array($fdata)) { 
                if ($course['grade'] != "IP") {
                    $cred_sum = $cred_sum + $course['credits']; 
                    $qualityPoints = $qualityPoints +  gpaPoints($course['grade'], $course['credits']);
                }
                $sem_hours = $sem_hours + $course['credits'];
            ?>
                <tr>
                    <td><?php echo $course['dept']?></td>
                    <td><?php echo $course['cno']?></td>
                    <td><?php echo $course['title']?></td>
                    <td><?php echo $course['grade']?></td>
                    <td><?php echo $course['credits']?></td>
                </tr>
            <?php 
            } 
            $totalCreditHours = $totalCreditHours + $cred_sum;
            $totalQualityPoints = $totalQualityPoints + $qualityPoints;
            $sem_gpa = "NA"; 
            if ($cred_sum != 0) {
                $sem_gpa = $qualityPoints / $cred_sum;
            }
            if ($totalCreditHours != 0) {
                $cum_gpa = $totalQualityPoints / $totalCreditHours;                
            } 
            
            ?>
                </table>
                <br><br>
                <h6>Total Credit Hours: <?php echo $sem_hours?></h6>
                <h6>Semester GPA: <?php echo $sem_gpa?></h6>
                <h6>Cumulative GPA: <?php echo $cum_gpa?><h6></div>
        <?php
        }
    }
}

?>
