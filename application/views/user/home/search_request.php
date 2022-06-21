<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$request = $language_content['language'];
			$request_array = !empty($request)?$request:'';
		 ?>
		<ul>
			<li><a href="<?php echo $base_url; ?>home"><?php echo $request_array['lg_home'];?></a></li>
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

			<div class="row" id="provider_list">
				<?php
				if(!empty($result)){
					foreach ($result as $request) {
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
								<?php if(!empty($request['request_image'])) { ?>
									<img src="<?php echo base_url().$request['request_image']; ?>" alt="">
								<?php }
								else
								{ ?>
									<img src="<?php echo $base_url.$req_img; ?>" alt="">
								<?php } ?>
								
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
											if($ri++ <=3){
											?>
											<li class="text-truncate"><?php echo ucfirst($description); ?></li>
										<?php }  } ?>
									</ol>
									<?php } ?>
								<div class="location-col d-flex justify-content-between mt-2">
									<div>
										<i class="fas fa-calendar-week"></i> <?php echo date('d-m-Y',strtotime($request['request_date'])); ?>
									</div>
									<div>
										<i class="far fa-clock"></i> <?php echo $request['request_time']; ?>
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
		<div class="loadmore_results" data-next-page="2" data-loading='0' style="display: none" data-search="0">
				<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
		</div>
	</div>
</div>
<!-- /Service Requests -->

<script type="text/javascript">
	var appointment_text = "<?php echo $request_array['lg6_appointment']; ?>";
	var no_results_found_text = "<?php echo $request_array['lg6_no_result_were_']; ?>";
</script>