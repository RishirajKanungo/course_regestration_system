<?php
        // Start the session
        session_start();

        // Insert the page header
//$page_title = 'Welcome!'
         $pg_title = "Create New User";
        require_once('header.php');
        $degreeErr = "";
        require_once('connectvars.php');
        // Show the navigation menu
        require_once('navmenu.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
                // Connect to the database
                require_once('connectvars.php');
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $studid = $_POST['studid'];
                $uname = $_POST['uname'];
                $pass = $_POST['password'];
                $fname = $_POST['fname'];
                $minit = $_POST['minit'];
                $lname = $_POST['lname'];
                $dob = $_POST['dob'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $acctype = $_POST['acctype'];
                $degree = $_POST['degree'];

                $gpa = $_POST['gpa'];
                $gradyear = $_POST['gradyear'];
                $ssn = $_POST['ssn'];

                if( ($acctype == 8 || $acctype == 5)  && empty($degree)  && !(strcmp($degree, 'MS') == 0 || strcmp($degree, 'PhD') == 0)){
                                echo '<p class="error"><font color="red"> Need a degree when creating a student or alumni</font></p>';

                }

                else if($acctype == 8 && (empty($gradyear) || empty($gpa))){
                                echo '<p class="error"><font color="red"> Need a Graduation year and gpa when creating an alumni</font></p>';

                }



                else if(isset($_SESSION['acc_type']) &&  $_SESSION['acc_type'] == 4 && !empty($fname)){//checks permissions and if the form was entered
<<<<<<< HEAD
                        $query = "insert into users values ($studid, '$uname', '$pass', '$fname', '$minit', '$lname', '$ssn', '$acctype', '$address', '$email','$dob');";
=======
                        $query = "insert into users values ($studid, '$uname', '$pass', '$fname', '$minit', '$lname', '$ssn', '$acctype', '$address', '$email', '$dob');";
>>>>>>> cf5b02866d459d0676885cd3875291b54fdd3c26
                        $data = mysqli_query($dbc, $query);
                        //echo $query;

                        if($acctype == 5) {
                                $query = "insert into student values ($studid, '$degree', '$gpa', NULL);";
                                $data = mysqli_query($dbc, $query);
                        }


                        if($acctype == 8){
                                
                                $query = "insert into alumni values ($studid, '$degree', '$gpa', '$gradyear');";
                                $data = mysqli_query($dbc, $query);
                        
                        }
			   //echo $query;

                }


        }

 ?>
<table>
 <form action="createnewuser.php" method="post">
    <tr>
   <label for="studid">User id:</label>
   <input type="text" id="studid" name="studid" required>
   </tr><br>
   <tr>



   <tr>
   <label for="uname">Username:</label>
   <input type="text" id="uname" name="uname" required>
   </tr><br>
   <tr>

   <label for="password">Password :</label>

   <input type="text"  id="password" name="password" required>
   </tr><br>

   <tr>
   <label for="fname">First Name:</label>
   <input type="text"  id="fname" name="fname" required>
   </tr><br>
   <tr>
   <label for="minit">Middle Intial:</label>
   <input type="text"  id="minit" name="minit">
   </tr><br>

   <tr>
    <label for="lname">Last Name:</label>
   <input type="text" id="lname" name="lname" required>
   </tr><br>


   <tr>
   <label for="ssn">SSN:</label>
   <input type="number" id="ssn" name="ssn">
   </tr><br>
<tr>
   <label for="address">Address:</label>
   <input type="text" id="address" name="address" required>
   </tr><br>

   <tr>
   <label for="email">Email:</label>
   <input type="email" id="email" name="email" required>
   </tr><br>

   <tr>
   <label for="acctype">Account type:</label>
   <input type="number" id="acctype" name="acctype" min = "0" max = "8" required>
   </tr><br>

   <tr>
   <label for="degree">Degree:</label>
   <input type="text" id="degree" name="degree">
   </tr><br>

  <tr>
  <label for="gpa">Gpa :</label>
 <input type="number" id="gpa" name="gpa" min = "0" value = "0" step = ".01">
</tr><br>
<tr>
   <label for="gradyear">Graduation Year :</label>
   <input type="text" id="gradyear" name="gradyear"></tr><br>

  <input type="submit" name ="create" value="create">

 </form>
</table>



 <?php
  require_once('footer.php');
?>
<<<<<<< HEAD
=======

>>>>>>> 9e02113bc9f63c95359a373a41e4d1f8c59f3c41
