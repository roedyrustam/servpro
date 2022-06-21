<div class="page-wrapper">
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-12">
							<h3 class="page-title">System Settings</h3>
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
						<form accept-charset="utf-8" id="map_settings" action="" method="POST" enctype="multipart/form-data">
							<div class="card">
								<div class="card-header">
									<div class="card-heads">
										<h4 class="card-title">Google Map API Key</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label>Google Map API Key</label>
										<input type="text" name="map_key" id="map_key" class="form-control" value="<?php if (isset($map_key)) echo $map_key;?>">
									</div>
									<div class="form-group">
										<div class="form-links">
											<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">How to create google map API key?</a>
										</div>
									</div>
									<div class="form-groupbtn">
										<button name="form_submit" type="submit" class="btn btn-primary me-2" value="true">Update</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class=" col-lg-6 col-sm-12 col-12">
						<form accept-charset="utf-8" id="apikey_settings" action="" method="POST" enctype="multipart/form-data">
							<div class="card">
								<div class="card-header">
									<div class="card-heads">
										<h4 class="card-title">Push Notification</h4>
									</div>
								</div>
								<div class="card-body">
								<div class="form-group">
									<div id="push_notification" class="tab-pane">
                                	<div class="form-group">
                                   		<label class="control-label">Firebase Server Key</label>              
                                        <input type="text" class="form-control" id="firebase_server_key" name="firebase_server_key"   value="<?php if (isset($firebase_server_key)) echo $firebase_server_key;?>">                          
                                	</div>
                            		</div>
								</div>
									<div class="form-group">
										<div class="form-links">
											<a href="https://firebase.google.com/docs/android/setup" target="_blank">How to create firebase setup?</a>
										</div>
									</div>
									<div class="form-groupbtn">
										<button name="form_submit" type="submit" class="btn btn-primary me-2" value="true">Update</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>