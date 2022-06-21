<?php 
$banner = !empty($banner["value"]) ? $banner["value"]: "assets/img/banner.jpg";
$banner = base_url().$banner;
$date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
$home = $language_content['language'];
$home_array = !empty($home)?$home:'';
$default = $default_language['language'];
$default_lang = !empty($default)?$default:'';
$bgquery = $this->db->query("select * from bgimage WHERE bgimg_for = 'banner'");
$bgresult = $bgquery->result_array();
$how_showhide = $this->db->get_where('system_settings',array('key' => 'how_showhide'))->row()->value;
$how_title = $this->db->get_where('system_settings',array('key' => 'how_title'))->row()->value;
$how_content = $this->db->get_where('system_settings',array('key' => 'how_content'))->row()->value;
$signup_name = $this->db->get_where('system_settings',array('key' => 'signup_name'))->row()->value;
$signup_link = $this->db->get_where('system_settings',array('key' => 'signup_link'))->row()->value;
$how_title_img = $this->db->get_where('system_settings',array('key' => 'how_title_img'))->row()->value;
if(!empty($bgresult[0]['upload_image']))
{
	$bgimg=base_url().$bgresult[0]['upload_image'];
}
else
{
	$bgimg=base_url().'assets/img/banner.jpg';
}

if(!empty($bgresult[0]['banner_content']))
{
	$banner_content=$bgresult[0]['banner_content'];
}
else
{
	$banner_content="High Quality Professional Services";
}

if(!empty($bgresult[0]['banner_sub_content']))
{
	$banner_sub_content=$bgresult[0]['banner_sub_content'];
}
else
{
	$banner_sub_content="All your service needs ends here.";
}

$banner_showhide = $this->db->get_where('bgimage',array('bgimg_id'=> 1))->row();
?>

<!-- Banner -->
<?php if($banner_showhide->banner_settings == 1)  { ?>
<div class="banner" style="background-image: url('<?php echo $bgimg; ?>');">
	<div class="inner-banner">
		<div class="banner-left">
			<h1><?php echo $banner_content; ?></h1>
			<h6><?php echo $banner_sub_content; ?></h6>
			<?php if($banner_showhide->main_search == 1)  { ?>
			<div class="header-search">
				<form method="post" action="<?php echo base_url()."home/search_request_details"?>">
					<input type="text" id="search_list" name="search" placeholder="<?php echo $home_array['lg14_search_request']; ?>">
					<input type="submit" name="searchsubmit">
				</form>
			</div>
			<ul id="searchResult"></ul>
			<?php } ?>
		</div>
	</div>
</div>
 <?php } ?>
<!-- /Banner -->

<!-- Service Categories -->

