<!-- SYSTEM ADMINISTRATOR PAGE -->

<!-- ALL FUNCTIONALITY AND NAV TAB CODE -->

<?php 
    session_start();
    require_once('../connectvars.php');
    require_once('../navMenus/navSys.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // require './sysupdates.php';
?>

<!DOCTYPE html> 
<head style="font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;">
    <title>System Administrator</title>

    <!-- META DATA -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/sysad.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.js"></script>
   <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.js"></script>
    <script src="js/sysad.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text&display=swap" rel="stylesheet">
</head>
<style>
    .error{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
}
span{
    color:#ac2424;
    font-size: 14px;
    font-style:italic;
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
     if (!isset($_SESSION['uid']) && (!isset($_SESSION['typeUser'])) || ($_SESSION['typeUser'] != 4)) {
         ?>
             <script type="text/javascript">alert("You must login to access this page. You are now being redirected to our home page");
             window.location.href = 'home.php';
             </script>
     <?php
     }
    // if (!$_SESSION['uid']) {}
    else {
    $uid_inuse = $_SESSION['uid'];
?>
    
    <!-- </section> -->
    <div>
        <br />
        <br />

    </div>
    <!-- PAGE Content -->
    <!-- <section id="page-content"> -->
        <div class="container" id="">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" role="tab" href="#profile">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab" id="allusers" href="#view-all">View All Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab"  href="#applicants">Applicants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" role="tab"  href="#reviewers">Reviewers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" role="tab"  href="#recommenders">Recommender</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" role="tab"  href="#search">Search</a>
                </li>
            </ul>
            <div class="tab-content" id="">
                <!-- Admin Profile Pane -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div><br/></div>
                        <!-- <h4>SYS Profile </h4> -->
                        <?php 
                            $q = "SELECT * FROM users WHERE UID = $uid_inuse;";
                            $d = mysqli_query($dbc, $q);
                            $data = mysqli_fetch_array($d);
                            if ($d){?>
                                <!-- <form class="form-group"> -->
                                    <div class="container">
                                        <script>console.log("<?php echo $data['lname']?> ");</script>
                                        <h4>Welcome, <?php echo $data['fname']?> <?php echo $data['minit']?> <?php echo $data['lname']?>!</h4>
                                    </div>
                                    <div class="container"><br><h6>Your profile:</h6><br></div>
                                    <div class="container">
                                        <form action="./sysadmin.php" method="POST" id="profile-form">
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
                                                            <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                                <option value="0" selected><?php echo $typeUser ?></option>
                                                                <option value="1">Faculty Reviewer</option>
                                                                <option value="2">Chair</option>
                                                                <option value="3">Graduate Secretary</option>
                                                                <option value="4">System Administrator</option>
                                                            </select>
                                                       <?php }
                                                        else if ($data['typeUser'] == 1){
                                                            $typeUser = "Faculty Reviewer"; ?>
                                                            <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                                <option value="1" selected><?php echo $typeUser ?></option>
                                                                <option value="2">Chair</option>
                                                                <option value="3">Graduate Secretary</option>
                                                                <option value="4">System Administrator</option>
                                                                <option value="0">Applicant</option>
                                                            </select>
                                                       <?php }
                                                        else if ($data['typeUser'] == 2){
                                                            $typeUser = "Chair"; ?>
                                                            <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                                <option value="2" selected><?php echo $typeUser ?></option>
                                                                <option value="3">Graduate Secretary</option>
                                                                <option value="4">System Administrator</option>
                                                                <option value="1">Faculty Reviewer</option>
                                                                <option value="0">Applicant</option>
                                                            </select>
                                                       <?php }
                                                        else if ($data['typeUser'] == 3){
                                                            $typeUser = "Graduate Secretary"; ?>
                                                            <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                                <option value="3" selected><?php echo $typeUser ?></option>
                                                                <option value="4">System Administrator</option>
                                                                <option value="0">Applicant</option>
                                                                <option value="1">Faculty Reviewer</option>
                                                                <option value="2">Chair</option>
                                                            </select>
                                                       <?php }
                                                        else if ($data['typeUser'] == 4){
                                                            $typeUser = "System Administrator"; ?>
                                                            <select disabled class="custom-select" name="typeUser" id="inputGroupSelect">
                                                                <option value="4" selected><?php echo $typeUser ?></option>
                                                                <option value="0">Applicant</option>
                                                                <option value="1">Faculty Reviewer</option>
                                                                <option value="2">Chair</option>
                                                                <option value="3">Graduate Secretary</option>
                                                            </select>
                                                       <?php } ?>                                                    
                                                    </div>
                                                    <!-- <input disabled  type="text" id="input" name="typeUser" data-error="fname-err" class="form-control form-group" value="<?php echo $typeUser?>" > -->
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
                                                    
                                                    <!-- <input disabled  type="password" id="input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" > -->
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
                                                    
                                                    <!-- <input disabled  type="password" id="input" name="password" data-error="minit-err" class="form-control form-group" value="<?php echo $data['password']; ?>" > -->
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
                                        
                                            <input type="button" class="btn float-right" id="update" name="update" value="Update Profile"> 
                                            <input type="hidden" class="btn float-right"  id="save" name="save" value="Save Changes"> 
                                            <a href="./sysadmin.php"><input type="hidden" class="btn float-left" id="cancel" name="cancel" value="Cancel"></a>
                                        </form>
                                <!-- </form> -->
                                            <script>
                                                console.log("in script 1");
                                                console.log("update: " + document.querySelector('#update').value);
                                                // if ((document.querySelector('#update').value == "Update Profile")){
                                                // if ($('#save').attr('type')=='hidden') {
                                                    document.getElementById("update").onclick = function () {
                                                        console.log("in update profile");
                                                        $('input[type=password]').attr('password', 'text'); 
                                                        $('input:not([id=input-perm])').removeAttr('disabled');
                                                        $('select').removeAttr('disabled');
                                                        var v = document.getElementById("update");
                                                        v.setAttribute('type','hidden');
                                                        var s = document.getElementById("save");
                                                        s.setAttribute('type','button');
                                                        var x = document.getElementById("cancel");
                                                        x.setAttribute('type','button');
                                                        //var d = document.getElementById("inputGroupSelect");
                                                    }
                                                    document.getElementById("cancel").onclick = function() { 
                                                        location.reaload();
                                                    }
                                                    document.getElementById("save").onclick = function() { 
                                                        console.log("save");
                                                        document.getElementById("cancel").onclick = function() { 
                                                            location.reload();
                                                        }
                                                        jQuery.validator.addMethod("alphanumeric", function(value, element) {
                                                            return this.optional(element) || /^[\w -]+$/i.test(value);
                                                        }, "Letters, numbers, and underscores only please");
                                                        $('#profile-form').validate({ 
                                                            rules: {
                                                                fname: {required: true, alphanumeric:true, maxlength:25},
                                                                minit: {lettersonly: true, maxlength: 1},
                                                                lname: {required: true, alphanumeric:true, maxlength:25},
                                                                ssn: {required: true, digits: true, minlength: 9, maxlength: 9},
                                                                email: {email: true, required: true},
                                                                address: {required: true, maxlength:100},
                                                                username: {required: true, alphanumeric: true, maxlength:20},
                                                                password: {required:true, maxlength:40},
                                                                uid: {required: true, digits: true},
                                                                typeUser: {required: true}
                                                            },
                                                            errorPlacement: function(error, element) {
                                                                //Custom position: first name
                                                                if (element.attr("name") == "fname" ) {
                                                                    // alert(error);
                                                                    $("span#fname-err").text($(error).text());
                                                                }
                                                                //Custom position: second name
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
                                                        // submitHandler: function(form){
                                                        if ($('#profile-form').valid()) {
                                                                var f = document.getElementsByName("fname")[0].value;
                                                                console.log("fname: " + f);
                                                                var m = document.getElementsByName("minit")[0].value;
                                                                var l = document.getElementsByName("lname")[0].value;
                                                                // var t = document.getElementsByName("typeUser")[0].value;
                                                                var t = $("#inputGroupSelect option:selected").text();
                                                                var uid = document.getElementsByName("uid")[0].value;
                                                                var ogUID = document.getElementsByName("uid")[0].value;
                                                                var a = document.getElementsByName("address")[0].value;
                                                                var e = document.getElementsByName("email")[0].value;
                                                                var ssn = document.getElementsByName("ssn")[0].value;
                                                                var u = document.getElementsByName("username")[0].value;
                                                                var p = document.getElementsByName("password")[0].value;
                                                                console.log("valid");
                                                                //var ret = checkInput();
                                                                //if (ret) {
                                                                $.ajax({
                                                                    url: "./edit-sys.php",
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
                                                                            var x = document.getElementById("save");
                                                                            x.setAttribute('type','hidden');
                                                                            var inputs = document.getElementById("input");
                                                                            inputs.setAttribute('disabled', 'true');
                                                                            window.location.href = "./sysadmin.php";
                                                                        // }
                                                                    }
                                                                })
                                                            }
                                                        }
                                                       
                                            </script>
                                        <!-- </form> -->
                                    </div>
                                <!-- </form> -->
                            <?php }
                        ?>

                </div>
                <!-- View All Pane -->
                <div class="tab-pane fade" id="view-all" role="tabpanel" aria-labelledby="view-all-tab">
                    <br><h4>Manage Users</h4><br>
                    <div class="form-row"><br>
                        <div class="col">
                            <input type="submit" name="create-user" value="Create New User" class="btn btn-dark" onclick="$('#createModal').modal('toggle');">
                            <input type="submit" name="create-rec" value="Create New Recommender" class="btn btn-dark" onclick="$('#createRec').modal('toggle');">
                        </div>
                    </div>
                    
                    <?php 
                        $q = "SELECT * FROM users;";
                        $d = mysqli_query($dbc, $q);
                        if (!$d) {
                            ?>
                                <script type="text/javascript"> alert("something went wrong") </script>
                            <?php
                        }
                        else {
                            // $r = mysqli_fetch_array($d);
                            $rows = mysqli_num_rows($d); 
                            // $count = 0;
                            // while ($row = $rd->fetch_object()) {
                            if ($rows > 0) { ?>
                            <br><br><h4>View Users</h4>
                                <div><br /></div>
                                <div class="table-responsive">
                                    <table width="100%" class="table fluid-container text-center justify-content-center"> 
                                        <thead>
                                            <tr>
                                                <th scope="col">Last</th>
                                                <th scope="col">First</th>
                                                <th scope="col">M. Initial</th>
                                                <th scope="col">UID</th>
                                                <th scope="col">Type of User</th>
                                                <th scope="col">User Information</th>
                                            </tr>
                                        </thead>
                                        <tbody><?php
                                        // while ($data = $d->fetch_object()){ 
                                        while ($data = mysqli_fetch_array($d)){ 
                                            // $count++; ?>
                                            <!-- <form method="post" action="#"> -->
                                            <tr id="<?php echo $data['UID'] ?>">
                                                    <td name="lname-all" data-target="lname-edit"><?php echo $data['lname'];?></td>
                                                    <td name="fname-all" data-target="fname-edit"><?php echo $data['fname'];?></td>
                                                    <td name="minit-all" data-target="minit-edit"><?php echo $data['minit'];?></td>
                                                    <td name="uid-all" id="uid-all" data-target="uid-edit"><?php echo $data['UID'];?></td>
                                                    <?php 
                                                        if ($data['typeUser'] == '0') { ?>
                                                            <td data-target="type-edit">Applicant</td>
                                                        <?php }
                                                        else if ($data['typeUser']== '1') { ?>
                                                            <td data-target="type-edit">Faculty Reviewer</td>
                                                        <?php }
                                                        else if ($data['typeUser'] == '2') { ?>
                                                            <td data-target="type-edit">Chair</td>
                                                        <?php }
                                                        else if ($data['typeUser'] == '3') { ?>
                                                            <td data-target="type-edit">Grad Secretary</td>
                                                        <?php }
                                                        else if ($data['typeUser'] == '4') { ?>
                                                            <td data-target="type-edit">System Administrator</td>
                                                        <?php }
                                                    ?>
                                                    <td>
                                                        <a type="submit" onclick="showAllModal(this);" name="user-info-btn" id="user-info-btn" class="btn btn-light" data-toggle="modal" data-role="update" data-id="<?php echo $data['UID']; ?>">View Profile</a>
                                                        <input type="button" id="remove" value="Remove User" class="btn btn-light" onclick="removeUser(<?php echo $data['UID']; ?>)">
                                                        <script>
                                                            // document.getElementById("remove").onsubmit = function(){
                                                            function removeUser(id) {
                                                                var uid = id;
                                                                console.log("uid: " + uid);
                                                                console.log("in remove");
                                                                // var checkstr = false;
                                                                console.log("checkstr: " + checkstr);
                                                                var checkstr =  confirm('Are you sure you want to remove this user?');
                                                                console.log("post checkstr: " + checkstr);
                                                                if(checkstr == true){
                                                                    $.ajax({
                                                                        url:"./remove-user.php",
                                                                        method: "POST",
                                                                        data: {uid:uid},
                                                                        success: function(response) {
                                                                            alert("User was removed.")
                                                                        }
                                                                    })
                                                                }
                                                                else{return false;}
                                                            }
                                                        </script>
                                                        <br>
                                                        <?php 
                                                            if ($data['typeUser'] == '0'){ ?>
                                                                <form action="./viewHistory.php" method="POST">
                                                                    <br><input type="submit" name="user-app-btn" value="View History" id="user-app-btn" class="btn btn-light"><br>
                                                                    <input type="hidden" name="oguid-all" data-target="og-uid" value="<?php echo $data['UID'];?>"/>
                                                                </form>
                                                            <?php }
                                                        ?>
                                                        
                                                    </td>
                                                    <input type="hidden" name="type-all" value="<?php echo $data['typeUser'];?>"/>
                                                    <input type="hidden" name="ssn-all" data-target="ssn-edit" value="<?php echo $data['ssn'];?>"/>
                                                    <input type="hidden" name="email-all" data-target="email-edit" value="<?php echo $data['email'];?>"/>
                                                    <input type="hidden" name="address-all" data-target="address-edit" value="<?php echo $data['address'];?>"/>
                                                    <input type="hidden" name="user-all" data-target="username-edit" value="<?php echo $data['username'];?>"/>
                                                    <input type="hidden" name="pass-all" data-target="pass-edit" value="<?php echo $data['password'];?>"/>
                                                    <!-- <input type="hidden" name="oguid-all" data-target="og-uid" value="<?php echo $data['UID'];?>"/> -->
                                                    <!-- <script>
                                                        document.getElementById("user-app-btn").onclick = function () {
                                                            var uid = $('input[name=oguid-all]').val();
                                                            console.log("uid: " + uid);
                                                            // var m = document.getElementsByName("minit-all")[0].value;
                                                            // var l = document.getElementsByName("lname-all")[0].value;
                                                            // var t = document.getElementsByName("type-all")[0].value;
                                                            // var uid = document.getElementsByName("uid-all")[0].value;
                                                            // // var ogUID = document.getElementsByName("oguid-all")[0].value;
                                                            // var a = document.getElementsByName("address-all")[0].value;
                                                            // var e = document.getElementsByName("email-all")[0].value;
                                                            // var ssn = document.getElementsByName("ssn-all")[0].value;
                                                            // var u = document.getElementsByName("user-all")[0].value;
                                                            // var p = document.getElementsByName("pass-all")[0].value;

                                                            $.ajax({
                                                                url: "./viewHistory.php",
                                                                type: 'POST',
                                                                data: {uid:uid},
                                                                success: function(response) {
                                                                    window.location.href="./viewHistory.php";
                                                                }
                                                            })
                                                        }
                                                    </script> -->
                                                    
                                                    
                                            </tr>
                                            <!-- </form> -->
                                        <?php }
                                    ?></tbody>
                                    </table>
                                </div>
                            <?php }
                        }
                    ?>
                </div>
                <!-- Applicant Pane -->
                <div class="tab-pane fade" id="applicants" role="tabpanel" aria-labelledby="app-tab">
                    <div><br /></div>
                    <!-- <h4>APPLICANT LIST</h4> -->
                    <?php
                        $q = "SELECT * FROM users WHERE typeUser = '0';";
                        $d = mysqli_query($dbc, $q);
                        // $countApp = 0;
                        if (!$d) {
                            ?><script>console.log("applicant tab q failure");</script><?php
                        }
                        else { ?>
                            <div class="table-responsive">
                                <table class="table fluid-container text-center justify-content-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Last</th>
                                            <th scope="col">First</th>
                                            <th scope="col">M. Initial</th>
                                            <th scope="col">UID</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">User Information</th>
                                            <tbody>
                                                <?php
                                                while ($data = mysqli_fetch_array($d)) {
                                                    // $count++; ?>
                                                    <tr id="<?php echo $data['username']?>">
                                                        <td data-target="app-lname-edit"><?php echo $data['lname'];?></td>
                                                        <td data-target="app-fname-edit"><?php echo $data['fname'];?></td>
                                                        <td data-target="app-minit-edit"><?php echo $data['minit'];?></td>
                                                        <td data-target="app-uid-edit"><?php echo $data['UID'];?></td>
                                                        <td data-target="app-username-edit"><?php echo $data['username'];?></td>
                                                        <td>
                                                            <a type="submit" onclick="showAppModal(this);" name="app-info-btn" class="btn btn-light" data-toggle="modal" data-role="update" data-id="<?php echo $data['username']; ?>">View Profile</a>
                                                            <input type="button" id="remove" value="Remove User" class="btn btn-light" onclick="removeUser(<?php echo $data['UID']; ?>)">
                                                            <br><br><form action="./viewHistory.php" method="POST">
                                                                <input type="submit" name="user-app-btn" value="View History" id="user-app-btn" class="btn btn-light">
                                                                <input type="hidden" name="oguid-all" data-target="og-uid" value="<?php echo $data['UID'];?>"/>
                                                            </form>
                                                        </td>
                                                        <input type="hidden" data-target="app-ssn-edit" value="<?php echo $data['ssn'];?>"/>
                                                        <input type="hidden" data-target="app-email-edit" value="<?php echo $data['email'];?>"/>
                                                        <input type="hidden" data-target="app-address-edit" value="<?php echo $data['address'];?>"/>
                                                        <input type="hidden" data-target="app-type-edit" value="<?php echo $data['typeUser'];?>"/>
                                                        <input type="hidden" data-target="app-pass-edit" value="<?php echo $data['password'];?>"/>
                                                        <input type="hidden" data-target="app-og-uid" value="<?php echo $data['UID'];?>"/>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php }
                    ?>
                </div>
                <!-- Reviewers Pane -->
                <div class="tab-pane fade" id="reviewers" role="tabpanel" aria-labelledby="rev-tab">
                    <div><br/></div>
                    <?php
                        $q = "SELECT * FROM users WHERE typeUser = '1' OR typeUser = '2' OR typeUser = '3';";
                        $d = mysqli_query($dbc, $q);
                        // $countApp = 0;
                        if (!$d) {
                            ?><script>console.log("applicant tab q failure");</script><?php
                        }
                        else { ?>
                            <div class="table-responsive">
                                <table class="table fluid-container text-center justify-content-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Last</th>
                                            <th scope="col">First</th>
                                            <th scope="col">M. Initial</th>
                                            <th scope="col">UID</th>
                                            <th scope="col">Type User</th>
                                            <th scope="col">User Information</th>
                                            <tbody>
                                                <?php
                                                while ($data = mysqli_fetch_array($d)) {
                                                    // $count++; ?>
                                                    <tr id="<?php echo $data['UID'] ?>">
                                                        <td data-target="lname-edit"><?php echo $data['lname'];?></td>
                                                        <td data-target="fname-edit"><?php echo $data['fname'];?></td>
                                                        <td data-target="minit-edit"><?php echo $data['minit'];?></td>
                                                        <td data-target="uid-edit"><?php echo $data['UID'];?></td>
                                                        <?php if ($data['typeUser']== '1') { ?>
                                                                <td data-target="type-edit">Faculty Reviewer</td>
                                                            <?php }
                                                            else if ($data['typeUser'] == '2') { ?>
                                                                <td data-target="type-edit">Chair</td>
                                                            <?php }
                                                            else if ($data['typeUser'] == '3') { ?>
                                                                <td data-target="type-edit">Grad Secretary</td>
                                                            <?php } ?>
                                                        <td>
                                                            <a type="submit" onclick="showRevModal(this);" name="rev-info-btn" id="rev-info-btn" class="btn btn-light" data-toggle="modal" data-role="update" data-id="<?php echo $data['UID']; ?>">View Profile</a>
                                                            <input type="button" id="remove" value="Remove User" class="btn btn-light" onclick="removeUser(<?php echo $data['UID']; ?>)">
                                                        </td>
                                                        <input type="hidden" data-target="ssn-edit" value="<?php echo $data['ssn'];?>"/>
                                                        <input type="hidden" data-target="email-edit" value="<?php echo $data['email'];?>"/>
                                                        <input type="hidden" data-target="address-edit" value="<?php echo $data['address'];?>"/>
                                                        <input type="hidden" data-target="username-edit" value="<?php echo $data['username'];?>"/>
                                                        <input type="hidden" data-target="pass-edit" value="<?php echo $data['password'];?>"/>
                                                        <input type="hidden" data-target="og-uid" value="<?php echo $data['UID'];?>"/>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php }
                    ?>
                </div>
                <!-- Recommender Pane -->
                <div class="tab-pane fade" id="recommenders" role="tabpanel" aria-labelledby="rec-tab">
                <div><br/></div>
                <?php
                        $q = "SELECT * FROM recommenders;";
                        $d = mysqli_query($dbc, $q);
                        // $countApp = 0;
                        if (!$d) {
                            ?><script>console.log("applicant tab q failure");</script><?php
                        }
                        else { ?>
                            <div class="table-responsive">
                                <table class="table fluid-container text-center justify-content-center">
                                    <thead >
                                        <tr>
                                            <th scope="col">Last</th>
                                            <th scope="col">First</th>
                                            <th scope="col">M. Initial</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">User Information</th>
                                            <tbody>
                                                <?php
                                                while ($data = mysqli_fetch_array($d)) {
                                                    // $count++; ?>
                                                    <tr id="<?php echo $data['fname'] ?>-<?php echo $data['minit']?>-<?php echo $data['lname'] ?>">
                                                        <td data-target="rec-lname-edit"><?php echo $data['lname'];?></td>
                                                        <td data-target="rec-fname-edit"><?php echo $data['fname'];?></td>
                                                        <td data-target="rec-minit-edit"><?php echo $data['minit'];?></td>
                                                        <td data-target="rec-email-edit"><?php echo $data['email'];?></td>
                                                        <td>
                                                            <a type="submit" onclick="showRecModal(this);" name="rec-info-btn" id="rec-info-btn" class="btn btn-light" data-toggle="modal" data-role="update" data-id="<?php echo $data['fname'] ?>-<?php echo $data['minit']?>-<?php echo $data['lname'] ?>">View Profile</a>
                                                        </td>
                                                        <input type="hidden" data-target="rec-title-edit" value="<?php echo $data['title'];?>"/>
                                                        <input type="hidden" data-target="rec-company-edit" value="<?php echo $data['company'];?>"/>
                                                        <input type="hidden" data-target="rec-pass-edit" value="<?php echo $data['password'];?>"/>
                                                        <input type="hidden" data-target="rec-og-email" value="<?php echo $data['email'];?>"/>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php }
                    ?>
                </div>
                <!-- Dynamic Search Pane -->
                <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="rec-tab">
                    <div><br /></div>
                    <div class="container">
                        <!-- <div class="input-group"> -->
                        <input type="text" onkeyup="search()" name="search_text" id="search_text" placeholder="Search by User Details" class="form-control" />
                        <!-- </div> -->
                    </div>
                    <div id="result"></div>
                </div>
            </div>
        </div>
    <!-- </section> -->
<!-- New User Modal-->
<div class="modal fade" id="createModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" id="create" action="./sysadmin.php">
      <div class="modal-header">
        <h5 class="modal-title" id="createModal">Create New User</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fnamecreate" class="form-control">
            </div>
            <div class="form-group">
                <label>Middle Initial</label>
                <input type="text" name="minitcreate" maxlength=1 class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lnamecreate" class="form-control">
            </div>
            <div class="form-group">
                <label for="ssn">SSN:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="new-ssn" type="checkbox">
                        </div>
                        <script>
                            $('#new-ssn').click(function(){
                                if(document.getElementById("ssn-new").type === 'password'){
                                    document.getElementById("ssn-new").type = "text";
                                }else{
                                    document.getElementById("ssn-new").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input type="password" id="ssn-new" name="ssncreate" class="form-control form-group" maxlength=9>
                </div>
            </div>
            <div class="form-group">
                <label for="typeUser">Type of User:</label>
                <div name="typeUser" class="input-group mb-3">
                    <select class="custom-select" name="typeUser" id="typeUser">
                        <option value="" selected></option>
                        <option value="0">Applicant</option>
                        <option value="1">Faculty Reviewer</option>
                        <option value="2">Chair</option>
                        <option value="3">Graduate Secretary</option>
                        <option value="4">System Administrator</option>
                    </select>                                           
                </div>
            <!-- </div> -->
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="emailcreate" class="form-control">
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="addresscreate" class="form-control">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="usernamecreate" class="form-control">
            </div>
            <input type="hidden" id="og-uid" class= "form-control" value="">
      </div>
      <div class="modal-footer">
        <!-- <a id=save-changes onclick="saveChanges();" class="btn btn-info float-right">Create</a> -->
        <input type="submit" id="create" class="btn btn-dark" value="Create">
        <button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
      </form>
      <script>
          jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
            $('#create').validate({
                rules:{
                    fnamecreate: {required:true, maxlength:25, alphanumeric:true},
                    minitcreate:{maxlength:1, lettersonly:true},
                    lnamecreate: {required: true, maxlength:25, alphanumeric:true},
                    ssncreate: {required: true, digits:true, maxlength:9, minlength:9},
                    typeUser: {required:true},
                    emailcreate: {required:true, email:true, maxlength:62},
                    addresscreate: {required: true, maxlength:100},
                    usernamecreate: {required: true, alphanumeric:true, maxlength:20},
                    passcreate: {required:true, maxlength:40}
                },
                submitHandler: function(){
                    $.ajax({
                        url: './add-user.php',
                        type: 'POST',
                        data: $('#create').serialize(),
                        success: function(response) {
                            console.log(response);
                            if (response == "" || response == " "){
                                alert("new user created");
                            }
                            alert(response);
                        }            
                    });
                }
            })
      </script>
    </div>
  </div>
</div>
<!-- All / Reviewer Modal-->
<div class="modal fade" id="all-revModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="" method="POST" id=allmodal>
      <div class="modal-header">
        <h5 class="modal-title" id="all-revModal">Edit User's Personal Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" id="fname-edit" name="fname" class="form-control">
            </div>
            <div class="form-group">
                <label>Middle Initial</label>
                <input type="text" id="minit-edit" name="minit" class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" id="lname-edit" name="lname" class="form-control">
            </div>
            <div class="form-group">
                <label for="ssn">SSN:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="check-ssn" type="checkbox">
                        </div>
                        <script>
                            $('#check-ssn').click(function(){
                                if(document.getElementById("ssn-edit").type === 'password'){
                                    document.getElementById("ssn-edit").type = "text";
                                }else{
                                    document.getElementById("ssn-edit").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input disabled type="password" id="ssn-edit" name="ssn" class="form-control form-group" maxlength=9>
                </div>
            </div>
            <div class="form-group">
                <label>User ID</label>
                <input disabled type="text" id="uid-edit" name="uid" class="form-control">
            </div>
            <div class="form-group">
                <label>Type of User</label>
                <input type="text" id="type-edit" name="typeUser" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" id="email-edit" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" id="address-edit" name="address" class="form-control">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input disabled type="text" id="username-edit" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="check-pass" type="checkbox">
                        </div>
                        <script>
                            $('#check-pass').click(function(){
                                if(document.getElementById("pass-edit").type === 'password'){
                                    document.getElementById("pass-edit").type = "text";
                                }else{
                                    document.getElementById("pass-edit").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input type="password" id="pass-edit" name="password" class="form-control">
                </div>
            </div>
            <input type="hidden" id="og-uid" class= "form-control" value="">
      </div>
      <div class="modal-footer">
        <input type="submit" id="update" class="btn btn-dark" value="Update">
        <button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
    <script>
       jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        $('#allmodal').validate({
            rules:{
                fname: {required:true, alphanumeric:true, maxlength:25},
                minit:{maxlength:1, lettersonly:true},
                lname: {required: true, maxlength:25, alphanumeric:true},
                ssn: {required: true, digits:true, maxlength:9, minlength:9},
                typeUser: {required:true},
                email: {required:true, email:true, maxlength:62},
                address: {required: true, maxlength:100},
                username: {required: true, alphanumeric:true, maxlength:20},
                password: {required:true, maxlength:40}
            },
            submitHandler: function(e){
                var disabled = $('#allmodal').find(':input:disabled').removeAttr('disabled');
                $.ajax({
                    url: './fetch-sys.php',
                    type: 'POST',
                    data: $('#allmodal').serialize(),
                    success: function(response) {
                        console.log(response);
                        alert(response);
                        disabled.attr('disabled','disabled');
                    }            
                });
            }
        });

    </script>
  </div>
</div>
<!-- Recommender Modal -->
<div class="modal fade" id="recModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" id="recmodal">
      <div class="modal-header">
        <h5 class="modal-title" id="recModTitle">Update Recommender Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" id="rec-fname-edit" name="fname" class="form-control">
            </div>
            <div class="form-group">
                <label>Middle Initial</label>
                <input type="text" id="rec-minit-edit" name="minit" class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" id="rec-lname-edit" name="lname" class="form-control">
            </div>
            <div class="form-group">
                <label>Company/Place of Employment</label>
                <input type="text" id="rec-company-edit" name="company" class="form-control">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="rec-title-edit" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" id="rec-email-edit" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="check-pass-rec" type="checkbox">
                        </div>
                        <script>
                            $('#check-pass-rec').click(function(){
                                if(document.getElementById("rec-pass-edit").type === 'password'){
                                    document.getElementById("rec-pass-edit").type = "text";
                                }else{
                                    document.getElementById("rec-pass-edit").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input type="password" id="rec-pass-edit" name="password" class="form-control">
                </div>
            </div>
            <input type="hidden" id=rec-og-email name="ogEmail" value="">
      </div>
      <div class="modal-footer">
        <!-- <a id=save-changes onclick="saveRecChanges();" class="btn btn-info float-right">Update</a> -->
        <input type="submit" id="update" class="btn btn-dark" value="Update">
        <button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
    <script>
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        $('#recmodal').validate({
            rules:{
                fname: {required:true, alphanumeric:true, maxlength:25},
                minit:{maxlength:1, lettersonly:true},
                lname: {required: true, maxlength:25, alphanumeric:true},
                title: {required:true, alphanumeric: true, maxlength:20},
                email: {required:true, email:true, maxlength:62},
                company: {required:true, alphanumeric: true, maxlength:81},
                password: {required:true, maxlength:40}
            },
            submitHandler: function(e){
                var disabled = $('#recmodal').find(':input:disabled').removeAttr('disabled');
                $.ajax({
                    url: './rec-prof-edits.php',
                    type: 'POST',
                    data: $('#recmodal').serialize(),
                    success: function(response) {
                        console.log(response);
                        alert(response);
                        disabled.attr('disabled','disabled');
                    }            
                });
            }
        });

    </script>
  </div>
</div>
<!-- App Modal -->
<div class="modal fade" id="appModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" id="appmodal">
      <div class="modal-header">
        <h5 class="modal-title" id="appModTitle">Update Applicant Information</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" id="app-fname-edit" name="fname" class="form-control">
            </div>
            <div class="form-group">
                <label>Middle Initial</label>
                <input type="text" id="app-minit-edit" name="minit" class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" id="app-lname-edit" name="lname" class="form-control">
            </div>
            <div class="form-group">
                <label for="ssn">SSN:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="check-ssn-app" type="checkbox">
                        </div>
                        <script>
                            $('#check-ssn-app').click(function(){
                                if(document.getElementById("app-ssn-edit").type === 'password'){
                                    document.getElementById("app-ssn-edit").type = "text";
                                }
                                else{
                                    document.getElementById("app-ssn-edit").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input disabled type="password" id="app-ssn-edit" name="ssn" class="form-control form-group" maxlength=9>
                </div>
            </div>
            <div class="form-group">
                <label>User ID</label>
                <input disabled type="text" id="app-uid-edit" name="uid" class="form-control">
            </div>
            <div class="form-group">
                <label>Type of User</label>
                <input type="text" id="app-type-edit" name="typeUser" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" id="app-email-edit" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" id="app-address-edit" name="address" class="form-control">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input disabled type="text" id="app-username-edit" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                        <input id="check-pass-app" type="checkbox">
                        </div>
                        <script>
                            $('#check-pass-app').click(function(){
                                if(document.getElementById("app-pass-edit").type === 'password'){
                                    document.getElementById("app-pass-edit").type = "text";
                                }else{
                                    document.getElementById("app-pass-edit").type = "password";
                                }
                            });
                        </script>
                    </div>
                    <input type="password" id="app-pass-edit" name="password" class="form-control">
                </div>
            </div>
            <input type="hidden" id="app-og-uid" class= "form-control" value="">
      </div>
      <div class="modal-footer">
        <input type="submit" id="update" class="btn btn-dark" value="Update">
        <!-- <a id=save-changes onclick="saveAppChanges();" class="btn btn-info float-right">Update</a> -->
        <button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
    </form>
    <script>
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        $('#appmodal').validate({
            rules:{
                fname: {required:true, alphanumeric: true, maxlength:25},
                minit:{maxlength:1, lettersonly:true},
                lname: {required: true, alphanumeric:true,  maxlength:25},
                ssn: {required: true, digits:true, maxlength:9, minlength:9},
                typeUser: {required:true},
                email: {required:true, email:true, maxlength:62},
                address: {required: true, maxlength:100},
                username: {required: true, alphanumeric:true, maxlength:20},
                password: {required:true, maxlength:40}
            },
            submitHandler: function(e){
                var disabled = $('#appmodal').find(':input:disabled').removeAttr('disabled');
                $.ajax({
                    url: './fetch-sys.php',
                    type: 'POST',
                    data: $('#appmodal').serialize(),
                    success: function(response) {
                        console.log(response);
                        // if (response == " "){
                        //     alert("Updates Saved");
                        // }
                        // else {
                        //     alert("Updates Saved");
                        // }
                        alert(response);
                        disabled.attr('disabled','disabled');
                    }            
                });
            }
        });

    </script>
  </div>
</div>
<!-- REC NEW -->
<div class="modal fade" id="createRec" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="POST" id="newrec">
      <div class="modal-header">
        <h5 class="modal-title" id="recModTitle">Create Recommender</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" id="rec-fname" name="fname" class="form-control">
            </div>
            <div class="form-group">
                <label>Middle Initial</label>
                <input type="text" id="rec-minit" name="minit" class="form-control">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" id="rec-lname" name="lname" class="form-control">
            </div>
            <div class="form-group">
                <label>Company/Place of Employment</label>
                <input type="text" id="rec-company" name="company" class="form-control">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="rec-title" name="title" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" id="rec-email" name="email" class="form-control">
            </div>
            <input type="hidden" id=rec-og-email name="ogEmail" value="">
      </div>
      <div class="modal-footer">
        <!-- <a id=save-changes onclick="saveRecChanges();" class="btn btn-info float-right">Update</a> -->
        <input type="submit" id="update" class="btn btn-dark" value="Create">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
    <script>
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        $('#newrec').validate({
            rules:{
                fname: {required:true, alphanumeric:true, maxlength:25},
                minit:{maxlength:1, lettersonly:true},
                lname: {required: true, maxlength:25, alphanumeric:true},
                title: {required: true, lettersonly: true, maxlength:20},
                email: {required:true, email:true, maxlength:62},
                company: {required:true, alphanumeric: true, maxlength:81},
            },
            submitHandler: function(e){
                var disabled = $('#newrec').find(':input:disabled').removeAttr('disabled');
                $.ajax({
                    url: './add-rec.php',
                    type: 'POST',
                    data: $('#newrec').serialize(),
                    success: function(response) {
                        // console.log(response);
                        alert(response);
                        disabled.attr('disabled','disabled');
                    }            
                });
            }
        });

    </script>
  </div>
</div>
    <?php 
    // END THE GIANT ELSE AROUND ALL CODE
    }
    ?>
</body>
</html>
