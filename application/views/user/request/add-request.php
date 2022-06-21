<!-- Breadcrub -->
<div class="breadcrub">
    <div class="container">
        <?php 
        $request = $language_content['language'];
        $request_array = !empty($request)?$request:'';
        ?>
        <ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $request_array['lg_home']; ?></a></li>
            <li><?php echo $request_array['lg6_request_a_servi']; ?></li>
        </ul>
    </div>
</div>
<!-- /Breadcrub -->

<!-- Request Service -->
<div class="request-service">
    <div class="container">
        <div class="request-title text-center"><h2><?php echo $request_array['lg6_request_a_servi']; ?></h2></div>
        <div class="request-form">
            <div class="card">
                <div class="card-body">
                    <?php if($this->session->flashdata('error_message')) {  ?>
                    <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message'); } ?>
                    <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message'); } ?>
                    <p class="data_create_error text-danger" style="display: none;"><?php echo $request_array['lg6_title_already_e']; ?></p>
                    <?php if(!empty($this->session->flashdata('notification_message'))) {?>
                    <p class="data_create_success text-success"><?php echo $this->session->flashdata('notification_message'); ?></p>
                    <?php }  ?>
                    <form action="#" class="form-horizontal" id="get_request_from">
                        <div class="form-group">
                            <label><?php echo $request_array['lg6_title']; ?> <span class="text-danger">*</span></label>
                            <input class="form-control" type="text"  name="title" id="title">
                            <span class="title_err_msg" name="title_err_msg" style="display:none; color:red">Title is required</span>
                        </div>
                        <div class="form-group des-count">
                            <label><?php echo $request_array['lg6_description_poi']; ?> 1 <span class="text-danger">*</span></label>
                            <div class="add-point d-flex justify-content-between align-items-center position-relative remove-point_1">
                                <div class="w-100">
                                   <textarea class="form-control" name="description[]" id="description1"></textarea>
                                    <span class="description1_err_msg" name="description1_err_msg" style="display:none; color:red"><?php echo $request_array['lg_description_is_required']; ?></span>
                                </div>
                                <div class="ml-3">
                                    <span class="add-icon plus-append-col" onclick="add_points()"><i class="fas fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="additionalpoints" current_points="2" >
                            <div class="form-group remove_point_2 des-count" >
                                <label class="control-label"><?php echo $request_array['lg6_description_poi']; ?> 2 <span class="text-danger">*</span></label>
                                <div class="add-point d-flex justify-content-between align-items-center remove-point_2">
                                    <div class="w-100">
                                        <textarea class="form-control" name="description[]" id="description2"></textarea>
                                        <span class="description2_err_msg" name="description2_err_msg" style="display:none; color:red"><?php echo $request_array['lg_description2_is_required']; ?></span>
                                    </div>
                                    <div class="ml-3">
                                        <span class="remove-icon minus-append-col" data-point="2" onclick="remove_points('2')"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo $request_array['lg6_location']; ?> <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between align-items-center add-location-col">
                                <div class="w-100">
                                    <input class="form-control" type="text"  name="location" id="location">
                                    <span class="location_err_msg" name="location_err_msg" style="display:none; color:red"><?php echo $request_array['lg_location_is_required']; ?></span>
                                </div>
                                <div class="ml-3">
                                    <a href="javascript:void(0)" class="btn bg-success" id="show_location" data-show="0"><?php echo $request_array['lg_add_location']; ?></a>
                                    <input type="hidden"  name="latitude" id="latitude"  value="11.033151">
                                    <input type="hidden"  name="longitude" id="longitude"  value="77.027660">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="request_date" id="request_date">
                                    <span class="request_date_err_msg" name="request_date_err_msg" style="display:none; color:red"><?php echo $request_array['lg_date_is_required']; ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_time']; ?>  <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="request_time" id="request_time">
                                    <span class="request_time_err_msg" name="request_time_err_msg" style="display:none; color:red"><?php echo $request_array['lg_time_is_required']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_proposed_fee']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control numbers_Only" type="text"  name="proposed_fee" id="proposed_fee" maxlength="15">
                                    <span class="proposed_fee_err_msg" name="proposed_fee_err_msg" style="display:none; color:red"><?php echo $request_array['lg_proposed_fee_is_required']; ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_contact_number']; ?>  <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <select name="countryCode" id="countryCode" class="form-control countryCode final_provider_c_code">
                                                <?php
                                                foreach ($country_list as $key => $country) { 
                                                    if($country['country_id']=='91'){$select='selected';}else{ $select='';} ?>
                                                    <option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input class="form-control numbers_Only" type="text"  name="contact_number" id="contact_number" maxlength="15">
                                            <span class="contact_number_err_msg" name="contact_number_err_msg" style="display:none; color:red"><?php echo $request_array['lg_contact_number_is_required']; ?></span>
                                            <small id="contact_number_err_msg" class="text-danger" style="display: none;"><?php echo $request_array['lg_invalid_contact_number']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block"><?php echo $request_array['lg_image']; ?></label>
                          <div class="btn avatar-view-btn">
                           <?php echo $request_array['lg_choose_image']; ?>
                            <p style="display: none;"><input type="hidden" id="crop_prof_img" name="request_image"></p>
                        </div>
                            <span class="file-upload-preview">
                            <img src="<?php echo $base_url; ?>assets/img/img-preview.png" alt=""  id="image_upload_preview" style="width: 50px;height: 50px;object-fit: cover;border-radius: 10px;">
                            </span>
                        </div>
                        <div class="form-group mb-0">
                           <button type="button" class="btn btn-primary submit-btn" onclick="get_request_button();" id="get_request_button1"><?php echo $request_array['lg6_submit']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="data_create_loading" style="display: none;"></div>
        </div>
    </div>
</div>
<!-- Request Service -->

<!--Request Image Modal-->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo $request_array['lg1_profile_image']; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
        <form class="avatar-form" action="<?=base_url('login/crop_request_img')?>" enctype="multipart/form-data" method="post">

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
                            <button class="btn avatar-save pull-right" type="submit">Save</button>
                        </div>
                    </div>
            </form>
        </div>
        </div>
    </div>
</div>
<!--/Request Image Modal-->

<script type="text/javascript">
	var description_point = "<?php echo $request_array['lg6_description_poi']; ?>";
</script>
