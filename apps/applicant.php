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
input[name=view]:hover {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=view] {
    background-color: #b8974f;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=edit]:hover {
    background-color: #cdc3a0;
    color:black;
    border: 0px;
    padding-top: 1%;
    padding-bottom: 1%;
    display: block;
    margin: auto;
}
input[name=edit] {
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
if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] != 0)) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = 'phase1/home.php';
            </script>
<?php } ?>

    <!-- Only display if there is not an active application -->
    <!-- Start Application button -->
    <?php 
        
        // Do not allow user to begin an application if they have already applied for all semesters
        $sql = ("SELECT appDate FROM history WHERE history.UID='$uid'"); 
        $sqlQuery = mysqli_query($dbc, $sql); 
        $numRows = mysqli_num_rows($sqlQuery); 

        $query = ("SELECT submissionStatus 
                   FROM app 
                   WHERE app.UID='$uid'"); 
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        $status = $row['submissionStatus']; 
        
        if ($numRows == 2) {
            echo "You have reached the maximum amount of applications for this application period."; 
        }
        else if ((strcmp($status, "In Progress") != 0) && (strcmp($status, "Submitted") != 0)) { ?> 
            <div class="card-body text-center" id="startApp" align="center">
            <!-- Start Application Button -->
            <input type="button" class="btn btn-light btn-lg" onclick="location.href='./phase1/app.php'" value="Start Application"/>
            </div>
    <?php } ?>
    
    <!-- Current Apps table -->
    <br><br><h3> Applications Pending Review </h3><br>
    <!-- <p>HELLO</p> -->
    <table>
    <tr>
            <th>Semester/Year</th>
            <th>Application Status</th>
            <th></th>
            <th>Transcript Status</th>
            <th>Recommendation Letter Status</th>
            <th>Decision</th>
    </tr>
    </table>
<?php
    // Query for current applications 
    $query = ("SELECT appDate, decisionStatus, submissionStatus, recStatus, transcriptStatus 
               FROM app, users 
               WHERE users.UID='$uid' AND users.UID=app.UID"); 
    $data = mysqli_query($dbc, $query);
    $numRows = mysqli_num_rows($data); 

    if ($numRows == 0){
        echo "<br>";
        echo "<h5>" . "You have no applications pending review at this time" . "</h5>";
    }

    $isSubmitted = 0;

    // Display current apps if there are any 
    while($row = mysqli_fetch_array($data)) {
            echo "<table border='1'>";
            echo "<tr>"; 
            echo "<td>" . $row['appDate'] . "</td>";
            echo "<td>" . $row['submissionStatus'] . "</td>";

            // display edit or view application buttons 
            if (strcmp($row['submissionStatus'], "Submitted") != 0) { ?> 
                <td>
                <form action='./phase1/app.php' method='post'>
                <!-- <button class='button'>Edit Application<type='submit' value='Edit Application' name='edit'></button> -->
                <input type='submit' class='btn btn-primary center-block' name='edit' value='Edit Application'/>
                </form></td>
            <?php 
            $isSubmitted = 0; } 
            else { ?>
                <td>
                <form action='./viewApplication.php' method='post'>
                <!-- <button class='button'>View Application<type='submit' value='View Application' name='view'></button> -->
                <input type='submit' class='btn btn-primary center-block' name='view' value='View Application'/>
                </form></td>
            <?php 
            $isSubmitted = 1;} 
            echo "<td>" . $row['transcriptStatus'] . "</td>";
            echo "<td>" . $row['recStatus'] . "</td>";
            if ($isSubmitted == 1){
                echo "<td>" . "Pending: Under Review" . "</td>";
            }
            else {
                echo "<td>" . "N/A" . "</td>";
            }
            echo "</tr>";
            echo "</table>"; 
    }
?>

    <!-- Past Apps table -->
    <br><br><br><h3> Application Decisions </h3><br>
    <table>
    <tr>
            <th>Semester/Year</th>
            <th>Decision</th>
            <?php if (strcmp($row['decisionStatus'], "Reject") != 0) { ?> 
            <th>Next Steps</th>
            <?php } ?>
    </tr>
    </table>

<?php
        // Query for past applications 
        $query = ("SELECT appDate, decisionStatus 
                   FROM history, users 
                   WHERE users.UID='$uid' AND users.UID=history.UID"); 
        $data = mysqli_query($dbc, $query);
        $numRows = mysqli_num_rows($data); 

        if ($numRows == 0){
            echo "<br>";
            echo "<h5>" . "You have no application decisions to view" . "</h5>";
        }

        // Display past apps if there are any 
        while($row = mysqli_fetch_array($data)) {
            echo "<table border='1'>";
            echo "<tr>"; 
            echo "<td>" . $row['appDate'] . "</td>";
            echo "<td>" . $row['decisionStatus'] . "</td>";
            if (strcmp($row['decisionStatus'], "Reject") != 0) { ?> 
                <td>
                <form action='viewOffer.php' method='post'>
                <button class='button'>View Your Offer<type='submit' value='View Offer' name='viewOffer'></button>
                </form></td>
            <?php 
            } 
            else { ?>
                <!-- <td>Do we want something here</td> -->
            <?php } ?>
            <?php 
            echo "</table>";
        }
?>   
</body>
</html>