<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery.js"></script>
<?php
	$query = $this->db->query("select * from system_settings WHERE status = 1");
		$result = $query->result_array();
		$this->website_name = '';
		$website_logo_front ='assets/img/signup-logo.png';

		if(!empty($result)) {
			foreach($result as $data){
			if($data['key'] == 'website_name'){
			$this->website_name = $data['value'];
			}
			if($data['key'] == 'logo_front'){
			$website_logo_front =  $data['value'];
			}
			if($data['key'] == 'login_image'){
	            $login_image = $data['value'];
	        }
		}
	}
	if(!empty($login_image))
        $login_image= $login_image;
    else $login_image = 'assets/img/page-banner.jpg';

    	$sign_up_text = $language_content['language'];
?>
<div class="main-wrapper">
	<div class="login-page">
		<div class="login-left">
			<img src="<?php echo base_url().$login_image; ?>" alt="">
		</div>
		<div class="login-right">
			<div class="inner-loginright">
				<div>
					<div class="login-logo"><a href="index.html"><img src="assets/img/logo.png" alt="" /></a></div>
					<div class="login-title mt-3">
						<h2><?php echo $sign_up_text['lg_sign_up_to_serv_pro']; ?></h2>
					</div>
					<?php
					$email ='';
					$tokenid ='';
					$username ='';
					$register_through ='1';
					$text = !(empty($language_content['language']))?$language_content['language']:'';
					if(!empty($this->session->userdata('google_plus_data'))){
						$google_plus_data = $this->session->userdata('google_plus_data');
						$email   = $google_plus_data['email'];
						$tokenid  = $google_plus_data['oauth_uid'];
						$username = $google_plus_data['first_name'].$google_plus_data['last_name'];
						$picture=$google_plus_data['picture'];
						$register_through ='3';
					}
					if(!empty($this->session->userdata('facebook_data'))){
						$facebook_data = $this->session->userdata('facebook_data');
						$email   = $facebook_data['email'];
						$tokenid  = $facebook_data['oauth_uid'];
						$username = $facebook_data['first_name'].$facebook_data['last_name'];
						$register_through ='2';
					}

				
					if($register_through == 1){ ?>
					<form method="post" id="signUpForms1" action="<?php echo base_url();?>login/create_new_user" enctype="multipart/form-data" class="mt-4">
						<div class="fileupload-register mb-3">
							<ul class="d-flex align-items-center">
								<li class="file-upload-preview">
									<img src="<?php echo $base_url; ?>assets/img/img-preview.png" alt=""  id="image_upload_preview">
								</li>
								<li>
									<div class="file-upload pro-img-upload btn avatar-view-btn" style="border-radius: 25px;">
										<img src="assets/img/cam-icon.png" alt="">
										<p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_pic"></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="form-group">
							<label><?php echo $sign_up_text['lg1_username']; ?> <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>">
						</div>
						<div class="form-group">
							<label><?php echo $sign_up_text['lg1_phone']; ?> <span class="text-danger">*</span></label>
							<input class="form-control numbers_Only" type="text" name="phone" id="phone" maxlength="15">
						</div>
						<div class="form-group">
							<label><?php echo $sign_up_text['lg1_email']; ?> <span class="text-danger">*</span></label>
							<input class="form-control" type="email" name="email_addr" id="email_addr" value="<?php echo $email
							; ?>">
						</div>
						<div class="form-group">
							<label><?php echo $sign_up_text['lg1_password']; ?> <span class="text-danger">*</span></label>
							<input class="form-control" type="password" name="password" id="password">
							<div class="text-danger" >
								<span id="password_err" style="display:none">
									<?php echo $sign_up_text['lg1_enter_password']; ?>
								</span>
								<span id="new_block_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_please_enter_ne']))?$text['lg4_please_enter_ne']:''; ?></span>
								<span class="text-danger" id="passwordchk_error" style="display: none;"><?php echo (!empty($text['lg4_password_should']))?$text['lg4_password_should']:''; ?></span>
								<span id="new_blockchk_error" class="text-danger" style="display:none"><?php echo (!empty($text['lg4_please_enter_di']))?$text['lg4_please_enter_di']:''; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label><?php echo $sign_up_text['lg1_confirm_passwor']; ?> <span class="text-danger">*</span></label>
							<input class="form-control" type="password" name="repeat_password" id="repeat_password">
							<div class="text-danger" id="repeat_password_err" style="display:none"><?php echo $sign_up_text['lg1_enter_confirm_p']; ?></div>
							<div class="text-danger" id="repeat_password_chk_err" style="display:none"><?php echo $sign_up_text['lg1_password_and_co']; ?></div>
						</div>
						<div class="form-group">
							<button class="btn" type="submit" id="signUpSubmit"><?php echo $sign_up_text['lg1_sign_up']; ?></button>
						</div>
						<div class="form-group">
							<?php echo $sign_up_text['lg1_already_have_an']; ?> <a href="<?php echo base_url();?>login"><?php echo $sign_up_text['lg1_login']; ?></a>
						</div>
					</form>
					<?php }elseif($register_through == 2){ ?>

					<form id="signUpForm" action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="user-upload-wrap">
								<div class="user-img-upload">
									<img src="<?php echo $base_url; ?>assets/img/placeholder.jpg" alt="" class="avatar-view-img">
									<div class="fileupload avatar-view-btn">
										<p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_image"></p>
									</div>
								</div>
							</div>
							<div class="text-danger" id="profile_image_err" style="display:none"><?php echo $sign_up_text['lg_please_choose_profile_image']; ?></div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $sign_up_text['lg1_username']; ?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>" readonly>
						<input type="hidden" name="tokenid" value="<?php echo $tokenid; ?>" id="tokenid">
						<input type="hidden" name="register_through" value="<?php echo $register_through; ?>">
							<div class="text-danger" id="username_err" style="display:none"><?php echo $sign_up_text['lg1_enter_username']; ?> </div>
							<div class="text-danger" id="username_chk_err" style="display:none"><?php echo $sign_up_text['lg1_this_username_i']; ?></div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $sign_up_text['lg1_email']; ?><span class="text-danger">*</span></label>
							<input class="form-control" type="email" name="email_addr" id="email_addr" value="<?php echo $email; ?>" <?php if(!empty($email)){ echo'readonly'; } ?>>

							<div class="text-danger" id="email_addr_chk_err" style="display:none"></br>This email address is already exist</div>
							<div class="text-danger" id="email_addr_err" style="display:none"><?php echo $sign_up_text['lg1_enter_email']; ?></div>
							<div class="text-danger" id="email_valid_addr_err" style="display:none"><?php echo $sign_up_text['lg1_please_enter_va']; ?></div>


							<div class="text-danger" id="email_addr_chk_err" style="display:none"></br><?php echo $sign_up_text['lg1_this_email_addr']; ?></div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $sign_up_text['lg1_phone']; ?><span class="text-danger">*</span></label>
							<input class="form-control numbers_Only" type="text" name="phone" id="phone" maxlength="15">
							<div class="text-danger" id="phone_err" style="display:none"><?php echo $sign_up_text['lg1_enter_phone_num']; ?></div>
							<div class="text-danger" id="phone_chk_err" style="display:none"><?php echo $sign_up_text['lg1_this_mobile_no_']; ?></div>
						</div>

						<div class="text-center">
							<button class="btn btn-primary btn-block account-btn" type="submit" id="signUpfacebook"><?php echo $sign_up_text['lg1_sign_up']; ?></button>
						</div>
					</form>
					<?php

					 }elseif($register_through == 3){ ?>

					<form id="signUpForm" action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<div class="user-upload-wrap">
								<div class="user-img-upload">
									<div class="user-img-upload">
								    	    <?php if($picture) { ?>
								    <img src="<?php echo $picture; ?>" alt="" class="avatar-view-img">
									<div class="fileupload avatar-view-btn">
										<p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_image"></p>
									</div>
								    <?php } else { ?>

									<img src="<?php echo $base_url; ?>assets/img/placeholder.jpg" alt="" class="avatar-view-img">
									<div class="fileupload avatar-view-btn">
										<p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_image" src="<?php echo $picture; ?>" value="<?php echo $picture; ?>"></p>
									</div>
									<?php } ?>

								</div>
							</div>
							<div class="text-danger" id="profile_image_err" style="display:none"><?php echo $sign_up_text['lg_please_choose_profile_image']; ?></div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $sign_up_text['lg1_username']; ?><span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>" readonly>
						<input type="hidden" name="tokenid" value="<?php echo $tokenid; ?>" id="tokenid">
						<input type="hidden" name="register_through" value="<?php echo $register_through; ?>">
							<div class="text-danger" id="username_err" style="display:none"><?php echo $sign_up_text['lg1_enter_username']; ?> </div>
							<div class="text-danger" id="username_chk_err" style="display:none"><?php echo $sign_up_text['lg1_this_username_i']; ?></div>
						</div>
						<div class="form-group">
							<label class="control-label"><?php echo $sign_up_text['lg1_email']; ?><span class="text-danger">*</span></label>
							<input class="form-control" type="email" name="email_addr" id="email_addr" value="<?php echo $email; ?>" readonly>
							<div class="text-danger" id="email_valid_addr_err" style="display:none"><?php echo $sign_up_text['lg1_please_enter_va']; ?></div>

							<div class="text-danger" id="email_addr_err" style="display:none"><?php echo $sign_up_text['lg1_enter_email']; ?></div>
							<div class="text-danger" id="email_addr_chk_err" style="display:none"></br><?php echo $sign_up_text['lg1_this_email_addr']; ?></div>
						</div>
					

						<div class="text-center">
							<button class="btn btn-primary btn-block account-btn" type="submit" id="signUpgoogle"><?php echo $sign_up_text['lg1_sign_up']; ?></button>
						</div>
					</form>
					<?php

					 } ?>
				</div>
				<div class="d-flex align-items-end">
					<div class="download-applogin mt-3 mb-3">
						<div class="section-title text-left pb-1">
							<h2><?php echo $sign_up_text['lg_download_our_app_now']; ?></h2>
						</div>
						<div class="d-flex">
							<div class="mr-3"><a href="#"><img src="assets/img/gp-01.jpg" alt=""></a></div>
							<div><a href="#"><img src="assets/img/gp-02.jpg" alt=""></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--Avatar Modal-->
