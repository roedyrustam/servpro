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
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-md-8">
                        <h4 class="page-title">Subscriptions</h4>
                    </div>
                    <div class="col-12 col-md-4 text-right">
                        <a href="<?php echo $base_url; ?>add-subscription" class="btn btn-primary rounded pull-right"><i class="fas fa-plus"></i> Add Subscription</a>
                    </div>
                </div>
                <div class="row"> 
                  <?php
                  if(!empty($list)){
                    foreach ($list as $subscription) {
                    
                  ?>
                    <div class="col-sm-4 col-md-4 col-lg-3">
                        <div class="pricing-box">
                          <a href="<?php echo $base_url.'delete-subscription/'.$subscription['id']; ?>" class="delete-subscription" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                            <h3 class="pricing-title" data-toggle="tooltip" data-placement="top" title="<?php echo $subscription['subscription_name']; ?>" ><?php echo $subscription['subscription_name']; ?></h3>
                            <?php
                           $usercurrency_code = $defaultcurr[0]['value'];
                          if($usercurrency_code){
                            $curr_amt = get_gigs_currency($subscription['fee'], $subscription['currency_code'], $usercurrency_code);
                            $cc_code = $usercurrency_code;
                          }else{
                            $cc_code = $subscription['currency_code'];
                            $curr_amt = $subscription['fee'];
                          }
                           ?>
                             <h1 class="pricing-rate"><sup><?php echo strtoupper($cc_code); ?></sup><?php echo $subscription['fee']; ?></h1>
                            <p class="subs-duration"><?php echo $subscription['fee_description']; ?></p>
							<a href="<?php echo $base_url.'edit-subscription/'.$subscription['id']; ?>" class="btn btn-primary rounded w-md">Edit</a>
                        </div>
                    </div>
                  <?php } } ?>
                </div>
            </div>
        </div>
