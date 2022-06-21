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
					<form class="form-horizontal" action="" method="post">
						<div class="card-box">
							<div class="form-group">
								<label class="col-sm-3 control-label">Option</label>
								<div class="col-sm-9">
									<div class="radio radio-inline">
										<input id="sandbox" name="gateway_type" value="sandbox" type="radio">
										<label for="sandbox"> Sandbox </label>
									</div>
									<div class="radio radio-inline">
										<input id="livepaypal" name="gateway_type" value='live' type="radio">
										<label for="livepaypal"> Live </label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<div class="clearfix"></div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Gateway Name</label>
								<div class="col-sm-9">
									<input type="text" id="gateway_name" name="gateway_name" value="" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">API Key</label>
								<div class="col-sm-9">
									<input type="text" id="api_key" name="api_key" value="" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">API Secret</label>
								<div class="col-sm-9">
									<input type="text" id="api_secret" name="api_secret" value="" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Status</label>
								<div class="col-sm-9">
									<div class="radio radio-inline">
										<input type="radio" id="blog_status1" value="1" name="status" checked="">
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" id="blog_status2" value="0" name="status">
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="text-center m-t-30">
								<button name="form_submit" value="submit" type="submit" class="btn btn-primary center-block">Add</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>