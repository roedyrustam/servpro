<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<?php
			$text = !(empty($language_content['language']))?$language_content['language']:'';
		?>
		<ul>
            <li><a href="<?php echo $base_url; ?>home"><?php echo $text['lg_home']; ?></a></li>
			<li><?php echo (!empty($text['lg6_history']))?$text['lg6_history']:'History'; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->

<div class="content technicians-section service-requests inner-request pt-4">
	<div class="container">
		<div class="service-tabs">
			<ul class="nav nav-pills">
				<li><a href="#pending_services" data-toggle="tab" class="active"><?php echo (!empty($text['lg6_pending']))?$text['lg6_pending']:'Pending'; ?></a></li>
				<li><a href="#completed_services" data-toggle="tab"><?php echo (!empty($text['lg6_completed']))?$text['lg6_completed']:'Completed'; ?></a></li>
			</ul>
		</div>
		<div class="service-list-wrap">
			<div class="tab-content pt-0">
				<div class="tab-pane" id="completed_services">
					<div class="row" id="completed_list">
						<?php
						$request_list = $history['request_list'];
						if(!empty($request_list)){
							foreach ($request_list as $request) {
								$profile_img = (!empty($request['profile_img']))?$request['profile_img']:'assets/img/placeholder.jpg';
								$description_details = (!empty($request['description']))?$request['description']:'';
								if(!empty($description_details)){
									$description_details = json_decode($description_details);
								}
							?>
							<div class="col-12 col-lg-6">
						        <div class="technician-widget">
									<div class="left">
										<a href="<?php echo $base_url; ?>history-view/<?php echo md5($request['r_id']) ?>">
											<img src="<?php echo $base_url.$profile_img; ?>" alt="">
										</a>
									</div>
									<div class="right">
										<div class="inner-right">
											<h4><a href="<?php echo $base_url; ?>history-view/<?php echo md5($request['r_id']) ?>"><?php echo ucfirst($request['title']); ?></a></h4>
											<?php
												$description_details = array_filter($description_details);
												if(count($description_details) > 0){ $i =1;?>
												<ol>
													<?php foreach ($description_details as $description) {
															if($i<=4){

														 ?>
														<li class="text-truncate"><?php echo ucfirst($description); ?></li>
													<?php } else{ break;}$i++;
												} ?>
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
						<?php }
						}else{ ?>
							<div class="col-sm-12">
								<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $text['lg6_no_details_were']; ?></a>
							</div>
						<?php }
					 	?>
					</div>
					<div class="loadmore_results" data-next-page="<?php echo $history['next_page']; ?>" data-loading='0' style="display: none">
					 	<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
					</div>
				</div>
				<div class="tab-pane active" id="pending_services">
					<div class="row" id="pending_list">
						<?php
						$pending_list = $pending['request_list'];
						if(!empty($pending_list)){
							foreach ($pending_list as $pend) {
								$profile_img = (!empty($pend['profile_img']))?$pend['profile_img']:'assets/img/placeholder.jpg';
								$penddescription_details = (!empty($pend['description']))?$pend['description']:'';
								if(!empty($penddescription_details)){
									$penddescription_details = json_decode($penddescription_details);
								}
							 ?>
								<div class="col-12 col-lg-6">
							        <div class="technician-widget">
										<div class="left">
											<a href="<?php echo $base_url; ?>history-view/<?php echo md5($pend['r_id']) ?>">
												<img src="<?php echo $base_url.$profile_img; ?>" alt="">
											</a>
										</div>
										<div class="right">
											<div class="inner-right">
												<h4><a href="<?php echo $base_url; ?>history-view/<?php echo md5($pend['r_id']) ?>"><?php echo ucfirst($pend['title']); ?></a></h4>
												<?php
													$penddescription_details = array_filter($penddescription_details);
													if(count($penddescription_details) >0){ $i =1;?>
													<ol>
														<?php foreach ($penddescription_details as $penddescription) {
																if($i<=3){

															 ?>
															<li class="text-truncate"><?php echo ucfirst($penddescription); ?></li>
														<?php } else{ break;}$i++;
													} ?>
													</ol>
												<?php } ?>
												<div class="location-col d-flex justify-content-between mt-2">
													<div>
														<i class="fas fa-calendar-week"></i> <?php echo date('d-m-Y',strtotime($pend['request_date'])); ?>
													</div>
													<div>
														<i class="far fa-clock"></i> <?php echo $pend['request_time']; ?>
													</div>
													<div>
														<h6><?php 
													$usercurrency_code = $this->session->userdata('usercurrency_code');
													if($usercurrency_code){
														$curr_amt = get_gigs_currency($pend['amount'], $pend['currency_code'], $usercurrency_code);
														echo strtoupper($usercurrency_code.' '.$curr_amt);
													}else{
														$curr_amt = get_gigs_currency($pend['amount'], $pend['currency_code'], $defaultcurrency[0]['value']);
														echo strtoupper($defaultcurrency[0]['value'].' '.$curr_amt);
													}
													 ?></h6>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php }

						}else{ ?>
							<div class="col-sm-12">
								<a href="javascript:void(0)" class="alter alter-danger" ><?php echo $text['lg6_no_details_were']; ?></a>
							</div>
						<?php }
					 	?>
					</div>
					 <div class="ploadmore_results" data-next-page="<?php echo $pending['next_page']; ?>" data-loading='0' style="display: none">
					 	<img src="<?php echo $base_url; ?>assets/img/loading.gif" >
					 </div>
				</div>
			</div>
		</div>
	</div>
</div>
