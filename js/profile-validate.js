function profileValidate() {

    $('#update-profile').validate({
        rules: {
            fname: {
                required: true,
                maxlength: 25,
                lettersonly: true,
            },
            minit: {
                length: 1,
                lettersonly: true
            },
            lname: {
                required: true,
                maxlength: 25,
                lettersonly: true
            },
            username: {
                required: true,

            },
            password: {
                required: true,
                maxlength: 40
            },
            ssn: {
                required: true,
                digits: true,
                length: 9
            },
            address: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            }
        }
    });
    $('#update-profile').submit(function () {
        if($(this).valid()) {
           alert('the form is valid');

        }
        if ($(this).invalid()) {
            alert("Some of the information entered is invalid. Please try again.");
            $("#update-profile").validate()
        }
    });
}