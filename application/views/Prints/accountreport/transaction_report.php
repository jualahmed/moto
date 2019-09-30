



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
			<section class="content-3" id="infomsg">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="box">	 
				<div class="box-body">
			
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</h3></center></div>
						<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
							<?php if(isset($transaction2)) foreach ($transaction2 as $key => $var):  ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['customer_name']; ?></td>
								  <td style="width:4%;">Sale</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
						</table>
						<div class="inner_table">
							<table id="output_sale">
							</table>
						</div>
						<table class="head" id="output_sale_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Collection</h3></center></div>
						<table class="head">

							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							<?php if(isset($transaction)) foreach ($transaction as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['customer_name']; ?></td>
								  <td style="width:4%;">Collection</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
							
						</table>
						<div class="inner_table">
							<table id="output_collection">
							</table>
						</div>
						<table class="head" id="output_collection_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Credit Collection</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>

							<?php if(isset($transaction3)) foreach ($transaction3 as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['customer_name']; ?></td>
								  <td style="width:4%;">Collection</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
							
						</table>
						<div class="inner_table">
							<table id="output_credit_collection">
							</table>
						</div>
						<table class="head" id="output_credit_collection_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							<?php if(isset($transaction4)) foreach ($transaction4 as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['distributor_name']; ?></td>
								  <td style="width:4%;">Purchase</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
						</table>
						<div class="inner_table">
							<table id="output_purchase">
							</table>
						</div>
						<table class="head" id="output_purchase_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Payment</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>

							<?php if(isset($transaction5)) foreach ($transaction5 as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['distributor_name']; ?></td>
								  <td style="width:4%;">Purchase</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
							
						</table>
						<div class="inner_table">
							<table id="output_purchase_payment">
							</table>
						</div>
						<table class="head" id="output_purchase_payment_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>


							<?php if(isset($transaction6)) foreach ($transaction6 as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['customer_name']; ?></td>
								  <td style="width:4%;">Purchase</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
							
						</table>
						<div class="inner_table">
							<table id="output_expense">
							</table>
						</div>
						<table class="head" id="output_expense_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense Payment</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>


							<?php if(isset($transaction7)) foreach ($transaction7 as $key => $var): ?>
								<tr>
								  <td style="width:4%;"><?php echo $key+1 ?></td>
								  <td style="width:4%;"><?php echo $var['date'] ?></td>
								  <td style="width:4%;"><?php echo $var['customer_name']; ?></td>
								  <td style="width:4%;">Purchase</td>
								  <td style="width:4%;"><?php echo $var['remarks']; ?></td>
								  <td style="width: 4%;text-align:right;"><?php echo($var['amount']); ?></td>
								</tr>
							<?php endforeach ?>
							
						</table>
						<div class="inner_table">
							<table id="output_expense_payment">
							</table>
						</div>
						<table class="head" id="output_expense_payment_sum">
						</table>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>	
</section>

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
