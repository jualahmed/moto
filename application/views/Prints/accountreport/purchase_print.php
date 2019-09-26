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
			<div >
				<?php if(count($purchase_data->result())>0){ ?>
				<div class="table-responsive">
					<table class="table table-primary table-bordered">
					<tr>
					  <td style="word-wrap: wrap">No</td>
					  <td>Challan No</td>
					  <td>Date</td>
					  <td>Product</td>
					  <td>Company</td>
					  <td>Category</td>
					  <td>engineno</td>
					  <td>chassisno</td>
					  <td>color</td>
					  <td title="Purchase Quantity">Quantity</td>
					  <td>BP</td>
					  <td>batteryno</td>
					</tr>
					<?php $i=0;$stockqty=0;$amount=0;$samount=0;foreach ($purchase_data->result() as $var):$i++; $stockqty++;$amount=$amount+$var->general_unit_sale_price; $samount=$samount+$var->purchase_price;?>
						<tr v-for="(a,index) in alldata">
						  <td><?php echo $i ?></td>
						  <td><?php echo $var->challan_no ?></td>
						  <td><?php echo $var->receipt_date ?></td>
						  <td><?php echo $var->product_name ?></td>
						  <td><?php echo $var->company_name ?></td>
						  <td><?php echo $var->catagory_name ?></td>
						  <td><?php echo $var->engineno ?>	 </td>
						  <td><?php echo $var->chassisno ?> </td>
						  <td><?php echo $var->color ?> </td>
						  <td title="Purchase Quantity">1</td>
						  <td><?php echo $var->purchase_price ?></td>
						  <td><?php echo $var->batteryno ?> </td>
						</tr>
					<?php endforeach ?>
					<tr>
						<td colspan="10"><b></b></td>
						<td colspan="1"><b>Total Quantity: <?php echo $stockqty ?></b> </td>
						<td colspan="1"><b>Total Stock Amount: <?php echo $samount ?></b></td>
					</tr>
				</table>
				</div>
				<?php }else{ ?>
					<h2 class="text-danger text-center">Result Empty</h2>
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
