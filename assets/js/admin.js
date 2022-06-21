
var csrf_token=$('#admin_csrf').val();
$( document ).ready(function() {
    /* Paypal - Start */
    var paypal_type= $("input[name='gateway_type']:checked").val(); 
    if(paypal_type=="sandbox"){
       $('#paypal_sandbox').show();
       $('#paypal_live').hide();
    } else {
        $('#paypal_sandbox').hide();
       $('#paypal_live').show();
    }

    $("input[name='gateway_type']").on('change',function(e){
        var paypal_gateway_type= $(this).val();
        if(paypal_gateway_type=="sandbox"){
           $('#paypal_sandbox').show();
           $('#paypal_live').hide();
        } else {
            $('#paypal_sandbox').hide();
           $('#paypal_live').show();
        }
           
    });
    /* Paypal - End */

    /* Paytab - Start */
    var paytab_type= $("input[name='paytab_gateway_type']:checked").val(); 
    if(paytab_type=="sandbox"){
       $('#paytab_sandbox').show();
       $('#paytab_live').hide();
    } else {
        $('#paytab_sandbox').hide();
       $('#paytab_live').show();
    }

    $("input[name='paytab_gateway_type']").on('change',function(e){
        var paypal_gateway_type= $(this).val();
        if(paypal_gateway_type=="sandbox"){
           $('#paytab_sandbox').show();
           $('#paytab_live').hide();
        } else {
            $('#paytab_sandbox').hide();
           $('#paytab_live').show();
        }
    });
    /* Paytab - End */

    /* Razorpay - Start */
    var razorpay_type= $("input[name='razorpay_gateway_type']:checked").val(); 
    if(razorpay_type=="sandbox"){
       $('#razorpay_sandbox').show();
       $('#razorpay_live').hide();
    } else {
        $('#razorpay_sandbox').hide();
       $('#razorpay_live').show();
    }

    $("input[name='razorpay_gateway_type']").on('change',function(e){
        var razorpay_gateway_type= $(this).val();
        if(razorpay_gateway_type=="sandbox"){
           $('#razorpay_sandbox').show();
           $('#razorpay_live').hide();
        } else {
            $('#razorpay_sandbox').hide();
           $('#razorpay_live').show();
        }
    });
    /* Razorpay - End */

  $("#banner_submit").on('click',function(e){
    var form = $('#banner_form')[0];
    var formData = new FormData(form);
    var banner=$('#banners').val();
    var width=$('#banners').width();
    var height = $('#banners').height();
    if(banner==''){
      $('.banner_error').text('Kindly Upload Image').css('color','red').show();
    }else{
     $('.banner_error').hide();

      $.ajax({
        url :banner_url,
        type: "POST",
        data:formData,
        dataType: "JSON",
        cache:false,
        contentType: false,
        processData: false,
        beforeSend:function() {
          $('#banner_submit').html('<div class="spinner-border text-light" role="status"></div>');
          $('#banner_submit').attr('disabled',true);
        },
        success: function(data)
        {
          $('#banner_submit').html('Save Changes');
          $('#banner_submit').attr('disabled',false);
          if(data.success){
            $('#banner_img_url').attr('src',data.img);
            toastr.success('Banner image added successFully');
          }else{
            toastr.error(data.msg);
          }
        },
        error:function(){
		}
		});
    }
  });
  $("#specialities_submit").on('click',function(e){
    e.preventDefault();
    var form = $('#specialities_form')[0];
    var formData = new FormData(form);
    var title=$('#specialities_title').val();
    var content=$('#specialities_content').val();
    if(title=="" || content==""){
     $('.title_error').text('Title is Required').css('color','red').show();
     $('.content_error').text('Content is Required').css('color','red').show();
   }
   if(title!=''&&content!=''){

     $('.title_error').hide();
     $('.content_error').hide();

     $.ajax({
      url :specialities_url,
      type: "POST",
      data:{specialities_title:title,specialities_content:content},
      dataType: "JSON",
      beforeSend:function() {
        $('#specialities_submit').html('<div class="spinner-border text-light" role="status"></div>');
        $('#specialities_submit').attr('disabled',true);
      },
      success: function(data)
      {
        $('#specialities_submit').html('Save Changes');
        $('#specialities_submit').attr('disabled',false);
        toastr.success('Specialities content added successfully');
      },
      error:function(){
                   }
                 });

   }
 });
  $("#doctor_submit").on('click',function(e){
    e.preventDefault();
    var form = $('#doctor_form')[0];
    var formData = new FormData(form);
    var title=$('#doctor_title').val();
    var content=$('#doctor_content').val();
    if(title=="" || content==""){
     $('.doctor_title_error').text('Title is Required').css('color','red').show();
     $('.doctor_content_error').text('Content is Required').css('color','red').show();
   }
   if(title!=''&&content!=''){

     $('.doctor_title_error').hide();
     $('.doctor_content_error').hide();

     $.ajax({
      url :specialities_url,
      type: "POST",
      data:{doctor_title:title,doctor_content:content},
      dataType: "JSON",
      beforeSend:function() {
        $('#doctor_submit').html('<div class="spinner-border text-light" role="status"></div>');
        $('#doctor_submit').attr('disabled',true);
      },
      success: function(data)
      {
        $('#doctor_submit').html('Save Changes');
        $('#doctor_submit').attr('disabled',false);
        toastr.success('Book our doctor content added successFully');
      },
      error:function(){
                   }
                 });

   }
 });


  $("#login_image_submit").on('click',function(e){
    alert(111);
    e.preventDefault();
    var form = $('#login_form')[0];
    var formData = new FormData(form);
    var banner=$('#login_images').val();
alert(login_url);


    if(banner==''){
      $('.login_error').text('Kindly Upload Image').css('color','red').show();
    }else{
     $('.login_error').hide();



      $.ajax({
        url :login_url,
        type: "POST",
        data:formData,
        dataType: "JSON",
        cache:false,
        contentType: false,
        processData: false,
        beforeSend:function() {
          $('#login_image_submit').html('<div class="spinner-border text-light" role="status"></div>');
          $('#login_image_submit').attr('disabled',true);
        },
        success: function(data)
        {
          $('#login_image_submit').html('Save Changes');
          $('#login_image_submit').attr('disabled',false);

          if(data.success){
            $('#img_url').attr('src',data.img);
            toastr.success('Login image added Successfully');
          }else{
            toastr.error(data.msg);
          }

        },
        error:function(){
                   }
                 });

    }
  });


  $("#availabe_feature_image_submit").on('click',function(e){
    e.preventDefault();
    var form = $('#availabe_feature')[0];
    var formData = new FormData(form);
    var banner=$('#availabe_feature_images').val();


    if(banner==''){
      $('.availabe_feature_error').text('Kindly Upload Image').css('color','red').show();
    }else{
     $('.availabe_feature_error').hide();

      $.ajax({
        url :feature_url,
        type: "POST",
        data:formData,
        dataType: "JSON",
        cache:false,
        contentType: false,
        processData: false,
        beforeSend:function() {
          $('#availabe_feature_image_submit').html('<div class="spinner-border text-light" role="status"></div>');
          $('#availabe_feature_image_submit').attr('disabled',true);
        },
        success: function(data)
        {
          $('#availabe_feature_image_submit').html('Save Changes');
          $('#availabe_feature_image_submit').attr('disabled',false);

          if(data.success){
            $('#feature_img_url').attr('src',data.img);
            toastr.success('Available feature image added Successfully');
          }else{
            toastr.error(data.msg);
          }

        },
        error:function(){
                   }
                 });

    }
  });

  $(document).on("click","#reset_menu",function(e){
  
  $.ajax({
      url: base_url+'admin/footer_menu/resetMenu',
      data: {csrf_token_name:csrf_token},
      type: 'POST',
      dataType: 'JSON',
      success: function(response){
        window.location.href = base_url+'admin/frontend-settings';
      },
      error: function(error){
        console.log(error);
      }
    });
});

  $(document).on("click",".addlinks",function () {
    var len = $('.links-cont').length + 1;
    if(len <= 5) {
        var navmenus = '<div class="form-group links-cont"><div class="row align-items-center"><div class="col-lg-3 col-12"><input type="text" class="form-control" name="menu_title[]" id="menu_title" placeholder="Title"></div><div class="col-lg-8 col-12"><input type="text" class="form-control" name="menu_links[]" id="menu_links" placeholder="Links" value="'+base_url+'"></div><div class="col-lg-1 col-12"><a href="#" class="btn btn-sm bg-danger-light delete_menu"><i class="far fa-trash-alt "></i>  </a></div></div></div> ';
      $(".settings-form").append(navmenus);
      return false;
    } else {
        $('.addlinks').hide();
        alert('Allow 5 menus only');
    }
});

//Remove updated header menus
$(document).on("click",".delete_menus",function () {
    var id = $(this).attr('data-id');
    $('#menu_'+id).remove();
    return false;
});
//Remove new header menus
$(document).on("click",".delete_menu",function () {
    $(this).closest('.links-cont').remove();
    return false;
});

function getcurrencysymbol(currencies) { 
     var csrf_toiken=$('#admin_csrf').val();
    $.ajax({
        type: "POST",
        url:  base_url+"admin/settings/get_currnecy_symbol",
        data:{
          id:currencies,
         'csrf_token_name': csrf_token,
        }, 
                     
        success: function (data) {
            $('#currency_symbol').val(data); 
          
        }
    });
}
$(document).ready(function() {
  $(document).on("change",".currency_code",function() {
    var currencies = $('#currency_option option:selected').text();
    getcurrencysymbol(currencies);
  });

  //Get country code key value
  $(document).on("change",".countryCode",function() {
        var countryKey = $(this).find(':selected').attr('data-countrycode');
        $('#country_code_key').val(countryKey); 
    });
});

 $( document ).ready(function() {
       $('.smtpMail').hide();
            var mail_config=$('#mail_config').val();

            if(mail_config=="phpmail"){
                $('.phpMail').show();
                $('.smtpMail').hide();
                $("#phpmail").prop("checked", true);
            }else{
               $("#smtpmail").prop("checked", true);
               $('.smtpMail').show();
            $('.phpMail').hide();
            }
            $('input[type=radio][name=mail_config]').on('change',function() {
           var mail_config=$(this).val();
           if(mail_config=="smtp"){
            $('.smtpMail').show();
            $('.phpMail').hide();
           }else{
                $('.phpMail').show();
                $('.smtpMail').hide();
           }
        });
    });
    $('#form_emailsetting').bootstrapValidator({
        container: '#messages',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
           
            email_address: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and cannot be empty'
                    }
                }
            }
        }
    });

     $(document).on("click",".addlinknew",function () {
    var len = $('.links-cont').length + 1;
    if(len <= 6) {
      var experiencecontent = '<div class="form-group links-cont">' +
      '<div class="row align-items-center">' +
      '<div class="col-lg-3 col-12">' +
      '<input type="text" class="form-control" name="label[]" attr="label" id="label" value="">' +
      '</div>' +
      '<div class="col-lg-8 col-12">' +
      '<input type="text" class="form-control" name="link[]" attr="link" id="link" value="'+base_url+'">' +
      '</div>' +
      '<div class="col-lg-1 col-12">' +
      '<a href="#" class="btn btn-sm bg-danger-light delete_links">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div>' +
      '</div>' ;
        $(".links-forms").append(experiencecontent);
    } else {
        $('.addlinknew').hide();
        alert('Allow 6 links only');
    }
  return false;
});

