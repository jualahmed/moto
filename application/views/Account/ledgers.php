<div class="content-wrapper" id="vueapp">
	<br>
	<section>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action" >
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url();?>account/all_ledger_report_find">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
								<div class="col-sm-2">
									<select class="form-control select2 ledger input-sm" v-model="purpose_id" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true" required>
										<option value="0">Select Purpose</option>
										<option value="1">Customer Sale</option>
										<option value="2">Purchase</option>
									<!-- 	<option value="3">Expense</option>
										<option value="4">Bank Transfer</option>
										<option value="5">Owner Transfer</option> -->
									</select>
								</div>
								<div v-if="purpose_id==1">
									<label for="inputEmail3" class="col-sm-1 control-label" id="cust_label">Ledger</label>
										<div class="col-sm-2" id="cust_list">
										<select name="customer_id" v-model="customer_id" id="" class="form-control">
											<option value="0">Select a Customer</option>
											<?php foreach ($customer_info as $var): ?>
												<option value="<?php echo $var->customer_id ?>"><?php echo $var->customer_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div v-if="purpose_id==2">
									<label for="inputEmail3" class="col-sm-1 control-label" id="dist_label">Ledger</label>
									<div class="col-sm-2" id="dist_list">
										<select class="form-control select2 ledger input-sm" v-model="distributor_id" id="distributor_id" name="distributor_id" tabindex="-1" aria-hidden="true" required="on">
											<option value="0">Select a distributor</option>
											<?php foreach ($distributor_info as $key => $var): ?>
												<option value="<?php echo $var->distributor_id ?>"><?php echo $var->distributor_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div v-if="purpose_id==3">
									<label for="inputEmail3" class="col-sm-1 control-label" id="exp_type_label">Type</label>
									<div class="col-sm-2" id="exp_type_list">
										<?php 
											echo form_dropdown('type_id', $expense_type,'','style="width:100%;" class="form-control select2 ledger input-sm" id="type_id" tabindex="-1" aria-hidden="true"');
										?>
									</div>
								</div>
								<div v-if="purpose_id==3">
									<label for="inputEmail3" class="col-sm-1 control-label" id="emp_label">Employee</label>
									<div class="col-sm-2" id="emp_list">
										<?php 
											echo form_dropdown('employee_id', $employee_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="employee_id" tabindex="-1" aria-hidden="true"');
										?>
									</div>
								</div>
								<div v-if="purpose_id==3">
									<label for="inputEmail3" class="col-sm-1 control-label" id="type_label">Type</label>
									<div class="col-sm-2" id="type_list">
										<select style="width:100%;" class="form-control select2 input-sm" id="transfer_type" tabindex="-1" aria-hidden="true">
											<option value="">Select Type</option>
											<option value="to_bank">To Bank</option>
											<option value="from_bank">From Bank</option>
										</select>
									</div>
								</div>
								<div v-if="purpose_id==3">
									<label for="inputEmail3" class="col-sm-1 control-label" id="own_type_label">Type</label>
									<div class="col-sm-2" id="own_type_list">
										<select style="width:100%;" class="form-control select2 input-sm" id="owner_transfer_type" tabindex="-1" aria-hidden="true">
											<option value="">Select Type</option>
											<option value="to_owner">To Owner</option>
											<option value="from_owner">From Owner</option>
										</select>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('start_date', '','class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
									?>
								</div>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('end_date', '','class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
									?>
								</div>
								
							</div>
							<div class="form-group text-right">
								<div class="col-sm-12">
									<button type="submit" v-on:click.stop.prevent="onSubmit" class="btn btn-success btn-sm" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/ledger_report_print" id="down" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="content infomsg" id="infomsg" v-if="purpose_id==1">
		<div class="row">
			<div class="col-md-6">
				<h2>Sale</h2>
				<table class="table table-secondary">
					<tr>
						<td>Date</td>
						<td>Purpose</td>
						<td>Total Amount</td>
					</tr>
					<tr v-for="v in alldata['total_sale']">
						<td>{{ v.date }}</td>
						<td>{{ v.transaction_purpose }}</td>
						<td>{{ v.amount }}</td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				<h2>Collection</h2>
				<table class="table table-secondary">
					<tr>
						<td>Date</td>
						<td>Purpose</td>
						<td>Total Amount</td>
					</tr>
					<tr v-for="v in alldata['total_collection']">
						<td>{{ v.date }}</td>
						<td>{{ v.transaction_purpose }}</td>
						<td>{{ v.amount }}</td>
					</tr>
				</table>
			</div>
		</div>	
	</section>

</div>
