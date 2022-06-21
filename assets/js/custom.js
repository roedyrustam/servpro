var csrf_token=$('#csrf_token').val();
$(document).ready(function(){
  	function timeToInt(time) {
    var arr = time.match(/^(0?[1-9]|1[012]):([0-5][0-9])([APap][mM])$/);
    if (arr == null) return -1;

    if (arr[3].toUpperCase() == 'PM') {
      arr[1] = parseInt(arr[1]) + 12;
    }
    return parseInt(arr[1]*100) + parseInt(arr[2]);
  }

    $('.daysfromtime_check, .daystotime_check').on('change', '', function (e) {
        $('.eachdayfromtime1').val("");$('.eachdaytotime1').val("");
        $('.eachdayfromtime2').val("");$('.eachdaytotime2').val("");
        $('.eachdayfromtime3').val("");$('.eachdaytotime3').val("");
        $('.eachdayfromtime4').val("");$('.eachdaytotime4').val("");
        $('.eachdayfromtime5').val("");$('.eachdaytotime5').val("");
        $('.eachdayfromtime6').val("");$('.eachdaytotime6').val("");
        $('.eachdayfromtime7').val("");$('.eachdaytotime7').val("");
    });

    $('.daystotime_check').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.daysfromtime_check').val();

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        if(start_time > end_time) {
          $('.daystotime_check').val("");
          $(".daystotime_check").css("border-color", "red");
          return false;
        }else{
          $(".daystotime_check").css("border", "1px solid #ddd");
          return true;
        }
    });

    $('.eachdaytotime1').on('change', '', function (e) {
        $daystotime = (this.value);
        $daysfromtime = $('.eachdayfromtime1').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");
        
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

          if(start_time > end_time){
            $('.eachdaytotime1').val("");
            $(".eachdaytotime1").css("border-color", "red");
            return false;
          } else{
            $(".eachdaytotime1").css("border", "1px solid #ddd");
            return true;
          }
    });

    $('.eachdaytotime2').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime2').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        //if($daysfromtime > $daystotime){
        if(start_time > end_time) {
            $('.eachdaytotime2').val("");
            $(".eachdaytotime2").css("border-color", "red");
            return false;
        } else {
            $(".eachdaytotime2").css("border", "1px solid #ddd");
            return true;
        }
    });

    $('.eachdaytotime3').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime3').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        //if($daysfromtime > $daystotime){
        if(start_time > end_time) {
            $('.eachdaytotime3').val("");
            $(".eachdaytotime3").css("border-color", "red");
            return false;
        } else {
            $(".eachdaytotime3").css("border", "1px solid #ddd");
            return true;
        }
    });

    $('.eachdaytotime4').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime4').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        //if($daysfromtime > $daystotime){
        if(start_time > end_time) {
            $('.eachdaytotime4').val("");
            $(".eachdaytotime4").css("border-color", "red");
            return false;
        }else{
            $(".eachdaytotime4").css("border", "1px solid #ddd");
            return true;
        }
    });

    $('.eachdaytotime5').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime5').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        //if($daysfromtime > $daystotime){
        if(start_time > end_time) {
            $('.eachdaytotime5').val("");
            $(".eachdaytotime5").css("border-color", "red");
            return false;
        }else{
            $(".eachdaytotime5").css("border", "1px solid #ddd");
            return true
        }
    });

    $('.eachdaytotime6').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime6').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        //if($daysfromtime > $daystotime){
        if(start_time > end_time) {
            $('.eachdaytotime6').val("");
            $(".eachdaytotime6").css("border-color", "red");
            return false;
        }else{
            $(".eachdaytotime6").css("border", "1px solid #ddd");
            return true;
        }
    });

    $('.eachdaytotime7').on('change', '', function (e) {
        $daystotime = this.value;
        $daysfromtime = $('.eachdayfromtime7').val();
        $('.daysfromtime_check').val("");$('.daystotime_check').val("");

        //convert both time into timestamp
        // Septemper 24, 2021 - this for example to convert the time into timestamp
        var start_time = new Date("Septemper 24, 2021 " + $daysfromtime);
        start_time = start_time.getTime();
        var end_time = new Date("Septemper 24, 2021 " + $daystotime);
        end_time = end_time.getTime();

        if(start_time > end_time) {
            $('.eachdaytotime7').val("");
            $(".eachdaytotime7").css("border-color", "red");
            return false;
        }else{
            $(".eachdaytotime7").css("border", "1px solid #ddd");
            return true;
        }
    });
});

   $('#signUpgoogle').on("click", function(){
          $("#email_addr_err").hide();
          $('#username_chk_err').hide();
          $('#email_addr_chk_err').hide();

          var username = $('#username').val();
          var email_addr = $('#email_addr').val();
          var profile_image = $('#crop_prof_img').val();
          var tokenid = $('#tokenid').val();

          var error = 0;
          if(username == "")
          {
            $("#username_err").show();
            error = 1;
          }

          if(email_addr == "")
          {
            $("#email_addr_err").show();
            error = 1;
          }

          if(error == 0)
    			{
    	 			var url = base_url+'login/check_email_address';
    				var request = $.ajax({
              url: url,
              type: "post",
              data: {'email_addr': email_addr}
            });
            // callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
    					var response_data = JSON.parse(response);
    					if(response_data.valid==false){
    					$('#email_addr_chk_err').show();
    					}else{
                $.ajax({
                 type:'POST',
                 url: base_url+'login/google_new_user',
                 data : {username:username,email_addr:email_addr,profile_image:profile_image,tokenid:tokenid}, //phone:phone,
                 success:function(response)
                 {
                   if(response> 0)
                   {
                     window.location = base_url+'signin';
                   }
                   else
                   {
                }
               }
              });
              }
            });
    			}

       });


   $('#signUpfacebook').on("click", function(){

              $("#email_addr_err").hide();
              $('#username_chk_err').hide();
              $('#email_addr_chk_err').hide();
              $("#phone_err").hide();

          var username = $('#username').val();
          var email_addr = $('#email_addr').val();
          var phone = $('#phone').val();
          var profile_image = $('#crop_prof_img').val();
          var tokenid = $('#tokenid').val();

          var error = 0;
          if(username == "")
          {
            $("#username_err").show();
            error = 1;
          }

          if(email_addr == "")
          {
            $("#email_addr_err").show();
            error = 1;
          }

          if(error == 0)
          {
            var url = base_url+'login/check_email_address';
            var request = $.ajax({
              url: url,
              type: "post",
              data: {'email_addr': email_addr}
            });
            // callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
              var response_data = JSON.parse(response);
              if(response_data.valid==false){
              $('#email_addr_chk_err').show();
              }else{

                $.ajax({
                 type:'POST',
                 url: base_url+'login/facebook_new_user',
                 data : {username:username,email_addr:email_addr,phone:phone,profile_image:profile_image,tokenid:tokenid},
                 success:function(response)
                 {
                   if(response> 0)
                   {
                     window.location = base_url+'signin';
                   }
                   else
                   {
           }
         }
       });
              }
            });
          }

       });

  // admin login success function completes here

      $("#signInSubmit").on("click", function(){
      });
