<?php
	// Start the session
	session_start();

	// Insert the page header
	require_once('header.php');

	require_once('connectvars.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Show the navigation menu
      require_once('navmenu.php');
     $myuid = $_SESSION['user_id'];

?>
<!-- search bar -->
	<form>
	<input type="search" name="search" placeholder="Search..."/>
	<input type="submit" />
	</form>
<br>
<div>
  
<?php

// prints out users that match the search
	  if(isset($_GET['search'])) {
        if($_SESSION['acc_type'] == 6) {
            $searchstudents = mysqli_query($dbc, "select * from users, student where (fname like '%{$_GET['search']}%' or minit like '%{$_GET['search']}%' or lname like '%{$_GET['search']}%') and users.uid = student.uid and student.advisor = '$myuid';");
        }
        else {
		    $searchstudents = mysqli_query($dbc, "select * from users, student where (fname like '%{$_GET['search']}%' or minit like '%{$_GET['search']}%' or lname like '%{$_GET['search']}%') and users.uid = student.uid;");
        }
        while ($searchstudent = mysqli_fetch_array($searchstudents)) {
			?>
		  
		  <label><?php echo $searchstudent['fname']; echo ' ' . $searchstudent['minit'] . '. '; echo $searchstudent['lname'] . ' '; ?></label>
		  <form action='gradaudit.php'>
		  <input type="hidden" name="uid" value="<?php echo $searchstudent['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Run Audit" />
		  </form>
		  <br>
		  <?php
		}
	
	  }
	else {
    // prints out every student
    if($_SESSION['acc_type'] == 6) {
        $students = mysqli_query($dbc, "select * from users, student where users.uid = student.uid and student.advisor = '$myuid';");
    }
    else {
        $students = mysqli_query($dbc, "select * from users, student where users.uid = student.uid;");
    }
	while ($student = mysqli_fetch_array($students)) {
		?>
		<label><?php echo $student['fname']; echo ' ' . $student['minit'] . '. '; echo $student['lname'] . ' '; ?></label>
		  <form action='gradaudit.php'>
		  <input type="hidden" name="uid" value="<?php echo $student['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Run Audit" />
		  </form>
		  <br>
		<?php
	}
?>
<br>	
<?php
 }

require_once('footer.php');
?>
</div>
