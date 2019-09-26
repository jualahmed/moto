
<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new customer
		</button>
		<br>
		<br>
		<div style="width: 100%">
							<div>
							<div style="display: flex;"> 
							  <multiselect 
							  v-model="selectedcustomar" 
							  id="ajax" label="customer_name" 
							  track-by="customer_name" 
							  placeholder="Type to search a Customar" 
							  open-direction="bottom" 
							  :options="customers" 
							  :searchable="true" 
							  :loading="isLoading" 
							  :internal-search="false" 
							  :clear-on-select="false" 
							  :close-on-select="true"
							  :options-limit="300" 
							  :limit="3" 
							  :limit-text="limitText" 
							  :max-height="600" 
							  :show-no-results="false" 
							  :hide-selected="false" 
							  @search-change="searchfind"
							 >	

							    <template slot="tag" slot-scope="{ option, remove }">
							    	<span class="custom__tag"><span>{{ option }}</span>
							    		<span class="custom__remove" @click="remove(option)">❌</span>
							    	</span>
							    </template>
							    <template slot="option" slot-scope="props">
							        <div class="option__desc">
								      	<span class="option__title" style="display: flex;">
									      	<img v-if="props.option.profile" style="padding: 5px;" :src="props.option.profile" alt="" width="40px;" height="40px;">
									      	<img v-else style="padding: 5px;" :src="base_url+'assets/img/user.jpg'" alt="" width="40px;" height="40px;">
									      	<div>
									      		{{ props.option.customer_name }} <br> {{ props.option.customer_contact_no }}
									      	</div>
									    </span>
							        </div>
							    </template>
							    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
							  </multiselect>
							  
							  </div>
							  	<div v-if="selectedcustomar!=null && selectedcustomar.length!=0">
									<table class="table table-secondary">
										<tr align="left">
											<th style="text-align: center;">Profile</th>
											<th>customer name</th>
											<th>Father Name</th>
											<th>mobile</th>
											<th>village</th>
											<th>post office</th>
											<th>tana</th>
											<th>district</th>
											<th align="center">Action</th>
										</tr>
										<tr>
											<td align="center">
												<img v-if="selectedcustomar.profile" :src="selectedcustomar.profile" alt="" width="30px" height="30px">
												<img v-else src="<?php echo base_url().'/assets/img/user.jpg' ?>" alt="" width="30px" height="30px">
											</td>
											<td align="left">{{ selectedcustomar.customer_name }}</td>
											<td align="left">{{ selectedcustomar.father_name }}</td>
											<td align="left">{{ selectedcustomar.customer_contact_no }}</td>
											<td align="left">{{ selectedcustomar.village }}</td>
											<td align="left">{{ selectedcustomar.postoffice }}</td>
											<td align="left">{{ selectedcustomar.police_station }}</td>
											<td align="left">{{ selectedcustomar.district }}</td>
											<td>
												<a data-toggle="modal" :customer_id="selectedcustomar.customer_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
												<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'customer/destroy/'+selectedcustomar.customer_id" class="btn btn-sm btn-danger" >
													<i class="fa fa-trash"></i> Delete
												</a>
											</td>
										</tr>
									</table>
								</div>
							</div>
			            </div>

		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th style="text-align: center;">Profile</th>
				<th>customer name</th>
				<th>Father Name</th>
				<th>mobile</th>
				<th>village</th>
				<th>post office</th>
				<th>tana</th>
				<th>district</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ row+index+1 }}</td>
				<td align="center">
					<img v-if="r.profile" :src="r.profile" alt="" width="30px" height="30px">
					<img v-else src="<?php echo base_url().'/assets/img/user.jpg' ?>" alt="" width="30px" height="30px">
				</td>
				<td>{{ r.customer_name }}</td>
				<td>{{ r.father_name }}</td>
				<td>{{ r.customer_contact_no }}</td>
				<td>{{ r.village }}</td>
				<td>{{ r.postoffice }}</td>
				<td>{{ r.police_station }}</td>
				<td>{{ r.district }}</td>
				<td>
					<a data-toggle="modal" :customer_id="r.customer_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'customer/destroy/'+r.customer_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td>
			</tr>
			<tr><td colspan="9" style="text-align: left;"><b>{{ rowperpage }}  Out Of {{ total }}</b></td></tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>

	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="customer" action="<?php echo base_url();?>customer/create" method="post" class="form-horizontal" enctype="multipart/form-data">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new customer</h3>
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
							   <label for="inputEmail3" class="control-label">Name <span class="text-danger">*</span></label>
								<?php 
									echo form_input('customer_name', '','class="form-control customer_name" placeholder="Customer Name" autocomplete="off"');
								?>
							</div>

						

							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number <span class="text-danger">*</span></label>
								<?php 
									echo form_input('customer_contact_no', '','class="form-control customer_contact_no" placeholder="Contact Number" autocomplete="off"');
								?>
							</div>
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Village <span class="text-danger">*</span></label>
								<?php 
									echo form_input('village', '','class="form-control village" placeholder="Village" autocomplete="off"');
								?>
							</div>

							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Thana <span class="text-danger">*</span></label>
								<input type="text" class="form-control police_station" name="police_station" placeholder="Thana">
							</div>
							
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Profile Photo</label>
								<input type="file" placeholder="Profile" id="file" name="file" class="form-control">
							</div>
						
						</div>
						<div class="col-md-6 right">
							
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Father Name <span class="text-danger">*</span></label>
								<?php 
									$fatherName = array(
											'name'	=> 'father_name',
											'class'	=> 'form-control father_name',
											'rows'  => '1',
											'cols'  => '10',
											'maxlength'	=> 300
										);
									echo form_textarea($fatherName, '', 'class="form-control" placeholder="Father Name"');
								?> 
							</div>

							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email</label>
								<?php 
									echo form_input('customer_email', '','class="form-control customer_email" placeholder="Email Name" autocomplete="off"');
								?>
							</div>
							
						
								
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Post Office <span class="text-danger">*</span></label>
								<?php 
									echo form_input('postoffice', '','class="form-control postoffice" placeholder="Postoffice" autocomplete="off"');
								?>
							</div>

							<div class="form-group">
							   <label for="inputEmail3" class="control-label">District <span class="text-danger">*</span></label>
								<input type="text" name="district" class="form-control district" placeholder="district">
							</div>

							<!-- <div class="form-group">
							   <label for="inputEmail3" class="control-label">Customer id</label>
								<input type="number" name="id" class="form-control" placeholder="Customar id">
							</div> -->

						

						</div>
					</div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success" name="search_random" id="upload"><i class="fa fa-fw fa-save"></i> Create</button>
			<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="customerupdate" action="<?php echo base_url();?>customer/update" method="post" class="form-horizontal">
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
						<input type="hidden" name="customer_id" id="customer_id">
		 				<div class="form-group">
							<label class="form-control-label">Customer Name <span class="text-danger">*</span></label>
							<?php 
								echo form_input('customer_name', '','class="form-control" id="customer_name" placeholder="customer Name" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">Father Name <span class="text-danger">*</span></label>
							<?php 
								$catagoryName = array(
									'name'	=> 'father_name',
									'class'	=> 'form-control',
									'id'	=> 'father_name',
									'rows'  => '2',
									'cols'  => '10',
									'maxlength'	=> 100
								);
								 echo form_input($catagoryName, '', 'class="form-control" rows="4" placeholder="father_name"');
							?> 
						</div>
					

						<div class="form-group">
							<label class="form-control-label">Village <span class="text-danger">*</span></label>
							<?php 
								echo form_input('village', '','class="form-control" id="village" placeholder="Village" autocomplete="off"');
							?>
						</div>	

						<div class="form-group">
							<label for="inputEmail3" class="control-label">Thana <span class="text-danger">*</span></label>
							<input type="text" class="form-control police_station" name="police_station" placeholder="Thana ">
						</div>
						
					</div>
					<div class="col-md-6 right">
						
						<div class="form-group">
							<label class="form-control-label">Customer Email</label>
							<?php 
								echo form_input('customer_email', '','class="form-control" id="customer_email" placeholder="customer Email" autocomplete="off"');
							?>
						</div>
							
						<div class="form-group">
							<label class="form-control-label">Customer Contact No <span class="text-danger">*</span></label>
							<?php 
								echo form_input('customer_contact_no', '','class="form-control" id="customer_contact_no" placeholder="customer contact no" autocomplete="off"');
							?>
						</div>

					

						<div class="form-group">
						   <label for="inputEmail3" class="control-label">Post Office <span class="text-danger">*</span></label>
							<?php 
								echo form_input('postoffice', '','class="form-control postoffice" placeholder="Postoffice" autocomplete="off"');
							?>
						</div>

						<div class="form-group">
						   <label for="inputEmail3" class="control-label">District <span class="text-danger">*</span></label>
							<input type="text" name="district" class="form-control district" placeholder="district">
						</div>

						<div class="form-group">
						   <label for="inputEmail3" class="control-label">Profile Photo</label>
							<input type="file" placeholder="Profile" id="files" name="file" class="form-control">
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


