<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-20 m-t-0">Razorpay Payment Gateway</h4>
				</div>
				<div class="col-sm-4 text-right m-b-20">					
				</div>
			</div>
			
			<div class="row">
			    <?php
					if ($this->session->userdata('message')) {
						echo $this->session->userdata('message');
					}
				?>
				<div class="col-lg-12">
					<div class="card-box">					
						<div class="table-responsive">
							<table class="table table-actions-bar datatable m-b-0">
								<thead>
									<tr>
										<th>#</th>
										<th>Gateway Name</th>
										<th>Gateway Type</th>
										<th>Publishable Key</th>
										<th>Publishable Secret</th>
										<th>Status</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($list)) {
									$i = 1;
									foreach ($list as $item) {
										$status = 'Active';
										if ($item['status'] == 0) {
											$status = 'In-active';
										}
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $item['gateway_name']; ?></td>
										<td><?php echo $item['gateway_type']; ?></td>
										<td><?php echo $item['api_key']; ?></td>
										<td><?php echo $item['api_secret']; ?></td>
										<td><?php echo $status; ?></td>
										<td class="text-right">
											<a href="<?php echo base_url() . "admin/razorpayment_gateway/edit/" . $item['id']; ?>" class="table-action-btn ml-2" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>
										</td>
									</tr>
									<?php
									}
									} else { ?>
									<tr>
										<td colspan="4">
											<p class="text-danger text-center m-b-0">No Records Found</p>
										</td>
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