<?php 
    // Start the session
    session_start();

    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    // Include navmenu 
    require_once('navMenus/navAppPortal.php'); 

    // Include db connection vars 
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html>
<head>
    <title> Applicant Portal </title>
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
<body>
<?php 
if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] != 0)) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'phase1/home.php';
            </script>
<?php } 
    $query = "SELECT fname from users where users.UID = '$uid'";
    $data = mysqli_query($dbc, $query);
    $r = mysqli_fetch_array($data);
    $acceptedName = $r['fname'];
?>

<h3>CONGRATULATIONS</h3>
<p>Dear <?php echo $acceptedName?>,
On behalf of the Admissions Committee, it is my pleasure to offer you admission to our University! You were identified as one of hte most talented and promising students in one our university's 
applicant pools ever. Your commitment to personal excellence makes yous tand out as someone who will thrive within the academic environment and our diverse community.
We expect great things from you and do hope that you choose our university as your home for the next four years! Below is a button to help you submit your deposit and once we recieve
the deposit, you will be matriculated into our school database as a student for the upcoming year!
</p>


<form action="" method="post">
<label for="cname">Cardholder Name:</label>
<input type="text" id="cname" name="cname" required>
<label for="card">Card Number:</label>
<input id="card" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx"  required>
<label for="expire">Expiration Date</label>
<select name="date" id="date" required>
    <option value="01">01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
</select>
<select name="" id="">
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
</select>
<br>
<input type="submit" id="accept_btn" class="btn btn-primary center-block" value="    Submit Deposit    "  name="accept_btn"/>
</form>

<?php
$query = "SELECT advisor from history where history.uid = '$uid'";
$data = mysqli_query($dbc, $query);
$r = mysqli_fetch_array($data);
$fullname = $r['advisor'];
$brokenupname = explode(" ", $fullname);
// echo $brokenupname[0] . $brokenupname[1];

$query = "SELECT appDate from history where history.uid = '$uid'";
$data = mysqli_query($dbc, $query);
$r = mysqli_fetch_array($data);
$admitDate = $r['appDate'];
$brokenupDate = explode(" ", $admitDate);


$query = "SELECT degree from history where history.uid = '$uid'";
$data = mysqli_query($dbc, $query);
$r = mysqli_fetch_array($data);
$studentDegree = $r['degree'];



$query = "SELECT UID from users where users.fname = '$brokenupname[0]' and users.lname = '$brokenupname[1]'";
$data = mysqli_query($dbc, $query);
$r = mysqli_fetch_array($data);
$advisorUID = $r['UID'];
// echo $advisorUID;

?>


<?php
//if they accept the offer, update the student's information in the user's table and the
//then store them into the student's table with the information from history where the UID's match
if(isset($_POST['accept_btn'])){
    //inserting the applicant as a student
    $query = "INSERT INTO student(uid,advisor,degree,form1status,admit_year) VALUES ('$uid', '$advisorUID', '$studentDegree', 0, '$brokenupDate[1]')";
    $data = mysqli_query($dbc, $query);
    if($data){
        echo "You are now a student!";
    }
    else{
        echo "Failed to make you a student";
    }

    $query = "UPDATE users SET typeUser = 5 WHERE users.UID = '$uid'";
    $data = mysqli_query($dbc, $query);
    if($data){
        echo "You are now a student type!";
        
    }
    else{
        echo "Failed to make you a student type";
    }
    ?>
    <script type="text/javascript">
        window.location.href = '../login.php';
    </script>
    <?php

    
    // header('Location: http://gwupyterhub.seas.gwu.edu/~sp20DBp2-dynamo/dynamo/apps/applicant.php');
}
?>