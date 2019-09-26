<table style="width: 100%">
  <thead>
    <tr>
      <td>
        <!--place holder for the fixed-position header-->
        <div class="page-header-space"></div>
      </td>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>
        <div class="page" style="line-height: 3;">
         	<?php if(count($data)>0){ ?>
<div class="table-responsive">     
	<div class="table-responsive">     
		<table class="table table-bordered table-secondary">
			<thead>
				<tr>
					<th>NO</th>
					<th>Challan No</th>
					<th>Invoice ID</th>
					<th>Date</th>
					<th>Product Name</th>
					<th>Engine No</th>
					<th>Chassis No</th>
					<th>Color</th>
					<th>Customer Name</th>
					<th>Mobile No</th>
					<th>Total</th>
					<th>Due</th>
					<th>Seller</th>
					<th>Battery No</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;$amount=0;$samount=0;foreach ($data as $key => $var): $i++;$samount=$samount+$var->totaldue+$var->totalinterest;$amount=$amount+$var->price+$var->installmentfee+$var->totalinterastlog ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $var->challan_no ?></td>
						<td><?php echo $var->sid ?></td>
						<td><?php echo $var->date ?></td>
						<td><?php echo $var->product_name ?></td>
						<td><?php echo $var->engineno ?></td>
						<td><?php echo $var->chassisno ?></td>
						<td><?php echo $var->color ?></td>
						<td><?php echo $var->customer_name ?></td>
						<td><?php echo $var->customer_contact_no ?></td>
						<td><?php echo $var->price+$var->installmentfee+$var->totalinterastlog ?></td>
						<td><?php echo sprintf('%0.2f',$var->totaldue+$var->totalinterest) ?></td>
						<td><?php echo $var->username ?></td>
						<td><?php echo $var->batteryno ?></td>	
					</tr>
				<?php endforeach ?>
				<tr>
					<td colspan="11"></td>
					<td><b>Total : <?php echo $amount ?></b></td>
					<td colspan="2"><b>Total Due: <?php echo sprintf('%0.2f',$samount) ?></b></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php }else{ ?>
<div>
	<h2 class="text-danger text-center">Result is Empty</h2>
</div>
<?php } ?>
        </div>
      </td>
    </tr>
  </tbody>

  <tfoot>
    <tr>
      <td>
        <div class="page-footer-space"></div>
      </td>
    </tr>
  </tfoot>
</table>
