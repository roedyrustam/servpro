<div class="page-wrapper">
    <div class="content container-fluid">          
        <div class="row">
            <div class="panel-body">
                <?php if($this->session->flashdata('message')) { ?>
                    <div class="alert alert-success text-center in" id="flash_succ_message">
                        <?php echo $this->session->userdata('message'); ?>
                    </div>  
                <?php } ?>  
                <?php if($this->session->flashdata('success_message')) { ?>
                    <div class="alert alert-success text-center in" id="flash_succ_message">
                        <?php echo $this->session->userdata('success_message'); ?>
                    </div>  
                <?php } ?>
                <?php if($this->session->flashdata('error_message')) { ?>
                    <div class="alert alert-danger text-center in" id="flash_succ_message">
                        <?php echo $this->session->userdata('error_message'); ?>
                    </div>  
                <?php } ?>


                <div class="col-12 col-md-offset-2">
                  <h4 class="page-title m-b-20 m-t-0 text-center">Language Management</h4>
              </div>
          </div>
      </div>

      <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="card-box">

                <form class="form-horizontal" id="" onsubmit="return language_validation();" action="" method="POST">

                    <div class="tab-pane active">

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Language</label>

                            <div class="col-sm-9">

                                <input  type="text" id="language" name="language" value="" class="form-control only_alphabets" >

                                <small class="error_msg help-block language_error" style="display: none;">Please enter a language</small>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="col-sm-3 control-label">Value</label>

                            <div class="col-sm-9">

                                <input type="text" id="value" name="value" value="" class="form-control only_alphabets" >

                                <small class="error_msg help-block value_error" style="display: none;">Please enter a value</small>

                            </div>

                        </div>
                        <div class="form-group">

                            <label class="col-sm-3 control-label">RTL or LTR (optional)</label>

                            <div class="col-sm-9">

                                <select name="tag" id="tag" class="form-control">
                                    <option value="">--Select a Tag--</option> 
                                    <option value="rtl">RTL</option> 
                                    <option value="ltr">LTR</option> x
                                </select>


                            </div>

                        </div>

                    </div>

                    <div class="m-t-30">

                        <button name="form_submit"  type="submit" class="btn btn-primary center-block" value="true">Save</button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <h4 class="page-title m-b-20 m-t-0">All Languages</h4>

    <div id="flash_lang_message"></div>

    <div class="card">
        <div class="card-body">
            <div class="panel mb-0">



                <div class="panel-body">



                    <div class="table-responsive">



                        <table class="table table-actions-bar table-striped releasetable m-b-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Language</th>

                                    <th>Language Value</th>

                                 

                                    <th>Status</th>
                                    <th>Default Language</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody >

                                <?php 



                                if (!empty($list))

                                {

                                    foreach ($list as $row)

                                    {      

                                        $new = '';      

                                        $status = 'Active';

                                        if($row['status']==2){

                                            $status = 'Inactive';



                                        }else{



                                        }  

                                        ?>

                                        <tr>

                                            <td> <?php echo $row['id']?></td>

                                            <td> <?php echo  $row['language'] ?></td>

                                            <td> <?php echo  $row['language_value'] ?></td>

                                         

                                            <td >

                                                <?php $status = ''; 
                                                if ($row['status'] == 1) 
                                                {  
                                                    $status = 'success'; 
                                                    $stst='Active'; 
                                                    $style='style="display:block;"';
                                                }
                                                else 
                                                {
                                                    $status = 'danger';
                                                    $stst='In Active';
                                                    $style='style="display:none;"';
                                                } 





                                                if($this->session->userdata('id') != 1)



                                                {


       



                                                }if($row['language_value']=='en'){
                                                   echo '  ';

                                               }else{?>

                                                 <span id="lang_status<?php echo $row['id'];?>" data-status="<?php echo $row['status'];?>" style="cursor: pointer;" onclick="change_status(<?php echo $row['id'];?>)" class="label label-<?php echo $status;?>"><span id="texts<?php echo $row['id'];?>"><?php echo $stst;?></span></span>



                                             <?php  }?>

                                         </td>
                                         <td><input type="radio" <?php echo $style;?> class="default_lang" value="1" <?php if($row['default_language']=='1') echo 'checked';?> name="default_language" data-id="<?php echo $row['id']; ?>" id="default_language<?php echo $row['id']; ?>"></td>
                                         <td><a href="<?php echo $base_url.'delete-addlang/'.$row['id']; ?>" class="delete-addlang" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash-alt text-danger"></i></a></td>

                                     </tr>

                                     <?php

                                 }



                             }else {

                                ?>

                                <tr>

                                    <td colspan="6"><p class="text-danger text-center m-b-0">No Records Found</p></td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>

</div>
</div>
</div>






<script type="text/javascript">



    function language_validation(){



        var error =0;

        var language = $('#language').val().trim();

        

        

        if(language==""){

            $('.language_error').show();

            error =1; 

        }else{

            $('.language_error').hide();

            

        }



        var value = $('#value').val().trim();

        

        

        if(value==""){

            $('.value_error').show();

            error =1; 

        }else{

            $('.value_error').hide();

            

        }



        if(error==0){

          return true;

      }else{

          return false;

      }



  }



  

  function delete_language(val)

  {

   bootbox.confirm("Are you sure want to Delete ? ", function(result) {

                

                if(result ==true)                {

                    var url        = BASE_URL+'admin/language_management_controller/delete_language';

                    var id = val;                               

                    $.ajax({

                      url:url,

                      data:{id:id}, 

                      type:"POST",

                      success:function(res){ 

                        if(res==1)

                        {

                         window.location = BASE_URL+'admin/language_management_controller/language';

                     }

                 }

             });  

                }

            }); 

}     





</script>

