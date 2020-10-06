<?php
	session_start();

	require_once('header.php');
	require_once('navmenu.php');
	echo '<head>';
	echo '<title>Assign fauluty advisors</title>';
	require_once('connectvars.php');
	


	if(isset($_SESSION['acc_type']) && $_SESSION['acc_type'] == 3) {

		if ($_SERVER["REQUEST_METHOD"] == "POST"){ 

			$studid = $_POST['studid'];
			$advidid = $_POST['advidid'];

			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				

			$query = "update student set advisor = $advidid where uid = $studid;";
        	$data = mysqli_query($dbc, $query);               
		}
	}

   
?>
 <form action="assignadvisor.php" method="post">
   <label for="studid">Student ID:</label>
   <input type="number" id="studid" name="studid" required>
   <label for="advidid">Advisor ID:</label>
   <input type="number" id="advidid" name="advidid" required><br>
   </br><input type="submit" class="button" name ="assign" value="Assign">
 </form>
<?php
        require_once('footer.php');
?>
