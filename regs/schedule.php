<?php
session_start();
$page_title = 'Schedule';
require_once('header.php');
require_once('../connectvars.php');

if(!isset($_SESSION['typeUser'])) {
	header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php');
} else {

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
.table-hover>tbody>tr:hover {
	background-color: #ffffff;
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
</style>
<?php
$username = $_SESSION['uid'];

$schedule_query = "SELECT DISTINCT t.*, c.cno AS course_num, c.dept AS dept, c.title AS title, sec.section_num AS section_num, sec.year AS year, sec.semester AS semester, sec.class_day AS class_day, sec.start_time AS start_time, sec.end_time AS end_time, sec.room AS room FROM users u, student s, transcript t, courses c, section sec WHERE t.status = 'Web Registered' AND  u.uid LIKE '$username' AND u.uid LIKE t.uid AND t.grade LIKE 'IP' AND t.cno LIKE c.uid AND t.sec_id LIKE sec.uid ORDER BY sec.start_time ASC";

$schedule = mysqli_query($dbc, $schedule_query);

$monday = array();
$tuesday = array();
$wednesday = array();
$thursday = array();
$friday = array();

while($row = mysqli_fetch_array($schedule)) {
	if($row['class_day'] == "M") {
		array_push($monday, $row);
	} else if($row['class_day'] == "T") {
                array_push($tuesday, $row);
        } else if($row['class_day'] == "W") {
                array_push($wednesday, $row);
        } else if($row['class_day'] == "R") {
                array_push($thursday, $row);
        } else if($row['class_day'] == "F") {
                array_push($friday, $row);
        }
}
?>
<table width="100%" height="75%" class="table table-hover">
	<td width="20%" height="100%">
		<fieldset style="height:100%;">
			<legend align="center" style="padding:15px; font-weight: bold;">Monday</legend>
			<?php 
			if(!empty($monday)) {
				echo '<table width="100%">';
				foreach($monday as $row) {
					echo '<tr><td align="center" style="padding:20px">';
					echo $row['dept'] . $row['course_num'] . ' ' . $row['title'] . '<br>';
					echo 'Location: ' . $row['room'] . '<br>';
					echo $row['start_time'] . ' - ' . $row['end_time'];
					echo '</td></tr>';
				}
				echo '</table>';
			}
			?>
		</fieldset>
	</td>
	<td width="20%" height="100%">
		<fieldset style="height:100%">
			<legend align="center" style="padding:15px; font-weight: bold;">Tuesday</legend>
			<?php
			if(!empty($tuesday)) {
				echo '<table width="100%">';
				foreach($tuesday as $row) {
        				echo '<tr><td align="center" style="padding:20px">';
        				echo $row['dept'] . $row['course_num'] . ' ' . $row['title'] . '<br>';
        				echo 'Location: ' . $row['room'] . '<br>';
        				echo $row['start_time'] . ' - ' . $row['end_time'];     
					echo '</td></tr>';
				}
				echo '</table>';  
			}
			?>
		</fieldset>
	</td>
	<td width="20%" height="100%">
		<fieldset style="height:100%">
			<legend align="center" style="padding:15px; font-weight: bold;">Wednesday</legend>
			<?php
			if(!empty($wednesday)) {
				echo '<table width="100%">';
				foreach($wednesday as $row) {
       					echo '<tr><td align="center" style="padding:20px">';
        				echo $row['dept'] . $row['course_num'] . ' ' . $row['title'] . '<br>';
        				echo 'Location: ' . $row['room'] . '<br>';
        				echo $row['start_time'] . ' - ' . $row['end_time'];
       					echo '</td></tr>';
				}
				echo '</table>';
			}
			?>
		</fieldset>
	</td>
	<td width="20%" height="100%">
		<fieldset style="height:100%">
			<legend align="center" style="padding:15px; font-weight: bold;">Thursday</legend>
			<?php
			if(!empty($thursday)) {
       				echo '<table width="100%" style="padding:20px">';
				foreach($thursday as $row) {
        				echo '<tr><td align="center">';
        				echo $row['dept'] . $row['course_num'] . ' ' . $row['title'] . '<br>';
        				echo 'Location: ' . $row['room'] . '<br>';
        				echo $row['start_time'] . ' - ' . $row['end_time'];
        				echo '</td></tr>';
				}
				echo '</table>';
			}
			?>
		</fieldset>
	</td>
	<td width="20%" height="100%">
		<fieldset style="height:100%">
			<legend align="center" style="padding:15px; font-weight: bold;">Friday</legend>
			<?php
			if(!empty($friday)) {
       				echo '<table width="100%" style="padding:20px">';
				foreach($friday as $row) {
        				echo '<tr><td align="center">';
        				echo $row['dept'] . $row['course_num'] . ' ' . $row['title'] . '<br>';
       					 echo 'Location: ' . $row['room'] . '<br>';
        				echo $row['start_time'] . ' - ' . $row['end_time'];
        				echo '</td></tr>';
				}
				echo '</table';
			}
			?>
		</fieldset>
	</td>
</table>
<?php
}
?>
