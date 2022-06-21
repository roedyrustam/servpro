<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Add Ratings Type</h4>
                    </div>
                </div>
                <?php if($this->session->flashdata('error_message')) {  ?>
                      <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message');
                 } ?>
                  <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message');
                  } ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form id="add_ratingstype" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Ratings Type</label>
                                <input class="form-control" type="text"  name="name" id="name">
                            </div>
                            
                            <div class="m-t-20">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Add Ratings Type</button>
                                 <a href="<?php echo $base_url; ?>ratingstype" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
