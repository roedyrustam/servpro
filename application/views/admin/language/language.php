<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-xs-8">
                        <h4 class="page-title">Keywords</h4>
                    </div>
                    <?php $page_key = $this->uri->segment(2); ?>
                    <div class="col-xs-4 text-right m-b-30">
                        <a href="<?php echo $base_url.'add-keyword/'.$page_key; ?>" class="btn btn-primary rounded pull-right"><i class="fas fa-plus"></i> Add Keyword</a>
                    </div>
                </div>
                <div class="row">
                  <?php if($this->session->flashdata('success_message')) {  ?>
                		<div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                	<?php $this->session->unset_userdata('success_message');
                  } ?>
                  <div class="alert alert-success text-center in" id="flash_success_message" style="display:none">Updated Successfully</div>
                		<div class="alert alert-danger text-center in" id="flash_error_message" style="display:none"></div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom-table m-b-0" id="language_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>English</th>
                                        <th>Malay</th>
                                         <th>Arabic</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
