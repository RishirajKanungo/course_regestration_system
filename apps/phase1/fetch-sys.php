<?php
// UPDATES ALL USER DATA + FACULTY DATA THRU MODALS 
    require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // if (isset($_POST['fname'])) {
        $fname = $_POST['fname'];
        $minit = $_POST['minit'];
        $lname = $_POST['lname'];
        $uid = $_POST['uid'];
        $ssn = $_POST['ssn'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $typeUser = $_POST['typeUser'];
        if ($_POST['typeUser'] == 'Applicant') {
            $typeUser = '0';
        }
        else if ($_POST['typeUser'] == 'Faculty Reviewer') {
            $typeUser = '1';
        }
        else if ($_POST['typeUser'] == 'Chair') {
            $typeUser = '2';
        }
        else if ($_POST['typeUser'] == 'Grad Secretary') {
            $typeUser = '3';
        }
        else if ($_POST['typeUser'] == 'System Administrator') {
            $typeUser = '4';
        }

        $q = "UPDATE users SET fname = '$fname', minit = '$minit', lname = '$lname', UID = $uid, email = '$email', ssn = $ssn, username = '$username', password = '$password', typeUser = $typeUser, address = '$address' WHERE UID = $uid;";
        $r = mysqli_query($dbc, $q);
        echo mysqli_error($dbc);

        if (!$r){
            echo "Something went wrong. Unable to update user profile.";
            return 0;
        }
        else { 
            echo "User profile updated!";
            return 1; 
        }

    
