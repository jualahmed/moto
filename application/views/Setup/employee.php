
<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new employee
		</button>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>employee name</th>
				<th>employee type</th>
				<th>employee address</th>
				<th>employee contact no</th>
				<th>int balance</th>
				<th>employee email</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ index+1 }}</td>
				<td>{{ r.employee_name }}</td>
				<td>{{ r.employee_type }}</td>
				<td>{{ r.employee_address }}</td>
				<td>{{ r.employee_contact_no }}</td>
				<td>{{ r.int_balance }}</td>
				<td>{{ r.employee_email }}</td>
				<td>
					<a data-toggle="modal" :employee_id="r.employee_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'employee/destroy/'+r.employee_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td>
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="employee" action="<?php echo base_url();?>employee/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new employee</h3>
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
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 left">
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Name</label>
								<?php 
									echo form_input('employee_name', '','class="form-control employee_name" style="text-transform:uppercase" placeholder="employee Name" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number</label>
								<?php 
									echo form_input('employee_contact_no', '','class="form-control employee_contact_no" placeholder="Contact Number" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email</label>
								<?php 
									echo form_input('employee_email', '','class="form-control employee_email" placeholder="Email Address" autocomplete="off"');
								?>
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Address</label>
								<?php 
									$employeeAddress = array(
											'name'	=> 'employee_address',
											'class'	=> 'form-control employee_address',
											'rows'  => '1',
											'cols'  => '10',
											'maxlength'	=> 300
										);
									echo form_textarea($employeeAddress, '', 'class="form-control" placeholder="employee Address"');
								?> 
							</div>
							<div class="form-group">
								  <label for="inputEmail3" class="control-label">type</label>
									<?php 
										$employeetype = array(
												'name'	=> 'employee_type',
												'class'	=> 'form-control employee_type',
												'rows'  => '1',
												'cols'  => '10',
												'maxlength'	=> 300
											);
										echo form_textarea($employeetype, '', 'class="form-control" placeholder="employee type"');
									?> 
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">int balance</label>
								<?php 
									echo form_input('int_balance', '','class="form-control int_balance" placeholder="int_balance" autocomplete="off"');
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
			<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="employeeupdate" action="<?php echo base_url();?>employee/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit employee</h3>
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
						<input type="hidden" name="employee_id" id="employee_id">
		 				<div class="form-group">
							<label class="form-control-label">employee Name</label>
							<?php 
								echo form_input('employee_name', '','class="form-control" id="employee_name" style="text-transform:uppercase" placeholder="employee Name" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">employee address</label>
							<?php 
								$catagoryaddress = array(
									'name'	=> 'employee_address',
									'class'	=> 'form-control',
									'id'	=> 'employee_address',
									'rows'  => '2',
									'cols'  => '10',
									'maxlength'	=> 100
								);
								 echo form_textarea($catagoryaddress, '', 'class="form-control" rows="4" placeholder="employee address"');
							?> 
						</div>
						<div class="form-group">
							<label class="form-control-label">employee contact no</label>
							<?php 
								echo form_input('employee_contact_no', '','class="form-control" id="employee_contact_no" style="text-transform:uppercase" placeholder="employee contact no" autocomplete="off"');
							?>
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">employee Email</label>
							<?php 
								echo form_input('employee_email', '','class="form-control" id="employee_email" style="text-transform:uppercase" placeholder="employee Email" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">employee type</label>
							<?php 
								echo form_input('employee_type', '','class="form-control" id="employee_type" style="text-transform:uppercase" placeholder="employee type" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="control-label">int balance</label>
							<?php 
								echo form_input('int_balance', '','class="form-control" id="int_balance" placeholder="int_balance" autocomplete="off"');
							?>
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


