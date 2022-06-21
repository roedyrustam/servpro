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

                            <ul class="nav nav-tabs navtab-bg nav-justified">

                                <li class="active tab"><a href="#general" data-toggle="tab">General</a></li>

                                <li class="tab"><a href="#seo_settings" data-toggle="tab">SEO</a></li> 

                                <li class="tab"><a href="#social_login" data-toggle="tab">Social Login</a></li>

                                <li class="tab"><a href="#push_notification" data-toggle="tab">Push Notification</a></li>

                                <li class="tab"><a href="#payment_setting" data-toggle="tab">Payments</a></li>

                                <li class="tab"><a href="#terms" data-toggle="tab">Terms & Condition</a></li>

                            </ul>

                            <div class="tab-content">

                                <div id="general" class="tab-pane active">

                                    <div class="form-group">

                                        <label class="col-sm-3 control-label">Website Name</label>

                                        <div class="col-sm-9">

                                            <input type="text" class="form-control" id="website_name" name="website_name" placeholder="Dreamguy's Technologies" value="<?php if (isset($website_name)) echo $website_name;?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Website Logo</label>
                                        <div class="col-sm-9">
                                            <div class="media">
                                                <div class="media-left">
                                                    <?php if (!empty($logo_front)){ ?><img src="<?php echo base_url().$logo_front?>" class="site-logo" /><?php } ?>
                                                </div>
                                                <div> 
                                                    <div class="uploader"><input type="file" id="site_logo" multiple="true"  class="form-control" name="site_logo" placeholder="Select file"></div>
                                                    <span class="help-block small">Recommended image size is <b>150px x 150px</b></span>
                                                </div>
                                            </div>
                                            <div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Favicon</label>
                                        <div class="col-sm-9">
                                            <div class="media">
                                                <div class="media-left">
                                                    <?php if (!empty($favicon)){ ?><img src="<?php echo base_url().'uploads/logo/'.$favicon?>" class="fav-icon" style="width:50px;height: 50px;" /><?php } ?>

                                                </div>

                                                <div class="media-body">

                                                    <div class="uploader"><input type="file"  multiple="true"  class="form-control" id="favicon" name="favicon" placeholder="Select file"></div>

                                                    <span class="help-block small">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></span>

                                                    <span class="help-block small">Accepted formats: only png and ico</span>

                                                </div>

                                            </div>

                                            <div id="img_upload_errors" class="text-danger" style="display:none">Please upload valid image file.</div>

                                        </div>

                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-3 control-label">Default Currency</label>

                                        <div class="col-sm-9">

                                            <input type="text" class="form-control" id="website_name" value="<?php if (isset($default_currency)) echo $default_currency;?>" readonly>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab-pane" id="seo_settings">
                                  <h4 class="card-title">SEO</h4>
                                  <div class="form-group">
                                    <label>Meta title</label>
                                    <input type="text" class="form-control" id="mete_title" name="meta_title" value="<?php if (isset($meta_title)) echo $meta_title;?>">
                                </div>
                                <div class="form-group">
                                    <label>Meta keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php if (isset($meta_keywords)) echo $meta_keywords;?>">
                                </div>
                                <div class="form-group">
                                    <label>Meta description</label>
                                    <textarea class="form-control" rows="6" id="meta_description" name="meta_description"><?php if (isset($meta_description)) echo $meta_description;?></textarea>
                                </div>
                            </div>



                            <div id="social_login" class="tab-pane">
                                <div class="col-md-6">
                                    <a href="https://www.codexworld.com/create-facebook-app-id-app-secret/" class="pull-right btn btn-primary btn-xs m-b-20" target="_blank">How to Create facebook app id?</a>
                                </div>

                                <div class="clearfix"></div>

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">Facebook App ID  </label>

                                    <div class="col-sm-9">

                                        <input type="text" class="form-control" id="website_facebook_app_id" name="website_facebook_app_id" placeholder="" value="<?php if (isset($website_facebook_app_id)) echo $website_facebook_app_id;?>">

                                    </div>

                                </div>



                                <div class="col-md-6">
                                    <a href="https://www.codexworld.com/create-google-developers-console-project/" class="pull-right btn btn-primary btn-xs m-b-20" target="_blank">How to Create google client id?</a>
                                </div>

                                <div class="clearfix"></div>



                                <div class="form-group">

                                    <label class="col-sm-3 control-label">Google Client Id </label>

                                    <div class="col-sm-9">

                                        <input type="text" class="form-control" id="website_google_client_id" name="website_google_client_id" placeholder="" value="<?php if (isset($website_google_client_id)) echo $website_google_client_id;?>">

                                    </div>

                                </div>



                            </div>



                            <div id="push_notification" class="tab-pane">

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">Firebase Server Key</label>

                                    <div class="col-sm-9">

                                        <input type="text" class="form-control" id="firebase_server_key" name="firebase_server_key"   value="<?php if (isset($firebase_server_key)) echo $firebase_server_key;?>">

                                    </div>

                                </div>



                            </div>

                            <div id="payment_setting" class="tab-pane">






                                <h3 class="text-primary">Stripe</h3>

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





                                </div>





                            </div>


                            <div id="terms" class="tab-pane">
                                <br>

                                <div class="form-group">

                                    <label class="col-sm-3 control-label">Terms</label>

                                    <div class="col-sm-9">

                                        <textarea class="form-control" style="height: 319px;" name="terms" id="summernote"><?php if (isset($terms)) echo $terms;?></textarea>



                                    </div>

                                </div>



                            </div>







                        </div>

                    </div>

                    <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>

                </form>
            </div>

        </div>
    </div>
</div>
</div>

