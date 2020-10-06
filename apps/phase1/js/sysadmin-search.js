// JS and JQUERY FOR SYSADMIN SEARCH MODAL POPUPS 

function showAllModal(prof){
    var id = $(prof).data('id');
    console.log("id in showModal: "+id);
    id0 = id;
    console.log("id0: "+ id0);
    var fname = $('#'+id).children('td[data-target=fname-edit]').text();
    var lname = $('#'+id).children('td[data-target=lname-edit]').text();
    var minit = $('#'+id).children('td[data-target=minit-edit]').text();
    var uid = $('#'+id).children('td[data-target=uid-edit]').text();
    // var OGuid = $('#'+id).children('td[data-target=uid-edit]').text();
    var email = $('#'+id).children('input[data-target=email-edit]').val();
    var ssn = $('#'+id).children('input[data-target=ssn-edit]').val();
    var username = $('#'+id).children('input[data-target=username-edit]').val();
    var password = $('#'+id).children('input[data-target=pass-edit]').val();
    var typeUser = $('#'+id).children('td[data-target=type-edit]').text();
    var address = $('#'+id).children('input[data-target=address-edit]').val();
    var ogUID = $('#'+id).children('input[data-target=og-uid]').val();

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

    $('#fname-edit').val(fname);
    $('#lname-edit').val(lname);
    $('#minit-edit').val(minit);
    $('#uid-edit').val(uid);
    $('#email-edit').val(email);
    $('#ssn-edit').val(ssn);
    $('#username-edit').val(username);
    $('#pass-edit').val(password);
    $('#type-edit').val(typeUser);
    $('#address-edit').val(address);
    $('#og-uid').val(ogUID);
    // originalUID = OGuid;
    $('#searchModal').modal('toggle');
// })
};
function saveSearchChanges (prof) {
    // var id = id0;
    console.log("id in save changes: "+id0);
    var fname = $('#fname-edit').val();
    var minit = $('#minit-edit').val();
    var lname = $('#lname-edit').val();
    var uid = $('#uid-edit').val();
    var email = $('#email-edit').val();
    var ssn = $('#ssn-edit').val();
    var username = $('#username-edit').val();
    var password = $('#pass-edit').val();
    var typeUser = $('#type-edit').val();
    console.log("typeUser: " + typeUser);
    var address = $('#address-edit').val();
    var ogUID = $('#og-uid').val();
    console.log("ogUID: " + ogUID);
    // var oldUID = originalUID;

    var searchModal = document.getElementById('searchModal');
    alert('saved!');
    $.ajax({
        type: 'POST',
        
        // dataType: "php",
        data: {fname:fname, minit:minit, lname:lname, uid:uid, email:email, ssn:ssn, username:username, password:password, typeUser:typeUser, address:address, ogUID:ogUID},
        // dataType: "php",
        url: './fetch-sys.php',
        success: function(response){
            // var data = response;
            console.log("response: " + response);
            if (response == '1') {
                console.log("successfully updated user data");
                // console.log("id0: " + id0);
                $('#'+id0).children('td[data-target=fname-edit]').text(fname);
                $('#'+id0).children('td[data-target=lname-edit]').text(lname);
                $('#'+id0).children('td[data-target=minit-edit]').text(minit);
                $('#'+id0).children('td[data-target=uid-edit]').text(uid);
                $('#'+id0).children('input[data-target=email-edit]').val(email);
                $('#'+id0).children('input[data-target=ssn-edit]').val(ssn);
                $('#'+id0).children('input[data-target=username-edit]').val(username);
                $('#'+id0).children('input[data-target=pass-edit]').val(password);
                $('#'+id0).children('td[data-target=type-edit]').text(typeUser);
                $('#'+id0).children('input[data-target=address-edit]').val(address);
                $('#searchModal').modal('toggle');
                searchModal.style.display = "none";
            }
            else if (response == '0'){
                console.log($fname);
                console.log('Something went wrong!');
            }
            
        },
        error: function() {
            alert('There was some error performing the AJAX call!');
          }
    })
};