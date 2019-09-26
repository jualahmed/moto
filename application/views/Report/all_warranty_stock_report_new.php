
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Warranty Stock Report</h3>
				</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_warranty_stock_report_find" class="form-horizontal" method="post" id="form_2" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" name="product_name" id="lock2122" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-2">
									<?php 
									echo form_dropdown('catagory_name', $catagory_name,'','class="form-control three select9" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-2">
									<?php 
									echo form_dropdown('company_name', $company_name,'','class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<div class="col-sm-3 mt-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_data_stock" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal preload" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/img/spin.gif" id="loaderIcon"/>
		</div>
	</div>
	<input type="hidden" id="barcode">
	<input type="hidden" id="product">
	<input type="hidden" id="product22">
	<input type="hidden" id="category">
	<input type="hidden" id="company">
	<input type="hidden" id="pro_type">
	<input type="hidden" id="pro_size">
	<input type="hidden" id="pro_amount">
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="wrap">
							<table class="table">
								<tr>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">ID</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Main Product</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;width: 56px;">Warranty Serial</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Company</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Category</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Stock</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">BP</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">SP</td>
								  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">EP</td>
								</tr>
							</table>
							<div class="inner_table"><table class="table" id="search_data"></table></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>