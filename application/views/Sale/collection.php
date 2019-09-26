<div class="content-wrapper">
    <section class="content" id="vuejscom"> 
	    <div class="row">
	      	<div class="col-md-12">
		        <div class="box">
		            <div class="box-header with-border text-center">
						<h2 class="box-title font-weight-bold">Due collection</h2>
						<br>
						<br>
						<div class="col-md-6">
							<label for="">Search With Customer Name Or Mobile Number</label>
							<multiselect 
							  v-model="selectedcustomar" 
							  id="ajax" label="customer_name" 
							  track-by="customer_name" 
							  placeholder="Type to search" 
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
							  @Select="testss"
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
							      	</div></span>
							      </div>
							    </template>
							    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
							</multiselect>
						</div>
						
						<div class="col-md-6">
							<form action="<?php echo base_url().'sale/collection' ?>" method="post">
								<label for="">Search With Invoice Id</label>
								<input type="text" name="id" value="<?php echo $id ?>" class="form-control" placeholder="Invoice id">
							</form>
						</div>

						<div class="col-md-12" v-if="allsale.length>0">
							<table class="table table-primary">
								<tr>
									<td>No</td>
									<td>Invoice No</td>
									<td>Product</td>
									<td>Challan No</td>
									<td>Engine No</td>
									<td>Battery No</td>
									<td>Color</td>
									<td>Chassis No</td>
									<td>Price</td>
									<td>Due</td>
									<td>Installment Date</td>
									<td>Details</td>
								</tr>
								<tr v-for="(i,index) in allsale">
									<td>{{ index+1 }}</td>
									<td>{{ i.id }}</td>
									<td>{{ i.product_name }}</td>
									<td>{{ i.challan_no }}</td>
									<td>{{ i.engineno }}</td>
									<td>{{ i.batteryno }}</td>
									<td>{{ i.color }}</td>
									<td>{{ i.chassisno }}</td>
									<td>{{ parseInt(i.price)+parseInt(i.installmentfee)+parseInt(i.totalinterastlog) }}</td>
									<td>{{ i.totaldue }}</td>
									<td>{{ i.seconddate }}</td>
									<td><a :href="base_url+'sale/collection/'+i.id" class="btn btn-info">Payment Now</a></td>
								</tr>
							</table>	
						</div>

						
						<?php if ($this->session->flashdata('success')): ?>
    						<h2 class="alert-success"><?php echo $this->session->flashdata('success');  ?></h2>
    					<?php endif ?>
						<br>
						<?php if(isset($invoiceinfo) && count($invoiceinfo)>0){ ?>
							<teble class="col-md-12">
								<br>
								<table class="table table-primary">
									<tr>
										<td><b>INVOICE ID:</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->sid ?></td>
										<td><b>PRICE :</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->price+$invoiceinfo[0]->installmentfee+$invoiceinfo[0]->totalinterastlog) ?></td>
										<td><b>DISCOUNT:</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->discount) ?></td>
										<td><b>Installments :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->month ?></td>
										<td><b>SCRECH CARD:</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->screchcard) ?></td>
									</tr>
									<tr>
										<td><b>TOTAL INTEREST :</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->totalinterest) ?></td>
										<td><b>PAR MONTH PAY :</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->permonthpay) ?></td>
										<td><b>DATE :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->date ?></td>
										<td><b>Remaining Installments :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->totalkisti ?></td>
										<input type="hidden" id="totalkisti" type="text" value="<?php echo $invoiceinfo[0]->totalkisti ?>">
										<input type="hidden" id="totalkisti1" type="text" value="<?php echo $invoiceinfo[0]->month ?>">
										<input type="hidden" id="doneistallment" type="text" value="<?php echo $invoiceinfo[0]->month-$invoiceinfo[0]->totalkisti ?>">
										<td><b>NEXT PAYMENT DATE :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->seconddate ?></td>
									</tr>
									<tr>
										<td><b>TOTAL DUE :</b> <?php if(isset($invoiceinfo[0]->sid))echo sprintf("%.2f",$invoiceinfo[0]->totaldue) ?></td>
									</tr>
								</table>
							
								<div class="col-md-12"><h3>Customer Info</h3></div>
								<table class="table table-primary">
									<tr style="vertical-align: center;">
										<td rowspan="2">
												<?php if($invoiceinfo[0]->profile){ ?>
													<img src="<?php echo $invoiceinfo[0]->profile; ?>" alt="" width="50px">
												<?php }else{ ?>
													<img src="<?php echo base_url() ?>/assets/img/user.jpg" alt="" width="50px">
												<?php } ?>
										</td>
										<td><b>Name :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->customer_name ?></td>
										<td><b>Mobile No :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->customer_contact_no ?></td>
										<td><b>Father Name :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->father_name ?></td>
										<td><b>Village :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->village ?></td>
										<td><b>Post Office :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->postoffice ?></td>
									</tr>
									<tr>
										<td><b>Tana :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->police_station ?></td>
										<td><b>District	 :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->district ?></td>
										<td></td>
									</tr>
								</table>

								<div class="col-md-12"><h3>Product Info</h3></div>
								<table class="table table-primary">
									<tr>
										<td><b>Name :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->product_name ?></td>
										<td><b>PRICE :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->price ?></td>
										<td>
											<b>DISCOUNT :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->discount ?>
											<input type="hidden" id="saleid" value="<?php echo $invoiceinfo[0]->sid ?>">
										</td>
									</tr>
								</table>
								
								<div class="col-md-12 text-right">
									<br>
									<?php if($invoiceinfo[0]->totalkisti>0){ ?>
										<a href="<?php echo base_url().'sale/paymentnow/'.$invoiceinfo[0]->sid ?>" class="btn btn-success">Payment now</a>
									<?php }else{ ?>
										<a href="" class="btn btn-success" disabled>Payment now</a>
									<?php } ?>
									<a href="<?php echo base_url().'sale/increase/'.$invoiceinfo[0]->sid ?>" class="btn btn-success">Increase Or Decrease Installment</a>
								</div>

								<?php if (isset($paymentnow)): ?>
									<div class="col-md-12">
									<br>
									<b>Previous Installment Due: <?php echo sprintf('%0.2f',$invoiceinfo[0]->totaldue+$invoiceinfo[0]->totalinterest-$invoiceinfo[0]->permonthpay*$invoiceinfo[0]->totalkisti); ?></b>
									<table class="table">
									<?php
										$today=date('Y-m-d');
										$t=0;
										foreach (json_decode($invoiceinfo[0]->alldate) as $i => $value):
										if($today>$value){
											$date1=date_create($value);
											$date2=date_create($today);
											$diff=date_diff($date1,$date2);
											$t=$diff->format("%a");
										}else{
											$t=0;
										}
									?>
										
											<tr>
												
												<td style="width: 15%;" class="text-left">
													<b>Date :</b> 
														<?php echo $value ?>
												</td>
												<td style="width: 15%;" class="text-left">
													<b>Payment :</b> <?php if(isset($invoiceinfo[0]->sid))echo $invoiceinfo[0]->permonthpay ;  ?>
												</td>
												<td style="width: 10%;" class="text-left">
													<b>Late :</b> <?php if($t>0) echo $t ?> days
												</td>
													
												<td style="width: 40%;">
														<b></b> <?php $am =0; if($t>0) $am=($invoiceinfo[0]->permonthpay*$perdaylatecost->pardayrate)/100; $am=$am/365;$am=$am*$t; ?>
													<form style="margin: auto;margin: 0px;"  action="<?php echo base_url().'sale/installmentsubmit/'.$invoiceinfo[0]->sid ?>">
														Late fee :
														<?php if ($i==0){ ?>
															<input id="latef" onblur="latefeecalculate()" style="width: 70px;" name="munisefee" type="text" value="<?php echo number_format((float)$am, 2, '.', '') ?>">
														<?php }else{ ?>
															<input style="width: 70px;" name="munisefee" type="text" value="<?php echo number_format((float)$am, 2, '.', '') ?>" disabled>
														<?php } ?>
														<input type="hidden" id="datadddddddd" value="<?php echo $invoiceinfo[0]->sid ?>">
														<?php if ($i==0){ ?>
															<input type="hidden" id="permonthpaydd" value="<?php echo $invoiceinfo[0]->permonthpay ?>">
															Total: <input id="amount" name="amount" style="width: 100px;" type="text" value="<?php echo number_format((float)($am)+$invoiceinfo[0]->permonthpay, 2, '.', ''); ?>" >
														<?php }else{ ?>
														Total: <input name="amount" style="width: 100px;" type="text" value="<?php echo number_format((float)($am)+$invoiceinfo[0]->permonthpay, 2, '.', ''); ?>" disabled>
														<?php } ?>
														<?php if ($i==0){ ?>
															<input type="submit" id="	" onclick="return confirm('Are you sure??')">
														<?php }else{ ?>
															<input type="submit" disabled>
														<?php }?>
													</form>
												</td>
											</tr>
									<?php endforeach ?>
									</table>
									</div>
								<?php endif ?>
								<?php if (isset($increaseordecrease)): ?>
									<div class="col-md-12 text-center">
									<br>
									<input v-model="month" autocomplete="off" type="text" name="month" placeholder="Enter month" style="padding: 15px;">
									<div v-if="month" >
										  <label><input v-model="withinterest" type="checkbox" value="">Interest</label>
										  <input type="text" v-if="withinterest" v-model="installmentfee" placeholder="Installment fee">
										<br>
				              			<ul v-if="installmentdate" style="text-align: center;list-style: none;">
				              				<li style="display: flex;justify-content: center;" v-for="(i,index) in installmentdate">({{ index+1 }} )  <vuejs-datepicker :format="formatDate" v-model="installmentdate[index]" disabled></vuejs-datepicker> </li>
				              			</ul>
					              	</div>
					              	<button v-if="month==installmentdate.length && isokay" @click.prevent="incressordesressmonth('<?php echo $invoiceinfo[0]->sid ?>')" class="btn btn-success">Submit</button>
					              	<button v-else class="btn btn-success" disabled>Submit</button>
									</div>
									<p class="text-danger" v-if="message">{{ message }}</p>
								<?php endif ?>
							</teble>
						<?php }else{?>
							<?php if (!$this->session->flashdata('success') && $id!=0): ?>

								<h2 class="text-danger">Invoice not found!!!! <?php echo $id; ?> </h2>
								
							<?php endif ?>
						<?php } ?>
					</div>
		        </div>
	      	</div>
	    </div>
    </section>
</div>


