<?php if($this->session->flashdata('error_message')) {  ?>
<div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
<?php $this->session->unset_userdata('error_message'); } ?>
<?php if($this->session->flashdata('success_message')) {  ?>
<div class="alert alert-success text-center in" id="flash_success_message"><?php echo $this->session->flashdata('success_message');?></div>
<?php $this->session->unset_userdata('success_message'); } ?>


<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$service = $language_content['language'];
			$service_array = !empty($service)?$service:'';
	 	?>
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $service_details['lg_home']; ?></a></li>
			<li><?php echo strtoupper($service_details['title']); ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<!-- Service  Details -->
<div class="service-view-section mt-4 mb-5">
	<div class="container">
		<div class="row">
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
			<div class="col-12 col-lg-8">
				<div class="service-provier-details">
					<div>
						<div class="service-provier-img">
							<?php if($chat_status == 0 || $service_details['provider_id'] == $this->session->userdata('user_id')){ ?>
									<a href="<?php echo $base_url.'user-profile/'.md5($service_details['provider_id']) ?>">
								<?php }else{ ?>
									<a href="javascript:void(0);">
								<?php } ?>
								<?php $profile_img = (!empty($service_details['profile_img']))?$service_details['profile_img']:'assets/img/placeholder.jpg'; ?>
								<img alt="" src="<?php echo $base_url.$profile_img ?>">
							</a>
						</div>
					</div>
					<div class="right-provier-details">
						<h4>
							<?php echo $service_details['username']; ?>
						</h4>
						<ul>
							<?php if($chat_status == 0 || $service_details['provider_id'] == $this->session->userdata('user_id')){ ?>
							<li><i class="fas fa-envelope"></i> <?php echo $service_details['email']; ?> </li>
							<li><i class="fas fa-phone-alt"></i> <?php echo $service_details['contact_number']; ?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php
					$description_details = (!empty($service_details['description_details']))?$service_details['description_details']:'';
					if(!empty($description_details)){
						$description_details = json_decode($description_details);
					}
				 ?>
				<div class="location-service">
			    	<h4><?php echo ucfirst($service_details['title']); ?></h4>
			    	<?php if(!empty($description_details)){ $i =1;?>
						<ol>
							<?php foreach ($description_details as $description) { ?>
								<li><?php echo ucfirst($description); ?></li>
							<?php  } ?>
						</ol>
					<?php } ?>
			    </div>
			    <div class="location-service provider-ratings">
			    	<h4>Ratings </h4>
			    	<div class="rating">
						<?php echo $service_array['lg6_ratings1']; ?> : 
							<?php
							for ($i=0; $i <5 ; $i++) { 
								if($i < $service_details['rating']){
								echo '<i class="fas fa-star filled"></i>';		
								}else{
									echo '<i class="fas fa-star"></i>';
								}
							?>
	                       <?php } ?>
						<span class="d-block average-rating mt-2">(<?php echo $service_details['rating'];?>)</span>	
					</div>
					<div class="mt-4">
						<a class="btn" href="javascript:;"  onclick="view_rating_reviews('<?php echo $service_details['p_id'];?>')" data-toggle="modal"><?php echo $service_array['lg6_view_reviews']; ?></a>
					</div>
			    </div>
			</div>
			<div class="col-12 col-lg-4">
				<div class="right-sidebar">
					<div class="card">
						<?php if($service_details['provider_id'] != $this->session->userdata('user_id')){ ?>
						<div class="card-header">
							<?php if($chat_status == 0){ ?>
								 <a class="btn w-100 border-btn" href="<?php echo $base_url."chat/".md5($service_details['provider_id']);?>"><?php echo $service_array['lg6_chat']; ?></a>
								 <?php if(empty($booked_sevice)) { ?>
								  <a class="btn w-100 mt-4" data-toggle="modal" data-target="#myModal" href="javascript:void(0);"><?php echo $service_array['lg6_book1']; ?></a>
								<?php } else if($booked_sevice->service_status == '1') { ?>
									<a class="btn w-100 mt-4" href="javascript:void(0);">Service Booked</a>
								<?php } else { ?>

										<span class="btn w-100 mt-4 badge bg-success">Completed</span>
								<?php }?>
							<?php }elseif($chat_status == 1){ ?>
								<?php if(empty($booked_sevice)) { ?>
								 <a class="btn w-100 mt-4" id="booking_service" href="javascript:void(0);"><?php echo $service_array['lg6_book1']; ?></a>
								<?php } ?>
								 <a href="javascript:void(0);" data-toggle="modal" data-target="#ddsubscribeConfirmModal" class="btn w-100 mt-4"><?php echo $service_array['lg6_chat']; ?></a>
						</div>
						<?php } } ?>
						<div class="card-body">
							<div class="available-time">
								<h4><?php echo $service_array['lg6_availability']; ?></h4>
								<?php
									$availability_details = (!empty($service_details['availability']))?$service_details['availability']:'';
									if(!empty($availability_details)){
										$availability_details = json_decode($availability_details,true);
									}
							 	?>
								<?php if(!empty($availability_details)){ $i =1;?>
								<ul>
									<?php foreach ($availability_details as $availability) {
									$day = $weekday = $timings = '';
									$day = $availability['day'];
									if($day == 1)
									{
										$weekday = 'Monday';
									}
									if($day == 2)
									{
										$weekday = 'Tuesday';
									}
									if($day == 3)
									{
										$weekday = 'Wednesday';
									}
									if($day == 4)
									{
										$weekday = 'Thursday';
									}
									if($day == 5)
									{
										$weekday = 'Friday';
									}
									if($day == 6)
									{
										$weekday = 'Saturday';
									}
									if($day == 7)
									{
										$weekday = 'Sunday';
									}
									
									$timings = $availability['from_time'] . "-" . $availability['to_time'];
									 ?>
									<li><?php echo ucfirst($weekday); ?> <span><?php echo $timings; ?></span></li>
									<?php  } ?>
								</ul>
							<?php } ?>
							</div>
							<div class="available-time mt-4">
								<h4>Location</h4>
								<div class="text-center map-col">
								    <div id="mylatitude" style="display: none;"></div>
							    	<div id="mylongitude" style="display: none;"></div>
							    	<div id="location" style="width: 100%; height: 360px;"></div>
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

<div class="modal fade custom-modal" id="subscribeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<a href="javascript:;" class="btn btn-success si_accept_confirm"><?php echo $service_array['lg6_yes']; ?></a>
				<button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal"><?php echo $service_array['lg6_cancel']; ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade custom-modal custom-modal book_time_slot" id="myModal" role="dialog">
 	<div class="modal-dialog modal-dialog-centered  modal-lg">
 		<!-- Modal content-->
 		<div class="modal-content">
 			<div class="modal-header">
 				<h5 class="modal-title text-center"><?php echo $service_array['lg6_booking_request']; ?></h5>
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          &times;
		        </button>
 				
 			</div>
 			<div class="modal-body">
 				<form id="" role="form" action="<?php echo base_url();?>user/service/book_service" method="POST" class="book-popup-form">
 					<div class="available-time-slots">
	 					<h4><?php echo $service_array['lg6_available_time_']; ?></h4>
	 					<div class="card">
				        	<div class="card-body">
		 						<div class="xyz book-popup-body">
		 							<div class="time-slots-list">
		 								<ul>
			 							<?php
			 							 $date_format = $this->db->get_where('system_settings',array('key' => 'date_format'))->row()->value;
			 							 $end_Date=date('Y-m-d', strtotime($service_details['end_date'].'+1 days'));
			 							 if($service_details['start_date'] == date("Y-m-d")) {
								             $period = new DatePeriod(
								             new DateTime($service_details['start_date']),
								             new DateInterval('P1D'),
								             new DateTime($end_Date)
								             );
							             } else if($service_details['start_date'] <= date("Y-m-d")) {
							             	$period = new DatePeriod(
								             new DateTime(date("Y-m-d")),
								             new DateInterval('P1D'),
								             new DateTime($end_Date)
								             );
							             } else if($service_details['start_date'] >= date("Y-m-d")) {
							             	$period = new DatePeriod(
								             new DateTime($service_details['start_date']),
								             new DateInterval('P1D'),
								             new DateTime($end_Date)
								             );
							             } 

							              $availability_details = json_decode($service_details['availability'],true);

							               $weekday =array();
							               $timings=array();


							              foreach ($availability_details as $availability) {
							                            $day = $availability['day'];

							                              if($day == 1)
							                              {
							                                $weekday[] = 'Mon';
							                                $weekdays = 'Mon';
							                              }
							                              if($day == 2)
							                              {
							                                $weekday[] = 'Tue';
							                                $weekdays = 'Tue';
							                              }
							                              if($day == 3)
							                              {
							                                $weekday[] = 'Wed';
							                                $weekdays = 'Wed';
							                              }
							                              if($day == 4)
							                              {
							                                $weekday[] = 'Thu';
							                                $weekdays = 'Thu';
							                              }
							                              if($day == 5)
							                              {
							                                $weekday[] = 'Fri';
							                                $weekdays = 'Fri';
							                              }
							                              if($day == 6)
							                              {
							                                $weekday[] = 'Sat';
							                                $weekdays = 'Sat';
							                              }
							                              if($day == 7)
							                              {
							                                $weekday[] = 'Sun';
							                                $weekdays = 'Sun';
							                              }

							                              $timings[$weekdays] = $availability['from_time'] . "-" . $availability['to_time'];
							                            }

							              foreach ($period as $key => $value) 
							              {

							                if (in_array($value->format('D'), $weekday))
							                {
							                  	if($service_details['end_date'] >= date("Y-m-d")) {

							                     $row['service_date']= $value->format('d-m-Y'); 
							                     $row['service_day']= $value->format('l'); 
							                     $row['service_time']= $timings[$value->format('D')];
							                     $row['is_selected']="0";
							                     


							                     echo'<li>
					 									<label class="custom-radio">
					 									<input required type="radio" value="'.$value->format('d-m-Y').','.$timings[$value->format('D')].'" name="availability_time">'.$value->format('d M Y').' ( '.$value->format('l').' : '.$timings[$value->format('D')].' ) 
					 										<span class="checkmark"></span>
					 									</label>
				 							    </li>';
							                  }
							                }
							                  
							             }
			 							?>	
			 							</ul>
		 							</div>	 							
		 						</div>												
			 				</div>
			 			</div>
			 			<div class="available-time-slots">
 							<label for="comment"><?php echo $service_array['lg6_notes']; ?>:</label>
 							<textarea class="form-control" rows="5" required="" name="notes" id="notes"></textarea>
 							<input type="hidden" name="provider_id" value="<?php echo $service_details['p_id'];?>">
 							<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>">
 							<?php 
 							if(!empty($this->session->userdata('user_latitude')) && !empty($this->session->userdata('user_longitude'))){ ?>
 							<input type="hidden" name="latitude"  value="<?php echo $this->session->userdata('user_latitude');?>">
 							<input type="hidden" name="longitude"  value="<?php echo $this->session->userdata('user_longitude');?>">

 						   <?php  }  else { ?>

 						   	<input type="hidden" name="latitude" id="current_latitude">
 							<input type="hidden" name="longitude" id="current_longitude">

 						  <?php }?>
 						</div>
 						<div class="text-center mt-4">
 							<button class="btn" type="submit" value="submit"><?php echo $service_array['lg6_submit']; ?></button>
 						</div>
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>
</div>

<div class="modal fade custom-modal" id="reviews" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      	<!-- Modal content-->
      	<div class="modal-content">
	        <div class="modal-header">
	          	<h5 class="modal-title"><?php echo $service_array['lg6_ratings__review']; ?></h5>
	          	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
		 		<div id="commentspopup" class="panel-fixed right">
					<div class="popup-body">
		                <div class="row">
		                  	<div class="col-md-12">
							  	<div class="scroll-wrapper">
			                      	<section class="comment-list">
				                        <!-- First Comment -->
				                        <div id="view_rating_reviews"></div>
				                        <!-- Second Comment Reply -->				
			                      	</section>
			                  	</div>  
		                  	</div>
		                </div>
					</div>
				</div>
	        </div>
      	</div>
    </div>
</div>

<script type="text/javascript">
	var subscribe_title = "<?php echo $service_array['lg6_subscribe']; ?>";
	var do_subscribe_msg = "<?php echo $service_array['lg6_please_do_subsc2']; ?>";
	var do_subscribe_msg1 = "<?php echo $service_array['lg6_are_you_sure_wa2']; ?>";
</script>

<?php if(isset($service_details['latitude']) && $service_details['latitude'] != ""){ ?>
<script type="text/javascript">
	var service_latitude='<?php echo $service_details['latitude'] ?>';
    var service_longitude='<?php echo $service_details['longitude'] ?>';
</script>
<?php } else { ?>
<script type="text/javascript">
	var service_latitude='28.610001';
    var service_longitude='77.230003';
</script>
<?php } ?>