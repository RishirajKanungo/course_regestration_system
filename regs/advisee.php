<?php

session_start();
$page_title = 'Advisees';
require_once('header.php');
require_once('../connectvars.php');

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

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../apps/portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<style>
.borderless td, .borderless th {
        border: none;
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

<div class="container">
<h4>Advisee List</h4>
<form method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>
    <table>
        <th>Name</th>
        <th>Student Id</th>
	<th>Advising Form</th>
	<th>Additional Information</th>
<?php 
	$a_id = $_SESSION['uid'];
	$get_advisee_query = "SELECT * FROM student s, users u WHERE u.UID = s.uid AND s.advisor = '$a_id'";
	$advisee_data = mysqli_query($dbc, $get_advisee_query);
	while($arow = mysqli_fetch_array($advisee_data)) {
		$student_id = $arow['uid'];
?>
	<tr>
            <td>
	    <label><?php echo $arow['fname'] . " ". $arow['lname'] ?></label>
            </td>
	    <td>
	    <label><?php echo $arow['uid'] ?></label>
            </td>
	    <td>
	    	<?php echo "<a href = './adviseeform.php?s_id=$student_id'>View Advising Form</a>" ?>
	    </td>
	    <td>
		<?php echo "<a href = './student.php?s_id=$student_id'>View Student Info and Update Grades</a>" ?>
	    </td>
        </tr>
        <?php } ?>
    </table>
</form>
</div>


