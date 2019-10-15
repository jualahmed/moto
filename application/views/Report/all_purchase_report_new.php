<div class="content-wrapper" id="vuejsapp">
	<section class="content">
			<div class="row">
				<div class="col-md-12">
				  <div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Purchase Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_purchase_report_find" method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" id="form_3">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Challan No</label>
								<div class="col-sm-2">
									<select name="catagory_id" class="form-control" v-model="receipt">
										<option value="0">Select a Challan No</option>
										<?php foreach ($purchase_receipt as $key => $value): ?>
											<option value="<?php echo $value->receipt_id ?>"><?php echo $value->distributor_name ?>( <?php echo $value->challan_no ?> )</option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-2">
									<input type="text" class="form-control" v-model="product" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-2">
									<select name="catagory_id" class="form-control" v-model="category">
										<option value="0">Select a Category</option>
										<?php foreach ($catagory as $key => $value): ?>
											<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-2">
									<select name="company_id" id="" class="form-control" v-model="company">
										<option value="0">Select a Company</option>
										<?php foreach ($company as $key => $var): ?>
											<option value="<?php echo $var->company_id ?>"><?php echo $var->company_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Distributor</label>
								<div class="col-sm-2">
									<select name="company_id" id="" class="form-control" v-model="distributor_id">
										<option value="0">Select a Distributor</option>
										<?php foreach ($distributor_info as $key => $var): ?>
											<option value="<?php echo $var->distributor_id ?>"><?php echo $var->distributor_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
									<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control", 'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-12 mt-2 text-right">
									<button type="submit" @click.prevent="purchase_report" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/download_data_purchase/'+receipt+'/'+product+'/'+category+'/'+company+'/'+distributor_id+'/'+start_date+'/'+end_date" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
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
	<section class="content-3" id="infomsg">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive" v-if="alldata.length>0">
					<table class="table table-primary">
						<tr>
						  <td>No</td>
						  <td>Challan No</td>
						  <td>Date</td>
						  <td>Product</td>
						  <td>Company</td>
						  <td>Category</td>
						  <td>engineno</td>
						  <td>chassisno</td>
						  <td>color</td>
						  <td title="Purchase Quantity">Quantity</td>
						  <td>BP</td>
						  <td>batteryno</td>
						  <td>Edit</td>
						</tr>
						<tr v-for="(a,index) in alldata">
						  <td>{{index+1}}</td>
						  <td>{{ a.challan_no }} </td>
						  <td>{{formatDate(a.receipt_date)}}</td>
						  <td>{{ a.product_name }}</td>
						  <td>{{ a.company_name }}</td>
						  <td>{{ a.catagory_name }}</td>
						  <td>{{ a.engineno }} </td>
						  <td>{{ a.chassisno }} </td>
						  <td>{{ a.color }} </td>
						  <td title="Purchase Quantity">1</td>
						  <td>{{ a.purchase_price }}</td>
						  <td>{{ a.batteryno }} </td>
						  <td><a href="" data-toggle="modal" @click="editthisproduct(a.ip_id)" data-target="#EditModel" class="sdfsdfsdf btn btn-sm btn-success" >Edit</a></td>
						</tr>
						<tr>
							<td colspan="10"><b></b></td>
							<td colspan="1"><b>Total Quantity: {{ stockqty }}</b> </td>
							<td colspan="1"><b>Total Stock Amount: {{ samount }}</b></td>
						</tr>
					</table>
				</div>
				<h2 v-else class="text-danger text-center">Result Empty</h2>
			</div>
		</div>	
	</section> 
</div>



<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="customerupdate" action="<?php echo base_url();?>product/w_p_update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit customer</h3>
	        	</div>
	        	<div class="col-md-6">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-body">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6 left">
						<input type="hidden" name="ip_id" id="ip_id">
						<div class="form-group">
							<label class="form-control-label">Engning no <span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="engineno" id="engineno">
						</div>	
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Chassis no <span class="text-danger">*</span></label>
							<input type="text" name="chassisno" id="chassisno" class="form-control">
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">Color</label>
							<input type="text" name="color" id="color" class="form-control">
						</div>
						<div class="form-group">
							<label class="form-control-label">Battry NO <span class="text-danger">*</span></label>
							<input type="text" name="batteryno" id="batteryno" class="form-control">
						</div>
					</div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
			<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>
