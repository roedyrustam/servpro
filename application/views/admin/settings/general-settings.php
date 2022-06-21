<div class="page-wrapper">
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-12">
					<h3 class="page-title">General Settings</h3>
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
				<form accept-charset="utf-8" id="general_settings" action="" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">
						<div class="card-heads">
							<h4 class="card-title">Website Basic Details</h4>
						</div>
					</div>
					<div class="card-body">
						<input type="hidden" id="user_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
						<div class="form-group">
							<label>Website Name<span class="manidory">*</span></label>
							<input type="text" class="form-control" name="website_name" id="website_name" placeholder="Enter Website Name" value="<?php echo $website_name; ?>">
						</div>
						<div class="form-group">
							<label>Contact Details <span class="manidory">*</span></label>
							<input type="text" class="form-control" name="contact_details" id="contact_details"  placeholder="Enter contact details" value="<?php echo $contact_details; ?>">
						</div>
						<div class="form-group">
							<label>Mobile Number <span class="manidory">*</span></label>
							<input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number" value="<?php echo $mobile_number; ?>">
						</div>
						<div class="form-groupbtn">
							<button name="form_submit" type="submit" class="btn btn-primary" value="true">Update</button>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class=" col-lg-6 col-sm-12 col-12">
				<form accept-charset="utf-8" id="image_settings" action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="user_csrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
					<div class="card">
						<div class="card-header">
							<div class="card-heads">
								<h4 class="card-title">Image Settings</h4>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<p class="settings-label">Website Logo <span class="manidory">*</span></p>
									<input type="file" accept="image/*" name="logo_front" id="logo_front" class="form-control">
								<h6 class="settings-size">Recommended image size is <span>280px x 36px</span></h6>
								<div class="upload-images ">
									<?php if (!empty($logo_front)) { ?><img src="<?php echo base_url() . $logo_front ?>" class="site-logo"><?php } ?>
								</div>
							</div>
							<div class="form-group">
								<p class="settings-label">Favicon <span class="manidory">*</span></p>
									<input type="file" accept="image/*" name="favicon" id="favicon"  class="form-control">
								<h6 class="settings-size">Recommended image size is <span>16px x 16px or 32px x 32px</span></h6>
								<h6 class="settings-size"> Accepted formats: only png and icon</h6>
								<div class="upload-images upload-imagesprofile">
									<?php if (!empty($favicon)) { ?><img src="<?php echo base_url() .'uploads/logo/'.$favicon ?>" class="fav-icon"><?php } ?>
								</div>
							</div>
							<div class="form-groupbtn">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true">Update</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>