<?php require_once('../connectvars.php');

// CREATE NEW USER AS SYS ADMIN 

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // if (isset($_POST['fname'])) {
        $fname = $_POST['fnamecreate'];
        $minit = $_POST['minitcreate'];
        $lname = $_POST['lnamecreate'];
        $ssn = $_POST['ssncreate'];
        $address = $_POST['addresscreate'];
        $email = $_POST['emailcreate'];
        $username = $_POST['usernamecreate'];
        //$password = $_POST['passcreate'];
        $typeUser = $_POST['typeUser'];
        if ($typeUser == "0") {
            $typeUser = 0;
        }
        
        $query  = "SELECT username, ssn FROM users WHERE username='$username' OR ssn=$ssn;";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) != 0){ 
            echo "A user with these credentials already exists. Unable to create user.";
            return;
       }
        else {
            function generate_password($length = 8) {
                $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
                $str = '';
                $maxLen = strlen($chars) - 1;
            
                for ($i=0; $i < $length; $i++) {
                    $str .= $chars[random_int(0, $maxLen)];
                }
                return $str;
                }
            
                // generate password of length 8 for recommender login
                $password = generate_password();

            $q = "INSERT INTO users (fname, minit, lname, email, ssn, username, password, typeUser, address) VALUES ('$fname','$minit','$lname','$email','$ssn','$username','$password', '$typeUser', '$address');";
            $r = mysqli_query($dbc, $q);
            echo mysqli_error($dbc);
        
            if (!$r){ ?>
                <script>console.log("error" + $typeUser);</script>
                <?php return 'Something went wrong. User has not been created.';
            }
            else { 
                // alert("New user created.");
                $to = $email;
                $subject = "Applicant Account Created";
                $txt = "Hi " . $fname . "  " . $lname . ", An account was created on your behalf with the following username and password. 
                Username: " . $username . "\n Password: " . $password;"\n
    
                Please log in at http://gwupyterhub.seas.gwu.edu/~sreyanalla/clout_computing/phase1/home.php to login and start your session.";
                $headers = "From: Admissions" . "\r\n";
    
                mail($to,$subject,$txt,$headers);

                echo 'A new user with these credentials has been created!'; 
                return;
            }
        }   