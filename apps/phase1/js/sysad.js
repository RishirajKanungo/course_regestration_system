/******** 
 * MAIN JAVASCRIPT FILE FOR SYSAD.PHP
 * DOES NOT INCLUDE SEARCH MODALS
 * INCLUDES SEARCH FUNCTIONALITY JS
**********/ 


var id0;
var originalUID;
function navSticky() {
    $('.nav-tabs').stickyTabs();
};
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
        $('#all-revModal').modal('toggle');
    // })
};

function createModal() {
    $('#createModal').modal('toggle');
}
function showAppModal(prof){
    var id = $(prof).data('id');
    console.log("id in showModal: "+id);
    id0 = id;
    console.log("id0: "+ id0);
    var fname = $('#'+id).children('td[data-target=app-fname-edit]').text();
    console.log(fname);
    var lname = $('#'+id).children('td[data-target=app-lname-edit]').text();
    var minit = $('#'+id).children('td[data-target=app-minit-edit]').text();
    var uid = $('#'+id).children('td[data-target=app-uid-edit]').text();
    // var OGuid = $('#'+id).children('td[data-target=uid-edit]').text();
    var email = $('#'+id).children('input[data-target=app-email-edit]').val();
    var ssn = $('#'+id).children('input[data-target=app-ssn-edit]').val();
    var username = $('#'+id).children('td[data-target=app-username-edit]').text();
    var password = $('#'+id).children('input[data-target=app-pass-edit]').val();
    var typeUser = $('#'+id).children('input[data-target=app-type-edit]').val();
    var address = $('#'+id).children('input[data-target=app-address-edit]').val();
    var ogUID = $('#'+id).children('input[data-target=app-og-uid]').val();

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

    $('#app-fname-edit').val(fname);
    $('#app-lname-edit').val(lname);
    $('#app-minit-edit').val(minit);
    $('#app-uid-edit').val(uid);
    $('#app-email-edit').val(email);
    $('#app-ssn-edit').val(ssn);
    $('#app-username-edit').val(username);
    $('#app-pass-edit').val(password);
    $('#app-type-edit').val(typeUser);
    $('#app-address-edit').val(address);
    $('#app-og-uid').val(ogUID);
    // originalUID = OGuid;
    $('#appModal').modal('toggle');
// })
};

function showRevModal(prof){
    var id = $(prof).data('id');
    console.log("id in showModal: "+id);
    id0 = id;
    console.log("id0: "+ id0);
    var fname = $('#'+id).children('td[data-target=fname-edit]').text();
    var lname = $('#'+id).children('td[data-target=lname-edit]').text();
    var minit = $('#'+id).children('td[data-target=minit-edit]').text();
    var email = $('#'+id).children('input[data-target=email-edit]').val();
    var uid = $('#'+id).children('td[data-target=uid-edit]').text();
    var ssn = $('#'+id).children('input[data-target=ssn-edit]').val();
    var username = $('#'+id).children('input[data-target=username-edit]').val();
    var password = $('#'+id).children('input[data-target=pass-edit]').val();
    var address = $('#'+id).children('input[data-target=address-edit]').val();
    var typeUser = $('#'+id).children('td[data-target=type-edit]').text();
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
    $('#ssn-edit').val(ssn);
    $('#address-edit').val(address);
    $('#type-edit').val(typeUser);
    $('#email-edit').val(email);
    $('#username-edit').val(username);
    $('#pass-edit').val(password);
    $('#og-uid').val(ogUID);
    $('#all-revModal').modal('toggle');
// })
}
function showRecModal(prof){
    var id = $(prof).data('id');
    console.log("id in showModal: "+id);
    id0 = id;
    console.log("id0: "+ id0);
    var fname = $('#'+id).children('td[data-target=rec-fname-edit]').text();
    var lname = $('#'+id).children('td[data-target=rec-lname-edit]').text();
    var minit = $('#'+id).children('td[data-target=rec-minit-edit]').text();
    var email = $('#'+id).children('td[data-target=rec-email-edit]').text();
    var title = $('#'+id).children('input[data-target=rec-title-edit]').val();
    var password = $('#'+id).children('input[data-target=rec-pass-edit]').val();
    var company = $('#'+id).children('input[data-target=rec-company-edit]').val();
    var ogEmail = $('#'+id).children('input[data-target=rec-og-email]').val();

    $('#rec-fname-edit').val(fname);
    $('#rec-lname-edit').val(lname);
    $('#rec-minit-edit').val(minit);
    $('#rec-title-edit').val(title);
    $('#rec-company-edit').val(company);
    $('#rec-email-edit').val(email);
    $('#rec-pass-edit').val(password);
    $('#rec-og-email').val(ogEmail);
    $('#recModal').modal('toggle');
// })
};


