
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(5);
	if($result!='')
	{
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Purchase Return Done", ":)", "success")
					});
			</script>';
		}
	}
?>
	<input type="hidden" id="hide_dist" value="<?php echo $this->uri->segment(3);?>">
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <div class="row">
       		<div class="col-md-6">
        		<div class="box">
            		<div class="box-header with-border">
              			<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Return</h3>
            		</div>
             		<div class="box-body">
                		<div class="col-md-12">
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="width: 35%;vertical-align: middle;">Distributor:</td>
									<td>
										<?php 
											echo form_dropdown('distributor_id', $distributor_info,$this->uri->segment(3),'class="form-control three select2" id="distributor_id" tabindex="-1" aria-hidden="true"');
										?>
									</td>
								</tr>
								<tr>
									<td style="width: 35%;vertical-align: middle;">Product:</td>
									<td>
										<select class="form-control select2 sel_dist" name="product_id" id="product_id" style="width: 100%;" required>
											<option value="">Select Product</option>
											<?php
											if($product_info->num_rows > 0)
											{
												foreach($product_info-> result() as $field)
												{ 
											?>
													<option value="<?php echo $field->product_id;?>"><?php echo $field -> product_name;?></option>
											<?php 
												}
											}
											?>
										</select>
									</td>
								</tr>
							</table>
							<form action="<?php echo base_url();?>purchase/list_purchase_temp_data" method="post" autocomplete="off">
								<input type="hidden" name="pro_id" required value="<?php echo $this->uri->segment(4);?>">
								<input type="hidden" name="dis_id" required value="<?php echo $this->uri->segment(3);?>">
								<?php
								if($this->uri->segment(4)!='')
								{
									if($product_info_warranty_details->num_rows > 0)
									{
									?>
									<table class="table table-bordered reduce_space" >
										<tr>
											<td colspan="4">Product Details</td>
										</tr>
										<?php
										foreach($product_info_details->result() as $tmp)
										{
										?>
										<tr>
											<td>Product Name</td>
											<td colspan="3"><?php echo $tmp->product_name;?></td>
										</tr>
										<tr>
											<td>Stock Amount</td>
											<td><?php echo $tmp->stock_amount;?></td>
											<td>Buy Price</td>
											<td><?php echo $tmp->bulk_unit_buy_price;?></td>
											<input type="hidden" name="buy_price" value="<?php echo $tmp->bulk_unit_buy_price;?>">
										</tr>
										<?php 
										}
										?>
									</table>
									<table class="table table-bordered reduce_space" >
										<tr>
											<td colspan="4">Warranty Product Details</td>
										</tr>
										<tr>
											<td style="text-align:center;">No</td>
											<td style="text-align:left;">Serial Name</td>
											<td style="text-align:center;">Action</td>
										</tr>
										<?php
										$i=1;
										foreach($product_info_warranty_details->result() as $tmp2)
										{
										?>
										<tr>
											<td style="text-align:center;"><?php echo $tmp2->ip_id;?></td>
											<td style="text-align:left;"><?php echo $tmp2->sl_no;?></td>
											<td style="text-align:center;"><input type="checkbox" name="ip_ids[<?php echo $i; ?>]" value="<?php echo $tmp2->ip_id; ?>" id="check_box"></td>
										</tr>
										<?php 
											$i++;
										}
										?>
									</table>
									<?php 
									}
									else
									{
									?>
										<?php
										if($product_info_details->num_rows > 0)
										{
										?>
										<table class="table table-bordered reduce_space" >
											<tr>
												<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
											</tr>
											<?php
											foreach($product_info_details->result() as $tmp)
											{
											?>
											<tr>
												<td>Product Name</td>
												<td colspan="3"><?php echo $tmp->product_name;?></td>
											</tr>
											<tr>
												<td>Stock Amount</td>
												<td><?php echo $tmp->stock_amount;?></td>
												<td>Buy Price</td>
												<td><?php echo $tmp->bulk_unit_buy_price;?></td>
												<input type="hidden" name="buy_price" value="<?php echo $tmp->bulk_unit_buy_price;?>">
											</tr>
											<?php
												if($tmp->stock_amount!='0')
												{
												?>
													<tr>
														<td>Return Quantity</td>
														<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
													</tr>
											<?php 
												}
												else
												{
											?>
													<tr>
														<td>Return Quantity</td>
														<td colspan="4"><input type="text" id="return_amount" title="Stock amount is zero" name="return_amount" readonly class="form-control"></td>
													</tr>
											<?php
												}
											}
											?>
										</table>
									<?php
										}
									}
								}
								?>
								<div class="box-footer text-right">
										<div class="col-sm-22">
											<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
										</div>
								</div>
							</form>
              			</div>
                	</div>
          		</div>
        	</div>
			<?php
			if($return_main_product->num_rows > 0)
			{
			?>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Return List</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="col-md-12">
							<?php
								$field = $return_main_product->row();
							?>
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;"><b>Distributor Name:</b> <?php echo $field->distributor_name;?></td>
								</tr>
							</table>
							<table class="table table-bordered reduce_space" >
								<tr>
									<td style="text-align:center;">No</td>
									<td style="text-align:center;">Product Name</td>
									<td style="text-align:center;">Quantity</td>
									<td style="text-align:center;"></td>
								</tr>
								<?php
								$i=1;
								$ii=1;
								foreach($return_main_product->result() as $tmp)
								{
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><b>Main Product:</b> <?php echo $tmp->product_name;?><br>
										<?php
										
										foreach($return_warranty_product[$ii]->result() as $new_tmp)
										{
											echo '<b>Warranty Product:</b> '.$new_tmp->sl_no.'<br>';

										}
										?>
									</td>
									<td style="text-align:center;"><?php echo $tmp->return_quantity;?></td>
									<td style="text-align:center;"><i id="delete<?php echo $tmp->prmp_id;?>" class="fa fa-fw fa-remove delete_product" style="color: red;cursor:pointer;" ></i> </td>
								</tr>
								<?php
									$ii++;
									$i++;
								}
								?>
							</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<form action="<?php echo base_url();?>purchase/final_purchase_return" method="post">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Final Submit</button>
										</form>
									</div>
								</center>
							</div>
						</div>    
					</div>    
				</div>    
			</div>
			<?php
			}
			?>
      	</div>    
    </section>
</div>
