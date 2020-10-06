<?php 
    // Start the session
    session_start();

    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    //get applicant UID to query with
    $applicantUID = htmlspecialchars($_POST['applicant']);

    // Include navmenu 
    require_once('navMenus/navRevPortal.php'); 

    // Include db connection vars 
    require_once('../connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $avgRec = 0;
    $avgGAS = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title> Reviewing Application </title>
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <link href="./css/style.css" red="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style>
        span{
            color:#ac2424;
            font-size: 14px;
            font-style:italics;
        }
        input[name=submitReview]:hover {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[name=submitReview] {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
   </style>
</head>
<body>

<!-- Restrict access to webpage to only faculty -->


<div class="container">
  <form method="POST">
  <?php 
    $query = ("SELECT * 
              FROM users
              WHERE users.UID='$applicantUID'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
  </br></br></br></br>
    <!-- Personal Information -->
    <h3> Student Information </h3>
    <div class="form-row">
      <div class="col">
        <label for="applicantUID">Applicant UID:</label>
        <input disabled type="text"  class="form-control form-group" label="Student UID: " minlength="1" maxlength="50" value="<?php echo $applicantUID ?>">
        <span id="applicantUID-err"></span>
      </div>
      <div class="col">
        <label for="fname">First Name:</label>
        <input disabled type="text"  class="form-control form-group" label="First Name " minlength="1" maxlength="50" value="<?php echo $row['fname'] ?>">
        <span id="fname-err"></span>
      </div>
      <div class="col">
        <label for="minit">Middle Initial:</label>
        <input disabled type="text"  class="form-control form-group" label="Middle Initial: " minlength="1" maxlength="50" value="<?php echo $row['minit'] ?>">
        <span id="minit-err"></span>
      </div>
      <div class="col">
        <label for="fname">Last Name:</label>
        <input disabled type="text"  class="form-control form-group" label="Last Name: " minlength="1" maxlength="50" value="<?php echo $row['lname'] ?>">
        <span id="lname-err"></span>
      </div>
    </div>
    <div class = "form-row">
      <div class="col">
        <label for="fname">Address:</label>
        <input disabled type="text"  class="form-control form-group" label="Address: " minlength="1" maxlength="50" value="<?php echo $row['address'] ?>">
        <span id="address-err"></span>
      </div>
      <div class="col">
        <label for="fname">Email:</label>
        <input disabled type="text"  class="form-control form-group" label="Email: " minlength="1" maxlength="50" value="<?php echo $row['email'] ?>">
        <span id="address-err"></span>
      </div>
    </div>

    <!-- General Info -->
    <h3> General Info </h3>
    <!-- Drop down bar to select MS or PhD -->
    <?php 
      $query = ("SELECT * 
                FROM app 
                WHERE app.UID='$applicantUID'"); 
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
      $applicantDate = $row['appDate'];
    ?>

    <div class="form-row">
      <div class="col">
        <label for="degree">Applying for Degree:</label>
        <input disabled type="text"  class="form-control form-group" label="Applying for Degree: " minlength="1" maxlength="50" value="<?php echo $row['degree'] ?>">
        <span id="degree-err"></span>
      </div>
      <div class="col">
        <label for="interests">Areas of Interest:</label>
        <input disabled type="text"  class="form-control form-group" label="Areas of Interest: " minlength="1" maxlength="50" value="<?php echo $row['interests'] ?>">
        <span id="interests-err"></span>
      </div>
      <div class="col">
        <label for="workexperience">Work Experience:</label>
        <input disabled type="text"  class="form-control form-group" label="Last Name: " minlength="1" maxlength="50" value="<?php echo $row['workExperience'] ?>">
        <span id="workExperience-err"></span>
      </div>
      <div class="col">
        <label for="appDate">Admission Date:</label>
        <input disabled type="text"  class="form-control form-group" label="Address: " minlength="1" maxlength="50" value="<?php echo $row['appDate'] ?>">
        <span id="appDate-err"></span>
      </div>
    </div>
    
    <!-- Recommender Info -->
    <h3> Recommender Info </h3>
    <?php 
      $query = ("SELECT title, recommenders.fname AS firstN, recommenders.minit AS mid, recommenders.lname AS lastN, recEmail
                FROM recommenders, app 
                WHERE app.UID='$applicantUID' AND app.recEmail=recommenders.email"); 
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
    ?>

    <div class="form-row">
      <div class="col">
        <label for="title">Title:</label>
        <input disabled type="text"  class="form-control form-group" label="Title: " minlength="1" maxlength="50" value="<?php echo $row['title'] ?>">
        <span id="title-err"></span>
      </div>
      <div class="col">
        <label for="firstN">First Name:</label>
        <input disabled type="text"  class="form-control form-group" label="First Name: " minlength="1" maxlength="50" value="<?php echo $row['firstN'] ?>">
        <span id="firstN-err"></span>
      </div>
      <div class="col">
        <label for="mid">Middle Initial:</label>
        <input disabled type="text"  class="form-control form-group" label="Middle Initial: " minlength="1" maxlength="50" value="<?php echo $row['mid'] ?>">
        <span id="mid-err"></span>
      </div>
      <div class="col">
        <label for="lastN">Last Name:</label>
        <input disabled type="text"  class="form-control form-group" label="Last Name: " minlength="1" maxlength="50" value="<?php echo $row['lastN'] ?>">
        <span id="lastN-err"></span>
      </div>
      <div class="col">
        <label for="recEmail">Email:</label>
        <input disabled type="text"  class="form-control form-group" label="Email: " minlength="1" maxlength="50" value="<?php echo $row['recEmail'] ?>">
        <span id="recEmail-err"></span>
      </div>
    </div>

    <!-- Academic Info  -->
    <h3> Academic Information </h3>
    <!-- GRE & TOEFL Scores -->
    <h5> Test Scores </h5>
    <?php 
      $query = ("SELECT * 
                FROM tests 
                WHERE tests.UID='$applicantUID'"); 
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
    ?>

    <div class="form-row">
      <div class="col">
        <label for="verbal">GRE Verbal Score:</label>
        <input disabled type="text"  class="form-control form-group" label="GRE Verbal Score: " minlength="1" maxlength="50" value="<?php echo $row['verbal'] ?>">
        <span id="verbal-err"></span>
      </div>
      <div class="col">
        <label for="quantitative">First Name:</label>
        <input disabled type="text"  class="form-control form-group" label="Quantitative Score: " minlength="1" maxlength="50" value="<?php echo $row['quantitative'] ?>">
        <span id="quantitative-err"></span>
      </div>
      <div class="col">
        <label for="total">Total:</label>
        <input disabled type="text"  class="form-control form-group" label="Total: " minlength="1" maxlength="50" value="<?php echo $row['verbal']+$row['quantitative'] ?>">
        <span id="total-err"></span>
      </div>
      <div class="col">
        <label for="GREdate">Date of Exam:</label>
        <input disabled type="text"  class="form-control form-group" label="Last Name: " minlength="1" maxlength="50" value="<?php echo $row['GREdate'] ?>">
        <span id="GREdate-err"></span>
      </div>
    </div>
    


    <div class="form-row">
      <div class="col">
        <label for="subject">GRE Advanced Subject:</label>
        <input disabled type="text"  class="form-control form-group" label="GRE Advanced Subject: " minlength="1" maxlength="50" value="<?php echo $row['subject'] ?>">
        <span id="subject-err"></span>
      </div>
      <div class="col">
        <label for="subjectScore">Score:</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectScore'] ?>">
        <span id="subjectScore-err"></span>
      </div>
      <div class="col">
        <label for="subjectDate">Date of Exam (Subject):</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectDate'] ?>">
        <span id="subjectDate-err"></span>
      </div>
    </div>

    <div class="form-row">
      <div class="col">
        <label for="subject">GRE Advanced Subject:</label>
        <input disabled type="text"  class="form-control form-group" label="GRE Advanced Subject: " minlength="1" maxlength="50" value="<?php echo $row['subject2'] ?>">
        <span id="subject-err"></span>
      </div>
      <div class="col">
        <label for="subjectScore">Score:</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectScore2'] ?>">
        <span id="subjectScore-err"></span>
      </div>
      <div class="col">
        <label for="subjectDate">Date of Exam (Subject):</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectDate2'] ?>">
        <span id="subjectDate-err"></span>
      </div>
    </div>

    <div class="form-row">
      <div class="col">
        <label for="subject">GRE Advanced Subject:</label>
        <input disabled type="text"  class="form-control form-group" label="GRE Advanced Subject: " minlength="1" maxlength="50" value="<?php echo $row['subject3'] ?>">
        <span id="subject-err"></span>
      </div>
      <div class="col">
        <label for="subjectScore">Score:</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectScore3'] ?>">
        <span id="subjectScore-err"></span>
      </div>
      <div class="col">
        <label for="subjectDate">Date of Exam (Subject):</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['subjectDate3'] ?>">
        <span id="subjectDate-err"></span>
      </div>
    </div>

    <div class="form-row">
      <div class="col">
        <label for="TOEFLscore">TOEFL Score:</label>
        <input disabled type="text"  class="form-control form-group" label="Score: " minlength="1" maxlength="50" value="<?php echo $row['TOEFLscore'] ?>">
        <span id="TOEFLscore-err"></span>
      </div>
      <div class="col">
        <label for="subject">Date of Exam (TOEFL):</label>
        <input disabled type="text"  class="form-control form-group" label="Date of Exam: " minlength="1" maxlength="50" value="<?php echo $row['TOEFLdate'] ?>">
        <span id="subject-err"></span>
      </div>
    </div> 

    <!-- Prior Degree Info -->
    <h3> Prior Degrees </h3>
    <?php 
      $query = ("SELECT * 
                FROM priorDegrees 
                WHERE priorDegrees.UID='$applicantUID'"); 
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
    ?>
    <!-- Bachelors Degree Info -->

    <div class="form-row">
      <div class="col">
        <label for="priorDeg">University (Bachelors):</label>
        <input disabled type="text"  class="form-control form-group" label="University: " minlength="1" maxlength="50" value="<?php echo $row['Buniversity'] ?>">
        <span id="Buniversity-err"></span>
      </div>
      <div class="col">
        <label for="subject">Year:</label>
        <input disabled type="text"  class="form-control form-group" label="Year: " minlength="1" maxlength="50" value="<?php echo $row['ByearDegree'] ?>">
        <span id="ByearDegree-err"></span>
      </div>
      <div class="col">
        <label for="BGPA">GPA:</label>
        <input disabled type="text"  class="form-control form-group" label="Year: " minlength="1" maxlength="50" value="<?php echo $row['BGPA'] ?>">
        <span id="BGPA-err"></span>
      </div>
    </div>  
    
    <!-- Masters Degree Info -->
    <div class="form-row">
      <div class="col">
        <label for="priorDeg">University (Masters):</label>
        <input disabled type="text"  class="form-control form-group" label="University: " minlength="1" maxlength="50" value="<?php echo $row['Muniversity'] ?>">
        <span id="Muniversity-err"></span>
      </div>
      <div class="col">
        <label for="subject">Year:</label>
        <input disabled type="text"  class="form-control form-group" label="Year: " minlength="1" maxlength="50" value="<?php echo $row['MyearDegree'] ?>">
        <span id="MyearDegree-err"></span>
      </div>
      <div class="col">
        <label for="BGPA">GPA:</label>
        <input disabled type="text"  class="form-control form-group" label="Year: " minlength="1" maxlength="50" value="<?php echo $row['MGPA'] ?>">
        <span id="MGPA-err"></span>
      </div>
    </div> 

    <!-- display the rec letter of that user -->
    <h3> Recommendation Letter </h3>
    <?php
    $query = ("SELECT recLetter FROM app WHERE app.UID='$applicantUID'");
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
    <!-- Bachelors Degree Info -->

    <div class="form-row">
      <div class="col">
        <label for="priorDeg">Recommendation Letter:</label>
        <input disabled type="text"  class="form-control form-group" label="Recommendation Letter: " minlength="1" maxlength="50" value="<?php echo $row['recLetter'] ?>">
        <span id="Buniversity-err"></span>
      </div>
    </div>  
    
  </form>
</div>

<?php
if ($typeUser == 2 || $typeUser == 3) {
// if($typeUser == 2 || $typeUser == 3){ ?>

<div class="container">
<h3> Past Reviews </h3>
<h5>Individual Faculty Reviewer Ratings</h5>
    <table>
    <tr>
            <th>Reviewer Name</th>
            <th>GAS Rating</th>
            <th>Comments(If Applicable)</th>
            <th>Reason for Rejection(If Applicable)</th>
            <th>Recommendation Rating (0-5)</th>
    </tr>
    </table>
</div>


<!-- Display past reviews of that student if user is GS or Chair -->
<?php
    $totalGAS = 0;
    $avgGAS = 0;
    $totalRecRating = 0;
    $avgRec = 0;
    $query = ("SELECT users.fname, users.lname, ratings.reviewerUID, ratings.GASrating, ratings.comments, ratings.reason, ratings.recRating FROM users,ratings WHERE ratings.UID='$applicantUID' AND ratings.reviewerUID = users.UID");
    $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
    $r = mysqli_num_rows($data);
    if ($r == 0){
      ?> 
      <div class="container">
        <h5>No past reviews have been submitted</h5>
      </div>
      <br><br>
      <?php
    }
    // $totalGAS =0;
    while($row = mysqli_fetch_array($data)) {
      ?> 
      <div class='container'>
  <?php
          echo "<table border='1'>";
          echo "<tr>"; 
          echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
          if($row['GASrating'] == 0){
            echo "<td>" . 'Reject' . "</td>";
          }
          elseif($row['GASrating'] == 1){
            echo "<td>" . 'Borderline Admit' . "</td>";
          }
          elseif($row['GASrating'] == 2){
            echo "<td>" . 'Admit without Aid' . "</td>";
          }
          elseif($row['GASrating'] == 3){
            echo "<td>" . 'Admit with Aid' . "</td>";
          }
          else{
            echo "<td>" . "</td>";
          }
          echo "<td>" . $row['comments'] . "</td>";
          if($row['reason'] == 'A'){
            echo "<td>" . 'Incomplete Record' . "</td>";
          }
          elseif($row['reason'] == 'B'){
            echo "<td>" . 'Does not meet minimum requirements' . "</td>";
          }
          elseif($row['reason'] == 'C'){
            echo "<td>" . 'Problems with letter' . "</td>";
          }
          elseif($row['reason'] == 'D'){
            echo "<td>" . 'Not competitive' . "</td>";
          }
          elseif($row['reason'] == 'E'){
            echo "<td>" . 'Other reasons' . "</td>";
          }
          else{
            echo "<td>" . "</td>";
          }
          //echo "<td>" . $row['reason'] . "</td>";
          echo "<td>" . $row['recRating'] . "</td>";
          echo "</tr>";
          $totalGAS = $totalGAS + $row['GASrating'];
          $totalRecRating = $totalRecRating + $row['recRating'];
          $avgGAS = $totalGAS/$r;
          $avgRec = $totalRecRating/$r;
          echo "</table>"; 
          ?></div><?php
  }
  ?>
<br><br>
  <div class="container">
      <h5>Faculty Review Summary</h5>
    <div class="form-row">
      <div class="col">
          <!-- <label for="priorDeg">Average GAS Rating:</label> -->
          <p><strong>Average GAS Rating:</strong> <?php 
          if ($avgGAS == 0){ 
            echo "No Faculty Reviewers have submitted a review yet";
          }
          else {
            echo $avgGAS;
          } ?> <br />
          <strong>Average Recommendation Rating:</strong> <?php
          if ($avgRec == 0){ 
            echo "No Faculty Reviewers have submitted a review yet";
          }
          else {
            echo $avgRec;
          }  ?></p>
          <!-- <input disabled type="text"  class="form-control form-group" label="avgGAS" value="<?php //echo $avgGAS ?>"> -->
        </div>
    </div>
  </div>
  <!-- Display additional information for Chair -->
  <br><br>
  <?php 
    $q = "SELECT recStatus, transcriptStatus FROM app WHERE UID='$applicantUID';";
    $d = mysqli_query($dbc, $q) or die (mysqli_error($dbc));
    $r = mysqli_fetch_array($d);
    if ($r['recStatus'] == "Received" && $r['transcriptStatus'] == "Received") {
  ?>

          <!-- <div class="col"> -->
            <!-- Rec Letter Rating Option Form -->
            <!-- <label for="Advisor">Advisor upon Admission</label>
            <select name="Advisor" id="" class="form-control">
              <option value=""></option>
              <option value="Bhagirath Narahari">Bhagirath Narahari</option>
              <option value=">Heller Wood">Heller Wood</option>
              <option value="Pablo Frank-Bolton">Pablo Frank-Bolton</option>
              <option value="Timothy Wood">Timothy Wood</option>
            </select>
          </div> -->
        </div>
        </div>
<?php
    }
}
?>
  

<br>

<?php //if ($typeUser == 1) {
  if ($typeUser == 1 || $typeUser == 2 || $typeUser == 3 || $typeUser == 6) { ?>
<div class="container">
<!-- reviewer form -->
  <form method="post">
  <h3>Application Review and Ratings</h3>
  <div class="form-row form-group">
    <div class="col">
      <label for="RecLetterRating">Rec Letter Rating</label>
      <select name="RecLetterRating" id="" class="form-control" required>
        <option selected></option>
        <option value="0">0 (Unacceptable)</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5 (Excellent)</option>
      </select>
    </div>
    <div class="col">
      <!-- GENERIC OPTION -->
    <label for="Generic">Generic Review:</label>
    <select name="Generic" id="" class="form-control" required>
      <option selected></option>
      <option value="Y">Yes</option>
      <option value="N">No</option>
    </select>
    </div>
    <div class="col">
    <!-- CREDIBLE OPTION -->
    <label for="Credible">Credible:</label>
    <select name="Credible" id="" class="form-control" required>
      <option selected></option>
      <option value="Y">Yes</option>
      <option value="N">No</option>
    </select>
    </div>
<!-- </div> -->

    <!-- FROM OPTION -->
    <?php
      $query = ("SELECT company FROM recommenders,app WHERE app.recEmail = recommenders.email AND '$applicantUID' = app.UID");
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
    ?>
    <div class="col">
    <label for="company">From:</label>
    <input disabled type="text"  class="form-control form-group" name="company" value ="<?php echo $row['company']?>" >
    </div>
    </div>
    <div class="form-row form-group">
      <div class="col">
        <!-- Grad Admissions Committee (GAS) Form -->
        <label for="GASRating">Grad Admissions Committee (GAS) Review Rating:</label>
        <br>
        <select name="GASRating" id="GAS" class="form-control" required>
          <option selected></option>
          <option value="0">Reject</option>
          <option value="1">Borderline Admit</option>
          <option value="2">Admit without Aid</option>
          <option value="3">Admit with Aid</option>
        </select>
      </div>
      <div class="col">
        <!-- Grad Admissions Committee (GAS) Form -->
        <label for="DCourses">Deficiency Courses if Any:</label>
        <input type="text" name="DCourses" id="" class="form-control form-group">
        <span class="error" id="DCourses-err"></span>
      </div>
    </div>
  <script> var GAS = document.getElementById('GAS').value;</script>
    <div class="form-row form-group">
      <div class="col">
        <!-- Rec Letter Rating Option Form -->
        <label for="RejectReason">Reason for Rejection: </label>
        <br>
        <select name="RejectReason" id="" class="form-control">
          <option value="F"></option>
          <option value="A">Incomplete Record</option>
          <option value="B">Does not meet minimum Requirements</option>
          <option value="C">Problems with Letters</option>
          <option value="D">Not Competitive</option>
          <option value="E">Other Reasons</option>
        </select>
      </div>
      <div class="col">
        <!-- Grad Admissions Committee (GAS) Form -->
        <label for="GASComments">GAS Reviewer Comments</label>
        <input type="text" name="GASComments" id="" class="form-control form-group">
        <span class="error" id="GASComments-err"></span>
      </div>
    </div>

<?php } ?>
  <!-- Display additional information for Chair and GS -->
    <?php
      if($typeUser == 2 || $typeUser == 3){
        ?>
        <div class = "container">
        <div class="form-row form-group">
          <div class="col">
          </div>
          <div class="col">
            <!-- Rec Letter Rating Option Form -->
            <label for="Advisor">Advisor</label>
            <select name="Advisor" id="" class="form-control">
              <option value=""></option>
              <option value="Bhagirath Narahari">Bhagirath Narahari</option>
              <option value="Sarah Morin">Sarah Morin</option>
              <option value="Gabe Parmer">Gabe Parmer</option>
              <option value="Timothy Wood">Timothy Wood</option>
            </select>
          </div>
        </div>
        </div>
        
    <?php
      }
    ?>

  <!-- Display additional information for GS -->
  <?php
      if($typeUser == 3){
        ?>
        <div class = "container">
        <h3>Final Decision</h3>
       <div class="form-row form-group">
          <div class="col"> -->
            <!-- Rec Letter Rating Option Form -->
            <label for="FinalDecision">Final Decision</label>
            <br>
            <select name="FinalDecision" id="" class="form-control">
              <option value="Admit with Aid">Admit with Aid</option>
              <option value="Admit">Admit</option>
              <option value="Reject">Reject</option>
            </select>
          </div>
          <div class="col">
          <?php
          }?>
    <?php
      // }
    ?> 

  <br><br>
  <!-- Save button -->
  <!-- <button class='button'>Save Review<type='submit' value='Save Application' name='saveReview'></button> -->
  <!-- Submit button -->
  <!-- <button class='button'>Submit Review<type='submit' value='Submit Application' name='submitReview'></button> -->
  <?php 
    $q = "SELECT recStatus, transcriptStatus FROM app WHERE UID='$applicantUID';";
    $d = mysqli_query($dbc, $q) or die (mysqli_error($dbc));
    $r = mysqli_fetch_array($d);
    if (($typeUser == "GradSec" || $typeUser == "Chair") && ($r['recStatus'] == "Received") && ($r['transcriptStatus'] == "Received")) {
  ?>
  <div class="container">
    <!-- <div class="form-control"> -->
      <input type="submit" id="login-log" class="btn btn-primary center-block" value="    Submit Review    "  name="submitReview"/>
    <!-- </div> -->
  </div>
  <?php } 
  else if ($typeUser == 1 || $typeUser == 2 || $typeUser == 3 || $typeUser == 6){ ?>
    <div class="container">
    <!-- <div class="form-control"> -->
      <input type="submit" id="login-log" class="btn btn-primary center-block" value="    Submit Review    "  name="submitReview"/>
    <!-- </div> -->
  </div>
  <?php }?>

  <input type="hidden" name="applicant" value="<?php echo $applicantUID?>">
  </form> </br></br>
</div>

<!-- PHP CODE FOR SUBMITTING REVIEWER FORM DATA INTO DATABASE -->
<?php
//if the submit button is clicked
if(isset($_POST['submitReview'])){
  //Submit all of the values entered into the RATINGS TABLE or Generic Data if not filled

  //if the user is a regular reviewer
  // if($typeUser == 1){
  if ($typeUser == 1 || $typeUser == 6) {
    $GASrating = "";
    $comments = "";
    $courses = "";
    $reason = "";
    $from = "";
    $recRating = "";
    $generic = "";
    $credible = "";

    $GASrating = $_POST['GASRating'];
    $comments = $_POST['GASComments'];
    $courses = $_POST['DCourses'];
    $reason = $_POST['RejectReason'];
    $recRating = $_POST['RecLetterRating'];
    $generic = $_POST['Generic'];
    $credible = $_POST['Credible'];
    echo $courses;

    $query = "SELECT appDate FROM app WHERE UID='$applicantUID';";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
    $rows = mysqli_fetch_array($data);
    $date = $rows['appDate'];

    //select the UID tuples from the table if needed
    $query = "SELECT ratings.UID FROM ratings WHERE ratings.UID=$applicantUID AND ratings.reviewerUID = '$uid' AND ratings.appDate = '$applicantDate';";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc)); 
    $numRows = mysqli_num_rows($data); 

    //if the query results in zero tuples, create a new review
    if($numRows == 0){
    // if($data->num_rows() === 0) {
      $query = "INSERT INTO ratings (UID, appDate, reviewerUID) VALUES ($applicantUID, '$applicantDate', $uid)";
      $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc)); 
      ?><script>console.log("HERE");</script><?php
    }

    $query = "UPDATE ratings SET GASrating = $GASrating, comments = '$comments', courses = '$courses', reason = '$reason', recRating = $recRating, generic = '$generic', credible = '$credible' WHERE ratings.UID='$applicantUID' AND ratings.reviewerUID = '$uid';";
    $data = mysqli_query($dbc, $query);
    if (!$data){ ?>
      <script>console.log("error");</script> <?php
    }

    //find the company again
    $query = ("SELECT company FROM recommenders,app WHERE app.recEmail = recommenders.email AND '$applicantUID' = app.UID AND app.appDate = $applicantDate");
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    $company = $row['company'];

    //update the history with company value
    //$query = "UPDATE history SET company = $company;";


  }

  //if the user is a chair
  else if ($typeUser == 2) {
  // elseif($typeUser == 2){
    ?>
    <script>console.log("I am a Chair USER!");</script>
    <?php
    // $GASrating = "";
    // $comments = "";
    // $courses = "";
    // $reason = "";
    // $from = "";
    // $recRating = "";
    // $generic = "";
    // $credible = "";
    $decisionStatus = "";
    
    // $advisor = "";

  

    // $GASrating = $_POST['GASRating'];
    // $comments = $_POST['GASComments'];
    // $courses = $_POST['DCourses'];
    // $reason = $_POST['RejectReason'];
    // $recRating = $_POST['RecLetterRating'];
    // $generic = $_POST['Generic'];
    // $credible = $_POST['Credible'];
    $decisionStatus = $_POST['FinalDecision'];
    $advisor = $_POST['Advisor'];
    //echo $decisionStatus;

    //update the history table if needed
    // IF THE USER IS NOT IN HISTORY, THIS IS THE FIRST APP THEY ARE SUBMITTING
    echo '1';
    $query = "SELECT UID FROM history WHERE history.UID=$applicantUID;";
    $data = mysqli_query($dbc, $query); 
    $numRows = mysqli_num_rows($data); 

    //if the query results in zero tuples, create a new review
    //IF THE USER DOESNT EXIST IN HISTORY, WE NEED TO ADD THEM 
    // if($data->num_rows() === 0) {
      echo '2';
      $query = "INSERT INTO history(UID,appDate, advisor) VALUES ('$applicantUID', '$applicantDate', '$advisor')";
      mysqli_query($dbc, $query) or die (mysqli_error($dbc));
      ?><script>console.log("HERE");</script><?php

    // ONCE WE INSERT, GET THE APP ID SO WE UPDATE THE CORRECT APP
    echo '3';
    $q = ("SELECT appID FROM history WHERE history.UID = $applicantUID AND history.appDate = '$applicantDate';");
    $d = mysqli_query($dbc, $q);
    $r = mysqli_fetch_array($d);
    $appID = $r['appID'];
    ?><script>console.log("got appID from history table");</script><?php

    echo '4';
    //getting rating data into history table
    $query = "UPDATE history SET avgGAS = '$avgGAS', avgRec = '$avgRec', decisionStatus = '$decisionStatus' WHERE history.UID = '$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID';";
    // $query = "UPDATE history SET decisionStatus = '$decisionStatus' WHERE history.UID = '$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID';";
    // $query = "UPDATE history SET GASrating = $GASrating, comments = '$comments', courses = '$courses', reason = '$reason', recRating = $recRating, generic = '$generic', credible = '$credible', decisionStatus = '$decisionStatus' WHERE (history.UID='$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID');";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
    if (!$data){ ?>
      <script>console.log("error in storing rating data in history table");</script> <?php
    }

    echo '5';
    //getting app data into history table
    // $query = "UPDATE history SET appDate = 'app.appDate', interests = 'app.interests', advisor = app.advisor, recLetter = app.recLetter, recEmail = app.recEmail, workExperience = app.workExperience WHERE history.UID = '$applicantUID' AND app.UID = '$applicantUID';";
    $query = "UPDATE history INNER JOIN app ON history.UID = app.UID and history.appDate = '$applicantDate' and history.appID = '$appID' SET history.appDate = app.appDate, history.interests = app.interests, history.recLetter = app.recLetter, history.recEmail = app.recEmail, history.workExperience = app.workExperience, history.degree = app.degree;";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
    if (!$data){ ?>
      <script>console.log("error in storing app data in history table");</script> <?php
      echo mysqli_error($dbc);
    }

    echo '6';
    //getting prior degree data into history table
    // $query = "UPDATE history INNER JOIN priorDegrees ON history.UID = priorDegrees.UID SET history.BtypeDegree = priorDegrees.BtypeDegree, history.Buniversity = priorDegrees.Buniversity, history.BGPA = priorDegrees.BGPA, history.Bmajor = priorDegrees.Bmajor, history.ByearDegree = priorDegrees.ByearDegree, history.MtypeDegree = priorDegrees.MtypeDegree, history.Muniversity = priorDegrees.Muniversity, history.MGPA = priorDegrees.MGPA, history.Mmajor = priorDegrees.Mmajor, history.MyearDegree = priorDegrees.MyearDegree;";
    $query = "UPDATE history JOIN priorDegrees ON history.UID = priorDegrees.UID 
              SET history.BtypeDegree = priorDegrees.BtypeDegree, 
                  history.Buniversity = priorDegrees.Buniversity, 
                  history.BGPA = priorDegrees.BGPA, 
                  history.Bmajor = priorDegrees.Bmajor, 
                  history.ByearDegree = priorDegrees.ByearDegree, 
                  history.MtypeDegree = priorDegrees.MtypeDegree, 
                  history.Muniversity = priorDegrees.Muniversity, 
                  history.MGPA = priorDegrees.MGPA, 
                  history.Mmajor = priorDegrees.Mmajor, 
                  history.MyearDegree = priorDegrees.MyearDegree
              WHERE history.appID = '$appID';";
    $data = mysqli_query($dbc, $query);
    if (!$data){ ?>
<?php
      echo mysqli_error($dbc);
    }

    echo '8';
    //getting test scores data into history table
    $query = "UPDATE history INNER JOIN tests ON history.UID = tests.UID 
              SET history.quantitative = tests.quantitative, 
                  history.verbal = tests.verbal, 
                  history.subjectScore = tests.subjectScore, 
                  history.subjectScore2 = tests.subjectScore2, 
                  history.subjectScore3 = tests.subjectScore3, 
                  history.subject = tests.subject, 
                  history.subject2 = tests.subject2, 
                  history.subject3 = tests.subject3, 
                  history.total = tests.total, 
                  history.GREdate = tests.GREdate, 
                  history.subjectDate = tests.subjectDate, 
                  history.subjectDate2 = tests.subjectDate2, 
                  history.subjectDate3 = tests.subjectDate3, 
                  history.TOEFLscore = tests.TOEFLscore, 
                  history.TOEFLdate = tests.TOEFLdate
              WHERE history.appID = '$appID';";
    $data = mysqli_query($dbc, $query);
    if (!$data){ ?> 
<?php
      echo mysqli_error($dbc);
    }

    echo '9';
    //if the decision status is set remove the rows of that student from apps, ratings, and tests
    if(!empty($decisionStatus)){
      $query = "DELETE FROM app WHERE UID = '$applicantUID' AND app.appDate = '$applicantDate';";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?> 
        <script>console.log("error in deleting applicant from app table");</script> <?php
        echo mysqli_error($dbc);
      }
      //delete from ratings
      // $query = "DELETE FROM ratings WHERE UID = '$applicantUID';";
      // $data = mysqli_query($dbc, $query);
      // if (!$data){ ?> 
         <!-- <script>console.log("error in deleting applicant from ratings table");</script> <?php //-->
      //   echo mysqli_error($dbc);
      // }
      //delete from tests
      echo '10';
      $query = "DELETE FROM tests WHERE UID = '$applicantUID';";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?> 
        <script>console.log("error in deleting applicant from tests table");</script> <?php
        echo mysqli_error($dbc);
      }

      echo '11';
      $query = "DELETE FROM priorDegrees WHERE priorDegrees.UID = '$applicantUID' LIMIT 1;";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?> 
        <script>console.log("error in deleting applicant from priorDegrees table");</script> <?php
        echo mysqli_error($dbc);
      }

      echo '12';
      $q = "SELECT email FROM users WHERE UID = '$applicantUID';";
      $d = mysqli_query($dbc, $q) or die (mysqli_error($dbc));
      $r = mysqli_fetch_array($d);
      if (!$d){ ?> 
        <script>alert(an error occurred while saving decision. please try again later)</script>
      <?php }
      else {
        $to = $r['email'];
        $subject = "Admissions Committee | Decision Made";
        $txt = "The application review committee has reviewed your appliaction in full. A decision has been made regarding your admission. 
        \nPlease log into your account to view the decision.";
        $headers = "From: GW Review Committee" . "\r\n";
        mail($to,$subject,$txt,$headers);
      }
    }

    //if the student is admitted, randomly assign a faculty member to be their advisor in history
    // if($decisionStatus == 'Admit with Aid' || $decisionStatus == 'Admit'){
    //   // $query = "UPDATE history SET history.advisor = '$advisor' WHERE history.appID = '$appID' AND history.UID = '$applicantUID' AND history.appDate = '$applicantDate';";
    //   // $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
      

    // }

    echo '13';
    //find the company again
    $query = ("SELECT company FROM recommenders,app WHERE app.recEmail = recommenders.email AND '$applicantUID' = app.UID");
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    $company = $row['company'];

    echo '14';
    //update the history with company value
    $query = "UPDATE history SET company = $company WHERE history.UID = '$applicantUID' AND history.appID = '$appID' AND history.appDate = '$applicantDate';";
    mysqli_query($dbc, $query);
  }
  
  

  //if the user is a GS reviewer
  else if ($typeUser == 3) {
  // elseif($typeUser == 3){
    ?>
    <script>console.log("I am a GS USER!");</script>
    <?php
    $q = "SELECT transcriptStatus FROM app WHERE app.UID='$applicantUID';";
    $d = mysqli_query($dbc, $q) or die (mysqli_error($dbc));
    $r = mysqli_fetch_array($d);
    $transcriptStatus = $r['transcriptStatus'];
    // $GASrating = "";
    // $comments = "";
    // $courses = "";
    // $reason = "";
    $from = "";
    // $recRating = "";
    // $generic = "";
    // $credible = "";
    $decisionStatus = "";
    //$transcriptStatus = "";
    // $advisor = "";

    $GASrating = $_POST['GASRating'];
    $comments = $_POST['GASComments'];
    $courses = $_POST['DCourses'];
    $reason = $_POST['RejectReason'];
    $recRating = $_POST['RecLetterRating'];
    $generic = $_POST['Generic'];
    $credible = $_POST['Credible'];
    $decisionStatus = $_POST['FinalDecision'];
    //$transcriptStatus = $_POST['transcriptStatus'];
    $advisor = $_POST['Advisor'];
    // echo $transcriptStatus;

    if(!empty($decisionStatus)){
      //update the history table if needed
      $query = "SELECT UID FROM history WHERE history.UID=$applicantUID;";
      $data = mysqli_query($dbc, $query); 
      $numRows = mysqli_num_rows($data); 

      //if the query results in zero tuples, create a new review

      // if($data->num_rows() === 0) {
        $query = "INSERT INTO history(UID,appDate, advisor) VALUES ('$applicantUID', '$applicantDate', '$advisor')";
        echo $query;
        ?><script>console.log("HERE");</script><?php
      

      //getting rating data into history table
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?>
        <script>console.log("error in storing rating data in history table");</script> <?php
        echo mysqli_error($dbc);
      }

    //GET THE APP ID FOR THIS APPLICANT AND APP DATE
    $q = "SELECT UID, appID FROM history WHERE history.UID = '$applicantUID' AND history.appDate = '$applicantDate';";
    $d = mysqli_query($dbc, $q);
    $r = mysqli_fetch_array($d);
    $appID = $r['appID'];
      //getting rating data into history table
      $query = "UPDATE history SET avgGAS = $avgGAS, avgRec = $avgRec, decisionStatus = '$decisionStatus' WHERE history.UID = '$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID';";
    // $query = "UPDATE history SET GASrating = $GASrating, comments = '$comments', courses = '$courses', reason = '$reason', recRating = $recRating, generic = '$generic', credible = '$credible', decisionStatus = '$decisionStatus' WHERE (history.UID='$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID');";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
    if (!$data){ ?>
      <script>console.log("error in storing rating data in history table");</script> <?php
    }

    //getting app data into history table
    // $query = "UPDATE history SET appDate = 'app.appDate', interests = 'app.interests', advisor = app.advisor, recLetter = app.recLetter, recEmail = app.recEmail, workExperience = app.workExperience WHERE history.UID = '$applicantUID' AND app.UID = '$applicantUID';";
    $query = "UPDATE history INNER JOIN app ON history.UID = app.UID and history.appDate = '$applicantDate' SET history.degree = app.degree, history.appDate = app.appDate, history.interests = app.interests, history.recLetter = app.recLetter, history.recEmail = app.recEmail, history.workExperience = app.workExperience;";
    $data = mysqli_query($dbc, $query) or die (mysqli_error($dbc));
    if (!$data){ ?>
      <script>console.log("error in storing app data in history table");</script> <?php
      echo mysqli_error($dbc);
    }

      //getting prior degree data into history table
      // $query = "UPDATE history INNER JOIN priorDegrees ON history.UID = priorDegrees.UID SET history.BtypeDegree = priorDegrees.BtypeDegree, history.Buniversity = priorDegrees.Buniversity, history.BGPA = priorDegrees.BGPA, history.Bmajor = priorDegrees.Bmajor, history.ByearDegree = priorDegrees.ByearDegree, history.MtypeDegree = priorDegrees.MtypeDegree, history.Muniversity = priorDegrees.Muniversity, history.MGPA = priorDegrees.MGPA, history.Mmajor = priorDegrees.Mmajor, history.MyearDegree = priorDegrees.MyearDegree;";
      $query = "UPDATE history JOIN priorDegrees ON history.UID = priorDegrees.UID
                SET history.BtypeDegree = priorDegrees.BtypeDegree, 
                    history.Buniversity = priorDegrees.Buniversity, 
                    history.BGPA = priorDegrees.BGPA, 
                    history.Bmajor = priorDegrees.Bmajor, 
                    history.ByearDegree = priorDegrees.ByearDegree, 
                    history.MtypeDegree = priorDegrees.MtypeDegree, 
                    history.Muniversity = priorDegrees.Muniversity, 
                    history.MGPA = priorDegrees.MGPA, 
                    history.Mmajor = priorDegrees.Mmajor, 
                    history.MyearDegree = priorDegrees.MyearDegree
                WHERE history.appID = '$appID' AND history.UID = '$applicantUID' and history.appDate = '$applicantDate';";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?>
<?php
        echo mysqli_error($dbc);
      }

      //getting test scores data into history table
      // $query = "UPDATE history INNER JOIN tests ON history.UID = tests.UID SET history.quantitative = tests.quantitative, history.verbal = tests.verbal, history.subjectScore = tests.subjectScore, history.subjectScore2 = tests.subjectScore2, history.subjectScore3 = tests.subjectScore3, history.subject = tests.subject, history.subject2 = tests.subject2, history.subject3 = tests.subject3, history.total = tests.total, history.GREdate = tests.GREdate, history.subjectDate = tests.subjectDate, history.subjectDate2 = tests.subjectDate2, history.subjectDate3 = tests.subjectDate3, history.TOEFLscore = tests.TOEFLscore, history.TOEFLdate = tests.TOEFLdate;";
      $query = "UPDATE history JOIN tests ON history.UID = tests.UID
                SET history.quantitative = tests.quantitative, 
                    history.verbal = tests.verbal, 
                    history.subjectScore = tests.subjectScore, 
                    history.subjectScore2 = tests.subjectScore2, 
                    history.subjectScore3 = tests.subjectScore3, 
                    history.subject = tests.subject, 
                    history.subject2 = tests.subject2, 
                    history.subject3 = tests.subject3, 
                    history.total = tests.total, 
                    history.GREdate = tests.GREdate, 
                    history.subjectDate = tests.subjectDate, 
                    history.subjectDate2 = tests.subjectDate2, 
                    history.subjectDate3 = tests.subjectDate3, 
                    history.TOEFLscore = tests.TOEFLscore, 
                    history.TOEFLdate = tests.TOEFLdate
                WHERE history.UID = '$applicantUID' AND history.appDate = '$applicantDate' AND history.appID = '$appID';";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?> 
 <?php
        echo mysqli_error($dbc);
      }

      //if the decision status is set remove the rows of that student from apps, ratings, and tests
      if(!empty($decisionStatus)){
        $query = "DELETE FROM app WHERE app.UID = '$applicantUID' LIMIT 1;";
        $data = mysqli_query($dbc, $query);
        if (!$data){ ?> 
          <script>console.log("error in deleting applicant from app table");</script> <?php
          echo mysqli_error($dbc);
        }
        //delete from ratings
        // $query = "DELETE FROM ratings WHERE ratings.UID = '$applicantUID' LIMIT 1;";
        // $data = mysqli_query($dbc, $query);
        // if (!$data){ ?> 
        //   <script>console.log("error in deleting applicant from ratings table");</script> <?php
        //   echo mysqli_error($dbc);
        // }
        //delete from tests
        $query = "DELETE FROM tests WHERE tests.UID = '$applicantUID' LIMIT 1;";
        $data = mysqli_query($dbc, $query);
        if (!$data){ ?> 
          <script>console.log("error in deleting applicant from tests table");</script> <?php
          echo mysqli_error($dbc);
        }

        $query = "DELETE FROM priorDegrees WHERE priorDegrees.UID = '$applicantUID' LIMIT 1;";
        $data = mysqli_query($dbc, $query);
        if (!$data){ ?> 
          <script>console.log("error in deleting applicant from priorDegrees table");</script> <?php
          echo mysqli_error($dbc);
        }

        $q = "SELECT email FROM users WHERE UID = '$applicantUID';";
        $d = mysqli_query($dbc, $q) or die (mysqli_error($dbc));
        $r = mysqli_fetch_array($d);
        if (!$d){ ?> 
          <script>alert(an error occurred while saving decision. please try again later)</script>
        <?php }
        else {
          $to = $r['email'];
          $subject = "Admissions Committee | Decision Made";
          $txt = "The application review committee has reviewed your appliaction in full. A decision has been made regarding your admission. 
          \nPlease log into your account to view the decision.";
          $headers = "From: GW Review Committee" . "\r\n";
          mail($to,$subject,$txt,$headers);
        }
      }
          //if the student is admitted, randomly assign a faculty member to be their advisor in history
      // if($decisionStatus == 'Admit with Aid' || $decisionStatus == 'Admit'){
      //   $query = "UPDATE history SET history.advisor = '$advisor' WHERE history.appID = '$appID' AND history.appDate = '$applicantDate' AND history.UID = '$applicantUID';";
      //   $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

      // }

      //find the company again
      $query = ("SELECT company FROM recommenders,app WHERE app.recEmail = recommenders.email AND '$applicantUID' = app.UID");
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
      $company = $row['company'];

      //update the history with company value
      $query = "UPDATE history SET company = $company;";

    }

    //if the decision is not set, just update the ratings table and also update the transcript status
    else{
      //update the table if needed
      $query = "SELECT UID FROM ratings WHERE ratings.UID=$applicantUID;";
      $data = mysqli_query($dbc, $query); 
      $numRows = mysqli_num_rows($data); 

      //if the query results in zero tuples, create a new review
      if($numRows == 0){
      // if($data->num_rows() === 0) {
        $query = "INSERT INTO ratings(UID) VALUES ($applicantUID)";
        mysqli_query($dbc, $query);
        ?><script>console.log("HERE");</script><?php
      }

      $query = "UPDATE ratings SET GASrating = $GASrating, comments = '$comments', courses = '$courses', reason = '$reason', recRating = $recRating, generic = '$generic', credible = '$credible' WHERE ratings.UID='$applicantUID';";
      $data = mysqli_query($dbc, $query);
      if (!$data){ ?>
        <script>console.log("error");</script> <?php
      }
      $query = "UPDATE app SET transcriptStatus = '$transcriptStatus' where app.UID = $applicantUID";
      $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
      if (!$data){ ?>
        <script>console.log("error updating the transcript status");</script> <?php
      }

    }

    



  }

  //
  ?>
      //Redirect to submitted confirmation page
     <script type="text/javascript">
     window.location.href = 'reviewer.php';
    </script>
  
  <?php
  //header('Location: ./reviewer.php');

  
}

?>



</body>

</html>
