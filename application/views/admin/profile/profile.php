<?php 
$user_role = $this->db->get_where('administrators', array('ADMINID'=>$this->session->userdata('admin_id')))->row()->user_role;
?>    
 <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 class="page-title">Profile</h4>
                    </div>
                </div>
                <div class="card-box profile-cardbox">
                    <div class="row">
                        <div class="col-md-12">
                          <?php if($this->session->flashdata('error_message')) {  ?>
                        	  <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                        	<?php $this->session->unset_userdata('error_message');
                         } ?>
                          <?php if($this->session->flashdata('success_message')) {  ?>
                        		<div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                        	<?php $this->session->unset_userdata('success_message');
                          } ?>
                          <div class="card-body">

      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item active home_tab"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Profile Settings</span></a> </li>
        <li class="nav-item home_add"> <a class="nav-link" data-toggle="tab" href="#pass" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Change password</span></a> </li>
      </ul>
      <div class="tab-content tabcontent-border">
        <div class="tab-pane active" id="profile" role="tabpanel">
          <div class="clearfix"></br></div>
              <h4 class="card-title">Profile Details</h4>
              <form id="profile_settings_form" class="form-horizontal settings-form" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-md-3 control-label">Username</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" value="<?php echo $details['username']; ?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Profile Image</label>

                  <div class="col-sm-7">

                      <div class="media align-items-center">

                        <div class="media-left">


                          <img src="<?php

                    if (!empty($details['profile_thumb'])) {

                      echo base_url($details['profile_thumb']);

                    } else {

                      echo base_url('assets/img/user.jpg');

                    }

                    ?>" width="100" height="100" class="profile-img avatar-view-img" /></div>

                        <div class="media-body">

                          <div class="uploader ml-2"><button class="btn btn-primary avatar-view-btn">Change profile picture</button>
                          <p style="display: none;"><input type="hidden" id="crop_prof_img" name="profile_img"></p>
                        </div>

											    <span id="image_error" class="text-danger" style="display:none">Please select an image.</span>

                        </div>

                      </div>

                  </div>
                </div>
                <div class="text-right save-form">
                  <button name="save_profile_change" id="save_profile_change" onclick="changeAdminProfile()" class="btn save-btn btn-primary" type="button">Save</button>
                </div>
              </form>
            </div>
        <div class="tab-pane" id="pass" role="tabpanel">
          <div class="clearfix"></br></div>
              <h4 class="card-title">Change password</h4>
              <form id="change_password_form" class="form-horizontal settings-form" action="<?php echo $base_url; ?>admin/profile/change_password" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-md-3 control-label">Current Password</label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" id="current_password" name="current_password" value="">
                    <span id="same_error" class="text-danger" style="display:none">Current and new password is same</span>
                    <span id="current_block_error" class="text-danger" style="display:none">Please enter current password</span>
                    <span id="current_chkblock_error" class="text-danger" style="display:none">Current password you have entered is invaild</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">New Password</label>
                  <div class="col-md-9">
                    <input type="password" id="new_password" name="new_password" class="form-control">
                    <span id="new_block_error" class="text-danger" style="display:none">Please enter new password</span>
                    <span class="text-danger" id="passwordchk_error" style="display: none;">Password should have min 8 chars uppercase lowercase number and special character</span>
                    <span id="new_blockchk_error" class="text-danger" style="display:none">Please enter different password</span>
                  </div>
                  </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Repeat Password</label>
                  <div class="col-md-9">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="">
                    <span id="repeat_block_error" class="text-danger" style="display:none">Please enter repeat password</span>
                    <span id="repeat_chkblock_error" class="text-danger" style="display:none">Repeat password is not matched</span>
                  </div>
                  </div>
                   <?php if ($user_role == 1) { ?>
                <div class="save-form">
                  <button name="save_profile_change" id="cform_submit" class="btn btn-primary save-btn" type="submit">Save</button>
                </div>
                 <?php } ?>
              </form>
            </div>
          </div>
        </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--modal-->
    <div class="modal custom-modal fade" id="avatar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Profile Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <?php $curprofile_img = (!empty($profile['profile_img']))?$profile['profile_img']:''; ?>
        <form class="avatar-form" action="<?=base_url('login/crop_profile_img/'.$curprofile_img)?>" enctype="multipart/form-data" method="post">
              <!-- Upload image and data -->
              <div class="avatar-upload">
                <input class="avatar-src" name="avatar_src" type="hidden">
                <input class="avatar-data" name="avatar_data" type="hidden">
                <label for="avatarInput">Select Image</label>
                <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                                    <span id="image_upload_error" class="error" style="display:none;"> Please Upload an Image . </span>
              </div>
              <!-- Crop and preview -->
              <div class="row">
                <div class="col-md-12">
                <div class="avatar-wrapper"></div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <button class="btn btn-primary avatar-save pull-right" type="submit">Yes, Save Changes</button>
                </div>
              </div>
          </form>
        </div>
        </div>
      </div>
    </div>
    <!--modal ends-->
        </div>
