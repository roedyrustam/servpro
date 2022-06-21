<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Edit Subcategory</h4>
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
                        <form id="update_subcategory" method="post" autocomplete="off" enctype="multipart/form-data">
                             <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category" id="category">
                                    <option value="">--select--</option>
                                    <?php
                                    foreach ($categories as $rows) {
                                    ?>
                                    <option value="<?php echo $rows['id'];?>" <?php if($rows['id']==$subcategories['category']) echo 'selected';?>><?php echo $rows['category_name'];?></option>
                                   <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subcategory Name</label>
                                <input class="form-control" type="text" value="<?php echo $subcategories['subcategory_name'];?>"  name="subcategory_name" id="subcategory_name">

                                 <input class="form-control" type="hidden" value="<?php echo $subcategories['id'];?>"  name="subcategory_id" id="subcategory_id">
                            </div>
                            <div class="form-group">
                                <label>Category Image</label>
                                <input class="form-control" type="file"  name="subcategory_image" id="subcategory_image">
                            </div>
                            <div class="form-group">
                                <img src="<?php echo base_url().$subcategories['subcategory_image'];?>">
                            </div>
                           
                            <div class="m-t-20">
                                <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Update subcategory</button>
                                 <a href="<?php echo $base_url; ?>subcategories" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
