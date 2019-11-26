<div class="content-wrapper" id="vue_app">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Motorcycle Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_sale_report_find" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-2">
									<input type="text" v-model="invoice_id" class ="form-control one" id="lock" placeholder="Inovice ID" title="Inovice ID" autocomplete="off" autofocus="on">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-5">
									<select name="" class="form-control" v-model="product_id">
										<option value="0">Select a Product</option>
										<?php foreach ($product_info as $value): ?>
											<option value="<?php echo $value->product_id ?>"><?php echo $value->product_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Customer</label>
								<div class="col-sm-2">
									<select name="" id="" class="form-control" v-model="customer_id">
										<option value="0">Select a Customer</option>
										<?php foreach ($customer_name as $key => $value): ?>
											<option value="<?php echo $value->customer_id ?>"><?php echo $value->customer_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<br>
								<br>
								<br>
								<label for="inputEmail3" class="col-sm-1 control-label">Seller</label>
								<div class="col-sm-2">
									<select name="" id="" class="form-control" v-model="seller_id">
										<option value="0">Select a Seller</option>
										<?php foreach ($seller as $var): ?>
											<option value="<?php echo $var->id ?>"><?php echo $var->username ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-12 mt-2 text-right">
									<button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/download_data_sale/'+invoice_id+'/'+customer_id+'/'+product_id+'/'+seller_id+'/'+start_date+'/'+end_date" id="down" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
							<br>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
  
  <div class="text-center" v-if="loding">
    <img src="<?php echo base_url();?>assets/img/LoaderIcon.gif" id="loaderIcon"/>
  </div>

	<section class="content">
		<div class="table-responsive" v-if="alldata.length">          
			<table class="table">
				<thead>
					<tr>
						<th>NO</th>
						<th>Challan No</th>
						<th>Invoice ID</th>
						<th>Date</th>
						<th>Product Name</th>
						<th>Engine No</th>
						<th>Chassis No</th>
						<th>Color</th>
						<th>Customer Name</th>
						<th>Mobile No</th>
						<th>Total</th>
						<th>Due</th>
						<th>Seller</th>
						<th>Battery No</th>
						<th>Print</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(i,index) in alldata">
						<td>{{ index+1 }}</td>
						<td>{{ i.challan_no }}</td>
						<td>{{ i.sid }}</td>
						<td>{{ formatDate(i.date) }}</td>
						<td>{{ i.product_name }}</td>
						<td>{{ i.engineno }}</td>
						<td>{{ i.chassisno }}</td>
						<td>{{ i.color }}</td>
						<td>{{ i.customer_name }}</td>
						<td>{{ i.customer_contact_no }}</td>
						<td>{{ parseInt(i.price)+parseInt(i.installmentfee)+parseInt(i.totalinterastlog) }}</td>
						<td>{{ parseInt(i.totaldue)+parseInt(i.totalinterest) }}</td>
						<td>{{ i.username }}</td>
						<td>{{ i.batteryno }}</td>	
						<td><a :href="base_url+'sale/invoiceprint/'+i.sid" target="_blank" class="btn btn-secondary">Print</a></td>
					</tr>
					<tr>
						<td colspan="11"></td>
						<td><b>Total: {{ amount }}</b></td>
						<td><b>Total Due:{{ samount }}</b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div v-else>
			<h2 class="text-danger text-center">Result is Empty</h2>
		</div>
	</section>
</div>
