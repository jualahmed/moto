<div class="content-wrapper" id="vueapp">
	<br>
	<div class="box-header with-border">
		<h3 class="box-title">Motorcycle Stock Details Report</h3>
		<h3 class="box-title text-right"> <a href="<?php echo base_url() ?>Report/stock_details_print" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration: none;"><i class="fa fa-download"></i> Download</a></h3>
	</div>
	<div class="table-responsive">
		<table class="table table-secondary">
		<tr>
		    <th>No</th>
		    <th>Challan No</th>
		    <th>Product</th>
		    <th>Company</th>
		    <th>Category</th>
		    <th>engineno</th>
		    <th>chassisno</th>
		    <th>color</th>
		    <th title="Purchase Quantity">Quantity</th>
		    <th>BP</th>
		    <th>SP</th>
		    <th>batteryno</th>
		</tr>
		<?php $i=0;$amount=0;$samount=0; foreach ($reportdata as $key => $var): $i++;$amount=$amount+$var->sale_price;$samount=$samount+$var->purchase_price ?>
			<tr>
				<td><?php echo $i ?></td>
			    <td><?php echo $var->challan_no ?></td>
			    <td><?php echo $var->product_name ?></td>
			    <td><?php echo $var->company_name ?></td>
			    <td><?php echo $var->catagory_name ?></td>
			    <td><?php echo $var->engineno ?></td>
			    <td><?php echo $var->chassisno ?></td>
			    <td><?php echo $var->color ?></td>
			    <td title="Purchase Quantity">1</td>
			    <td><?php echo $var->purchase_price ?></td>
			    <td><?php echo $var->sale_price ?></td>
			    <td><?php echo $var->batteryno ?></td>
			</tr>
		<?php endforeach ?>
			<tr>
				<td colspan="8"><b></b></td>
				<td colspan="1"><b>Total Quantity: <?php echo $i ?></b></td>
				<td colspan="1"><b>Total Amount: <?php echo $samount ?></b></td>
				<td colspan="1"><b>Total Sale Amount: <?php echo $amount ?></b></td>
			</tr>
	</table>
	</div>
</div>