// saves changes fro all and revs 
function saveChanges (prof) {
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
                $('#all-revModal').modal('toggle');
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

//save changes for app modal 
function saveAppChanges (prof) {
    // var id = id0;
    console.log("id in save changes: "+id0);
    var fname = $('#app-fname-edit').val();
    var minit = $('#app-minit-edit').val();
    var lname = $('#app-lname-edit').val();
    var uid = $('#app-uid-edit').val();
    var email = $('#app-email-edit').val();
    var ssn = $('#app-ssn-edit').val();
    var username = $('#app-username-edit').val();
    var password = $('#app-pass-edit').val();
    var typeUser = $('#app-type-edit').val();
    console.log("typeUser: " + typeUser);
    var address = $('#app-address-edit').val();
    var ogUID = $('#app-og-uid').val();
    console.log("ogUID: " + ogUID);
    // var oldUID = originalUID;

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
                $('#'+id).children('td[data-target=app-fname-edit]').text(fname);
                $('#'+id).children('td[data-target=app-lname-edit]').text(lname);
                $('#'+id).children('td[data-target=app-minit-edit]').text(minit);
                $('#'+id).children('td[data-target=app-uid-edit]').text(uid);
                $('#'+id).children('input[data-target=app-email-edit]').val(email);
                $('#'+id).children('input[data-target=app-ssn-edit]').val(ssn);
                $('#'+id).children('td[data-target=app-username-edit]').text(username);
                $('#'+id).children('input[data-target=app-pass-edit]').val(password);
                $('#'+id).children('input[data-target=app-type-edit]').val(typeUser);
                $('#'+id).children('input[data-target=app-address-edit]').val(address);
                $('#appModal').modal('toggle');
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
}
// saves changes for recs
function saveRecChanges() {
    var fname = $('#rec-fname-edit').val();
    var minit = $('#rec-minit-edit').val();
    var lname = $('#rec-lname-edit').val();
    var email = $('#rec-email-edit').val();
    var title = $('#rec-title-edit').val();
    var company = $('#rec-company-edit').val();
    var password = $('#rec-pass-edit').val();
    var ogEmail = $('#rec-og-email').val();
    console.log("rec data saved");
    $.ajax({
        type:'POST',
        data: {fname:fname, minit:minit, lname:lname, email:email,title:title, password:password, ogEmail:ogEmail},
        url: './rec-prof-edits.php',
        success: function(response) {
            console.log("response: " + response);
            if (response == '0') {
                console.log("rec profile unable to update");
            }
            else if (response == '1'){
                console.log("rec table updated")
                $('#'+id0).children('td[data-target=rec-fname-edit]').text(fname);
                $('#'+id0).children('td[data-target=rec-lname-edit]').text(lname);
                $('#'+id0).children('td[data-target=rec-minit-edit]').text(minit);
                $('#'+id0).children('td[data-target=rec-email-edit]').text(email);
                $('#'+id0).children('input[data-target=rec-pass-edit]').text(password);
                $('#'+id0).children('input[data-target=rec-company-edit]').text(company);
                $('#'+id0).children('input[data-target=rec-title-edit]').text(title);
                $('#recModal').modal('toggle');
            }
        },
        error: function() {
            alert("Something went wrong with the ajax call in rec");
        }
    })
}
function showPass(id) {
    // var elID = id
    console.log(id);
    if (id == 'pass-edit') {
        var x = document.getElementById('pass-edit');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        } 
    }
    else if (id == 'app-pass-edit') {
        var x = document.getElementById('rec-pass-edit');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    else if (id == 'rec-pass-edit') {
        var x = document.getElementById('rec-pass-edit');
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        } 
    }
};

// // $(document).ready(function(){
function search(){
load_data();
function load_data(query){
  $.ajax({
   url:"./dynamicSearch.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
}
$('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
 };

//  $('.toggle-password').on('click', function() {
//     $(this).toggleClass('fa-eye fa-eye-slash');
//     let input = $($(this).attr('toggle'));
//     if (input.attr('type') == 'password') {
//       input.attr('type', 'text');
//     }
//     else {
//       input.attr('type', 'password');
//     }
//   });
//   $("#input").on('click', function() {
//     $(this).toggleClass("fa-eye fa-eye-slash");
//     var input = $("#password");
//     if (input.attr("type") === "password") {
//       input.attr("type", "text");
//     } 
//     else {
//       input.attr("type", "password");
//     }
//  });
