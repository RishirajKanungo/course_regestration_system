<?php require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // ADD NEW RECOMMENDER AS SYS ADMIN 
    
    // if (isset($_POST['fname'])) {
        $fname = $_POST['fname'];
        $minit = $_POST['minit'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $company = $_POST['company'];

        $query  = "SELECT email FROM recommenders WHERE email='$email';";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) != 0){ 
            echo "A user with these credentials already exists. unable to create user";
            return 0;
       }
        else if (mysqli_num_rows($data) == 0) {
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

            $q = "INSERT INTO recommenders (fname, minit, lname, email, title, company, password) VALUES ('$fname','$minit','$lname','$email','$title','$company', '$password');";
            $r = mysqli_query($dbc, $q);
            echo mysqli_error($dbc);
        
            if (!$r){ ?>
                <?php return 'Something went wrong. User has not been created.';
            }
            else { 
            // alert("New user created.");
           

                $to = $email;
                $subject = "Recommender Account Created";
                $txt = "Hi " . $fname . "  " . $lname . ", An applicant has requested that you submit a recommendation letter on their behalf. An account was created for you with the following username and password. 
                Username: " . $email . "\n Password: " . $password;"\n
    
                Please log in at http://gwupyterhub.seas.gwu.edu/~sreyanalla/clout_computing/phase1/home.php to login and start your session.";
                $headers = "From: Admissions" . "\r\n";
    
                mail($to,$subject,$txt,$headers);
                echo 'A new user with these credentials has been created!';
                return 1;
                
            }
        }   