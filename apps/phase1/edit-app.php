
<!DOCTYPE html> 
<head>


    <!-- EDIT USER APP HISTORY AS SYSADMIN FROM FULLAPPS.PHP-->
    <title>View Applicant History</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/sysad.css" rel="stylesheet">
    <script src="js/sysad.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>
<body>
</body>
</html>

<?php
    session_start();
    require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!isset($_SESSION['uid']) && !isset($_SESSION['typeUser']) || ($_SESSION['typeUser']) != '4' ) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'home.php';
            </script>
        <?php
    }
    else { 
        // SYS ADMIN UID
        $uid_inuse = $_SESSION['uid'];
        // echo $_SESSION['uid'];

        if (isset($_POST['fname'])){
            $ogUID = $_POST['ogUID'];

            // USER TABLE CREDS 
            $fname = $_POST['fname'];
            $minit = $_POST['minit'];
            $lname = $_POST['lname'];
            $uid = $_POST['uid'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $ssn = $_POST['ssn'];
            $username = $_POST['username'];
            $password = $_POST['password'];
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
            $decision = $_POST['decisionStatus'];
            $appDate = $_POST['appDate'];

            // UPDATE USER TABLE
            $q = "UPDATE users SET fname = '$fname', minit = '$minit', lname = '$lname', UID = $uid, email = '$email', ssn = '$ssn', username = '$username', password = '$password', typeUser = '$typeUser', address = '$address' WHERE UID = $ogUID;";
            $r = mysqli_query($dbc, $q);
            echo mysqli_error($dbc);

            $q1 = "UPDATE app SET decisionStatus = '$decision' WHERE UID = $ogUID;";
            $r1 = mysqli_query($dbc, $q1);
            echo mysqli_error($dbc);

            $q1 = "UPDATE history SET decisionStatus = '$decision' WHERE UID = $ogUID AND appDate = $appDate;";
            $r1 = mysqli_query($dbc, $q1);
            echo mysqli_error($dbc);

            if (!$r || !$r1){
                return '0';
            }
            else { 
                return '1'; 
            }
         }
    }

?>