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
												<span class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i><?php echo ucfirst($srows['lg_view_phone_no']);?></span>
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