<div class="modal fade custom-modal" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?php echo $sign_up_text['lg1_profile_image']; ?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
		<form class="avatar-form" action="<?=base_url('login/crop_profile_img')?>" enctype="multipart/form-data" method="post">

					<!-- Upload image and data -->
					<div class="avatar-upload">
						<input class="avatar-src" name="avatar_src" type="hidden">
						<input class="avatar-data" name="avatar_data" type="hidden">
						<label for="avatarInput"><?php echo $sign_up_text['lg1_select_image']; ?></label>
						<input class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/png, image/gif, image/jpeg, image/jpg">
                        <span id="image_upload_error" class="error" style="display:none;"> <?php echo $sign_up_text['lg1_please_upload_a']; ?>. </span>
					</div>
					<!-- Crop and preview -->
					<div class="row">
						<div class="col-md-12">
						<div class="avatar-wrapper"></div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col-md-12">
							<button class="btn avatar-save pull-right" type="submit"><?php echo $sign_up_text['lg1_yes'].", ".$sign_up_text['lg1_save_changes']; ?></button>
						</div>
					</div>
			</form>
		</div>
		</div>
	</div>
</div>
<!--/Avatar Modal-->

<!-- Ic Avatar Modal-->
<div class="modal fade custom-modal" id="ic_avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><i><?php echo $sign_up_text['lg1_ic_image']; ?></i></h5>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
		<form class="ic_avatar-form" action="<?=base_url('login/crop_ic_img')?>" enctype="multipart/form-data" method="post">

				<div class="avatar-body">
					<!-- Upload image and data -->
					<div class="ic_avatar-upload">
						<input class="ic_avatar-src" name="ic_avatar_src" type="hidden">
						<input class="ic_avatar-data" name="avatar_data" type="hidden">
						<label for="avatarInput"><?php echo $sign_up_text['lg1_select_image']; ?></label>
						<input class="ic_avatar-input" id="ic_avatarInput" name="avatar_file" type="file">
            			<span id="ic_image_upload_error" class="error" style="display:none;"> <?php echo $sign_up_text['lg1_please_upload_a']; ?>. </span>
					</div>
					<!-- Crop and preview -->
					<div class="row">
						<div class="col-md-12">
						<div class="ic_avatar-wrapper"></div>
						</div>
					</div>
					<div class="row ic_avatar-btns">
						<div class="col-md-12">
							<button class="btn btn-success ic_avatar-save pull-right" type="submit"><?php echo $sign_up_text['lg1_yes'].", ".$sign_up_text['lg1_save_changes']; ?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
		</div>
	</div>
