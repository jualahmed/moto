<div class="content-wrapper" id="vue_app">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Installment Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/installment_report_response" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
							<div class="form-group">

								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<input type="text" name="start_date" class="form-control" id="datepickerrr" placeholder="<?php echo $bd_date ?>">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<input type="text" name="end_date" class="form-control" id="datepicker" placeholder="<?php echo $bd_date ?>">
								</div>
								<div class="col-sm-6 mt-2">
									<button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a :href="base_url+'Report/installment_report_print/'+startdate+'/'+enddate" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
							<br>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
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
						<th>Customer Name</th>
						<th>Mobile No</th>
						<th>Total</th>
						<th>Due</th>
						<th>Payment Date</th>
						<th>Payment Amount</th>
						<th>Engine No</th>
						<th>Chassis No</th>
						<th>Color</th>
						<th>Seller</th>
            <th>Battery No</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(i,index) in alldata">
						<td>{{ index+1 }}</td>
						<td>{{ i.challan_no }}</td>
						<td>{{ i.sid }}</td>
						<td>{{ formatDate(i.created_at) }}</td>
						<td>{{ i.product_name }}</td>
						<td>{{ i.customer_name }}</td>
						<td>{{ i.customer_contact_no }}</td>
						<td>{{ parseInt(i.price)+parseInt(i.installmentfee)+parseInt(i.totalinterastlog) }}</td>
						<td>{{ i.totaldue }}</td>
						<td>{{ formatDate(i.date) }}</td>
						<td>{{ i.amount }}</td>
						<td>{{ i.engineno }}</td>
						<td>{{ i.chassisno }}</td>
						<td>{{ i.color }}</td>
						<td>{{ i.username }}</td>
            <td>{{ i.batteryno }}</td>  
						<td><a :href="base_url+'report/deleteinstallment/'+i.all_installment_id" onclick="return confirm('Are Sure want to delete?')" class="btn btn-sm btn-danger">Delete</a></td>	
						<!-- <th>{{ i.price+i.totalinterest+i.installmentfee }}</th> -->
						<!-- <th>{{ i.totaldue+i.screchcard+i.discount }}</th> -->
					</tr>
				</tbody>
			</table>
		</div>
		<div v-else>
			<h2 class="text-danger text-center">Result is Empty</h2>
		</div>
	</section>
</div>
