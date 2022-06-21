<div class="page-wrapper">
            <div class="content container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Add Currency</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_currency" action="<?php echo base_url().'admin/currency/add_currency'; ?>" method="post"  enctype="multipart/form-data"  >
							<div class="form-group">
								<label for="parent_category">Country Name</label>
								<input type="text" name="country_name"  placeholder="Enter Country Name " class="form-control" id="country_name" required>
								<input type="hidden" value="" id="currency_id">
							</div>
							<div class="form-group">
								<div class="text-center text-error" id="error-exist"></div>
								<label for="category_name">Currency Code</label>
								<input type="text" name="currency_code"  placeholder="Enter Currency Code " class="form-control" id="currency_code" required>
							</div>
								<div class="form-group">
								<div class="text-center text-error" id="error-exist"></div>
								<label for="category_name">Currency Sign</label>
								<input type="text" name="currency_sign"  placeholder="Enter Currency Sign " class="form-control" id="currency_sign" required>
							</div>
							<div class="form-group">
								<div class="text-center text-error" id="error-exist"></div>
								<label>Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">--select--</option>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
							</div>
							
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/currency'?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
 