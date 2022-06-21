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
}
}
?>
<div class="account-page login-bg">
    <div class="container">
        <div class="account-box">
            <div class="account-header">
                <div class="account-logo">
                    <a href="<?php echo $base_url."admin"; ?>"><img src="<?php echo base_url().$website_logo_front;?>" alt="servpro"></a>
                </div>
            </div>
            <div class="account-wrapper">
                <h3 class="account-title">Sign in to servpro</h3>
                <h4 class="account-sub-title">Enter your details below</h4>
        		<?php if($this->session->flashdata('error_message')) {  ?>
              	  <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
              	<?php $this->session->unset_userdata('error_message');
                } ?>
                <?php if($this->session->flashdata('success_message')) {  ?>
              		<div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
              	<?php $this->session->unset_userdata('success_message');
                } ?>
                <form id="adminSignIn" action="<?php echo $base_url; ?>" method="POST">
                    <div class="form-group">
                        <label class="control-label">Username or Email</label>
                        <input class="form-control" type="text" name="username" id="username">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                   
                        <div class="col-xs-6 text-right">
                            <a href="<?php echo $base_url; ?>admin/login/forgot_password">Forgot password?</a>
                        </div>
                    </div>
                  
                    <div class="text-center">
                        <button class="btn btn-primary btn-block account-btn" id="loginSubmit" type="button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>