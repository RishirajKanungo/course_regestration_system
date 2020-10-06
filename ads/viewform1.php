<?php
session_start();


require_once('header.php');

require_once('connectvars.php');
// Show the navigation menu
require_once('navmenu.php');


if($_SESSION['acc_type'] == 6) {
                echo '<table id="t01">';
                $query = "SELECT * FROM student s, users a WHERE a.uid = s.uid AND advisor='" . $_SESSION['user_id'] . "'";
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $data = mysqli_query($dbc, $query);
                while($uid = mysqli_fetch_array($data)){

                        echo "User id:".$uid[0]." Name: " . $uid['fname'] . " " . $uid['lname'];
                        $query = "SELECT * FROM form1 f, courses c WHERE c.cno = f.cno AND f.dept = c.dept AND f.uid='" . $uid[0] . "'";

                        $dbc1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                        $data1 = mysqli_query($dbc1, $query);
                	if ( mysqli_num_rows($data1) >0) {
                                echo '<th>Department</th><th>Course Number</th><th>Course Title</th><th>Credits</th></tr>';
                                while($row = mysqli_fetch_array($data1)) {
                                                echo "<tr><td>".$row['dept'] . "</td><td>".  $row['cno'] . "</td><td>".  $row['title'] . "</td><td>".  $row['credits'] ."</td></tr>";

                        			echo "<br />";

                        	}
                	}
                echo " : Has no approved form one <br />";
                
                }

}
echo '</table>';
require_once('footer.php');
?>

