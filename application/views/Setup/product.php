<div class="content-wrapper" id="vuejsapp">
	<section class="content">
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Product Setup</h3>
					</div>
					<form id="product" action="<?php echo base_url();?>product/create" method="post" class="form-horizontal" enctype="multipart/form-data">
						<div class="box-body">	
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Catagory Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md catagory_id">
										<select name="catagory_id" class="form-control">
											<option value="">Select a Catagory</option>
											<?php foreach ($catagory as $value) { ?>
												<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#cModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>

								<label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
								<div class="col-sm-4">
									<input type="text" name="product_name" id="edValue" class="form-control product_name" onKeyPress="edValueKeyPress()" onKeyUp="edValueKeyPress()" onBlur="checkAvailability()" placeholder="Product Name" autocomplete="off">
								
									<span id="user-availability-status1" style="display:none;"></span>
									<span id="user-availability-status2" style="display:none;"></span>
									<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
								</div>

								<label for="inputEmail3" class="col-sm-2 control-label">Product Model</label>
								<div class="col-sm-4">
									<input type="text" name="product_model" class="form-control product_model" placeholder="Product Model" autocomplete="off">
									<span id="user-availability-status1" style="display:none;"></span>
									<span id="user-availability-status2" style="display:none;"></span>
									<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
								</div>
							</div>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md company_id">
										<select name="company_id" id="" class="form-control">
											<option value="">Select a Company</option>
											<?php foreach ($company as $value) { ?>
												<option value="<?php echo $value->company_id ?>"><?php echo $value->company_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#comModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Unit Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md unit_id">
										<select name="unit_id" id="" class="form-control">
											<option value="">Select a Unit</option>
											<?php foreach ($unit as $value) { ?>
												<option value="<?php echo $value->unit_id ?>"><?php echo $value->unit_name ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button type="button" data-toggle="modal" data-target="#unitModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<br>
								<br>
								<br>
							<div class="row">

								<label for="inputEmail3" class="col-sm-2 control-label">Product Size</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_size','' , 'class= "form-control product_size" placeholder="Product Size" id="product_size" autocomplete="off"');	
									?>
								</div>
							
							
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Alarm Level</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('alarming_stock', '0', 'class= "form-control" id="six" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Image</label>
								<div class="col-sm-4">
									<input type="file" name="user_file_3" id="photo" class="form-control">
								</div>
							</div>
							<br>
							<div class="row">
								<label for="inputEmail3" class="col-sm-2 control-label">Genral / Warranty </label>
								<div class="col-sm-4">
									<select class="select2 form-control" name="product_specification" required="on" id="product_specification">
										<option value="">Select Type</option>
										<option value="1" selected>General</option>
										<option value="2">Warranty</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label war_peri" style="display:none;">Warranty Period(In Month)</label>
								<div class="col-sm-4 war_peri" style="display:none;">
									<input type="number" name="product_warranty" class="form-control" placeholder="N/A" id="nine" autocomplete="off">
								</div>
								
							</div>
						</div> 
						<div class="box-footer text-right">
							<div class="col-sm-22">
								<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
								<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
							</div>
						</div>
					</form>
				</div> 
			</div> 
		</div>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Product Name</th>
				<th>Product Category</th>
				<th>Product Company</th>
				<th>Product Size</th>
				<th>Product Status</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ row+index+1 }}</td>
				<td>{{ r.product_name }}</td>
				<td>{{ r.catagory_name }}</td>
				<td>{{ r.company_name }}</td>
				<td>{{ r.product_size }}</td>
				<td><span v-if="r.product_status==1">Active</span><span class="text-danger" v-else>Inactive</span></td>
				<td>
					<a data-toggle="modal" :product_id="r.product_id" data-target="#EditModel" class="btn edit btn-sm btn-success edit" ><i class="fa fa-edit"></i> Edit</a>
				<!-- 	<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'product/destroy/'+r.product_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a> -->
				</td>
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
	</section> 
</div>

<!-- Modal -->
<div class="modal fade" id="cModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="categoryinsertformproduct" action="<?php echo base_url();?>category/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new Category</h3>
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
				<div class="form-group">
					<label class="form-control-label">Category Name</label>
					<?php 
						echo form_input('catagory_name', '','class="form-control" id="catagory_name placeholder="Category Name" autocomplete="off"');
					?>
				</div>
				<div class="form-group">
					<label class="form-control-label">Category Description</label>
					<?php 
						$catagoryDescription = array(
							'name'	=> 'catagory_description',
							'id'	=> 'catagory_description',
							'class'	=> 'form-control',
							'rows'  => '2',
							'cols'  => '10',
							'maxlength'	=> 100
						);
						 echo form_textarea($catagoryDescription, '', 'class="form-control" rows="4" placeholder="Category Description"');
					?> 
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

<!-- company -->
<div class="modal fade" id="comModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form id="conpamyinsertformproduct" action="<?php echo base_url();?>company/create" method="post" class="form-horizontal">
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
							   <label for="inputEmail3" class="control-label">Name</label>
								<?php 
									echo form_input('company_name', '','class="form-control company_name placeholder="Company Name" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number</label>
								<?php 
									echo form_input('company_contact_no', '','class="form-control company_contact_no" placeholder="Contact Number" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email</label>
								<?php 
									echo form_input('company_email', '','class="form-control company_email" placeholder="Email Address" autocomplete="off"');
								?>
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Address</label>
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
								  <label for="inputEmail3" class="control-label">Description</label>
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

<!-- Unit -->
<div class="modal fade" id="unitModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="unit" action="<?php echo base_url();?>unit/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new unit</h3>
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
						<div class="col-md-12">
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Name</label>
								<?php 
									echo form_input('unit_name', '','class="form-control unit_name placeholder="unit Name" autocomplete="off"');
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

<!-- Unit -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <form id="productedit" action="<?php echo base_url();?>product/update" method="post" class="form-horizontal" enctype="multipart/form-data">
	  	<input type="hidden" name="product_id" class="product_id">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
		    <div class="modal-header">
		        <div class="row">
		        	<div class="col-md-6">
		        		<h3 class="modal-title" id="exampleModalLabel">Edit Product</h3>
		        	</div>
		        	<div class="col-md-6">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
		        	</div>
		        </div>
		    </div>
			<div class="box-body">	
				<div class="row">
					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Catagory Name</label>
						<div class="input-group input-group-md">
							<select name="catagory_id" class="form-control catagory_id">
								<option value="">Select a Catagory</option>
								<?php foreach ($catagory as $value) { ?>
									<option value="<?php echo $value->catagory_id ?>"><?php echo $value->catagory_name ?></option>
								<?php } ?>
							</select>
							<span class="input-group-btn">
								<button type="button" data-toggle="modal" data-target="#cModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
							</span>
						</div>
					</div>

					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Product Name</label>
						<?php 
							echo form_input('product_name', '','class ="form-control product_name  id="edValue" onKeyPress="edValueKeyPress()" onKeyUp="edValueKeyPress()" onBlur="checkAvailability()" placeholder="Product Name" autocomplete="off"');
							
						?>
						<span id="user-availability-status1" style="display:none;"></span>
						<span id="user-availability-status2" style="display:none;"></span>
						<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
					</div>

					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Product Model</label>
						<?php 
							echo form_input('product_model', '','class ="form-control product_model placeholder="Product Model" autocomplete="off"');
							
						?>
						<span id="user-availability-status1" style="display:none;"></span>
						<span id="user-availability-status2" style="display:none;"></span>
						<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Company Name</label>
						<div class="input-group input-group-md">
							<select name="company_id" id="" class="form-control company_id">
								<option value="">Select a Company</option>
								<?php foreach ($company as $value) { ?>
									<option value="<?php echo $value->company_id ?>"><?php echo $value->company_name ?></option>
								<?php } ?>
							</select>
							<span class="input-group-btn">
								<button type="button" data-toggle="modal" data-target="#comModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
							</span>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Unit Name</label>
						<div class="input-group input-group-md">
							<select name="unit_id" id="" class="form-control unit_id">
								<option value="">Select a Unit</option>
								<?php foreach ($unit as $value) { ?>
									<option value="<?php echo $value->unit_id ?>"><?php echo $value->unit_name ?></option>
								<?php } ?>
							</select>
							<span class="input-group-btn">
								<button type="button" data-toggle="modal" data-target="#unitModel" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
							</span>
						</div>
					</div>
					<div class="col-sm-6">
						<label for="inputEmail3" class="control-label">Product Size</label>
						<?php 
							echo form_input('product_size','' , 'class= "form-control product_size" placeholder="Product Size" id="product_size" autocomplete="off"');	
						?>
					</div>
				<br>
			</div> 
	        <div class="modal-footer">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        	<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
				<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	        </div>
	    </div>
	  </div>
	</div>
	</form>
</div>


