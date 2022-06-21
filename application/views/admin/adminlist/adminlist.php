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
                        <h4 class="page-title">Adminlist</h4>
                    </div>
                    <div class="col-12 col-md-4 text-right">
                        <a href="<?php echo $base_url; ?>add-adminlist" class="btn btn-primary rounded pull-right"><i class="fas fa-plus"></i> Add Admin</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="datatable table custom-table m-b-0 categories_table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile Image</th>
                                        <th> Name</th>
                                        <th> Email id</th>
                                        <th>User Name</th>
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
                                        <td><img src="'.$rows['profile_thumb'].'" class="w-40"></td>
                                        <td>'.$rows['name'].'</td>
                                        <td>'.$rows['email'].'</td>
                                        <td>'.$rows['username'].'</td>

                                        <td><a href="'.base_url().'edit-adminlist/'.$rows['ADMINID'].'" class="table-action-btn ml-2" title="Edit"><i class="fas fa-edit text-success"></i></a>&nbsp;&nbsp;
                                            <a data-toggle="modal" onclick="delete_adminlist('.$rows['ADMINID'].')" href="#" class="table-action-btn ml-2" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>
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


        <div class="modal fade" id="delete_adminlist" tabindex="-1" role="dialog" aria-labelledby="delete_adminlistLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="<?php echo base_url();?>admin/adminlist/delete_adminlist">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure want to delete this Admin?
        <input type="hidden" name="admin_id" id="admin_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
      </div>
      </form>
    </div>
  </div>
</div>
