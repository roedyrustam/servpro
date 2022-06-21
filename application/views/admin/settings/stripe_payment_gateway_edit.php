<div class="page-wrapper">
            <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
					<?php if($this->session->flashdata('message')) { ?>
					<?php echo $this->session->userdata('message'); ?>
					<?php } ?>
                    <h4 class="page-title m-b-20 m-t-0">Stripe Payment Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                	<div class="card-box">
						<form class="form-horizontal" action="<?php echo base_url().'admin/settings/edit/'.$list['id']; ?>" method="post">
						<div class="card-box">
							<div class="form-group mb-0">
								<label class="control-label">Option</label>
								<div class="">
									
									<?php if ($list['gateway_type'] == 'sandbox') { ?>
										<div class="radio radio-inline">
										<input id="sandbox" name="gateway_type"  value="sandbox" type="radio" checked >
										<label for="sandbox"> Sandbox </label>
										</div>
									<?php } ?>	
									<?php if ($list['gateway_type'] == 'live') { ?>	
										<div class="radio radio-inline">
										<input id="livepaypal" name="gateway_type" value='live' type="radio"  checked>
										<label for="livepaypal"> Live </label>
										</div>
									<?php } ?>	
								</div>
							</div>
						</div>
					<div class="card-box mb-0">
						
						 
						<div class="clearfix"></div>
							<div class="form-group">
								<label class=" control-label">Gateway Name</label>
								<div class="">
									<input  type="text" id="gateway_name" name="gateway_name"  value="<?php if(!empty($list['gateway_name'])){ echo $list['gateway_name']; } ?>" required class="form-control" placeholder="Gateway Name" >
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">API Key</label>
								<div class="">
										<input type="text" id="api_key" name="api_key" value="<?php if(!empty($list['api_key'])){ echo $list['api_key']; } ?>" required class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class=" control-label">Rest Key</label>
								<div class="">
									<input type="text" id="value" name="value" value="<?php if(!empty($list['value'])){ echo $list['value']; } ?>" required class="form-control" >
								</div>
							</div>
					 
							<div class=" m-t-30">
							    <button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/stripe_payment_gateway' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</div>
					</form>
					</div>
					</div>
			</div>
		</div>
	</div>
		
 
