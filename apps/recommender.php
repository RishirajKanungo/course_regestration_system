
<?php 
    // Start the session
    session_start();

    // Set email of logged in user session var
    $email = $_SESSION['email'];

    // Include navmenu 
    require_once('navMenus/navRecPortal.php'); 

    // Include connection vars  
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html> 
<head>
    <title>Recommender</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="phase1/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <!-- <script src="search.js"></script> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</head>
<body>

<!-- </section> -->
    <div>
        <br />
        <br />
        <br />
        <br />
    </div>
    

<?php 
    if (!isset($_SESSION['email'])) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = './phase1/home.php';
            </script>
        <?php
    }
?>
    <!-- Current Letter Requests table -->
    <h3> Current Recommendation Letter Requests </h3>
    <table>
    <tr>
            <th>Requesting Applicant</th>
            <th>Status</th>
            <th></th>
    </tr>
    </table>
<?php
    $query = ("SELECT users.fname, users.minit, users.lname, users.UID
               FROM users, app
               WHERE app.recEmail='$email' AND app.UID=users.UID AND app.recStatus='Not Received'"); 
    $data = mysqli_query($dbc, $query);

    // Display current requests if there are any 
    while($row = mysqli_fetch_array($data)) {
        echo "<table border='1'>";
        echo "<tr>"; 
        echo "<td>" . $row['fname'] . " " . $row['minit'] . " " . $row['lname'] . "</td>";
        echo "<td>" . "In Progress" . "</td>"; 
        echo "<td>
        <form action='recForm.php' method='post'>
        <button class='button'>Submit Letter<type='submit' value='Submit Letter' name='subLetter'></button>
        <input type='hidden' value='{$row['UID']}' name='UID'>
        </form></td>";
        echo "</tr>";
        echo "</table>"; 
    }
?> </br></br></br>
    <h3> Past Recommendation Letter Submisisons </h3>
    <table>
    <tr>
            <th>Applicant</th>
            <th>Application Date</th>
            <th>Status</th>
    </tr>
    </table>

    <?php
    $query = ("SELECT users.fname, users.minit, users.lname, app.appDate
               FROM users, app
               WHERE app.recEmail='$email' AND app.UID=users.UID AND app.recStatus='Received'"); 
    $data = mysqli_query($dbc, $query);
    
    // Display past requests if there are any in app table
    while($row = mysqli_fetch_array($data)) {
        echo "<table border='1'>";
        echo "<tr>"; 
        echo "<td>" . $row['fname'] . " " . $row['minit'] . " " . $row['lname'] . "</td>";
        echo "<td>" . $row['appDate'] . "</td>";
        echo "<td>" . "Completed" . "</td>";
        echo "</tr>";
        echo "</table>"; 
    }

    $query = ("SELECT users.fname, users.minit, users.lname, history.appDate
               FROM users, history
               WHERE history.recEmail='$email' AND history.UID=users.UID"); 
    $data = mysqli_query($dbc, $query);
    
    // Display past requests if there are any in history table  
    while($row = mysqli_fetch_array($data)) {
        echo "<table border='1'>";
        echo "<tr>"; 
        echo "<td>" . $row['fname'] . " " . $row['minit'] . " " . $row['lname'] . "</td>";
        echo "<td>" . $row['appDate'] . "</td>";
        echo "<td>" . "Completed" . "</td>";
        echo "</tr>";
        echo "</table>"; 
    }
    ?>
</body>
</html>