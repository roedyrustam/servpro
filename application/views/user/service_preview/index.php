<section>
		<div class="block no-padding">
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<ul class="restaurantslider">
							<?php 
							if(!empty($service['service_details_image']))
							{
								$service_image=explode(',', $service['service_details_image']);
								for ($i=0; $i < count($service_image) ; $i++) { 
									echo'<li><img src="'.base_url().$service_image[$i].'" alt="" /></li>';
								}
							}
							?>
				
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block no-padding gray">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="slhead">
							<div class="row">
								<div class="col-lg-6">
									<div class="sltitle">
										<h1><?php echo ucfirst($service['service_title']);?></h1>
										<span><?php echo ucfirst($service['service_sub_title']);?></span>
										<ul class="listmetas">
											<li><span class="ratedbox">3.5</span>3 Ratings</li>
											<li><a href="#" title=""><?php echo ucfirst($service['category_name']);?></a></li>
											<li><div class="currency"><i><?php echo currency_conversion(settings('currency'));?></i><?php echo $service['service_amount'];?></div></li>
										</ul>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="slbtnsspans">
										<span><i class="flaticon-pin"></i> <?php echo ucfirst($service['service_location']);?></span>
										<div class="slbtns">
											<a href="#" title=""><i class="flaticon-note"></i><?php echo ucfirst($service['lg_chat']);?></a>
											<a href="#" title=""><i class="flaticon-heart"></i><?php echo ucfirst($service['lg_save']);?></a>
											<a href="#" title=""><i class="flaticon-thumb-up"></i><?php echo ucfirst($service['lg_add_review']);?></a>
										</div>
									</div>
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
					<div class="col-lg-8 column">
						<div class="bbox">
							<h3><?php echo ucfirst($service['lg_about']);?></h3>
							<div class="ldesc">
								<?php echo $service['about'];?>
							</div>
						</div>
						<div class="bbox">
							<h3><?php echo ucfirst($service['lg_services_offered']);?></h3>
							<div class="amenties">
								<?php
								    if(!empty($service['service_offered']))
									{
										$service_offered=explode(',', $service['service_offered']);
										for ($j=0; $j < count($service_offered) ; $j++) { 
											echo'<span><i class="flaticon-map"></i>'.$service_offered[$j].'</span>';
										}
									}
								?>
								
								
							</div>
						</div>
						<div class="bbox">
							<h3><?php echo ucfirst($service['lg_most_popular_services']);?></h3>
							<div class="dishlist">
								<div class="dishlisthumb"><img src="<?php echo base_url();?>assets/front_end/images/rl1.jpg" alt="" /></div>
								<div class="dishlistinfo">
									<h3><?php echo ucfirst($service['lg_the_five_spot']);?> <i><?php echo ucfirst($service['lg_$5.95']);?></i></h3>
									<p>Three eggs scrambled together with Molinari soppressata salami, served with toast and choice of potatoes </p>
								</div>
							</div>
							<div class="dishlist">
								<div class="dishlisthumb"><img src="<?php echo base_url();?>assets/front_end/images/rl2.jpg" alt="" /></div>
								<div class="dishlistinfo">
									<h3>Cheese Omlet <i>$5.95</i></h3>
									<p>Three eggs scrambled together with Molinari soppressata salami, served with toast and choice of potatoes </p>
								</div>
							</div>
							<div class="dishlist">
								<div class="dishlisthumb"><img src="<?php echo base_url();?>assets/front_end/images/rl3.jpg" alt="" /></div>
								<div class="dishlistinfo">
									<h3>Waffle <i>$5.95</i></h3>
									<p>Three eggs scrambled together with Molinari soppressata salami, served with toast and choice of potatoes </p>
								</div>
							</div>
						</div>
						
						<div class="bbox">
							<h3>2 Reviews for <?php echo ucfirst($service['service_title']);?></h3>
							<div class="reviewssec">
								<div class="reviewthumb"> <img src="<?php echo base_url();?>assets/front_end/images/review1.jpg" alt="" /> </div>
								<div class="reviewinfo">
									<h3>Ali TUFAN</h3>
									<span>December 12, 2017 at 8:18 am</span>
									<ul class="listmetas justrate"><li><span class="rated">3.5</span>3 Ratings</li></ul>
									<p>We had the tasting menu here and it was one of the nicest meals I’ve ever had. The of the food service and surroundings it was marvellous.</p>
									<div class="wasreview">
										<span>Was This Review ...?</span>
										<div class="wasreviewbtn">
											<a href="#" title="" class="c1"><i class="flaticon-thumb-up"></i>Interesting 85</a>
											<a href="#" title="" class="c2"><i class="flaticon-smile"></i>Lol 45</a>
											<a href="#" title="" class="c3"><i class="flaticon-heart"></i>Love 87</a>
										</div>
									</div>
									<div class="reviewaction">
										<a href="#" title=""><i class="flaticon-back"></i> Reply</a>
									</div>
								</div>
							</div>
							<div class="reviewssec">
								<div class="reviewthumb"> <img src="images/review2.jpg" alt="" /> </div>
								<div class="reviewinfo">
									<h3>Ali TUFAN </h3>
									<span>December 12, 2017 at 8:18 am</span>
									<ul class="listmetas justrate"><li><span class="rated">3.5</span>3 Ratings</li></ul>
									<p>We had the tasting menu here and it was one of the nicest meals I’ve ever had. The of the food service and surroundings it was marvellous.</p>
									<div class="rgallery">
										<a href="#" title=""><img src="<?php echo base_url();?>assets/front_end/images/rg1.jpg" alt="" /></a>
										<a href="#" title=""><img src="<?php echo base_url();?>assets/front_end/images/rg2.jpg" alt="" /></a>
										<a href="#" title=""><img src="<?php echo base_url();?>assets/front_end/images/rg3.jpg" alt="" /></a>
									</div>
									<div class="wasreview">
										<span>Was This Review ...?</span>
										<div class="wasreviewbtn">
											<a href="#" title="" class="c1"><i class="flaticon-thumb-up"></i>Interesting 85</a>
											<a href="#" title="" class="c2"><i class="flaticon-smile"></i>Lol 45</a>
											<a href="#" title="" class="c3"><i class="flaticon-heart"></i>Love 87</a>
										</div>
									</div>
									<div class="reviewaction">
										<a href="#" title=""><i class="flaticon-back"></i> Reply</a>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="col-lg-4 column">
						<div class="openclosetiming">
							<h3>Closed <span>09:00 AM - 05:00 PM</span></h3>
							<span>Monday <i>2:00 pm - 11:45 pm</i></span>
							<span>Tuesday <i>2:00 pm - 11:45 pm</i></span>
							<span>Wednesday <i>2:00 pm - 11:45 pm</i></span>
							<span>Thursday <i>2:00 pm - 11:45 pm</i></span>
							<span>Friday <i>2:00 pm - 11:45 pm</i></span>
							<span>Saturday <i>2:00 pm - 11:45 pm</i></span>
							<span>Sunday <i>2:00 pm - 11:45 pm</i></span>
						</div>
						
						<div class="cbusiness">
							<h3>Contact business</h3>
							<form>
								<label>Your Name *</label>
								<input type="text" placeholder="Ali TUF..." />
								<label>Your Email Address*</label>
								<input type="text" placeholder="demo@demo.com" />
								<label>Your Message</label>
								<textarea placeholder="demo@demo.com"></textarea>
								<button type="submit">Send Message</button>
							</form>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</section>