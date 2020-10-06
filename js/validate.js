// HOME PAGE SIGN UP AND LOGIN VALIDATION
$(function() {
    
$.validator.setDefaults({
    focusCleanup: true,
    focusInvalid: false,
    errorClass: 'help-block',
    highlight: function(element){
        $(element)
            .closest('.form-group')
            .addClass('has-error');
    },
    unhighlight: function(element){
        $(element)
            .closest('.form-group')
            .removeClass('has-error');
    }
});

        $("#signup-form").validate({
            
            rules: {
                fname: {
                    required: true,
                    lettersonly: true,
                    notEqual: true,
                },
                minit: {
                    // required: false,
                    lettersonly: true,
                    maxlength:1,
                    minlength:1
                },
                lname: {
                    required: true,
                    lettersonly: true,
                },
                ssn: {
                    required: true,
                    maxlength: 9,
                    minlength: 9,
                    digits: true
                },
                address: {
                    required: true
                },
                email:{
                    required: true,
                    email: true
                },
                username:{
                    required: true,
                    maxlength: 20,
                    minlength: 1
                    // alphanum: true
                },
                password:{
                    required: true,
                    maxlength: 40,
                    minlength: 1,
                },
                cpass:{
                    required: true,
                    maxlength: 40,
                    minlength: 1,
                    // maxlength:40,
                    equalTo: "#password"
                }
            },
            messages: {
                fname:{
                    lettersonly:"Alphabetic characters only please",
                    notEqual: "done"
                },
                lname:{
                    lettersonly:"Alphabetic characters only please"
                },
                minit:{
                    lettersonly:"Alphabetic characters only please"
                },
                ssn: {
                    required: "This field is required",
                    maxlength: "Please enter 9 digits",
                    minlength: "Please enter 9 digits",
                    digits: "Numeric digits only. Please do not include dashes"
                },
                email: {
                    email: "Please enter a valid email"
                },
                username:{

                },
                password: {
                    
                },
                cpass:{
                    equalTo: "Password does not match"
                }
            },
            // errorElement : 'p',
            // errorLabelContainer: '.error',
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
                    $("#user-err").text($(error).text());
                }
                if (element.attr("name") == "password" ) {
                    $("#pass-err").text($(error).text());
                }
                if (element.attr("name") == "cpass" ) {
                    $("#cpass-err").text($(error).text());
                }

            }
        });

        $('#signup-form').submit(function () {
            // if($(this).valid()) {
            //    alert('the form is valid');

            // }
            if ($(this).invalid()) {
                alert("Some of the information entered is invalid. Please try again.");
                $("#signup-form").validate()
            }
        });
    // });
    
    // $("#login-log").click(function(){
        $("#login-form").validate({
            rules:{
                user:{
                    required: true,
                },
                pass:{
                    required:true
                }
            },
            messages:{
                user:{
                    // required: "please enter your username"
                    // preventDefault()
                },
                pass: {
                    // required: "please enter your password"
                }
            },
            errorPlacement: function(error, element) {
                //Custom position: first name
                if (element.attr("name") == "user" ) {
                    // alert(error);
                    $("span#username-err").text($(error).text());
                }
                if (element.attr("name") == "pass" ) {
                    // alert(error);
                    $("span#password-err").text($(error).text());
                }
            }
        });
    // });
    $('#login-form').submit(function () {
        // if($(this).valid()) {
        //     alert('the form is valid');

        // }
        if ($(this).invalid()) {
            alert("Some of the inputs you've entered are invalid. Please try again.");
            $("#login-form").validate()
        }
    });
});
