<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Edit Category</h4>
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
                        <form id="update_ratingstype" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Rating Type Name</label>
                                <input class="form-control" type="text" value="<?php echo $ratingstype['name'];?>"  name="name" id="name">

                                 <input class="form-control" type="hidden" value="<?php echo $ratingstype['id'];?>"  name="id" id="id">
                            </div>                           
                            <div class="m-t-20">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update Rating Type</button>
                                 <a href="<?php echo $base_url; ?>ratingstype" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
