<!DOCTYPE html> 
<head>
    <title>View Applicant History</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <link href="./css/sysad.css" rel="stylesheet">
    <!-- <script src="js/sysupdates.php"></script> -->
    <script src="js/sysad.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
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
        // echo $_SESSION['uid'];

        if (isset($_POST['oguid-all'])) {
            $uid = $_POST['oguid-all'];
        }
            // GET ALL HISTORY
            $q = "SELECT * FROM users WHERE UID = $uid;";
            $d = mysqli_query($dbc, $q);
            $r = mysqli_fetch_array($d);
            if (!$d){
                ?>
                    <script>
                        console.log("error running query 0");
                    </script>
                <?php
            } ?>
        <div class="container">
            <div>
                <h4><br>User Information <br></h4>
                <br>
                <table id="history" class="table fluid-container" style="width:500px;"> 
                        <tr>
                            <th>Applicant Name</th>
                            <td><?php echo $r['fname']?> <?php echo $r['minit']?> <?php echo $r['lname']?></td>
                        </tr>
                        <tr>
                            <th>UID</th>
                            <td><?php echo $r['UID']?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo $r['username']?></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><?php echo $r['password']?></td>
                        </tr>
                        <tr>
                            <th>Email Address</th>
                            <td><?php echo $r['email']?></td>
                        </tr>
                        <tr>
                            <th>SSN</th>
                            <td><?php echo $r['ssn']?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo $r['address']?></td>
                        </tr>
                </table>
            </div>
        </div>   

            <?php
            $q2 = "SELECT users.UID, appDate, degree, submissionStatus FROM users JOIN app ON users.UID = app.UID WHERE users.UID=$uid;";
            $d2 = mysqli_query($dbc, $q2);
            // echo mysqli_error($d2);
            if (!$d2){
                ?>
                    <script>
                        console.log("error running query 2");
                    </script>
                <?php
            } ?>

        <div class="container">    
            <h4><br> Current Applications</h4><br>
            <?php if (mysqli_num_rows($d2) > 0) { ?>
                <div><br /></div>
                    <div class="table-responsive">
                        <table id="history" class="table fluid-container text-center justify-content-center"> 
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Application Date</th>
                                    <th scope="col">Program/Degree</th>
                                    <th scope="col">Application Status</th>
                                    <th scope="col">More Information</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($data = mysqli_fetch_array($d2)) { ?>
                                <tr id="<?php echo $data['UID'] ?>">
                                    <td name="date" data-target="lname-edit"><?php echo $data['appDate'];?></td>
                                    <td name="degree" data-target="lname-edit"><?php echo $data['degree'];?></td>
                                    <td name="submission" data-target="fname-edit"><?php echo $data['submissionStatus'];?></td>
                                    <td>
                                        <form method="POST" action="./fullApps.php">
                                            <input type="submit" name="user-app-btn" value="View Details" id="curr-apps" class="btn btn-outline-dark" data-id="<?php echo $data['UID']; ?>">
                                            <input type="hidden" name="app-uid" value="<?php echo $data['UID'];?>"/>
                                            <input type="hidden" name="date" value="<?php echo $data['appDate'];?>"/>
                                            <input type="hidden" name="submission" value="<?php echo $data['submissionStatus'];?>"/>
                                        </form>
                                    </td>
                                </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                    </div>
            <?php } 
                else { ?>
                    <h6>This applicant has no open applications.</h6>
            <?php  } 

            // GET PAST APPLICATIONS
            $q1 = "SELECT users.UID, appDate, degree, decisionStatus FROM history JOIN users ON history.UID = users.UID WHERE users.UID = $uid;";
            $d1 = mysqli_query($dbc, $q1);
            // echo mysqli_error($d1);
            if (!$d1){
                ?>
                    <script>
                        console.log("error running query 1");
                    </script>
                <?php
            } ?>
        </div>
        <div class="container">
            <h4><br> Past Applications</h4><br>
            <?php if (mysqli_num_rows($d1) > 0) { ?>
                <div><br /></div>
                    <div id="history" class="table-responsive" >
                        <table class="table fluid-container text-center justify-content-center"> 
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Application Date</th>
                                    <th scope="col">Program/Degree</th>
                                    <th scope="col">Decision Status</th>
                                    <th scope="col">More Information</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($rows = mysqli_fetch_array($d1)) { ?>
                                <tr id="<?php echo $rows['UID'] ?>">
                                    
                                        <td name="date" data-target="lname-edit"><?php echo $rows['appDate'];?></td>
                                        <td name="degree" data-target="lname-edit"><?php echo $rows['degree'];?></td>
                                        <td name="decision" data-target="lname-edit"><?php echo $rows['decisionStatus'];?></td>
                                        <td>
                                            <form method="POST" action="./fullApps.php">                                                
                                                <input type="submit" name="user-app-btn" value="View Details" id="past-apps" class="btn btn-outline-dark" data-id="<?php echo $rows['UID']; ?>">
                                                <input type="hidden" name="app-uid" value="<?php echo $rows['UID'];?>"/>
                                                <input type="hidden" name="date" value="<?php echo $rows['appDate'];?>"/>
                                                <input type="hidden" name="decision" value="<?php echo $rows['decisionStatus'];?>"/>
                                            </form>
                                        </td>
                                    <!-- </form> -->
                                </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                    </div>
            <?php } else { ?>
                    <h6>This applicant has no past applications.</h6><br>
            <?php } ?>
        </div>


        <?php //} ?>

            

    <!-- LAST closing tag to END giant ELSE -->
    <?php }
?>