<?php 
    session_start();
    require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // require './js/js-sysadmin.php';
?>
<!DOCTYPE html> 
<head>
    <title>System Administrator</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="js/sysad.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text&display=swap" rel="stylesheet">

</head>
<style>
    .error{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
}
span{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
}
input[type=button] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=button]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
a[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
a[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=submit] {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
input[type=submit]:hover {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
}
</style>
<?php
       if (isset($_POST['fname'])){
            $newfname = $_POST['fname'];
            $newminit = $_POST['minit'];
            $newlname = $_POST['lname'];
            $newuid = $_POST['uid'];
            $newemail = $_POST['email'];
            $newssn = $_POST['ssn'];
            $newusername = $_POST['username'];
            $newpass = $_POST['password'];
            $newtype = $_POST['typeUser'];
            $newaddress = $_POST['address'];
            $olduid = $_POST['oldUID']
            ?>
            <script>console.log("in sysupdates.php")</script>
            <?php
            $edit_query = "UPDATE users 
                            SET fname = '$newfname', minit = '$newminit',
                                lname = '$newlname', uid = '$newuid', 
                                email = '$newemail', ssn = '$newssn',
                                username = '$newusername', password = '$newpass',
                                typeUser = '$newtype', address = '$newaddress'
                            WHERE uid = $olduid;";
            $run_query = mysqli_query($dbc, $edit_query);
            ?>
            <script>console.log("ran query")</script>
            <?php
            if (!$run_query){
                ?>
                <script>console.log("something went wrong");</script>
            <?php
            }
            else { ?>
                <script>
                console.log("query success");
                </script>

            <?php }
        }
    ?>