<?php

require_once('connectvars.php');

// incorrect login error message
$error_msg = "";
$db_msg = "";
// connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	switch ($_POST['form']) {
		case "reset":
			$mysql_host = 'localhost';
			$mysql_database = 'bits_please';
			$mysql_user = 'bits_please';
			$mysql_password = '404-Error!';
			$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
			$query = file_get_contents("reg_schema.sql");
			$schema = $db->prepare($query);
			if ($schema->execute())
				$db_msg = "Database reset.";
			else 
				$db_msg = "Oops! An error occurred while running the sql file.";
		break;
		case "login":
			if (!isset($_SESSION['role'])){
				session_start();
				// set the username and password the user entered
				$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
				$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
				
				// checks the user entered a username and password
				if (!empty($username) && !empty($password)) {
					$query = "SELECT username, role, account_id FROM account WHERE username = '" . $username . "' and password = '" . $password . "'";
					$data = mysqli_query($dbc, $query);
		
					// makes sure the login was valid
					if (mysqli_num_rows($data) == 1) { 
						$row = mysqli_fetch_array($data);
		
						// set the session variables
						$_SESSION['username'] = $row['username'];
						$_SESSION['account_id'] = $row['account_id'];
						$role  = $row['role'];
							$_SESSION['role'] = $role;
						
						if ($role == "student"){
							$idquery = "SELECT student_id FROM student WHERE a_id = '" . $_SESSION['account_id'] . "'";
							$iddata = mysqli_query($dbc, $idquery);
							$id = mysqli_fetch_array($iddata);
							$_SESSION['student_id'] = $id['student_id'];
						}
						else if ($role == "faculty"){
							$idquery = "SELECT faculty_id FROM faculty WHERE a_id = '" . $_SESSION['account_id'] . "'";
							$iddata = mysqli_query($dbc, $idquery);
							$id = mysqli_fetch_array($iddata);
							$_SESSION['faculty_id'] = $id['faculty_id'];
						}
						
						$home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/index.php';
							header('Location: ' . $home_url);
					}
					else {
						$error_msg = "Login failed. Please enter a valid username and password.";
					}
				}	
				$error_msg = "Please enter a valid username and password.";
			}	
		break;
	}
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
	<div style="background-image: url('https://www.gwu.edu/sites/g/files/zaxdzs2226/f/The%20George%20Washington%20University.jpg'); backgroun-size:cover">
	<div class="login-container">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="row">
		<h2 style="text-align:center; font-family: 'Secular One', sans-serif; font-size:200%; color: white;"><strong>Login</strong></h2>
		<div class="col">
			<input type="text" class="login-input" placeholder="Username" name="username" value="<?php if (!empty($username)) echo $username; ?>" required/>
			<input type="password" class="login-input" placeholder="Password" name="password" value="<?php if (!empty($password)) echo $password; ?>" required/>
    			<button value="login" class="login-button" name="form" type="submit">Login</button></form>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <button value="reset" class="login-button" name="form" type="submit">Reset Database</button> </form>
<?php 
if (empty($_SESSION['username'])) {
        echo '<p class="error" style="font-family:' . 'Secular One' . ', sans-serif; text-align:center;">' . $error_msg . $db_msg . '</p>';
}
?>
		</div>
		</div>
	</form>
	</div>
</html>


