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

<!-- Edit Request -->
<div class="request-service">
    <div class="container">
        <div class="request-title text-center"><h2><?php echo $request_array['lg6_request_a_servi']; ?></h2></div>
        <div class="request-form">
            <div class="card">
                <div class="card-body">
                    <p class="data_create_error text-danger" style="display: none;"><?php echo $request_array['lg6_title_already_e']; ?></p>
                    <form action="#" class="form-horizontal" id="edit_request_from">
                        <div class="form-group">
                            <label><?php echo $request_array['lg6_title']; ?> <span class="text-danger">*</span></label>
                            <input class="form-control" type="text"  name="title" id="title" value="<?php echo $request_details['title']; ?>">
                            <input class="form-control" type="hidden"  name="r_id" id="r_id" value="<?php echo $request_details['r_id']; ?>">
                        </div>
                        <?php
                            $description_details = (!empty($request_details['description']))?$request_details['description']:'';
                            if(!empty($description_details)){
                                $description_details = json_decode($description_details);
                            }
                            $count = count($description_details);
                            $i =1;
                            foreach ($description_details as $description) {
                                if($i<=$count){
                        ?>                  
                        <div class="form-group">
                            <div class="form-group remove_point_<?php echo $i; ?> des-count" >
                            <label><?php echo $request_array['lg6_description_poi']; ?> <?php echo $i; ?><span class="text-danger">*</span></label>
                            <div class="remove-point d-flex justify-content-between align-items-center remove-point_<?php echo $i; ?>">
                                <div class="w-100">
                                    <input class="form-control" type="text"  name="description[]" id="description1" value="<?php echo $description; ?>">
                                </div>
                                <?php if($i==1 && $i >=5) { ?>
                                    <div class="ml-3">
                                        <span class="add-icon plus-append-col" onclick="add_points()"><i class="fas fa-plus"></i></span>
                                    </div>
                                <?php } ?>
                                <?php if($i!=1) { ?>
                                    <div class="ml-3">
                                        <span class="remove-icon minus-append-col" onclick="remove_points(<?php echo $i; ?>)"><i class="fas fa-times"></i></span>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                        </div>
                        <?php $i++; } } 
                        if($i <= 5) { ?>
                            <div class="additionalpoints" current_points="<?php echo $count; ?>" ></div>
                        <?php } else { ?>
                                <div class="additionalpoints" current_points="<?php echo $count; ?>" ></div>
                        <?php }
                        ?>
                      
                        <div class="form-group">
                            <label><?php echo $request_array['lg6_location']; ?> <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-between align-items-center add-location-col">
                                <div class="w-100">
                                    <input class="form-control" type="text"  name="location" id="location" data-show="0" value="<?php echo $request_details['location']; ?>">
                                <input type="hidden"  name="latitude" id="latitude" value="<?php echo !empty($request_details['latitude'])?$request_details['latitude']:'11.033151'; ?>">
                                <input type="hidden"  name="longitude" id="longitude" value="<?php echo !empty($request_details['longitude'])?$request_details['longitude']:'77.027660'; ?>">
                                </div>
                                <div class="ml-3">
                                    <a href="javascript:void(0)" class="btn bg-success" id="show_location" data-show="0"><?php echo $request_array['lg_add_location']; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="request_date" id="request_date" value="<?php echo date("d-m-Y", strtotime($request_details['request_date'])); ?>">
                                    <input class="form-control" type="hidden" name="current_date" id="current_date" value="<?php date_default_timezone_set("Asia/Kuala_Lumpur"); echo $current_date = date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_time']; ?>  <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"  name="request_time" id="request_time" value="<?php echo $request_details['request_time']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $request_array['lg6_proposed_fee']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control numbers_Only" type="text"  name="proposed_fee" id="proposed_fee" maxlength="15" value="<?php echo $request_details['amount']; ?>">
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
                                                    if($country['country_id']==$request_details['country_code']){$select='selected';}else{ $select='';} ?>
                                                    <option <?=$select;?> data-countryCode="<?=$country['country_code'];?>" value="<?=$country['country_id'];?>"><?=$country['country_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <input class="form-control numbers_Only" type="text"  name="contact_number" id="contact_number" maxlength="15" value="<?php echo $request_details['contact_number']; ?>">
                                            <small id="contact_number_err_msg" class="text-danger" style="display: none;"><?php echo $request_array['lg_invalid_contact_number']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            if($request_details['request_image']) {
                                $req_image = base_url().$request_details['request_image'];
                            } else {
                                $req_image = $base_url.'assets/img/img-preview.png';   
                            }
                        ?>
                        <div class="form-group">
                            <label class="d-block">Image</label>
                           <div class="btn avatar-view-btn">
                            Choose Image
                            <p style="display: none;"><input type="hidden" id="crop_prof_img" name="request_image"></p>
                        </div>
                            <span class="file-upload-preview">
                            <img src="<?php echo $req_image; ?>" alt=""  id="image_upload_preview" style="width: 50px;height: 50px;object-fit: cover;border-radius: 10px;">
                            </span>
                        </div>
                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-primary submit-btn" id="edit_request_button"><?php echo $request_array['lg6_submit']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="data_create_loading" style="display: none;"></div>
    </div>
</div>
<!-- Edit Request -->

<!--Request Image Modal-->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo $request_array['lg_request_image']; ?></h5>
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
                            <button class="btn avatar-save pull-right" type="submit"><?php echo $request_array['lg_save']; ?></button>
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
