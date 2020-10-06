$(function() {
    // FUNCTIONING VALIDATE APPLICATION.PHP ON SUBMIT
    
    // document.getElementsByName("submit").onclick() = function ({
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w -]+$/i.test(value);
        }, "Letters, numbers, and underscores only please");
        jQuery.validator.addMethod("dateFormat",
            function(value, element) {
                var date = value.split("/");
                if (parseInt(date[1]) > 0 && parseInt(date[1]) <= 30 && parseInt(date[0]) > 0 && (parseInt(date[0]) == 4 || parseInt(date[0]) == 6 || parseInt(date[0]) == 9 || parseInt(date[0]) == 11) && parseInt(date[2]) <= 2020){
                    return this.optional(element) || true;
                }
                else if (parseInt(date[1]) > 0 && parseInt(date[1]) <= 31 && parseInt(date[0]) > 0 && (parseInt(date[0]) == 1 || parseInt(date[0]) == 3 || parseInt(date[0]) == 5 || parseInt(date[0]) == 7 || parseInt(date[0]) == 8 || parseInt(date[0]) == 10 || parseInt(date[0]) == 12) && parseInt(date[2]) <= 2020) {
                    return this.optional(element) || true;
                }
                else if (parseInt(date[1]) > 0 && parseInt(date[1]) <=29 && (parseInt(date[0]) == 2) && ((parseInt(data[2])% 4) == 0) && parseInt(data[2])<= 2020){
                    return this.optional(element) || true;
                }
                else if (parseInt(date[1]) > 0 && parseInt(date[1]) <=28 && (parseInt(date[0]) == 2) && ((parseInt(data[2])% 4) != 0) && parseInt(data[2]) <= 2020){
                    return this.optional(element) || true;
                }
                return this.optional(element) || false;
            },
            "Please enter a valid date (MM/DD/YYYY)"
        );
        
        $('#app').validate({
            rules:{
                appDegree: {required:true},
                interests: {required: true},
                work: {required:true},
                admitDate: {required:true},
                title:{required:true, lettersonly:true},
                firstN:{required:true, lettersonly:true},
                mid: {lettersonly:true, maxlength:1},
                lastN:{required:true, lettersonly:true},
                recemail:{required:true, email:true},
                company:{required:true, maxlength:81},
                verbal:{
                    required: function (element) {
                        if ($("#appDegree option:selected").text() != "PhD" && $("#GREdate").val().length == 0 && $("#quant").val().length == 0 && $("#total").val().length == 0){
                            // check = false;
                            return false;
                        }
                    },
                    digits:true,
                    min:130,
                    max:170
                },
                quant:{
                    required: function (element) {
                        if ($("#appDegree option:selected").text() != "PhD" && $("#verbal").val().length == 0 && $("#GREdate").val().length == 0 && $("#total").val().length == 0){
                            // check = false;
                            return false;
                        }
                    },
                    digits:true,
                    min:130,
                    max:170
                },
                total: {
                    required: function (element) {
                        if ($("#appDegree option:selected").text() != "PhD" && $("#verbal").val().length == 0 && $("#quant").val().length == 0 && $("#GREdate").val().length == 0){
                            // check = false;
                            return false;
                        }
                    },
                    digits:true,
                    min: 260,
                    max: 340
                },
                GREdate: {
                    required: function (element) {
                        if ($("#appDegree option:selected").text() != "PhD" && $("#verbal").val().length == 0 && $("#quant").val().length == 0 && $("#total").val().length == 0){
                            // check = false;
                            return false;
                        }
                    },
                    maxlength:10,
                    dateFormat: function (element) {
                        if ($("#appDegree option:selected").text() != "PhD" || ( $("#verbal").val().length == 0 && $("#quant").val().length == 0 && $("#total").val().length == 0)){
                            // check = false;
                            return false;
                        }
                        else {
                            return true;
                        }
                    },
                },
                subject:{
                    required: function(element){
                        if ($("#subjectScore").val() == "" && $("#subjectDate").val() == "" ){
                            return false;
                        }
                    },
                    alphanumeric:true
                },
                subjectScore:{
                    required: function(element){
                        if ($("#subject").val() == "" && $("#subjectDate").val() == "" ){
                            return false;
                        }
                    },
                    digits:true,
                    min:200,
                    max:990
                },
                subjectDate:{
                    required: function(element){
                        // if (document.getElementsByName("subject").value != ""){
                        //     return "";
                        // }
                        if ($("#subject").val() == "" && $("#subjectScore").val() == ""){
                            return false;
                        }
                    },
                    maxlength:10,
                    dateFormat:true,
                },
                subject2:{
                    required: function(element){
                        if ($("#subjectScore2").val() == "" && $("#subjectDate2").val() == ""){
                            return false;
                        }
                        // return true;
                    },
                    alphanumeric:true
                },
                subjectScore2:{
                    required: function(element){
                        if ($("#subject2").val() == "" && $("#subjectDate2").val() == "" ){
                            return false;
                        }
                    },
                    digits:true,
                    min:200,
                    max:990
                },
                subjectDate2:{
                    required: function(element){

                        if ($("#subject2").val() == "" && $("#subjectScore2").val() == ""){
                            return false;
                        }
                    },
                    maxlength:10,
                    dateFormat:true,
                },
                subject3:{
                    required: function(element){
                        if ($("#subjectScore3").val() == "" && $("#subjectDate3").val() == "" ){
                            return false;
                        }
                    },
                    alphanumeric:true
                },
                subjectScore3:{
                    required: function(element){
                        if ($("#subject3").val() == "" && $("#subjectDate3").val() == "" ){
                            return false;
                        }
                    },
                    digits:true,
                    min:200,
                    max:990
                },
                subjectDate3:{
                    required: function(element){
                        // if (document.getElementsByName("subject").value != ""){
                        //     return "";
                        // }
                        if ($("#subject3").val() == "" && $("#subjectScore3").val() == ""){
                            return false;
                        }
                    },
                    maxlength:10,
                    dateFormat:true,
                },
                TOEFLscore:{
                    required: function(element){
                        // if ($("#appDegree option:selected").text() != "PhD"){
                        //     return "";
                        // }
                        if ($("#TOEFLdate").val() == ""){
                            return false;
                        }
                    },
                    digits:true,
                    max:120,
                },
                TOEFLdate:{
                    required: function(element){
                        if ($("#TOEFLscore").val() == ""){
                            return false;
                        }
                    },
                    maxlength:10,
                    dateFormat: true
                },
                Btype: {required: true},
                Buniversity:{required: true, alphanumeric:true},
                ByearDegree:{required: true, digits:true, maxlength:4, minlength:4, min:1980, max:2021},
                Bmajor:{required: true, alphanumeric:true},
                BGPA:{required: true, number:true, max:4.0},
                Mtype: {
                    required: function(element){
                        if ($("#Muniversity").val() == "" && $("#MyearDegree").val() == "" && $("#Mmajor").val() == "" && $("#MGPA").val() == ""){
                            return false;
                        }
                    },
                },
                Muniversity:{
                    required: function(element){      
                        if ($("#priorD option:selected").text() != "PhD" && $("#priorD option:selected").text() != "MS" && $("#MyearDegree").val() == "" && $("#Mmajor").val() == "" && $("#MGPA").val() == ""){
                            return false;
                        }
                    },
                    alphanumeric:true
                },
                MyearDegree:{
                    required: function(element){
                        // console.log($("#priorD option:selected").val())
                        if ($("#priorD option:selected").text() != "PhD" && $("#priorD option:selected").text() != "MS" && $("#Muniversity").val() == "" && $("#Mmajor").val() == "" && $("#MGPA").val() == ""){
                            return false;
                        }
                    }, 
                    digits:true, 
                    maxlength:4, 
                    minlength:4, 
                    min:1980, 
                    max:2021
                },
                Mmajor:{
                    required: function(element){
                        if ($("#priorD option:selected").text() != "PhD" && $("#priorD option:selected").text() != "MS" && $("#MyearDegree").val() == "" && $("#Muniversity").val() == "" && $("#MGPA").val() == ""){
                            return false;
                        }
                    }, 
                    alphanumeric:true
                },
                MGPA:{
                    required: function(element){
                        if ($("#priorD option:selected").text() != "PhD" && $("#priorD option:selected").text() != "MS" && $("#MyearDegree").val() == "" && $("#Mmajor").val() == "" && $("#Muniversity").val() == ""){
                            return false;
                        }
                    },  
                    number:true,
                    max:4.0
                }
    
            },
            messages:{
                verbal:{min: "Please enter a valid score between 130 and 170", max: "Please enter a valid score between 130 and 170"},
                quant: {min: "Please enter a valid score between 130 and 170", max: "Please enter a valid score between 130 and 170"},
                total: {min: "Please enter a valid score between 260 and 340", max: "Please enter a valid score between 260 and 340"},
                subjectScore: {min: "Please enter a valid score between 200 and 990", max: "Please enter a valid score between 200 and 990"},
                TOEFLscore: {min: "Please enter a valid score between 0 and 120", max:"Please enter a valid score between 0 and 120"},
                BGPA: {min: "Please enter a valid GPA (0 - 4.0)", max: "Please enter a valid GPA (0 - 4.0)"},
                MGPA: {min: "Please enter a valid GPA (0 - 4.0)", max: "Please enter a valid GPA (0 - 4.0)"},
                ByearDegree: {min: "Please enter a graduation year between 1980 and 2020", max:"Please enter a graduation year between 1980 and 2020"},
                MyearDegree: {min: "Please enter a graduation year between 1980 and 2020", max:"Please enter a graduation year between 1980 and 2020"},
            },
            errorPlacement: function(error, element) {
                //Custom position: first name
                if (element.attr("name") == "appDegree" ) {
                    // alert(error);
                    $("span#appDegree-err").text($(error).text());
                }
                //Custom position: second name
                if (element.attr("name") == "interests" ) {
                    $("#interests-err").text($(error).text());
                }
                if (element.attr("name") == "work" ) {
                    // alert(error);
                    $("span#work-err").text($(error).text());
                }
                //Custom position: second name
                if (element.attr("name") == "admitDate" ) {
                    $("#admitDate-err").text($(error).text());
                }
                if (element.attr("name") == "title" ) {
                    // alert(error);
                    $("span#title-err").text($(error).text());
                }
                //Custom position: second name
                if (element.attr("name") == "firstN" ) {
                    $("#firstN-err").text($(error).text());
                }
                if (element.attr("name") == "mid" ) {
                    // alert(error);
                    $("span#mid-err").text($(error).text());
                }
                //Custom position: second name
                if (element.attr("name") == "lastN" ) {
                    $("#lastN-err").text($(error).text());
                }
                if (element.attr("name") == "recemail" ) {
                    $("#recemail-err").text($(error).text());
                }
                if (element.attr("name") == "company" ) {
                    $("#company-err").text($(error).text());
                }
                if (element.attr("name") == "verbal" ) {
                    $("#verbal-err").text($(error).text());
                }
                if (element.attr("name") == "quant" ) {
                    $("#quant-err").text($(error).text());
                }
                if (element.attr("name") == "total" ) {
                    $("#total-err").text($(error).text());
                }
                if (element.attr("name") == "GREdate" ) {
                    $("#GREdate-err").text($(error).text());
                }
                if (element.attr("name") == "subject" ) {
                    $("#subject-err").text($(error).text());
                }
                if (element.attr("name") == "subjectScore" ) {
                    $("#subjectScore-err").text($(error).text());
                }
                if (element.attr("name") == "subjectDate" ) {
                    $("#subjectDate-err").text($(error).text());
                }
                if (element.attr("name") == "subject2" ) {
                    $("#subject2-err").text($(error).text());
                }
                if (element.attr("name") == "subjectScore2" ) {
                    $("#subjectScore2-err").text($(error).text());
                }
                if (element.attr("name") == "subjectDate2" ) {
                    $("#subjectDate2-err").text($(error).text());
                }
                if (element.attr("name") == "subject3" ) {
                    $("#subject3-err").text($(error).text());
                }
                if (element.attr("name") == "subjectScore3" ) {
                    $("#subjectScore3-err").text($(error).text());
                }
                if (element.attr("name") == "subjectDate3" ) {
                    $("#subjectDate3-err").text($(error).text());
                }
                if (element.attr("name") == "TOEFLscore" ) {
                    $("#TOEFLscore-err").text($(error).text());
                }
                if (element.attr("name") == "TOEFLdate" ) {
                    $("#TOEFLdate-err").text($(error).text());
                }
                if (element.attr("name") == "Btype" ) {
                    $("#Btype-err").text($(error).text());
                }
                if (element.attr("name") == "Buniversity" ) {
                    $("#Buniversity-err").text($(error).text());
                }
                if (element.attr("name") == "ByearDegree" ) {
                    $("#ByearDegree-err").text($(error).text());
                }
                if (element.attr("name") == "Bmajor" ) {
                    $("#Bmajor-err").text($(error).text());
                }
                if (element.attr("name") == "BGPA" ) {
                    $("#BGPA-err").text($(error).text());
                }
                if (element.attr("name") == "Mtype" ) {
                    $("#Mtype-err").text($(error).text());
                }
                if (element.attr("name") == "Muniversity" ) {
                    $("#Muniversity-err").text($(error).text());
                }
                if (element.attr("name") == "MyearDegree" ) {
                    $("#MyearDegree-err").text($(error).text());
                }
                if (element.attr("name") == "Mmajor" ) {
                    $("#Mmajor-err").text($(error).text());
                }
                if (element.attr("name") == "MGPA" ) {
                    $("#MGPA-err").text($(error).text());
                }
    
            },
            success: function(label,element) {
                $("span .error").html('');
             },

        });
        
        $("#save").on('click', function () {
            $(document.getElementsByName("appDegree")).rules('remove');
            $(document.getElementsByName("interests")).rules('remove');
            $(document.getElementsByName("work")).rules('remove');
            $(document.getElementsByName("admitDate")).rules('remove');
            $(document.getElementsByName("title")).rules('remove', "required");
            $(document.getElementsByName("firstN")).rules('remove', 'required');
            $(document.getElementsByName("lastN")).rules('remove', 'required');
            $(document.getElementsByName("recemail")).rules('remove', 'required');
            $(document.getElementsByName("company")).rules('remove', 'required');
            $(document.getElementsByName("verbal")).rules('remove', 'required');
            $(document.getElementsByName("quant")).rules('remove', 'required');
            $(document.getElementsByName("total")).rules('remove', 'required');
            $(document.getElementsByName("GREdate")).rules('remove', 'required');
            $(document.getElementsByName("subject")).rules('remove', 'required');
            $(document.getElementsByName("subjectScore")).rules('remove', 'required');
            $(document.getElementsByName("subjectDate")).rules('remove', 'required');
            $(document.getElementsByName("subject2")).rules('remove', 'required');
            $(document.getElementsByName("subjectScore2")).rules('remove', 'required');
            $(document.getElementsByName("subjectDate2")).rules('remove', 'required');
            $(document.getElementsByName("subject3")).rules('remove', 'required');
            $(document.getElementsByName("subjectScore3")).rules('remove', 'required');
            $(document.getElementsByName("subjectDate3")).rules('remove', 'required');
            $(document.getElementsByName("TOEFLscore")).rules('remove', 'required');
            $(document.getElementsByName("TOEFLdate")).rules('remove', 'required');
            $(document.getElementsByName("Btype")).rules('remove', 'required');
            $(document.getElementsByName("Buniversity")).rules('remove', 'required');
            $(document.getElementsByName("ByearDegree")).rules('remove', 'required');
            $(document.getElementsByName("Bmajor")).rules('remove', 'required');
            $(document.getElementsByName("BGPA")).rules('remove');
            $(document.getElementsByName("Mtype")).rules('remove', 'required');
            $(document.getElementsByName("Muniversity")).rules('remove', 'required');
            $(document.getElementsByName("MyearDegree")).rules('remove', 'required');
            $(document.getElementsByName("Mmajor")).rules('remove', 'required');
            $(document.getElementsByName("MGPA")).rules('remove');
            // $("#app").validate();
            $("#app").valid();
            $.ajax({
                url: '../phase1/save-app.php',
                method:"post",
                data: $('#app').serialize(),
                success: function(response) {
                   // $('#app').submit();
                   console.log(response);
                   alert("Your application has been saved");
                }
            })
            // alert("Your application has been saved");
            console.log("in save");
        });
    //}
    
})
