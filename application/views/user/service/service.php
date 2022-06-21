<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$service = $language_content['language'];
			$service_array = !empty($service)?$service:'';
	 	?>
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $service_array['lg_home']; ?></a></li>
			<li><?php echo $service_array['lg6_services']; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Technicians -->
<div class="technicians-section pt-4">
	<div class="container">
		<div class="inner-technicians inner-service-technicians">	

			<!-- Search -->
			<div class="advance-search">
				<div class="search-title mb-1">
					<h5><?php echo $service_array['lg6_search']; ?></h5>
				</div>
				<div class="advance-form mt-3 pt-1">
					<div class="row">
						<div class="col-12 col-lg-4">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="<?php echo $service_array['lg6_search']; ?>" name="search_title" id="search_title">
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="form-group">
								<select class="form-control select" title="<?php echo $service_array['lg6_category']; ?>" multiple name="category[]" id="category" style="height: 50px !important;" data-live-search="true"></select>
							</div>
						</div>
						<div class="col-12 col-lg-4">
							<div class="form-group">
								<select class="form-control select" title="<?php echo $service_array['lg6_sub_category']; ?>" name="subcategory[]" id="subcategory" style="height: 50px !important;" multiple data-live-search="true"></select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="d-flex advance-btn-col">
							<div class="mr-3">
								<a href="#" class="btn border-btn advance-search-btn"><?php echo $service_array['lg6_advanced_search']; ?></a>
							</div>
							<div class="">
								<button class="btn" id="search_list" data-next-page="1" data-loading="0" data-current="1" onclick="service_search_list(0)"><?php echo $service_array['lg6_search']; ?></button>
							</div>
						</div>
					</div>
					<div class="advance-search-col advance-service-col" id="advance_serch">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<div class="form-group">
											<label><?php echo $service_array['lg6_date']; ?></label>
											<input type="text" class="form-control" placeholder="<?php echo $service_array['lg6_date']; ?>" name="request_date" id="request_date">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<label><?php echo $service_array['lg6_location']; ?></label>
											<input type="text" class="form-control" placeholder="<?php echo $service_array['lg6_location']; ?>" name="location" id="location">
									    	  	<input type="hidden" name="latitude" id="latitude" value="">
									    	  	<input type="hidden" name="longitude" id="longitude" value="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Search -->

			<div class="row mt-5 pt-4" id="provider_list">  
				<?php

					$provider_list = $services['provider_list'];

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

					$profile_img = (!empty($provider['profile_img']))?$provider['profile_img']:'assets/img/placeholder.jpg';
					$description_details = (!empty($provider['description_details']))?$provider['description_details']:'';
					if(!empty($description_details)){
						$description_details = json_decode($description_details);
					}

				?>
				<div class="col-12 col-lg-6">	
			        <div class="technician-widget">
						<div class="left">
							<a href="<?php echo $base_url; ?>service-view/<?php echo md5($provider['p_id']) ?>">
								<?php if(!empty($provider['service_image'])) { ?>
									<img src="<?php echo base_url().$provider['service_image']; ?>" alt="">
								<?php } else {?>
								<img src="<?php echo base_url().'assets/img/placeholder.jpg'; ?>" alt="">
							<?php } ?>
							</a>
						</div>
						<div class="right">
							<div class="inner-right">
								<h4><a href="<?php echo $base_url; ?>service-view/<?php echo md5($provider['p_id']) ?>"><?php echo ucfirst($provider['title']); ?></a></h4>
								<?php if(!empty($description_details)){ $i =1;?>
								<ol>
									<?php foreach ($description_details as $description) {
											if($i<=3){

										 ?>
										<li class="text-truncate"><?php echo ucfirst($description); ?></li>
									<?php } else{ break;}$i++;
								} ?>
								</ol>
								<?php } ?>
								<div class="location-col d-flex justify-content-between align-items-center mt-2 pt-1">
									<?php if($chat_status == 0 || $provider['provider_id'] != $this->session->userdata('user_id')){ ?>
									<div>
										<i class="fas fa-phone-alt"></i><?php echo $provider['contact_number']; ?>
									</div>
									<?php } ?>
									<?php if($provider['provider_id'] != $this->session->userdata('user_id')){ ?>
									<div>
										<?php if($chat_status == 0){ ?>
											<a href="<?php echo $base_url."chat/".md5($provider['provider_id']);?>" class="btn"><?php echo $service_array['lg6_chat']; ?></a>
										<?php }elseif($chat_status == 1){ ?>
											<a href="javascript:void(0);" class="btn service-amount si-chat-subscribe"><?php echo $service_array['lg6_chat']; ?></a>
								 		<?php } ?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php }

				}else{ ?>
					<div class="col-sm-12">
						<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $service_array['lg6_no_details_were']; ?></a>
					</div>
					<?php }
				?>
			</div>
			<div class="loadmore_results" data-next-page="<?php echo $services['next_page']; ?>" data-loading='0'  data-search="0" style="display: none">
				<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
			</div>

		</div>
	</div>
</div>
<!-- /Technicians -->

<!-- Subscribe Confirm Modal -->
<div class="modal fade" id="subscribeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="acc_title"></h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
		<p id="acc_msg"></p>
		</div>
		<div class="modal-footer">
			<a href="javascript:;" class="btn btn-success si_accept_confirm"><?php echo $service_array['lg6_yes']; ?></a>
			<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo $service_array['lg6_cancel']; ?></button>
		</div>
		</div>
	</div>
</div>
<!-- Subscribe Confirm Modal -->

<script type="text/javascript">
	var subscribe_title = "<?php echo $service_array['lg6_subscribe']; ?>";
	var do_subscribe_msg = "<?php echo $service_array['lg6_please_do_subsc2']; ?>";
	var do_subscribe_msg1 = "<?php echo $service_array['lg6_are_you_sure_wa2']; ?>";
	var chat_lang = "<?php echo $service_array['lg6_chat']; ?>";
	var contact_number_txt = "<?php echo $service_array['lg6_contact_number']; ?>";
</script>
