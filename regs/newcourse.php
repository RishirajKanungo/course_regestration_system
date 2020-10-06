<?php
session_start();
$page_title = 'New Course';
require_once('header.php');
require_once('../connectvars.php');
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
</style>
<?php
$msg = "";
$coursenum_err = $dept_err = $title_err = $credits_err = $description_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

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

        if(empty($_POST['dept'])) {
                $dept_err = "Department is required";
                $valid_input = false;
        } else {
                $dept = strtoupper(test_input($_POST['dept']));
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
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
               
                $query = "INSERT INTO courses (cno, dept, title, credits) VALUES ('$coursenum', '$dept', '$title', '$credits')";
                $result = mysqli_query($dbc, $query);
                if ($result) {
                        $msg = "You have succesfully created a new course";
                } else {
                        $msg = "Error: please try again";
                }
        }
}
?>
<br>
<div class="container">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <h4>New Course</h4>
<div class="form-row">
<div class="col">
        <label>Department: </label>
        <input type="text" class="form-control form-group" name="dept"/>
        <span class="error"><?php echo $dept_err?></span>
</div>
<div class="col">
        <label>Course Number: </label>
        <input type="text" class="form-control form-group" name="coursenum"/>
        <span class="error"><?php echo $coursenum_err?></span>
</div>
<div class="col">
        <label>Title: </label>
        <input type="text" class="form-control form-group" name="title"/>
        <span class="error"><?php echo $title_err?></span>
</div>
<div class="col">
        <label>Credits: </label>
        <input type="text" class="form-control form-group" name="credits"/>
        <span class="error"><?php echo $credits_err?></span>
</div>
</div>
        <input type="submit" style="margin-right: 0px; float: right;" value="Submit">
</form>
<div>
<?php
echo  $msg;
?>
