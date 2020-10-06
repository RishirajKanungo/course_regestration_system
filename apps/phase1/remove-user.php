<?php echo 'here'; 

// DELETE USER FROM SYS ADMIN USING REMOVE PROFILE BUTTON 
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$uid_to_remove = $_POST['uid'];

$q = "SELECT typeUser FROM users WHERE users.UID = $uid_to_remove;";
$d = mysqli_query($dbc,$q);
$data = mysqli_fetch_array($d);

$typeUser = $data['typeUser'];

if ($typeUser == 0) {
    // REMOVE HISTORY
    $q1 = "DELETE FROM history WHERE history.UID = $uid_to_remove;";
    $d1 = mysqli_query($dbc,$q1);
    mysqli_error($dbc);

    //REMOVE RATINGS
    $q2 = "DELETE FROM ratings WHERE ratings.UID = $uid_to_remove;";
    $d2 = mysqli_query($dbc,$q2);
    mysqli_error($dbc);

    //REMOVE APP
    $q3 = "DELETE FROM app WHERE app.UID = $uid_to_remove;";
    $d3 = mysqli_query($dbc,$q3);
    mysqli_error($dbc);

    //REMOVE PRIOR DEGREES
    $q4 = "DELETE FROM priorDegrees WHERE priorDegrees.UID = $uid_to_remove;";
    $d4 = mysqli_query($dbc,$q4);
    mysqli_error($dbc);

    //REMOVE TESTS
    $q5 = "DELETE FROM tests WHERE tests.UID = $uid_to_remove;";
    $d5 = mysqli_query($dbc,$q5);
    mysqli_error($dbc);

    //REMOVE USER
    $q5 = "DELETE FROM users WHERE users.UID = $uid_to_remove;";
    $d5 = mysqli_query($dbc,$q5);
    mysqli_error($dbc);
}
else {
    //REMOVE USER iF NOT APPLICANT
    $q6 = "DELETE FROM users WHERE users.UID = $uid_to_remove;";
    $d6 = mysqli_query($dbc,$q6);
    mysqli_error($dbc);
}

?>