</div>
<!-- Ic Avatar Modal-->

<script>
$(document).ready(function () {
    $.validator.addMethod("email", function(value, element) {
    // allow any non-whitespace characters as the host part
    return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
    }, 'Please enter a valid email address.');
    $.validator.addMethod("passmatch", function(value, element) {
    // allow any non-whitespace characters as the host part
    return this.optional( element ) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$/.test( value );
    }, 'Please enter a valid password address.');

    $('#signUpForms1').validate({
        rules: {
            username: {
                required: true,
                remote: {
                    url: base_url +"login/check_username",
                    type: "post",
                    data: {
                        username : function(){
                           return $('#username').val();
                        }
                    }
                }
            },
            email_addr: {
              required: true,
              email: true,
              remote: {
                    url: base_url +"login/check_email_address",
                    type: "post",
                    data: {
                        email_addr : function(){
                           return $('#email_addr').val();
                        }
                    }
                }
            },
            phone:{
              required: true,
              remote: {
                url: base_url+"login/check_phone",
                type: "post",
                data: {
                        phone : function(){
                           return $('#phone').val();
                        }
                    }
              }
            },
            password:{
                required: true,
                passmatch: true,
            },
            repeat_password:{
              required: true,
              equalTo: "#password"
            }
        },
        messages: {
          username:{
            required: 'Enter the user name',
            remote: 'User name is already exist'
          },
          email_addr: {
            required: 'Enter the email address',
            email: 'Please enter a valid email address.',
            remote: 'Email address is already exist'
          },
          phone: {
            required: 'Enter the phone number',
            remote: 'Phone number is already exist'
          },
          password: {
            required: 'Enter the password',
            passmatch: 'Password must contain at least eight characters, at least one number and both lower and uppercase letters and special characters'
          },
          repeat_password: {
            required: 'Enter the confirm password',
            equalTo: 'Password do not match'
          }
        }
    });
});

</script>
