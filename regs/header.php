<html>
<head>
	<?php echo '<title>Banweb - ' . $page_title . '</title>';?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <a class="navbar-brand js-scroll-trigger" href="#home"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" 
    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggle-icon"></span>
    </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div><br></div>
<?php 
// redirects to login page if not logged in
if(!(isset($_SESSION['typeUser']))) {
	header('Location: http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php');
}
echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../dashboard.php">Dashboard</a></li></ul>';
if($_SESSION['typeUser'] == 5) {
	//viewable pages for student
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/personalinfo.php">Personal Information</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/registration.php">Registration</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/schedule.php">Schedule</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/transcript.php">Transcript</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/courses.php">Course Catalog</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/sections.php">Sections</a></li></ul>';
	echo '<ul class="navbar-nav"><li class="nav-item navbar-right"><a style="color:white; class="nav-link navrbar-right" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/logout.php">Log out</a></li></ul>';
} else if ($_SESSION['typeUser'] == 6) {
	//viewable pages for faculty
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/personalinfo.php">Personal Information</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/advisee.php">Advisees</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/users.php">Users</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/classes.php">Classes</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/courses.php">Course Catalog</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/sections.php">Sections</a></li></ul>';
	echo '<ul class="navbar-nav"><li class="nav-item navbar-right"><a style="color:white; class="nav-link navrbar-right" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/logout.php">Log out</a></li></ul>';
} else if ($_SESSION['typeUser'] == 4) {
	//viewable pages for system admin
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/users.php">Users</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/courses.php">Course Catalog</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/sections.php">Sections</a></li></ul>';
	//echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/settings.php">Settings</a></li></ul>';
	echo '<ul class="navbar-nav"><li class="nav-item navbar-right"><a style="color:white; class="nav-link navrbar-right" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/logout.php">Log out</a></li></ul>';
} else if ($_SESSION['typeUser'] == 3) {
	//viewable pages for gradsec 
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/users.php">Users</a></li></ul>';
	//echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/reports.php">Reports</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/courses.php">Course Catalog</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/sections.php">Sections</a></li></ul>';
	echo '<ul class="navbar-nav"><li class="nav-item navbar-right"><a style="color:white; class="nav-link navrbar-right" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/logout.php">Log out</a></li></ul>';
} else if ($_SESSION['typeUser'] == 7) {
	//viewable pages for registrar
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/users.php">Users</a></li></ul>';
	echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/courses.php">Course Catalog</a></li></ul>';
        echo '<ul class="navbar-nav mr-auto"><li class="nav-item active"><a style="color:white; class="nav-link" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/sections.php">Sections</a></li></ul>';
        echo '<ul class="navbar-nav"><li class="nav-item navbar-right"><a style="color:white; class="nav-link navrbar-right" href="http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/logout.php">Log out</a></li></ul>';
}
?>

</div>
</nav> 
</body></html>