//Remove updated Links menus
$(document).on("click",".delete_links",function () {
    var id = $(this).attr('data-id');
    $('#link_'+id).remove();
    return false;
});

//Remove new Links menus
$(document).on("click",".delete_links",function () {
    $(this).closest('.links-cont').remove();
    return false;
});

$(document).on("click",".addsocail",function () {
  var experiencecontent = '<div class="form-group countset">' +
  '<div class="row align-items-center">' +
  '<div class="col-lg-2 col-12">' +
  '<div class="socail-links-set">' +
  '<ul>' +
  '<li class=" dropdown has-arrow main-drop">' +
  '<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">' +
  '<span class="user-img">' +
  '<i class="fab fa-github me-2"></i>' +
  '</span>' +
  '</a>' +
  '<div class="dropdown-menu">' +
  '<a class="dropdown-item" href="#"><i class="fab fa-facebook-f me-2"></i>Facebook</a>' +
  '<a class="dropdown-item" href="#"><i class="fab fa-twitter me-2"></i>twitter</a>' +
  '<a class="dropdown-item" href="#"><i class="fab fa-youtube me-2"></i> Youtube</a>' +
  '</div>' +
  '</li>' +
  '</ul>' +
  '</div>' +
  '</div>' +
  '<div class="col-lg-9 col-12">' +
  '<input type="text" class="form-control" name="snapchat" attr="snapchat" id="facebook" value="">' +
  '</div>' +
  '<div class="col-lg-1 col-12">' +
  '<a href="#" class="btn btn-sm bg-danger-light  delete_review_comment">' +
  '<i class="far fa-trash-alt "></i> ' +
  '</a>' +
  '</div>' +
  '</div> ' +
  '</div> ';
  
  $(".setings").append(experiencecontent);
  return false;
});

