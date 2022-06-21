<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Edit Adminlist</h4>
                    </div>
                </div>
                <div class="row">
                    <?php if($this->session->flashdata('error_message')) {  ?>
                      <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message');
                 } ?>
                  <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message');
                  } ?>
                    <div class="col-md-8 col-md-offset-2">
                        <form id="update_adminlist" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label> Name</label>
                                <input class="form-control" type="text" value="<?php echo $adminlist['name'];?>"  name="firstname" id="firstname">

                                 <input class="form-control" type="hidden" value="<?php echo $adminlist['ADMINID'];?>"  name="admin_id" id="admin_id">
                            </div>
                            <div class="form-group">
                                <label>Email Id</label>
                                <input class="form-control" type="email" value="<?php echo $adminlist['email'];?>" name="email_id" id="email_id">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" value="<?php echo $adminlist['username'];?>" name="username" id="username">
                            </div>
                            
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input class="form-control" type="file"  name="profile_image" id="profile_image" accept="image/jpg,image/png,image/jpeg">
                            </div>
                            <div class="form-group">
                                <img src="<?php echo base_url().$adminlist['profile_thumb'];?>">
                            </div>
                           <div class="form-group">
                                <label>Set Access</label>
                                <div class="example1">
                                    <div><input type="checkbox" name="selectall1" id="selectallad1" class="all" value="1"> <label for="selectall1"><strong>Select all</strong></label></div>
                                    <?php
                                $module_result = $this->db->select('*')->get('module_list')->result_array();

                                     foreach ($module_result as $module) {
                                        $checkcondition  = "";
                                            $access_result = $this->db->where('admin_user_id',$adminlist['ADMINID'])->where('module_id',$module['module_id'])->where('access_status',1)->select('access_id')->get('module_access')->result_array();
                                            if(!empty($access_result)){
                                                $checkcondition  = "checked='checked'";
                                            }
                                    ?>
                                    <div><input type="checkbox"  name="accesscheck[]" <?php echo $checkcondition; ?> id="check<?php echo $module['module_id'];?>" value="<?php echo $module['module_id'];?>" class="checkboxad"> <label for="check1"><?php echo $module['module_name'];?></label></div>
                                    <?php } ?>                                  
                                </div>
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update Admin</button>
                                 <a href="<?php echo $base_url; ?>adminlist" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
