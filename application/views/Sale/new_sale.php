<div class="content-wrapper">
    <section class="content" id="vuejscom"> 
	    <div class="row">
	      	<div class="col-md-12">
		        <form id="product_listing_form">
		        <div class="box">
		            <div class="box-header with-border text-center">
						<h32 class="box-title font-weight-bold">Sale Listing</h2>
							<input type="text" v-model="id" placeholder="invoice id" type="number"> 
					</div>
		            <div class="box-body" style="display: flex;">
						<div  style="width: 50%">

						  <label for="">Product search</label>
						  <multiselect 
							  v-model="selectedCountries" 
							  id="ajax" label="product_name" 
							  track-by="chassisno" 
							  placeholder="Type to search product by Chassis No" 
							  open-direction="bottom" 
							  :options="countries" 
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
							  @search-change="asyncFind">
						    <template slot="tag" slot-scope="{ option, remove }">
						    	<span class="custom__tag"><span>{{ option }}</span>
						    		<span class="custom__remove" @click="remove(option)">❌</span>
						    	</span>
						    </template>
						    <template slot="option" slot-scope="props">
						      <div class="option__desc">
						      	<span class="option__title">{{ props.option.product_name }}</span>
						      	<span class="option__small">(MODEL:{{ props.option.product_model }}) ( Chassis No {{ props.option.chassisno }})</span></div>
						    </template>
						    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
						  </multiselect>
						  <div v-if="selectedCountries!=null && selectedCountries.length!=0">
								<table class="table table-secondary">
									<tr>
										<td><b>Product Name:</b> {{  selectedCountries.product_name }}</td>
										<td colspan="2"><b>Chassis No:</b> {{  selectedCountries.chassisno }}</td>
										<td><b>Engine No:</b> {{  selectedCountries.engineno }}</td>
									</tr>
									<tr>
										<td><b>Color:</b> {{  selectedCountries.color }}</td>
										<td><b>Battery No:</b> {{  selectedCountries.batteryno }}</td>
									</tr>
								</table>
						  </div>
						  	<div>
								<div>
									<label for="">Reference Name</label>
				              		<input type="text" class="form-control" v-model="referencename">
				              	</div>

				              	<div>
									<label for="">Reference Contact Number</label>
				              		<input type="text" class="form-control" v-model="referenccontact">
				              	</div>
								
								<div>
									<label for="">Remarks</label>
				              		<textarea name="" class="form-control" v-model="remarks" id="" cols="10" rows="10"></textarea>
				              	</div>
				              	<div>
									<label for="">Key</label>
				              		<input type="text" class="form-control" v-model="key" placeholder="Number Of Key">
				              	</div>
							</div>
						</div>
						<div style="width: 50%">
							<div>
								<label for="">Customar search</label>
								<div style="display: flex;"> 
							  <multiselect 
							  v-model="selectedcustomar" 
							  id="ajax" label="customer_name" 
							  track-by="customer_name" 
							  placeholder="Type to search customers" 
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
							  <span class="input-group-btn" style="width: 37px;padding: 3px;"><button type="button" data-toggle="modal" data-target="#cModel" class="btn btn-block btn-primary add_unit"><i class="fa fa-plus"></i></button></span>
							  </div>
							  	<div v-if="selectedcustomar!=null && selectedcustomar.length!=0">
									<table class="table table-secondary">
										<tr>
											<td><b>Customar Name:</b> {{  selectedcustomar.customer_name }}</td>
											<td><b>Contact No:</b> {{  selectedcustomar.customer_contact_no }}</td>
											
										</tr>
										<tr>
											<td><b>Village:</b> {{  selectedcustomar.village }}</td>
											<td><b>Post Office:</b> {{  selectedcustomar.postoffice }}</td>
											
										</tr>
										<tr>
											<td><b>Father Name:</b> {{  selectedcustomar.father_name }}</td>
											<td colspan="2"><b>Tana:</b> {{  selectedcustomar.police_station }}</td>
										</tr>
									</table>
								</div>
							</div>

							<div>
								<div class="col-md-6">
								
									
									<div>
										<label for="">Installment Fee</label>
				              			<input style="text-align: right;" type="number" class="form-control custom_form_control installmentfee" v-model="installmentfee" id="installmentfee" @blur="changefinalamountaextrafee" placeholder="Installment Fee" autocomplete="off" required>
									</div>
									
									<div style="display: flex;">
										<div>
											<label for="">Month</label>
					              			<input type="number" class="form-control custom_form_control month" min="1" v-model="month" @blur="calculateinterast" id="month" name="" placeholder="Month" autocomplete="off" required>
										</div>
					              		<div class="checkbox" style="margin-top: 30px;margin-left: 10px;">
										  <label><input v-model="check" type="checkbox" value="">Interest</label>
										</div>
									</div>
				              		<br>

				              		<div>
				              			<div v-if="month" >
						             		<table class="table" v-if="installmentdate">
						             			<tr v-for="(i,index) in installmentdate">
						             				<td width="25%">{{ index+1 }}</td>
						             				<td width="40%">{{ installmentdate[index] }}</td>
						             				<td width="35%">{{ parmanthpay }}</td>
						             			</tr>
						             		</table>
						              	</div>
				              		</div>

								</div>

								<div class="col-md-6">
									<div>
										<label for="">Price</label>
					              		<input style="text-align: right;" type="number" class="form-control custom_form_control price" v-model="price" id="price" name="" placeholder="Price" autocomplete="off" required disabled>
					              		<br>
									</div>

									<div>
										<label for="">Discount</label>
					              		<input style="text-align: right;" type="number" class="form-control custom_form_control discount" v-model="discount" @blur="changefinalamount" id="discount" name="" placeholder="Discount" autocomplete="off" required>
					              		<br>
									</div>

									<div>
										<label for="">Screch card</label>
					              		<input style="text-align: right;" type="number" class="form-control custom_form_control screchcard" v-model="screchcard" @blur="changefinalamounts" id="screchcard" name="" placeholder="Screch Card" autocomplete="off" required>
					              		<br>
									</div>
									
									<div>
										<label for="">Advance pay</label>
					              		<input style="text-align: right;" type="number" class="form-control custom_form_control advancepay" v-model="advancepay" @blur="changefinalamounta" id="advancepay" name="" placeholder="Advance pay" autocomplete="off" required>
					              		<br>
									</div>

									<div>
										<label for="">Final Amount</label>
					              		<input type="number" class="form-control custom_form_control finalamount" v-model="finalamount" id="finalamount" name="" placeholder="Final amount" autocomplete="off" required disabled style="text-align: right;font-weight: 700;">
					              		<br>
									</div>

									<div>
										<table class="table"  v-if="month">
					              			<tr>
							                  <td style="vertical-align: middle;">Total Due: </td>
							                  <td>
							                    <input style="text-align: right;width: 70%;" type="text" class="form-control sale_input_custom_styl align_right" v-model="finalamount" id="total" placeholder="Total" disabled="">
							                  </td>
							                </tr>
							                	<tr>
							                  <td style="vertical-align: middle;">Total Interest: </td>
							                  <td>
							                    <input style="text-align: right;width: 70%;" type="text" class="form-control sale_input_custom_styl align_right" v-model="totalintrast" id="total" placeholder="Total" disabled="">
							                  </td>
							                </tr>
							                	<tr>
							                  <td style="vertical-align: middle;">Per Month Pay: </td>
							                  <td>
							                    <input style="text-align: right;width: 70%;" type="text" class="form-control sale_input_custom_styl align_right" v-model="parmanthpay" id="total" placeholder="Total" disabled="">
							                  </td>
							                </tr>
							                	<tr>
							                  <td style="vertical-align: middle;">Date: </td>
							                  <td>
							                    <input type="date" style="width: 85%;" class="form-control sale_input_custom_styl align_right" v-model="data" id="date" placeholder="Total">
							                  </td>
							                </tr>
					              		</table>
				              		</div>
				              	</div>

				              	<div class="col-md-3" style="display: none;">
				              		<input type="number" class="form-control custom_form_control quantity" v-model="quantity" id="quantity" name="" placeholder="Quantity" autocomplete="off" required disabled>
				              	</div>
				            </div>
			            </div>
		            </div>

		            <div class="box-footer">
	      			<div class="selebutton" style="display: flex;justify-content: center;">
	      				<div>
							<button  v-if="selectedCountries && selectedCountries.product_id && month==installmentdate.length && selectedCountries && selectedcustomar.customer_id" type="button" @click="submit" class="btn btn-success" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Sale</button>

							<button v-else type="button" @click="submit" class="btn btn-success" name="search_random" id="submit" disabled><i class="fa fa-fw fa-save"></i> Sale</button>

						</div>
						<div>
								<button type="reset" id="reset" class="btn btn-danger btn_for_sale style"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
						<div>
							<button type="button" class="btn btn-primary btn_for_sale style2" @click="print" id="credit_sale" v-if="id">Print Invoice</button>

						</div>	
						<div>
							<button type="button" class="btn btn-primary btn_for_sale style2" @click="printmoneyrecopt" id="credit_sale" v-if="id">Print Money Recipt</button>
						</div>
					</div>
	  			</div>
		        </div>
		              	</form>

	      	</div>
	      	<div class="col-md-12" style="display: none;">
				<table class="table table-secondary">
              		<tr class="bg-aqua color-palette">
              			<td>
              				SL No
              			</td>
						<td>
              				Name
              			</td>
              			<td>
              				Stock
              			</td>
              			<td>
              				QTY
              			</td>
						<td>
              				Sale
              			</td>
              			<td>
              				Total
              			</td>
              			<td>
              				 <i class="fa fa-fw fa-wrench"></i>
              			</td>
              		</tr>
              		<tr>
              			<td colspan="6">{{ selldata }}</td>
              		</tr>
				</table>
	      	</div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="cModel" tabindex="-1" role="dialog" aria-labelledby="cModelLabel" aria-hidden="true">
    <form id="customer" action="<?php echo base_url();?>customer/create" method="post" class="form-horizontal" enctype="multipart/form-data">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="cModelLabel">Create a new customer</h3>
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

							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Customer id</label>
								<input type="number" name="id" class="form-control" placeholder="Customar id">
							</div>

						

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


