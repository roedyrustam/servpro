
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
<div class="account-page">
            <div class="container">
                <div class="account-box">
                    <div class="account-header">
                        <div class="account-logo">
                            <a href="<?php echo $base_url; ?>"><img src="<?php echo base_url().$website_logo_front;?>" alt="servpro"></a>
                        </div>
                    </div>
                    <div class="account-wrapper">
                        <h3 class="account-title">Forgot Password</h3>
                        <h4 class="account-sub-title">Enter your details below</h4>
                        <form action="<?php echo $base_url; ?>admin/login/send_forgot_password" method="post">
                            <div class="form-group">
                                <label class="control-label"> Email</label>
                                <input class="form-control" name="email_id" type="text">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-block account-btn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="account-footer">
                        <a href="<?php echo $base_url; ?>admin">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>