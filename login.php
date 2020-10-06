<?php 
    //start the session
    session_start();
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $host = DB_HOST;
    $dbuser = DB_USER;
    $dbpass = DB_PASSWORD;
    $dbname = DB_NAME;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- STYLING LINKS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/scrolling-nav.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signupValidate.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- JAVASCIPT AND JQUERY-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <!-- CHANGE NAVBAR ON SCROLL-->
    <style>
        nav {
            background:transparent !important;
        }
        nav.scrolled {
            background:#fff !important;

            transition: background 200ms linear;
        }
        button#navbtn.scrolled {
            border-color: #130d07;
            color: #130d07;
        }
        button#navbtn.scrolled:hover {
            border-color: #130d07;
            color: #130d07;
            background-color: ;
        }
    </style>
</head>

<body id="top-of-content">

    <!-- Navigation / Navbar Scrolling -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" 
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggle-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-responsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#signup">Create an Account</a> -->
                        <form method="POST">
                        <button type="submit" class="btn btn-outline-light" name="reset" id="navbtn">Reset</button>
                        </form>
                        <?php
                            if (isset($_POST['reset'])) {
                                $script_path = '/home/ead/sp20DBp2-dynamo/public_html/dynamo/';
                                $command = "mysql --user={$dbuser} --password='{$dbpass}' " . "-h {$host} -D {$dbname} < {$script_path}";
                                $output = shell_exec($command . 'dynamo.sql');
                            }         
                        ?>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#signup">Create an Account</a> -->
                        <a href="#signups"><button class="btn btn-outline-light" id="navbtn">Create an Account</button> <br /></a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="#login">Log In</a> -->
                        <a href="#logins"><button class="btn btn-outline-light" id="navbtn">Log In</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- JUMBOTRON -->
    <div class="jumbotron jumbotron-fluid" id ="jumbotron">
        <div class="container">
            <h1 class="display-4">START YOUR JOURNEY WITH US TODAY.</h1>
            <!-- <h2 class="lead">Buy groceries that are fresh.</h2> -->
        </div>
        <div class="card-body text-center" id="applybtn" align="center">
            <!-- Apply Button -->
            <a href="#logins"><button class="btn btn-light btn-lg">Apply</button> <br /></a>
        </div>
    </div>
    <!-- SIGN UP FORM  -->
    <div class="fluid-container text-center" id="signups">
        <div id = "signups" class="row">
            <div class="col-12 col-md-8 text-center" id="signup-text">
                <h2 class="sign" style=" text-align: center; color:#cdc3a0">CREATE YOUR ACCOUNT</h2>
                <a href=#logins><p style="color:#cdc3a0; font-size:14px;">Already have an account? Click here to log in.</p></a>
                <!-- </section> -->
                <div><br /></div>
                <div class="container-fluid" id="container-form">
                    <form method="post" id="signup-form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <input type="text" id="fname" name="fname" data-error="fname-err" class="form-control form-group" placeholder="First Name *" minlength="1" maxlength="50" value="<?php if (!empty($user_fname)) echo $user_fname; ?>"  >
                                <p class="reqs">
                                    Only contains letters<br/>
                                    No more than 50 characters
                                </p>
                                <span id="fname-err"></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="input" name="minit" data-error="minit-err" class="form-control form-group" placeholder="M." minlength="0" maxlength="1" value="<?php if (!empty($user_minit)) echo $user_minit; ?>" >
                                <p class="reqs">Only 1 character</p>
                                <span id="minit-err"></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="input" name="lname" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php if (!empty($user_lname)) echo $user_lname; ?>" >
                                <p class="reqs">
                                    Only contains letters<br/>
                                    No more than 50 characters
                                </p>
                                <span id="lname-err"></span>
                            </div>
                        </div>
                        <div class="form-row justify-content-center"> 
                            <div class="col-6 align-self-center">
                                <input type="password" id="input" name="ssn"data-error="ssn-err" class="form-control form-group" placeholder="SSN *" maxlength=9 value="<?php if (!empty($ssn)) echo $user_ssn; ?>" >
                                <p class="reqs">9 Digit SSN <br /> Do not include dashes</p>
                                <span id="ssn-err"></span>

                                <input type="text" id="input" name="address" data-error="address-err" class="form-control form-group" placeholder="Address *" minlength="1" maxlength="100" value="<?php if (!empty($user_address)) echo $user_address; ?>"  >
                                <p class="reqs">Please enter your permanent home address</p>
                                <span id="address-err"></span>

                                <input type="text" id="input" name="email" data-error="email-err" class="form-control form-group" placeholder="Email Address *" maxlength="62" value="<?php if (!empty($user_email)) echo $user_email; ?>" >
                                <p class="reqs">Example: jappleseed@gmail.com</p>
                                <span id="email-err"></span>

                                <input type="text" id="input" name="username" data-error="user-err" class="form-control form-group" placeholder="Username *"  minlength="1" maxlength="20" value="<?php if (!empty($user_user)) echo $user_user; ?>">
                                <p class="reqs">May contain letters and numbers <br/> No more than 20 characters</p>
                                <span id="user-err"></span>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-3 col-sm-6 ">
                                <input type="password" id="password" name="password" data-error="pass-err" class="form-control form-group" placeholder="Password *"  minlength="1" maxlength="40" value="<?php if (!empty($user_pass)) echo $user_pass; ?>" >
                                <p class="reqs">No more than 40 characters</p>
                                <span id="pass-err"></span>
                            </div>
                            <div class="col-md-3 col-sm-6 ">
                                <input type="password" id="input" name="cpass" data-error="cpass-err" class="form-control form-group" placeholder="Confirm Password *"  minlength="1" maxlength="40" value="<?php if (!empty($user_cpass)) echo $user_cpass; ?>" >
                                <p class="reqs">No more than 40 characters <br/> Passwords must match</p>
                                <span id="cpass-err"></span>
                            </div>
                        </div>
                        <div><br /></div> 
                        <div class="form-row justify-content-center">
                            <input type="submit" class="btn btn-outline-light btn-lg" align="center" value="    Sign Up    " id="submit-log" name="submit-log"/>
                        </div>    
                    </form>
                </div>
            </div> 
            <!-- IMAGE -->
            <div class="col-6 col-md-4 justify-center-content"  style="padding-top: 1%; vertical-align:center;" id="img-signup">
                <div><br/></div>
                <img class="img-fluid" src="./images/accs.jpg">
            </div>
        </div>
    </div>

    <!-- LOG IN -->
    <div class="fluid-container text-center" id="logins">
        <section>
            <h2 id="already">ALREADY HAVE AN ACCOUNT?</h2>
            <h4 id="signs">SIGN IN</h4>
            <div class="container">
                <form id="login-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div> <br /> </div>
                    <div class="form-row justify-content-center">
                        <div class="col-sm-4">
                            <input type="text" name="user" id="input-login" data-error="username-err" class="form-control" placeholder="Username *" value="<?php if (!empty($user_username)) { echo $user_username; }?>" >
                            <p class="reqs" style="font-style:italic; text-align: left; padding-left: 5%; font-size:13px; color:#13070d">Please enter your account username</p>
                            <span id="username-err"></span>
                        </div>
                    </div>
                    <div> <br /> </div>
                    <div class="form-row justify-content-center">
                        <div class="col-sm-4">
                            <input type="password" name="pass" id="input-login" data-error="password-err" class="form-control" placeholder="Password *" value="<?php if (!empty($user_password)){ echo $user_password;}?>">
                            <p class="reqs" style="font-style:italic; text-align: left; padding-left: 5%; font-size:13px; color:#13070d">Please enter the corresponding password</p>
                            <span id="password-err"></span>
                        </div>
                    </div>
                    <div> <br /> </div>
                    <div class="form-row justify-content-center"> 
                        <a href=#signups><p style=" font-size:14px; color:#13070d;">Don't have an account? Click here to sign up.</p><a>
                    </div>
                    <div class="form-row justify-content-center">
                            <input type="submit" id="login-log" class="btn btn-outline-dark btn-lg" align="center" value="    Log In    "  name="login-log"/>
                    </div> 
                </form>
            </div>
        </section>
    </div>
