<div class="page-wrapper">
	<div class="content container-fluid">

		<div class="row">

			

			<div class="col-sm-12">

				<h4 class="page-title m-b-20 m-t-0">Add Keywords </h4>

			</div>

		</div>

		<div class="panel-body">
			<?php if($this->session->flashdata('message')) { ?>
				<div class="alert alert-success text-center in" id="flash_succ_message">
					<?php echo $this->session->userdata('message'); ?>
				<?php } ?>
			</div> 

			<div class="row">

				<div class="col-lg-12">

					<div class="card-box">

						

						<div>
							
							<div class="tab-content">
								<div id="single_data" class="tab-pane active">
									<div class="m-t-30">
										<p class="text-center text-danger"><b><em>Note: *   Please enter words only in English ..........</em></b></p>
									</div>
									<form class="form-horizontal" autocomplete="off" id="" onsubmit="return keyword_validation();" action="" method="POST">

										
										<div class="form-group">
											<label class="control-label">Field Name :</label>
											<div class="">
												<input name="field_name" id="field_name" class="form-control" type="text" style=" text-transform: lowercase;">
												<small class="error_msg help-block field_name_error" style="display: none;">Please enter a field</small>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label">Name :</label>
											<div class="">
												<input name="name" id="name" class="form-control" type="text">
												<small class="error_msg help-block name_error" style="display: none;">Please enter a name</small>
											</div>
										</div>
										
										<div class="m-t-30">
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

			function keyword_validation(){

				var error =0;
				var field_name = $('#field_name').val().trim();
				var name = $('#name').val().trim();


				if(field_name==""){
					$('.field_name_error').show();
					error =1; 
				}else{
					$('.field_name_error').hide();

				}

				if(name==""){
					$('.name_error').show();
					error =1; 
				}else{
					$('.name_error').hide();

				}

				if(error==0){
					return true;
				}else{
					return false;
				}
			}

			function multiple_keyword_validation(){

				var error =0;
				var keyword = $('#multiple').val().trim();


				if(keyword==""){
					$('.multi_keyword_error').show();
					error =1; 
				}else{
					$('.multi_keyword_error').hide();

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
                	var url        = BASE_URL+'admin/language_management_controller/delete_keyword';
                	var id = val;                               
                	$.ajax({
                		url:url,
                		data:{id:id}, 
                		type:"POST",
                		success:function(res){ 
                			if(res==1)
                			{
                				window.location = BASE_URL+'admin/language_management_controller/add_keyword';
                			}
                		}
                	});  
                }
            }); 
			}
		</script>