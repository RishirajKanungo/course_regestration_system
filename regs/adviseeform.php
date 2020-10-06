<?php
if (!isset($_SESSION)) {
	session_start();
}
$page_title = 'Advising Form';
require_once('header.php');
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
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
	if(isset($_POST["signoff"])) {
		$student_id = $_GET["s_id"];
		$update_query = "UPDATE transcript SET status = 'Web Registered' WHERE uid = '$student_id' AND status = 'Advising Hold'";
		$result = mysqli_query($dbc, $update_query);
		if ($result) {
                        $msg = "You have succesfully signed off on the advising form";
                } else {
                        $msg = "Error: please try again";
		}		
		echo "<script>alert('" . $msg . "')</script>";
	} else {
		$student_id = $_GET["s_id"];
		$get_form_query = "SELECT * FROM transcript t, users u, courses c WHERE t.uid = u.UID AND t.cno = c.uid AND t.uid = '$student_id' AND t.status = 'Advising Hold'";
		$fdata = mysqli_query($dbc, $get_form_query);
	
		$get_name = "SELECT fname, lname FROM users WHERE UID = '$student_id'";
		$ndata = mysqli_query($dbc, $get_name);
		$nrow = mysqli_fetch_array($ndata);
?>
<div class="container">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?s_id=$student_id"; ?>">
<h4>Advising Form</h4>
<div class="form-row">
	<div class="col">
	<label>Name:</label>
	<input disabled type="text" name="name" class="form-control form-group" value="<?php echo $nrow['fname'] . " " . $nrow['lname'];?>"/>
	</div>	
        <div class="col">
        <label>Student ID:</label>
        <input disabled type="text" name="studentid" class="form-control form-group" value="<?php echo $student_id;?>"/>
        </div>
</div>
<?php
		if(mysqli_num_rows($fdata) == 0) {
			echo "The student does not have any pending advising form";
		} else {
			echo "<label>Modules:</label>";
			while($frow = mysqli_fetch_array($fdata)) {
				echo "<div class='form-row'>";			
				echo "<div class='col'>";
				echo "<input disabled type='text' name='module' class='form-control form-group' value='" . $frow['dept'] . $frow['cno'] . " " . $frow['title'] . "'/>";
				echo "</div>";
				echo "<div class='col-md-2'>";
				echo "<input disabled type='text' name='module' class='form-control form-group' value='" . $frow['credits'] . " Credits'/>";
				echo "</div>";
				echo "</div>";
			}
			echo '<input style="float: right; margin-right:0px;" class="btn btn-light btn-lg" type="submit" name="signoff" value="Sign off"/>';
			echo "</form>";
			echo "</div>";
		}
	}
?>
