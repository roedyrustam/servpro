<?php
$page = $this->uri->segment(1);
$text = !(empty($language_content['language']))?$language_content['language']:'';
?>
 

<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<ul>
			<li><a href="<?php echo $base_url; ?>home"><?php echo $text['lg_home']; ?></a></li>
			<li><?php echo (!empty($text['lg4_my_profile']))?$text['lg4_my_profile']:'My Profile'; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<?php if($page == 'user-profile'){ ?>

<!-- Profile -->
<div class="inner-profile-col mt-4">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4">
				<div class="edit-profile">
					<?php $profile_img = (!empty($profile['profile_img']))?$profile['profile_img']:'assets/img/user.jpg'; ?>
					<img src="<?php echo $base_url.$profile_img ?>" alt="">
					<div class="mt-4">
						<?php if($profile['user_id'] == $this->session->userdata('user_id')){?>
							<a href="edit-profile" class="btn w-100"><?php echo (!empty($text['lg4_edit_profile']))?$text['lg4_edit_profile']:'Edit Profile'; ?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-8">
				<div class="right-profile-details">
					<div class="card">
						<div class="card-body">
							<ul>
								<li><?php echo (!empty($text['lg4_username']))?$text['lg4_username']:'Username'; ?><div><?php echo $profile['username']; ?></div></li>
								<li><?php echo (!empty($text['lg4_email']))?$text['lg4_email']:'Email'; ?> <div><?php echo $profile['email']; ?> </div></li>
								<li><?php echo (!empty($text['lg4_phone_number']))?$text['lg4_phone_number']:'Phone Number'; ?> <div><?php echo $profile['mobile_no']; ?></div></li>
								<li>
									<?php echo (!empty($text['lg4_subscription']))?$text['lg4_subscription']:'Subscription'; ?>
									<?php
										$subscription_name = '';
										$subscription_date = '';
										if(!empty($profile['subscription_details'])){
											$subscription_name = $profile['subscription_details']['subscription_name'];
											$subscription_date = date("M Y", strtotime($profile['subscription_details']['expiry_date_time']));
										}
										if(!empty($subscription_name)){
										?>
										<div>
											<span><?php echo $subscription_name; ?></span>
											(<?php echo (!empty($text['lg4_valid_till']))?$text['lg4_valid_till']:'Valid till'; ?> <?php echo $subscription_date; ?>)</div> 
										<?php } else { ?> - <?php } ?>
										<?php
										$current_id = $this->uri->segment(2);
									 	if(empty($current_id) || $current_id == md5($this->session->userdata('user_id'))){ ?>
									 	<div class="mt-2">
											<a href="<?php echo $base_url."subscription-list"; ?>"><span class="btn text-white"><?php echo (!empty($text['lg_add']))?$text['lg_add']:'Add'; ?> <i class="fa fa-plus"></i></span></a>
										</div>
									<?php } ?>
								</li>
								<li><?php echo (!empty($text['lg4_id_card']))?$text['lg4_id_card']:'ID Card'; ?>
									<div>
										<?php $ic_card_image = (!empty($profile['ic_card_image']))?$profile['ic_card_image']:''; ?>
										<?php if(!empty($ic_card_image)) { ?>
											<a href="<?php echo $base_url.$ic_card_image ?>" target="_blank">
											<img alt="user" src="<?php echo $base_url.$ic_card_image; ?>" class="img-responsive"></a>
										<?php } ?>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Profile -->

<?php }elseif($page == 'edit-profile'){ ?>
<div class="content mb-5">
	<div class="container">
		<div class="service-tabs">
			<ul class="nav nav-pills">
				<li><a data-toggle="tab" href="#profile_cont" aria-expanded="true" class="active"><?php echo (!empty($text['lg4_my_profile']))?$text['lg4_my_profile']:'My Profile'; ?></a></li>
				<?php if($this->session->userdata('register_through') == 1){ ?>
				<li><a data-toggle="tab" href="#change_password" aria-expanded="false"><?php echo (!empty($text['lg4_change_password']))?$text['lg4_change_password']:'Change password'; ?></a></li>
			<?php } ?>
			</ul>
		</div>
		<div class="tab-content pt-0">
			<div class="tab-pane active" id="profile_cont">
				<div>
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="edit-profile">
								<?php $profile_img = (!empty($profile['profile_img']))?$profile['profile_img']:'assets/img/user.jpg'; ?>
								<img alt="user" src="<?php echo $base_url.$profile_img ?>">
								<div class="mt-4">
									<div class="pro-img-upload btn btn-default avatar-view-btn">
										<p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_image"></p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-8">
							<div class="right-profile-details">
								<div class="card">
									<div class="card-body">
										<?php if($this->session->flashdata('error_message')) {  ?>
						                <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
						            	<?php $this->session->unset_userdata('error_message'); } ?>
						              	<?php if($this->session->flashdata('success_message')) {  ?>
						                <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
						              	<?php $this->session->unset_userdata('success_message'); } ?>
						              	<form id="updateProfile" method="post"  action="<?php echo base_url();?>profile/update_profile" enctype="multipart/form-data">
											<ul>
												<li class="d-flex align-items-center justify-content-between"><label><?php echo (!empty($text['lg4_username']))?$text['lg4_username']:''; ?></label> <div><input type="text" class="form-control" name="username" id="username" value="<?php echo $profile['username']; ?>" disabled></div></li>
												<li class="d-flex align-items-center justify-content-between"><label><?php echo (!empty($text['lg4_email']))?$text['lg4_email']:''; ?></label> <div><input type="email" class="form-control" name="email_addr" id="email_addr" value="<?php echo $profile['email']; ?>" disabled> </div></li>
												<li class="d-flex align-items-center justify-content-between"><label><?php echo (!empty($text['lg4_phone_number']))?$text['lg4_phone_number']:''; ?></label> <div><input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="12" value="<?php echo $profile['mobile_no']; ?>"></div></li>
												<li>
													<label class="mt-1 d-block">
														<?php echo (!empty($text['lg4_subscription']))?$text['lg4_subscription']:'Subscription'; ?>
													</label>
													<?php
														$subscription_name = '';
														$subscription_date = '';
														if(!empty($profile['subscription_details'])){
															$subscription_name = $profile['subscription_details']['subscription_name'];
															$subscription_date = date("M Y", strtotime($profile['subscription_details']['expiry_date_time']));
														}
													?>
													<div>
														<div>
														<span><?php echo $subscription_name; ?></span> (<?php echo (!empty($text['lg4_valid_till']))?$text['lg4_valid_till']:''; ?> <?php echo $subscription_date; ?>)
														</div>
														<?php if($this->session->userdata('user_id')){ ?>
															<div class="mt-2">
																<a href="<?php echo $base_url."subscription-list"; ?>" class="btn text-white">+ Add</a>
															</div>
														<?php } ?>
													</div>
												</li>
												<li class="d-flex align-items-center justify-content-between"><label><?php echo (!empty($text['lg4_id_card']))?$text['lg4_id_card']:''; ?></label>
													<div class="card-upload-det">
														<ul>
															<li>
																<div class="card-btn ic_avatar-view-btn w-auto btn"><i class="fa fa-cloud"></i><?php echo (!empty($text['lg4_upload_ic_card']))?$text['lg4_upload_ic_card']:''; ?> <input type="hidden" class="upload" name="ic_card_image" id="ic_card_image"></div>
															</li>
															<?php $ic_card_image = (!empty($profile['ic_card_image']))?$profile['ic_card_image']:''; ?>
															<div>
																<img class="ic_avatar-view-img" src="<?php echo $base_url.$ic_card_image; ?>" alt="">
															</div>
														</ul>
													</div>
												</li>
												<li>
													<button type="submit" class="btn btn-primary submit-btn" id="profileSubmit"><?php echo (!empty($text['lg4_submit']))?$text['lg4_submit']:''; ?></button>
												</li>
											</ul>
										</form>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
									 	var mobile_error = "<?php echo (!empty($text['lg4_please_enter_yo']))?$text['lg4_please_enter_yo']:''; ?>";
									 </script>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="change_password">
				<div class="right-profile-details">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="change_password">
										<div>
											<form id="change_password_form" action="<?php echo $base_url; ?>profile/change_password" method="post">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">
															<label ><?php echo (!empty($text['lg4_current_passwor']))?$text['lg4_current_passwor']:''; ?></label>
														</div>
														<div class="col-md-8">
															<input type="password" class="form-control" name="current_password" id="current_password" value="" >
															<span id="current_block_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_please_enter_cu']))?$text['lg4_please_enter_cu']:''; ?></span>
															<span id="current_chkblock_error" class="text-danger" style="display:none"><?php echo 'Current Password does not match'; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">
															<label ><?php echo (!empty($text['lg4_new_password']))?$text['lg4_new_password']:''; ?></label>
														</div>
														<div class="col-md-8">
															<input type="password" class="form-control" name="new_password" id="new_password" maxlength="20" value="">
															<span id="new_block_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_please_enter_ne']))?$text['lg4_please_enter_ne']:''; ?></span>
															<span class="text-danger" id="passwordchk_error" style="display: none;"><?php echo (!empty($text['lg4_password_should']))?$text['lg4_password_should']:''; ?></span>
															<span id="new_blockchk_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_password_should']))?$text['lg4_password_should']:''; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4">
															<label ><?php echo (!empty($text['lg4_confirm_passwor']))?$text['lg4_confirm_passwor']:''; ?></label>
														</div>
														<div class="col-md-8">
															<input type="password" class="form-control" name="confirm_password" id="confirm_password" value="">
															<span id="repeat_block_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_please_enter_re']))?$text['lg4_please_enter_re']:''; ?></span>
															<span id="repeat_chkblock_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_repeat_password']))?$text['lg4_repeat_password']:''; ?></span>
														</div>
													</div>
												</div>
												<div class="form-group mb-0">
													<div class="row">
														<div class="col-md-8 col-md-offset-4">
															<button id="cform_submit" type="submit" class="btn btn-primary submit-btn"><?php echo (!empty($text['lg4_submit']))?$text['lg4_submit']:''; ?></button>
														</div>
													</div>
												</div>

											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Avatar Modal -->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $text['lg4_profile_image']; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<?php $curprofile_img = (!empty($profile['profile_img']))?$profile['profile_img']:''; ?>
			<form class="avatar-form" action="<?=base_url('login/crop_profile_img/'.$curprofile_img)?>" enctype="multipart/form-data" method="post">
				<div class="modal-body">
					<div class="avatar-body p-0">
						<!-- Upload image and data -->
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput"><?php echo $text['lg4_select_image']; ?></label>
							<input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
							<span id="image_upload_error" class="error" style="display:none;"> <?php echo $text['lg4_please_upload_a']; ?>. </span>
						</div>
						<!-- Crop and preview -->
						<div class="avatar-wrapper"></div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button class="btn avatar-save" type="submit"><?php echo $text['lg4_yes'].", ".$text['lg4_save_changes']; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Avatar Modal -->

<!-- Ic Avatar Modal-->
<div class="modal fade custom-modal" id="ic_avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo $text['lg4_ic_image']; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<?php $curic_card_image = (!empty($profile['ic_card_image']))?$profile['ic_card_image']:''; ?>
			<form class="avatar-form" action="<?=base_url('login/crop_ic_img/'.$curic_card_image)?>" enctype="multipart/form-data" method="post">
				<div class="modal-body">
					<div class="avatar-body p-0">
						<!-- Upload image and data -->
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput"><?php echo $text['lg4_select_image']; ?></label>
							<input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
							<span id="ic_image_upload_error" class="error" style="display:none;"> <?php echo $text['lg4_please_upload_a']; ?>. </span>
						</div>
						<!-- Crop and preview -->
						<div class="avatar-wrapper"></div>
					</div>
				</div>
				<div class="modal-footer text-right">
					<button class="btn avatar-save" type="submit"><?php echo $text['lg4_yes'].", ".$text['lg4_save_changes']; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Ic Avatar Modal-->

<?php } ?>

<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.js"></script>
<script>
$(document).ready(function () {
    $('#updateProfile').validate({
        rules: {
            mobile_no:{
              required: true,
              remote: {
                url: base_url+"login/check_mob_number",
                type: "post",
                data: {
                        phone : function(){
                           return $('#mobile_no').val();
                        }
                    }
              }
            }
        },
        messages: {
          mobile_no: {
            required: 'Enter the phone number',
            remote: 'Phone number is already exist'
          }
        }
    });
});

</script>