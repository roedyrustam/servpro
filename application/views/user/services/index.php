<section>
		<div class="block gray less-top less-bottom">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="innertitle">
							<h2>Find a Professional</h2>
							<span>Get the best professional</span>
						</div>
					</div>
					<div class="col-lg-6">
						<ul class="breadcrumbs">
							<li><a href="<?php echo base_url();?>" title="">Home</a></li>
							<li><a href="#" title="">Find a Professional</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block remove-top">
			<div class="container">
				<div class="row">
                	<div class="col-lg-4 column">
						<div class="mlfilter-sec static">
							<div class="mltitle">
								<h3>Filters</h3>
							</div>
							<div class="mfilterform2">
								<form id="search_form" >
									<div class="row">
										<div class="col-lg-6">
											<div class="mlfield drop">
												<input type="text" id="price_range" placeholder="Price" />
												<i class="fa fa-money"></i>
												<div class="prices-dropsec">
													<div class="prices-drop">
														<p>What is the price range?</p>
														
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="mlfield">
												<select id="sort_by" class="selectbox">
													<option value="">Sort By</option>
													<option value="1">Price Low to High</option>
													<option value="2">Price High to Low</option>
													<option value="3">Newest</option>
												</select>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="mlfield s2">
												<input type="text" id="common_search" value="<?php if(isset($_POST["common_search"]) && !empty($_POST["common_search"])) echo $_POST["common_search"];?>" class="common_search" placeholder="What are you looking for?" />
											</div>
										</div>

										<div class="col-lg-12">
											<div class="mlfield s2">
												<select id="categories" class="selectbox">
													<option value="">All Categories</option>
													<?php foreach ($category as $crows) {
													echo'<option value="'.$crows['id'].'">'.$crows['category_name'].'</option>';	
													}?>
												</select>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="mlfield s2">
												<input type="text" id="service_location" value="<?php if(isset($_POST["user_address"]) && !empty($_POST["user_address"])) echo $_POST["user_address"];?>" placeholder="Location" />
												<input type="hidden"  value="<?php if(isset($_POST["user_latitude"]) && !empty($_POST["user_latitude"])) echo $_POST["user_latitude"];?>" id="service_latitude">
                                                 <input type="hidden" value="<?php if(isset($_POST["user_longitude"]) && !empty($_POST["user_longitude"])) echo $_POST["user_longitude"];?>" id="service_longitude">
												<i class="fa fa-map-marker"></i>
											</div>
										</div>

										
									</div>
									<button onclick="get_services()" type="button">Search <i class="fa fa-search" aria-hidden="true"></i></button>
								</form>	
							</div>
							
						</div>
					</div>
					<div class="col-lg-8 column">
						<div class="ml-filterbar">
							<h3><i class="flaticon-eye"></i><span id="service_count"><?php echo $count;?></span> Results Found</h3>
							<ul>
								<li class="doubleplaces"><span><i class="fa fa-th-large"></i></span></li>
								<li class="listingplaces"><span><i class="fa fa-th-list"></i></span></li>
							</ul>
						</div>
						<div class="ml-placessec">
							<div class="row" id="dataList">

								 <?php
								if(!empty($service))
								{
									foreach ($service as $srows) {
										$serviceimage=explode(',', $srows['service_image']);
								
										?>
								<div class="col-lg-6">
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
										<div class="boxplaces">
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
										</div>
									</div><!-- Places -->
								</div>
								<?php } }
							else { 
							
								echo '<div class="col-lg-12">
									<div class="places">
										No Services Found
									</div>
								</div>';
							 } 
							 
							 $pagination=explode('|',$this->ajax_pagination->create_links());
							 if(isset($pagination[1]) && !empty($pagination[1]))
							 {
							 	echo $pagination[1];
							 }
							  ?>

								
								
							</div>
						</div>
						
					</div>					
				</div>
			</div>
		</div>
	</section>