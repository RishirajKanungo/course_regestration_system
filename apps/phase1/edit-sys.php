<?php require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // EDIT SYSTEM ADMIN PROFILE OFF OF PROFILE PANE IN SYSADMIN.PHP
    
    $fname = $_POST['fname'];
    $minit = $_POST['minit'];
    $lname = $_POST['lname'];
    $uid = $_POST['uid'];
    $ssn = $_POST['ssn'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ogUID = $_POST['ogUID'];
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

    $q = "UPDATE users SET fname = '$fname', minit = '$minit', lname = '$lname', UID = $uid, email = '$email', ssn = '$ssn', username = '$username', password = '$password', typeUser = $typeUser, address = '$address' WHERE UID = $ogUID;";
    $r = mysqli_query($dbc, $q);
    echo mysqli_error($dbc);

    if (!$r){ ?>
        <script>console.log("error");</script>
        <?php return '0';
    }
    else { 
        return '1'; 
    }
?>