<?php 
$android_link = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'app_store_link'")->result_array();
$ios_link = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'play_store_link'")->result_array();
$download_showhide = $this->db->get_where('system_settings',array('key' => 'download_showhide'))->row()->value;
$categories = $this->db->get_where('footer_submenu', array('widget_name'=>'Categories-Widget'))->row();
$download_title = $this->db->get_where('system_settings',array('key' => 'download_title'))->row()->value;
$download_content = $this->db->get_where('system_settings',array('key' => 'download_content'))->row()->value;
$app_store_img = $this->db->get_where('system_settings',array('key' => 'app_store_img'))->row()->value;
$play_store_img = $this->db->get_where('system_settings',array('key' => 'play_store_img'))->row()->value;
$download_right_img = $this->db->get_where('system_settings',array('key' => 'download_right_img'))->row()->value;
$contact_us = $this->db->select('address, phone, email, widget_showhide,page_title')->get_where('footer_submenu', array('widget_name'=>'contact-widget'))->row();
$follow_us = $this->db->select('widget_showhide,page_title,followus_link')->get_where('footer_submenu', array('widget_name'=>'social-widget'))->row();
$quick_link = $this->db->get_where('footer_submenu', array('id'=>2))->row();
$copyright = $this->db->select('link, widget_showhide,page_title,page_desc')->get_where('footer_submenu', array('widget_name'=>'copyright-widget'))->row();
?>
<!-- Download App -->
<?php if ($download_showhide == 1) { ?>
<?php	if($page == 'index' || $page == 'home' ){ ?>
<div class="downloadapp-section">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12 col-md-6">
				<div class="left">
					<div class="section-title text-left pb-3">
						<h2><?php echo ($download_title)?$download_title:'Download Our App';?></h2>
					</div>
					<p><?php echo ($download_content)?$download_content:'Aliquam lorem ante, dapibus in, viverra quis'; ?></p>
					<div class="d-flex mt-4">
						<div class="mr-3"><a href="<?php echo ($android_link[0]['value'])?$android_link[0]['value']:'#'; ?>"><img class="thumbnail m-b-0" src="<?php echo base_url() . $app_store_img; ?>"></a></div>
						
						<div><a href="<?php echo ($ios_link[0]['value'])?$ios_link[0]['value']:'#'; ?>"><img class="thumbnail m-b-0" src="<?php echo base_url() . $play_store_img; ?>"></a></div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="right">
					<img class="thumbnail m-b-0" src="<?php echo base_url() . $download_right_img; ?>">
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php } ?>
<!-- /Download App -->

<!-- Footer -->
<?php	if($page == 'chat' || $page == 'chat-history' ){ ?>
<?php } else { ?>
<footer>
	<div class="container">
		<?php
		    $sub_footer = $language_content['language'];
		    $sub_footer_array = !empty($sub_footer)?$sub_footer:'';
		?>
		<div class="row">
			<?php if($copyright->widget_showhide == 1) { ?>
			<div class="col-12 col-md-6 col-lg-4">
				<div class="foooter-logo">
					<div>
						<a href="<?php echo $base_url; ?>home"><img src="<?php echo base_url();?>assets/img/footer-logo.png" alt=""></a>
					</div>
					<div class="mt-4">
						<span><?php echo $copyright->page_desc; ?></span>
					</div>
					<div class="mt-2">
						<ul>
							 <?php if(!empty($copyright->link)&& $copyright->link != 'null') {
							$crLinks = json_decode($copyright->link);
								foreach($crLinks as $key => $crlink) { 
									if($crlink->url != '' && $crlink->name != '') { ?>
									<li><a href="<?php echo $crlink->url; ?>"><?php echo $crlink->name; ?></a></li>
							<?php } } } else { ?>
									<li><a href="#">Terms&Conditions</a></li>
									<li><a href="#">Privacy Policy</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php }
				$cat_view = $categories->category_view;
				$cat_count = $categories->category_count;
				if($cat_view == 'Orderby') {
					$this->db->order_by('id', 'ASC');
				}
				if($cat_view == 'Name') {
					$this->db->order_by('category_name', 'ASC');
				}
				if($cat_view == 'Popular category') {
					$this->db->order_by('id', 'ASC');
				} 
				if($cat_view == 'Recent category') {
					$this->db->where('date(created_at) >= ( CURDATE() - INTERVAL 7 DAY )');
				} 
				$this->db->select('*');
				$this->db->from('categories');
				$this->db->where(array('status'=>1));
				$this->db->limit($cat_count);
				$result = $this->db->get()->result_array(); 
			?>
			<?php if($categories->widget_showhide == 1) { ?>
			<div class="col-12 col-md-6 col-lg-3">
				<div class="footer-links">
					<h4><?php echo str_replace('_', ' ', $categories->page_title); ?></h4>
					<ul>
						<?php foreach ($result as $res) { ?>
							<li><a href="<?php echo base_url(); ?>search/<?php echo str_replace(' ', '-', strtolower($res['category_name'])); ?>"><?php echo ucfirst($res['category_name']); ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
		
			<?php if($quick_link->widget_showhide == 1) { ?>
			<div class="col-12 col-md-6 col-lg-2">
				<div class="footer-links">
					<h4><?php echo str_replace('_', ' ', $quick_link->page_title); ?></h4>
					<ul>
						
						 <?php if(!empty($quick_link->link)&& $quick_link->link != 'null') {
							$quickLink = json_decode($quick_link->link);
							foreach ($quickLink as $key => $link) { 
								if(!empty($link)) {
								?>
							<li><a href="<?php echo $link->link; ?>"><?php echo ucfirst($link->label); ?></a></li>
						<?php } } ?> <li><a href="<?php echo base_url('login')?>">Change Location</a></li>
						<?php } else {?>
						<li><a href="<?php echo base_url();?>request">Service Request</a></li>
						<li><a href="<?php echo base_url();?>service">Book Service</a></li>
						<li><a href="<?php echo base_url();?>help">Help</a></li>
						<li><a href="<?php echo base_url();?>faq">Faq</a></li>
						<li><a href="<?php echo base_url();?>cookie-policy">Cookie Policy</a></li>
						<li><a href="<?php echo base_url('login')?>">Change Location</a></li>
					<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
			<?php if($follow_us->widget_showhide == 1) { ?>
			<div class="col-12 col-md-6 col-lg-3">
				<div class="social-links">
					<h4><?php echo str_replace('_', ' ', $follow_us->page_title); ?></h4>
					<ul>
						<?php 
											$followUs = json_decode($follow_us->followus_link);
											foreach ($followUs as $key => $value) { 
												if(!empty($value)) {
													if ($key == 'facebook') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
													<?php 	
													}
													if ($key == 'twitter') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
													<?php 	
													}
													if ($key == 'youtube') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
													<?php 	
													}
													if ($key == 'linkedin') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
											
													<?php 	
													}
													if ($key == 'github') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-github"></i></a></li>
													<?php 	
													}
													if ($key == 'instagram') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
													<?php 	
													}
													if ($key == 'gplus') {
														?>
											<li><a href="<?php echo $value; ?>" target="_blank"><i class="fab fa-google"></i></a></li>
													<?php 	
													}
												?>
										<?php } } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</footer>
<?php } ?>
<!-- /Footer -->
