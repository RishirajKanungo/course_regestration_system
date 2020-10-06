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

    $uid = $_POST['UID'];
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
    <script src="search.js"></script>
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
    $statusMsg = '';

    // File upload path
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if(!empty($_FILES["file"]["name"])){
        $uid = $_POST['UID'];
        // Allow certain file formats
        $allowTypes = array('docx','doc','txt','pdf');
        if(in_array($fileType, $allowTypes)){
        // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                $query = "INSERT INTO uploads (UID, fileName) VALUES ('$uid','".$fileName."')";
                if(mysqli_query($dbc, $query)){
                    echo "<h4> Your letter was submitted! </h4>";
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                    $query = "UPDATE app SET recStatus='Received' WHERE app.UID='$uid'";
                    mysqli_query($dbc, $query); 
                }
                else{
                    $statusMsg = "File upload failed, please try again.";
                } 
            }
            else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }
        else{
            $statusMsg = 'Sorry, only DOC, DOCS, TXT, & PDF files are allowed to upload.';
        }
    }
    else{
        $statusMsg = 'Please select a file to upload.';
    }

// Display status message
echo $statusMsg;
?>

