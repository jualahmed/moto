<div class="content-wrapper" id="vue_app">
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Income Report</h3>
          </div>
          <div class="box-body">
            <form action ="<?php echo base_url();?>Report/installment_report_response" class="form-horizontal" method="post" enctype="multipart/form-data" id="salereport" autocomplete="off">
              <div class="form-group">

                <label for="inputEmail3" class="col-sm-1 control-label">Start</label>
                <div class="col-sm-2">
                  <input type="text" name="start_date" class="form-control" id="datepickerrr" placeholder="<?php echo $bd_date ?>">
                </div>
                <label for="inputEmail3" class="col-sm-1 control-label">End</label>
                <div class="col-sm-2">
                  <input type="text" name="end_date" class="form-control" id="datepicker" placeholder="<?php echo $bd_date ?>">
                </div>
                <div class="col-sm-6 mt-2">
                  <button @click.prevent="result" type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
                  <button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
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
    <div class="table-responsive" v-if="alldata.length">          
      <table class="table">
        <thead>
          <tr>
            <th style="text-align: center;">NO</th>
            <th style="text-align: center;">Date</th>
            <th style="text-align: center;">Customer ID</th>
            <th>Customer Name</th>
            <th>Income Type</th>
            <th style="text-align: right;">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(i,index) in alldata">
            <td align="center">{{ index+1 }}</td>
            <td align="center">{{ formatDate(i.dddddd) }}</td>
            <td align="center">{{ i.customer_id }}</td>
            <td>{{ i.customer_name }}</td>
            <th>{{ i.transaction_purpose }}</th>
            <th style="text-align: right;">{{ i.amount }}</th>
          </tr>
          <tr>
            <td colspan="5"></td>
            <td style="text-align: right;"><b>Total: {{ amount }}</b></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <h2 class="text-danger text-center">Result is Empty</h2>
    </div>
  </section>
</div>
