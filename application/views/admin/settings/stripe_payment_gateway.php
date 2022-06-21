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
            <li class="nav-item active">
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
            <div class="col-lg-8 col-md-offset-2">
                <div class="card">
                    <div class="card-body">
                    	
                        <form action="<?php echo base_url() . 'admin/settings/edit/' . $list[0]['id']; ?>" method="post">
                            <h4 class="payment_title">Stripe</h4>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="outerDivFull" >
							<div class="switchToggle">
								<input name="stripe_show" type="checkbox"  value="1" id="switch" <?php if($list[0]['status']== 1) { ?>checked <?php } ?>>
								<label for="switch">Toggle</label>
							</div>
							</div>

                            <div class="form-group">
                                <label>Stripe Option</label>
                                <div>
                                    <div class="form-check form-radio form-check-inline">
                                        <input class="form-check-input stripe_payment" id="sandbox" name="gateway_type" value="sandbox" type="radio" <?= ($list[0]['gateway_type'] == "sandbox") ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="sandbox">Sandbox</label>
                                    </div>
                                    <div class="form-check form-radio form-check-inline">
                                        <input class="form-check-input stripe_payment" id="livepaypal" name="gateway_type" value="live" type="radio"  <?= ($list[0]['gateway_type'] == "live") ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="livepaypal">Live</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gateway Name</label>
                                <input  type="text" id="gateway_name" name="gateway_name"  value="<?php if (!empty($list[0]['gateway_name'])) {
    echo $list[0]['gateway_name'];
} ?>" required class="form-control" placeholder="Gateway Name">
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" id="api_key" name="api_key" value="<?php if (!empty($list[0]['api_key'])) {
    echo $list[0]['api_key'];
} ?>" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Rest Key</label>
                                <input type="text" id="value" name="value" value="<?php if (!empty($list[0]['value'])) {
    echo $list[0]['value'];
} ?>" required class="form-control">
                            </div>
                            <div class="mt-4">
                                    <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>

                                <a href="<?php echo base_url() . 'admin/stripe_payment_gateway' ?>" class="btn btn-link m-l-5">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
