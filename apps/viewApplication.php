<?php 
    // Start the session
    session_start();

    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    // Include navmenu 
    require_once('./navMenus/navAppPortal.php'); 

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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<form method="POST">
<?php  
  $query = ("SELECT * 
             FROM users
             WHERE users.UID='$uid'"); 
  $row = mysqli_query($dbc, $query);
  $data = mysqli_fetch_array($row);
?>
  <!-- Personal Information -->

  <div class="container">
    <form action="" method="POST" id="app">
    <h4>Personal Information</h4><br>
    <div class="form-row">
        <div class="col">
            <label for="fname">First Name:</label>
            <input disabled type="text" id="input" name="fname" data-error="fname-err" class="form-control form-group" label="First Name: " minlength="1" maxlength="50" value="<?php echo $data['fname']; ?>"  >
            <span id="fname-err"></span>
        </div>
        <div class="col">
            <label for="minit">Middle Initial:</label>
            <input disabled type="text" id="input" name="minit" data-error="minit-err" class="form-control form-group" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $data['minit']; ?>" >
            <span id="minit-err"></span>
        </div>
        <div class="col">
            <label for="lname">Last Name:</label>
            <input disabled type="text" id="input" name="lname" data-error="lname-err" class="form-control form-group" minlength="1" maxlength="50" value="<?php echo $data['lname']; ?>" >
            <span id="lname-err"></span>
        </div>
        <div class="col">
            <label for="uid">UID:</label>
            <input disabled type="text" id="input-perm" name="uid" data-error="lname-err" class="form-control form-group" minlength="1" maxlength="50" value="<?php echo $data['UID']; ?>" >
            <span id="uid-err"></span>
        </div>
        <div class="col">
            <label for="typeUser">Type of User:</label>
            <div name="typeUser" class="input-group mb-3">
                <?php if ($data['typeUser'] == 0){
                    $typeUser = "Applicant"; ?>
                    <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                <?php }
                else if ($data['typeUser'] == 1){
                    $typeUser = "Faculty Reviewer"; ?>
                    <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                <?php }
                else if ($data['typeUser'] == 2){
                    $typeUser = "Chair"; ?>
                    <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                <?php }
                else if ($data['typeUser'] == 3){
                    $typeUser = "Graduate Secretary"; ?>
                    <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                <?php }
                else if ($data['typeUser'] == 4){
                    $typeUser = "System Administrator"; ?>
                    <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                <?php } ?>                                                    
            </div>
            <!-- <input disabled  type="text" id="input" name="typeUser" data-error="fname-err" class="form-control form-group" value="<?php echo $typeUser?>" > -->
            <span id="type-err"></span>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="username">Username:</label>
            <input disabled  type="text" id="input-perm" name="username" data-error="fname-err" class="form-control form-group" value="<?php echo $data['username']; ?>"  >
            <span id="username-err"></span>
        </div>
        <div class="col">
            <label for="password">Password:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <input id="check" type="checkbox" aria-label="Checkbox for following text input">
                    </div>
                    <script>
                        $('#check').click(function(){
                            if('password' == $('#pass-input').attr('type')){
                                $('#pass-input').prop('type', 'text');
                            }else{
                                $('#pass-input').prop('type', 'password');
                            }
                        });
                    </script>
                </div>
                <input disabled  type="password" id="pass-input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" >
            </div>
            <!-- <input disabled  type="password" id="input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" > -->
            <span id="pass-err"></span>
        </div>
        <div class="col">
            <label for="fname">Email:</label>
            <input disabled type="text" id="input" name="email" data-error="fname-err" class="form-control form-group" value="<?php echo $data['email']; ?>"  >
            <span id="email-err"></span>
        </div>
        <div class="col">
            <label for="ssn">SSN:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <input id="check2" type="checkbox" aria-label="Checkbox for following text input">
                    </div>
                    <script>
                        $('#check2').click(function(){
                            if('password' == $('#ssn-input').attr('type')){
                                $('#ssn-input').prop('type', 'text');
                            }else{
                                $('#ssn-input').prop('type', 'password');
                            }
                        });
                    </script>
                </div>
                <input disabled  type="password" id="ssn-input" name="ssn" class="form-control form-group" maxlength=9 value="<?php echo $data['ssn']; ?>" >
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="minit">Address:</label>
            <input disabled type="text" id="input" name="address" data-error="minit-err" class="form-control form-group" value="<?php echo $data['address']; ?>" >
        </div>
    </div>
    <br>

  <!-- General Info -->
  <!-- <h3> General Info </h3> -->
  <!-- Drop down bar to select MS or PhD -->
  <?php 
    $query = ("SELECT * 
               FROM app 
               WHERE app.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>

  <h4>General Information</h4><br>
    <div class="form-row form-group">
        <div class="col">
            <label for="inputState"><strong>Degree Applying for:</strong></label>
            <input disabled type="text" id="input" name="degree" class="form-control form-group" value="<?php echo $row['degree']; ?>" >
        </div>
        <div class="col">
            <label for="interests"><strong>Interests:</strong></label>
            <input disabled type="text" id="input" name="interests" class="form-control form-group" value="<?php echo $row['interests']; ?>" >
        </div>
        <div class="col">
            <label for="work"><strong>Work Experience:</strong></label>
            <input disabled type="text" id="input" name="work" class="form-control form-group" value="<?php echo $row['workExperience']; ?>" >
        </div>
        <div class="col">
            <label for="admitDate"><strong>Admission Date:</strong> </label>
            <input disabled type="text" id="input" name="admitDate" class="form-control form-group" value="<?php echo $row['appDate']; ?>" >
        </div>
      </div>
  
  <!-- Recommender Info -->
  <br><h4>Recommender Information</h4><br>
  <h6>Credentials and instructions for recommenders will be sent once your application is submitted.</h6>
  <?php 
    $query = ("SELECT company, title, recommenders.fname AS firstN, recommenders.minit AS mid, recommenders.lname AS lastN, recEmail
               FROM recommenders, app 
               WHERE app.recEmail=recommenders.email"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
  <div class="form-row form-group">
        <div class="col">
            <label for="title"><strong>Title:</strong></label>
            <input disabled type="text" id="input" name="title" class="form-control form-group" value="<?php echo $row['title']; ?>" >
        </div>
        <div class="col">
            <label for="firstN"><strong>First Name:</strong></label>
            <input disabled type="text" id="input" name="firstN" class="form-control form-group" value="<?php echo $row['firstN']; ?>" >
        </div>
        <div class="col">
            <label for="mid"><strong>Middle Initial:</strong></label>
            <input disabled type="text" id="input" name="mid" class="form-control form-group" value="<?php echo $row['mid']; ?>" >
        </div>
        <div class="col">
            <label for="lastN"><strong>Last Name:</strong></label>
            <input disabled type="text" id="input" name="lastN" class="form-control form-group" value="<?php echo $row['lastN']; ?>" >
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="company"><strong>Company/Place of Employment:</strong></label>
            <input disabled type="text" id="input" name="company" class="form-control form-group" value="<?php echo $row['company']; ?>" >
        </div>
        <div class="col">
            <label for="recemail"><strong>Email:</strong></label>
            <input disabled type="text" id="input" name="recemail" class="form-control form-group" value="<?php echo $row['recEmail']; ?>" >
        </div>
    </div>

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
   <br><h6>GRE Scores</h6>
    <div class="form-row form-group">
        <div class="col">
            <label for="verbal"><strong>Verbal Score:</strong></label>
            <input disabled type="text" id="verbal" name="verbal" class="form-control form-group" value="<?php echo $row['verbal']; ?>" >
        </div>
        <div class="col">
            <label for="quant"><strong>Quantitative Score:</strong></label>
            <input disabled type="text" id="quant" name="quant" class="form-control form-group" value="<?php echo $row['quantitative']; ?>" >
        </div>
        <div class="col">
            <label for="total"><strong>Total Score:</strong></label>
            <input disabled type="text" id="total" name="total" class="form-control form-group" value="<?php echo $row['total']; ?>" >
        </div>
        <div class="col">
            <label for="GREdate"><strong>GRE Exam Date:</strong></label>
            <input disabled type="text" id="GREdate" name="GREdate" placeholder="DDMONYY" class="form-control form-group" value="<?php echo $row['GREdate']; ?>" >
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject"><strong>Advanced Subject:</strong></label>
            <input disabled type="text" id="subject" name="subject" class="form-control form-group" value="<?php echo $row['subject']; ?>" >
        </div>
        <div class="col">
            <label for="subjectScore"><strong>Subject Score:</strong></label>
            <input disabled type="text" id="subjectScore" name="subjectScore" class="form-control form-group" value="<?php echo $row['subjectScore']; ?>" >
        </div>
        <div class="col">
            <label for="subjectDate"><strong>Subject Exam Date:</strong></label>
            <input disabled type="text" id="subjectDate" name="subjectDate" class="form-control form-group" value="<?php echo $row['subjectDate']; ?>" >
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject2"><strong>Advanced Subject:</strong></label>
            <input disabled type="text" id="subject2" name="subject2" class="form-control form-group" value="<?php echo $row['subject2']; ?>" >
            <span class="error" id="subject-err"></span>
        </div>
        <div class="col">
            <label for="subjectScore2"><strong>Subject Score:</strong></label>
            <input disabled type="text" id="subjectScore2" name="subjectScore2" class="form-control form-group" value="<?php echo $row['subjectScore2']; ?>" >
            <span class="error" id="subjectScore-err"></span>
        </div>
        <div class="col">
            <label for="subjectDate2"><strong>Subject Exam Date:</strong></label>
            <input disabled type="text" id="subjectDate2" name="subjectDate2" class="form-control form-group" placeholder="MM/DD/YYYY" value="<?php echo $row['subjectDate2']; ?>" >
            <span class="error" id="subjectDate-err"></span>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject3"><strong>Advanced Subject:</strong></label>
            <input disabled type="text" id="subject3" name="subject3" class="form-control form-group" value="<?php echo $row['subject3']; ?>" >
            <span class="error" id="subject-err"></span>
        </div>
        <div class="col">
            <label for="subjectScore3"><strong>Subject Score:</strong></label>
            <input disabled type="text" id="subjectScore3" name="subjectScore3" class="form-control form-group" value="<?php echo $row['subjectScore3']; ?>" >
            <span class="error" id="subjectScore-err"></span>
        </div>
        <div class="col">
            <label for="subjectDate3"><strong>Subject Exam Date:</strong></label>
            <input disabled type="text" id="subjectDate3" name="subjectDate3" class="form-control form-group" placeholder="MM/DD/YYYY" value="<?php echo $row['subjectDate3']; ?>" >
            <span class="error" id="subjectDate-err"></span>
        </div>
    </div>
    <br>
    <h6>TOEFL Scores</h6>
    <div class="form-row form-group">
        <div class="col">
            <label for="TOEFLscore"><strong>TOEFL Score:</strong></label>
            <input disabled type="text" id="TOEFLscore" name="TOEFLscore" class="form-control form-group" value="<?php echo $row['TOEFLscore']; ?>" >
        </div>
        <div class="col">
            <label for="TOEFLdate"><strong>Exam Date:</strong></label>
            <input disabled type="text" id="TOEFLdate" name="TOEFLdate" placeholder="DDMONYY" class="form-control form-group" value="<?php echo $row['TOEFLdate']; ?>" >
        </div>
    </div>

   <!-- Prior Degree Info -->
  <h4> Prior Degrees </h4>
  <?php 
    $query = ("SELECT * 
               FROM priorDegrees 
               WHERE priorDegrees.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
  ?>
 
  <div class="form-row form-group">
        <div class="col">
            <label for="priorDeg"><strong>Prior Bachelors Degree</strong></label>
            <input disabled type="text" name="priorDeg" class="form-control form-group" value="<?php echo $row['BtypeDegree'] ?>">
        </div>
        <div class="col">
            <label for="Buniversity"><strong>University:</strong></label>
            <input disabled type="text" id="input" name="Buniversity" class="form-control form-group" value="<?php echo $row['Buniversity']; ?>" >
        </div>
        <div class="col">
            <label for="ByearDegree"><strong>Graduation Year:</strong></label>
            <input disabled type="text" id="input" name="ByearDegree" class="form-control form-group" placeholder="YYYY" value="<?php echo $row['ByearDegree']; ?>" >
        </div>
        <div class="col">
            <label for="Bmajor"><strong>Major:</strong></label>
            <input disabled type="text" id="input" name="Bmajor" class="form-control form-group" value="<?php echo $row['Bmajor']; ?>" >
        </div>
        <div class="col">
            <label for="BGPA"><strong>GPA:</strong></label>
            <input disabled type="text" id="input" name="BGPA" class="form-control form-group" value="<?php echo $row['BGPA']; ?>" >
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="priorD"><strong>Prior Masters Degree</strong></label>
            <input disabled type="text" name="priorD" class="form-control form-group" value="<?php echo $row['MtypeDegree'] ?>">
        </div>
        <div class="col">
            <label for="Muniversity"><strong>University:</strong></label>
            <input disabled type="text" id="input" name="Muniversity" class="form-control form-group" value="<?php echo $row['Muniversity']; ?>" >
        </div>
        <div class="col">
            <label for="MyearDegree"><strong>Graduation Year:</strong></label>
            <input disabled type="text" id="input" name="MyearDegree" class="form-control form-group" placeholder="YYYY"  value="<?php echo $row['MyearDegree']; ?>" >
        </div>
        <div class="col">
            <label for="Mmajor"><strong>Major:</strong></label>
            <input disabled type="text" id="input" name="Mmajor" class="form-control form-group" value="<?php echo $row['Mmajor']; ?>" >
        </div>
        <div class="col">
            <label for="MGPA"><strong>GPA:</strong></label>
            <input disabled type="text" id="input" name="MGPA" class="form-control form-group" value="<?php echo $row['MGPA']; ?>" >
        </div>
    </div>
    <?php 
        $query = "SELECT decisionStatus, submissionStatus, recStatus, transcriptStatus FROM app WHERE UID = $uid;";
        $row = mysqli_query($dbc, $query);
        $data = mysqli_fetch_array($row);
    ?>
    <br><h3>Application Status</h3>
    <div class="form-row">
        <div class="col">                                        
            <label for="decisionStatus"><strong>Admission Decision Status:</strong></label>
            <input disabled type="text" name="decisionStatus" class="form-control" value="<?php echo $data['decisionStatus'] ?>">
        </div>
        <div class="col">
            <label for="lname"><strong>Application Submission Status:</strong></label>
            <input disabled  type="text" id="input" name="submissionStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['submissionStatus']; ?>" >
        </div>
        <div class="col">
            <label for="lname"><strong>Recommendation Letter Status:</strong></label>
            <input disabled  type="text" id="input" name="recStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['recStatus']; ?>" >
        </div>
        <div class="col">
            <label for="lname"><strong>Transcript Status:</strong></label>
            <input disabled  type="text" id="input" name="transcriptStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['transcriptStatus']; ?>" >
        </div>
    </div></br></br>
  </form>
</div>

