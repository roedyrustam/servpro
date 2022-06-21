<div class="page-wrapper">
            <div class="content container-fluid">
                <?php if($this->session->flashdata('error_message')) {  ?>
                      <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message');
                 } ?>
                  <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message');
                  } ?>
                <div class="row align-items-center">
                    <div class="col-12 col-md-8">
                        <h4 class="page-title">Categories</h4>
                    </div>
                    <div class="col-12 col-md-4 text-right">
                        <a href="<?php echo $base_url; ?>add-category" class="btn btn-primary rounded pull-right"><i class="fas fa-plus"></i> Add Category</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table m-b-0 categories_table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Image</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    foreach ($list as $rows) 
                                    {
                                        echo'<tr>
                                        <td>'.$i++.'</td>
                                        <td><img src="'.base_url().$rows['category_image'].'" class="w-40"></td>
                                        <td>'.$rows['category_name'].'</td>
                                        <td><a href="'.base_url().'edit-category/'.$rows['id'].'" class="table-action-btn ml-2" title="Edit"><i class="fas fa-edit text-success"></i></a>&nbsp;&nbsp;
                                            <a data-toggle="modal" onclick="delete_category('.$rows['id'].')" href="#" class="table-action-btn ml-2" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
                                        </td>
                                          </tr>';
                                       
                                    }

                                    ?>
                                    

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="delete_category" tabindex="-1" role="dialog" aria-labelledby="delete_categoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="<?php echo base_url();?>admin/categories/delete_category">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure want to delete this category?
        <input type="hidden" name="category_id" id="category_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
      </form>
    </div>
  </div>
</div>
