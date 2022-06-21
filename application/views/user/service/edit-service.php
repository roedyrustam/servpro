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
		<div class="request-title text-center"><h2><?php echo $service_array['lg6_provide_a_servi']; ?></h2></div>
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
					<form id="edit_service_form" method="post" action="<?php echo base_url()."update_service"; ?>">
						<div class="form-group">
							<label><?php echo $service_array['lg6_title']; ?> <span class="text-danger">*</span></label>
							<input class="form-control" type="text"  name="title" id="title" value="<?php echo $service_details['title']; ?>">
							<input class="form-control" type="hidden"  name="p_id" id="p_id" value="<?php echo $service_details['p_id']; ?>">
						</div>
						<div class="form-group">
							<label><?php echo $service_array['lg6_category']; ?><span class="text-danger">*</span></label>
							<input type="hidden" id="category_id" value="<?php echo $service_details['category'];?>">
                            <select class="form-control select" multiple title="<?php echo $service_array['lg6_category']; ?>" name="category[]" id="category" style="height: 50px !important;" data-live-search="true"></select>
						</div>
						<div class="form-group">
							<label><?php echo $service_array['lg6_sub_category']; ?><span class="text-danger">*</span></label>
							<input type="hidden" id="subcategory_id" value="<?php echo $service_details['subcategory']; ?>">
                            <select class="form-control select" multiple title="<?php echo $service_array['lg6_sub_category']; ?>" name="subcategory[]" id="subcategory" style="height: 50px !important;" data-live-search="true"></select>
						</div>	
						<?php
							$description_details = (!empty($service_details['description_details']))?$service_details['description_details']:'';
							if(!empty($description_details)){
								$description_details = json_decode($description_details);
							}
							$count = count($description_details);
							$i =1;
							foreach ($description_details as $description) {
							if($i<=$count){
							//if($i==1){
						?>					
						<div class="form-group">
							<div class="form-group remove_point_<?php echo $i; ?> des-count" >
							<label><?php echo $service_array['lg6_description_poi']; ?> <?php echo $i; ?><span class="text-danger">*</span></label>
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
							<label><?php echo $service_array['lg6_location']; ?> <span class="text-danger">*</span></label>
							<div class="d-flex justify-content-between align-items-center add-location-col">
								<div class="w-100">
									<input class="form-control" type="text"  name="location" id="location" data-show="0" value="<?php echo $service_details['location']; ?>">
                                <input type="hidden"  name="latitude" id="latitude" value="<?php echo !empty($service_details['latitude'])?$service_details['latitude']:'11.033151'; ?>">
                                <input type="hidden"  name="longitude" id="longitude" value="<?php echo !empty($service_details['longitude'])?$service_details['longitude']:'77.027660'; ?>">
								</div>
								<div class="ml-3">
									<a href="javascript:void(0)" class="btn bg-success" id="location" data-show="0"><?php echo $service_array['lg_add_location']; ?></a>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $service_array['lg6_start_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_start_date" id="start_date"  value="<?php echo date('d-m-Y', strtotime($service_details['start_date']));?>">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label><?php echo $service_array['lg6_end_date']; ?> <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_end_date" id="end_date" value="<?php echo date('d-m-Y', strtotime($service_details['end_date']));?>">
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
                                             <input class="form-control numbers_Only" type="text"  name="contact_number" id="contact_number" maxlength="15" value="<?php echo $service_details['contact_number'];?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
							<label class="mb-0"><?php echo $service_array['lg6_availability']; ?> <span class="text-danger">*</span></label>
						</div>
						<?php
							$availability_details = (!empty($service_details['availability']))?$service_details['availability']:'';
							if(!empty($availability_details)){
								$availability_details = json_decode($availability_details,true);
							}
								$days = array();
								$Monday_from_time = '';
								$Monday_to_time = '';
								$Tuesday_from_time = '';
								$Tuesday_to_time = '';
								$Wednesday_from_time = '';
								$Wednesday_to_time = '';
								$Thursday_from_time = '';
								$Thursday_to_time = '';
								$Friday_from_time = '';
								$Friday_to_time = '';
								$Saturday_from_time = '';
								$Saturday_to_time = '';
								$Sunday_from_time = '';
								$Sunday_to_time = '';
								$Monday_checked = '';
								$Tuesday_checked = '';
								$Wednesday_checked = '';
								$Thursday_checked = '';
								$Friday_checked = '';
								$Saturday_checked = '';
								$Sunday_checked = '';
								foreach ($availability_details as $availability) {
									$days[] = $availability['day'];
									if($availability['day'] == 1){
										$Monday = '';
										$Monday_checked = 'checked';
										$Monday_from_time = $availability['from_time'];
										$Monday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 2){
										$Tuesday = '';
										$Tuesday_checked = 'checked';
										$Tuesday_from_time = $availability['from_time'];
										$Tuesday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 3){
										$Wednesday = '';
										$Wednesday_checked = 'checked';
										$Wednesday_from_time = $availability['from_time'];
										$Wednesday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 4){
										$Thursday = '';
										$Thursday_checked = 'checked';
										$Thursday_from_time = $availability['from_time'];
										$Thursday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 5){
										$Friday = '';
										$Friday_checked = 'checked';
										$Friday_from_time = $availability['from_time'];
										$Friday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 6){
										$Saturday = '';
										$Saturday_checked = 'checked';
										$Saturday_from_time = $availability['from_time'];
										$Saturday_to_time = $availability['to_time'];
									}
									if($availability['day'] == 7){
										$Sunday = '';
										$Sunday_checked = 'checked';
										$Sunday_from_time = $availability['from_time'];
										$Sunday_to_time = $availability['to_time'];
									}
								}
								$day_count = count($days);
								$checked = '';
								$Monday = '';
								$Tuesday = '';
								$Wednesday = '';
								$Thursday = '';
								$Friday = '';
								$Saturday = '';
								$Sunday = '';
								if($day_count == 7)
								{
									$checked = 'checked';
									$Monday = 'disabled';
									$Tuesday = 'disabled';
									$Wednesday = 'disabled';
									$Thursday = 'disabled';
									$Friday = 'disabled';
									$Saturday = 'disabled';
									$Sunday = 'disabled';

									$All_from_time = $Monday_from_time;
									$All_to_time = $Monday_to_time;
									$Monday_checked = '';
									$Tuesday_checked = '';
									$Wednesday_checked = '';
									$Thursday_checked = '';
									$Friday_checked = '';
									$Saturday_checked = '';
									$Sunday_checked = '';
								}
								else {
									$checked = '';
									$All_from_time = '-';
									$All_to_time = '-';
								}
						?>
						<div class="row align-items-center">
							<div class="col-12 col-lg-4">
								<div class="form-group">
									<label class="custom-checkbox">
										<span><?php echo $service_array['lg6_all_days']; ?></span>
									  	<input type="checkbox" class="days_check" name="availability[0][day]" value="1" <?php echo $checked; ?>>
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
										<select class="form-control daysfromtime_check select"  name="availability[0][from_time]">
											<?php echo from_time(1, $All_from_time); ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4">
								<div class="form-group d-flex justify-content-between align-items-center">
									<div>
										<?php echo $service_array['lg6_to']; ?> 
									</div>
									<div class="w-75">
										<select class="form-control daystotime_check select" name="availability[0][to_time]">
											<?php echo to_time(1, $All_to_time); ?>
										</select>
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

							$day_name_checked = array();
							$day_name_checked[1] = 'Monday_checked';
							$day_name_checked[2] = 'Tuesday_checked';
							$day_name_checked[3] = 'Wednesday_checked';
							$day_name_checked[4] = 'Thursday_checked';
							$day_name_checked[5] = 'Friday_checked';
							$day_name_checked[6] = 'Saturday_checked';
							$day_name_checked[7] = 'Sunday_checked';

							$var_from_time = array();
							$var_from_time[1] = 'Monday_from_time';
							$var_from_time[2] = 'Tuesday_from_time';
							$var_from_time[3] = 'Wednesday_from_time';
							$var_from_time[4] = 'Thursday_from_time';
							$var_from_time[5] = 'Friday_from_time';
							$var_from_time[6] = 'Saturday_from_time';
							$var_from_time[7] = 'Sunday_from_time';

							$var_to_time = array();
							$var_to_time[1] = 'Monday_to_time';
							$var_to_time[2] = 'Tuesday_to_time';
							$var_to_time[3] = 'Wednesday_to_time';
							$var_to_time[4] = 'Thursday_to_time';
							$var_to_time[5] = 'Friday_to_time';
							$var_to_time[6] = 'Saturday_to_time';
							$var_to_time[7] = 'Sunday_to_time';
						for ($i=1; $i <= 7; $i++) {  ?>
						<div class="row align-items-center">
							<div class="col-12 col-lg-4">
								<div class="form-group">
									<label class="custom-checkbox">
										<span><?php echo $day_name[$i]; ?></span>
									  	<input type="checkbox" class="eachdays eachdays<?php echo $i; ?>"  name="availability[<?php echo $i; ?>][day]" value="<?php echo $i; ?>" <?php echo $$day_name_checked[$i]; ?> <?php echo $$day_name[$i]; ?>> 
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
										<select class="form-control select eachdayfromtime eachdayfromtime<?php echo $i; ?>" name="availability[<?php echo $i; ?>][from_time]" <?php echo $$day_name[$i]; ?>>
											<?php echo from_time(2, $$var_from_time[$i]); ?>
										</select>

									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4">
								<div class="form-group d-flex justify-content-between align-items-center">
									<div>
										<?php echo $service_array['lg6_to']; ?>
									</div>
									<div class="w-75">
											<select class="form-control select eachdaytotime eachdaytotime<?php echo $i; ?>" name="availability[<?php echo $i; ?>][to_time]" <?php echo $$day_name[$i]; ?>>
												<?php echo to_time(1, $$var_to_time[$i]); ?>
											</select>
									</div>
								</div>
							</div>
						</div>
						<?php }

							function from_time($selected='', $my_from_time)
							{
								if($my_from_time == '-'){
									$time_from = '<option value="" selected>-</option>';
								}
								else{
									$time_from = '<option value="">-</option>';
								}
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

										if($s ==0){ $s	= 12; }

										if($s <10){
											$label1 = '0'.$s.':00 PM';
											$label2 = '0'.$s.':30 PM';
										}else{
											$label1 = $s.':00 PM';
											$label2 = $s.':30 PM';
										}
									}
									if($my_from_time == $label1){
										$time_from .= '<option value="'.$label1.'" selected>'.$label1.'</option>';
									}else{
										$time_from .= '<option value="'.$label1.'">'.$label1.'</option>';
									}

									if($my_from_time == $label2){
										$time_from .= '<option value="'.$label2.'" selected>'.$label2.'</option>';
									}else{
										$time_from .= '<option value="'.$label2.'">'.$label2.'</option>';
									}
								}
								return $time_from;
							}
							function to_time($selected='', $my_to_time)
							{
								if($my_to_time == '-'){
									$to_time = '<option value="" selected>-</option>';
								}
								else{
									$to_time = '<option value="">-</option>';
								}
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

										if($s ==0){ $s	= 12; }

										if($s <10){
											$label1 = '0'.$s.':00 PM';
											$label2 = '0'.$s.':30 PM';
										}else{
											$label1 = $s.':00 PM';
											$label2 = $s.':30 PM';
										}
									}
									if($my_to_time == $label1){
										$to_time .= '<option value="'.$label1.'" selected>'.$label1.'</option>';
									}else{
										$to_time .= '<option value="'.$label1.'">'.$label1.'</option>';
									}

									if($my_to_time == $label2){
										$to_time .= '<option value="'.$label2.'" selected>'.$label2.'</option>';
									}else{
										$to_time .= '<option value="'.$label2.'">'.$label2.'</option>';
									}
								}
							return $to_time;
							}
						?>
						<?php
                            if(!empty($service_details['service_image'])) {
                                $req_image = base_url().$service_details['service_image'];
                            } else {
                                $req_image = $base_url.'assets/img/img-preview.png';   
                            }
                        ?>
						<div class="form-group">
                            <label class="d-block">Image</label>
                           <div class="btn avatar-view-btn">
                            Choose Image
                            <p style="display: none;"><input type="hidden" id="crop_prof_img" name="service_image"></p>
                        </div>
                            <span class="file-upload-preview">
                            <img src="<?php echo $req_image; ?>" alt=""  id="image_upload_previewaaa" style="width: 35px;height: 25px;">
                            </span>
                    </div>
						<div class="form-group mb-0">
							<button type="submit" class="btn" id="edit_service_button"><?php echo $service_array['lg6_submit']; ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Request Service -->

<!--Service Image Modal-->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Service Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
        <form class="avatar-form" action="<?=base_url('login/crop_service_img')?>" enctype="multipart/form-data" method="post">

                    <!-- Upload image and data -->
                    <div class="avatar-upload">
                        <input class="avatar-src" name="avatar_src" type="hidden">
                        <input class="avatar-data" name="avatar_data" type="hidden">
                        <label for="avatarInput"><?php echo $service_array['lg1_select_image']; ?></label>
                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
                        <span id="image_upload_error" class="error" style="display:none;"> <?php echo $service_array['lg1_please_upload_a']; ?>. </span>
                    </div>
                    <!-- Crop and preview -->
                    <div class="row">
                        <div class="col-md-12">
                        <div class="avatar-wrapper"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn avatar-save pull-right" type="submit"><?php echo $service_array['lg_save']; ?></button>
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
    $('#edit_service_form').validate({ 
        rules: {
            title: {
                required: true
            },
            category: {
              required: true
            },
            location:{
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
          category: {
            required: 'Enter the category'
          },
          location: {
            required: 'Enter the location'
          },
          contact_number: {
            required: 'Enter the contact number'
          }
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