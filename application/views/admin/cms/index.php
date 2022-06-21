
<!-- Page Wrapper -->
<div class="page-wrapper">
  <div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
      <div class="row">
<?php if($this->session->flashdata('error_message')) {  ?>
    <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
  <?php $this->session->unset_userdata('error_message');} ?>
<?php if($this->session->flashdata('success_message')) {  ?>
      <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
  <?php $this->session->unset_userdata('success_message'); } ?>
        <div class="col-sm-12">
          <h3 class="page-title">CMS</h3>
        </div>
      </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
      <div class="col-12">

        <!-- General -->

        <div class="card-box">
          <div class="card-header">
            <h4 class="card-title">Banner</h4>
          </div>
          <div class="card-body">


            <div class="settings-tabs">
              <ul class="nav nav-tabs navtab-bg nav-justified">
                <li class="active tab"><a  href="#banner" data-toggle="tab">Banner</a> </li>
                <li class="tab"><a href="#doctor_book" data-toggle="tab"><span>Banner Content</span></a></li>                
                <li class="tab"><a href="#login_image" data-toggle="tab"><span>Login Image</span></a></li>
                 <li class="tab"><a href="#app_details" data-toggle="tab"><span>App Link</span></a></li>
              </ul>
            </div>

            <div class="row">
              <div class="col-lg-9">
                <div class="tab-content">

                 <div class="tab-pane active active" id="banner">

                  <div class="clearfix"><br></div>
                  <form action="<?php echo base_url();?>admin/cms/add_banner"  id="banner_form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                      <label>Banner Background Image</label>
                      
                      <div class="uploader"><input type="file" id="banners"  class="form-control" name="banner" placeholder="Select file"></div>
                      <p class="form-text text-muted small mb-0">Recommended image size is <b>1600 x 210</b></p>  <span class="banner_error"></span>
                      <?php if (!empty($banner)){ ?><img id="banner_img_url" src="<?php echo base_url().$banner[0]['value']?>" class="site-logo img-responsive"><?php } ?>
                      <div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>
                    </div>
                    <button id="banner_submit1" type="submit" class="btn btn-primary center-block">Save Changes</button>
                  </form>
                </div>
                <div class="tab-pane" id="doctor_book">
                  <div class="clearfix"><br></div>
                  <form action="<?php echo base_url();?>admin/cms/add_doctor"  id="doctor_form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                      <label>Title</label>
                      <input type="text" id="doctor_title" name="doctor_title" class="form-control" value="<?php echo $doctor_title[0]['value'];?>">
                      <span class="doctor_title_error"></span>
                    </div>
                    <div class="form-group">
                      <label>Content</label>                      
                      <textarea  rows="4" cols="50" class="form-control" name="doctor_content" id="doctor_content"><?php echo $doctor_content[0]['value'];?></textarea>
                      <span class="doctor_content_error"></span>
                    </div>
                    <button id="doctor_submit1" type="submit" class="btn btn-primary center-block">Save Changes</button>
                  </form>
                </div>

                <div class="tab-pane"id="feature_image">
                  <div class="clearfix"><br></div>
                  <form action="<?php echo base_url();?>admin/cms/add_feature_img"  id="banner_form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                      <label>Available Features Image</label>
                      <div class="uploader"><input type="file" id="availabe_feature_images"  class="form-control" name="availabe_feature_image" placeholder="Select file"></div>
                      <p class="form-text text-muted small mb-0">Recommended image size is <b>421 x 376</b></p>  <span class="availabe_feature_error"></span>
                      <?php
                        $availabe_feature_image=settings('availabe_feature_image');
                        $img_url=base_url().$availabe_feature_image;

                        if(!empty($availabe_feature_image)){ ?>
                        <img src="<?php echo base_url().settings('availabe_feature_image')?>" class="site-logo" id="feature_img_url" style="width: 250px;">
                      <?php } ?>
                      <div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>
                    </div>
                    <button id="availabe_feature_image_submit1" type="submit" class="btn btn-primary center-block">Save Changes</button>
                  </form>
                </div>

                <div class="tab-pane" id="login_image">
                  <div class="clearfix"><br></div>
                  <form action="<?php echo base_url();?>admin/cms/add_login_img"  id="banner_form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                      <label>Login Image</label>
                      <div class="uploader"><input type="file" id="login_images"  class="form-control" name="login_image" placeholder="Select file"></div>
                      <p class="form-text text-muted small mb-0">Recommended image size is <b>1000 x 650</b></p>  <span class="login_error"></span>
                      <?php
                      $login_image=$login_image[0]['value'];
                      $img_url=base_url().$login_image;

                      if (!empty($login_image)){ ?>
                        <img src="<?php echo $img_url;?>" class="site-logo" id="img_url" >
                      <?php } ?>
                      <div id="img_upload_error" class="text-danger"  style="display:none"><b>Please upload valid image file.</b></div>
                    </div>
                    <button id="login_image_submit1" type="submit" class="btn btn-primary center-block">Save Changes</button>
                  </form>
                </div>

                 <div class="tab-pane" id="app_details">
                  <div class="clearfix"><br></div>
                  <form action="<?php echo base_url();?>admin/cms/add_app_link"  id="doctor_form" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                      <label>Android App Link</label>
                      <input type="text" id="android_app_link" name="android_app_link" class="form-control" value="<?php echo $android_app_link[0]['value'];?>">
                      <span class="doctor_title_error"></span>
                    </div>
                    <div class="form-group">
                      <label>IOS App Link</label>   
                       <input type="text" id="ios_app_link" name="ios_app_link" class="form-control" value="<?php echo $ios_app_link[0]['value'];?>"> 
                      <span class="doctor_content_error"></span>
                    </div>
                    <button id="app_submit" type="submit" class="btn btn-primary center-block">Save Changes</button>
                  </form>
                </div>


              </div>



            </div>
          </div>

        </div>
      </div>

      <!-- /General -->

    </div>
  </div>

</div>      
</div>
<!-- /Page Wrapper -->

</div>

<script type="text/javascript">
  var banner_url="<?php echo base_url();?>"+'admin/cms/add_banner';
  var login_url="<?php echo base_url();?>"+'admin/cms/add_login_img';
  var feature_url="<?php echo base_url();?>"+'admin/cms/add_feature_img';
  var specialities_url="<?php echo base_url();?>"+'admin/cms/add_specialities';
</script>