<?php 
    // Start the session
    session_start();

    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    // Include navmenu 
    require_once('navMenus/navRevPortal.php'); 

    // Include db connection vars 
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title> Reviewer Portal </title>
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head> -->
<!DOCTYPE html>
<html>
<head>
    <title> Reviewer Portal </title>
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
        input[name=transcript]:hover {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[name=transcript] {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[name=setDecision]:hover {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
            display: block;
            margin: auto;
        }
        input[name=setDecision] {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
            display: block;
            margin: auto;
        }
   </style>
<body>    
<?php
    if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] == 4) || ($_SESSION['typeUser'] == 0)) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'public_html/dynamo/login.php';
            </script>
        <?php
    } ?>
    </br></br></br></br>
    <!-- Current Apps table -->
    <h3> Applicants </h3>
    <table>
    <tr>
            <th>Name</th>
            <th>Recommendation Letter Status</th>
            <th>Transcript Status</th>
            <th></th>
    </tr>
    </table>
<?php
    if($typeUser == 1 || $typeUser == 2 || $typeUser == 6){
    // Query for current applications to review
    // $query = "SELECT DISTINCT fname, lname, decisionStatus, recStatus, transcriptStatus, users.UID
    //            FROM app, users 
    //            WHERE app.submissionStatus='Submitted' AND users.typeUser = 0"; 
    $query = ("SELECT users.fname, users.minit, users.lname, users.UID, app.recStatus, app.transcriptStatus FROM users, app WHERE app.UID=users.UID AND app.submissionStatus='Submitted' AND '$uid' NOT IN (SELECT ratings.reviewerUID FROM ratings WHERE ratings.UID = users.UID)");
    $data = mysqli_query($dbc, $query)
        or die("Error: " .mysqli_error($dbc));


    // Display current apps if there are any 
    while($row = mysqli_fetch_array($data)) {
        ?> 
        
    <?php
            $applicant = $row['UID'];
            echo "<table border='1'>";
            echo "<tr>"; 
            echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
            // echo "<td>" . $row['transcriptStatus'] . "</td>";
            echo "<td>" . $row['recStatus'] . "</td>";
            echo "<td>" . $row['transcriptStatus'] . "</td>";

    ?> 
        <?php
            if($row['transcriptStatus'] == 'Received' && $row['recStatus'] == 'Received'){
            ?>
                <td>
                    <form method='post' action=reviewApplication.php>
                        <button class='button'>View Application<type='submit'></button>
                        <input type="hidden" name="applicant" value="<?php echo $applicant?>">
                    </form>
                </td>

                <?php
                echo "</tr>";
                echo "</table>"; 
            }
            else{?>
                <td>

                </td>
            <?php
            }
        }
    }

    /* if the user is a Grad Secretary */ 

    if($typeUser == 3){
    // Query for current applications to review
    // $query = "SELECT DISTINCT fname, lname, decisionStatus, recStatus, transcriptStatus, users.UID
    //            FROM app, users 
    //            WHERE app.submissionStatus='Submitted' AND users.typeUser = 0"; 
    $query = ("SELECT users.fname, users.minit, users.lname, users.UID, app.recStatus, app.transcriptStatus FROM users, app WHERE app.UID=users.UID AND app.submissionStatus='Submitted'");
    $data = mysqli_query($dbc, $query)
        or die("Error: " .mysqli_error($dbc));
    

    // Display current apps if there are any 
    while($row = mysqli_fetch_array($data)) {
        ?> 
        
    <?php
             $applicant = $row['UID'];
             echo "<table border='1'>";
             echo "<tr>"; 
             echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
             echo "<td>" . $row['recStatus'] . "</td>"; ?>
             <td>
                <form method="post">
                    <select name="tstatus" id="">
                    <?php
                        if(strcmp($row['transcriptStatus'], "Not Received") ==  0){?>
                            <option value="Not Received" selected>Not Received</option>
                            <option value="Received" >Received</option>
                        <?php }
                        elseif(strcmp($row['transcriptStatus'], "Received") ==  0){?>
                            <option value="Received" selected>Received</option>
                            <option value="Not Received">Not Received</option>
                        <?php }
                        else { ?>
                            <option value="Not Received">Not Received</option>
                            <option value="Received">Received</option>
                        <?php }
                        ?>                    
                    </select> 
                    <input type="submit" class="btn btn-primary center-block" name="transcript" value="Update"/>
                    <input type="hidden" name="applicationID" value="<?php echo $applicant?>">
                </form>
             </td>

             <td>
                <form method='post' action=reviewApplication.php>
                    <input type="submit" class="btn btn-primary center-block" name="setDecision" value="View Applicant Data"/>
                    <input type="hidden" name="applicant" value="<?php echo $applicant?>">
                    <input type="hidden" name="permission" value=0>
                </form>
            </td>

            <?php
            echo "</tr>";
            echo "</table>"; 
            ?>

<!--         <form method='post' action=reviewApplication.php>
                    <input type="submit" class="btn btn-primary center-block" name="setDecision" value="Render Applicant Decision"/>
                    <input type="hidden" name="applicant" value="<?php echo $applicant?>">
                    <input type="hidden" name="permission" value=1>
        </form> -->
        <?php 
    }
}

    ?>
    </div>
    <?php
    
?>
 
</body>
</html>

<!-- If the button is clicked -->
<?php
if(isset($_POST['transcript'])){
    $transcript = $_POST['tstatus'];
    $applicantUniversityID = $_POST['applicationID'];

    //echo "Updating transcript status of " . $applicantUniversityID . " to " . $transcript;            
    $query = "UPDATE app SET transcriptStatus = '$transcript' WHERE app.UID='$applicantUniversityID'";
    $data = mysqli_query($dbc, $query);
    $page = $_SERVER['PHP_SELF'];
    echo '<meta http-equiv="Refresh" content="0;' . $page . '">';
}

?>


   