$(document).ready(function(){
      $('#userSignIn').bootstrapValidator({
      fields: {
      username:   {
      validators:          {
      notEmpty:              {
      message: username_err_msg
                 }
               }
              },
      password:           {
      validators:           {
      notEmpty:               {
      message: password_err_msg
                  }
                }
              }
    		}
        }).on('success.form.bv', function(e) {

        })  
});

$('#start_date').datetimepicker({
     minDate:new Date(),
    format: 'DD-MM-YYYY'
 });

$('#end_date').datetimepicker({
    format: 'DD-MM-YYYY',
    useCurrent: false
 });
$("#start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
 $("#end_date").on("dp.change", function (e) {
  });

$('#edit_start_date').datetimepicker({
     minDate:new Date(),
    format: 'DD-MM-YYYY'
});

$('#edit_end_date').datetimepicker({
     minDate:new Date(),
    format: 'DD-MM-YYYY',
    useCurrent: false
 });
$("#edit_start_date").on("dp.change", function (e) {
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });
 $("#edit_end_date").on("dp.change", function (e) {
  });

$("#profileSubmit").on("click", function(){
});

function get_request_button() {

    var error =0;
    $('.data_create_error').hide();


        if($('#title').val()==""){
            $('.title_err_msg').show();
            $('#title').attr('style','border-color:red');
          error = 1;
        }else{
            $('.title_err_msg').attr('style','display:none');
            $('#title').removeAttr('style');
        }

        if($('#description1').val()==""){
            $('.description1_err_msg').show();
            $('#description1').attr('style','border-color:red');
          error = 1;
        }else{
            $('.description1_err_msg').attr('style','display:none');
            $('#description1').removeAttr('style');
        }
      var points = $('.additionalpoints').attr('current_points');
        for (var l = 2; l <= points; l++) {
          if($('#description'+l).val()==""){
            $('.description2_err_msg').show();
          $('#description'+l).attr('style','border-color:red');
             error = 1;
          }else{
            $('.description2_err_msg').attr('style','display:none');
            $('#description'+l).removeAttr('style');
          }
        }


        if($('#location').val()==""){
            $('.location_err_msg').show();
            $('#location').attr('style','border-color:red');
            error = 1;
        }else{
            $('.location_err_msg').attr('style','display:none');
          $('#location').removeAttr('style');
        }
        if($('#request_date').val()==""){
                $('.request_date_err_msg').show();
                $('#request_date').attr('style','border-color:red');
                error = 1;
        }else{
            $('.request_date_err_msg').attr('style','display:none');
          $('#request_date').removeAttr('style');
        }
        if($('#request_time').val()==""){
            $('.request_time_err_msg').show();
            $('#request_time').attr('style','border-color:red');
          error = 1;
        }else{
            $('.request_time_err_msg').attr('style','display:none');
            $('#request_time').removeAttr('style');
        }

        if($('#proposed_fee').val()=="" || $('#proposed_fee').val()<=0){
            $('.proposed_fee_err_msg').show();
            $('#proposed_fee').attr('style','border-color:red');
          error = 1;
        }else{
            $('.proposed_fee_err_msg').attr('style','display:none');
            $('#proposed_fee').removeAttr('style');
        }

        if($('#contact_number').val()==""){
            $('.contact_number_err_msg').show();
            $('#contact_number').attr('style','border-color:red');
          error = 1;
        }else{
          var contact=$('#contact_number').val();
            if(contact.length !=10)
            {
              error = 1;
              $('#contact_number').attr('style','border-color:red');
              $('#contact_number_err_msg').show();
            }
            else
            {
              $('#contact_number').removeAttr('style');
              $('#contact_number_err_msg').hide();
              $('.contact_number_err_msg').attr('style','display:none');
            }
        }



    if(error == 0){
        $('.data_create').show();
    var form = $('#get_request_from')[0];
    var form1 = $('get_request_from')[0];
        var formData = new FormData(form);
    $.ajax({ 
              url: base_url+'create_request',
              type: 'POST',
              cache: false, 
              data: formData,
              dataType: 'json',
              processData: false,
                contentType: false,
              success: function(data) {
                          if(data == 2){
                            $('.data_create_loading').hide();
                            $('.data_create_error').show();
                            window.location.href= base_url+'my-request';

                        }else{
                            window.location.href= base_url+'my-request';
                        }
                    }
          });
    }else{
        $('.data_create_loading').hide();
    }
}

$(document).on('click','#edit_request_button',function(){

    var error =0;
    $('.data_create_error').hide();
    var current_date = $('#current_date').val();
    var request_time = $('#request_date').val();
    var request_time_array = request_time.split("-").map(Number);

    var request_date = request_time_array[2]+'-'+request_time_array[1]+'-'+request_time_array[0];


        if($('#title').val()==""){
          $('#title').attr('style','border-color:red');
          error = 1;
        }else{
          $('#title').removeAttr('style');
        }

        if($('#description1').val()==""){
          $('#description1').attr('style','border-color:red');
          error = 1;
        }else{
          $('#description1').removeAttr('style');
        }
      var points = $('.additionalpoints').attr('current_points');
        for (var l = 2; l <= points; l++) {
          if($('#description'+l).val()==""){
          $('#description'+l).attr('style','border-color:red');
             error = 1;
          }else{
            $('#description'+l).removeAttr('style');
          }
        }


        if($('#location').val()==""){
          $('#location').attr('style','border-color:red');
          error = 1;
        }else{
          $('#location').removeAttr('style');
        }
        if($('#request_date').val()==""){
          $('#request_date').attr('style','border-color:red');
          error = 1;
        }else{
          $('#request_date').removeAttr('style');
          if((new Date(current_date).getTime() > new Date(request_date).getTime()))
          {
            error = 1;
            $('#request_date').attr('style','border-color:red');
          }
          else {
            $('#request_date').removeAttr('style');
          }
        }
        if($('#request_time').val()==""){
          $('#request_time').attr('style','border-color:red');
          error = 1;
        }else{
          $('#request_time').removeAttr('style');
        }

        if($('#proposed_fee').val()=="" || $('#proposed_fee').val()<=0){
          $('#proposed_fee').attr('style','border-color:red');
          error = 1;
        }else{
          $('#proposed_fee').removeAttr('style');
        }

        if($('#contact_number').val()==""){
          $('#contact_number').attr('style','border-color:red');
          error = 1;
        }else{
          var contact=$('#contact_number').val();
            if(contact.length !=10)
            {
              error = 1;
              $('#contact_number').attr('style','border-color:red');
              $('#contact_number_err_msg').show();
            }
            else
            {
              $('#contact_number').removeAttr('style');
              $('#contact_number_err_msg').hide();
            }
        }



    if(error == 0){
        $('.data_create').show();
    var data_string = $("#edit_request_from").serialize();
    $.post(base_url+'update_request',{data:data_string},function(data){
        if(data == 2){
            $('.data_create_loading').hide();
            // window.location.href= base_url+'my-request';
        }else{
           window.location.href= base_url+'my-request';
        	return false;
            // window.location.href= base_url+'my-request';
        }
    });
    }else{
        $('.data_create_loading').hide();
         // window.location.href= base_url+'my-request';
    }
});

 $("#description1").keydown(function(){
  $('#description-error').hide();
});

$('#category').on('change', function() {
  if( this.value != "" ){
      $('#category-error').hide();
  }
});

$(document).on('click','#add_service_button_old',function(){
        var error =0;
        var points = $('.additionalpoints').attr('current_points');

        if($('#title').val()==""){
          $('#title').attr('style','border-color:red');
          error = 1;
          }else{
          $('#title').removeAttr('style');
        }

        if($('#category').val()==""){
          $('.dropdown-toggle[data-id="category"]').attr('style','border-color:red');
          $('#category-error').show();
          $('#category-error').append("Select any category");
             error = 1;
          }else{
             $('.dropdown-toggle[data-id="category"]').removeAttr('style');
             $('#category-error').hide();
          }

         if($('#description1').val()==""){
          $('#description1').attr('style','border-color:red');
          $('#description-error').show();
          $('#description-error').append("Enter the Description");
             error = 1;
          }else{
            $('#description1').removeAttr('style');
            $('#description-error').hide();
          }

        for (var l = 2; l <= points; l++) {
          if($('#description'+l).val()==""){
          $('#description'+l).attr('style','border-color:red');
             error = 1;
          }else{
            $('#description'+l).removeAttr('style');
          }
        }

        if($('#location').val()==""){
             $('#location').attr('style','border-color:red');
             error = 1;
        }else{
             $('#location').removeAttr('style');
        }

        if($('#contact_number').val()==""){
          error = 1;
          $('#contact_number').attr('style','border-color:red');
        }else{
            var contact=$('#contact_number').val();
            if(contact.length !=10)
            {
              error = 1;
              $('#contact_number').attr('style','border-color:red');
              $('#contact_number_err_msg').show();
            }
            else
            {
              $('#contact_number').removeAttr('style');
              $('#contact_number_err_msg').hide();
            }

        }
        if($('#start_date').val()==""){
          error = 1;
          $('#start_date').attr('style','border-color:red');
        }else{
            $('#start_date').removeAttr('style');
        }
        if($('#end_date').val()==""){
          error = 1;
          $('#end_date').attr('style','border-color:red');
        }else{
            $('#end_date').removeAttr('style');
        }

        if($('.days_check').is(':checked') == true){

            $('.eachdays').removeAttr('style');
            $('.eachdayfromtime').removeAttr('style');
            $('.eachdaytotime').removeAttr('style');

          if($('.daysfromtime_check').val()==''){
              $('.daysfromtime_check').attr('style','border-color:red');
              error = 1;
          }else{
            $('.daysfromtime_check').removeAttr('style');
          }
          if($('.daystotime_check').val()==''){
              error = 1;
              $('.daystotime_check').attr('style','border-color:red');

          }else{
            $('.daystotime_check').removeAttr('style');
          }

        }else{
            var oneday = 0;
             $('.daysfromtime_check').removeAttr('style');
             $('.daystotime_check').removeAttr('style');

        $('.eachdays').each(function(){
            if($(this).is(':checked') == true){
               oneday = 1;
            }
          });
          if(oneday == 1){
            $('.eachdays').removeAttr('style');
            $('.eachdayfromtime').removeAttr('style');
            $('.eachdaytotime').removeAttr('style');
          }

          $('.eachdays').each(function(){

              if($(this).is(':checked') == true){


                var val = $(this).val();
                val = parseInt(val);

                if($('.eachdayfromtime'+val).val() ==''){
                  error = 1;

                  $('.eachdayfromtime'+val).attr('style','border-color:red');
                }else{
                  $('.eachdayfromtime'+val).removeAttr('style');
                }

                if($('.eachdaytotime'+val).val() ==''){
                  error = 1;
                  $('.eachdaytotime'+val).attr('style','border-color:red');
                }else{
                  $('.eachdaytotime'+val).removeAttr('style');
                }

              }

          });
          if(oneday == 0){
            $('.eachdays').attr('style','outline:2px solid red');
            $('.eachdayfromtime').attr('style','border-color:red');
            $('.eachdaytotime').attr('style','border-color:red');
            error = 1;
          }else{
          }

        }




    $('.data_create_error').hide();
    if(error == 0){
        $('.data_create_loading').show();
        var data_string = $("#add_service_form").serialize();
        $.post(base_url+'create_service',{data:data_string},function(data){
            if(data == 2){
                $('.data_create_loading').hide();
                $('.data_create_error').show();
            }else{
             window.location.href= base_url+'my-services';
        }
        });
    }else{
        $('.data_create_loading').hide();
    }
});



$(document).on('click','#edit_service_button',function(){

    var error =0;


    var points = $('.additionalpoints').attr('current_points');
    var current_date = $('#current_date').val();
    var start_date = $('#edit_start_date').val();
    var end_date = $('#edit_end_date').val();
    var start_array = start_date.split("-").map(Number);
    var end_array = end_date.split("-").map(Number);

    var edit_start_date = start_array[2]+'-'+start_array[1]+'-'+start_array[0];
    var edit_end_date = end_array[2]+'-'+end_array[1]+'-'+end_array[0];

        if($('#title').val()==""){
          $('#title').attr('style','border-color:red');
          error = 1;
        }else{
          $('#title').removeAttr('style');
        }

        if($('#category').val()==""){
          $('.dropdown-toggle[data-id="category"]').attr('style','border-color:red');
             error = 1;
          }else{
             $('.dropdown-toggle[data-id="category"]').removeAttr('style');
          }
         if($('#description1').val()==""){
          $('#description1').attr('style','border-color:red');
             error = 1;
          }else{
            $('#description1').removeAttr('style');
          }

        for (var l = 2; l <= points; l++) {
          if($('#description'+l).val()==""){
          $('#description'+l).attr('style','border-color:red');
             error = 1;
          }else{
            $('#description'+l).removeAttr('style');
          }
        }


        if($('#location').val()==""){
             $('#location').attr('style','border-color:red');
          error = 1;
        }else{
                $('#location').removeAttr('style');
        }
        if($('#contact_number').val()==""){
          error = 1;
          $('#contact_number').attr('style','border-color:red');
        }else{
            var contact=$('#contact_number').val();
            if(contact.length !=10)
            {
              error = 1;
              $('#contact_number').attr('style','border-color:red');
              $('#contact_number_err_msg').show();
            }
            else
            {
              $('#contact_number').removeAttr('style');
              $('#contact_number_err_msg').hide();
            }
        }
        if($('#edit_start_date').val()==""){
          error = 1;
          $('#edit_start_date').attr('style','border-color:red');
        }else{
            $('#edit_start_date').removeAttr('style');
            if((new Date(current_date).getTime() > new Date(edit_start_date).getTime()))
            {
              error = 1;
              $('#edit_start_date').attr('style','border-color:red');
            }
            else {
              $('#edit_start_date').removeAttr('style');
            }
        }
        if($('#edit_end_date').val()==""){
          error = 1;
          $('#edit_end_date').attr('style','border-color:red');
        }else{
            $('#edit_end_date').removeAttr('style');
            if((new Date(edit_start_date).getTime() > new Date(edit_end_date).getTime()))
            {
              error = 1;
              $('#edit_end_date').attr('style','border-color:red');
            }
            else {
              $('#edit_end_date').removeAttr('style');
            }
        }

        if($('.days_check').is(':checked') == true){

            $('.eachdays').removeAttr('style');
            $('.eachdayfromtime').removeAttr('style');
            $('.eachdaytotime').removeAttr('style');

          if($('.daysfromtime_check').val()==''){
              $('.daysfromtime_check').attr('style','border-color:red');
              error = 1;
          }else{
            $('.daysfromtime_check').removeAttr('style');
          }
          if($('.daystotime_check').val()==''){
              error = 1;
              $('.daystotime_check').attr('style','border-color:red');

          }else{
            $('.daystotime_check').removeAttr('style');
          }

        }else{
            var oneday = 0;
             $('.daysfromtime_check').removeAttr('style');
             $('.daystotime_check').removeAttr('style');

        $('.eachdays').each(function(){
            if($(this).is(':checked') == true){
               oneday = 1;
            }
          });
          if(oneday == 1){
            $('.eachdays').removeAttr('style');
            $('.eachdayfromtime').removeAttr('style');
            $('.eachdaytotime').removeAttr('style');
          }

          $('.eachdays').each(function(){

              if($(this).is(':checked') == true){


                var val = $(this).val();
                val = parseInt(val);

                if($('.eachdayfromtime'+val).val() ==''){
                  error = 1;

                  $('.eachdayfromtime'+val).attr('style','border-color:red');
                }else{
                  $('.eachdayfromtime'+val).removeAttr('style');
                }

                if($('.eachdaytotime'+val).val() ==''){
                  error = 1;
                  $('.eachdaytotime'+val).attr('style','border-color:red');
                }else{
                  $('.eachdaytotime'+val).removeAttr('style');
                }

              }

          });
          if(oneday == 0){
            $('.eachdays').attr('style','outline:2px solid red');
            $('.eachdayfromtime').attr('style','border-color:red');
            $('.eachdaytotime').attr('style','border-color:red');
            error = 1;
          }else{
          }

        }

    $('.data_create_error').hide();
    if(error == 0){
        $('.data_create_loading').show();
        var data_string = $("#edit_service_form").serialize();
        $.post(base_url+'update_service',{data:data_string},function(data){
            if(data == 2){
                $('.data_create_loading').hide();
            }else{
             window.location.href= base_url+'my-services';
        }
        });
    }else{
        $('.data_create_loading').hide();
    }
});

$(document).on('click','.days_check',function(){

    if($(this).is(':checked') == true){

        $('.eachdays').attr('disabled','disabled');
        $('.eachdayfromtime').attr('disabled','disabled');
        $('.eachdaytotime').attr('disabled','disabled');
        $('.eachdays').prop('checked', false);
        $('.eachdays').removeAttr('style');
        $('.eachdayfromtime').removeAttr('style');
        $('.eachdaytotime').removeAttr('style');

    }else{
        $('.eachdays').removeAttr('disabled');
        $('.eachdayfromtime').removeAttr('disabled');
        $('.eachdaytotime').removeAttr('disabled');
        $('.daysfromtime_check').val('');
        $('.daystotime_check').val('');
        $('.daysfromtime_check').removeAttr('style');
        $('.daystotime_check').removeAttr('style');
    }

});

  $(".numbers_Only").keydown(function (e) {

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

  function add_points(){
      var current_points = $('.additionalpoints').attr('current_points');
      var val = (parseInt(current_points) +1);
      var len = $('.des-count').length+1;
      if(len < 5){
        $('.add-icon').show();
      }else{
        $('.add-icon').hide();
      }


        var html = '<div class="form-group remove_point_'+val+' des-count" >'+
                '<label class="control-label">'+description_point+' '+len+' <span class="text-danger">*</span></label>'+
                '<div class="add-point d-flex justify-content-between align-items-center">'+
                   ' <div class="w-100">'+
                     '   <textarea class="form-control" type="text"  name="description[]" id="description'+val+'"></textarea>'+
                    '</div>'+
                     '<div class="ml-3">'+
                          '<span class="remove-icon minus-append-col" onclick="remove_points('+val+')"><i class="fas fa-times"></i></span>'+
                      '</div>'+
                '</div>'+
            '</div>';
        $('.additionalpoints').append(html);

     $('.additionalpoints').attr('current_points',val);
  }

  function remove_points(id){
    var icon_count = $('.add-icon').length;
    var add_icon = '<div class="ml-3"><span class="add-icon plus-append-col"  onclick="add_points()"><i class="fas fa-plus"></i></span></div>';
       var current_points = $('.additionalpoints').attr('current_points');
       $('.remove_point_'+id).remove();
       var len = $('.des-count').length;
       if(len < 5) {
            $('.add-icon').remove();
            $('.remove-point_1').append(add_icon);
        }
       $('.additionalpoints').attr('current_points',(parseInt(id) -1));
  }


    $('#request_date').datetimepicker({
           minDate:new Date(),
           format: 'DD-MM-YYYY',
           // format: 'LD'
    });
    $('#request_time').datetimepicker({
        icons:{
            up: 'fa fa-angle-up',
            down: 'fa fa-angle-down'
        },
        format: 'LT'
    });

$(document).on('click','.si-confirm-complete',function(){
	$('#requestFinalConfirmModal').modal('show');
	var url    =  base_url+'user/service/complete_request';
	var req_id = $(this).attr("data-id");
	$(document).on('click','.si_confirm',function(){
		var dataString="req_id="+req_id;
		$.ajax({
				url:url,
				data:dataString,
				type:"POST",
				beforeSend:function(){
				 	$('#requestFinalConfirmModal').modal('toggle');
				},
				success: function(res){
					 if(res==1)
					 {
						location.reload(true);
					 }else{
						location.reload(true);
					 }
				 }
		});
	});
	$(document).on('click','.si_cancel',function(){
		//$('#confirmModal').modal('toggle');
	});
});

$(document).on('click','.si-decline-complete',function(){
	$('#requestFinalDeclineModal').modal('toggle');
	var url    =  base_url+'user/service/decline_request';
	var req_id = $(this).attr("data-id");
	$(document).on('click','.si_confirm',function(){
		var dataString="req_id="+req_id;
		$.ajax({
				url:url,
				data:dataString,
				type:"POST",
				beforeSend:function(){
				 	$('#requestFinalDeclineModal').modal('toggle');
				},
				success: function(res){
					 if(res==1)
					 {
						location.reload(true);
					 }else{
						location.reload(true);
					 }
				 }
		});
	});
	$(document).on('click','.si_cancel',function(){
		//$('#confirmModal').modal('toggle');
	});
});

$(document).on('click','#show_location',function(){
   var showmap = $(this).attr('data-show');
     $(this).attr('data-show',1);
     $('.setlocation').hide();
     $('.addlocation').show();
     $('#my_map').modal('show');
     initMap();


});

function addlocation(){

  var address = $('#autocomplete').val();
  var latitude = $('#user_latitude').val();
  var longitude = $('#user_longitude').val();
  $('#location').val(address);
  $('#latitude').val(latitude);
  $('#longitude').val(longitude);
  $('#my_map').modal('hide');
  $(this).attr('data-show',0);

}

$(document).on('click','#booking_service',function(){
    var user_id = $('#session_user_id').val();
    if(user_id == '') {
        window.location = base_url+'login';
    } else {
        $('.book_time_slot').modal('show');;
    }
});
$(document).on('click','.si-accept-complete',function(){
    var user_id = $('#session_user_id').val();
    if(user_id != 0) {
        var url    =  base_url+'user/request/request_accept';
        var req_id = $(this).attr("data-id");
        var sub = $(this).attr("data-sub");
        $('#acceptConfirmModal').modal('show');
        if(sub == 0) {
            $('#acc_title').html('<i>'+accept_title+'</i>');
            $('#acc_msg').html(accept_msg);
        } else {
            $('#acc_title').html('<i>'+subscribe_title+'</i>');
            $('#acc_msg').html(do_subscribe_msg+', '+do_subscribe_msg1);
        }
        $(document).on('click','.si_accept_confirm',function(){
            if(sub == 0) {
                var dataString="req_id="+req_id;
                $.ajax({
                        url:url,
                        data:dataString,
                        type:"POST",
                        beforeSend:function(){
                            $('#acceptConfirmModal').modal('hide');
                        },
                        success: function(res){
                             if(res==1)
                             {
                                window.location = base_url+'request';
                             }else{
                                window.location = base_url+'request';
                             }
                         }
                });
            } else {
                window.location = base_url+'subscription-list';
            }
        });

        $(document).on('click','.si_accept_cancel',function(){
            //$('#confirmModal').modal('toggle');
        });
    } else {
        window.location = base_url+'login';
    }
	
});

$(document).on('click','.si-chat-subscribe',function(){
  $('#subscribeConfirmModal').modal('show');
  $('#acc_title').html('<i>'+subscribe_title+'</i>');
  $('#acc_msg').html(do_subscribe_msg+', '+do_subscribe_msg1);
	$(document).on('click','.si_accept_confirm',function(){
     window.location = base_url+'subscription-list';
	});
	$(document).on('click','.si_accept_cancel',function(){
		//$('#confirmModal').modal('toggle');
	});
});

$(document).on('click','.si-delete-request',function(){
  var req_id = $(this).attr("data-id");
  $('#deleteConfirmModal').modal('show');
  $('#acc_title').html('<i>'+delete_title+'</i>');
  $('#acc_msg').html(delete_msg);
	$(document).on('click','.si_accept_confirm',function(){
    var dataString="req_id="+req_id;
    var url    =  base_url+'user/request/delete_request';
    $.ajax({
        url:url,
        data:dataString,
        type:"POST",
        beforeSend:function(){
          $('#deleteConfirmModal').modal('toggle');
        },
        success: function(res){
           if(res==1)
           {
            window.location = base_url+'my-request';
           }else if(res==2){
            window.location = base_url+'my-request';
           }
           else if(res==3){
            window.location = base_url+'my-request';
           }
         }
    });
	});
	$(document).on('click','.si_accept_cancel',function(){
		//$('#confirmModal').modal('toggle');
	});
});

$(document).on('click','.si-delete-service',function(){
  var p_id = $(this).attr("data-id");
  $('#deleteConfirmModal').modal('toggle');
  $('#acc_title').html('<i>'+delete_title+'</i>');
  $('#acc_msg').html(delete_msg);
	$(document).on('click','.si_accept_confirm',function(){
    var dataString="p_id="+p_id;
    var url    =  base_url+'user/service/delete_service';
    $.ajax({
        url:url,
        data:dataString,
        type:"POST",
        beforeSend:function(){
          $('#deleteConfirmModal').modal('toggle');
        },
        success: function(res){
           if(res==1)
           {
            window.location = base_url+'my-services';
           }else if(res==2){
            window.location = base_url+'my-services';
           }
         }
    });
	});
	$(document).on('click','.si_accept_cancel',function(){
		//$('#confirmModal').modal('toggle');
	});
});
function advanced_search() {
  $("#advance_serch").toggle();
}

/* Search and advance search Start */
function search_list(val) {


          $('#search_list').attr('data-loading',val);
          $('.loadmore_results').attr('data-search',1);
          if(val==0){
            $('.loadmore_results').attr('data-loading',0);
            $('#search_list').attr('data-next-page',0);
            $('#search_list').attr('data-loading',0);
          }
          var nextpage = $('#search_list').attr('data-next-page');
          var current  = $('#search_list').attr('data-current');
          var loading  = $('#search_list').attr('data-loading');
          var loadmore_call = $('.loadmore_results').attr('data-loading');

           if(nextpage !=-1){ 

            var search_title = $('#search_title').val();
            var request_date = $('#request_date').val();
            var request_time = $('#request_time').val();
            var min_price = $('#min_price').val();
            var max_price = $('#max_price').val();
            var location = $('#location').val();
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();
          if (search_title !='' || request_date !='' || request_time !='' || min_price !='' || max_price !='' || location !='') {
                $('.loadmore_results').show();
                $('.loadmore_results').attr('data-loading',1);
                if(val==0){  $('#provider_list').html('Loading...');}
                $.post(
                  base_url+'search_request_load',
                  {
                    search_title:search_title,
                    request_date:request_date,
                    request_time:request_time,
                    min_price:min_price,
                    max_price:max_price,
                    location:location,
                    nextpage:nextpage,
                    latitude:latitude,
                    longitude:longitude
                  },
                  function(data){

                  var results = JSON.parse(data);

                  $('.loadmore_results').attr('data-loading',0);
                  $('.loadmore_results').attr('data-next-page',results['next_page']);
                  $('#search_list').attr('data-next-page',results['next_page']);

                  var records = results['request_list'];
                  if(loading == 0){
                    $('#provider_list').html('');
                  }
                  if(records.length > 0){
                    var html = '';
                    $(records).each(function(i,record){
                      var r_id =md5(record.r_id);
                    var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

                      html = html +' <div class="col-12 col-lg-6">'+
                  '<div class="technician-widget" href="'+base_url+'request-view/'+r_id+'">'+
                        '<div class="left">'+
                          '<a href="'+base_url+'request-view/'+r_id+'">'+
                          '<img src="'+base_url+profile_img+'" alt="" width="100" height="100">'+
                          '</a>'+
                        '</div>'+
                        '<div class="right">  '+
                        '<div class="inner-right">'+
                        '<a href="'+base_url+'request-view/'+r_id+'">'+
                          '<h4>'+record.title+'</h4>'+
                          '</a>';
                          var description =  JSON.parse(record.description);

                      if(description.length > 0){

                        var i =1;
                      html = html + '<ol>';
                      $(description).each(function(j,description){
                          if(i<=3){

                              html = html +'<li class="text-truncate">'+description+'</li>';
                          }else{
                          //  break;
                           }
                          i++;
                        });

                    html = html +'</ol>';
                      }
                    html = html +
                      '<div class="location-col d-flex justify-content-between mt-2">'+
                              '<div><i class="fas fa-calendar-week"></i> <span>'+record.request_date+'</span></div>'+
                              '<div><i class="far fa-clock"></i> <span>'+record.request_time+'</span></div>'+
                              '<div><h6>'+record.currency_code+' '+record.amount+'</h6></div>'+
                          '</div>'+
                          '</div>'+
                        '</div>'+
                        '</div>'+
                    '</div>';

                    });
                    $('.loadmore_results').hide();
                    if(loading == 0){
                     $('#provider_list').html(html);
                    }else{
                      $('#provider_list').append(html);
                    }

                  }

                  if(results['total_pages'] == 0){
                    $('.loadmore_results').hide();
                    $('#search_list').attr('data-loading',0);
                     $('#provider_list').html('<a href="javascript:void(0)" class="col-md-12 alert alert-danger">'+no_results_found_text+'</a>');
                  }

                 });

              }
        }

}

function service_search_list(val) {


          $('#search_list').attr('data-loading',val);
          $('.loadmore_results').attr('data-search',1);
          if(val==0){
            $('.loadmore_results').attr('data-loading',0);
            $('#search_list').attr('data-next-page',0);
            $('#search_list').attr('data-loading',0);
            // $('#provider_list').html('Loading...');
          }
          var nextpage = $('#search_list').attr('data-next-page');
          var current  = $('#search_list').attr('data-current');
          var loading  = $('#search_list').attr('data-loading');
          var loadmore_call = $('.loadmore_results').attr('data-loading');

           if(nextpage !=-1){



            var search_title = $('#search_title').val();
            var category = $('#category').val();
            var subcategory = $('#subcategory').val();
            var request_date = $('#request_date').val();
            var location = $('#location').val();
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();

            //if (search_title !='' || request_date !='' ||  location !='') {

              $('.loadmore_results').show();
              $('.loadmore_results').attr('data-loading',1);
                if(val==0){  $('#provider_list').html('Loading...');}

                $.post(base_url+'service_search_list',
                  {
                   search_title:search_title,
                   category:category,
                   subcategory:subcategory,
                    request_date:request_date,
                    location:location,
                    nextpage:nextpage,
                    latitude:latitude,
                    longitude:longitude
                  }
                  ,function(data){

                  var results = JSON.parse(data);

                  $('.loadmore_results').attr('data-loading',0);
                  $('.loadmore_results').attr('data-next-page',results['next_page']);
                   $('#search_list').attr('data-next-page',results['next_page']);

                  var records = results['provider_list'];
                  if(loading == 0){
                    $('#provider_list').html('');
                  }
                  if(records.length > 0){
                    var html = '';
                    $(records).each(function(i,record){

                      //console.log(record);
                      p_id = md5(record.p_id);
											var provider_id =md5(record.provider_id);
                    var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';
                    var chat_status = results['subscription_status'];

                      html = html +'<div class="col-12 col-lg-6">'+
                    '<div class="technician-widget">'+
                  '<div class="left">'+
                      '<a href="'+base_url+'service-view/'+p_id+'">'+
                        '<img src="'+base_url+profile_img+'"  width="100" height="100" alt="">'+
                      '</a>'+
                  '</div>'+
                  '<div class="right">'+
                  '<div class="inner-right">'+
                      '<h4>'+record.title+'</h4>';
                      var description_details =  JSON.parse(record.description_details);
                      if(description_details.length > 0){
                        var i =1;
                      html = html + '<ol>';
                      $(description_details).each(function(j,description){
                          if(i<=3){
                            html = html +'<li class="text-truncate">'+description+'</li>';
                          }else{
                          //  break;
                           }
                          i++;
                        });

                    html = html +'</ol>';
                      }
                    html = html +
                    '<div class="location-col d-flex justify-content-between align-items-center mt-2 pt-1">';
                      if(chat_status == 0 || provider_id == md5(userid)){
                        html = html + '<div><i class="fas fa-phone-alt"></i> <span>'+record.contact_number+'</span></div>';
                      }else{
                        html = html + '<div><i class="fas fa-phone-alt"></i><span>-</span></div>';
                      }
                    html = html ;
                    if(provider_id != md5(userid)){
                      if(chat_status == 0){
                        html = html + '<div><a href="'+base_url+'chat/'+provider_id+'" class="btn">'+chat_lang+'</a></div>';
                      }
                      else if(chat_status == 1){
                        html = html + '<div class="service-right"><a href="javascript:void(0);" class="service-amount si-chat-subscribe">'+chat_lang+'</a></div>';
                      }
                    }
                  html = html +
                  '</div>'+
                  '</div>'+
                  '</div>'+
                '</div>'+
            '</div>';

                    });

                    if(loading == 0){
                     $('#provider_list').html(html);
                    }else{
                      $('#provider_list').append(html);
                    }
                  }

                  $('.loadmore_results').hide();

                  if(results['total_pages'] == 0){
                    $('.loadmore_results').hide();
                    $('#search_list').attr('data-loading',0);
                     $('#provider_list').html('<a href="javascript:void(0)" class="col-md-12 alert alert-danger">No result were found</a>');
                  }

                 });

              //}
              }
}

$("#new_password").on("keyup", function() {
    var new_password = $('#new_password').val();
    var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/;

    if(!passReg.test(new_password)){
        error = 1;
        $('#new_block_error').hide();
        $('#passwordchk_error').show();
    } else {
         $('#passwordchk_error').hide();
    }
});

$("#confirm_password").on("keyup", function() {
    var repeat_password = $('#confirm_password').val();
    var new_password = $('#new_password').val();
if(repeat_password!=""){
    $('#repeat_block_error').hide();
    if(repeat_password!=new_password){
        error =1;
        $('#repeat_chkblock_error').show();
    }else{
        $('#repeat_chkblock_error').hide();
    }
    }
});
/* Search and advance search End */
 $("#cform_submit").on("click",function(e){
      e.preventDefault();
      $('#current_block_error').hide();
      $('#current_chkblock_error').hide();
      $('#new_block_error').hide();
      $('#new_blockchk_error').hide();
      $('#passwordchk_error').hide();
      $('#repeat_block_error').hide();
      $('#repeat_chkblock_error').hide();
      var current_password = $('#current_password').val();
      var new_password = $('#new_password').val();
      var repeat_password = $('#confirm_password').val();
      var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/;
      var error =0;
      if(current_password == new_password){
            error =1;
            $('#same_error').show();
          }else{
            $('#same_error').hide();
          }
   });
  $("#cform_submit").on("click",function(e){
			e.preventDefault();
			$('#current_block_error').hide();
			$('#current_chkblock_error').hide();
			$('#new_block_error').hide();
			$('#new_blockchk_error').hide();
			$('#passwordchk_error').hide();
			$('#repeat_block_error').hide();
			$('#repeat_chkblock_error').hide();
			var current_password = $('#current_password').val();
			var new_password = $('#new_password').val();
			var repeat_password = $('#confirm_password').val();
			var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/;
			var error =0;
			if(current_password==""){
				error =1;
				$('#current_block_error').show();
			}else{
				$('#current_block_error').hide();
			}
			if(new_password==""){
				error =1;
				$('#new_block_error').show();
			}else{
				$('#new_block_error').hide();
				if(!passReg.test(new_password)){
					error = 1;
					$('#passwordchk_error').show();
				}else{
				 $('#passwordchk_error').hide();
	 				if(new_password == current_password)
	 				{
	 					error =1;
	 					$('#new_blockchk_error').show();
	 				}
					else {
	 					$('#new_blockchk_error').hide();					}
				}
			}
			if(repeat_password==""){
				error =1;
				$('#repeat_block_error').show();
			}else{
				$('#repeat_block_error').hide();
					if(repeat_password!=new_password){
						error =1;
						$('#repeat_chkblock_error').show();
					}else{
						$('#repeat_chkblock_error').hide();
					}
			}

			if(error==0){

				var url = base_url+'check_password';
				var request = $.ajax({
          url: url,
          type: "post",
          data: {'current_password': current_password},
        success: function(response) {
					if(response==0){
					$('#current_chkblock_error').show();
					}
					else{
						$('#current_chkblock_error').hide();
						 $('#change_password_form').submit();
					}
        }
			});
			}
		});

    $("#forgot_form_submit").on("click",function(e){
			e.preventDefault();
			$('#username_block_error').hide();
			$('#username_chkblock_error').hide();
			var username = $('#username').val();
      var error =0;
			if(username==""){
				error =1;
				$('#username_block_error').show();
			}else{
				$('#username_block_error').hide();
			}
			if(error==0){
				var url = base_url+'check_forgot_username';
				var request = $.ajax({
          url: url,
          type: "post",
          data: {'username': username},
        success: function(response) {
					if(response==0){
					$('#username_chkblock_error').show();
					}
					else{
						$('#username_chkblock_error').hide();
						 $('#forgot_password_form').submit();
					}
        }
			});
			}
		});

function loadmyrequest() {



          var search_filter = $('#search_filter').val();
          $.post(base_url+'load_myrequest',{nextpage:1,search_filter:search_filter},function(data){


                  var results = JSON.parse(data);

                  $('.loadmore_results').attr('data-loading',0);
                  $('.loadmore_results').attr('data-next-page',results['next_page']);

                  var records = results['request_list'];
                  if(records.length > 0){
                    var html = '';
                    $(records).each(function(i,record){

                      // console.log(record);
                      var r_id =md5(record.r_id);
                      var dr_id =record.r_id;
                      var status = '';
                  var sclass = '';
                  if(record.status == -1){
                    status = 'Expired';
                    sclass = 'bg-danger';
                  }
                  else if(record.status == 0){
                    status = 'Pending';
                    sclass = 'bg-warning';
                  }
                  else if(record.status == 1){
                    status = 'Accepted';
                    sclass = 'bg-primary';
                  }
                  else if(record.status == 2){
                    status = 'Completed';
                    sclass = 'bg-success';
                  }
                  else if(record.status == 3){
                    status = 'Declined';
                    sclass = 'bg-danger';
                  }
                    var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

                      html = html +' <div class="col-12 col-lg-6">'+
                        '<div class="technician-widget">';
                        '<div class="left">'+
                          '<a class="service-link" href="'+base_url+'request-view/'+r_id+'">'+
                            '<img src="'+base_url+profile_img+'" alt="">'+
                          '</a>'+
                        '</div>';
                        html = html +'<div class="right">'+
                      '<div class="inner-right">'+
                      '<div class="d-flex justify-content-between align-items-center">'+
                        '<div>'+
                        '<span class="badge '+sclass+'">'+status+'</span>'+
                        '</div>'+
                        '<div class="mr-2">'+
                          '<div class="request-edit-option">'+
                            '<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="'+base_url+'assets/img/menu.png" alt=""></a>'+
                          '<ul class="dropdown-menu">';
                          if(record.status == 0 || record.status == -1){
                            html = html +'<li><a href="'+base_url+'edit-request/'+r_id+'">'+edit_text+'</a></li>';
                          }
                            html = html +'<li><a href="javascript:void(0)" class="si-delete-request" data-id="'+dr_id+'">'+delete_text+'</a></li>'+
                          '</ul>'+
                          '</div>'+
                        '</div>'+
                      '</div>'+
                          '<a class="service-link" href="'+base_url+'request-view/'+r_id+'">'+
                            '<h4>'+record.title+'</h4>'+
                          '</a>';
                          var description =  JSON.parse(record.description);

                      if(description.length > 0){

                        var i =1;
                      html = html + '<ol>';
                      $(description).each(function(j,description){
                          if(i<=3){

                              html = html +'<li class="text-truncate">'+description+'</li>';
                          }else{
                          //  break;
                           }
                          i++;
                        });

                    html = html +'</ol>';
                      }
                    html = html +
                      '<div class="location-col d-flex justify-content-between mt-2">'+
                          '<div><i class="fas fa-calendar-week"></i> '+record.request_date+'</div>'+
                          '<div><i class="far fa-clock"></i> '+record.request_time+'</div>'+
                          '<div><h6>'+record.currency_code+' '+record.amount+'</h6></div>'+
                  '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';

                    });
                    $('.loadmore_results').hide();
                    $('#provider_list').html(html);
                  }else{
                    $('#provider_list').html('<a href="javascript:void(0)" >'+No_result_were_found+'</a>');
                  }

                 });
}



function loadmyservice() {
var search_filter = $('#search_filter').val();
$.post(base_url+'load_mybookservice',{nextpage:1,search_filter:search_filter},function(data){


    var results = JSON.parse(data);

    $('.loadmore_results').attr('data-loading',0);
    $('.loadmore_results').attr('data-next-page',results['next_page']);

    var records = results['request_list'];
    if(records.length > 0){
      var html = '';
      $(records).each(function(i,record){

        // console.log(record);
        var sid =md5(record.id);

        var status = '';
    var sclass = '';
    if(record.service_status == -1){
      status = 'Expired';
      sclass = 'bg-danger';
    }
    else if(record.service_status == 1){
      status = 'Pending';
      sclass = 'bg-warning';
    }
    else if(record.service_status == 2){
      status = 'Completed';
      sclass = 'bg-success';
    }
    else if(record.service_status == 3){
      status = 'Declined';
      sclass = 'bg-danger';
    }
      var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

        html = html +' <div class="col-12 col-lg-6">'+
          '<div class="technician-widget">'+
          '<div class="left">'+
            '<img src="'+base_url+profile_img+'" alt="">'+
          '</div>'+
        '<div class="right">'+
          '<div class="inner-right">';
          if(record.service_status == 1)
          {
            html +='<a href="'+base_url+'booking-status/'+sid+'" class="btn badge">Complete</a>';
          }
          else
          {
           html +='<span class="btn badge '+sclass+'">'+status+'</span>';
          }

           html +=
            '<h4>'+record.title+'</h4>'+

            '<ol>'+
                '<li>'+name_text+' : '+record.full_name+'</li>'+
                '<li>'+details_text+' : '+record.notes+'</li>'+

            '</ol>'+
            '<div class="location-col d-flex justify-content-between mt-2">'+
                '<div><i class="fas fa-calendar-week"></i>'+record.service_dates+'</div>'+
                '<div><i class="far fa-clock"></i>'+record.from_times+ '-' +record.to_times+'</div>'+
            '</div>'+
            '<div class="location-col d-flex justify-content-between mt-2">'+
              '<div><i class="fas fa-phone-alt"></i> '+record.mobile_no+'</div>'+
            '</div>'+
        '</div>'+
        '</div>'+
        '</div>'+
      '</div>';

      });
      $('.loadmore_results').hide();
      $('#provider_list').html(html);
    }else{
      $('#provider_list').html('<a href="javascript:void(0)" >'+No_result_were_found+'</a>');
    }

   });
}


function loadmybooking() {



          var search_filter = $('#search_filter').val();
          $.post(base_url+'load_mybooking',{nextpage:1,search_filter:search_filter},function(data){


                  var results = JSON.parse(data);

                  $('.loadmore_results').attr('data-loading',0);
                  $('.loadmore_results').attr('data-next-page',results['next_page']);

                  var records = results['request_list'];
                  if(records.length > 0){
                    var html = '';
                    $(records).each(function(i,record){

                      // console.log(record);
                      var r_id =md5(record.r_id);
                      var dr_id =record.r_id;
                      var status = '';
                  var sclass = '';
                  if(record.service_status == -1){
                    status = 'Expired';
                    sclass = 'bg-danger';
                  }
                  else if(record.service_status == 1){
                    status = 'Pending';
                    sclass = 'bg-warning';
                  }
                  else if(record.service_status == 2){
                    status = 'Completed';
                    sclass = 'bg-success';
                  }
                  else if(record.service_status == 3){
                    status = 'Declined';
                    sclass = 'bg-danger';
                  }
                    var profile_img = (record.profile_img !='')?record.profile_img:'assets/img/placeholder.jpg';

                      html = html +' <div class="col-12 col-lg-6">'+
                        '<div class="technician-widget">'+
                        '<div class="left">'+
                          '<img src="'+base_url+profile_img+'" alt="" width="100" height="100">'+
                        '</div>'+
                        '<div class="right">'+
                        '<div class="inner-right">'+
                        '<span class="badge '+sclass+'">'+status+'</span>'+
                          '<h4>'+record.title+'</h4>'+

                          '<ol>'+
                              '<li class="text-truncate">'+name_text+' : '+record.full_name+'</li>'+
                              '<li class="text-truncate">'+details_text+' : '+record.notes+'</li>';
                           html +='</ol>'+
                      '<div class="location-col d-flex justify-content-between mt-2">'+
                              '<div><i class="fas fa-calendar-week"></i><span>'+record.service_dates+'</span></div>'+
                              '<div><i class="far fa-clock"></i><span>'+record.from_times+'-'+record.to_times+'</span></div>'+
                              '</div>'+
                      '<div class="location-col d-flex justify-content-between align-items-center mt-2 pb-1">'+        
                          '<div><i class="fas fa-phone-alt"></i>'+record.contact_number+'</div>'+
                          '<div>';
                          if(record.service_status == 2){
                                if(record.review_count == 0){

                               html += '<a class="btn" href="javascript:;" onclick="post_reviews('+record.id+','+record.provider_id+')"  data-toggle="modal">'+rate_now_text+'</a>';
                               } }
                          html += 
                          '</div>'+
                          '</div>'+
                      '</div>'+
                      '</div>'+
                       '</div>'+
                    '</div>';

                    });
                    $('.loadmore_results').hide();
                    $('#provider_list').html(html);
                  }else{
                    $('#provider_list').html('<a href="javascript:void(0)" >'+No_result_were_found+'</a>');
                  }

                 });
}


 $('[data-toggle="tooltip"]').tooltip();


  if($('.service-slider').length > 0 ){
    $('.service-slider').owlCarousel({
      items:2,
      margin:30,
      dots:true,
      responsiveClass:true,
      responsive:{
        0:{
          items:1
        },
        768:{
          items:2
        },
        1170:{
          items:2,
          loop:false
        }
      }
    });
  }

  if($('.service-provider-slider').length > 0 ){
    $('.service-provider-slider').owlCarousel({
      items:2,
      margin:30,
      dots:true,
      responsiveClass:true,
      responsive:{
        0:{
          items:1
        },
        768:{
          items:2
        },
        1170:{
          items:2,
          loop:false
        }
      }
    });
  }

//Custom Input Value
$('.custom-inputfile input[type="file').on('change',function(){
    var filename = $(this).val();
    $('.custom-inputfile .file-name-col').html(filename);
});

var cookies_content=$('#cookies_showhide').val();
var cookies_text=$('#cookies_content_text').val();

if(cookies_content == 1 && cookies_text!= '') {
    $(document).herbyCookie({
        btnText: "Accept",
        policyText: "Cookie policy",
        text: cookies_text,
        scroll: false,
        expireDays: 30,
        link: base_url+"cookie-policy"
    });
}

//service auto-complete

 $(document).ready(function(){

    $("#search_list").keyup(function(){
        var service_name = $(this).val();

        if(service_name != ""){

            $.ajax({
                url:  base_url +'home/ajaxSearch',
                type: 'post',
                data: {
                 title:service_name,
                 csrf_token_name:csrf_token
                 },
                dataType: 'json',
                success:function(response){

                    var len = JSON.parse(response.length);
                    $("#searchResult").empty();
                    for( var i = 0; i<len; i++){
                   
                        var id = response[i]['id'];
                        var name = response[i]['title'];

                        $("#searchResult").append("<li value='"+id+"'>"+name+"</li>");

                    }

                    // binding click event to li
                    $("#searchResult li").bind("click",function(){
                        setText(this);
                    });

                }
            });
        }

    });

});

// Set Text to search box and get details
function setText(element){

    var value = $(element).text();
    var userid = $(element).val();
      console.log(value);
    $("#search_list").val(value);
    $("#searchResult").empty();
    
}
