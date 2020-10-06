<?php
	// Start the session
	session_start();

	// Insert the page header
	//$page_title = 'Welcome!';
	require_once('header.php');

	require_once('connectvars.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Show the navigation menu
	  require_once('navmenu.php');

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
		$searchapplicants = mysqli_query($dbc, "select * from user, student where (fname like '%{$_GET['search']}%' or minit like '%{$_GET['search']}%' or lname like '%{$_GET['search']}%') and user.uid = student.uid and degree = phd and gradapp = 1;");
		while ($searchapplicant = mysqli_fetch_array($searchapplicants)) {
			?>
		  
		  <label><?php echo $searchapplicant['fname']; echo ' ' . $searchapplicant['minit'] . '. '; echo $searchapplicant['lname'] . ' '; ?></label>
		  <form action='approvephd.php'>
		  <input type="hidden" name="uid" value="<?php echo $searchapplicant['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Approve" />
		  </form>
		  <form action='rejectphd.php'>
		  <input type="hidden" name="uid" value="<?php echo $searchapplicant['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Reject" />
		  </form>
		  <br>
		  <?php
		}
	
	  }
	else {
	// prints out everyone applying to graduate
	$applicants = mysqli_query($dbc, "select * from users, student where users.uid = student.uid and degree = 'PhD' and gradapp = 1;");
	while ($applicant = mysqli_fetch_array($applicants)) {
		?>
		<label><?php echo $applicant['fname']; echo ' ' . $applicant['minit'] . '. '; echo $applicant['lname'] . ' '; ?></label>
		  <form action='approvephd.php'>
		  <input type="hidden" name="dui" value="<?php echo $applicant['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Approve" />
		  </form>
		  <form action='rejectphd.php'>
		  <input type="hidden" name="uid" value="<?php echo $applicant['uid']?>" />
		  <input type="submit" class="button" name="decision" value="Reject" />
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
