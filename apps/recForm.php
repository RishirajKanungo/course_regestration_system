<?php 
    // Start the session
    session_start();

    // Get hidden posted UID of applicant we are submitting for
    if (isset($_POST['UID'])) {
      $uid = $_POST['UID']; 
      //echo $uid;
    } 

    // Set email of logged in user session var
    $email = $_SESSION['email'];

    // Include navmenu 
    require_once('navMenus/navRecFormPortal.php'); 

    // Include connections vars 
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html>
<body>
<?php 
    if (!isset($_SESSION['email'])) {
        ?>
            <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
            window.location.href = './phase1/home.php';
            </script>
        <?php
    }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
   <script src="./phase1/js/validLetter.js"></script>
</head>
<style>
  .btn-lg:hover {
    background-color: #b8974f;
    color:black;
  }
  .btn-lg {
    background-color: #cdc3a0;
    color:black;
  }
  .error{
    color:#ac2424;
    font-size: 16px;
    font-style:italics;
  }
</style>
<?php
$query = ("SELECT recLetter 
               FROM app 
               WHERE app.UID='$uid'"); 
$data = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($data);
?>
 <div class="container" style="align:center;">
<div class="fuild-container content-center" style="padding-left:3%;padding-right:3%; align:center;">
<br><br>
<h2> Recommendation Letter Submission</h2>

<!-- File upload of letter -->
<!-- <h6 style="font-style:italic"> <a href=#upload> Upload a File </a> or <a href=#textbox> Submit letter manually </a> </h6><br><br> -->
<!-- <h3 id = "upload"> Upload File </h3>
<h6 style="font-style:italic">Files must be type: </h6> -->

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select File to Upload:
    <input type="file" class="btn-lg btn-light float-left" name="file">
    <input type="submit" name="submit" class="btn-lg btn-light float-left" value="Upload">
    <input type="hidden" name="UID" value="<?php echo $uid?>">
</form>
<br><br>

<!-- Textbox submission of letter -->
<h3 id = "textbox"> Manual Submission </h3>
<h6 style="font-style:italic"> Letters must be between 50-2500 characters </h6>
</br>
  <form action ='' method='post' id='letter' name='letter'>
          <textarea class="form-control" name="recLetter" charset="utf-8" id="recLetter" style="height:400px; Width:100%; line-height: 25px;" placeholder="Input Recommendation.." onkeyup="countChars(this)"> <?php echo $row['recLetter']?> </textarea>
          
          <h6 id="wordCount">0 words</h6>
          <h6 id="charCount">0 characters (with spaces)</h6>
          <h6 id="charCountWithOutSpaces">0 characters (Without Spaces)</h6>
        
          <!-- live word and character count  -->
          <script> 
          function countChars() {
            var val = document.getElementById("recLetter").value;
            var withSpace = val.length;
            var wordsCount = val.match(/\S+/g).length;
            var charWithOutSpace = val.replace(/\s+/g, '').length;
    
            document.getElementById("wordCount").innerHTML = wordsCount + ' words';
            document.getElementById("charCount").innerHTML =  withSpace + ' characters (with spaces)';
            document.getElementById("charCountWithOutSpaces").innerHTML = charWithOutSpace + ' characters (without spaces)';
          } </script>

          <br>
          <!-- Save button -->
          <input type='submit' class="btn-lg btn-light float-left" value="Save Letter" name='save'>
          <input type="hidden" name="UID" value="<?php echo $uid?>">

          <!-- Submit button -->
          <input type='submit' class="btn-lg btn-light float-right" id="submitLetter" value="Submit Letter" name="submitLetter" onclick="(this).validate()">
          <input type="hidden" name="UID" value="<?php echo $uid?>"> 
  </form> 
</div>
</div>
</br></br>
<!-- if user saves manually -->
<?php 
  // save letter 
  if (isset($_POST['save'])) {    
    // get text
    $uid = $_POST['UID'];
  
    $recLetter = "";
    $recLetter = $_POST["recLetter"];
    
    // if changes were made 
    if ($recLetter != ""){
      $query = "INSERT INTO letters (UID, recLetter) VALUES ('$uid', '$recLetter')";
      mysqli_query($dbc, $query); 
    }
?>
<!-- // Redirect to saved confirmation page  -->
<script type="text/javascript">
    window.location.href = 'savedLetter.php';
</script>

<!-- if user submits manually -->
<?php }
  // submit letter 
  if (isset($_POST['submitLetter'])) {    
    // get text
    $uid = $_POST['UID'];
  
    $recLetter = "";
    $recLetter = $_POST["recLetter"];
    
    // if changes were made 
    if ($recLetter != ""){
      $query = "INSERT INTO letters (UID, recLetter) VALUES ('$uid', '$recLetter')";
      mysqli_query($dbc, $query); 
    }

    // update submission status 
    $query = "UPDATE app SET recStatus='Received', recLetter='$recLetter' WHERE app.UID='$uid'";
    mysqli_query($dbc, $query);

?>
<!-- // Redirect to submitted confirmation page  -->
<script type="text/javascript">
    window.location.href = 'submittedLetter.php';
</script>
<?php }
?>

<!-- if user uploads file -->
<?php 
  // submit letter 
  //if (isset($_POST['submit'])) {    
    // get text
    //$uid = $_POST['UID'];
    
?>
<!-- // Redirect to submitted confirmation page  -->
<!-- <script type="text/javascript">
    window.location.href = 'submittedLetter.php';
</script> -->

</body>
</html>