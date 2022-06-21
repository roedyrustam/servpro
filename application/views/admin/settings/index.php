<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php if($this->session->flashdata('message')) { ?>
                    <?php echo $this->session->userdata('message'); ?>
                <?php } ?>
                <h4 class="page-title m-b-20 m-t-0">General Settings </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">

                        <div>

                            <ul class="nav nav-tab settings-tab">

                                <li class="nav-item"><a href="#general" data-toggle="tab" class="nav-link active">General</a></li>

                                <li class="nav-item"><a href="#seo_settings" data-toggle="tab" class="nav-link">SEO</a></li> 

                                <li class="nav-item"><a href="#social_login" data-toggle="tab" class="nav-link">Social Login</a></li>

                                <li class="nav-item"><a href="#push_notification" data-toggle="tab" class="nav-link">Push Notification</a></li>


                                <li class="nav-item"><a href="#terms" data-toggle="tab" class="nav-link">Terms & Condition</a></li>

                            </ul>

                            <div class="tab-content pt-4 mt-2">

                                <div id="general" class="tab-pane active">

                                    <div class="form-group">

                                        <label class="control-label">Website Name</label>

                                        <div class="">

                                            <input type="text" class="form-control" id="website_name" name="website_name" placeholder="Dreamguy's Technologies" value="<?php if (isset($website_name)) echo $website_name;?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Website Logo</label>
                                        <div class="">
                                            <div class="media">
                                                <div>
                                                    <div class="uploader"><input type="file" id="site_logo" multiple="true"  class="form-control" name="site_logo" placeholder="Select file"></div>
                                                    <span class="help-block small">Recommended image size is <b>150px x 150px</b></span>
                                                </div>
                                            </div>
                                            <div class="media-left mt-2">
                                                <?php if (!empty($logo_front)){ ?><img src="<?php echo base_url().$logo_front?>" class="site-logo" /><?php } ?>
                                            </div>
                                            <div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Favicon</label>
                                        <div class="">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="uploader"><input type="file"  multiple="true"  class="form-control" id="favicon" name="favicon" placeholder="Select file"></div>
                                                    <span class="help-block small">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></span>
                                                    <span class="help-block small">Accepted formats: only png and ico</span>
                                                </div>
                                            </div>
                                            <div class="media-left mt-2">
                                                <?php if (!empty($favicon)){ ?><img src="<?php echo base_url().'uploads/logo/'.$favicon?>" class="fav-icon" style="width:50px;height: 50px;" /><?php } ?>
                                            </div>
                                            <div id="img_upload_errors" class="text-danger" style="display:none">Please upload valid image file.</div>

                                        </div>

                                    </div>


                                    <div class="form-group">

                                        <label class="control-label">Default Currency</label>

                                        <div class="">

                                            <input type="text" class="form-control" id="website_name" value="<?php if (isset($reference_currency_code)) echo $reference_currency_code;?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
											<label class="control-label">Reference Currency</label>
											<div class="">
												<?php
												if (!isset($reference_currency_code)) {
													$reference_currency_code = '';
												}
												?>
												<select class="form-control" name="reference_currency_code">
													<option value="">Select Currency</option>
													<?php
													foreach ($currency as $key => $value) {
													?>
													<option value="<?php echo $value['currency_code']; ?>" <?php echo ($reference_currency_code == $value['currency_code']) ? 'selected' : ''; ?>><?php echo $value['currency_code']; ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
                                </div>

                                <div class="tab-pane" id="seo_settings">
                                  <h4 class="mb-4 mt-2">SEO</h4>
                                  <div class="form-group">
                                    <label class="control-label">Meta title</label>
                                    <div class="">
                                    <input type="text" class="form-control" id="mete_title" name="meta_title" value="<?php if (isset($meta_title)) echo $meta_title;?>">
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Meta keywords</label>
                                    <div class="">
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php if (isset($meta_keywords)) echo $meta_keywords;?>">
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Meta description</label>
                                    <div class="">
                                    <textarea class="form-control" rows="6" id="meta_description" name="meta_description"><?php if (isset($meta_description)) echo $meta_description;?></textarea>
                                </div>
                                </div>
                                <div class="form-group">
											<label class="control-label">Viewport</label>
											<div class="">
												<input type="text" class="form-control" id="viewport" name="viewport" value="<?php if (isset($viewport)) echo $viewport; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">The indifferent meta tags</label>
											<div class="">
												<input type="text" class="form-control" id="indiff_tags" name="indiff_tags" value="<?php if (isset($indiff_tags)) echo $indiff_tags; ?>">
											</div>
										</div>
                                <div class="form-group">
                                	<h4 class="mb-4">Social meta tags</h4>
							<div class="">
                                <ul class="nav nav-tab settings-tab">

                                <li class="nav-tab"><a href="#fb" data-toggle="tab" class="active nav-link">Facebook</a></li>

                                <li class="nav-tab"><a href="#twit" data-toggle="tab" class="nav-link">Twitter</a></li> 

                                <li class="nav-tab"><a href="#insta" data-toggle="tab" class="nav-link">Instagram</a></li>

                                <li class="nav-tab"><a href="#google_plus" data-toggle="tab" class="nav-link">Google+</a></li>

                                <li class="nav-tab"><a href="#linked_in" data-toggle="tab" class="nav-link">Linked In</a></li>


                            </ul>
                        </div>
                        </div>

                            <div class="tab-content">

                                <div id="fb" class="tab-pane active">
                                	<div class="form-group">
											<label class="control-label">Og:Url</label>

											<div class="">
												<input type="text" class="form-control" id="fb_og_url" name="fb_og_url" value="<?php if (isset($fb_og_url)) echo $fb_og_url; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Type</label>

											<div class="">
												<input type="text" class="form-control" id="fb_og_type" name="fb_og_type" value="<?php if (isset($fb_og_type)) echo $fb_og_type; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Title</label>

											<div class="">
												<input type="text" class="form-control" id="fb_og_title" name="fb_og_title" value="<?php if (isset($fb_og_title)) echo $fb_og_title; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Description</label>

											<div class="">
												<input type="text" class="form-control" id="fb_og_description" name="fb_og_description" value="<?php if (isset($fb_og_description)) echo $fb_og_description; ?>">
											</div>
											</div>
										</div>
											<div id="twit" class="tab-pane">
											<div class="form-group">
											<label class="control-label">Og:Url</label>

											<div class="">
												<input type="text" class="form-control" id="twitter_og_url" name="twitter_og_url" value="<?php if (isset($twitter_og_url)) echo $twitter_og_url; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Type</label>

											<div class="">
												<input type="text" class="form-control" id="twitter_og_type" name="twitter_og_type" value="<?php if (isset($twitter_og_type)) echo $twitter_og_type; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Title</label>

											<div class="">
												<input type="text" class="form-control" id="twitter_og_title" name="twitter_og_title" value="<?php if (isset($twitter_og_title)) echo $twitter_og_title; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Description</label>

											<div class="">
												<input type="text" class="form-control" id="twitter_og_description" name="twitter_og_description" value="<?php if (isset($twitter_og_description)) echo $twitter_og_description; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Image Url</label>

											<div class="">
												<input type="text" class="form-control" id="twitter_og_img" name="twitter_og_img" value="<?php if (isset($twitter_og_img)) echo $twitter_og_img; ?>">
											</div>
											</div>
											</div>
											<div id="insta" class="tab-pane">
											<div class="form-group">
											<label class="control-label">Og:Url</label>

											<div class="">
												<input type="text" class="form-control" id="insta_ogurl" name="insta_ogurl" value="<?php if (isset($insta_ogurl)) echo $insta_ogurl; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Type</label>

											<div class="">
												<input type="text" class="form-control" id="insta_ogtype" name="insta_ogtype" value="<?php if (isset($insta_ogtype)) echo $insta_ogtype; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Title</label>

											<div class="">
												<input type="text" class="form-control" id="insta_ogtitle" name="insta_ogtitle" value="<?php if (isset($insta_ogtitle)) echo $insta_ogtitle; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Description</label>

											<div class="">
												<input type="text" class="form-control" id="insta_ogdesc" name="insta_ogdesc" value="<?php if (isset($insta_ogdesc)) echo $insta_ogdesc; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Image Url</label>

											<div class="">
												<input type="text" class="form-control" id="insta_ogimgurl" name="insta_ogimgurl" value="<?php if (isset($insta_ogimgurl)) echo $insta_ogimgurl; ?>">
											</div>
											</div>
											</div>
												<div id="google_plus" class="tab-pane">
											<div class="form-group">
											<label class="control-label">Og:Url</label>

											<div class="">
												<input type="text" class="form-control" id="google_og_url" name="google_og_url" value="<?php if (isset($google_og_url)) echo $google_og_url; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Type</label>

											<div class="">
												<input type="text" class="form-control" id="google_og_type" name="google_og_type" value="<?php if (isset($google_og_type)) echo $google_og_type; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Title</label>

											<div class="">
												<input type="text" class="form-control" id="google_og_title" name="google_og_title" value="<?php if (isset($google_og_title)) echo $google_og_title; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Description</label>

											<div class="">
												<input type="text" class="form-control" id="google_og_description" name="google_og_description" value="<?php if (isset($google_og_description)) echo $google_og_description; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Image Url</label>

											<div class="">
												<input type="text" class="form-control" id="google_og_img" name="google_og_img" value="<?php if (isset($google_og_img)) echo $google_og_img; ?>">
											</div>
											</div>
											</div>
												<div id="linked_in" class="tab-pane">
											<div class="form-group">
											<label class="control-label">Og:Url</label>

											<div class="">
												<input type="text" class="form-control" id="linkedin_ogurl" name="linkedin_ogurl" value="<?php if (isset($linkedin_ogurl)) echo $linkedin_ogurl; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Type</label>

											<div class="">
												<input type="text" class="form-control" id="linkedin_ogtype" name="linkedin_ogtype" value="<?php if (isset($linkedin_ogtype)) echo $linkedin_ogtype; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Title</label>

											<div class="">
												<input type="text" class="form-control" id="linkedin_ogtitle" name="linkedin_ogtitle" value="<?php if (isset($linkedin_ogtitle)) echo $linkedin_ogtitle; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Description</label>

											<div class="">
												<input type="text" class="form-control" id="linkedin_ogdesc" name="linkedin_ogdesc" value="<?php if (isset($linkedin_ogdesc)) echo $linkedin_ogdesc; ?>">
											</div>
											</div>
											<div class="form-group">
											<label class="control-label">Og:Image Url</label>

											<div class="">
												<input type="text" class="form-control" id="linkedin_ogimgurl" name="linkedin_ogimgurl" value="<?php if (isset($linkedin_ogimgurl)) echo $linkedin_ogimgurl; ?>">
											</div>
											</div>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label">Robots</label>
											<div class="">
												<input type="text" class="form-control" id="robots" name="robots" value="<?php if (isset($robots)) echo $robots; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">Specific bots (Googlebot)</label>
											<div class="">
												<input type="text" class="form-control" id="specific_bots" name="specific_bots" value="<?php if (isset($specific_bots)) echo $specific_bots; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">Language</label>
											<div class="">
												<input type="text" class="form-control" id="language" name="language" value="<?php if (isset($language)) echo $language; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">Geo Position</label>
											<div class="">
												<input type="text" class="form-control" id="meta_geo_position" name="meta_geo_position" value="<?php if (isset($meta_geo_position)) echo $meta_geo_position; ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="control-label">Geo Placename</label>
											<div class="">
												<input type="text" class="form-control" id="meta_geo_placename" name="meta_geo_placename" value="<?php if (isset($meta_geo_placename)) echo $meta_geo_placename; ?>">
											</div>
										</div>

										<div class="form-group">
											<label class="control-label">Geo Region</label>
											<div class="">
												<input type="text" class="form-control" id="meta_geo_region" name="meta_geo_region" value="<?php if (isset($meta_geo_region)) echo $meta_geo_region; ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">Site verification</label>
											<div class="">
												<input type="text" class="form-control" id="site_verification" name="site_verification" value="<?php if (isset($site_verification)) echo $site_verification; ?>">
											</div>
										</div>


                            </div>



                            <div id="social_login" class="tab-pane">
                                <div class="">
                                    <a href="https://www.codexworld.com/create-facebook-app-id-app-secret/" class="btn btn-primary btn-xs m-b-20" target="_blank">How to Create facebook app id?</a>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group">

                                    <label class="control-label">Facebook App ID  </label>

                                    <div class="">

                                        <input type="text" class="form-control" id="website_facebook_app_id" name="website_facebook_app_id" placeholder="" value="<?php if (isset($website_facebook_app_id)) echo $website_facebook_app_id;?>">

                                    </div>

                                </div>



                                <div class="">
                                    <a href="https://www.codexworld.com/create-google-developers-console-project/" class="btn btn-primary btn-xs m-b-20" target="_blank">How to Create google client id?</a>
                                </div>

                                <div class="clearfix"></div>



                                <div class="form-group">

                                    <label class="control-label">Google Client Id </label>

                                    <div class="">

                                        <input type="text" class="form-control" id="website_google_client_id" name="website_google_client_id" placeholder="" value="<?php if (isset($website_google_client_id)) echo $website_google_client_id;?>">

                                    </div>

                                </div>



                            </div>



                            <div id="push_notification" class="tab-pane">

                                <div class="form-group">

                                    <label class="control-label">Firebase Server Key</label>

                                    <div class="">

                                        <input type="text" class="form-control" id="firebase_server_key" name="firebase_server_key"   value="<?php if (isset($firebase_server_key)) echo $firebase_server_key;?>">

                                    </div>

                                </div>



                            </div>

                            <div id="payment_setting" class="tab-pane">
                             	<h4 class="mb-3">Paypal</h4>

                            	 <div class="form-group">

                                    <label class="col-sm-3 control-label">Paypal Option</label>

                                    <div class="col-sm-9">

                                        <?php 

                                        $ckd1 = 'checked="checked"';

                                        $ckd2 = '';

                                        if (isset($paypal_option)){

                                            if($paypal_option==1){

                                                $ckd1 = 'checked="checked"';

                                                $ckd2 = '';

                                            }

                                            if($paypal_option==2){

                                                $ckd1 = '';

                                                $ckd2 = 'checked="checked"';

                                            }

                                        } ?>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd1; ?> name="paypal_option" value="1"> SandBox

                                        </label>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd2; ?> name="paypal_option" value="2"> Live

                                        </label>
                                    </div>
                                    <label class="col-sm-3 control-label mb-3">Paypal Payment</label>
											<div class="col-sm-9">
												<?php
												$ckd1 = 'checked="checked"';
												$ckd2 = '';
												if (isset($paypal_allow)) {
													if ($paypal_allow == 1) {
														$ckd1 = 'checked="checked"';
														$ckd2 = '';
													}
													if ($paypal_allow == 2) {
														$ckd1 = '';
														$ckd2 = 'checked="checked"';
													}
												}
												?>
												<label class="radio-inline"><input type="radio" <?php echo $ckd1; ?> name="paypal_allow" value="1"> Active</label>
												<label class="radio-inline"><input type="radio" <?php echo $ckd2; ?> name="paypal_allow" value="2"> Inactive</label>
											</div>

                                </div>
                                    <h4>PayTabs</h4>

                            	 <div class="form-group">

                                    <label class="col-sm-3 control-label mb-3">PayTabs Option</label>

                                    <div class="col-sm-9">

                                        <?php 

                                        $ckd1 = 'checked="checked"';

                                        $ckd2 = '';

                                        if (isset($paytabs_option)){

                                            if($paytabs_option==1){

                                                $ckd1 = 'checked="checked"';

                                                $ckd2 = '';

                                            }

                                            if($paytabs_option==2){

                                                $ckd1 = '';

                                                $ckd2 = 'checked="checked"';

                                            }

                                        } ?>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd1; ?> name="paytabs_option" value="1"> SandBox

                                        </label>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd2; ?> name="paytabs_option" value="2"> Live

                                        </label>
                                    </div>
                                    <label class="col-sm-3 control-label mb-3">PayTab Payment</label>
											<div class="col-sm-9">
												<?php
												$ckd1 = 'checked="checked"';
												$ckd2 = '';
												if (isset($paytabs_allow)) {
													if ($paytabs_allow == 1) {
														$ckd1 = 'checked="checked"';
														$ckd2 = '';
													}
													if ($paytabs_allow == 2) {
														$ckd1 = '';
														$ckd2 = 'checked="checked"';
													}
												}
												?>
												<label class="radio-inline"><input type="radio" <?php echo $ckd1; ?> name="paytabs_allow" value="1"> Active</label>
												<label class="radio-inline"><input type="radio" <?php echo $ckd2; ?> name="paytabs_allow" value="2"> Inactive</label>
											</div>

                                </div>
                    			<h4 class="mb-3">Razorpay</h4>

                            	 <div class="form-group">

                                    <label class="col-sm-3 control-label">Razorpay Option</label>

                                    <div class="col-sm-9">

                                        <?php 

                                        $ckd1 = 'checked="checked"';

                                        $ckd2 = '';

                                        if (isset($razorpay_option)){

                                            if($razorpay_option==1){

                                                $ckd1 = 'checked="checked"';

                                                $ckd2 = '';

                                            }

                                            if($razorpay_option==2){

                                                $ckd1 = '';

                                                $ckd2 = 'checked="checked"';

                                            }

                                        } ?>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd1; ?> name="razorpay_option" value="1"> SandBox

                                        </label>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd2; ?> name="razorpay_option" value="2"> Live

                                        </label>
                                    </div>
                                    <label class="col-sm-3 control-label">Razorpay Payment</label>
											<div class="col-sm-9">
												<?php
												$ckd1 = 'checked="checked"';
												$ckd2 = '';
												if (isset($razorpay_allow)) {
													if ($razorpay_allow == 1) {
														$ckd1 = 'checked="checked"';
														$ckd2 = '';
													}
													if ($razorpay_allow == 2) {
														$ckd1 = '';
														$ckd2 = 'checked="checked"';
													}
												}
												?>
												<label class="radio-inline"><input type="radio" <?php echo $ckd1; ?> name="razorpay_allow" value="1"> Active</label>
												<label class="radio-inline"><input type="radio" <?php echo $ckd2; ?> name="razorpay_allow" value="2"> Inactive</label>
											</div>

                                </div>
                                <h4 class="mb-3">Stripe</h4>

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">Stripe Option</label>

                                    <div class="col-sm-9">

                                        <?php 

                                        $ckd1 = 'checked="checked"';

                                        $ckd2 = '';

                                        if (isset($stripe_option)){

                                            if($stripe_option==1){

                                                $ckd1 = 'checked="checked"';

                                                $ckd2 = '';

                                            }

                                            if($stripe_option==2){

                                                $ckd1 = '';

                                                $ckd2 = 'checked="checked"';

                                            }

                                        } ?>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd1; ?> name="stripe_option" value="1"> SandBox

                                        </label>

                                        <label class="radio-inline">

                                            <input type="radio" <?php echo $ckd2; ?> name="stripe_option" value="2"> Live

                                        </label>
                                    </div>
                                    <label class="col-sm-3 control-label">Stripe Payment</label>
											<div class="col-sm-9">
												<?php
												$ckd1 = 'checked="checked"';
												$ckd2 = '';
												if (isset($stripe_allow)) {
													if ($stripe_allow == 1) {
														$ckd1 = 'checked="checked"';
														$ckd2 = '';
													}
													if ($stripe_allow == 2) {
														$ckd1 = '';
														$ckd2 = 'checked="checked"';
													}
												}
												?>
												<label class="radio-inline"><input type="radio" <?php echo $ckd1; ?> name="stripe_allow" value="1"> Active</label>
												<label class="radio-inline"><input type="radio" <?php echo $ckd2; ?> name="stripe_allow" value="2"> Inactive</label>
											</div>

                                </div>
                            </div>


                            <div id="terms" class="tab-pane">
                                <br>

                                <div class="form-group">

                                    <label class="control-label">Terms</label>

                                    <div class="">

                                        <textarea class="form-control" style="height: 319px;" name="terms" id="summernote"><?php if (isset($terms)) echo $terms;?></textarea>



                                    </div>

                                </div>



                            </div>







                        </div>

                    </div>
                    <div class="">
                    <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
                	</div>

                </form>
            </div>

        </div>
    </div>
</div>
</div>

