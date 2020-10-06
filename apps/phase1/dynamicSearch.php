<!DOCTYPE html>
<head>

<!-- DYNAMIC SEARCH ON SYS ADMIN -->
        <!-- META DATA -->
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sysad.css" rel="stylesheet">
    <script src="js/sysad.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text&display=swap" rel="stylesheet">
</head>
<body>
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

<?php require_once('../connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if(isset($_POST["query"])) {
        $search = mysqli_real_escape_string($dbc, $_POST["query"]);
        $query = "SELECT * FROM users
                  WHERE
                    fname LIKE '%".$search."%'
                    OR minit LIKE '%".$search."%'
                    OR lname LIKE '%".$search."%'
                    OR UID LIKE '%".$search."%'
                    OR username LIKE '%".$search."%';";
    $result = mysqli_query($dbc, $query);
    if (mysqli_num_rows($result) == 0){ ?>
        <div class="container">
            <br />
            <h5>No matching results found.</h5>
            <p>Please try another search.</p>
        </div>
    <?php }
    else if(mysqli_num_rows($result) > 0) {
    ?>
        <div><br /></div>
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
                            while ($data = mysqli_fetch_array($result)) {
                                // $count++; ?>
                                <tr id="<?php echo $data['UID'] ?>">
                                    <td data-target="lname-edit"><?php echo $data['lname'];?></td>
                                    <td data-target="fname-edit"><?php echo $data['fname'];?></td>
                                    <td data-target="minit-edit"><?php echo $data['minit'];?></td>
                                    <td data-target="uid-edit"><?php echo $data['UID'];?></td>
                                    <?php if ($data['typeUser']== '0') { ?>
                                            <td data-target="type-edit">Applicant</td>
                                        <?php }
                                        else if ($data['typeUser']== '1') { ?>
                                            <td data-target="type-edit">Faculty Reviewer</td>
                                        <?php }
                                        else if ($data['typeUser']== '2') { ?>
                                            <td data-target="type-edit">Chair</td>
                                        <?php }
                                        else if ($data['typeUser'] == '3') { ?>
                                            <td data-target="type-edit">Chair</td>
                                        <?php }
                                        else if ($data['typeUser'] == '4') { ?>
                                            <td data-target="type-edit">System Administrator</td>
                                        <?php } ?>
                                    <td>
                                        <a type="submit" onclick="showRevModal(this);" name="rev-info-btn" id="rev-info-btn" class="btn btn-outline-dark" data-toggle="modal" data-role="update" data-id="<?php echo $data['UID']; ?>">View Profile</a>
                                        <input type="button" id="remove" value="Remove User" class="btn btn-light" onclick="removeUser(<?php echo $data['UID']; ?>)">
                                        <script>
                                            function removeUser(id) {
                                                var uid = id;
                                                console.log("uid: " + uid);
                                                console.log("in remove");
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
                                        <?php if ($data['typeUser'] == 0) { ?>
                                            <br><br><form action="./viewHistory.php" method="POST">
                                                <input type="submit" name="user-app-btn" value="View History" id="user-app-btn" class="btn btn-light" data-id="<?php echo $data['UID']; ?>">
                                                <input type="hidden" name="oguid-all" data-target="og-uid" value="<?php echo $data['UID'];?>"/>
                                            </form>
                                        <?php }?>
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
    }
    else{
        echo '';
    }?>
                

<div class="modal fade" id="searchModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModal">Edit User's Personal Information</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
              <div class="form-group">
                  <label>First Name</label>
                  <input type="text" id="search-fname-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Middle Initial</label>
                  <input type="text" id="search-minit-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" id="search-lname-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>SSN</label>
                  <input type="text" id="search-ssn-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>User ID</label>
                  <input type="text" id="search-uid-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Type of User</label>
                  <input type="text" id="search-type-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Email</label>
                  <input type="text" id="search-email-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Address</label>
                  <input type="text" id="search-address-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Username</label>
                  <input type="text" id="search-username-edit" class="form-control">
              </div>
              <div class="form-group">
                  <label>Password</label>
                  <input type="password" id="search-pass-edit" class="form-control">
                  <input type="checkbox" id="search-show-pass" style="font-size:13px; font-weight:200px;" onclick="showPass('search-pass-edit')"> Show Password
              </div>
              <input type="hidden" id="search-og-uid" class= "form-control" value="">
        </div>
        <div class="modal-footer">
          <a id=save-changes onclick="saveSearchChanges();" class="btn btn-primary pull-right">Update</a>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          
        </div>
      </div>
  </div>

<script>
$(document).ready(function(){


 function showSearchModal(prof){
        var id = $(prof).data('id');
        console.log("id in showModal: "+id);
        id0 = id;
        console.log("id0: "+ id0);
        var fname = $('#'+id).children('td[data-target=search-fname-edit]').text();
        var lname = $('#'+id).children('td[data-target=search-lname-edit]').text();
        var minit = $('#'+id).children('td[data-target=search-minit-edit]').text();
        var uid = $('#'+id).children('td[data-target=search-uid-edit]').text();
        var email = $('#'+id).children('input[data-target=search-email-edit]').val();
        var ssn = $('#'+id).children('input[data-target=search-ssn-edit]').val();
        var username = $('#'+id).children('input[data-target=search-username-edit]').val();
        var password = $('#'+id).children('input[data-target=search-pass-edit]').val();
        var typeUser = $('#'+id).children('td[data-target=search-type-edit]').text();
        var address = $('#'+id).children('input[data-target=search-address-edit]').val();
        var ogUID = $('#'+id).children('input[data-target=search-og-uid]').val();

        if (typeUser == '0') {
            typeUser = "Applicant";
        }
        if (typeUser == '1') {
            typeUser = "Faculty Reviewer";
        }
        if (typeUser == '2') {
            typeUser = "Chair";
        }
        if (typeUser == '3') {
            typeUser = "Grad Secretary";
        }

        $('#search-fname-edit').val(fname);
        $('#search-lname-edit').val(lname);
        $('#search-minit-edit').val(minit);
        $('#search-uid-edit').val(uid);
        $('#search-email-edit').val(email);
        $('#search-ssn-edit').val(ssn);
        $('#search-username-edit').val(username);
        $('#search-pass-edit').val(password);
        $('#search-type-edit').val(typeUser);
        $('#search-address-edit').val(address);
        $('#search-og-uid').val(ogUID);
        $('#searchModal').modal('toggle');
};

});
</script>

  </body>
  </html>