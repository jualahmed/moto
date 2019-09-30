
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

		<form action="<?php echo base_url().'pandingmamo/create' ?>" method="post">
			<div class="col-md-4">
				<select class="form-control"  name="product_id">
					<option>Select a Product</option>
					<?php foreach ($product as $key => $var): ?>
						<option value="<?php echo $var->product_id ?>"><?php echo $var->product_name ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-4">
				<select class="form-control" class="form-control" name="customer_id">
					<option>Select a customar</option>
					<?php foreach ($customer as $key => $var): ?>
						<option value="<?php echo $var->customer_id ?>"><?php echo $var->customer_name ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="col-md-4">
				<input type="text" name="amount" class="form-control"> 
			</div>
			<br>
			<br>
			<div class="col-md-12">
				<input type="submit" name="" class="btn btn-success" value="submit">
			</div>
		</form>

		<br><br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Product name</th>
				<th>Customer</th>
				<th>Amount</th>
				<th align="center">Action</th>
			</tr>
			<?php foreach ($pandingmamo as $key => $var): ?>
			<tr align="left"> 
					<td><?php echo $key+1 ?></td>
					<td><?php echo $var->product_name ?></td>
					<td><?php echo $var->customer_name ?></td>
					<td><?php echo $var->amount ?></td>
					<td>
						<a target="_blanck" href="<?php echo base_url().'pandingmamo/printpandingmamo/'.$var->id ?>">Print</a>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</section>
</div>
