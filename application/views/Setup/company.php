<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new Company
		</button>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Company name</th>
				<th>Company description</th>
				<th>Company address</th>
				<th>Company contact no</th>
				<th>Company email</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ row+index+1 }}</td>
				<td>{{ r.company_name }}</td>
				<td>{{ r.company_description }}</td>
				<td>{{ r.company_address }}</td>
				<td>{{ r.company_contact_no }}</td>
				<td>{{ r.company_email }}</td>
				<td>
					<a data-toggle="modal" :company_id="r.company_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'Company/destroy/'+r.company_id" class="btn btn-sm btn-danger" >
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
    <form id="company" action="<?php echo base_url();?>company/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new Company</h3>
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
							   <label for="inputEmail3" class="control-label">Company Name</label>
								<?php 
									echo form_input('company_name', '','class="form-control company_name"  placeholder="Company Name" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Company Address</label>
								<?php 
									$companyAddress = array(
											'name'	=> 'company_address',
											'class'	=> 'form-control company_address',
											'rows'  => '1',
											'cols'  => '10',
											'maxlength'	=> 300
										);
									echo form_textarea($companyAddress, '', 'class="form-control" placeholder="Company Address"');
								?> 
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Company contact no</label>
								<?php 
									echo form_input('company_contact_no', '','class="form-control company_contact_no" placeholder="Contact Number" autocomplete="off"');
								?>
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Company Email</label>
								<?php 
									echo form_input('company_email', '','class="form-control company_email" placeholder="Email Address" autocomplete="off"');
								?>
							</div>
							
							<div class="form-group">
								  <label for="inputEmail3" class="control-label">Company Description</label>
									<?php 
										$companyDescription = array(
												'name'	=> 'company_description',
												'class'	=> 'form-control company_description',
												'rows'  => '1',
												'cols'  => '10',
												'maxlength'	=> 300
											);
										echo form_textarea($companyDescription, '', 'class="form-control" placeholder="Company Description"');
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
    <form id="companyupdate" action="<?php echo base_url();?>company/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit Company</h3>
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
						<input type="hidden" name="company_id" id="company_id">
		 				<div class="form-group">
							<label class="form-control-label">Company Name</label>
							<?php 
								echo form_input('company_name', '','class="form-control" id="company_name"  placeholder="Company Name" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">Company address</label>
							<?php 
								$catagoryaddress = array(
									'name'	=> 'company_address',
									'class'	=> 'form-control',
									'id'	=> 'company_address',
									'rows'  => '2',
									'cols'  => '10',
									'maxlength'	=> 100
								);
								 echo form_textarea($catagoryaddress, '', 'class="form-control" rows="4" placeholder="Company address"');
							?> 
						</div>
						<div class="form-group">
							<label class="form-control-label">Company contact no</label>
							<?php 
								echo form_input('company_contact_no', '','class="form-control" id="company_contact_no"  placeholder="Company contact no" autocomplete="off"');
							?>
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">Company Email</label>
							<?php 
								echo form_input('company_email', '','class="form-control" id="company_email"  placeholder="Company Email" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">Company Description</label>
							<?php 
								echo form_input('company_description', '','class="form-control" id="company_description"  placeholder="Company Description" autocomplete="off"');
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