$(".setings").on('click','.delete_review_comment', function () {
  $(this).closest('.countset').remove();
  return false;
});

$(document).on("click",".addnewlinks",function () {
    var len = $('.copyright_content').length + 1;
    if(len <= 3) {
    var experiencecontent = '<div class="form-group links-conts copyright_content">' +
      '<div class="row align-items-center">' +
      '<div class="col-lg-3 col-12">' +
      '<input type="text" class="form-control" value="" name="label1[]">' +
      '</div>' +
      '<div class="col-lg-8 col-12">' +
      '<input type="text" class="form-control" value="'+base_url+'" name="link1[]">' +
      '</div>' +
      '<div class="col-lg-1 col-12">' +
      '<a href="#" class="btn btn-sm bg-danger-light delete_copyright">' +
      '<i class="far fa-trash-alt "></i> ' +
      '</a>' +
      '</div>' +
      '</div>' +
      '</div>' ;
      $(".settingset").append(experiencecontent);
        return false;
    } else {
        $('.addnewlinks').hide();
        alert('Allow 3 links only');
    } 
  
});

//Remove updated copyright menus
$(document).on("click",".delete_copyright",function () {
    var id = $(this).attr('data-id');
    $('#link1_'+id).remove();
    return false;
});

//Remove new copyright menus
$(document).on("click",".delete_copyright",function () {
    $(this).closest('.links-conts').remove();
    return false;
});

 $(document).on("click", ".delete_show", function () {
    var id=$(this).attr('data-id');
    delete_modal_show(id);
  });

   $(document).on("click",".addfaq",function () {
  var experiencecontent = '<div class="row counts-list" id="faq_content">' +
  '<div class="col-md-11">' +
  '<div class="cards">' +
  '<div class="form-group">' +
  '<label>Title</label>' +
  '<input type="text" class="form-control" name="page_title[]" style="text-transform: capitalize;" required>' +
  '</div>' +
  '<div class="form-group mb-0">' +
  '<label>Page Content</label>' +
  ' <textarea class="form-control content-textarea" id="ck_editor_textarea_id"  name="page_content[]"></textarea>'+
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="col-md-1">' +
  '<a href="#" class="btn btn-sm bg-danger-light delete_faq">' +
  '<i class="far fa-trash-alt "></i> ' +
  '</a>' +
  '</div>' +
  '</div> ';
  
  $(".faq").append(experiencecontent);
  return false;
});

