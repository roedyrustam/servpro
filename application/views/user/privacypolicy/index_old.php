
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
    if($data['key'] == 'terms'){
		$termsconditions =  $data['value'];
	}
    }
    }
    
?>
<div class="main-wrapper">
			<div class="account-page">
				<div class="content-wrapper">
					<div class="account-box">
						<div class="account-header">
							<div class="account-logo">
								<a href="<?php echo $base_url; ?>"><img src="<?php echo base_url().$website_logo_front;?>" alt="servpro" style="width: 250px;"></a>
							</div>
						</div>
						<?php
							$forgot = $language_content['language'];
							$forgot_array = !empty($forgot)?$forgot:'';
						 ?>
						<div class="account-wrapper">
							<h3 class="account-title">Our Terms and Conditions</h3>
							<h3><?php echo $termsconditions;?></h3>
						</div>
						<div class="account-footer">
							
						</div>
					</div>
				</div>
			</div>
		</div>
