<div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h4 class="page-title">Add Keyword</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <form action="" id="addKeyword" method="post">
                        <?php $page_key = $this->uri->segment(2); ?>
                            <div class="form-group">
                                <label>Multiple Keyword</label>
                                <textarea class="form-control" placeholder="(ex):Hello world,Have a nice day" name="multiple_key" id="multiple_key"></textarea>
                                <input class="form-control" type="hidden" value="<?php echo $page_key; ?>" name="page_key" id="page_key">
                            </div>
                            <div class="m-t-20">
                                <button class="btn btn-primary" type="submit">Add</button>
                                 <a href="<?php echo $base_url.'language/'.$page_key; ?>" class="btn btn-link">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