</body>

<?php
require_once('connectvars.php');

// HANDLING LOGINS 
if (isset($_POST['login-log'])) {
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Grab the user-entered log-in data
    $user_username = mysqli_real_escape_string($dbc, trim($_POST['user']));
    $user_password = mysqli_real_escape_string($dbc, trim($_POST['pass']));
  
    // if both user and pass fields are filled out
    if (!empty($user_username) && !empty($user_password)) {
      // Look up and verify the username and password in the database
        $query = "SELECT uid, typeUser, password 
                    FROM users 
                    WHERE username = '$user_username' AND password = '$user_password';";
        $data = mysqli_query($dbc, $query);

        // query for recommender account
        $rec_query = "SELECT email, password
                      FROM recommenders
                      WHERE email = '$user_username' AND password = '$user_password';";
        $rec_data = mysqli_query($dbc, $rec_query);
        
        // If The log-in is OK 
        if ($data || $rec_data) {
            // if the login corresponds to a non-recommender
            if (mysqli_num_rows($data) != 0) {
                echo 'data found';

                $found = mysqli_fetch_array($data);
        
                //set the username and uid session vars
                $_SESSION['typeUser'] = $found[1];
                $_SESSION['uid'] = $found[0];
        
                // IF USER IS AN APPLICANT
                if ($_SESSION['typeUser'] == 0) {
                ?>
                    <script type="text/javascript">
                    window.location.href = 'dashboard.php';
                    </script>
                <?php
                }
                // IF USER IS A FACULTY REVIEWER
                if ($_SESSION['typeUser'] == 1) {
                ?>
                    <script type="text/javascript">
                    window.location.href = 'dashboard.php';
                    </script>
                <?php
                }

                // IF USER IS A CHAIR
                if ($_SESSION['typeUser'] == 2) {
                ?>
                    <script type="text/javascript">
                    window.location.href = 'dashboard.php';
                    </script>
                <?php
                }

                // IF USER IS A GRAD SECRETARY 
                if ($_SESSION['typeUser'] == 3) {
                ?>
                    <script type="text/javascript">
                    window.location.href = 'dashboard.php';
                    </script>
                <?php
                }

                // IF USER IS A SYS ADMIN
                if ($_SESSION['typeUser'] == 4) {
                ?>
                    <script type="text/javascript">
                    window.location.href = 'dashboard.php';
                    </script>
                <?php
                }

                // IF USER IS A STUDENT
                if ($_SESSION['typeUser'] == 5) {
                    ?>
                        <script type="text/javascript">
                        window.location.href = 'dashboard.php';
                        </script>
                    <?php
                    }
                if ($_SESSION['typeUser'] == 6) {
                    ?>
                        <script type="text/javascript">
                        window.location.href = 'dashboard.php';
                        </script>
                    <?php
                    }
                if ($_SESSION['typeUser'] == 7) {
                    ?>
                        <script type="text/javascript">
                        window.location.href = 'dashboard.php';
                        </script>
                    <?php
                    }
            }
            // if the login corresponds to a recommender 
            else if (mysqli_num_rows($rec_data) != 0) {
                $rec_found = mysqli_fetch_array($rec_data);
                $_SESSION['email'] = $rec_found[0];
                ?>
                    <script type="text/javascript">
                    window.location.href = 'apps/recommender.php';
                    </script>
                <?php
            }
            else { ?>
                <script type="text/javascript"> alert("Sorry, you must enter a valid username and password to log in")</script>
            <?php }
        }
    }
}

