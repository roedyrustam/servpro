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
                        <form id="update_category" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input class="form-control" type="text" value="<?php echo $categories['category_name'];?>"  name="category_name" id="category_name">

                                 <input class="form-control" type="hidden" value="<?php echo $categories['id'];?>"  name="category_id" id="category_id">
                            </div>
                            <div class="form-group">
                                <label>Category Image</label>
                                <input class="form-control" type="file"  name="category_image" id="category_image" accept="image/jpg,image/png,image/jpeg">
                            </div>
                            <div class="form-group">
                                <img src="<?php echo base_url().$categories['category_image'];?>">
                            </div>
                           
                            <div class="m-t-20">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update Category</button>
                                 <a href="<?php echo $base_url; ?>categories" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