<?php $category = $this->data['category']; ?>
<div class="service-categories">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2><?php echo (!empty($home_array['lg14_service_categories'])) ? $home_array['lg14_service_categories'] : $default_lang['lg14_service_categories']; ?></h2>
				</div>
				<?php if (!empty ($category)) {  ?>
				<div class="swiper-container">
				    <div class="swiper-wrapper">
				    	<?php for($i=0;$i<count($category);$i++){ ?>
				        <div class="swiper-slide">
				        	<a href="<?php echo base_url()."service_categories/".$category[$i]['id']; ?>" class="service-col">
				        		<div class="service-img">
				        			<img src="<?php echo base_url().$category[$i]['category_image'];?>" alt="">
				        		</div>
				        		<div class="service-text">
				        			<h4><?php echo $category[$i]['category_name']; ?></h4>
				        		</div>
				        	</a>
				        </div>
				        <?php } ?>
				    </div>
				    <div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			<?php } else { ?>
					<center><a href="javascript:void(0)" class="alter alter-danger" ><?php echo $home_array['lg14_no_details_were']; ?></a></center>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
<!-- /Service Categories -->

<!-- Statistics -->
<div class="statistics">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4">
				<div class="statistics-col">
					<?php $request_details = $this->data['request_details'];
					?>
					<h2><?php echo $request_details ?></h2>
					<h5>Services Requests</h5>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="statistics-col">
					<?php $total_services = $this->data['total_services'];
					?>
					<h2><?php echo $total_services ?></h2>
					<h5>Number of services</h5>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="statistics-col">
					<?php $total_users = $this->data['total_users'];
					?>
					<h2><?php echo $total_users ?></h2>
					<h5>Number of users</h5>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Statistics -->

<!-- Technicians -->
<div class="technicians-section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2><?php echo (!empty($home_array['lg14_service_provide'])) ? $home_array['lg14_service_provide'] : $default_lang['lg14_service_provide']; ?></h2>
				</div>
				<div class="inner-technicians">
					<div class="swiper-container">
					    <div class="swiper-wrapper">
					    	<?php

					if(!empty($provider_list)){


						$chat_status = 0;
						$sub_count =0;

						if(isset($subscription_details)&& !empty($subscription_details)) {
							$sub_count = count($subscription_details);
							$subscription_id = $subscription_details['subscription_id'];
							$subscription_date = $subscription_details['subscription_date'];
							$expiry_date_time = $subscription_details['expiry_date_time'];
						}



						date_default_timezone_set('UTC');
						$current_date_time = date('Y-m-d H:i:s');
						if(($sub_count > 0) && ($current_date_time <= $expiry_date_time)){
							$chat_status = 0;
						} else {
							$chat_status = 1;
						}
						foreach ($provider_list as $provider) {

							$ratings =  $this->service->get_service_details(md5($provider['p_id']));

							$provider_id = $provider['provider_id'];

							$profile_img = (!empty($provider['profile_img']))?$provider['profile_img']:'assets/img/placeholder.jpg';
							$description_details = (!empty($provider['description_details']))?$provider['description_details']:'';
							if(!empty($description_details)){
								$description_details = json_decode($description_details);
							}

							?>
					    	<div class="swiper-slide">
						        <div class="technician-widget">
									<div class="left">
										<a href="<?php echo $base_url; ?>service-view/<?php echo md5($provider['p_id']) ?>">
								<?php if(!empty($provider['service_image'])) { ?>
									<img src="<?php echo base_url().$provider['service_image']; ?>" alt="">
								<?php } else {?>
								<img src="<?php echo base_url().'assets/img/placeholder.jpg'; ?>" alt="">
							<?php } ?></a>
									</div>
									<div class="right">
										<div class="inner-right">
											<h4><a href="<?php echo $base_url; ?>service-view/<?php echo md5($provider['p_id']) ?>"><?php echo ucfirst($provider['title']); ?></a></h4>
											<?php if(!empty($description_details)){ $i =1;?>
												<ol>
													<?php foreach ($description_details as $description) {
														if($i<=4){

															?>
															<li class="text-truncate"><?php echo ucfirst($description); ?></li>
														<?php } else{ break;}$i++;
													} ?>
												</ol>
											<?php } ?>
											<div class="location-col d-flex justify-content-between align-items-center mt-2 pb-1">
												<div>
													<div class="overflow-address">
														<i class="fas fa-map-marker-alt"></i> <span style="overflow: hidden;text-overflow: ellipsis;"> <?php echo $provider['location']?></span> 
													</div>
													<?php if($chat_status == 0 || $provider['provider_id'] == $this->session->userdata('user_id')){ ?>
														<div class="mt-2">
															<i class="fas fa-phone-alt"></i> <span><?php echo $provider['contact_number']; ?></span>
														</div>
													<?php } ?>
												</div>
												<div>
													<div class="rating">
														<?php
															for ($i=0; $i <5 ; $i++) { 
																if($i < $ratings['rating']){
																echo '<i class="fas fa-star filled"></i>';		
																}else{
																	echo '<i class="fas fa-star"></i>';
																}
															?>
									                       <?php } ?>
									                       <span class="d-inline-block average-rating">(<?php echo $ratings['rating'];?>)</span>	
													</div>
												</div>
												<div style="display:none;">
													<?php if($chat_status == 0 && $provider_id != $user_id){ ?>
														<a href="<?php echo $base_url."chat/".md5($provider['provider_id']);?>" class="btn"><?php echo $home_array['lg_chat']; ?></a>
													<?php }elseif($chat_status == 1 && $provider_id != $user_id){ ?>
														<a href="javascript:void(0);" data-toggle="modal" data-target="#ddsubscribeConfirmModal" class="btn"><?php echo $home_array['lg_chat']; ?></a>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
								} 
							} else{ ?>
									<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $home_array['lg14_no_details_were']; ?></a>
								<?php }
							?>
					    </div>
					</div>
					<?php if(!empty($provider_list)){ ?>
					<div class="swiper-button-next"></div>
  					<div class="swiper-button-prev"></div>
  				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Technicians -->	

<!-- About US-->
<?php if($how_showhide == 1)  { ?>
<div class="aboutus-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="left">
					<div class="section-title text-left pb-3">
						<h2><?php echo ($how_title)?$how_title:'World-Class Services for You';?></h2>
					</div>
					<p><?php echo ($how_content)?$how_content:'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Quis ipsum suspendisse ultrices commodo viverra gravida.';?></p>
					<?php if(empty($this->session->userdata('user_id'))) { ?>
					 <a href="<?php echo ($signup_link)?$signup_link:'#';?>" class="btn"><?php echo ($signup_name)?$signup_name:'Signup Now';?></a>
					<?php } ?>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="right">
					<img class="thumbnail m-b-0" src="<?php echo base_url() . $how_title_img; ?>">
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- /About US -->	

<!-- Service Requests -->
<div class="technicians-section service-requests">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2><?php echo $home_array['lg14_service_request']; ?></h2>
				</div>
				<?php if(!empty($request_list)) { ?>
				<div class="inner-technicians">
					<div class="swiper-container">
					    <div class="swiper-wrapper">
					    	<?php 
								foreach ($request_list as $request) {

									$chat_status = 0;
									$sub_count =0;

									if(isset($subscription_details)&& !empty($subscription_details))
									{
										$sub_count = count($subscription_details);
										$subscription_id = $subscription_details['subscription_id'];
										$subscription_date = $subscription_details['subscription_date'];
										$expiry_date_time = $subscription_details['expiry_date_time'];
									}



									date_default_timezone_set('UTC');
									$current_date_time = date('Y-m-d H:i:s');
									if(($sub_count > 0) && ($current_date_time <= $expiry_date_time)){
										$chat_status = 0;
									} else {
										$chat_status = 1;
									}

									$requester_id = $request['requester_id'];

									$rprofile_img = (!empty($request['profile_img']))?$request['profile_img']:'assets/img/placeholder.jpg';
									$rdescription_details = (!empty($request['description']))?$request['description']:'';
									if(!empty($rdescription_details)){
										$rdescription_details = json_decode($rdescription_details);
									}

									?>
					    	<div class="swiper-slide">
						        <div class="technician-widget">
									<div class="left">
										<a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']) ?>">
											<?php if(!empty($request['request_image'])) { ?>
									<img src="<?php echo base_url().$request['request_image']; ?>" alt="">
								<?php } else {?>
								<img src="<?php echo base_url().'assets/img/placeholder.jpg'; ?>" alt="">
							<?php } ?>
										</a>
									</div>
									<div class="right">
										<div class="inner-right">
											<h4><a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']) ?>"><?php echo ucfirst($request['title']); ?></a></h4>
											<?php if(!empty($rdescription_details)){ $i =1;?>
											<ol>
												<?php foreach ($rdescription_details as $rdescription) {
													if($i<=4){

														?>
														<li class="text-truncate"><?php echo ucfirst($rdescription); ?></li>
													<?php } else{ break;}$i++;
												} ?>
											</ol>
											<?php } ?>
											<div class="location-col d-flex justify-content-between mt-2">
												<div>
													<i class="fas fa-calendar-week"></i><?php echo date($date_format,strtotime($request['request_date'])); ?>
												</div>
												<div>
												<?php
												 $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
													if($time_format == '12 Hours') {
												    $time = date('G:ia', strtotime($request['request_time']));
												} elseif($time_format == '24 Hours') {
												   $time = date('H:i:s', strtotime($request['request_time']));
												} else {
												    $time = date('G:ia', strtotime($request['request_time']));
												}
												?>
													<i class="far fa-clock"></i><span><?php echo $time; ?></span>
												</div>
												<div>
													<h6>
														<?php
														$usercurrency_code = $this->session->userdata('usercurrency_code');
														if($usercurrency_code){
															$curr_amt = get_gigs_currency($request['amount'], $request['currency_code'], $usercurrency_code);
															echo strtoupper($usercurrency_code.' '.$curr_amt);
														}else{
															$curr_amt = get_gigs_currency($request['amount'], $request['currency_code'], $defaultcurrency[0]['value']);
															echo strtoupper($defaultcurrency[0]['value'].' '.$curr_amt);
														}
														 ?>
													</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
					    </div>
					</div>
					<div class="swiper-button-next"></div>
  					<div class="swiper-button-prev"></div>
				</div>
			<?php } else { ?>
					<center><a href="javascript:void(0)" class="alter alter-danger" ><?php echo $home_array['lg14_no_details_were']; ?></a></center>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
<!-- /Service Requests -->

<!-- Subscribe Confirm Modal -->
<div class="modal fade custom-modal" id="subscribeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="acc_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p id="acc_msg"></p>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-success si_accept_confirm"><?php echo $home_array['lg14_yes']; ?></a>
				<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo $home_array['lg14_cancel']; ?></button>
			</div>
		</div>
	</div>
</div>

<!-- /Subscribe Confirm Modal -->
<script type="text/javascript">
	var subscribe_title = "<?php echo $home_array['lg14_subscribe']; ?>";
	var do_subscribe_msg = "<?php echo $home_array['lg14_please_do_subsc1']; ?>";
	var do_subscribe_msg1 = "<?php echo $home_array['lg14_are_you_sure_wa']; ?>";
</script>






