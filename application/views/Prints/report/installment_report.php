<table style="width: 100%">
  <thead>
    <tr>
      <td>
        <div class="page-header-space">
        	
        </div>
      </td>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>
        <div class="page" style="line-height: 3;">
         	<?php if (count($temp2)): ?>
			<div class="table table-responsive table-bordered">          
				<table class="table">
					<thead>
						<tr>
							<th>NO</th>
							<th>Challan No</th>
							<th>Invoice ID</th>
							<th>Date</th>
							<th>Product Model</th>
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
						</tr>
					</thead>
					<tbody>
						<?php foreach ($temp2 as $key => $var): ?>
							<tr v-for="(i,index) in alldata">
								<td><?php echo $key+1 ?></td>
								<td><?php echo $var->challan_no ?></td>
								<td><?php echo $var->sid ?></td>
								<td><?php echo $var->created_at ?></td>
								<td><?php echo $var->product_name ?></td>
								<td><?php echo $var->customer_name ?></td>
								<td><?php echo $var->customer_contact_no ?></td>
								<td><?php echo $var->price+$var->installmentfee+$var->totalinterastlog ?></td>
								<td><?php echo $var->totaldue ?>	</td>
								<td><?php echo $var->date ?></td>
								<td><?php echo $var->amount ?></td>
								<td><?php echo $var->engineno ?></td>
								<td><?php echo $var->chassisno ?></td>
								<td><?php echo $var->color ?></td>
								<td><?php echo $var->username ?></td>
								<td><?php echo $var->batteryno ?></td>	
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>

			<div>
				<h2 class="text-danger text-center">Result is Empty</h2>
			</div>
			<?php endif ?>
        </div>
      </td>
    </tr>
  </tbody>

  <tfoot>
    <tr>
      <td>
        <div class="page-footer-space">
        	
        </div>
      </td>
    </tr>
  </tfoot>
</table>