// HANDLING SINGUPS
if (isset($_POST['submit-log'])) {
    // check if user already exist 

    $user_ssn = mysqli_real_escape_string($dbc, trim($_POST['ssn']));
    $user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $user_user = mysqli_real_escape_string($dbc, trim($_POST['username']));

    $q1 = "SELECT ssn, email, username
           FROM users
           WHERE ssn = '$user_ssn' OR email = '$user_email' OR username = '$user_user';";
    $d1 = mysqli_query($dbc, $q1);

    // check if username is taken, but user does not exist
    $q2 = "SELECT username
           FROM users
           WHERE username = '$user_user';";
    $d2 = mysqli_query($dbc, $q2);

    // if user already exists
    if (mysqli_num_rows($d1) != 0) {
        ?>
            <script type="text/javascript"> alert("A user with these credentials already exists. If you already have an accout please log in below.")</script>
        <?php
    }
    // if username taken
    if (mysqli_num_rows($d2) != 0) {
        ?>
            <script type="text/javascript"> alert("This username is taken. Please choose another.")</script>
        <?php
    }

    // if user doesnt exist
    else if (mysqli_num_rows($d1) == 0 && mysqli_num_rows($d2) == 0){
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user_user = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $user_pass = mysqli_real_escape_string($dbc, trim($_POST['password']));
        $user_fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
        $user_minit = mysqli_real_escape_string($dbc, trim($_POST['minit']));
        $user_lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
        $user_ssn = mysqli_real_escape_string($dbc, trim($_POST['ssn']));
        $user_address = mysqli_real_escape_string($dbc, trim($_POST['address']));
        $user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));

        $q = "INSERT INTO users (username, password, fname, minit, lname, ssn, typeUser, address, email) 
            VALUES ('$user_user', '$user_pass', '$user_fname', '$user_minit', '$user_lname', '$user_ssn', '0', '$user_address', '$user_email');";
        $d = mysqli_query($dbc, $q);
        if (!$d) {
            ?>
                <script type="text/javascript"> alert("Something went wrong. Please try again.")</script>
            <?php
        }
        else {
            // check if user was added to DB 
            $query = "SELECT username, uid, typeUser
                    FROM users 
                    WHERE username = '$user_user' AND typeUser = '0' ;";
            $data = mysqli_query($dbc, $query);

            // if no data found, user was not created
            if (!$data) {
                ?>
                <script type="text/javascript"> alert("Something went wrong. Please try again.")</script>
                <?php
            }
            // if data found, user is signed up and can log in now
            else if ($data) {
                $rows = mysqli_fetch_array($data);
                $_SESSION['typeUser'] = $rows[2];
                $_SESSION['uid'] = $rows[1];
                ?>
                <script type="text/javascript"> 
                alert("Your user ID is: <?php echo $_SESSION['uid'] ?>");
                alert("Your user has been created! You'll be redirected to your dashboard.");
                window.location.href = '../dynamo/dashboard.php';
                </script>
            <?php
            }
        }
        
    }
}

?>

<!-- NAV CHANGE ON SCROLL -->
<script>
    $(window).scroll(function(){
        $('nav').toggleClass('scrolled', $(this).scrollTop() > 100);
        $('button#navbtn').toggleClass('scrolled', $(this).scrollTop() > 100);
    });
</script>
</html>

