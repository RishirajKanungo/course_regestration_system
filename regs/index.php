<?php
session_start();
$page_title = 'Home';
require_once('header.php');
require_once('../connectvars.php');
?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- STYLING LINKS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/scrolling-nav.css" rel="stylesheet">
    <link href="../css/jumbotron.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/signupValidate.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- JAVASCIPT AND JQUERY-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style>
	body, html {
		height:100%;
	}

	.bg {
		height:100%;

		background-position: center;
	 	background-repeat: no-repeat;
  		background-size: cover;
	}
    </style>

<?php
if(!(isset($_SESSION['typeUser']))) {
	header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/login.php');
}

?>
<head>
<link href="https://fonts.googleapis.com/css?family=Secular+One&display=swap" rel="stylesheet">
</head>
<div class="jumbotron jumbotron-fluid bg" id="jumbotron">
	<div class="top-left">Hello, Welcome to Registration!</div>
</div>          
