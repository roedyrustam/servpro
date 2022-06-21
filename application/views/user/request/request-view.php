<?php
$date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
$time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
?>

<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$request = $language_content['language'];
			$request_array = !empty($request)?$request:'';
	 	?>
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $request_array['lg_home']; ?></a></li>
			<li><?php echo strtoupper($request_details['title']); ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service  Details -->
<div class="service-details-section mt-4 mb-5">
	<div class="container">
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
		?>
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="service-provier-details justify-content-start text-left">
					<div class="service-provier-img">
							<?php if($chat_status == 0 || $request_details['requester_id'] == $this->session->userdata('user_id')){ ?>
									<a href="<?php echo $base_url.'user-profile/'.md5($request_details['requester_id']) ?>">
								<?php }else{ ?>
									<a href="javascript:void(0);">
								<?php } ?>
								<?php $profile_img = (!empty($request_details['profile_img']))?$request_details['profile_img']:'assets/img/placeholder.jpg'; ?>
								<img alt="" src="<?php echo $base_url.$profile_img ?>">
							</a>
						</div>
					<div class="right-provier-details mt-0">
						<h4><?php if($chat_status == 0 || $request_details['requester_id'] == $this->session->userdata('user_id')){ ?>
								 <a href="<?php echo $base_url.'user-profile/'.md5($request_details['requester_id']) ?>">
								<a href="javascript:void(0);">
							<?php }else{ ?>
								<a href="javascript:void(0);">
							<?php } ?>
							<?php echo $request_details['username']; ?></a>
						</h4>
						<ul class="mt-2">
							<li><i class="fas fa-envelope"></i> <?php echo $request_details['email']; ?></li>
							<li><i class="fas fa-phone-alt"></i> <?php echo $request_details['contact_number']; ?></li>
						</ul>
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
					<ol class="mt-2">
						<?php foreach ($description_details as $description) {
							if($i<=5){
						 ?>
							<li><?php echo ucfirst($description); ?></li>
						<?php } else{ break;}$i++;
						} ?>
					</ol>
				<?php } ?>
			    </div>
			</div>
			<div class="col-12 col-lg-4">
				<div class="right-sidebar">
					<div class="card">
						<?php
							if($request_details['requester_id'] != $this->session->userdata('user_id')){
								if($chat_status == 0){
							?>
						<div class="card-header">
								<a class="btn w-100 border-btn si-accept-complete" data-id="<?=md5($request_details['r_id'])?>" data-sub="0" href="javascript:void(0);"><?php echo $request_array['lg6_accept_request']; ?></a>
								<a href="<?php echo $base_url."requester-chat/".md5($request_details['requester_id']);?>" class="btn w-100 mt-4">Chat</a>
							<?php }elseif($chat_status == 1){ ?>
								<a class="btn w-100 mt-4 si-accept-complete" data-id="<?=md5($request_details['r_id'])?>" data-sub="1" href="javascript:void(0);"><?php echo $request_array['lg6_accept_request']; ?></a>
						</div>
						<?php } } ?>
						<div class="card-body">
							<div class="expecting-fee">
								<h4><?php echo $request_array['lg6_expecting_fee1']; ?></h4>
								<h3><?php 
								$usercurrency_code = $this->session->userdata('usercurrency_code');
								$currency_symbol = $this->db->get_where('system_settings',array('key' => 'currency_symbol'))->row()->value;
								if($usercurrency_code){
									$curr_amt = get_gigs_currency($request_details['amount'], $request_details['currency_code'], $usercurrency_code);
									echo strtoupper($usercurrency_code.' '.$curr_amt);
								}else{
									$curr_amt = get_gigs_currency($request_details['amount'], $request_details['currency_code'], $defaultcurrency[0]['value']);
									echo strtoupper($defaultcurrency[0]['value'].' '.$curr_amt);
								}
								 ?></h3>
							</div>
							<div class="date-time-col">
								<ul>
									<li>Date     :  <span><?php
									echo date($date_format, strtotime($request_details['request_date']));?></span></li>
									<?php
									 $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
										if($time_format == '12 Hours') {
									    $time = date('G:ia', strtotime($request_details['request_time']));
									} elseif($time_format == '24 Hours') {
									   $time = date('H:i:s', strtotime($request_details['request_time']));
									} else {
									    $time = date('G:ia', strtotime($request_details['request_time']));
									}
									?>
									<li>Time    : <span><?php echo $time; ?></span></li>
								</ul>
							</div>
							<div class="available-time mt-4">
								<h4>Location</h4>
								<div class="text-center map-col">
									<div id="mylatitude" style="display: none;"></div>
							    	<div id="mylongitude" style="display: none;"></div>
							    	<div id="map" style="width: 100%; height: 360px;"></div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Service  Details -->

<!-- Accept Confirm Modal -->
<div class="modal fade custom-modal" id="acceptConfirmModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<a href="javascript:;" class="btn btn-success si_accept_confirm"><?php echo $request_array['lg6_yes']; ?></a>
				<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo $request_array['lg6_cancel']; ?></button>
			</div>
		</div>
	</div>
</div>
<!-- /Accept Confirm Modal -->

<script type="text/javascript">
	var accept_title = "<?php echo $request_array['lg6_accept_request']; ?>";
	var accept_msg = "<?php echo $request_array['lg6_are_you_sure_wa1']; ?>";
	var subscribe_title = "<?php echo $request_array['lg6_subscribe']; ?>";
	var do_subscribe_msg = "<?php echo $request_array['lg6_please_do_subsc']; ?>";
	var do_subscribe_msg1 = "<?php echo $request_array['lg6_are_you_sure_wa2']; ?>";
</script>
