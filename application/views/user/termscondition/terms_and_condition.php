<?php
$query = $this->db->query("select * from system_settings WHERE status = 1");
$result = $query->result_array();
$forgot = $language_content['language'];

?>
<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $forgot['lg_home']; ?></a></li>
			<li><?php echo 'Terms & Conditions'; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<div class="content mb-5">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="blk-style">
					<div class="row">
						 <div class="account-wrapper">
						 	<?php if(!empty($result)) {
									foreach($result as $data){
										if($data['key'] == 'terms'){
											$this->terms = $data['value'];
									}
								  }
								}
							 ?>

							<h4 style="text-transform: capitalize;"><?php echo ($terms)?$terms[0]['page_title']:'Terms Of Services'; ?></h4><br>
							<p><?php echo ($terms)?$terms[0]['page_content']:'Details Not Found.'; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

