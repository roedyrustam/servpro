<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Add Category</h4>
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
                        <form id="add_category" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input class="form-control" type="text"  name="category_name" id="category_name">
                            </div>
                            <div class="form-group">
                                <label>Category Image</label>
                                <input class="form-control" type="file"  name="category_image" accept="image/jpg,image/png,image/jpeg" id="category_image">
                            </div>                           
                            <div class="m-t-20">
                                <button class="btn btn-primary addCat" name="form_submit" value="submit" type="submit">Add Category</button>
                                 <a href="<?php echo $base_url; ?>categories" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>