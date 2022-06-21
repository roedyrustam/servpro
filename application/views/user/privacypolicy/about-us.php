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
			<li><?php echo 'About Us'; ?></li>
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
					<?php
						$forgot_array = !empty($forgot)?$forgot:''; ?>
						 <div class="account-wrapper">
							<h4 style="text-transform: capitalize;"><?php echo ($about_us)?$about_us[0]['page_title']:'About Us'; ?></h4><br>
							<p><?php echo ($about_us)?$about_us[0]['page_content']:'Details Not Found.'; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
