<?php 
// UPDATE PROFILE

    // Start the session
    session_start();
    // Set type user of logged in user session var 
    $typeUser = $_SESSION['typeUser']; 
    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    require_once('../navMenus/navbar.php'); 
    require_once('../connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<!DOCTYPE html>
<head>
    <title> Update Profile</title>
    <link rel="stylesheet" type="text/css" href="portalCSS/style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text&display=swap" rel="stylesheet">
    <link href="./css/sysad.css" rel="stylesheet">
</head>
<style>
        span{
            color:#ac2424;
            font-size: 14px;
            font-style:italics;
        }
        input[type=button] {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[type=button]:hover {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        a[type=submit] {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        a[type=submit]:hover {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[type=submit] {
            background-color: #cdc3a0;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
        input[type=submit]:hover {
            background-color: #b8974f;
            color:black;
            border: 0px;
            padding-top: 1%;
            padding-bottom: 1%;
        }
   </style>
<body>

<?php 
$q = "SELECT * FROM users WHERE UID = $uid;";
$d = mysqli_query($dbc, $q);
$data = mysqli_fetch_array($d);
if ($d){ ?>
    <div class="container">
        <!-- <script>console.log("<?php echo $data['lname']?> ");</script> -->
        <h4>Welcome, <?php echo $data['fname']?> <?php echo $data['minit']?> <?php echo $data['lname']?>!</h4>
    </div>
    <div class="container"><br><h6>Your profile:</h6><br></div>
    <div class="container">
        <form action="./updateProfile.php" method="POST" id="user-update">
            <div class="form-row">
                <div class="col">
                    <label for="fname">First Name:</label>
                    <input disabled  type="text" id="input" name="fname" data-error="fname-err" class="form-control form-group" label="First Name: " minlength="1" maxlength="50" value="<?php echo $data['fname']; ?>"  >
                    <span id="fname-err"></span>
                </div>
                <div class="col">
                    <label for="minit">Middle Initial:</label>
                    <input disabled  type="text" id="input" name="minit" data-error="minit-err" class="form-control form-group" label="Middle Initial" minlength="0" maxlength="1" value="<?php echo $data['minit']; ?>" >
                    <span id="minit-err"></span>
                </div>
                <div class="col">
                    <label for="lname">Last Name:</label>
                    <input disabled  type="text" id="input" name="lname" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data['lname']; ?>" >
                    <span id="lname-err"></span>
                </div>
            </div>
            <div><br></div>
            <div class="form-row">
                <div class="col">
                    <label for="uid">UID:</label>
                    <input disabled  type="text" id="input-perm" name="uid" data-error="lname-err" class="form-control form-group" placeholder="Last Name *"  minlength="1" maxlength="50" value="<?php echo $data['UID']; ?>" >
                    <span id="uid-err"></span>
                </div>
                <div class="col">
                    <label for="typeUser">Type of User:</label>
                    <div name="typeUser" class="input-group mb-3">
                        <?php if ($data['typeUser'] == 0){
                            $typeUser = "Applicant"; ?>
                            <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                        <?php }
                        else if ($data['typeUser'] == 1){
                            $typeUser = "Faculty Reviewer"; ?>
                            <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                        <?php }
                        else if ($data['typeUser'] == 2){
                            $typeUser = "Chair"; ?>
                            <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                        <?php }
                        else if ($data['typeUser'] == 3){
                            $typeUser = "Graduate Secretary"; ?>
                            <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                        <?php }
                        else if ($data['typeUser'] == 4){
                            $typeUser = "System Administrator"; ?>
                            <input disabled  type="text" id="input-perm" name="type" class="form-control form-group" value="<?php echo $typeUser; ?>"  >
                        <?php } ?>                                                    
                    </div>
                    <span id="type-err"></span>
                </div>
                <div class="col">
                    <label for="username">Username:</label>
                    <input disabled  type="text" id="input-perm" name="username" data-error="fname-err" class="form-control form-group" value="<?php echo $data['username']; ?>"  >
                    <span id="username-err"></span>
                </div>
                <div class="col">
                    <label for="password">Password:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input id="check" type="checkbox" aria-label="Checkbox for following text input">
                            </div>
                            <script>
                                $('#check').click(function(){
                                    if('password' == $('#pass-input').attr('type')){
                                        $('#pass-input').prop('type', 'text');
                                    }else{
                                        $('#pass-input').prop('type', 'password');
                                    }
                                });
                            </script>
                        </div>
                        <input disabled  type="password" id="pass-input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" >
                    </div>
                    <span id="pass-err"></span>
                </div>
            </div>
            <div><br></div>
            <div class="form-row">
                <div class="col">
                    <label for="fname">Email:</label>
                    <input disabled type="text" id="input" name="email" data-error="fname-err" class="form-control form-group" value="<?php echo $data['email']; ?>"  >
                    <span id="email-err"></span>
                </div>
                <div class="col">
                    <label for="ssn">SSN:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input id="check2" type="checkbox" aria-label="Checkbox for following text input">
                            </div>
                            <script>
                                $('#check2').click(function(){
                                    if('password' == $('#ssn-input').attr('type')){
                                        $('#ssn-input').prop('type', 'text');
                                    }else{
                                        $('#ssn-input').prop('type', 'password');
                                    }
                                });
                            </script>
                        </div>
                        <input disabled  type="password" id="ssn-input" name="ssn" class="form-control form-group" maxlength=9 value="<?php echo $data['ssn']; ?>" >
                    </div>
                     <span id="ssn-err"></span>
                </div>
            </div>
            <div><br></div>
            <div class="form-row">
                <div class="col">
                    <label for="minit">Address:</label>
                    <input disabled type="text" id="input" name="address" data-error="minit-err" class="form-control form-group" value="<?php echo $data['address']; ?>" >
                    <span id="address-err"></span>
                </div>
            </div>
            <div><br></div>
        
            <input type="button" class="btn btn-info float-right" id="update" name="update" value="Update Profile"> 
            <input type="hidden" class="btn btn-info float-right"  id="save" name="save" value="Save Changes"> 
            <input type="hidden" class="btn btn-info float-left" id="cancel" name="cancel" value="Cancel" break>
        </form>
    <!-- </form> -->
            <script>
                console.log("in script 1");
                console.log("update: " + document.querySelector('#update').value);
                    document.getElementById("update").onclick = function () {
                        console.log("in update profile");
                        $('input[type=password]').attr('password', 'text'); 
                        $('input:not([id=input-perm])').removeAttr('disabled');
                        var v = document.getElementById("update");
                        v.setAttribute('type','hidden');
                        var s = document.getElementById("save");
                        s.setAttribute('type','button');
                        var x = document.getElementById("cancel");
                        x.setAttribute('type','button');
                    }
                    console.log("update2: " + document.querySelector('#update').value);

                    document.getElementById("cancel").onclick = function () {
                        location.reload();
                    }
                    document.getElementById("save").onclick = function() { 
                        console.log("save");
                        jQuery.validator.addMethod("alphanumeric", function(value, element) {
                            return this.optional(element) || /^[\w -]+$/i.test(value);
                        }, "Letters, numbers, and underscores only please");
                        $('#user-update').validate({ 
                            rules: {
                                fname: {
                                    required: true,
                                    alphanumeric: true,
                                    maxlength:25
                                },
                                minit: {
                                    lettersonly: true,
                                    maxlength: 1
                                },
                                lname: {
                                    required: true,
                                    alphanumeric: true,
                                    maxlength:25
                                },
                                ssn: {
                                    required: true,
                                    digits: true,
                                    minlength: 9,
                                    maxlength: 9
                                },
                                email: {
                                    email: true,
                                    required: true,
                                },
                                address: {
                                    required: true,
                                    maxlength: 100,
                                },
                                username: {
                                    required: true,
                                    alphanumeric: true,
                                    maxlength:20,
                                },
                                password: {
                                    required:true,
                                    maxlength:40,
                                },
                                uid: {
                                    required: true,
                                    digits: true,
                                    maxlength:8
                                },
                                typeUser: {
                                    required: true
                                }
                            },
                            errorPlacement: function(error, element) {
                                if (element.attr("name") == "fname" ) {
                                    $("span#fname-err").text($(error).text());
                                }
                                if (element.attr("name") == "minit" ) {
                                    $("#minit-err").text($(error).text());
                                }
                                if (element.attr("name") == "lname" ) {
                                    $("#lname-err").text($(error).text());
                                }
                                if (element.attr("name") == "typeUser" ) {
                                    $("#type-err").text($(error).text());
                                }
                                if (element.attr("name") == "uid" ) {
                                    $("#uid-err").text($(error).text());
                                }
                                if (element.attr("name") == "ssn" ) {
                                    $("#ssn-err").text($(error).text());
                                }
                                if (element.attr("name") == "email" ) {
                                    $("#email-err").text($(error).text());
                                }
                                if (element.attr("name") == "address" ) {
                                    $("#address-err").text($(error).text());
                                }
                                if (element.attr("name") == "username" ) {
                                    $("#username-err").text($(error).text());
                                }
                                if (element.attr("name") == "password" ) {
                                    $("#pass-err").text($(error).text());
                                }
                            },
                            
                        });
                        if ($('#user-update').valid()) {
                                var f = document.getElementsByName("fname")[0].value;
                                console.log("fname: " + f);
                                var m = document.getElementsByName("minit")[0].value;
                                var l = document.getElementsByName("lname")[0].value;
                                var t = $("#inputGroupSelect option:selected").text();
                                var uid = document.getElementsByName("uid")[0].value;
                                var ogUID = document.getElementsByName("uid")[0].value;
                                var a = document.getElementsByName("address")[0].value;
                                var e = document.getElementsByName("email")[0].value;
                                var ssn = document.getElementsByName("ssn")[0].value;
                                var u = document.getElementsByName("username")[0].value;
                                var p = document.getElementsByName("password")[0].value;
                                console.log("valid");
                                $.ajax({
                                    url: "./update-user.php",
                                    type: 'POST',
                                    data: {fname:f, minit:m, lname:l, typeUser:t, uid:uid, address:a, email:e, ssn:ssn, username:u, password:p, ogUID:ogUID},                             
                                    success: function(response) {
                                        console.log("response: " + response);
                                            console.log("response success");
                                            $('input[name=fname]').text(f);
                                            $('input[name=minit]').text(m);
                                            $('input[name=lname]').text(l);
                                            $('input[name=uid]').text(uid);
                                            $('input[name=typeUser]').text(t);
                                            $('input[name=address]').text(a);
                                            $('input[name=email]').text(e);
                                            $('input[name=ssn]').text(ssn);
                                            $('input[name=username]').text(u);
                                            $('input[name=password]').text(p);
                                            var v = document.getElementById("update");
                                            v.setAttribute('type','button');
                                            var s = document.getElementById("save");
                                            s.setAttribute('type','hidden');
                                            var x = document.getElementById("cancel");
                                            x.setAttribute('type','hidden');
                                            var inputs = document.getElementById("input");
                                            inputs.setAttribute('disabled', 'true');
                                            window.location.href = "./updateProfile.php";
                                    }
                                })
                            }
                        }
                        
            </script>
    </div>
<?php } ?>

</body>
</html>