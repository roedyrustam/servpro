<?php
    $query = $this->db->query("select * from system_settings WHERE status = 1");
    $result = $query->result_array();
    $this->website_name = '';
    $website_logo_front ='assets/img/logo.png';

    $forgot = $language_content['language'];
    $forgot_array = !empty($forgot)?$forgot:'';

    if(!empty($result)) {
        foreach($result as $data) {
            if($data['key'] == 'website_name'){
                $this->website_name = $data['value'];
            }   
            if($data['key'] == 'logo_front') {
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
                    
                    <?php if($this->session->flashdata('error_message')) {  ?>
                    <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message');
                    } ?>
                    <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message');
                    } ?>
                    <form id="changePassword" action="<?php echo $base_url; ?>login/change_new_password/<?php echo $user_id?>" method="POST" class="mt-4">
                        <div class="form-group">
                            <label><?php echo $forgot_array['lg13_new_password']; ?></label>
                            <input class="form-control" type="password" name="new_password" id="new_password">
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
                        </div>
                        <div class="form-group">
                            <label><?php echo $forgot_array['lg13_confirm_passwor']; ?></label>
                            <input class="form-control" type="password" name="repeat_password" id="repeat_password">
                        </div>
                        <div class="form-group">
                            <button class="btn" id="fogotSubmit" type="submit"><?php echo $forgot_array['lg13_submit']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
</div>
<!-- /Main Wrapper -->

<script type="text/javascript">
	var new_pass_msg = "<?php echo $forgot_array['lg13_please_enter_yo1']; ?>";
	var new_pass_valid_msg = "<?php echo $forgot_array['lg13_password_should'].','.$forgot_array['lg13_uppercase'].','.$forgot_array['lg13_lowercase'].','.$forgot_array['lg13_number_and_spec']; ?>";
	var re_new_pass_msg = "<?php echo $forgot_array['lg13_please_reenter_']; ?>";
	var same_pass_msg = "<?php echo $forgot_array['lg13_the_new_passwor']; ?>";
</script>
