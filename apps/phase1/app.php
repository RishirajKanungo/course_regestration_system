<?php 

// VIEW USERS CURRENT APPLICATION FROM APPLICANT.PHP 

    // Start the session
    session_start();

    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    // Include navmenu 
    require_once('../navMenus/navbar.php'); 

    // Include db connection vars 
    require_once('../connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
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
   <style>
        span{
            color:#ac2424;
            font-size: 14px;
            font-style:italics;
        }
        input[type=button]:hover {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[type=button] {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
   </style>
</head>
<body>
<?php 
if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] != 0)) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'home.php';
            </script>
<?php } 
$query = "SELECT * FROM users WHERE users.UID = '$uid';"; 
$d = mysqli_query($dbc, $query);
$data = mysqli_fetch_array($d);
?>

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
            <input disabled  type="text" id="input-perm" name="uid" data-error="lname-err" class="form-control form-group" minlength="1" maxlength="50" value="<?php echo $data['UID']; ?>" >
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
            
            <!-- <input disabled  type="password" id="input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" > -->
            <span id="ssn-err"></span>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="minit">Address:</label>
            <input disabled type="text" id="input" name="address" data-error="minit-err" class="form-control form-group" value="<?php echo $data['address']; ?>" >
            <span id="address-err"></span>
        </div>
    </div>
    <br>
    <?php 
        $query = ("SELECT * FROM app WHERE app.UID='$uid';"); 
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
    ?>
    <h4>General Information</h4><br>
    <div class="form-row form-group">
        <div class="col">
            <label for="inputState"><strong>Degree Applying for:</strong></label>
            <select name="appDegree" id="appDegree" class="form-control">
                <?php if (strcmp($row['degree'], "PhD") == 0) { ?>
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
            </select>
            <span class="error" id="appDegree-err"></span>
        </div>
        <div class="col">
            <label for="interests"><strong>Interests:</strong></label>
            <input type="text" id="input" name="interests" class="form-control form-group" value="<?php echo $row['interests']; ?>" >
            <span class="error" id="interests-err"></span>
        </div>
        <div class="col">
            <label for="work"><strong>Work Experience:</strong></label>
            <input type="text" id="input" name="work" class="form-control form-group" value="<?php echo $row['workExperience']; ?>" >
            <span class="error" id="work-err"></span>
        </div>
        <div class="col">
            <label for="admitDate"><strong>Admission Date:</strong> </label>
            <select id="admitDate" name="admitDate" class="form-control">
            <?php
                $query = ("SELECT appDate
                        FROM history
                        WHERE history.UID='$uid'"); 
                $data = mysqli_query($dbc, $query);

                // Four possible options if no prev apps 
                $f20 = 1; 
                $s21 = 1;
                
                // Determine which semesters the applicant has already applied to 
                while ($row = mysqli_fetch_array($data)) {
                    if (in_array($row['appDate'], ['Fall 2020', 'Spring 2021', 'Fall 2021', 'Spring 2022'])) {
                        if (strcmp($row['appDate'], "Fall 2020") == 0) {
                        $f20 = 0;
                        }
                        else if (strcmp($row['appDate'], "Spring 2021") == 0) {
                        $s21 = 0;
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
                else { ?>
                    <option selected></option>
                <?php }

                if ($f20 == 1){ ?>
                    <option value="Fall 2020">Fall 2020</option>
                <?php }
                if ($s21 == 1){ ?>
                    <option value="Spring 2021">Spring 2021</option>
                <?php } ?>
            </select>
            <span class="error" id="admitDate-err"></span>
        </div>
    </div>
    <br><h4>Recommender Information</h4><br>
    <h6>Credentials and instructions for recommenders will be sent once your application is submitted.</h6>
    <?php 
    $query = ("SELECT title, recommenders.fname AS firstN, recommenders.minit AS mid, recommenders.lname AS lastN, recEmail
    FROM recommenders JOIN app ON app.recEmail=recommenders.email
    WHERE app.UID='$uid';"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    ?>
    <div class="form-row form-group">
        <div class="col">
            <label for="title"><strong>Title:</strong></label>
            <input type="text" id="input" name="title" class="form-control form-group" value="<?php echo $row['title']; ?>" >
            <span class="error" id="title-err"></span>
        </div>
        <div class="col">
            <label for="firstN"><strong>First Name:</strong></label>
            <input type="text" id="input" name="firstN" class="form-control form-group" value="<?php echo $row['firstN']; ?>" >
            <span  class="error"id="firstN-err"></span>
        </div>
        <div class="col">
            <label for="mid"><strong>Middle Initial:</strong></label>
            <input type="text" id="input" name="mid" class="form-control form-group" value="<?php echo $row['mid']; ?>" >
            <span class="error" id="mid-err"></span>
        </div>
        <div class="col">
            <label for="lastN"><strong>Last Name:</strong></label>
            <input type="text" id="input" name="lastN" class="form-control form-group" value="<?php echo $row['lastN']; ?>" >
            <span class="error" id="lastN-err"></span>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="company"><strong>Company/Place of Employment:</strong></label>
            <input type="text" id="input" name="company" class="form-control form-group" value="<?php echo $row['company']; ?>" >
            <span class="error" id="company-err"></span>
        </div>
        <div class="col">
            <label for="recemail"><strong>Email:</strong></label>
            <input type="text" id="input" name="recemail" class="form-control form-group" value="<?php echo $row['recEmail']; ?>" >
            <span class="error" id="recemail-err"></span>
        </div>
    </div>
    <br><h4>Academic Information</h4><br>
    <h5>Test Scores</h5>
    <?php $query = ("SELECT * FROM tests WHERE tests.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data); ?>
    <br><h6>GRE Scores</h6>
    <div class="form-row form-group">
        <div class="col">
            <label for="verbal"><strong>Verbal Score:</strong></label>
            <input type="text" id="verbal" name="verbal" class="form-control form-group" value="<?php echo $row['verbal']; ?>" >
            <span class="error" id="verbal-err"></span>
        </div>
        <div class="col">
            <label for="quant"><strong>Quantitative Score:</strong></label>
            <input type="text" id="quant" name="quant" class="form-control form-group" value="<?php echo $row['quantitative']; ?>" >
            <span class="error" id="quant-err"></span>
        </div>
        <!-- <div class="col"> -->
            <!-- <label for="total"><strong>Total Score:</strong></label> -->
            <!-- <?php //$totalGRE = $row['quantitative'] + $row['verbal']; ?> -->
            <!-- <input type="text" id="total" name="total" class="form-control form-group" value="<?php echo $row['total']; ?>" > -->
            <!-- <span class="error" id="total-err"></span> -->
        <!-- </div> -->
        <div class="col">
            <label for="GREdate"><strong>GRE Exam Date:</strong></label>
            <input type="text" id="GREdate" name="GREdate" placeholder="MM/DD/YYYY" class="form-control form-group" value="<?php echo $row['GREdate']; ?>" >
            <span class="error" id="GREdate-err"></span>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject"><strong>Advanced Subject:</strong></label>
            <input type="text" id="subject" name="subject" class="form-control form-group" value="<?php echo $row['subject']; ?>" >
            <span class="error" id="subject-err"></span>
        </div>
        <div class="col">
            <label for="subjectScore"><strong>Subject Score:</strong></label>
            <input type="text" id="subjectScore" name="subjectScore" class="form-control form-group" value="<?php echo $row['subjectScore']; ?>" >
            <span class="error" id="subjectScore-err"></span>
        </div>
        <div class="col">
            <label for="subjectDate"><strong>Subject Exam Date:</strong></label>
            <input type="text" id="subjectDate" name="subjectDate" class="form-control form-group" placeholder="MM/DD/YYYY" value="<?php echo $row['subjectDate']; ?>" >
            <span class="error" id="subjectDate-err"></span>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject2"><strong>Advanced Subject:</strong></label>
            <input type="text" id="subject2" name="subject2" class="form-control form-group" value="<?php echo $row['subject2']; ?>" >
            <span class="error" id="subject2-err"></span>
        </div>
        <div class="col">
            <label for="subjectScore2"><strong>Subject Score:</strong></label>
            <input type="text" id="subjectScore2" name="subjectScore2" class="form-control form-group" value="<?php echo $row['subjectScore2']; ?>" >
            <span class="error" id="subjectScore2-err"></span>
        </div>
        <div class="col">
            <label for="subjectDate2"><strong>Subject Exam Date:</strong></label>
            <input type="text" id="subjectDate2" name="subjectDate2" class="form-control form-group" placeholder="MM/DD/YYYY" value="<?php echo $row['subjectDate2']; ?>" >
            <span class="error" id="subjectDate2-err"></span>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="subject3"><strong>Advanced Subject:</strong></label>
            <input type="text" id="subject3" name="subject3" class="form-control form-group" value="<?php echo $row['subject3']; ?>" >
            <span class="error" id="subject3-err"></span>
        </div>
        <div class="col">
            <label for="subjectScore3"><strong>Subject Score:</strong></label>
            <input type="text" id="subjectScore3" name="subjectScore3" class="form-control form-group" value="<?php echo $row['subjectScore3']; ?>" >
            <span class="error" id="subjectScore3-err"></span>
        </div>
        <div class="col">
            <label for="subjectDate3"><strong>Subject Exam Date:</strong></label>
            <input type="text" id="subjectDate3" name="subjectDate3" class="form-control form-group" placeholder="MM/DD/YYYY" value="<?php echo $row['subjectDate3']; ?>" >
            <span class="error" id="subjectDate3-err"></span>
        </div>
    </div>
    <br>
    <h6>TOEFL Scores</h6>
    <div class="form-row form-group">
        <div class="col">
            <label for="TOEFLscore"><strong>TOEFL Score:</strong></label>
            <input type="text" id="TOEFLscore" name="TOEFLscore" class="form-control form-group" value="<?php echo $row['TOEFLscore']; ?>" >
            <span class="error" id="TOEFLscore-err"></span>
        </div>
        <div class="col">
            <label for="TOEFLdate"><strong>Exam Date:</strong></label>
            <input type="text" id="TOEFLdate" name="TOEFLdate" placeholder="MM/DD/YYYY" class="form-control form-group" value="<?php echo $row['TOEFLdate']; ?>" >
            <span  class="error" id="TOEFLdate-err"></span>
        </div>
    </div>
    <br><h4>Prior Degrees</h4><br>
    <?php 
    $query = ("SELECT * FROM priorDegrees WHERE priorDegrees.UID='$uid'"); 
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    ?>
    <div class="form-row form-group">
        <div class="col">
            <label for="priorDeg"><strong>Prior Bachelors Degree</strong></label>
            <select id="priorDeg" name="Btype" class="form-control">
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
                    <option selected></option>
                    <option value="BS" >BS</option>
                    <option value="BA">BA</option>
                <?php } ?> 
            </select> 
            <span class="error" id="Btype-err"></span>
        </div>
        <div class="col">
            <label for="Buniversity"><strong>University:</strong></label>
            <input type="text" id="Buniversity" name="Buniversity" class="form-control form-group" value="<?php echo $row['Buniversity']; ?>" >
            <span  class="error" id="Buniversity-err"></span>
        </div>
        <div class="col">
            <label for="ByearDegree"><strong>Graduation Year:</strong></label>
            <input type="text" id="ByearDegree" name="ByearDegree" class="form-control form-group" placeholder="YYYY" value="<?php echo $row['ByearDegree']; ?>" >
            <span  class="error" id="ByearDegree-err"></span>
        </div>
        <div class="col">
            <label for="Bmajor"><strong>Major:</strong></label>
            <input type="text" id="Bmajor" name="Bmajor" class="form-control form-group" value="<?php echo $row['Bmajor']; ?>" >
            <span  class="error" id="Bmajor-err"></span>
        </div>
        <div class="col">
            <label for="BGPA"><strong>GPA:</strong></label>
            <input type="text" id="BGPA" name="BGPA" class="form-control form-group" value="<?php echo $row['BGPA']; ?>" >
            <span  class="error" id="BGPA-err"></span>
        </div>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="priorD"><strong>Prior Masters Degree</strong></label>
            <select id="priorD" name="Mtype" class="form-control">
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
                    <option selected></option>
                    <option value="MS">MS</option>
                    <option value="PhD">PhD</option>
                <?php } ?> 
            </select> 
            <span class="error" id="Mtype-err"></span>
        </div>
        <div class="col">
            <label for="Muniversity"><strong>University:</strong></label>
            <input type="text" id="Muniversity" name="Muniversity" class="form-control form-group" value="<?php echo $row['Muniversity']; ?>" >
            <span class="error" id="Muniversity-err"></span>
        </div>
        <div class="col">
            <label for="MyearDegree"><strong>Graduation Year:</strong></label>
            <input type="text" id="MyearDegree" name="MyearDegree" class="form-control form-group" placeholder="YYYY"  value="<?php echo $row['MyearDegree']; ?>" >
            <span class="error" id="MyearDegree-err"></span>
        </div>
        <div class="col">
            <label for="Mmajor"><strong>Major:</strong></label>
            <input type="text" id="Mmajor" name="Mmajor" class="form-control form-group" value="<?php echo $row['Mmajor']; ?>" >
            <span class="error" id="Mmajor-err"></span>
        </div>
        <div class="col">
            <label for="MGPA"><strong>GPA:</strong></label>
            <input type="text" id="MGPA" name="MGPA" class="form-control form-group" value="<?php echo $row['MGPA']; ?>" >
            <span id="MGPA-err"></span>
        </div>
    </div>
    
    <input type="button" class="btn btn-info float-right" id="send" name="send" value="Submit Application">
    <input type="button" class="btn btn-info float-left" id="save" name="save" value="Save Application">
    <br><br><br><br>

    </form>
    <script>
     $("#send").on('click', function (e) {
            $('#app').validate();
            console.log("send");
            e.preventDefault();
            // var inputs = $("#app :input").serializeArray();
            // console.log(inputs); 
            if ($('#app').valid()){
                // $("#app").valid();
                $.ajax({
                    url: '../phase1/submit-app.php',
                    method:"post",
                    data: $('#app').serialize(),
                    success: function(response) {
                       $('#app').submit();
                       console.log(response);
                       if (response != 0) {
                        alert("Your application has been submitted! You will now be redirected to your dashboard.");
                        window.location.href="../applicant.php";
                       }
                       
                    }
                })

            }
        });
    </script>
</body>
</html>
