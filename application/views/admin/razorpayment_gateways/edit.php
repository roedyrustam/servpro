<div class="content-page">
	<div class="content">
		<div class="container">
			<?php
			if ($this->session->userdata('message')) {
				echo $this->session->userdata('message');
			}
			?>
			<div class="row">
				<div class="col-sm-12">
					<form class="form-horizontal" action="<?php echo base_url() . 'admin/razorpayment_gateway/edit/' . $list['id']; ?>" method="post">
						<div class="card-box">
							<div class="form-group">
								<label class="col-sm-3 control-label">Option</label>
								<div class="col-sm-9">
									<?php if ($list['gateway_type'] == 'sandbox') { ?>
									<div class="radio radio-inline">
										<input id="sandbox" name="gateway_type" value="sandbox" type="radio" checked>
										<label for="sandbox"> Sandbox </label>
									</div>
									<?php } ?>
									
									<?php if ($list['gateway_type'] == 'live') { ?>
									<div class="radio radio-inline">
										<input id="livepaypal" name="gateway_type" value='live' type="radio" checked>
										<label for="livepaypal"> Live </label>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="card-box">
							<div class="clearfix"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Gateway Name</label>
								<div class="col-sm-9">
									<input type="text" id="gateway_name" name="gateway_name" value="<?php if (!empty($list['gateway_name'])) { echo $list['gateway_name']; } ?>" required class="form-control" placeholder="Gateway Name">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">API Key</label>
								<div class="col-sm-9">
									<input type="text" id="api_key" name="api_key" value="<?php if (!empty($list['api_key'])) { echo $list['api_key']; } ?>" required class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">API Secret</label>
								<div class="col-sm-9">
									<input type="text" id="api_secret" name="api_secret" value="<?php if (!empty($list['api_secret'])) { echo $list['api_secret']; } ?>" required class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status</label>
								<div class="col-sm-9">
									<div class="radio radio-inline">
										<input type="radio" id="blog_status1" value="1" name="status" <?php if ($list['status'] == 1) { echo 'checked=""'; } ?>>
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" id="blog_status2" value="0" name="status" <?php if ($list['status'] == 0) { echo 'checked=""'; } ?>>
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="line">
								<hr>
							</div>
							<div class="text-center m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url() . 'admin/razorpayment_gateway' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>