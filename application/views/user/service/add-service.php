<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.js"></script>

<!-- Breadcrub -->
<div class="breadcrub">
    <div class="container">
    <?php
      $service = $language_content['language'];
      $service_array = !empty($service)?$service:'';
    ?>
    <ul>
        <li><a href="<?php echo $base_url; ?>home"><?php echo $service_array['lg_home']; ?></a></li>
        <li><?php echo $service_array['lg6_provide_a_servi']; ?></li>
    </ul>
  </div>
</div>
<!-- /Breadcrub -->

<!-- Add Service -->
<div class="request-service">
    <div class="container">
        <div class="request-title text-center"><h2><?php echo $service_array['lg_add_a_service']; ?></h2></div>
        <div class="request-form">
            <div class="card">
                <div class="card-body">
                    <?php if($this->session->flashdata('error_message')) {  ?>
                        <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message'); } ?>
                    <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message'); } ?>
                    <p class="data_create_error text-danger" style="display: none;"><?php echo $service_array['lg6_title_already_e']; ?></p>
                        <?php if(!empty($this->session->flashdata('notification_message'))) {?>
                        <p class="data_create_success text-success"><?php echo $this->session->flashdata('notification_message'); ?></p>
                        <?php }  ?>
                    <form id="add_service_form" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label><?php echo $service_array['lg6_title']; ?> <span class="text-danger">*</span></label>
                            <input class="form-control" type="text"  name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label><?php echo $service_array['lg6_category']; ?> <span class="text-danger">*</span></label>
                                <select class="form-control select" title="<?php echo $service_array['lg6_category']; ?>" multiple name="category[]" id="category" style="height: 50px !important;" data-live-search="true"></select>
                                <p id="category-error" class="error" for="category" style="display: none;"></p>
                        </div>
                        <div class="form-group">
                            <label><?php echo $service_array['lg6_sub_category']; ?></label>
                                <select class="form-control select" title="<?php echo $service_array['lg6_sub_category']; ?>" name="subcategory[]" id="subcategory" style="height: 50px !important;" multiple data-live-search="true"></select>
                        </div>
                        <div class="form-group des-count">
                            <label><?php echo $service_array['lg6_description_poi']; ?> <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between align-items-center remove-point_1">
                                <div class="w-100">
                                    <input class="form-control" type="text"  name="description[]" id="description1">
                                    <p id="description-error" class="error" for="description" style="display: none;"></p>
                                </div>
                                <div class="ml-3">
                                    <span class="add-icon plus-append-col"  onclick="add_points()"><i class="fas fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="additionalpoints" current_points="2" >
                            <div class="form-group remove_point_2 des-count">
                                <label><?php echo $service_array['lg6_description_poi']; ?> 2 <span class="text-danger">*</span></label>
                                <div class="add-point d-flex justify-content-between align-items-center">
                                    <div class="w-100">
                                        <input class="form-control" type="text"  name="description[]" id="description2">
                                    </div>
                                    <div class="ml-3">
                                        <span class="remove-icon minus-append-col" onclick="remove_points(2)"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo $service_array['lg6_location']; ?> <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between align-items-center add-location-col">
                                <div class="w-100">
                                    <input class="form-control" type="text"  name="location" id="location" data-show="0">
                                        
                                </div>
                                <div class="ml-3">
                                    <a href="javascript:void(0)" class="btn bg-success" id="show_location" data-show="0"><?php echo $service_array['lg_add_location']; ?></a>
                                    <input type="hidden"  name="latitude" id="latitude"  value="11.033151">
                                    <input type="hidden"  name="longitude" id="longitude" value="77.027660">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $service_array['lg6_start_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="start_date" id="start_date">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $service_array['lg6_end_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="end_date" id="end_date">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $service_array['lg6_contact_number']; ?> <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <select name="countryCode" id="countryCode" class="form-control countryCode final_provider_c_code">
                                                <?php
                                                foreach ($country_list as $key => $country) { 
                                                    if($country['country_id']=='91'){$select='selected';}else{ $select='';} 
                                                    ?>
                                                    <option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-8">
                                             <input class="form-control numbers_Only" type="text"  name="contact_number" id="contact_number" maxlength="15">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-0"><?php echo $service_array['lg6_availability']; ?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label class="custom-checkbox">
                                        <span><?php echo $service_array['lg6_all_days']; ?></span>
                                        <input type="checkbox" class="days_check" name="availability[0][day]" value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo $service_array['lg6_from']; ?> 
                                    </div>
                                    <div class="w-75">
                                        <span class="time-select">
                                        <select class="form-control daysfromtime_check"  name="availability[0][from_time]">
                                            <?php echo from_time(1); ?>
                                        </select></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo $service_array['lg6_to']; ?>
                                    </div>
                                    <div class="w-75">
                                         <span class="time-select">
                                        <select class="form-control daystotime_check" name="availability[0][to_time]">
                                            <?php echo to_time(1); ?>
                                        </select></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $day_name = array();
                        $day_name[1] = $service_array['lg6_monday'];
                        $day_name[2] = $service_array['lg6_tuesday'];
                        $day_name[3] = $service_array['lg6_wednesday'];
                        $day_name[4] = $service_array['lg6_thursday'];
                        $day_name[5] = $service_array['lg6_friday'];
                        $day_name[6] = $service_array['lg6_saturday'];
                        $day_name[7] = $service_array['lg6_sunday'];
                        for ($i=1; $i <= 7; $i++) {  ?>
                        <div class="row align-items-center">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label class="custom-checkbox">
                                        <span><?php echo $day_name[$i]; ?></span>
                                        <input type="checkbox" class="eachdays eachdays<?php echo $i; ?>"  name="availability[<?php echo $i; ?>][day]" value="<?php echo $i; ?>">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo $service_array['lg6_from']; ?>
                                    </div>
                                    <div class="w-75">
                                        <span class="time-select">
                                        <select class="form-control eachdayfromtime  eachdayfromtime<?php echo $i; ?>" name="availability[<?php echo $i; ?>][from_time]">
                                            <?php echo from_time(2); ?>
                                        </select></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php echo $service_array['lg6_to']; ?>
                                    </div>
                                    <div class="w-75">
                                        <span class="time-select" >
                                        <select class="form-control  eachdaytotime eachdaytotime<?php echo $i; ?>" name="availability[<?php echo $i; ?>][to_time]" >
                                            <?php echo to_time(1); ?>
                                        </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }
                            function from_time($selected='')
                            {
                                $time_from = '<option value="">-</option>';
                                for ($j=0; $j <=23 ; $j++) {
                                    if($j <10){
                                        $k = '0'.$j;
                                    }else{
                                        $k = $j;
                                    }
                                    if($j <12){
                                        if($j <10){
                                            $label1 = '0'.$j.':00 AM';
                                            $label2 = '0'.$j.':30 AM';
                                        }else{
                                            $label1 = $j.':00 AM';
                                            $label2 = $j.':30 AM';
                                        }

                                    }else{
                                        $s = ($j-12);

                                        if($s ==0){ $s  = 12; }

                                        if($s <10){
                                            $label1 = '0'.$s.':00 PM';
                                            $label2 = '0'.$s.':30 PM';
                                        }else{
                                            $label1 = $s.':00 PM';
                                            $label2 = $s.':30 PM';
                                        }
                                    }
                                    $time_from .= '<option value="'.$label1.'">'.$label1.'</option>';
                                    $time_from .= '<option value="'.$label2.'">'.$label2.'</option>';
                                }
                                return $time_from;
                            }
                            function to_time($selected='')
                            {
                                $to_time = '<option value="">-</option>';
                                for ($j=0; $j <=23 ; $j++) {

                                    if($j <10){
                                        $k = '0'.$j;
                                    }else{
                                        $k = $j;
                                    }

                                    if($j <12){
                                        if($j <10){
                                            $label1 = '0'.$j.':00 AM';
                                            $label2 = '0'.$j.':30 AM';
                                        }else{
                                            $label1 = $j.':00 AM';
                                            $label2 = $j.':30 AM';
                                        }

                                    }else{
                                        $s = ($j-12);

                                        if($s ==0){ $s  = 12; }

                                        if($s <10){
                                            $label1 = '0'.$s.':00 PM';
                                            $label2 = '0'.$s.':30 PM';
                                        }else{
                                            $label1 = $s.':00 PM';
                                            $label2 = $s.':30 PM';
                                        }
                                    }

                                    $to_time .= '<option value="'.$label1.'">'.$label1.'</option>';
                                    $to_time .= '<option value="'.$label2.'">'.$label2.'</option>';
                                }
                            return $to_time;
                            }
                        ?>
                         <div class="form-group">
                            <label class="d-block"><?php echo $service_array['lg_image']; ?></label>
                           <div class="btn avatar-view-btn">
                           <?php echo $service_array['lg_choose_image']; ?>
                            <p style="display: none;"><input type="hidden" id="crop_prof_img" name="service_image"></p>
                        </div>
                            <span class="file-upload-preview">
                            <img src="<?php echo $base_url; ?>assets/img/img-preview.png" alt=""  id="image_upload_preview" style="width: 35px;height: 25px;">
                            </span>
                    </div>
                        <div class="form-group mb-0" style="padding-top: 20px">
                            <button type="submit" class="btn" id="add_service_button"><?php echo $service_array['lg6_submit']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="data_create_loading" style="display: none;"></div>
        </div>
    </div>
</div>
<!-- /Add Service -->

<!--Service Image Modal-->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo $request_array['lg_upload_service_image']; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
        <form class="avatar-form" action="<?=base_url('login/crop_service_img')?>" enctype="multipart/form-data" method="post">

                    <!-- Upload image and data -->
                    <div class="avatar-upload">
                        <input class="avatar-src" name="avatar_src" type="hidden">
                        <input class="avatar-data" name="avatar_data" type="hidden">
                        <label for="avatarInput"><?php echo $request_array['lg1_select_image']; ?></label>
                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
                        <span id="image_upload_error" class="error" style="display:none;"> <?php echo $request_array['lg1_please_upload_a']; ?>. </span>
                    </div>
                    <!-- Crop and preview -->
                    <div class="row">
                        <div class="col-md-12">
                        <div class="avatar-wrapper"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn avatar-save pull-right" type="submit"><?php echo $request_array['lg_save']; ?></button>
                        </div>
                    </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!--/Service Image Modal-->

<script type="text/javascript">
    var description_point = "<?php echo $service_array['lg6_description_poi']; ?>";
</script>

<script>
  $(document).ready(function () {
    $('#add_service_form').validate({ 
        rules: {
            title: {
                required: true
            },
            'category[]': {
              required: true
            },
           
            location:{
              required: true
            },
            contact_number:{
              required: true
            },
            start_date:{
              required: true
            },
            end_date:{
              required: true
            },
            contact_number:{
              required: true
            }
        },
        messages: {
          title:{
            required: 'Enter the title'
          },
          'category[]': {
            required: 'Enter the category'
          },
         
          location: {
            required: 'Enter the location'
          },
          contact_number: {
            required: 'Enter the contact number'
          },
          start_date: {
            required: 'Start date is required'
          },
          end_date: {
            required: 'End date is required'
          }
        }
    }); 


    $(document).on('click','#add_service_button',function(){
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
            alert();
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
});

//Image Upload Preview  
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#avatarInput").change(function () {
    readURL(this);
});
</script>


