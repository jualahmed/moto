<div class="content-wrapper" id="vueapp">
	<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Motorcycle Stock Report</h3>
            <h3 class="box-title"> ( Total Stock Amount: <?php echo sprintf("%.2f",$total_stock_price);?> )</h3>
            <h3 class="box-title"> ( Stock Quantity: <?php echo $total_stock_quantity;?> )</h3>
          </div>
          <div class="box-body">
            <form action ="<?php echo base_url();?>Report/stock_details_json" class="form-horizontal" method="post" id="form_2" autocomplete="off">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-1 control-label">Product</label>
                <div class="col-sm-2">
                  <select name="product_id" class="form-control" v-model="product_id">
                    <option value="0">Select a Product</option>
                    <?php foreach ($product as $key => $value): ?>
                      <option value="<?php echo $value->product_id ?>"><?php echo $value->product_name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-success btn-sm" @click.prevent="stockreport" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
                  <button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
                  <a href="<?php echo base_url() ?>Report/stock_details_print" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration: none;"><i class="fa fa-download"></i> Download</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  	<div class="table-responsive">
  		<table class="table table-secondary">
    		<tr>
    		    <th style="text-align: center;">No</th>
            <th style="text-align: center;">Challan No</th>
    		    <th style="text-align: center;">Date</th>
            <th title="Purchase Quantity">Quantity</th>
    		    <th style="text-align: center;">engineno</th>
    		    <th style="text-align: center;">chassisno</th>
    		    <th style="text-align: center;">color</th>
    		    <th style="text-align: right">BP</th>
    		    <th style="text-align: right">SP</th>
            <th style="text-align: center;">Company</th>
            <th style="text-align: center;">Category</th>
    		    <th style="text-align: center;">batteryno</th>
            <th style="text-align: center;">Product</th>
    		</tr>
  			<tr v-for="(p,index) in alldata" style="text-align: center;">
  				<td>{{ index+1 }}</td>
            <td>{{ p.challan_no }}</td>
  			    <td>{{ p.purchase_date }}</td>
  			   
            <td title="Purchase Quantity">1</td>
            <td>{{ p.engineno }}</td>
            <td>{{ p.chassisno }}</td>
            <td>{{ p.color }}</td>
            <td style="text-align: right">{{ p.purchase_price }}</td>
            <td style="text-align: right">{{ p.sale_price }}</td>

  			    <td>{{ p.company_name }}</td>
  			    <td>{{ p.catagory_name }}</td>
  			    <td>{{ p.batteryno }}</td>
            <td>{{ p.product_name }}</td>
  			</tr>
  			<tr>
  				<td colspan="3"><b></b></td>
  				<td colspan="1"><b>Total Quantity: {{ stockqty }}</b></td>
          <td colspan="3"><b></b></td>
  				<td colspan="1"><b>Total Amount: {{ samount }}</b></td>
  				<td colspan="1"><b>Total Sale Amount: {{ amount }}</b></td>
  			</tr>
  	  </table>
  	</div>
  </section>
</div>
