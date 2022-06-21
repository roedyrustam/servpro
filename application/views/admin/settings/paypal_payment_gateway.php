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
           <li class="nav-item active">
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
            <li class="nav-item">
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
                                    
                                        <h4 class="payment_title">Paypal</h4>
                                        <div class="outerDivFull">
                                        <div class="switchToggle">
                                            <input name="paypal_show" type="checkbox"   value="1" id="switch" <?php if ($list['status'] == 1) { echo 'checked'; } ?>>
                                            <label for="switch">Toggle</label>
                                        </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="control-label">Paypal Option</label>
                                            <div class="">
                                                <input id="sandbox" name="gateway_type"  value="sandbox" type="radio" <?php if ($list['gateway_type'] == 'sandbox') { echo 'checked'; } ?> >
                                                <label for="sandbox"> Sandbox </label>
                                                <input id="livepaypal" name="gateway_type" value='live' type="radio" <?php if ($list['gateway_type'] == 'live') { echo 'checked'; } ?>>
                                                <label for="livepaypal"> Live </label>
                                            </div>
                                        </div>
                                    
                            
                                    <div class="" id="paypal_sandbox">
                                        <h4 class="m-t-0 header-title m-b-20"><b>Sandbox</b></h4>
                                        <div class="form-group">
                                            <label class="control-label">Paypal Email</label>
                                            <input class="form-control" type="text" name="sandbox_email" value="<?php if (!empty($list['sandbox_email'])) { echo $list['sandbox_email']; } ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Paypal Password</label>
                                            <input class="form-control" type="password" name="sandbox_password" value="<?php if (!empty($list['sandbox_password'])) { echo $list['sandbox_password']; } ?>">
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label">Paypal Scretkey</label>
                                            <input class="form-control" type="text" name="sandbox_paypal_secret_key" value="<?php if (!empty($list['sandbox_paypal_secret_key'])) { echo $list['sandbox_paypal_secret_key']; } ?>">
                                        </div>
                                    </div>
                            
                                    <div class="" id="paypal_live">
                                        <h4 class="m-t-0 header-title m-b-20"><b>Live Paypal</b></h4>
                                        <div class="form-group">
                                            <label class="control-label">Paypal User</label>
                                            <input class="form-control" type="text" name="email" value="<?php if (!empty($list['email'])) { echo $list['email']; } ?>">
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label">Paypal Password</label>
                                            <input class="form-control" type="password" name="password" value="<?php if (!empty($list['password'])) { echo $list['password']; } ?>">
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label">Paypal Scretkey</label>
                                            <input class="form-control" type="text" name="live_paypal_secret_key" value="<?php if (!empty($list['live_paypal_secret_key'])) { echo $list['live_paypal_secret_key']; } ?>">
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label">Braintree Tokenization key</label>
                                            <input class="form-control" type="text" name="braintree_key" value="<?php if (!empty($list['braintree_key'])) { echo $list['braintree_key']; } ?>">
                                        </div> 
                                        <div class="form-group">
                                            <label class="control-label">Braintree Merchant ID</label>
                                            <input class="form-control" type="text" name="braintree_merchant" value="<?php if (!empty($list['braintree_merchant'])) { echo $list['braintree_merchant']; } ?>">
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label">Braintree Public key</label>
                                            <input class="form-control" type="text" name="braintree_publickey" value="<?php if (!empty($list['braintree_publickey'])) { echo $list['braintree_publickey']; } ?>">
                                        </div> 
                                        <div class="form-group">
                                            <label class="control-label">Braintree Private key</label>
                                            <input class="form-control" type="text" name="braintree_privatekey" value="<?php if (!empty($list['braintree_privatekey'])) { echo $list['braintree_privatekey']; } ?>">
                                        </div>  
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