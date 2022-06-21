<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-12">
							<h3 class="page-title">SEO Settings</h3>
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
				<form accept-charset="utf-8" id="seo_settings" action="" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class=" col-lg-6 col-sm-12 col-12">
							<div class="card">
								<div class="card-body">
									<div class="form-group">
										<label>Meta Title <span class="manidory">*</span></label>
										<input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php if (isset($meta_title)) echo $meta_title; ?>">
									</div>
									<div class="form-group">
										<label>Meta Keywords <span class="manidory">*</span></label>
										<input type="text" data-role="tagsinput" class="input-tags form-control"  name="meta_keywords"  id="services" value="<?php if (isset($meta_keywords)) echo $meta_keywords; ?>">
									</div>
									<div class="form-group">
										<label>Meta Description  <span class="manidory">*</span></label>
										<textarea class="form-control"  name="meta_description" id="meta_description" value=""><?php if (isset($meta_description)) echo $meta_description;?></textarea>
									</div>
									<div class="form-groupbtn">
										<button name="form_submit" type="submit" class="btn btn-primary me-2" value="true">Update</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>