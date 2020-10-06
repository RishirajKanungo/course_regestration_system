<?php 
    // REC PROFILE UPDATE QUERY FROM SYS ADMIN REC MODAL
    require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_POST['fname'])) {
        $fname = $_POST['fname'];
        $minit = $_POST['minit'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $password = $_POST['password'];
        $ogEmail = $_POST['ogEmail'];


        $q = "UPDATE recommenders SET fname = '$fname', minit='$minit', lname = '$lname', email = '$email', title ='$title', password = '$password', company = '$company' WHERE email = '$ogEmail';";
        $d = mysqli_query($dbc, $q);
        if (!$d) {
            echo "Something went wrong. Unable to update recommender profile.";
            return 0;
        }
        else {
            echo "Recommender profile updated!";
            return 1;
        }
    }
    
?>