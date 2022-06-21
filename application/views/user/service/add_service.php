
	<section>
		<div class="block gray less-top less-bottom">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="innertitle">
                     <?php
                        $service = $language_content['language'];
                        $service_array = !empty($service)?$service:'';
                      ?>
							<h2><?php echo $service_array['lg_add_a_service']; ?></h2>
							<span>Add your desired Service here</span>
						</div>
					</div>
					<div class="col-lg-6">
						<ul class="breadcrumbs">
                   <li><a href="<?php echo $base_url; ?>home"><?php echo $service_array['lg_home']; ?></a></li>
							<li><a><?php echo $service_array['lg_add_a_service']; ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>


<section>
   <div class="block">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-10">
               <!-- PBox -->
               <div class="pbox border">
                  <div class="addlistingform">
                     <form method="post" enctype="multipart/form-data" autocomplete="off" id="add_service" action="">
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_title']; ?> *</span>
                                 <input type="text" name="service_title" id="service_title">
                              </div>
                           </div>

                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_sub_title']; ?>*</span>
                                 <input type="text" name="service_sub_title" id="service_sub_title">
                              </div>
                           </div>

                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_category']; ?> *</span>
                                 <select class="form-control select" title="Category" name="category" id="category"  data-live-search="true"></select>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_sub_category']; ?>*</span>
                                <select class="form-control select" title="Sub Category" name="subcategory" id="subcategory" data-live-search="true"></select>
                              </div>
                           </div>

                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_service_location']; ?> *</span>
                                 <input type="text" name="service_location" id="service_location">
                                 <input type="hidden" name="service_latitude" id="service_latitude">
                                 <input type="hidden" name="service_longitude" id="service_longitude">
                              </div>
                           </div>

                           <div class="col-lg-6">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_service_amount']; ?> *</span>
                                 <input type="text" name="service_amount" id="service_amount">
                              </div>
                           </div>

                            <div class="col-lg-12">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_service_offered']; ?>*</span>
                                 <input type="text" class="input_tags" data-role="tagsinput" name="service_offered[]" id="service_offered">
                              </div>
                           </div>

                           <div class="col-lg-12">
                              <div class="fieldformy">
                                 <span><?php echo $service_array['lg_about']; ?> *</span>
                                 <textarea id="about" class="" name="about"></textarea>
                              </div>
                           </div>

                           <div class="col-lg-12">
                              <a title="" class="uploadfile">
                              <img src="<?php echo base_url();?>assets/front_end/images/cloud.png" alt="">
                              <span><?php echo $service_array['lg_upload_service_images']; ?> </span>
                              <input type="file" name="images[]" id="images" multiple accept="image/jpeg, image/png, image/gif,">
                              <div id="uploadPreview"></div>
                              </a>
                             
                           </div>

                          
                           <div class="col-lg-12 float-right">
                             <button type="submit" name="form_submit" value="submit"><?php echo $service_array['lg_submit']; ?></button>
                           </div>
                           
                        </div>
                     </form>
                  </div>
               </div>
               
              
            </div>
         </div>
      </div>
   </div>
</section>