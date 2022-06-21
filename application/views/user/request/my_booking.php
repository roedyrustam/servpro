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
			<li><?php echo $request_array['lg6_my_bookings']; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service Requests -->
<div class="technicians-section service-requests inner-request pt-4">
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
						    	<select class="form-control select" name="search_filter" id="search_filter" onchange="loadmybooking()">
						    		<option value="10"><?php echo $request_array['lg6_all']; ?></option>
						    		<option value="1"><?php echo $request_array['lg6_pending']; ?></option>
						    		<option value="2"><?php echo $request['lg6_completed']; ?></option>
						    	</select>
							</div>
							<div>
								<a href="#" class="btn"><?php echo $request_array['lg_search']; ?></a>
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
						$notes = (!empty($request['notes']))?$request['notes']:'';

						$status = '';
						$class = '';
						if($request['service_status'] == -1){
							$status = $request_array['lg6_expired']; //'Expired';
							$class = 'bg-danger';
						}
						else if($request['service_status'] == 1){
							$status = $request_array['lg6_pending']; //'Pending';
							$class = 'bg-warning';
						}
						else if($request['service_status'] == 2){
							$status = $request_array['lg6_completed']; //'Completed';
							$class = 'bg-success';
						}
						else if($request['service_status'] == 3){
							$status = $request_array['lg6_declined']; //'Declined';
							$class = 'bg-danger';
						}
					?>
				<div class="col-12 col-lg-6">
			        <div class="technician-widget">
						<div class="left">
							<a href="<?php echo base_url()."service-view/".md5($request['provider_id']); ?>">
								<?php if(!empty($request['service_image'])) { ?>
									<img src="<?php echo base_url().$request['service_image']; ?>" alt="">
								<?php } else {?>
								<img src="<?php echo base_url().'assets/img/placeholder.jpg'; ?>" alt="">
							<?php } ?>
							</a>
						</div>
						<div class="right">
							<div class="inner-right">
								<span class="badge <?php echo $class; ?>"><?php echo $status; ?></span>
								<h4><a href="<?php echo base_url()."service-view/".md5($request['provider_id']); ?>"><?php echo ucfirst($request['title']); ?></a></h4>
								<ol>
									<li class="text-truncate"><?php echo $request_array['lg6_name']; ?> : <?php echo $request['full_name']; ?></li>
									<li class="text-truncate"><?php echo $request_array['lg6_details']; ?> : <?php echo $request['notes']; ?></li>
								</ol>
								<div class="location-col d-flex justify-content-between mt-2">
									<div>
										<i class="fas fa-calendar-week"></i> <?php echo date($date_format,strtotime($request['service_date'])); ?>
									</div>
									<div>
										<?php
										 $time_format = $this->db->get_where('system_settings',array('key' => 'time_format'))->row()->value;
										if($time_format == '12 Hours') {
										    $from_time = date('G:ia', strtotime( $request['from_time']));
										    $to_time = date('G:ia', strtotime( $request['to_time']));
										} elseif($time_format == '24 Hours') {
										   $from_time = date('H:i:s', strtotime( $request['from_time']));
										   $to_time = date('H:i:s', strtotime( $request['to_time']));
										} else {
										    $from_time = date('G:ia', strtotime( $request['from_time']));
										    $to_time =  date('G:ia', strtotime( $request['to_time']));
										}
										?>
										<i class="far fa-clock"></i> <?php echo $from_time;?> - <?php echo $to_time;?>
									</div>
								</div>
								<div class="location-col d-flex justify-content-between mt-2 pb-1">
									<div>
										<i class="fas fa-phone-alt"></i> <?php echo $request['contact_number']; ?>
									</div>
								</div>
								<?php if($request['service_status'] == '2' && $request['review_count'] == 0) { 

									?>
									<div class="location-col d-flex justify-content-between align-items-center mt-2 pb-1">
										<div><a class="btn btn-sm" href="javascript:;" onclick="post_reviews(<?php echo $request['id']; ?>,<?php echo $request['provider_id']; ?>)" data-toggle="modal">Rate Now</a></div>
									</div>
								<?php } ?>
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
			<div class="loadmore_results" data-next-page="<?php echo $requests['next_page']; ?>" data-loading='0' data-search="0" style="display: none">
	 			<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
	 		</div>
		</div>
	</div>
</div>
<!-- /Service Requests -->

<!-- Delete Confirm Modal -->
<div class="modal fade custom-modal" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<!-- /Delete Confirm Modal -->

<!-- Reviews -->
<div class="modal fade custom-modal" id="reviews" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
	        	<h4 class="modal-title"><?php echo $request_array['lg6_ratings__review']; ?></h4>
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
				 <div id="commentspopup" class="panel panel-default panel-fixed right">
					<div class="panel-heading">
						<strong class=""><?php echo $request_array['lg6_ratings1']; ?></strong>
					</div>
					<div class="panel-body popup-body">
						<form method="post" action="<?php echo base_url();?>post-reviews">
			                <div class="row">
			                  <div class="col-md-12">
							  <div class="scroll-wrapper">
			                      <section class="comment-list">
			                            <input name="rating" value="0" required="" id="rating_star" type="hidden" />
										<div class="overall-rating"></div>                 
			                      </section>
			                  </div>
							  <div class="row">
							  <div class="col-sm-12">
								  <div class="sticky-bottom-blk">
				                      <h5 class="page-header mt-23"><?php echo $request_array['lg6_post_reviews']; ?></h5>
				                      <div class="message-area review-message-area">
				                      	<div class="input-group d-flex flex-wrap align-items-center">
				                      	  	<input type="hidden" name="booking_id" id="booking_id">
				                      	  	<input type="hidden" name="p_id" id="service_id">  
					                        <textarea class="form-control" name="review" required="" placeholder="<?php echo $request_array['lg6_type_message']; ?>">
					                        </textarea>
					                        <span class="input-group-btn mt-3">
					                            <button class="btn btn-custom" type="submit"><i class="fa fa-paper-plane"></i></button>
					                        </span>
				                          </div>
				                      </div>
								  </div>
			                      </div>
								  </div> 
			                  </div>
			                </div>
			            </form>
					</div>
				</div>
	        </div>
	    </div>
    </div>
</div>
<!-- /Reviews -->

<script type="text/javascript">
	var delete_title = "<?php echo $request_array['lg6_delete_request']; ?>";
	var delete_msg = "<?php echo $request_array['lg6_are_you_sure_wa']; ?>";
	var edit_text = "<?php echo $request_array['lg6_edit']; ?>";
	var delete_text = "<?php echo $request_array['lg6_delete']; ?>";
	var name_text="<?php echo $request_array['lg6_name']; ?>";
	var details_text="<?php echo $request_array['lg6_details']; ?>";
	var rate_now_text="<?php echo $request_array['lg6_rate_now']; ?>";
</script>
