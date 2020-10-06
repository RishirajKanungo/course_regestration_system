<!DOCTYPE html>
<html>
<head>
    <title>Submit Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text&display=swap" rel="stylesheet">
   <script src="./js/validapp.js"></script>
   <link href="./css/style.css" red="stylesheet">
   <link href="./css/sysad.css" red="stylesheet">
   <style>
        span{
            color:#ac2424;
            font-size: 14px;
            font-style:italics;
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
</head>
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
    $q = "SELECT UID FROM app WHERE app.UID='$uid'";
    $d = mysqli_query($dbc, $q); 
    if (!$d){
      return 0;
    }
    $numRows = mysqli_num_rows($d); 

    // Create new row in app for user  
    if ($numRows == 0) { 
      $q1 = "INSERT INTO app (UID) VALUES ($uid)";
      $d1 = mysqli_query($dbc, $q1); 
      if (!$d1){
        return 0;
      }

      // Set default statuses in application 
      $q2 = "UPDATE app SET decisionStatus='Pending', submissionStatus='In Progress', recStatus='Not Received', transcriptStatus='Not Received', recEmail='$recEmail' WHERE app.UID='$uid'";
      $d2 = mysqli_query($dbc, $q2); 
      if (!$d2) { return 0; }
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
      $d3 = mysqli_query($dbc, $queryTests);
      if (!$d3) { return 0; }
    }

    /** Update tests table **/
    $q4 = "SELECT UID FROM tests WHERE tests.UID='$uid'";
    $d4 = mysqli_query($dbc, $q4); 
    if (!$d4) { return 0; }
    $numRows = mysqli_num_rows($d4); 

    // Create new row in tests for user  
    if ($numRows == 0) {
      $q5 = "INSERT INTO tests (UID) VALUES ($uid)";
      $d5 = mysqli_query($dbc, $q5); 
      if (!$d5) { return 0; }
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
      $q6 = "UPDATE tests SET $update_values WHERE tests.UID=$uid"; 
      $d6 = mysqli_query($dbc, $q6);
      if (!$d6) { return 0; }
    }
  
  /** Update recommender table **/
  $q7 = "SELECT email FROM recommenders WHERE recommenders.email='$recEmail'";
  $d7 = mysqli_query($dbc, $q7); 
  if (!$d7) { return 0; }
  $numRows = mysqli_num_rows($d7); 

  // Create new row in app for recommender  
  if ($numRows == 0) {
    $q8 = "INSERT INTO recommenders (email) VALUES ('$recEmail')";
    $d8 = mysqli_query($dbc, $q8); 
    if (!$d8) { return 0; }
  }
 
  // We only want to update fields that have input 
  $update_arr = array();
  if ($firstN != "") {
    $update_arr[] = "fname='".$firstN."'";
  }
  if ($mid != "") {
    $update_arr[] = "minit='".$mid."'";
  }
  if ($lastN != "") {
    $update_arr[] = "lname='".$lastN."'";
  }
  if ($title != "") {
    $update_arr[] = "title='".$title."'";
  }
  if ($company != "") {
    $update_arr[] = "company='".$company."'";
  }
  
  // array of values we want to update in app 
  $update_values = implode(', ', $update_arr);

  if (!empty($update_values)) {
    $queryTests = "UPDATE recommenders SET $update_values WHERE recommenders.email='$recEmail'"; 
    mysqli_query($dbc, $queryTests);
  }

  /** Update priorDegrees table **/
  $q9 = "SELECT UID FROM priorDegrees WHERE priorDegrees.UID='$uid'";
  $d9 = mysqli_query($dbc, $q9); 
  if (!$d9) { return 0; }
  $numRows = mysqli_num_rows($d9); 

  // Create new row in priorDegrees for user  
  if ($numRows == 0) { 
    $q10 = "INSERT INTO priorDegrees (UID) VALUES ($uid)";
    $d10 = mysqli_query($dbc, $q10); 
    if (!$d10) { return 0; }
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
    $q11 = "UPDATE priorDegrees SET $update_values WHERE priorDegrees.UID=$uid;"; 
    $d11 = mysqli_query($dbc, $q11);
    if (!$d11) { return 0; }
  }

  /* If recommender does not have an account */ 
  $q12 = "SELECT password FROM recommenders WHERE recommenders.email='$recEmail'";
  $d12 = mysqli_query($dbc, $q12); 
  $row = mysqli_fetch_array($d12);
  if (!$d12) { return 0; }
   
  if ($row['password'] == NULL) {
    // Generate random password of length 8 for recommender login 
    function generate_password($length = 8) {
      $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
      $str = '';
      $maxLen = strlen($chars) - 1;
  
      for ($i=0; $i < $length; $i++) {
        $str .= $chars[random_int(0, $maxLen)];
      }
      return $str;
    }

    // generate password of length 8 for recommender login
    $password = generate_password();
  
    // update db 
    $q13 = "UPDATE recommenders SET password='$password' WHERE recommenders.email='$recEmail'";
    $d13 = mysqli_query($dbc, $q13); 
    if (!$d13) { return 0; }

    // get name of student 
    $q14 = "SELECT fname, lname FROM users WHERE users.UID='$uid'";
    $d14 = mysqli_query($dbc, $q14); 
    if (!$d14) { return 0; }
    $row = mysqli_fetch_array($d14);
    $studentName = $row['fname'] . " " . $row['lname'];

    // Email recommender 
    $to = $recEmail;
    $subject = "Recommendation Letter Request | Account Creation";
    $txt = "An applicant has requested that you submit a recommendation letter on their behalf. An account was created for you 
    to review and submit letter requests. Login to your account with the 
    credentials below at http://gwupyterhub.seas.gwu.edu/~sp20DBp1-clout_computing/clout_computing/phase1/home.php to complete it.
    \n Username: " . $recEmail . "\n Password: " . $password;
    $headers = "From: admissions" . "\r\n";
    mail($to,$subject,$txt,$headers);
  }

  /* If recommender already has account */
  else {
    // Email recommender 
    $to = $recEmail;
    $subject = "Recommendation Letter Request";
    $txt = "An applicant has requested that you submit a recommendation letter on their behalf. Login to your existing account  
    at http://gwupyterhub.seas.gwu.edu/~sp20DBp1-clout_computing/clout_computing/phase1/home.php to complete it.";
    $headers = "From: admissions" . "\r\n";
    mail($to,$subject,$txt,$headers);
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


  // Update app submissionStatus to completed 
  $q15 = "UPDATE app SET submissionStatus='Submitted' WHERE app.UID='$uid'";
  $d15 = mysqli_query($dbc, $q15); 
  if (!$d15) { return 0; }
?>
<!-- // Redirect to submitted confirmation page  -->
<script type="text/javascript">
      alert("Thank you for submitting an application! You will now be redirected to your portal");
      window.location.href = '../applicant.php'; 
</script>
