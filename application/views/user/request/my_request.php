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
			<li><?php echo $request_array['lg6_my_requests']; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service Requests -->
<div class="technicians-section service-requests inner-request pt-4">
	<button class="btn btn-primary" id="search_list" data-next-page="1" data-loading="0" data-current="1" onclick="search_list(0)" style="display: none;"><?php echo $request_array['lg6_search']."..."; ?></button>
	<?php if(!empty($this->session->flashdata('notification_message'))){ ?>
		<p class="alert alert-success"><?php echo $this->session->flashdata('notification_message'); ?></p>
	<?php } ?>
	<div class="container">
		<?php if($this->session->flashdata('error_message')) {  ?>
        <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
    	<?php $this->session->unset_userdata('error_message'); } ?>
	    <?php if($this->session->flashdata('success_message')) {  ?>
	        <div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
	    <?php $this->session->unset_userdata('success_message'); } ?>
		<div class="inner-technicians">

			<!-- Search -->
			<div class="filter-search">
				<div class="card">
					<div class="card-body">
						<div class="d-flex align-items-center inner-filter">
							<div>
								<h6><?php echo $request_array['lg6_filter']; ?></h6>
							</div>
							<div class="w-100">
								<select class="form-control select" name="search_filter" id="search_filter">
						    		<option value="10"><?php echo $request_array['lg6_all']; ?></option>
						    		<option value="0"><?php echo $request_array['lg6_pending']; ?></option>
						    		<option value="1"><?php echo $request_array['lg6_accept3']; ?></option>
						    		<option value="2"><?php echo $request_array['lg6_complete2']; ?></option>
						    	</select>
							</div>
							<div>
								<a href="#" class="btn" onclick="loadmyrequest()"><?php echo $request_array['lg_search']; ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Search -->

			<div class="row" id="provider_list">
				<?php
				$request_list = $requests['request_list'];
				//echo 'sd<pre>'; print_r($request_list); exit;
				if(!empty($request_list)){

					foreach ($request_list as $request) {


						$profile_img = (!empty($request['profile_img']))?$request['profile_img']:'assets/img/placeholder.jpg';
						$descriptions = (!empty($request['description']))?$request['description']:'';
						if(!empty($descriptions)){
							$descriptions = json_decode($descriptions);
						}
						$status = '';
						$class = '';
						//echo '<pre>'; print_r($request_list); exit;
						if($request['status'] == -1){
							$status = 'Expired';
							$class = 'bg-danger';
						}
						else if($request['status'] == 0){
							$status = 'Pending';
							$class = 'bg-warning';
						}
						else if($request['status'] == 1){
							$status = 'Accepted';
							$class = 'bg-primary';
						}
						else if($request['status'] == 2){
							$status = 'Completed';
							$class = 'bg-success';
						}
						else if($request['status'] == 3){
							$status = 'Declined';
							$class = 'bg-danger';
						}

					?>
				<div class="col-12 col-lg-6">
			        <div class="technician-widget">
						<div class="left">
							<a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']); ?>">
								<?php if(!empty($request['request_image'])) { ?>
								<img src="<?php echo base_url().$request['request_image']; ?>" alt="">
							<?php } else { ?>
								<img src="<?php echo base_url().'assets/img/placeholder.jpg'; ?>" alt="">
							<?php } ?>
							</a>
						</div>
						<div class="right">
							<div class="inner-right">
								<div class="d-flex justify-content-between align-items-center">
									<div>
										<span class="badge <?php echo $class; ?>"><?php echo $status; ?></span>
									</div>
									<div class="mr-2">
										<div class="request-edit-option">
											<a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><img src="<?php echo $base_url."assets/img/menu.png"; ?>" alt=""></a>
											<ul class="dropdown-menu">
												<?php if(($request['status'] == 0) || ($request['status'] == -1)){ ?>
												<li><a href="<?php echo $base_url."edit-request/".md5($request['r_id']); ?>"><?php echo $request_array['lg6_edit']; ?></a></li>
												<?php } ?>
												<li><a href="javascript:void(0)" class="si-delete-request" data-id="<?php echo $request['r_id']; ?>"><?php echo $request_array['lg6_delete']; ?></a></li>
											</ul>
										</div>
									</div>
								</div>
								<h4><a href="<?php echo $base_url; ?>request-view/<?php echo md5($request['r_id']); ?>"><?php echo ucfirst($request['title']); ?></a></h4>
								<?php
									$descriptions = array_filter($descriptions);
								if(count($descriptions) > 0 ){
									$my_r = 1;
								?>
								<ol>
									<?php
										foreach ($descriptions as $description) {
										if ($my_r++ <=4) {
											?>
										<li class="text-truncate"><?php echo ucfirst($description); ?></li>
									<?php } ?>
									<?php } ?>
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
											 ?>	
										</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				}else{ ?>
						<div class="col-12 col-lg-6">
							<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $request_array['lg6_no_details_were']; ?></a>
						</div>
				<?php }
			 	?>
			</div>
			<div class="loadmore_results" data-next-page="<?php echo $requests['next_page']; ?>" data-loading='0' data-search="0" style="display: none">
				 <img src="<?php echo $base_url; ?>assets/img/loading.gif" >
			</div>
		</div>
	</div>
</div>
<!-- /Service Requests -->

<!-- Delete Confirm Modal -->
<div class="modal fade custom-modal" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="acc_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<p id="acc_msg"></p>
			</div>
			<div class="modal-footer">
				<a href="javascript:;" class="btn si_accept_confirm"><?php echo $request_array['lg6_yes']; ?></a>
				<button type="button" class="btn si_accept_cancel" data-dismiss="modal"><?php echo $request_array['lg6_cancel']; ?></button>
			</div>
		</div>
	</div>
</div>
<!-- /Delete Confirm Modal -->

<script type="text/javascript">
	var delete_title = "<?php echo $request_array['lg6_delete_request']; ?>";
	var delete_msg = "<?php echo $request_array['lg6_are_you_sure_wa']; ?>";
	var edit_text = "<?php echo $request_array['lg6_edit']; ?>";
	var delete_text = "<?php echo $request_array['lg6_delete']; ?>";
</script>
