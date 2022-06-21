<?php
$query = $this->db->query("SELECT * FROM offline_payment");
$bank_details = $query->row_array();
?>
<div class="page-wrapper">
            <div class="content container-fluid">
         <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Payment Settings</h3>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <?php if($this->session->flashdata('error_message')) {  ?>
              <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
            <?php $this->session->unset_userdata('error_message');
         } ?>
          <?php if($this->session->flashdata('success_message')) {  ?>
                <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
            <?php $this->session->unset_userdata('success_message');
          } ?>
        <ul class="nav nav-tabs menu-tabs">
           <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/paypal_payment_gateway'; ?>">PayPal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/paytab_payment_gateway'; ?>">Paytab</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/stripe_payment_gateway'; ?>">Stripe</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url() . 'admin/razor_payment_gateway'; ?>">Razorpay</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url() . 'admin/offlinepayment'; ?>">Offline Payment</a>
            </li>
        </ul>
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
                        <div class="card">
                            <div class="card-body">
                                <form id="paypal_save" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <h4 class="payment_title">Offline Payment</h4>
                                        <div class="outerDivFull" >
                                        <div class="switchToggle">
                                            <input name="offline_show" type="checkbox"  value="1" id="switch"<?=$bank_details['status']?'checked':'';?>>
                                            <label for="switch">Toggle</label>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Bank Name</label>
                                            <input class="form-control" type="text" name="bank_name" value="<?php if (isset($bank_details['bank_name'])) echo $bank_details['bank_name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Account Holder Name</label>
                                            <input class="form-control" type="text" name="holder_name" value="<?php if (isset($bank_details['holder_name'])) echo $bank_details['holder_name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Account Number</label>
                                            <input class="form-control" type="text" name="account_num" value="<?php if (isset($bank_details['account_num'])) echo $bank_details['account_num']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">IFSC Code</label>
                                            <input class="form-control" type="text" name="ifsc_code" value="<?php if (isset($bank_details['ifsc_code'])) echo $bank_details['ifsc_code']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Branch Name</label>
                                            <input class="form-control" type="text" name="branch_name" value="<?php if (isset($bank_details['branch_name'])) echo $bank_details['branch_name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">UPI Id</label>
                                            <input class="form-control" type="text" name="upi_id" value="<?php if (isset($bank_details['upi_id'])) echo $bank_details['upi_id']; ?>">
                                        </div>
                                        <div class="m-t-20 ">
                                        <button class="btn btn-primary addCat" name="form_submit" value="submit" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>