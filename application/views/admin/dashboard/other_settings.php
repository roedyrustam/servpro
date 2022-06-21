<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title">Other Settings</h3>
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
		<div class="row">
			<div class=" col-lg-6 col-sm-12 col-12">
				<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="google_analytics" action="<?php echo base_url('admin/settings/analytics'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
				<div class="card">
					<div class="card-header">
						<div class="card-heads">
							<h4 class="card-title mb-0">Enable Google Analytics</h4>
							<div>
								<div class="status-toggle">
                                    <input  id="analytics_showhide" class="check" type="checkbox" name="analytics_showhide"<?=$analytics_showhide?'checked':'';?>>
                                    <label for="analytics_showhide" class="checktoggle">checkbox</label>
                        		</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>Google Analytics <span class="manidory">*</span></label>
							<textarea class="form-control" placeholder="Google Analytics" name="google_analytics"><?php if (isset($google_analytics)) echo $google_analytics;?></textarea>
						</div>
						<div class="form-groupbtn">
							<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save</button>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class=" col-lg-6 col-sm-12 col-12 d-flex">
				<div class="card flex-fill">
					<form class="form-horizontal"  method="POST" enctype="multipart/form-data" id="cookies" action="<?php echo base_url('admin/settings/cookies'); ?>">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card-header">
						<div class="card-heads">
							<h4 class="card-title mb-0">Cookies Agreement</h4>
							<div class="">
								<div class="status-toggle">
                                    <input  id="cookies_showhide" class="check" type="checkbox" name="cookies_showhide"<?=$cookies_showhide?'checked':'';?>>
                                    <label for="cookies_showhide" class="checktoggle">checkbox</label>
                        		</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label>Google Absense Code<span class="manidory">*</span></label>
							<textarea class="form-control summernote" placeholder="Cookies" name="cookies"><?php if (isset($cookies)) echo $cookies;?></textarea>
							<div id="editor"></div>
						</div>
						<div class="form-groupbtn">
							<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save</button>
						</div>
					</div>
					</form>
				</div>
			
			</div>
		</div>
	</div>
</div>