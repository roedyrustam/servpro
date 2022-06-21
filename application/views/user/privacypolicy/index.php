<?php
$page = $this->uri->segment(1);
$text = !(empty($language_content['language']))?$language_content['language']:'';

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
<section class="page-banner">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-text">
				 <h2><?php echo 'Privacy Policy'; ?></h2>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="blk-style">
					<div class="row">
					<?php $forgot = $language_content['language'];
						$forgot_array = !empty($forgot)?$forgot:''; ?>
						 <div class="account-wrapper">
							<h3 class="account-title">Our Privacy Policy</h3><br>
							<h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
