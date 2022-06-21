<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Add Adminlist</h4>
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
                        <form id="add_adminlist" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text"  name="firstname" id="firstname" required>
                            </div>
                            <div class="form-group">
                                <label>Email Id</label>
                                <input class="form-control" type="email"  name="email_id" id="email_id" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text"  name="username" id="username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password"  name="password" id="password">
                            </div>
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input class="form-control" type="file"  name="profile_image" accept="image/jpg,image/png,image/jpeg" id="profile_image" required>
                            </div>
                            <div class="form-group">
                                <label>Set Access</label>
                                <div class="example">
                                    <div><input type="checkbox" name="selectallall" id="selectallad1" class="all" value="21"> <label for="selectallall"><strong>Select all</strong></label></div>
                                    <?php
                                $module_result = $this->db->select('*')->get('module_list')->result_array();

                                     foreach ($module_result as $module) {
                                        $checkcondition  = "";
                                    ?>
                                    <div><input type="checkbox" class="checkboxad" name="accesscheck[]" id="check<?php echo $module['module_id'];?>" value="<?php echo $module['module_id'];?>"> <label for="check1"><?php echo $module['module_name'];?></label></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary addCat" name="form_submit" value="submit" type="submit">Add Adminlist</button>
                                 <a href="<?php echo $base_url; ?>adminlist" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


