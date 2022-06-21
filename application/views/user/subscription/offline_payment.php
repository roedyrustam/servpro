<?php
$forgot = $language_content['language'];
$query = $this->db->query("SELECT * FROM offline_payment");
$bank_details = $query->row_array();
?>
<!-- Breadcrub -->
<div class="breadcrub">
	<div class="container">
		<ul>
			<li><a href="<?php echo $base_url; ?>home"><?php echo $forgot['lg_home']; ?></a></li>
			<li><?php echo $forgot['lg_offline_payment']; ?></li>
		</ul>
	</div>
</div>
<!-- /Breadcrub -->
<div class="content mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="">
					<div class="row">
						<h4><?php echo $forgot['lg_order_summary']; ?></h4>
						<br>
						<hr>
						<br>
						<div class="col-lg-12 col-sm-12 col-12">
							<!-- <div class="form-group">
								<label>Payable amount</label>
								<input type="text" class="form-control" name="meta_title" id="meta_title" value="">
							</div> -->
							<table class="table">
							    <thead class="table-dark">
							      <tr>
							        <th>Name</th>
							        <th>Details</th>
							      </tr>
							    </thead>
							    <tbody>
							      <tr>
							        <td>Bank Name</td>
							        <td><?php if (isset($bank_details['bank_name'])) echo $bank_details['bank_name']; ?></td>
							      </tr>
							      <tr>
							        <td>Holder Name</td>
							        <td><?php if (isset($bank_details['holder_name'])) echo $bank_details['holder_name']; ?></td>
							      </tr>
							      <tr>
							        <td>Account Number</td>
							        <td><?php if (isset($bank_details['account_num'])) echo $bank_details['account_num']; ?></td>
							      </tr>
							      <tr>
							        <td>IFSC Code</td>
							        <td><?php if (isset($bank_details['ifsc_code'])) echo $bank_details['ifsc_code']; ?></td>
							      </tr>
							      <tr>
							        <td>Branch Name</td>
							        <td><?php if (isset($bank_details['branch_name'])) echo $bank_details['branch_name']; ?></td>
							      </tr>
							      <tr>
							        <td>UPI Id</td>
							        <td><?php if (isset($bank_details['upi_id'])) echo $bank_details['upi_id']; ?></td>
							      </tr>
							    </tbody>
							 </table>
							<form id="offline_save" method="post" autocomplete="off" enctype="multipart/form-data" >
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="bank_name"  id="" value="<?php if (isset($bank_details['bank_name'])) echo $bank_details['bank_name']; ?>">
							</div>
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="holder_name"  id="" value="<?php if (isset($bank_details['holder_name'])) echo $bank_details['holder_name']; ?>">
							</div>
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="account_num"  id="" value="<?php if (isset($bank_details['account_num'])) echo $bank_details['account_num']; ?>">
							</div>
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="ifsc_code"  id="" value="<?php if (isset($bank_details['ifsc_code'])) echo $bank_details['ifsc_code']; ?>">
							</div>
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="branch_name"  id="" value="<?php if (isset($bank_details['branch_name'])) echo $bank_details['branch_name']; ?>">
							</div>
							<div class="form-group">
								<input type="hidden" data-role="tagsinput" class="input-tags form-control"  name="upi_id"  id="" value="<?php if (isset($bank_details['upi_id'])) echo $bank_details['upi_id']; ?>">
							</div>
							<div class="form-group">
								<label><?php echo $forgot['lg_document_of_your_payment_(jpg,_pdf,_txt,_png,_docx)']; ?><span class="manidory">*</span></label>
								<input type="file" data-role="tagsinput" class="input-tags form-control"  name="offline_doc"  id="offline_doc" value="" required>
							</div>
							<div class="form-groupbtn">
								<button name="form_submit" type="submit" class="btn btn-primary me-2" value="true">Submit Payment Document</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
