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
    <title> Application </title>
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
   <script src="./phase1/js/validapp.js"></script>
</head>
<body>
<?php 
if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] != 0)) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = './phase1/home.php';
            </script>
<?php } ?>
<form id="application-form" method="POST" action="">
<?php  
  $query = ("SELECT * 
             FROM users
             WHERE users.UID='$uid'"); 
  $data = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($data);
?>
  <!-- Personal Information -->
  <h3> Personal Information </h3>
  <p>HELLO HELLO </p>
  <p> *Note: If you need to update your personal information, click on 'Update Profile' in the navmenu </p>
  <b>First Name: </b> <?php echo $row['fname']?> </br>
  <b>Middle Initial: </b> <?php echo $row['minit']?> </br>
  <b>Last Name: </b> <?php echo $row['lname']?> </br>
  <b>SSN: </b> <?php echo $row['ssn']?> </br>
  <b>Address: </b> <?php echo $row['address']?> </br>
  <b>Email: </b> <?php echo $row['email']?> </br>
  <b>User ID: </b> <?php echo $uid?> </br>


  <!-- General Info -->
  <h3> General Info </h3>
  <!-- Drop down bar to select MS or PhD -->
  <?php 
    $query = ("SELECT * 
               FROM app 
               WHERE app.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>

  <label for="appDegree">Applying for Degree: </label>
  <select id="appDegree" name="appDegree">
  <?php 
    if (strcmp($row['degree'], "PhD") == 0) { ?>
        <option value="PhD" selected>PhD</option>
        <option value="MS">MS</option>
    <?php }
    else if (strcmp($row['degree'], "MS") == 0){ ?>
        <option value="MS" selected>MS</option>
        <option value="PhD">PhD</option>
    <?php } 
    else { ?>
      <option selected></option>
      <option value="MS">MS</option>
      <option value="PhD">PhD</option>
    <?php } ?>   
  </select> </br>

  <b>Areas of Interest</b> <input type="text" value="<?php echo $row['interests']?>" name="interests"/> </br>
  <b>Work Experience</b> <input type="text" value="<?php echo $row['workExperience']?>" name="workExperience"/> </br>

  <!-- Admission Sem/Year Drop Down -->
  <label for="admitDate">Admission Date: </label>
  <select id="admitDate" name="admitDate">
  <?php
    $query = ("SELECT appDate
               FROM history
               WHERE history.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);

    // Four possible options if no prev apps 
    $f20 = 1; 
    $s21 = 1;
    $f21 = 1;
    $s22 = 1;
    
    // Determine which semesters the applicant has already applied to 
    while ($row = mysqli_fetch_array($data)) {
      if (in_array($row['appDate'], ['Fall 2020', 'Spring 2021', 'Fall 2021', 'Spring 2022'])) {
        if (strcmp($row['appDate'], "Fall 2020") == 0) {
          $f20 = 0;
        }
        else if (strcmp($row['appDate'], "Spring 2021") == 0) {
          $s21 = 0;
        }
        else if (strcmp($row['appDate'], "Fall 2021") == 0) {
          $f21 = 0;
        }
        else if (strcmp($row['appDate'], "Spring 2022") == 0) {
          $s22 = 0;
        }
      }
    }

    $query = ("SELECT appDate
               FROM app
               WHERE app.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    
    // Load saved appDate if any
    if (strcmp($row['appDate'], "Fall 2020") == 0) { ?>
      <option value="Fall 2020" selected>Fall 2020</option>
    <?php }
    else if (strcmp($row['appDate'], "Spring 2021") == 0) { ?>
      <option value="Spring 2021" selected>Spring 2021</option>
    <?php }
    else if (strcmp($row['appDate'], "Fall 2021") == 0) { ?>
      <option value="Fall 2021" selected>Fall 2021</option>
    <?php }
    else if (strcmp($row['appDate'], "Spring 2022") == 0) { ?>
      <option value="Spring 2022" selected>Spring 2022</option>
    <?php }
    else { ?>
      <option selected></option>
    <?php }

    if ($f20 == 1){ ?>
      <option value="Fall 2020">Fall 2020</option>
    <?php }
    if ($s21 == 1){ ?>
      <option value="Spring 2021">Spring 2021</option>
    <?php }
    if ($f21 == 1){ ?>
      <option value="Fall 2021">Fall 2021</option>
    <?php }
    if ($s22 == 1){ ?>
      <option value="Spring 2022">Spring 2022</option>
    <?php } ?>
    </select>


  <!-- Recommender Info -->
  <h4> Recommender Info </h4>
  <?php 
    $query = ("SELECT title, recommenders.fname AS firstN, recommenders.minit AS mid, recommenders.lname AS lastN, recEmail, company
               FROM recommenders, app 
               WHERE app.UID='$uid' AND app.recEmail=recommenders.email"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
  <p> *Note: Credentials and instructions for recommenders will be sent once you submit your application </p>
  <b>Title:</b><input type="text" value="<?php echo $row['title']?>" name="title"/></br>
  <b>First Name:</b><input type="text" value="<?php echo $row['firstN']?>"name="fname"/> </br>
  <b>Middle Initial:</b><input type="text" value="<?php echo $row['mid']?>"name="minit"/> </br>
  <b>Last Name:</b><input type="text" value="<?php echo $row['lastN']?>"name="lname"/></br>
  <b>Email:</b><input type="text" value="<?php echo $row['recEmail']?>"name="email"/> 
  <b>From:</b><input type="text" value="<?php echo $row['company']?>"name="company"/> 


  <!-- Academic Info  -->
  <h3> Academic Information </h3>
  <!-- GRE & TOEFL Scores -->
  <h4> Test Scores </h4>
  <?php 
    $query = ("SELECT * 
               FROM tests 
               WHERE tests.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
   <b>GRE Verbal Score:</b><input type="text" value="<?php echo $row['verbal']?>" name="verbal" id="verbal"/> 
   <b>Quantitative Score:</b> <input type="text" value="<?php echo $row['quantitative']?>" name="quantitative"/> 
   <b>Total:</b><input type="text" value="<?php echo $row['total']?>" name="total"/> 
   <b>Date of Exam:</b><input type="text" value="<?php echo $row['GREdate']?>" name="GREdate"/> </br>
   <b>GRE Advanced Subject:</b> <input id="subject" type="text" value="<?php echo $row['subject']?>" name="subject" id="subject"/> 
   <b>Score:</b><input type="text" id="subjectScore" value="<?php echo $row['subjectScore']?>" name="subjectScore"/> 
   <b>Date of Exam:</b> <input type="text" id="subjectDate" value="<?php echo $row['subjectDate']?>" name="subjectDate"/> </br>
   <b>TOEFL Score:</b> <input type="text" value="<?php echo $row['TOEFLscore']?>" name="TOEFLscore" id="TOEFL"/> 
   <b>Date of Exam:</b> <input type="text" value="<?php echo $row['TOEFLdate']?>" name="TOEFLdate"/> </br>

   <!-- Prior Degree Info -->
  <h4> Prior Degrees </h4>
  <?php 
    $query = ("SELECT * 
               FROM priorDegrees 
               WHERE priorDegrees.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
  <!-- Bachelors Degree Info -->
  <label for="priorDeg">Prior Degree (Bachelors) </label>
  <select id="priorDeg" name="Btype">
  <?php
    if (strcmp($row['BtypeDegree'], "BA") == 0) { ?>
        <option value="BA" selected>BA</option>
        <option value="BS">BS</option>
    <?php }
    else if (strcmp($row['BtypeDegree'], "BS") == 0) { ?>
        <option value="BS" selected>BS</option>
        <option value="BA">BA</option>
    <?php } 
    else { ?>
        <option selected> </option>
        <option value="BS" >BS</option>
        <option value="BA">BA</option>
    <?php } ?> 
  </select> 
  <b>University</b> <input type="text" value="<?php echo $row['Buniversity']?>" name="Buniversity"/> 
  <b>Year</b> <input type="text" value="<?php echo $row['ByearDegree']?>" name="ByearDegree"/>
  <b>Major</b> <input type="text" value="<?php echo $row['Bmajor']?>" name="Bmajor"/> 
  <b>GPA</b> <input type="text" value="<?php echo $row['BGPA']?>" name="BGPA"/> </br>
  
  <!-- Masters Degree Info -->
  <label for="priorD">Prior Degree (Masters) </label>
  <select id="priorD" name="Mtype">
  <?php
    if (strcmp($row['MtypeDegree'], "MS") == 0) { ?>
        <option value="MS" selected>MS</option>
        <option value="PhD">PhD</option>
    <?php }
    else if (strcmp($row['MtypeDegree'], "PhD") == 0) { ?>
        <option value="PhD" selected>PhD</option>
        <option value="MS">MS</option>
    <?php } 
    else { ?>
        <option selected> </option>
        <option value="MS">MS</option>
        <option value="PhD">PhD</option>
    <?php } ?> 
  </select> 
  <b>University</b> <input type="text" value="<?php echo $row['Muniversity']?>" name="Muniversity"/> 
  <b>Year</b> <input type="text" value="<?php echo $row['MyearDegree']?>" name="MyearDegree"/> 
  <b>Major</b> <input type="text" value="<?php echo $row['Mmajor']?>" name="Mmajor"/> 
  <b>GPA</b> <input type="text" value="<?php echo $row['MGPA']?>" name="MGPA"/> </br>


<br><br>
<!-- Save button -->
<input type='submit' value="Save Application" name='save'>

<!-- Submit button -->
<input type='submit' id="submitApp" value="Submit Application" name='submitApp'>
</form>
<script type="text/javascript">
     document.getElementById('submitApp').onclick = function(){
        console.log("in submitted");
        submitValidate();
        $('#application-form').validate();
      }
 </script>
<br><br><br>

<?php
    // If save button is clicked, insert fields into db 
    if (isset($_POST['save'])){ ?>
      <?php
      // Get general info 
      $appDegree = "";
      $interests = "";
      $workExperience = "";
      $admitDate = ""; 

      $appDegree = $_POST["appDegree"];
      $interests = $_POST["interests"];
      $workExperience = $_POST["workExperience"];
      $admitDate = $_POST["admitDate"]; 

      // Get recommender info 
      $recFName = ""; 
      $recMinit = "";
      $recLName = "";
      $recEmail = "";
      $recTitle = "";
      $recCompany = "";

      $recTitle = $_POST["title"]; 
      $recFName = $_POST["fname"]; 
      $recMinit = $_POST["minit"];
      $recLName = $_POST["lname"];
      $recEmail = $_POST["email"];
      $recCompany = $_POST["company"];

      // Get academic info 
      $verbal = "";
      $quantitative = "";
      $total = "";
      $GREdate = "";
      $subject = "";
      $subjectScore = "";
      $subjectDate = "";
      $TOEFLScore = "";
      $TOEFLDate = "";

      $verbal = $_POST["verbal"];
      $quantitative = $_POST["quantitative"];
      $total = $_POST["total"];
      $GREdate = $_POST["GREdate"];
      $subject = $_POST["subject"];
      $subjectScore = $_POST["subjectScore"];
      $subjectDate = $_POST["subjectDate"];
      $TOEFLScore = $_POST["TOEFLscore"];
      $TOEFLDate = $_POST["TOEFLdate"];

      // Get prior degree info 
      $BtypeDeg = "";
      $Buniversity = ""; 
      $ByearDeg = "";
      $BGPA = "";
      $Bmajor = "";
      $MtypeDeg = "";
      $Muniversity = ""; 
      $MyearDeg = "";
      $MGPA = "";
      $Mmajor = "";

      $BtypeDeg = $_POST["Btype"];
      $Buniversity = $_POST["Buniversity"]; 
      $ByearDeg = $_POST["ByearDegree"];
      $BGPA = $_POST["BGPA"];
      $Bmajor = $_POST["Bmajor"];
      $MtypeDeg = $_POST["Mtype"];
      $Muniversity = $_POST["Muniversity"]; 
      $MyearDeg = $_POST["MyearDegree"];
      $MGPA = $_POST["MGPA"];
      $Mmajor = $_POST["Mmajor"];

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
      if ($recEmail != "") {
        $update_arr[] = "recEmail='".$recEmail."'";
      }
      if ($workExperience != "") {
        $update_arr[] = "workExperience='".$workExperience."'";
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
      if ($TOEFLScore != "") {
        $update_arr[] = "TOEFLscore='".$TOEFLScore."'";
      }
      if ($TOEFLDate != "") {
        $update_arr[] = "TOEFLdate='".$TOEFLDate."'";
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
    if ($recTitle != "") {
      $update_arr[] = "title='".$recTitle."'";
    }
    if ($recFName != "") {
      $update_arr[] = "fname='".$recFName."'";
    }
    if ($recMinit != "") {
      $update_arr[] = "minit='".$recMinit."'";
    }
    if ($recLName != "") {
      $update_arr[] = "lname='".$recLName."'";
    }
    if ($recCompany != "") {
      $update_arr[] = "company='".$recCompany."'";
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
    if ($BtypeDeg != "") {
      $update_arr[] = "BtypeDegree='".$BtypeDeg."'";
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
    if ($ByearDeg != "") {
      $update_arr[] = "ByearDegree='".$ByearDeg."'";
    }
    if ($MtypeDeg != "") {
      $update_arr[] = "MtypeDegree='".$MtypeDeg."'";
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
    if ($MyearDeg != "") {
      $update_arr[] = "MyearDegree='".$MyearDeg."'";
    }
    
    // array of values we want to update in app 
    $update_values = implode(', ', $update_arr);

    if (!empty($update_values)) {
      $queryTests = "UPDATE priorDegrees SET $update_values WHERE priorDegrees.UID=$uid"; 
      mysqli_query($dbc, $queryTests);
    }
?>
    <!-- // Redirect to saved confirmation page  -->
    <script type="text/javascript">
     window.location.href = 'savedApp.php';
    </script>
<?php
}
  // If submit button is clicked 
  if (isset($_POST['submitApp'])){
    echo 'submit pressed';
    ?>

      <script>$('#application-form').validate();</script>
<?php
    // Get general info 
    $appDegree = "";
    $interests = "";
    $workExperience = "";
    $admitDate = ""; 

    $appDegree = $_POST["appDegree"];
    $interests = $_POST["interests"];
    $workExperience = $_POST["workExperience"];
    $admitDate = $_POST["admitDate"]; 

    // Get recommender info 
    $recFName = ""; 
    $recMinit = "";
    $recLName = "";
    $recEmail = "";
    $recTitle = "";
    $recCompany = "";

    $recTitle = $_POST["title"]; 
    $recFName = $_POST["fname"]; 
    $recMinit = $_POST["minit"];
    $recLName = $_POST["lname"];
    $recEmail = $_POST["email"];
    $recCompany = $_POST["company"];

    // Get academic info 
    $verbal = "";
    $quantitative = "";
    $total = "";
    $GREdate = "";
    $subject = "";
    $subjectScore = "";
    $subjectDate = "";
    $TOEFLScore = "";
    $TOEFLDate = "";

    $verbal = $_POST["verbal"];
    $quantitative = $_POST["quantitative"];
    $total = $_POST["total"];
    $GREdate = $_POST["GREdate"];
    $subject = $_POST["subject"];
    $subjectScore = $_POST["subjectScore"];
    $subjectDate = $_POST["subjectDate"];
    $TOEFLScore = $_POST["TOEFLscore"];
    $TOEFLDate = $_POST["TOEFLdate"];

    // Get prior degree info 
    $BtypeDeg = "";
    $Buniversity = ""; 
    $ByearDeg = "";
    $BGPA = "";
    $Bmajor = "";
    $MtypeDeg = "";
    $Muniversity = ""; 
    $MyearDeg = "";
    $MGPA = "";
    $Mmajor = "";

    $BtypeDeg = $_POST["Btype"];
    $Buniversity = $_POST["Buniversity"]; 
    $ByearDeg = $_POST["ByearDegree"];
    $BGPA = $_POST["BGPA"];
    $Bmajor = $_POST["Bmajor"];
    $MtypeDeg = $_POST["Mtype"];
    $Muniversity = $_POST["Muniversity"]; 
    $MyearDeg = $_POST["MyearDegree"];
    $MGPA = $_POST["MGPA"];
    $Mmajor = $_POST["Mmajor"];

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
    if ($recEmail != "") {
      $update_arr[] = "recEmail='".$recEmail."'";
    }
    if ($workExperience != "") {
      $update_arr[] = "workExperience='".$workExperience."'";
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
    if ($TOEFLScore != "") {
      $update_arr[] = "TOEFLscore='".$TOEFLScore."'";
    }
    if ($TOEFLDate != "") {
      $update_arr[] = "TOEFLdate='".$TOEFLDate."'";
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
  if ($numRows == 0) {
    $query = "INSERT INTO recommenders (email) VALUES ('$recEmail')";
    mysqli_query($dbc, $query); 
  }

  // We only want to update fields that have input 
  $update_arr = array();
  if ($recFName != "") {
    $update_arr[] = "fname='".$recFName."'";
  }
  if ($recMinit != "") {
    $update_arr[] = "minit='".$recMinit."'";
  }
  if ($recLName != "") {
    $update_arr[] = "lname='".$recLName."'";
  }
  if ($recTitle != "") {
    $update_arr[] = "title='".$recTitle."'";
  }
  if ($recCompany != "") {
    $update_arr[] = "company='".$recCompany."'";
  }
  
  // array of values we want to update in app 
  $update_values = implode(', ', $update_arr);

  if (!empty($update_values)) {
    $queryTests = "UPDATE recommenders SET $update_values WHERE recommenders.email='$recEmail'"; 
    mysqli_query($dbc, $queryTests);
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
  if ($BtypeDeg != "") {
    $update_arr[] = "BtypeDegree='".$BtypeDeg."'";
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
  if ($ByearDeg != "") {
    $update_arr[] = "ByearDegree='".$ByearDeg."'";
  }
  if ($MtypeDeg != "") {
    $update_arr[] = "MtypeDegree='".$MtypeDeg."'";
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
  if ($MyearDeg != "") {
    $update_arr[] = "MyearDegree='".$MyearDeg."'";
  }
  
  // array of values we want to update in app 
  $update_values = implode(', ', $update_arr);

  if (!empty($update_values)) {
    $queryTests = "UPDATE priorDegrees SET $update_values WHERE priorDegrees.UID=$uid"; 
    mysqli_query($dbc, $queryTests);
  }

  /* If recommender does not have an account */ 
  $query = "SELECT password FROM recommenders WHERE recommenders.email='$recEmail'";
  $data = mysqli_query($dbc, $query); 
  $row = mysqli_fetch_array($data);
   
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
    $query = "UPDATE recommenders SET password='$password' WHERE recommenders.email='$recEmail'";
    mysqli_query($dbc, $query); 

    // get name of student 
    $query = "SELECT fname, lname FROM users WHERE users.UID='$uid'";
    mysqli_query($dbc, $query); 
    $row = mysqli_fetch_array($data);
    $studentName = $row['fname'] . " " . $row['lname'];

    // Email recommender 
    $to = $recEmail;
    $subject = "Recommendation Letter Request | Account Creation";
    $txt = "An applicant has requested that you submit a recommendation letter on their behalf. An account was created for you 
    to review and submit letter requests. Login to your account with the 
    credentials below at http://gwupyterhub.seas.gwu.edu/~sreyanalla/clout_computing/phase1/home.php to complete it.
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
    at http://gwupyterhub.seas.gwu.edu/~sreyanalla/clout_computing/phase1/home.php to complete it.";
    $headers = "From: admissions" . "\r\n";
    mail($to,$subject,$txt,$headers);
  }
  
  // Update app submissionStatus to completed 
  $query = "UPDATE app SET submissionStatus='Submitted' WHERE app.UID='$uid'";
  mysqli_query($dbc, $query); 
?>

<?php
}
?>
<!-- </form> -->
</body>
</html>
