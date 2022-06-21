<div class="page-wrapper">
            <div class="content container-fluid">
                <?php if($this->session->flashdata('error_message')) {  ?>
                      <div class="alert alert-danger text-center in" id="flash_error_message"><?php echo $this->session->flashdata('error_message');?></div>
                    <?php $this->session->unset_userdata('error_message');
                 } ?>
                  <?php if($this->session->flashdata('success_message')) {  ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message"><?php echo $this->session->flashdata('success_message');?></div>
                    <?php $this->session->unset_userdata('success_message');
                  } ?>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Colour Settings</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form action="<?php base_url(). "dashboard/colours"; ?>" id="addColours" method="post">
                            <div class="form-group">
                                <label>Morning</label>
                                <input class="form-control" type="color" name="morning" id="morning" value="<?php if(!empty($list['morning'])) { echo $list['morning']; } ?>">
                            </div>
                            <div class="form-group">
                                <label>Afternoon</label>
                                <input class="form-control" type="color" name="afternoon" id="afternoon" value="<?php if(!empty($list['afternoon'])) { echo $list['afternoon']; } ?>">
                            </div>
                            <div class="form-group">
                                <label>Evening</label>
                                <input class="form-control" type="color" name="evening" id="evening" value="<?php if(!empty($list['evening'])) { echo $list['evening']; } ?>">
                            </div>
                            <div class="form-group">
                                <label>Night</label>
                                <input class="form-control" type="color" name="night" id="night" value="<?php if(!empty($list['night'])) { echo $list['night']; } ?>">
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                 <a href="<?php echo $base_url; ?>dashboard" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
