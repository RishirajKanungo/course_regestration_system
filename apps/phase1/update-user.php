<?php 

// QUERIES FOR UPDATEPROFILE.PHP
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $uid = $_POST['uid'];
        $fname = $_POST['fname'];
        $minit = $_POST['minit'];
        $lname = $_POST['lname'];
        $ssn = $_POST['ssn'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $q = "UPDATE users SET fname = '$fname', minit = '$minit', lname = '$lname', ssn = $ssn, address = '$address', email = '$email', password = '$password' WHERE UID = $uid;";
        $r = mysqli_query($dbc, $q);
        echo mysqli_error($dbc);
    
        if (!$r){ ?>
            <script>console.log("error");</script>
            <?php return '0';
        }
        else { 
            return '1'; 
        }