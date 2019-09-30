


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
			 <div class="row">
	<div style="width:50%;margin:auto;">
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Debit / Inword</h3></center>
		</div>
		<table class="simpleTable" style="width:98%;">
			<thead>
				<tr class="tableRowBG">
					<th colspan="3">Date</th>
					<th colspan="3">Particular</th>
					<th colspan="3" style="text-align:right;">Amount</th>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$total_credit =0.00;
			foreach($credit as $field):
			?>
				<tr>
					<th colspan="3"> <?php echo $field['date']; ?>  </th>
					<th colspan="3"> <?php echo $field['transaction_purpose']; ?>  </th>
					<th colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field['amount']); ?> </th>
					<?php $total_credit += $field['amount'];?>
				</tr>
			<?php
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<th colspan="3"></th>
					<th colspan="3">Total</th>
					<th colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_credit); ?> </th>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width:50%;margin:auto;">
		<div class="box-header with-border" style="background: #bbbfc1;">
			<center><h3 class="box-title" style="text-align:center;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:noraml;">Credit / Outword</h3></center>
		</div>
		<table class="simpleTable" style="width:100%;">
			<thead>
				<tr class="tableRowBG">
					<th colspan="3">Date</th>
					<th colspan="3">Particular</th>
					<th colspan="3" style="text-align:right;">Amount</th>
				</tr>
			</thead>	
			<tbody>	
			<?php
			$total_debit =0.00;
			foreach($debit as $field2):
			?>
				<tr>
					<th colspan="3"> <?php echo $field2['date']; ?>  </th>
					<th colspan="3"> <?php echo $field2['transaction_purpose']; ?><br> <?php echo $field2['type_type']; ?> </th>
					<th colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$field2['amount']); ?> </th>
					<?php $total_debit += $field2['amount'];?>
				</tr>
			<?php
				endforeach;
				
			?>
				<tr class="tableRowBG">
					<th colspan="3"></th>
					<th colspan="3">Total</th>
					<th colspan="3" style="text-align:right;"> <?php echo sprintf('%0.2f',$total_debit); ?> </th>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row" style="width:20%;margin:auto;">
	<h3 class="pageTitleSmall" style="margin:20px 0 5px 0;"> Summary </h3>
	<table class="simpleTable" style="margin-top:20px;">
		<thead>
			<tr class="tableRowBG">
				<th colspan="3" style="text-align:center;">Date Duration</th>
				<th colspan="3" style="text-align:center;">Total Balance</th>
			</tr>
		</thead>	
		<tbody>	
			<tr>
				<th colspan="3" style="text-align:center;"> <?php echo $this->uri->segment(3) .'- -'. $this->uri->segment(4); ?>  </th>
				<th colspan="3" style="text-align:center;"> <?php echo sprintf('%0.2f',$total_credit - $total_debit); ?>  </th>
			</tr>
		</tbody>
	</table>
</div>
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
