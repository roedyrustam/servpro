<div class="page-wrapper">
	<div class="content container-fluid">

		<div class="row">

			<div class="col-sm-8">
				<?php  if($this->session->flashdata('message')){ ?>
					<p class="bg-success"><?php echo $this->session->flashdata('message'); ?></p>
				<?php } ?>
				<h4 class="page-title m-b-20 m-t-0">Manage Currency</h4>

			</div>
			<div class="col-sm-4 text-right m-b-20">
				<a href="<?php echo base_url().'admin/currency/add_currency'; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Currency</a>
			</div>
		</div>

		<div class="row">

			<div class="col-lg-12">

				<div class="card-box">

					<div class="table-responsive">

						<table class="datatable table table-actions-bar table-striped releasetable m-b-0"> 

							<thead>

								<tr>

									<th>#</th>     
									<th>Country</th>
									<th>Currency Code</th> 			 
									<th>Status</th> 	      
									<th>Created Date</th>

									<th class="text-right">Action</th>

								</tr>

							</thead>

							<tbody>

								<?php 

								if(!empty($list)) 

								{

									$i=1;

									


									

									foreach($list as $item) { 


										$status = 'Active'; 
										if($item['status']==0){ 
											$status = 'Inactive';
											$val = '';
										} else {
											$val = 'checked';
										}   

										

										?>

										<tr>

											<td><?php echo $i; ?></td>               
											<td><?php echo $item['currency_name']; ?></td>

											<td><?php echo $item['currency_code']; ?></td>


											<td><label class="switch toggle-small"><input type="checkbox" <?php echo $val; ?> id="status_<?php echo $item['id']; ?>" data-on="Active" data-off="Inactive" onchange="change_Status(<?php echo $item['id']; ?>)"><span class="slider round" data-size="mini"></span></label></td>

											<td><?php if(!empty($item['created_date']))
											{

												echo date('d M Y', strtotime(str_replace('-','/', $item['created_date'])));}else{
													echo "";
												} ?></td>

												<td class="text-right">
													<a href="javascript:void(0)" onclick="admin_make_as_default_currency(<?php echo $item['id']; ?>)" class="table-action-btn" title="Make as Default Currency"><i class="fab fa-spotify text-info"></i></a>
													<a href="<?php echo base_url()."admin/currency/edit_currency/".$item['id']; ?>" class="table-action-btn ml-2" title="Edit"><i class="fas fa-edit text-success"></i></a>
													<a href="javascript:void(0)" onclick="admin_delete_currency(<?php echo $item['id']; ?>)" class="table-action-btn ml-2" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a> 

												</td>

											</tr>

											<?php $i = $i+1; } } else { ?>

												<tr>

													<td colspan="10"><p class="text-danger text-center m-b-0">No Records Found</p></td>

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

 

		<script type="text/javascript">
			var BASE_URL = "<?php echo base_url(); ?>";
			function admin_delete_currency(id) {
				if(confirm("Are you sure you want to delete this Currency?")){
					$.post(BASE_URL+'admin/currency/admin_delete_currency',{id:id},function(result){
						if(result){
							location.reload();
						}
					});

				}	
			}
			function admin_make_as_default_currency(id) {
				if(confirm("Are you sure you want to make this as Default Currency?")){
					$.post(BASE_URL+'admin/currency/admin_default_currency',{id:id},function(result){
						if(result){
							location.reload();
						}
					});

				}	
			}

	function change_Status(id) {
        var stat= $('#status_'+id).prop('checked');

        if(stat==true) {
           var status=1;
        } else {
           var status=0;
        }
        $.post('<?php echo base_url();?>admin/currency/change_Status',{id:id,status:status},function(data){

        });

    }
		</script>