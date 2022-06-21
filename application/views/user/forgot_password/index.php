<?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $website_logo_front ='assets/img/logo.png';
    
    if(!empty($result)) {
    	foreach($result as $data) {
	    	if($data['key'] == 'website_name') {
	    	$this->website_name = $data['value'];
	    	}    
	    	if($data['key'] == 'logo_front') {
	             $website_logo_front =  $data['value'];
	    	}
	    	if($data['key'] == 'login_image') {
	            $login_image = $data['value'];
	        }
    	}
    }
if(!empty($login_image))
        $login_image= $login_image;
    else $login_image = 'assets/img/page-banner.jpg';

    $forgot = $language_content['language'];
    $forgot_array = !empty($forgot)?$forgot:'';
?>

<!-- Main Wrapper -->
<div class="main-wrapper">

    <div class="login-page">
        <div class="login-left">
            <img src="<?php echo base_url().$login_image; ?>" alt="">
        </div>
        <div class="login-right">
            <div class="inner-loginright">
                <div>
                    <div class="login-logo"><a href="<?php echo $base_url; ?>"><img src="<?php echo base_url().$website_logo_front;?>" alt="servpro"></a></div>
                    <div class="login-title mt-3">
                        <h2><?php echo $forgot_array['lg13_forgot_password']; ?></h2>
                        <h4><?php echo $forgot_array['lg13_enter_your_deta']; ?></h4>
                    </div>
                    
                    <form id="forgot_password_form" action="<?php echo $base_url; ?>login/send_forgot_password" method="post" class="mt-4">
                        <div class="form-group">
                            <label><?php echo $forgot_array['lg13_username_or_ema']; ?></label>
                           	<input class="form-control" type="text" name="username" id="username">
							<span id="username_block_error" class="text-danger" style="display:none"><?php echo $forgot_array['lg13_please_enter_yo']; ?>
							</span>
							<span id="username_chkblock_error" class="text-danger" style="display:none"><?php echo $forgot_array['lg13_username_or_ema1']; ?>
							</span>
                        </div>
                        <div class="form-group">
                            <button id="forgot_form_submit" class="btn" type="submit"><?php echo $forgot_array['lg13_reset_password']; ?></button>
                        </div>
                        <div class="form-group">
                        	<a href="<?php echo base_url(); ?>login"><?php echo $forgot_array['lg13_back_to_login']; ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
</div>
<!-- /Main Wrapper -->
