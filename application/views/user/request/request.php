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
			<li><?php echo $request_array['lg6_requests']; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service Requests -->
<div class="technicians-section service-requests inner-request pt-4">
	<div class="container">
		<div class="inner-technicians">
			<?php if($this->session->flashdata('error_message')) {  ?>
	        <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
	    	<?php $this->session->unset_userdata('error_message'); } ?>
	      <?php if($this->session->flashdata('success_message')) {  ?>
	        <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
	      <?php $this->session->unset_userdata('success_message'); } ?>
			<!-- Search -->
			<div class="advance-search">
				<div class="search-title mb-1">
					<h5><?php echo $request_array['lg6_search']; ?>:</h5>
				</div>
				<div class="advance-form mt-3 pt-1">
					<div class="form-group">
						 <input type="text" class="form-control" placeholder="<?php echo $request_array['lg6_search'].".."; ?>" name="search_title" id="search_title">
					</div>
					<div class="form-group">
						<div class="d-flex advance-btn-col">
							<div class="mr-3">
								<a href="#" class="btn border-btn advance-search-btn"><?php echo $request_array['lg6_advanced_search']; ?></a>
							</div>
							<div class="">
								<button class="btn btn-primary" id="search_list" data-next-page="1" data-loading="0" data-current="1" onclick="search_list(0)"><?php echo $request_array['lg6_search']; ?></button>
							</div>
						</div>
					</div>
					<div class="advance-search-col" id="advance_serch">
						<div class="card">
							<div class="card-body">
								<form method="post" action="search.html">
									<div class="row">
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label><?php echo $request_array['lg6_date']; ?></label>
												<input type="text" class="form-control" placeholder="Date" name="request_date" id="request_date">
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label><?php echo $request_array['lg6_location']; ?></label>
												  <input type="text" class="form-control"   name="location" id="location">
										    	  <input type="hidden" name="latitude" id="latitude" value="">
										    	  <input type="hidden" name="longitude" id="longitude" value="">
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label><?php echo $request_array['lg6_min_price']; ?></label>
												<input type="text" class="form-control numbers_Only"   name="min_price" id="min_price">
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="form-group">
												<label><?php echo $request_array['lg6_max_price']; ?> </label>
												<input type="text" class="form-control numbers_Only"  name="max_price" id="max_price" maxlength="10" >
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Search -->

			<div class="row" id="provider_list">
				<?php
				$request_list = $requests['request_list'];
				if(!empty($request_list)){

					foreach ($request_list as $request) {
						$profile_img = (!empty($request['profile_img']))?$request['profile_img']:'assets/img/placeholder.jpg';
						$req_img = (!empty($request['request_image']))?$request['request_image']:'assets/img/placeholder.jpg';
						$descriptions = (!empty($request['description']))?$request['description']:'';
						if(!empty($descriptions)){
							$descriptions = json_decode($descriptions);
						}

					?>
				<div class="col-12 col-lg-6">
			        <div class="technician-widget">
						<div class="left">
							<a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']); ?>">
								<img src="<?php echo $base_url.$req_img; ?>" alt="">
							</a>
						</div>
						<div class="right">
							<div class="inner-right">
								<h4><a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']); ?>"><?php echo ucfirst($request['title']); ?></a></h4>
								<?php
									$descriptions = array_filter($descriptions);
									if(count($descriptions) > 0){
										$ri = 1;
									 ?>
									<ol>
										<?php foreach ($descriptions as $description) {
											if($ri++ <=4){
											?>
											<li class="text-truncate"><?php echo ucfirst($description); ?></li>
										<?php }  } ?>
									</ol>
									<?php } ?>
								<div class="location-col d-flex justify-content-between mt-2">
									<div>
										<i class="fas fa-calendar-week"></i> <?php echo date($date_format,strtotime($request['request_date'])); ?>
									</div>
									<div>
										<?php
										 $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
											if($time_format == '12 Hours') {
										    $time = date('G:ia', strtotime( $request['request_time']));
										} elseif($time_format == '24 Hours') {
										   $time = date('H:i:s', strtotime( $request['request_time']));
										} else {
										    $time = date('G:ia', strtotime( $request['request_time']));
										}
										?>
										<i class="far fa-clock"></i> <?php echo $time; ?>
									</div>
									<div>
										<h6><?php 
												$usercurrency_code = $this->session->userdata('usercurrency_code');
												if($usercurrency_code){
													$curr_amt = get_gigs_currency($request['amount'], $request['currency_code'], $usercurrency_code);
													echo strtoupper($usercurrency_code.' '.$curr_amt);
												}else{
													$curr_amt = get_gigs_currency($request['amount'], $request['currency_code'], $defaultcurrency[0]['value']);
													echo strtoupper($defaultcurrency[0]['value'].' '.$curr_amt);
												}
											?></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				}else{ ?>
					<div class="col-sm-12">
						<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $request_array['lg6_no_details_were']; ?></a>
					</div>
				<?php }
			 ?>
			</div>
		</div>
		<div class="loadmore_results" data-next-page="<?php echo $requests['next_page']; ?>" data-loading='0' style="display: none" data-search="0">
				<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
		</div>
	</div>
</div>
<!-- /Service Requests -->

<script type="text/javascript">
	var appointment_text = "<?php echo $request_array['lg6_appointment']; ?>";
	var no_results_found_text = "<?php echo $request_array['lg6_no_result_were_']; ?>";
</script>
