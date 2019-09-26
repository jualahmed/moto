<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Rate</th>
				<th>Freemonth</th>
				<th>Pardayrate</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ index+1 }}</td>
				<td>{{ r.rate }}</td>
				<td>{{ r.freemonth }}</td>
				<td>{{ r.pardayrate }}</td>
				<td>
					<a data-toggle="modal" :id="r.id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
				</td>
			</tr>
		</table>
	</section>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="configupdate" action="<?php echo base_url();?>config/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit config</h3>
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
						<input type="hidden" name="id" id="id">
		 				<div class="form-group">
							<label class="form-control-label">Rate</label>
							<?php 
								echo form_input('rate', '','class="form-control" id="rate" style="text-transform:uppercase" placeholder="Rate" autocomplete="off"');
							?>
						</div>
						<div class="form-group">
							<label class="form-control-label">Months</label>
							<?php 
								echo form_input('freemonth', '','class="form-control" id="freemonth" style="text-transform:uppercase" placeholder="freemonth" autocomplete="off"');
							?>
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">Pardayrate</label>
							<?php 
								echo form_input('pardayrate', '','class="form-control" id="pardayrate" style="text-transform:uppercase" placeholder="pardayrate" autocomplete="off"');
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