//Remove updated Faq content
$(document).on("click",".delete_faq_content",function () {
    var id = $(this).attr('data-id');
        $('#faq_'+id).remove();
    return false;
});

//Remove new Faq content
$(document).on("click",".delete_faq",function () {
    $(this).closest('#faq_content').remove();
    return false;
});
  
  function faq_delete(id)
  {
  var r = confirm("Deleting FAQ will also delete its related all datas!! ");
    if (r == true) {

      var csrf_token = $('#active_csrf').val();
      $.ajax({
        type: 'POST',
        url: base_url+"admin/settings/faq_delete",
        data: {
          id: id, 
          csrf_token_name: csrf_token
        },
        success: function (response)
        {

          if (response == 'success')
          {
            window.location = base_url+'admin/settings/faq_delete';
          }else{
            
            window.location = base_url+'admin/settings/faq_delete';
          }
        }
      });

    } else {
      return false;
    }
  

}
 $(document).ready(function() {
            $(document).on("click",".faq_delete",function() {
                var id = $(this).attr('data-id');
                faq_delete(id);
            });
       });

 $('#pages_status').on('click','.pages_status', function () {
        var id = $(this).attr('data-id');
        pages_status(id);
    });
  function pages_status(id){
  var stat= $('#pages_status'+id).prop('checked');
  if(stat==true) {
    var status=1;
  }
  else {
    var status=0;
  }
  var url = base_url+ 'admin/settings/page_status';
  var status_id = id;
  var status = status;
  var data = { 
    status_id: status_id,
    status: status,
    csrf_token_name:csrf_token
  };
  $.ajax({
    url: url,
    data: data,
    type: "POST",
    success: function (data) {
      console.log(data);
      if(data=="success"){
         swal({
     title: "Pages",
     text: "Status Change SuccessFully....!",
     icon: "success",
     button: "okay",
     closeOnEsc: false,
     closeOnClickOutside: false,
     });
      }
    }
  });
  }

   $('.chngstatus').on('change', function()
    {
      var id = $(this).attr('data-id');
      var statusId = $(this).val();
     
      if (statusId) {
        var url = base_url+ 'admin/settings/offline_status';
        var status_id = id;
        var status = status;
        var data = { 
          status_id: status_id,
          status: statusId,
          csrf_token_name:csrf_token
        };
        $.ajax({
          url: url,
          data: data,
          type: "POST",
          success: function (data) {
            console.log(data);
            if(data=="success"){
             window.location.href = base_url+'admin/offlinepayment_details';
            }
            
          }
        });
      }
      else 
      {
        return false;
      }
    });

});
