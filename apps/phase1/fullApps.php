<!DOCTYPE html>
 <!--VIEW APPLICANT HISTORY AS SYS ADMIN  -->
<head>
    <title>View Applicant History</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/sysad.css" rel="stylesheet">
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
<body>
</body>
</html>
<?php 
    session_start();
    require_once('../connectvars.php');
    require_once('../navMenus/navSys.php');
    // require_once('../navMenus/navAppPortal.php'); 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!isset($_SESSION['uid']) && !isset($_SESSION['typeUser']) || ($_SESSION['typeUser']) != '4' ) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'home.php';
            </script>
        <?php
    }
    else { 
        // SYS ADMIN UID
        $uid_inuse = $_SESSION['uid'];

        // PAST APPLICATION so query in history 
        if (isset($_POST['decision'])) {

            $uid = $_POST['app-uid'];
            // echo $uid;
            $appDate = $_POST['date'];
            $decision = $_POST['decision'];
            
            $q = "SELECT * FROM history WHERE UID = '$uid' AND appDate = '$appDate';";
            $d = mysqli_query($dbc, $q);
            $data = mysqli_fetch_array($d);

            $q1 = "SELECT * FROM users WHERE UID = '$uid';";
            $d1 = mysqli_query($dbc, $q1);
            $data1 = mysqli_fetch_array($d1);

            $q2 = "SELECT * FROM recommenders JOIN app ON app.recEmail = recommenders.email WHERE app.UID = $uid;";
            $d2 = mysqli_query($dbc, $q2);
            $data2 = mysqli_fetch_array($d2);
            
            if (!$d || !$d1 || !$d2){
                echo 'something went wrong';
            }
                 ?>
                    <div class="container">
                        <form action="" method="POST" id="pastapp">
                            <section>
                                <div class="form-row">
                                    <h3>Personal Information</h3>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">First Name:</label>
                                        <input disabled  type="text" id="input" name="fname" data-error="fname-err" class="form-control form-group" value="<?php echo $data1['fname']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Middle Initial:</label>
                                        <input disabled  type="text" id="input" name="minit" data-error="minit-err" class="form-control form-group" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $data1['minit']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Last Name:</label>
                                        <input disabled  type="text" id="input" name="lname" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data1['lname']; ?>" >
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="uid">UID:</label>
                                        <input disabled  type="text" id="input" name="uid" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data1['UID']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="typeUser">Type of User:</label>
                                        <div name="typeUser" class="input-group mb-3">
                                            <?php if ($data1['typeUser'] == 0){
                                                $typeUser = "Applicant"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="0" selected><?php echo $typeUser ?></option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                </select>
                                            <?php }
                                            else if ($data1['typeUser'] == 1){
                                                $typeUser = "Faculty Reviewer"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="1" selected><?php echo $typeUser ?></option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($data1['typeUser'] == 2){
                                                $typeUser = "Chair"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="2" selected><?php echo $typeUser ?></option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($data1['typeUser'] == 3){
                                                $typeUser = "Graduate Secretary"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="3" selected><?php echo $typeUser ?></option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                </select>
                                            <?php }
                                            else if ($data1['typeUser'] == 4){
                                                $typeUser = "System Administrator"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="4" selected><?php echo $typeUser ?></option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                </select>
                                            <?php } ?>                                                    
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="fname">Username:</label>
                                        <input disabled  type="text" id="input" name="username" data-error="fname-err" class="form-control form-group" value="<?php echo $data1['username']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Password:</label>
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
                                        <input disabled  type="password" id="pass-input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data1['password']; ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Email:</label>
                                        <input disabled  type="text" id="input" name="email" data-error="fname-err" class="form-control form-group" value="<?php echo $data1['email']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label data-error="wrong" data-success="right" for="minit">SSN:</label>
                                        <input disabled  type="password" id="input" name="ssn" data-error="minit-err" class="form-control form-group validate" value="<?php echo $data1['ssn']; ?>" > 
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="minit">Address:</label>
                                        <input disabled type="text" id="input" name="address" data-error="minit-err" class="form-control form-group" value="<?php echo $data1['address']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>General Information</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Degree Applying to:</label>
                                        <input disabled  type="text" id="input" name="degree" data-error="fname-err" class="form-control form-group" value="<?php echo $data['degree']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Semester/Year you desire to attend:</label>
                                        <input disabled  type="text" id="input" name="appDate" data-error="minit-err" class="form-control form-group" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $data['appDate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Areas of Interest:</label>
                                        <input disabled  type="text" id="input" name="interest" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data['interests']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Work Experience:</label>
                                        <input disabled  type="text" id="input" name="work" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data['workExperience']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Recommender Information</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Title:</label>
                                        <input disabled  type="text" id="input" name="title" data-error="fname-err" class="form-control form-group" value="<?php echo $data2['title']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">First Name:</label>
                                        <input disabled  type="text" id="input" name="firstN" data-error="minit-err" class="form-control form-group" label="Middle Initial"  value="<?php echo $data2['fname']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Middle Initial:</label>
                                        <input disabled  type="text" id="input" name="mid" data-error="lname-err" class="form-control form-group" value="<?php echo $data2['minit']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Last Name:</label>
                                        <input disabled  type="text" id="input" name="lastN" data-error="lname-err" class="form-control form-group" value="<?php echo $data2['lname']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Recommender Email:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $data2['recEmail']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Place of Employment:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $data2['company']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                <?php if ($data['recLetter'] == "Submitted"){
                                    $recLetter = $data['recLetter'];
                                }
                                else {
                                    $recLetter = "Not yet received";
                                } ?>                           
                                    <div class="col">
                                        <label for="lname">Recommender Letter:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $recLetter; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <h3>Test Scores</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">GRE Verbal Score:</label>
                                        <input disabled  type="text" id="input" name="verbal" data-error="fname-err" class="form-control form-group" value="<?php echo $data['verbal']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Quantitative Score:</label>
                                        <input disabled  type="text" id="input" name="quant" data-error="minit-err" class="form-control form-group" value="<?php echo $data['quantitative']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Total:</label>
                                        <input disabled  type="text" id="input" name="total" data-error="lname-err" class="form-control form-group" value="<?php echo $data['total']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="gre-date" data-error="lname-err" class="form-control form-group" value="<?php echo $data['GREdate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['subject']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['subjectScore']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['subjectDate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject2" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subject2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject2-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectScore2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject2-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectDate2']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject3" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subject2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject3-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectScore2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject3-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectDate2']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">TOEFL Score:</label>
                                        <input disabled  type="text" id="input" name="toefl" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['TOEFLscore']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="toefl-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['TOEFLdate']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Bachelors Degree</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Degree Type:</label>
                                        <input disabled  type="text" id="input" name="bdegree-type" data-error="fname-err" class="form-control form-group" value="<?php echo $data['BtypeDegree']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">University:</label>
                                        <input disabled  type="text" id="input" name="buniv" data-error="minit-err" class="form-control form-group" value="<?php echo $data['Buniversity']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Year:</label>
                                        <input disabled  type="text" id="input" name="byear" data-error="lname-err" class="form-control form-group" value="<?php echo $data['ByearDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Major:</label>
                                        <input disabled  type="text" id="input" name="bmajor" data-error="lname-err" class="form-control form-group" value="<?php echo $data['Bmajor']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GPA:</label>
                                        <input disabled  type="text" id="input" name="bgpa" data-error="lname-err" class="form-control form-group" value="<?php echo $data['BGPA']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Masters Degree</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Degree Type:</label>
                                        <input disabled  type="text" id="input" name="mdegree" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['MtypeDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Univerisity:</label>
                                        <input disabled  type="text" id="input" name="muniv" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['Muniversity']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Year:</label>
                                        <input disabled  type="text" id="input" name="myear" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['MyearDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Major:</label>
                                        <input disabled  type="text" id="input" name="mmajor" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['Mmajor']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GPA:</label>
                                        <input disabled  type="text" id="input" name="mgpa" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['MGPA']; ?>" >
                                    </div>
                                </div>
                                <section>
                                <br><h3>Application Status</h3>
                                <div class="form-row">
                                    <div class="col">                                        
                                        <label for="decisionStatus">Admission Decision Status:</label>
                                        <div name="typeUser" class="input-group mb-3">
                                            <?php if ($data['decisionStatus'] == "Pending"){
                                                $decision = "Pending"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="0" selected><?php echo $decision ?></option>
                                                    <option value="1">Reject</option>
                                                    <option value="3">Admit without Aid</option>
                                                    <option value="4">Admit with Aid</option>
                                                </select>
                                            <?php }
                                            else if ($data['decisionStatus'] == "Reject"){
                                                $decision = "Reject"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="1" selected><?php echo $decision ?></option>
                                                    <option value="3">Admit without Aid</option>
                                                    <option value="4">Admit with Aid</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($data['decisionStatus'] == "Admit without Aid"){
                                                $decision = "Admit without Aid"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="3" selected><?php echo $decision ?></option>
                                                    <option value="4">Admit with Aid</option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Reject</option>
                                                </select>
                                            <?php }
                                            else if ($data['decisionStatus'] == "Admit with Aid"){
                                                $decision = "Admit with Aid"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="4" selected><?php echo $decision ?></option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="3">Admit without Aid</option>
                                                </select>
                                            <?php } ?>                                                    
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="lname">Application Submission Status:</label>
                                        <input disabled  type="text" id="input" name="submissionStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data2['submissionStatus']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Recommendation Letter Status:</label>
                                        <input disabled  type="text" id="input" name="recStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data2['recStatus']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Transcript Status:</label>
                                        <input disabled  type="text" id="input" name="transcriptStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $data2['transcriptStatus']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Application Review</h3>
                                <h5>GAS Reviewer Ratings</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GAS Rating:</label>
                                        <input disabled  type="text" id="input" name="GASrating" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['GASrating']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Comments:</label>
                                        <input disabled  type="text" id="input" name="comments" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['comments']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Courses:</label>
                                        <input disabled  type="text" id="input" name="courses" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['courses']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Reason:</label>
                                        <input disabled  type="text" id="input" name="reason" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['reason']; ?>" >
                                    </div>
                                </div>
                                <h5>Faculty Reviewer Ratings</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Recommendation Letter Rating:</label>
                                        <input disabled  type="text" id="input" name="recRating" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['recRating']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Generic:</label>
                                        <input disabled  type="text" id="input" name="generic" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['generic']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Credible:</label>
                                        <input disabled  type="text" id="input" name="credible" data-error="lname-err" class="form-control form-group"  value="<?php echo $data['credible']; ?>" >
                                    </div>
                                </div><br>
                            </section>
                                <input type="hidden" class="btn btn-info float-right" id="save1" name="save1" value="Save Changes">
                                <input type="hidden" class="btn btn-dark float-left" id="cancel1" name="cancel1" value="Cancel">
                            </form>
                    </div>
                    <script>
                    console.log("update: " + document.querySelector('#edit1').value);
                        document.getElementById("edit1").onclick = function () {
                                console.log("in update profile");
                                $('input[type=password]').attr('password', 'text'); 
                                // $('input').removeAttr('disabled');
                                $('input[name=fname]').removeAttr('disabled');
                                $('input[name=minit]').removeAttr('disabled');
                                $('input[name=lname]').removeAttr('disabled');
                                $('input[name=email]').removeAttr('disabled');
                                $('input[name=typeUser]').removeAttr('disabled');
                                $('input[name=password]').removeAttr('disabled');
                                $('input[name=address]').removeAttr('disabled');
                                // $('input[name=decisionStatus]').removeAttr('disabled');
                                $('select[name=typeUser]').removeAttr('disabled');

                                var v = document.getElementById("edit1");
                                v.setAttribute('type','hidden');
                                var s = document.getElementById("save1");
                                s.setAttribute('type','button');
                                var s = document.getElementById("cancel1");
                                s.setAttribute('type','button');
                            }
                            document.getElementById("save1").onclick = function() { 
                                console.log("in save changes");
                                var f = document.getElementsByName("fname")[0].value;
                                console.log("fname: " + f);
                                var m = document.getElementsByName("minit")[0].value;
                                var l = document.getElementsByName("lname")[0].value;
                                var t = $("#inputGroupSelect option:selected").text()
                                var uid = document.getElementsByName("uid")[0].value;
                                var ogUID = document.getElementsByName("uid")[0].value;
                                var a = document.getElementsByName("address")[0].value;
                                var e = document.getElementsByName("email")[0].value;
                                var ssn = document.getElementsByName("ssn")[0].value;
                                var u = document.getElementsByName("username")[0].value;
                                var p = document.getElementsByName("password")[0].value;
                                var appDate = document.getElementsByName("appDate")[0].value;
                                var decision = $("#decisionStatus option:selected").text();

                                var validator = $("#pastapp").validate({
                                    rules: {
                                        fname: {required:true, lettersonly:true, maxlength: 25},
                                        minit: {maxlength:1, lettersonly:true},
                                        lname: {required:true, lettersonly: true, maxlength:25},
                                        email: {email:true, required:true},
                                        address: {required:true, maxlength: 100},
                                        password: {required: true, maxlength:40},
                                        typeUser: {required: true},
                                        decision: {requied: true}
                                    }
                                });

                                if ($('#pastapp').valid()) {
                                    $.ajax({
                                        url: "./edit-app.php",
                                        type: 'POST',
                                        data: {fname:f, minit:m, lname:l, typeUser:t, uid:uid, address:a, email:e, ssn:ssn, username:u, password:p, ogUID:ogUID, decisionStatus:decision, appDate:appDate},                            
                                        success: function(data) {
                                            console.log("response: " + data);
                                            $('#pastapp').submit()
                                            location.reload();
                                        }
                                    })
                                }
                            }
                    </script>
               <?php //}
            //}
        }
        // CURRENT APPLICATION
        else if (isset($_POST['submission'])) {
            $uid = $_POST['app-uid'];
            // echo $uid;
            $submissionStatus = $_POST['submission'];
            $appDate = $_POST['date'];
            // $q = "SELECT * FROM users, app, tests, priorDegrees WHERE users.UID = '$uid' AND appDate = '$appDate' AND submissionStatus = '$submissionStatus';";
            // PERSONAL INFO
            $q = "SELECT * FROM users WHERE users.UID = $uid;"; 
            $d = mysqli_query($dbc, $q);
            $r = mysqli_fetch_array($d);
            
            // RECOMMENDER INFO
            $q2 = ("SELECT title, company, recommenders.fname AS firstN, recommenders.minit AS mid, recommenders.lname AS lastN, recEmail
                                    FROM recommenders JOIN app ON recommenders.email = app.recEmail
                                    WHERE app.UID='$uid' AND app.recEmail=recommenders.email"); 
            $d2 = mysqli_query($dbc, $q2);
            $r2 = mysqli_fetch_array($d2);

            // TESTS
            $q3 = "SELECT * FROM tests WHERE tests.UID = $uid;";
            $d3 = mysqli_query($dbc, $q3);
            $r3 = mysqli_fetch_array($d3);

            // APP INFO
            $q4 = "SELECT * FROM app WHERE app.UID = $uid;";
            $d4 = mysqli_query($dbc, $q4);
            $r4 = mysqli_fetch_array($d4);

            // PRIOR DEGREES
            $q5 = "SELECT * FROM priorDegrees WHERE priorDegrees.UID = $uid;";
            $d5 = mysqli_query($dbc, $q5);
            $r5 = mysqli_fetch_array($d5);

            // PRIOR DEGREES
            $q6 = "SELECT * FROM ratings WHERE ratings.UID = $uid;";
            $d6 = mysqli_query($dbc, $q6);
            $r6 = mysqli_fetch_array($d6);

            if (!$d || !$d2 || !$d3 || !$d4 || !$d5 || !$d6 ){
                echo 'something went wrong';
            }
            // echo mysqli_num_rows($d);
            if ((mysqli_num_rows($d) > 0)){ ?>
                    <div class="container">
                        <!-- <form action="" method="POST" id="curr-app"> -->
                        <form action="" method="POST" id="current">
                            <section>
                                <h3>Personal Information</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">First Name:</label>
                                        <input disabled  type="text" id="input" name="fname" data-error="fname-err" class="form-control" value="<?php echo $r['fname']; ?>"  >
                                        <span class="error" id="fname-err"></span>
                                    </div>
                                    <div class="col">
                                        <label for="minit">Middle Initial:</label>
                                        <input disabled  type="text" id="input" name="minit" data-error="minit-err" class="form-control" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $r['minit']; ?>" >
                                        <span class="error" id="minit-err"></span>
                                    </div>
                                    <div class="col">
                                        <label for="lname">Last Name:</label>
                                        <input disabled  type="text" id="input" name="lname" data-error="lname-err" class="form-control" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $r['lname']; ?>" >
                                        <span class="error" id="lname-err"></span>
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="uid">UID:</label>
                                        <input disabled  type="text" id="input" name="uid" data-error="lname-err" class="form-control" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $r['UID']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="typeUser">Type of User:</label>
                                        <div name="typeUser" class="input-group mb-3">
                                            <?php if ($r['typeUser'] == 0){
                                                $typeUser = "Applicant"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="0" selected><?php echo $typeUser ?></option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                </select>
                                            <?php }
                                            else if ($r['typeUser'] == 1){
                                                $typeUser = "Faculty Reviewer"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="1" selected><?php echo $typeUser ?></option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($r['typeUser'] == 2){
                                                $typeUser = "Chair"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="2" selected><?php echo $typeUser ?></option>
                                                    <option value="3">Graduate Secretary</option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($r['typeUser'] == 3){
                                                $typeUser = "Graduate Secretary"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="3" selected><?php echo $typeUser ?></option>
                                                    <option value="4">System Administrator</option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                </select>
                                            <?php }
                                            else if ($r['typeUser'] == 4){
                                                $typeUser = "System Administrator"; ?>
                                                <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                    <option value="4" selected><?php echo $typeUser ?></option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="2">Chair</option>
                                                    <option value="3">Graduate Secretary</option>
                                                </select>
                                            <?php } ?>                                                    
                                        </div>
                                        <span class="error" id="type-err"></span>
                                    </div>
                                    <div class="col">
                                        <label for="fname">Username:</label>
                                        <input disabled  type="text" id="input" name="username" data-error="fname-err" class="form-control" value="<?php echo $r['username']; ?>"  >
                                        <span class="error" id="username-err"></span>
                                    </div>
                                    <div class="col">
                                        <label for="minit">Password:</label>
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
                                        <input disabled  type="password" id="pass-input" name="password" data-error="minit-err" class="form-control" value="<?php echo $r['password']; ?>" >
                                        <span class="error" id="password-err"></span>
                                        </div>
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Email:</label>
                                        <input disabled  type="text" id="input" name="email" data-error="fname-err" class="form-control" value="<?php echo $r['email']; ?>"  >
                                        <span class="error" id="email-err"></span>
                                    </div>
                                    <div class="col">
                                        <label data-error="wrong" data-success="right" for="minit">SSN:</label>
                                        <input disabled  type="password" id="input" name="ssn" data-error="minit-err" class="form-control validate" value="<?php echo $r['ssn']; ?>" > 
                                    </div>
                                </div>
                                <div><br></div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="minit">Address:</label>
                                        <input disabled type="text" id="input" name="address" data-error="minit-err" class="form-control" value="<?php echo $r['address']; ?>" >
                                        <span class="error" id="address-err"></span>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>General Information</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Degree Applying to:</label>
                                        <input disabled  type="text" id="input" name="degree" data-error="fname-err" class="form-control form-group" value="<?php echo $r4['degree']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Semester/Year you desire to attend:</label>
                                        <input disabled  type="text" id="input" name="appDate" data-error="minit-err" class="form-control form-group" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $r4['appDate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Areas of Interest:</label>
                                        <input disabled  type="text" id="input" name="interest" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $r4['interests']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Work Experience:</label>
                                        <input disabled  type="text" id="input" name="work" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $r4['workExperience']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Recommender Information</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Title:</label>
                                        <input disabled  type="text" id="input" name="title" data-error="fname-err" class="form-control form-group" value="<?php echo $r2['title']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">First Name:</label>
                                        <input disabled  type="text" id="input" name="firstN" data-error="minit-err" class="form-control form-group" label="Middle Initial"  value="<?php echo $r2['firstN']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Middle Initial:</label>
                                        <input disabled  type="text" id="input" name="mid" data-error="lname-err" class="form-control form-group" value="<?php echo $r2['mid']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Last Name:</label>
                                        <input disabled  type="text" id="input" name="lastN" data-error="lname-err" class="form-control form-group" value="<?php echo $r2['lastN']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Recommender Email:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $r2['recEmail']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Place of Employment:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $r2['company']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                <?php if ($r4['recLetter'] == "Submitted"){
                                    $recLetter = $r4['recLetter'];
                                }
                                else {
                                    $recLetter = "Not yet received";
                                } ?>                           
                                    <div class="col">
                                        <label for="lname">Recommender Letter:</label>
                                        <input disabled  type="text" id="input" name="recEmail" data-error="lname-err" class="form-control form-group"  value="<?php echo $recLetter; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Test Scores</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">GRE Verbal Score:</label>
                                        <input disabled  type="text" id="input" name="verbal" data-error="fname-err" class="form-control form-group" value="<?php echo $r3['verbal']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">Quantitative Score:</label>
                                        <input disabled  type="text" id="input" name="quant" data-error="minit-err" class="form-control form-group" value="<?php echo $r3['quantitative']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Total:</label>
                                        <input disabled  type="text" id="input" name="total" data-error="lname-err" class="form-control form-group" value="<?php echo $r3['total']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="gre-date" data-error="lname-err" class="form-control form-group" value="<?php echo $r3['GREdate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subject']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectScore']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectDate']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject2" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subject2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject2-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectScore2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject2-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectDate2']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject:</label>
                                        <input disabled  type="text" id="input" name="subject3" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subject2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GRE Advanced Subject Score:</label>
                                        <input disabled  type="text" id="input" name="subject3-score" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectScore2']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="subject3-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['subjectDate2']; ?>" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">TOEFL Score:</label>
                                        <input disabled  type="text" id="input" name="toefl" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['TOEFLscore']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Date of Exam:</label>
                                        <input disabled  type="text" id="input" name="toefl-date" data-error="lname-err" class="form-control form-group"  value="<?php echo $r3['TOEFLdate']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Bachelors Degree</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fname">Degree Type:</label>
                                        <input disabled  type="text" id="input" name="bdegree-type" data-error="fname-err" class="form-control form-group" value="<?php echo $r5['BtypeDegree']; ?>"  >
                                    </div>
                                    <div class="col">
                                        <label for="minit">University:</label>
                                        <input disabled  type="text" id="input" name="buniv" data-error="minit-err" class="form-control form-group" value="<?php echo $r5['Buniversity']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Year:</label>
                                        <input disabled  type="text" id="input" name="byear" data-error="lname-err" class="form-control form-group" value="<?php echo $r5['ByearDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Major:</label>
                                        <input disabled  type="text" id="input" name="bmajor" data-error="lname-err" class="form-control form-group" value="<?php echo $r5['Bmajor']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GPA:</label>
                                        <input disabled  type="text" id="input" name="bgpa" data-error="lname-err" class="form-control form-group" value="<?php echo $r5['BGPA']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Masters Degree</h3>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Degree Type:</label>
                                        <input disabled  type="text" id="input" name="mdegree" data-error="lname-err" class="form-control form-group"  value="<?php echo $r5['MtypeDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Univerisity:</label>
                                        <input disabled  type="text" id="input" name="muniv" data-error="lname-err" class="form-control form-group"  value="<?php echo $r5['Muniversity']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Year:</label>
                                        <input disabled  type="text" id="input" name="myear" data-error="lname-err" class="form-control form-group"  value="<?php echo $r5['MyearDegree']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Major:</label>
                                        <input disabled  type="text" id="input" name="mmajor" data-error="lname-err" class="form-control form-group"  value="<?php echo $r5['Mmajor']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">GPA:</label>
                                        <input disabled  type="text" id="input" name="mgpa" data-error="lname-err" class="form-control form-group"  value="<?php echo $r5['MGPA']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Application Status</h3>
                                <div class="form-row">
                                    <!-- <div class="col"> -->
                                    <div class="col">                                        
                                        <label for="decisionStatus">Admission Decision Status:</label>
                                        <div name="typeUser" class="input-group mb-3">
                                            <?php if ($r4['decisionStatus'] == "Pending"){
                                                $decision = "Pending"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="0" selected><?php echo $decision ?></option>
                                                    <option value="1">Reject</option>
                                                    <option value="3">Admit without Aid</option>
                                                    <option value="4">Admit with Aid</option>
                                                </select>
                                            <?php }
                                            else if ($r4['decisionStatus'] == "Reject"){
                                                $decision = "Reject"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="1" selected><?php echo $decision ?></option>
                                                    <option value="3">Admit without Aid</option>
                                                    <option value="4">Admit with Aid</option>
                                                    <option value="0">Applicant</option>
                                                </select>
                                            <?php }
                                            else if ($r4['decisionStatus'] == "Admit without Aid"){
                                                $decision = "Admit without Aid"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="3" selected><?php echo $decision ?></option>
                                                    <option value="4">Admit with Aid</option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Reject</option>
                                                </select>
                                            <?php }
                                            else if ($r4['decisionStatus'] == "Admit with Aid"){
                                                $decision = "Admit with Aid"; ?>
                                                <select disabled class="custom-select" name="decisionStatus" id="decisionStatus">
                                                    <option value="4" selected><?php echo $decision ?></option>
                                                    <option value="0">Applicant</option>
                                                    <option value="1">Faculty Reviewer</option>
                                                    <option value="3">Admit without Aid</option>
                                                </select>
                                            <?php } ?>                                                    
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="lname">Application Submission Status:</label>
                                        <input disabled  type="text" id="input" name="submissionStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $r4['submissionStatus']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Recommendation Letter Status:</label>
                                        <input disabled  type="text" id="input" name="recStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $r4['recStatus']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Transcript Status:</label>
                                        <input disabled  type="text" id="input" name="transcriptStatus" data-error="lname-err" class="form-control form-group"  value="<?php echo $r4['transcriptStatus']; ?>" >
                                    </div>
                                </div>
                            </section>
                            <section>
                                <br><h3>Application Review</h3>
                                <h5>GAS Reviewer Ratings</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">GAS Rating:</label>
                                        <input disabled  type="text" id="input" name="GASrating" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['GASrating']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Comments:</label>
                                        <input disabled  type="text" id="input" name="comments" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['comments']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Courses:</label>
                                        <input disabled  type="text" id="input" name="courses" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['courses']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Reason:</label>
                                        <input disabled  type="text" id="input" name="reason" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['reason']; ?>" >
                                    </div>
                                </div>
                                <h5>Faculty Reviewer Ratings</h5>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="lname">Recommendation Letter Rating:</label>
                                        <input disabled  type="text" id="input" name="recRating" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['recRating']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Generic:</label>
                                        <input disabled  type="text" id="input" name="generic" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['generic']; ?>" >
                                    </div>
                                    <div class="col">
                                        <label for="lname">Credible:</label>
                                        <input disabled  type="text" id="input" name="credible" data-error="lname-err" class="form-control form-group"  value="<?php echo $r6['credible']; ?>" >
                                    </div>
                                </div><br>
                                <!-- <form action="" method="POST" id="current"> -->
                                    <input type="button" class="btn btn-info float-right" id="edit" name="edit" value="Edit Application"> 
                                    <input type="hidden" class="btn btn-info float-right" id="save" name="save" value="Save Changes">
                                    <input type="hidden" class="btn btn-dark float-left" id="cancel" name="cancel" value="Cancel" onclick="location.reload()">
                                    <input type="hidden" name="fname1" value="<?php echo $r['fname']?>">
                                    <input type="hidden" name="minit1" value="<?php echo $r['minit']?>">
                                    <input type="hidden" name="lname1" value="<?php echo $r['lname']?>">
                                    <input type="hidden" name="email1" value="<?php echo $r['email']?>">
                                    <input type="hidden" name="pass1" value="<?php echo $r['password']?>">
                                    <input type="hidden" name="type1" value="<?php echo $typeUser?>">
                                    <input type="hidden" name="address1" value="<?php echo $r['address']?>">
                                    <input type="hidden" name="decision1" value="<?php echo $r4['decisionStatus']?>">
                                </form>
                            </section>
                            <!-- <form action="" method="POST"> -->
                                
                            <!-- </form> -->
                        <!-- </form> -->
                        
                    </div>
                    <script>
                        console.log("in script 1");
                        
                            document.getElementById("edit").onclick = function () {
                                console.log("in update profile");
                                $('input[type=password]').attr('password', 'text'); 
                                // $('input').removeAttr('disabled');
                                $('input[name=fname]').removeAttr('disabled');
                                $('input[name=minit]').removeAttr('disabled');
                                $('input[name=lname]').removeAttr('disabled');
                                $('input[name=email]').removeAttr('disabled');
                                $('input[name=typeUser]').removeAttr('disabled');
                                $('input[name=password]').removeAttr('disabled');
                                $('input[name=address]').removeAttr('disabled');
                                $('select[name=typeUser]').removeAttr('disabled');

                                var v = document.getElementById("edit");
                                v.setAttribute('type','hidden');
                                var s = document.getElementById("save");
                                s.setAttribute('type','button');
                                var s = document.getElementById("cancel");
                                s.setAttribute('type','button');
                            }
                        //}
                            document.getElementById("save").onclick = function() { 
                                console.log("in save changes");
                                var f = document.getElementsByName("fname")[0].value;
                                console.log("fname: " + f);
                                var m = document.getElementsByName("minit")[0].value;
                                var l = document.getElementsByName("lname")[0].value;
                                var t = $("#inputGroupSelect option:selected").text()
                                var uid = document.getElementsByName("uid")[0].value;
                                var ogUID = document.getElementsByName("uid")[0].value;
                                var a = document.getElementsByName("address")[0].value;
                                var e = document.getElementsByName("email")[0].value;
                                var ssn = document.getElementsByName("ssn")[0].value;
                                var u = document.getElementsByName("username")[0].value;
                                var p = document.getElementsByName("password")[0].value;
                                var appDate = document.getElementsByName("appDate")[0].value;
                                var decision = $("#decisionStatus option:selected").text();

                                var validator = $("#current").validate({
                                    rules: {
                                        fname: {required:true, lettersonly:true, maxlength: 25},
                                        minit: {maxlength:1, lettersonly:true},
                                        lname: {required:true, lettersonly: true, maxlength:25},
                                        email: {email:true, required:true},
                                        address: {required:true, maxlength: 100},
                                        password: {required: true, maxlength:40},
                                        typeUser: {required: true},
                                        decision: {requied: true}
                                    },
                                    errorPlacement: function(error, element) {
                                        //Custom position: first name
                                        if (element.attr("name") == "fname" ) {
                                            // alert(error);
                                            $("span#fname-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "minit" ) {
                                            // alert(error);
                                            $("span#minit-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "lname" ) {
                                            // alert(error);
                                            $("span#lname-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "email" ) {
                                            // alert(error);
                                            $("span#email-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "address" ) {
                                            // alert(error);
                                            $("span#address-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "password" ) {
                                            // alert(error);
                                            $("span#password-err").text($(error).text());
                                        }
                                        if (element.attr("name") == "typeUser" ) {
                                            // alert(error);
                                            $("span#type-err").text($(error).text());
                                        }
                                    }
                                });
                                var validator2 = $("#pastapp").validate({
                                    rules: {
                                        fname: {required:true, lettersonly:true, maxlength: 25},
                                        minit: {maxlength:1, lettersonly:true},
                                        lname: {required:true, lettersonly: true, maxlength:25},
                                        email: {email:true, required:true},
                                        address: {required:true, maxlength: 100},
                                        password: {required: true, maxlength:40},
                                        typeUser: {required: true},
                                        decision: {requied: true}
                                    }
                                });
                                if ($('#current').valid() || $('#pastapp').valid()) {
                                    $.ajax({
                                        url: "./edit-app.php",
                                        type: 'POST',
                                        data: {fname:f, minit:m, lname:l, typeUser:t, uid:uid, address:a, email:e, ssn:ssn, username:u, password:p, ogUID:ogUID, decisionStatus:decision, appDate:appDate},                            
                                        success: function(data) {
                                            console.log("response: " + data);
                                            $('#current').submit()
                                            location.reload();
                                        }
                                    })
                                }
                            }
                    </script>
               <?php //}
            }
        }


    } ?>