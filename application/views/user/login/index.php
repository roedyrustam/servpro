<?php
$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
$this->website_name = '';
$website_logo_front ='assets/img/logo.png';

if(!empty($result))
{
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
?>

<div class="main-wrapper">
	<div class="login-page">
		<div class="login-left">
			<img src="<?php echo base_url().$login_image; ?>" alt="">
		</div>
		<div class="login-right">
			<div class="inner-loginright">
				<div>
					<div class="login-logo"><a href="<?php echo $base_url; ?>"><img src="<?php echo base_url().$website_logo_front; ?>" alt="servpro"></a></div>
					<?php
					$login = $language_content['language'];
					$login_array = !empty($login)?$login:'';
					?>
					<div class="login-title mt-3">
						<h2><?php echo $login_array['lg2_sign_in_to']; ?> <?php echo $this->website_name;?></h2>
						<h4><?php echo $login_array['lg2_enter_your_deta']; ?></h4>
					</div>
					<?php if($this->session->flashdata('error_message')) {  ?>
					<div class="alert alert-danger text-center in" id="flash_error_message">
						<?php echo $this->session->flashdata('error_message');?>
					</div>
					<?php $this->session->unset_userdata('error_message'); } ?>
					<?php if($this->session->flashdata('success_message')) {  ?>
					<div class="alert alert-success text-center in" id="flash_success_message">
						<?php echo $this->session->flashdata('success_message');?>
					</div>
					<?php $this->session->unset_userdata('success_message'); } ?>
					<form id="userSignIn" action="<?php echo base_url()."login/is_valid_login"; ?>" method="post" class="mt-4">
						<div class="form-group">
							<label><?php echo $login_array['lg2_username']; ?></label>
							<input type="text" name="username" id="username" class="form-control">
						</div>
						<div class="form-group">
							<label><?php echo $login_array['lg2_password']; ?></label>
							<input type="password" name="password" id="password" class="form-control">
						</div>
						<div class="form-group">
							<a href="<?php echo $base_url; ?>forgot-password"><?php echo $login_array['lg2_forgot_password']; ?></a>
						</div>
						<div class="form-group">
							<button class="btn" id="signInSubmit" type="submit"><?php echo $login_array['lg2_sign_in']; ?></button>
						</div>
						<div class="form-group">
							<?php echo $login_array['lg2_don_t_have_an_a']; ?> <a href="<?php echo $base_url; ?>signup"><?php echo $login_array['lg2_signup_now']; ?></a>
						</div>
					</form>
					<div class="login-social">
						<ul>
							<li><a onclick="fbLogin()" href="javascript:void(0);" class="fb"><img src="assets/img/fb-icon.png" /><?php echo $login_array['lg_facebook']; ?></a></li>
							<li><a class="customGPlusSignIn" href="javascript:void(0);" id="customBtn"><img src="assets/img/google-icon.png" /><?php echo $login_array['lg_google']; ?></a></li>
						</ul>
					</div>
					<script type="text/javascript">
						var username_err_msg = "<?php echo $login_array['lg2_please_enter_us']; ?>";
						var password_err_msg = "<?php echo $login_array['lg2_please_enter_pa']; ?>";
					</script>	
				</div>
				<div class="d-flex align-items-end">
					<div class="download-applogin mt-3 mb-3">
						<div class="section-title text-left pb-1">
							
							<h2><?php echo $login_array['lg_download_our_app_now']; ?></h2>
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



<script type="text/javascript" src="<?php echo $base_url;?>/assets/js/jquery-3.1.1.js"></script>	
<script type="text/javascript">
function setlanguage(lang) {
	$.post(base_url+'setlocation/language',{lang:lang},function(status){
		if(status){
			location.reload();
		}
	});
}
</script>