<!DOCTYPE html> 
<head>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-lg fixed-top bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbar-responsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="navbtn" href="/dynamo/apps/reviewApplication.php">
                        <!-- Link to User Dashboard -->
                        <a href="/~sp20DBp2-dynamo/dynamo/apps/reviewer.php"><input type="submit" id="navbutton"class="btn btn-outline-light" value="Dashboard"><br /></a>
                    </li>
                    <div><br/></div>
                    <li class="nav-item" id="navbtn" >
                        <!-- Link to Log Out -->
                        <a href="/~sp20DBp2-dynamo/dynamo/apps/phase1/logout.php"><input type="submit" id="navbutton" value="Log Out" class="btn btn-outline-light"/><br/></a>
                    </li>
                </ul>
            </div>
             <!-- Search bar -->
             <div class="topnav">
                <div class="search-container">
                    <form action="revSearch.php" method="post">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit"><i class="btn btn-outline-light"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div><br></div>
</head>

