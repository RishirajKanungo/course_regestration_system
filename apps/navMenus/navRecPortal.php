<!DOCTYPE html> 
<head>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.topnav a.active {
  background-color: #2196F3;
  color: white;
}

.topnav .search-container {
  float: right;
  margin-left: 50px;
  margin-right: 10px;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}

.topnav .search-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 0px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}
.topnav .search-container button:hover {
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .topnav .search-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .search-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
</style>

    <nav class="navbar navbar-expand-lg fixed-top bg-dark">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbar-responsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="navbtn" href="../clout_computing/recommender.php">
                        <!-- Link to User Dashboard -->
                        <a href="../clout_computing/recommender.php"><input type="submit" id="navbutton"class="btn btn-outline-light" value="Dashboard"><br /></a>
                    </li>
                    <div><br/></div>
                    <li class="nav-item" id="navbtn" >
                        <!-- Link to Log Out -->
                        <a href="./phase1/logout.php"><input type="submit" id="navbutton" value="Log Out" class="btn btn-outline-light"/><br/></a>
                    </li>
                </ul>
            </div>
            <!-- Search bar -->
            <div class="topnav">
                <div class="search-container">
                    <form action="../clout_computing/recSearch.php" method="post">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div><br></div>
</head>
</html>

