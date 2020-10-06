$(function() {
    $("form[name='letter']").validate({
      // validation rules
      rules: {
        recLetter: {
          required: true,
          minlength: 50,
          maxlength: 2500
        },
      },
      //error message
      messages: {
        recLetter: "Please enter between 50-2500 characters (without spaces)",
      },
      // submitHandler: function(form) {
      //   form.submit();
      // }
    });
    
})
$('#save').on('submit', function() {
  $(document.getElementsByName("recLetter")).rules('remove');
  $('#letter').validate();
  console.log("save");
})


