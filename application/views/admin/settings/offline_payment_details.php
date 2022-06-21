<?php 
$servie_staus = array(
array("id"=>1,'value'=>'Pending'),
array("id"=>2,'value'=>'approval'),
);
?>
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
                        <h4 class="page-title">Offline Payment List</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="datatable table custom-table m-b-0 categories_table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Subscription Plan</th>
                                        <th>Payment Document</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                    $i=1;
                                   
/*                                    echo "<pre>";print_r($list);exit;
*/                                    foreach ($list as $rows) 
                                    {
                                    	 $badge='';
                                    	 $disabled= '';
									if ($rows['status']==1) {
										$badge='Pending';
										$color='dark';
									}
									if ($rows['status']==2) {
										$badge='approval';
										$color='info';
										$disabled = "disabled";
									}
									
                                        echo'<tr>
                                        <td>'.$i++.'</td>
                                        <td>'.$rows['username'].'</td>
                                        <td>'.$rows['subscription_name'].'</td>
                                        <td><a href="'.base_url().$rows['upload_doc'].'" class="btn btn-primary btn-sm" download="Offline Payment Document"><i class="fas fa-download"></i></a></td>
                                        <td>'.$rows['expiry_date_time'].'</td>
                                        <td><label class="badge badge-'.$color.'">'.ucfirst($badge).'</lable></td>
                                        <td><select class="form-control chngstatus" name="ser_status" data-id="'.$rows['id'].'" data-userid="'.$rows['subscriber_id'].'"'.$disabled.'> 
												<option value="">Select Status</option>';
												foreach ($servie_staus as $pro) { 
												echo '<option value="'.$pro['id'].'">'.$pro['value'].'</option>';
												} 
											echo '</select></td>
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
