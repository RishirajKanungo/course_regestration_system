<!DOCTYPE html>
<html>
<head>
    <title> Application </title>
    <!-- <link rel="stylesheet" type="text/css" href="portalCSS/style.css"> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   <script src="./js/validapp.js"></script>
   <link href="./css/style.css" red="stylesheet">
   <link href="./css/sysad.css" red="stylesheet">
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
<body></body>
</html>

<?php 
// SAVE AND SUBMIT APPLICATIONS (REDIRECTED TO FROM VALIDAPP)
session_start();
require_once('../connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// APPLICANT UID
$uid = $_SESSION['uid'];
echo $uid;

// UPDATE APP
$appDegree = $_POST['appDegree'];
$interests = $_POST['interests'];
$work = $_POST['work'];
$admitDate = $_POST['admitDate'];

// RECOMMENDER DATA
$title = $_POST['title'];
$firstN = $_POST['firstN'];
$mid = $_POST['mid'];
$lastN = $_POST['lastN'];
$recEmail = $_POST['recemail'];
$company = $_POST['company'];

// TESTS DATA 
$verbal = $_POST['verbal'];
$quantitative = $_POST['quant'];
$total = $_POST['total'];
$GREdate = $_POST['GREdate'];
$subject = $_POST['subject'];
$subjectScore = $_POST['subjectScore'];
$subjectDate = $_POST['subjectDate'];
$subject2 = $_POST['subject2'];
$subjectScore2 = $_POST['subjectScore2'];
$subjectDate2 = $_POST['subjectDate2'];
$subject3 = $_POST['subject3'];
$subjectScore3 = $_POST['subjectScore3'];
$subjectDate3 = $_POST['subjectDate3'];
$TOEFLscore = $_POST['TOEFLscore'];
$TOEFLdate = $_POST['TOEFLdate'];

// PRIOR DEGREES DATA
$Btype = $_POST['Btype'];
$Buniversity = $_POST['Buniversity'];
$ByearDegree = $_POST['ByearDegree'];
$Bmajor = $_POST['Bmajor'];
$BGPA = $_POST['BGPA'];
$Mtype = $_POST['Mtype'];
$Muniversity = $_POST['Muniversity'];
$MyearDegree = $_POST['MyearDegree'];
$Mmajor = $_POST['Mmajor'];
$MGPA = $_POST['MGPA'];

/** Update app table **/
$query = "SELECT UID FROM app WHERE app.UID='$uid'";
$data = mysqli_query($dbc, $query); 
$numRows = mysqli_num_rows($data); 

// Create new row in app for user  
if ($numRows == 0) { 
  $query = "INSERT INTO app (UID) VALUES ($uid)";
  mysqli_query($dbc, $query); 

  // Set default statuses in application 
  $query = "UPDATE app SET decisionStatus='Pending', submissionStatus='In Progress', recStatus='Not Received', transcriptStatus='Not Received' WHERE app.UID='$uid'";
  mysqli_query($dbc, $query); 
}

// We only want to update fields that have input 
$update_arr = array();
if ($appDegree != "") {
  $update_arr[] = "degree='".$appDegree."'";
}
if ($admitDate != "") {
  $update_arr[] = "appDate='".$admitDate."'";
}
if ($interests != "") {
  $update_arr[] = "interests='".$interests."'";
}
// if ($recEmail != "") {
//   $update_arr[] = "recEmail='".$recEmail."'";
// }
if ($work != "") {
  $update_arr[] = "workExperience='".$work."'";
}

// array of values we want to update in app 
$update_values = implode(', ', $update_arr);

if (!empty($update_values)) {
  $queryTests = "UPDATE app SET $update_values WHERE app.UID=$uid"; 
  mysqli_query($dbc, $queryTests);
}

/** Update tests table **/
$query = "SELECT UID FROM tests WHERE tests.UID='$uid'";
$data = mysqli_query($dbc, $query); 
$numRows = mysqli_num_rows($data); 

// Create new row in tests for user  
if ($numRows == 0) {
  $query = "INSERT INTO tests (UID) VALUES ($uid)";
  mysqli_query($dbc, $query); 
}

// We only want to update fields that have input 
$update_arr = array();
if ($quantitative != "") {
  $update_arr[] = "quantitative='".$quantitative."'";
}
if ($verbal != "") {
  $update_arr[] = "verbal='".$verbal."'";
}
if ($subjectScore != "") {
  $update_arr[] = "subjectScore='".$subjectScore."'";
}
if ($subject != "") {
  $update_arr[] = "subject='".$subject."'";
}
if ($total != "") {
  $update_arr[] = "total='".$total."'";
}
if ($GREdate != "") {
  $update_arr[] = "GREdate='".$GREdate."'";
}
if ($subjectDate != "") {
  $update_arr[] = "subjectDate='".$subjectDate."'";
}
if ($TOEFLscore != "") {
  $update_arr[] = "TOEFLscore='".$TOEFLscore."'";
}
if ($TOEFLdate != "") {
  $update_arr[] = "TOEFLdate='".$TOEFLdate."'";
}
if ($subjectScore2 != "") {
    $update_arr[] = "subjectScore2='".$subjectScore2."'";
}
if ($subject2 != "") {
    $update_arr[] = "subject2='".$subject2."'";
}
if ($subjectDate2 != "") {
    $update_arr[] = "subjectDate2='".$subjectDate2."'";
}
if ($subjectScore3 != "") {
    $update_arr[] = "subjectScore3='".$subjectScore3."'";
}
if ($subject3 != "") {
    $update_arr[] = "subject3='".$subject3."'";
}
if ($subjectDate3 != "") {
    $update_arr[] = "subjectDate3='".$subjectDate3."'";
}

// array of values we want to update in tests 
$update_values = implode(', ', $update_arr);

if (!empty($update_values)) {
  $queryTests = "UPDATE tests SET $update_values WHERE tests.UID=$uid"; 
  mysqli_query($dbc, $queryTests);
}

/** Update recommender table **/
$query = "SELECT email FROM recommenders WHERE recommenders.email='$recEmail'";
$data = mysqli_query($dbc, $query); 
$numRows = mysqli_num_rows($data); 

// Create new row in app for recommender  
if (($numRows == 0) && ($recEmail !="")) {
$query = "INSERT INTO recommenders (email) VALUES ('$recEmail')";
mysqli_query($dbc, $query); 
}

// We only want to update fields that have input 
$update_arr = array();
if ($title != "") {
$update_arr[] = "title='".$title."'";
}
if ($firstN != "") {
$update_arr[] = "fname='".$firstN."'";
}
if ($mid != "") {
$update_arr[] = "minit='".$mid."'";
}
if ($lastN != "") {
$update_arr[] = "lname='".$lastN."'";
}
if ($company != "") {
  $update_arr[] = "company='".$company."'";
}

// array of values we want to update in app 
$update_values = implode(', ', $update_arr);

if (!empty($update_values)) {
$queryRec = "UPDATE recommenders SET $update_values WHERE recommenders.email='$recEmail'"; 
mysqli_query($dbc, $queryRec);
}

/** Update priorDegrees table **/
$query = "SELECT UID FROM priorDegrees WHERE priorDegrees.UID='$uid'";
$data = mysqli_query($dbc, $query); 
$numRows = mysqli_num_rows($data); 

// Create new row in priorDegrees for user  
if ($numRows == 0) { 
$query = "INSERT INTO priorDegrees (UID) VALUES ($uid)";
mysqli_query($dbc, $query); 
}

// We only want to update fields that have input 
$update_arr = array();
if ($Btype != "") {
$update_arr[] = "BtypeDegree='".$Btype."'";
}
if ($Buniversity != "") {
$update_arr[] = "Buniversity='".$Buniversity."'";
}
if ($BGPA != "") {
$update_arr[] = "BGPA='".$BGPA."'";
}
if ($Bmajor != "") {
$update_arr[] = "Bmajor='".$Bmajor."'";
}
if ($ByearDegree != "") {
$update_arr[] = "ByearDegree='".$ByearDegree."'";
}
if ($Mtype != "") {
$update_arr[] = "MtypeDegree='".$Mtype."'";
}
if ($Muniversity != "") {
$update_arr[] = "Muniversity='".$Muniversity."'";
}
if ($MGPA != "") {
$update_arr[] = "MGPA='".$MGPA."'";
}
if ($Mmajor != "") {
$update_arr[] = "Mmajor='".$Mmajor."'";
}
if ($MyearDegree != "") {
$update_arr[] = "MyearDegree='".$MyearDegree."'";
}

// array of values we want to update in app 
$update_values = implode(', ', $update_arr);

if (!empty($update_values)) {
$queryTests = "UPDATE priorDegrees SET $update_values WHERE priorDegrees.UID=$uid"; 
mysqli_query($dbc, $queryTests);
}

/* Update Letters table */ 
$query = "SELECT recEmail FROM letters WHERE letters.UID='$uid' AND letters.recEmail='$recEmail'";
$data = mysqli_query($dbc, $query); 
$numRows = mysqli_num_rows($data); 
$isEmail = 0;

// Create new row in letters for user if none 
if (($numRows == 0) && ($recEmail !="")) { 
  $query = "INSERT INTO letters (UID, recEmail) VALUES ('$uid', '$recEmail')";
  mysqli_query($dbc, $query); 
}

else if ($numRows != 0){
  while ($row = mysqli_fetch_array($data)){
      if (strcmp($row['recEmail'], $recEmail) == 0) {
        $isEmail = 1;
      }
  }
}

if (($isEmail == 0) && ($recEmail !="")) { 
  $query = "INSERT INTO letters (UID, recEmail) VALUES ('$uid', '$recEmail')";
  mysqli_query($dbc, $query); 
}

?>
<!-- // Redirect to saved confirmation page  -->
<script type="text/javascript">
    alert("Your application has been saved");
    window.location.href = '../applicant.php';
</script>

