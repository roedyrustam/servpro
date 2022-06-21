<?php 
$bo1query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image1'");
$bo1result = $bo1query->result_array();

$bo2query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image2'");
$bo2result = $bo2query->result_array();

$bo3query = $this->db->query("select * from bgimage WHERE bgimg_for = 'bottom_image3'");
$bo3result = $bo3query->result_array();

$download_showhide = $this->db->get_where('system_settings',array('key' => 'download_showhide'))->row()->value;
$how_showhide = $this->db->get_where('system_settings',array('key' => 'how_showhide'))->row()->value;
?>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-lg-8 m-auto">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-12">
							<h3 class="page-title">Home Page</h3>
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
					<div class=" col-lg-12 col-sm-12 col-12">
						<form class="form-horizontal" id="banner_settings" action="<?php echo base_url('admin/settings/bannersettings'); ?>"  method="POST" enctype="multipart/form-data" >
							 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="card">
							<?php
									if (!empty($list)) {
									foreach ($list as $item) {
									?>
							<div class="card-header">
								<div class="card-heads">
									<h4 class="card-title mb-0">Banner Settings</h4>
									<div class="col-auto">
										<div class="status-toggle">
											 <input  id="banner_showhide" class="check" type="checkbox" name="banner_showhide"<?=($item['banner_settings']==1)?'checked':'';?>>
		                                    <label for="banner_showhide" class="checktoggle">checkbox</label>
                                		</div>
									</div>
								</div>
							</div>
							<div class="card-body">
							
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="banner_content" class="form-control" value="<?php echo ucwords($item['banner_content']); ?>">
								</div>
								<div class="form-group">
									<label>Content</label>
									<input type="text" name="banner_sub_content" class="form-control" value="<?php echo ucwords($item['banner_sub_content']); ?>">
								</div>
								<div class="form-group">
									<p class="settings-label">Banner image</p>
									<div class="form-group">
										  <input class="form-control" type="file"  name="upload_image" id="upload_image">
									</div>
									<?php if(!empty($item['upload_image'])) { ?>
										<div class="upload-images d-block">
											<img class="thumbnail home_banner_img" src="<?php echo base_url() . $item['upload_image']; ?>">
										</div>
									<?php } else { ?>
											<div class="upload-images d-block">
											<img class="thumbnail home_banner_img" src="<?php echo base_url() . 'assets/img/banner.jpg'; ?>">
										</div>
									<?php } ?>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-5 col-12">
											<div class="card-heads mb-3">
											<h4 class="card-title f-14">Main Search </h4>
											<div class="status-toggle mr-3">
			                                    <input  id="main_showhide" class="check" type="checkbox" name="main_showhide"<?=($item['main_search']==1)?'checked':'';?>>
			                                    <label for="main_showhide" class="checktoggle">checkbox</label>
                                			</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-groupbtn">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Update</button>
									<a href="<?php echo base_url(); ?>admin/page"  class="btn btn-cancel">Back</a>
								</div>
							<?php }
						}
							 ?>
							</div>
						</div>
					</form>
						<form class="form-horizontal" id="how_it_works" action="<?php echo base_url('admin/settings/howitworks'); ?>"  method="POST" enctype="multipart/form-data" >
							 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="card">
							<div class="card-header">
								<div class="card-heads">
									<h4 class="card-title mb-0">About Us</h4>
									<div>
										<div class="status-toggle">
		                                    <input  id="how_showhide" class="check" type="checkbox" name="how_showhide"<?=($how_showhide==1)?'checked':'';?>>
		                                    <label for="how_showhide" class="checktoggle">checkbox</label>
                                		</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="how_title"  value="<?php if (isset($how_title)) echo $how_title;?>">
								</div>
								<div class="form-group">
									<label>Content</label>
									<input type="text" class="form-control" name="how_content"  value="<?php if (isset($how_content)) echo $how_content;?>">
								</div>	
								<div class="form-group">
									<label>Button Name</label>
									<input type="text" class="form-control" name="signup_name"  value="<?php if (isset($signup_name)) echo $signup_name;?>">
								</div>	
								<div class="form-group">
									<label>Button Link</label>
									<?php if(!empty($signup_link)) { ?>
									<input type="text" class="form-control" placeholder="Link with http:// Or https://" name="signup_link" value="<?php if (isset($signup_link)) echo $signup_link;?>">
									<?php } else {?>
										<input type="text" class="form-control" placeholder="Link with http:// Or https://" name="signup_link" value="<?php echo base_url();?>signup">
									<?php } ?>
								</div>				
								<div class="form-group">
									<p class="settings-label">About-Us Image</p>
									 <input class="form-control" type="file"  name="how_title_img" id="upload_image">
									<?php if(!empty($how_title_img)) { ?>
											<div class="upload-images ">
												<img class="thumbnail home_banner_img" src="<?php echo base_url() . $how_title_img; ?>">
											</div>
											<?php } else { ?>
													<img class="thumbnail home_banner_img" src="<?php echo base_url() . 'assets/img/about-img.png'; ?>">
									<?php } ?>
								</div>
								<div class="form-groupbtn">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Update</button>
									<a href="<?php echo base_url(); ?>admin/page"  class="btn btn-cancel">Back</a>
								</div>
							</div>
						</div>
					</form>
					<form class="form-horizontal" id="download_sec" action="<?php echo base_url('admin/settings/download_sec'); ?>" method="POST" enctype="multipart/form-data" >
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
						<div class="card">
							<div class="card-header">
								<div class="card-heads">
									<h4 class="card-title mb-0">Download Section</h4>
									<div>
										<div class="status-toggle">
		                                    <input  id="download_showhide" class="check" type="checkbox" name="download_showhide"<?=($download_showhide==1)?'checked':'';?>>
		                                    <label for="download_showhide" class="checktoggle">checkbox</label>
                                		</div>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="download_title"  value="<?php if (isset($download_title)) echo $download_title;?>">
								</div>
								<div class="form-group">
									<label>Content</label>
									<input type="text" class="form-control" name="download_content"  value="<?php if (isset($download_content)) echo $download_content;?>">
								</div>
								<div class="row">
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<p class="settings-label">Google Play Store</p>
												<input class="form-control" type="file"  name="app_store_img" id="upload_image">
											<?php if(!empty($app_store_img)) { ?>
											<div class="upload-images ">
												<img class="thumbnail home_banner_img" src="<?php echo base_url() . $app_store_img; ?>">
											</div>
											<?php } else { ?>
													<img class="thumbnail home_banner_img" src="<?php echo base_url() . 'assets/img/gp-01.jpg'; ?>">
									<?php } ?>
									
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>App Link</label>
											<input type="text" class="form-control" name="app_store_link"  value="<?php if (isset($app_store_link)) echo $app_store_link;?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<p class="settings-label">App Store (iOs)</p>
												<input class="form-control" type="file"  name="play_store_img" id="upload_image">
											<?php if(!empty($play_store_img)) { ?>
											<div class="upload-images ">
												<img class="thumbnail home_banner_img" src="<?php echo base_url() . $play_store_img; ?>">
											</div>
											<?php } else { ?>
													<img class="thumbnail home_banner_img" src="<?php echo base_url() . 'assets/img/gp-02.jpg'; ?>">
									<?php } ?>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>App Link</label>
											<input type="text" class="form-control" name="play_store_link"  value="<?php if (isset($play_store_link)) echo $play_store_link;?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Download Right Image</label>
									<input class="form-control" type="file"  name="download_right_img" id="upload_image">
									<?php if(!empty($download_right_img)) { ?>
											<div class="upload-images ">
												<img class="thumbnail home_banner_img" src="<?php echo base_url() . $download_right_img; ?>">
												
											</div>
											<?php } else { ?>
													<img class="thumbnail home_banner_img" src="<?php echo base_url() . 'assets/img/gp-02.jpg'; ?>">
									<?php } ?>
								</div>
								<div class="form-groupbtn">
									<button name="form_submit" type="submit" class="btn btn-primary" value="true">Update</button>
									<a href="<?php echo base_url(); ?>admin/page"  class="btn btn-cancel">Back</a>
								</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>