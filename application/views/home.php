<div class="content-wrapper">
	<section class="content">
		<div class="text-right">
			<!-- <a href="<?php echo base_url().'admin/allsmssend' ?>" class="btn btn-success">Send sms</a> -->
			<br>
			<br>
		</div>
		<?php if ($messsage): ?>
			<h3 id="messsages" class="text-success"><?php echo $messsage; ?></h3>
		<?php endif ?>
		<?php if ($alltodayinstallment->num_rows()>0): ?>
			<table class="table">
				<tr>
					<th>Invoice id</th>
					<th>Customer</th>
					<th>Phone</th>
					<th>Installment No</th>
					<th>Amount</th>
					<th>Action</th>
				</tr>
				<?php foreach ($alltodayinstallment->result() as $key => $var): ?>
					<tr>
						<td><?php echo $var->id ?></td>
						<td><?php echo $var->customer_name ?></td>
						<td><?php echo $var->customer_contact_no ?></td>
						<td><?php echo ($var->month-$var->totalkisti)+1 ?></td>
						<td><?php echo $var->amount ?></td>
						<td><a onclick="sendsms('<?php echo $var->all_installment_id; ?>' , '<?php echo ($var->month-$var->totalkisti)+1; ?>')" class="btn btn-sm btn-success">Send sms</a></td>
					</tr>
				<?php endforeach ?>
			</table>
		<?php else: ?>
			<?php echo "Do not have any installment today"; ?>
		<?php endif ?>

	</section>
</div>
