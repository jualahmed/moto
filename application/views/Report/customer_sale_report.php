<div class="content-wrapper" id="vue_app">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Installment Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/customer_report_response" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
							<div class="form-group">

								<label for="inputEmail3" class="col-sm-1 control-label">Customer</label>
								<div class="col-sm-2">
									<select name="customer_name" v-model="customer_id" id="" class="form-control select2">
										<option value="0">Select a Customer</option>
										<?php foreach ($customer as $key => $var): ?>
											<option value="<?php echo $var->customer_id ?>"><?php echo $var->customer_name ?></option>
										<?php endforeach ?>
									</select>
								</div>

								<div class="col-sm-6 mt-2">
									<button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a>
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
		<div v-if="alldata.length">
			<div v-for="(i,index) in alldata">
				<div class="col-md-12 text-center"><h3>Invoice Id : {{ i.sid }} </h3></div>
				<div class="col-md-12 text-center"><h3>Customer Info</h3></div>
				<table class="table table-primary">
					<tr style="vertical-align: center;">
						<td rowspan="2">
								<div v-if="i.profile">
									<img :src="i.profile" alt="" width="50px">
								</div>
								<div v-else>
									<img src="<?php echo base_url() ?>/assets/img/user.jpg" alt="" width="50px">
								</div>
						</td>
						<td><b>Name :</b> {{ i.customer_name }} </td>
						<td><b>Mobile No :</b> {{ i.customer_contact_no }} </td>
						<td><b>Father Name :</b> {{ i.father_name }} </td>
						<td><b>Village :</b> {{ i.village }} </td>
						<td><b>Post Office :</b> {{ i.postoffice }} </td>
					</tr>
					<tr>
						<td><b>Tana :</b> {{ i.police_station }} </td>
						<td><b>District  :</b> {{ i.district }} </td>
						<td></td>
					</tr>
				</table>

				<div class="col-md-12 text-center"><h3>Product Info</h3></div>
				<table class="table">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Engine No</th>
							<th>Chassis No</th>
							<th>Color</th>
							<th>Battery No</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{ i.product_name }}</td>
							<td>{{ i.engineno }}</td>
							<td>{{ i.chassisno }}</td>
							<td>{{ i.color }}</td>
							<td>{{ i.batteryno }}</td>
							<!-- <th>{{ i.price+i.totalinterest+i.installmentfee }}</th> -->
							<!-- <th>{{ i.totaldue+i.screchcard+i.discount }}</th> -->
						</tr>
					</tbody>
				</table>
				<div style="text-align: right;">
					<table class="table" style="padding: 0px;margin:0px;border: none;width: 300px;margin-right: 0px;">
						<tr>
							<td>
								<p><b>বিক্রয় মূল্য :</b></p>
								<p style="font-size: 15px;"><b>নগদ জমা :</b> </p>
								<p style="font-size: 15px;"><b>কিস্তি পরিশোধ :</b></p>
								<p style="font-size: 15px;"><b>বকেয়া :</b></p>
							    <p><b>ডিসকাউন্ট : ( - )</b> </p>
								<p><b><b>স্ক্রার্চ কার্ড</b> : ( - )</b></p>
							</td>
							<td align="right" style="font-size: 15px;">
								<b>
									<p> {{ parseInt(i.price)+parseInt(i.totalinterastlog)+parseInt(i.installmentfee) }} </p>
									<p> {{ parseInt(i.advancepay) }} </p>
									<p> {{ (parseInt(i.price)+parseInt(i.totalinterastlog)+parseInt(i.installmentfee))-(parseInt(i.totaldue)+parseInt(i.totalinterest)) }}</p>
									<p> {{ parseInt(i.totaldue)+parseInt(i.totalinterest) }}</p>
									<p> {{ parseInt(i.discount) }} </p>
									<!-- <p> {{ i.screchcard }} </p> -->
								</b>
							</td>
						</tr>
					</table>
				</div>

			</div>			
		</div>
		<div v-else>
			<h2 class="text-danger text-center">Result is Empty</h2>
		</div>
	</section>
</div>
