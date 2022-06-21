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
							 } 
							 
							$pagination=explode('|',$this->ajax_pagination->create_links());
							echo $pagination[1];
							?>

                         
						