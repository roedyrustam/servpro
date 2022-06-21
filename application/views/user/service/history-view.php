<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$text = !(empty($language_content['language']))?$language_content['language']:'';
		?>
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $request_details['lg_home']; ?></a></li>
			<li><?php echo strtoupper($request_details['title']); ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service  Details -->
<div class="service-details-section mt-4 mb-5">
	<div class="container">
		<?php if($this->session->flashdata('error_message')) {  ?>
        <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
    	<?php $this->session->unset_userdata('error_message'); } ?>
      	<?php if($this->session->flashdata('success_message')) {  ?>
        <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
      	<?php $this->session->unset_userdata('success_message'); } ?>
			<?php
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
				$header_text = '';
				$top_id = '';
				$top_username = '';
				$top_phone = '';
				$top_email = '';
				$top_img = '';
				$bot_id = '';
				$bot_username = '';
				$bot_phone = '';
				$bot_email = '';
				$bot_img = '';
				$requester_id = $request_details['requester_id'];
				$acceptor_id = $request_details['acceptor_id'];
				$user_id = $this->session->userdata('user_id');
				if($user_id == $requester_id){
					$header_text = $text['lg6_acceptor'];
					$top_id = $requester_id;
					$top_username = $request_details['username'];
					$top_phone = $request_details['contact_number'];
					$top_email = $request_details['email'];
					$top_img = $request_details['profile_img'];
					$bot_id = $acceptor_id;
					$bot_username = $request_details['acceptor_name'];
					$bot_phone = $request_details['acceptor_mobile'];
					$bot_email = $request_details['acceptor_email'];
					$bot_img = $request_details['acceptor_image'];
				}
				elseif($user_id == $acceptor_id){
					$header_text = $text['lg6_requestor'];
					$top_id = $acceptor_id;
					$top_username = $request_details['acceptor_name'];
					$top_phone = $request_details['acceptor_mobile'];
					$top_email = $request_details['acceptor_email'];
					$top_img = $request_details['acceptor_image'];
					$bot_id = $requester_id;
					$bot_username = $request_details['username'];
					$bot_phone = $request_details['contact_number'];
					$bot_email = $request_details['email'];
					$bot_img = $request_details['profile_img'];
				}
			?>
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="service-provier-details justify-content-start text-left">
					<div class="right-provier-details">
						<h4><?php if($chat_status == 0 || $top_id == $this->session->userdata('user_id')){ ?>
								 <a href="<?php echo $base_url.'user-profile/'.md5($top_id) ?>">
							<?php }else{ ?>
								<a href="javascript:void(0);">
							<?php } ?>
							<?php echo $top_username; ?></a></h4>
							<?php if($chat_status == 0 || $top_id == $this->session->userdata('user_id')){ ?>
							<ul class="mt-2">
								<li><i class="fas fa-envelope"></i> <?php echo $top_email; ?></li>
								<li><i class="fas fa-phone-alt"></i> <?php echo $top_phone; ?></li>
							</ul>
							<?php } ?>
					</div>
				</div>
				<?php
					$description_details = (!empty($request_details['description']))?$request_details['description']:'';
					if(!empty($description_details)){
						$description_details = json_decode($description_details);
					}
				 ?>
			    <div class="location-service">
			    	<h4><?php echo ucfirst($request_details['title']); ?></h4>
			    	<?php if(!empty($description_details)){ $i =1;?>
						<ol>
							<?php foreach ($description_details as $description) {
								if($i<=5){
							 ?>
								<li class="text-truncate"><?php echo ucfirst($description); ?></li>
							<?php } else{ break;}$i++;
							} ?>
						</ol>
					<?php } ?>
			    </div>
			</div>
			<div class="col-12 col-lg-4">
				<div class="right-sidebar">
					<div class="card">
						<?php if(!empty($request_details['rad_status'])) { ?>
								<?php if($request_details['rad_status'] == 1) { if($request_details['acceptor_id'] == $this->session->userdata('user_id')) { ?>
						<div class="card-header">
							<a class="btn w-100 border-btn" href="javascript:void(0);">Pending</a>
							<?php } if($request_details['requester_id'] == $this->session->userdata('user_id')) { ?>
					          <a class="btn w-100 mt-4 si-confirm-complete" data-id="<?=$request_details['rad_id']?>" href="javascript:void(0);">Complete Request</a>
					        <?php  } } elseif($request_details['rad_status'] == 2) { ?>
					          <a class="btn w-100 mt-4" href="javascript:void(0);">Completed</a>
						</div>
						<?php } } ?>
						<div class="card-body">
							<div class="expecting-fee">
								<h4><?php echo (!empty($text['lg6_expecting_fee1']))?$text['lg6_expecting_fee1']:'Expecting Fee'; ?></h4>
								<h3><?php 
									$usercurrency_code = $this->session->userdata('usercurrency_code');
									if($usercurrency_code){
										$curr_amt = get_gigs_currency($request_details['amount'], $request_details['currency_code'], $usercurrency_code);
										echo strtoupper($usercurrency_code.' '.$curr_amt);
									}else{
										$curr_amt = get_gigs_currency($request_details['amount'], $request_details['currency_code'], $defaultcurrency[0]['value']);
										echo strtoupper($defaultcurrency[0]['value'].' '.$curr_amt);
									}
									 ?>	
								</h3>
							</div>
							<div class="date-time-col">

								<ul>
									<li>Date     :  <span><?php echo $request_details['request_date']; ?></span></li>
									<li>Time    : <span><?php echo date("H:i A", strtotime($request_details['request_time'])); ?></span></li>
								</ul>
							</div>
							<div class="available-time mt-4">
								<h4>Location</h4>
								<div id="mylatitude" style="display: none;"></div>
							    <div id="mylongitude" style="display: none;"></div>
								<div class="text-center map-col">
									  <div id="map" style="width: 100%; height: 600px;"></div>
									  
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Acceptor Details Starts -->
	<?php if($request_details['rad_status'] != '') { ?>
	<div class="services">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
				<div class="request-top">
					<h3 class="section-title"><?php echo $header_text; ?></h3>
						<div class="requester-info">
							<div class="requester-img">
								<?php if($chat_status == 0 || $bot_id == $this->session->userdata('user_id')){ ?>
									 <a href="<?php echo $base_url.'user-profile/'.md5($bot_id) ?>">
								<?php }else{ ?>
									<a href="javascript:void(0);">
								<?php } ?>
									<?php $acceptor_profile_img = (!empty($bot_img))?$bot_img:'assets/img/placeholder.jpg'; ?>
									<img alt="" src="<?php echo $base_url.$acceptor_profile_img ?>">
								</a>
							</div>
							<div class="request-content">
								<div class="inner">
									<h3>
										<?php if($chat_status == 0 || $bot_id == $this->session->userdata('user_id')){ ?>
											 <a href="<?php echo $base_url.'user-profile/'.md5($bot_id) ?>">
										<?php }else{ ?>
											<a href="javascript:void(0);">
										<?php } ?>
										<?php echo $bot_username; ?></a></h3>
										<?php if($chat_status == 0 || $bot_id == $this->session->userdata('user_id')){ ?>
											<div class="servicer-email"><i class="fa fa-envelope"></i> <?php echo $bot_email; ?></div>
											<div class="servicer-phone"><i class="fa fa-phone"></i> <?php echo $bot_phone; ?></div>
										<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<!-- Acceptor Details Ends -->
</div>
<!-- /Service  Details -->

<div class="modal fade custom-modal" id="requestFinalConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo (!empty($text['lg6_complete_reques']))?$text['lg6_complete_reques']:'Complete Request'; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	
			</div>
			<div class="modal-body">
			<p><?php echo (!empty($text['lg6_are_you_sure_wa3']))?$text['lg6_are_you_sure_wa3']:'Are you sure want to complete this request?'; ?></p>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-success si_confirm"><?php echo (!empty($text['lg6_yes']))?$text['lg6_yes']:'Yes'; ?></a>
				<button type="button" class="btn btn-danger si_cancel" data-dismiss="modal"><?php echo (!empty($text['lg6_cancel']))?$text['lg6_cancel']:'Cancel'; ?></button>
			</div>
		</div>
	</div>
</div>


