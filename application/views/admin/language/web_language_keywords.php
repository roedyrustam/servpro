<div class="page-wrapper">
    <div class="content container-fluid">
        
     <div class="row align-items-center mb-3">
        <div class="col-12 col-md-8">
           <h4 class="page-title m-b-20 m-t-0">Add Language Keywords</h4>
       </div>
       
       <div class="col-12 col-md-4 text-right">
        <a href="<?php echo $base_url;?>add-web-keyword" class="btn btn-primary rounded pull-right"><i class="fas fa-plus"></i> Add Keyword</a>
    </div>
</div>
<div>
    <div class="card">
        <div class="card-body">
            <div class="panel">
                <div class="panel-body">
                    <?php if($this->session->flashdata('message')) { ?>
                        <div class="alert alert-success text-center in" id="flash_succ_message">
                            <?php echo $this->session->userdata('message'); ?>
                            
                        </div> 
                    <?php } ?>
                    <div class="table-responsive">
                        <form action="<?php echo base_url().'admin/language/update_multi_web_language/';?>" onsubmit="update_multi_lang();" method="post" id="form_id">
                            
                            
                            <table class="table" id="language_web_table">
                                <thead>
                                    <tr>
                                        <?php
                                        if (!empty($active_language))
                                        {
                                            foreach ($active_language as $row)
                                            {  
                                                ?>
                                                <th><?php echo ucfirst($row['language'])?></th>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                            <div class="m-t-30 text-center">
                                <button name="form_submit"  type="submit" class="btn btn-primary center-block" value="true">Save</button>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>
</div>
</div>



<script type="text/javascript">
    
    function update_multi_lang()
    {
        
        
        $("#form_id").submit();
    }

</script>