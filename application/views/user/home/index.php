
	<section>
		<div class="block no-padding">
			<div class="layer blackish">
				<div data-velocity="-.1" style="background: url('<?php echo base_url();?>assets/front_end/images/p1.jpg') repeat scroll 50% 422.28px transparent;" class="no-parallax parallax scrolly-invisible"></div><!-- PARALLAX BACKGROUND IMAGE -->	
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-12">
							<div class="listingsf">
								<h3>World's Largest <span>Marketplace</span></h3> 
								<p>Search From 12,45,754 Awesome Verified Ads! </p>
								<div class="listingform">
									<form action="<?php echo base_url();?>search" id="search_service" method="post">
										<div class="fieldform line">
											<i class="fa fa-television bficon" aria-hidden="true"></i>
											<div class="form-group mb-0">
											<input type="text" class="form-control border-0 mb-0 bg-white common_search" name="common_search" id="search-blk" placeholder="What are you looking for?" >
											</div>
										</div>
										<div class="fieldform">
											<i class="fa fa-location-arrow bficon" aria-hidden="true"></i>
											<div class="form-group mb-0">
											  <input type="text"  class="form-control mb-0 bg-white" value="<?php echo (!empty($this->session->userdata('user_address')))?$this->session->userdata('user_address'):''; ?>" name="user_address" id="user_address" placeholder="Your Location">
											  	<input type="hidden" value="<?php echo (!empty($this->session->userdata('user_latitude')))?$this->session->userdata('user_latitude'):''; ?>" name="user_latitude" id="user_latitude">
                                                <input type="hidden"  value="<?php echo (!empty($this->session->userdata('user_longitude')))?$this->session->userdata('user_longitude'):''; ?>" name="user_longitude" id="user_longitude">
											    <a onclick="current_location(1)" href="javascript:void(0);" class="position-absolute positionY" ><i class="fa fa-crosshairs" aria-hidden="true"></i></a>

											    
											  </div>
  
											
										</div>
																		
										<div class="fieldbtn">
											<button name="search" value="search" onclick="search_service()" type="button">Search <i class="fa fa-search" aria-hidden="true"></i></button>
										</div>
									</form>
								</div>
								<div class="formcat">
									<i class="fa fa-circle" aria-hidden="true"></i>
                                    <span>Popular Searches</span>
									<a href="#" title="">Food & Drink</a>
									<a href="#" title="">Hotel & Hostel</a>
									<a href="#" title="">Shop & Store</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
                    	<div class="row">
                        	<div class="col-md-6">
                            	<div class="heading">
                                    <h2>Featured Categories</h2>
                                    <span>What do you need to find?</span>
                                </div><!-- Heading -->
                            </div>
                            <div class="col-md-6">
                            	<div class="viewall">
                                    <h4><a href="<?php echo base_url();?>all-categories">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a></h4>
                                    <span>Featured Categories</span>
                                </div><!-- Heading -->
                            </div>
                        </div>						
						<div class="catsec">
							<div class="row">

								<?php
								if(!empty($category))
								{
									foreach ($category as $crows) {
								
										?>
								<div class="col-lg-4">
									<div class="category">
										<img src="<?php echo base_url().$crows['category_image'];?>" alt="" />
										<div class="cattitle">
											<h3><a href="#" title=""><i class="fa fa-circle" aria-hidden="true"></i> <?php echo ucfirst($crows['category_name']);?></a></h3>
										</div>
                                        <div class="catcount">
                                        	<i class="fa fa-clone" aria-hidden="true"></i> <?php echo $crows['category_count'];?> <i class="fa fa-dot-circle-o yellow" aria-hidden="true"></i>
                                        </div>
									</div><!-- Category -->
								</div>
							<?php } }
							else { 
							
								echo '<div class="col-lg-12">
									<div class="category">
										No Categories Found
									</div><!-- Category -->
								</div>';
							 } ?>

							</div>
						</div><!-- Cat Sec -->
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block gray">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
                    	<div class="row">
                        	<div class="col-md-6">
                            	<div class="heading">
                                    <h2>Most Popular Services</h2>
									<span>Explore the greates our services. You won’t be disappointed</span>
                                </div><!-- Heading -->
                            </div>
                            <div class="col-md-6">
                            	<div class="viewall">
                                    <h4><a href="<?php echo base_url();?>all-services">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a></h4>
                                    <span>Most Popular</span>
                                </div><!-- Heading -->
                            </div>
                        </div>
						<div class="carouselplaces">
							<ul id="carouselsec">

								<?php
								if(!empty($services))
								{
									foreach ($services as $srows) {

										$serviceimage=explode(',', $srows['service_image']);
								
										?>

								<li>	
									<div class="places">
										<div class="placethumb">
											<img src="<?php echo base_url().$serviceimage[0];?>" alt="" />
                                            <div class="favoptions">
                                            	<span> <a href="#"><i class="fa fa-heart-o"></i></a> </span>
                                            </div>
											<div class="placeoptions">
												<span class="pull-left tg-userprice"> <span class="profilepic"><img src="<?php echo base_url();?>assets/front_end/images/tes3.jpg"></span> <?php echo currency_conversion(settings('currency')).$srows['service_amount'];?> </span>
                                                <span class="pull-right tg-themetag yellowtag"> <?php echo ucfirst($srows['category_name']);?> </span>
											</div>
										</div>
										<div class="placeinfos">
											<h3><a href="<?php echo base_url().'service-preview/'.str_replace(' ', '-', $srows['service_title']).'?sid='.md5($srows['id']);?>" title=""><?php echo ucfirst($srows['service_title']);?></a></h3>
											<div class="rating">
												<i class="fa fa-star rated"></i>
												<i class="fa fa-star rated"></i>
												<i class="fa fa-star rated"></i>
												<i class="fa fa-star rated"></i>
												<i class="fa fa-star-o"></i> (3)
											</div>
										</div>
										<div class="placedetails">											
											<span class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i>View Phone No</span>
                                            <span class="pull-right"><?php echo ucfirst($srows['service_location']);?><i class="fa fa-map-marker" aria-hidden="true"></i></span>
										</div>
									</div><!-- Places -->
								</li>
								
								<?php } }
							else { 
							
								echo '<li>	
									<div class="places">
										No Services Found
									</div>
								</li>';
							 } ?>

								
								
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading howitworks">
							<h2>How It Works</h2>
							<span>Aliquam lorem ante, dapibus in, viverra quis</span>
						</div><!-- Heading -->
						<div class="howworksec">
							<div class="row">
								<div class="col-lg-4">
									<div class="howwork">
										<div class="iconround">
                                        	<div class="steps">01</div>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hiw1.png">
                                        </div>
										<h3>Choose What To Do</h3>
										<p>Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.</p>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="howwork">
										<div class="iconround">
                                        	<div class="steps">02</div>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hiw2.png">
                                        </div>
										<h3>Find What You Want</h3>
										<p>Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.</p>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="howwork">
										<div class="iconround">
                                        	<div class="steps">03</div>
                                            <img src="<?php echo base_url();?>assets/front_end/images/hiw3.png">
                                        </div>
										<h3>Amazing Places</h3>
										<p>Aliquam lorem ante, dapibus in, viverra quis, feugiat Phasellus viverra nulla ut metus varius laoreet.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	

