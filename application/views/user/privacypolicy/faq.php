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
			<li><?php echo 'FAQ'; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->


<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="faq-card">
				<?php  if(!empty($pages)) { 
				$i =1;
	        	foreach ($pages as $key => $value) { ?>
	        		<details class="faq_before">
						<summary class="faq_after"><?php echo ($value->page_title); ?></summary>
						<?php echo ($value->page_content); ?>
					</details>
				<?php 
			$i++;
			} 
		 		}  else { ?>
		 			<h3><?php echo $forgot['lg_details_not_found']; ?> </h3>
		 		<?php } ?>				
		</div>
			</div>
		</div>
	</div>
</div>