<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
  	<link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/printstyle.css" type="text/css"/>
	<link href="https://fonts.maateen.me/solaiman-lipi/font.css" rel="stylesheet">
	<style>
		*{
			font-family: 'SolaimanLipi', Arial, sans-serif !important;
		}
		.img{
			position: absolute;
		    left: 25%;
		    opacity: .15;
		    top: 0%;
		    width: 50%;
		}
	</style>
</head>
<body> 

	 	<div id ="main_invoice" style="width: 700px; margin: auto;">
			<div id = "invoice"  style="width: 698px;">
				<div id="shop_title_box"  style="width: 698px;">			
						<img style="width: 698px;" src="<?php echo base_url();?>images/common.jpg" height="101px">
						<table class="table table-secondary">
								<tr>
							<td colspan="4" align="center"><b><span style="font-size: 20px;">প্রোপ্রাইটর : প্রদীপ কান্তি দে (নির্মল) </span> </b><br>ইমেইল : internationalsuprova2019pd@gmail.com </td>
						</tr>
							<tr align="center">
								<th align="center" style="width: 33.33%;"><h4 style="text-align: left;">রশিদ নং : <b><?php echo $this->bangla_ntw->engToBn($single->id); ?></b></h4></th>
								<th align="center" style="padding-top: 10px;width: 33.333333333%;"><h4 style="text-align: center;    margin-top: 4px;
    margin-bottom: 4px;">তারিখ : <b><?php echo  $this->bangla_ntw->engToBn(date("d-m-Y", strtotime($single->created_at))); ?></b></h4></th>
							</tr>
						</table>
				</div> <!--end of shop_title_box-->
				<div id = "invoice_details_header" style="width: 699px;">	
					<table class="customers" style="width: 100%;">	
					<tr>
						<th colspan="6" style="text-align: center;padding: 2px;"><h4><b>গ্রাহকের বিবরণ</b></h4></th>
					</tr>
						<tr>
							<td align="center" rowspan="5">
								<?php if($single->profile){ ?>
									<img src="<?php echo $single->profile; ?>" alt="" width="50px">
								<?php }else{ ?>
									<img src="<?php echo base_url() ?>/assets/img/user.jpg" alt="" width="50px">
								<?php } ?>
							</td>
							<td ><b>নাম :</b> <?php echo $single->customer_name; ?></td>
							<td ><b>আইডি :</b> <?php echo $this->bangla_ntw->engToBn($single->customer_id); ?></td>	
						</tr>
						<tr >
							<td style="width: 55%;"><b>পিতার নাম :</b> <?php echo $single->father_name; ?></td>
							<td ><b>মোবাইল নং :</b> <?php echo $this->bangla_ntw->engToBn($single->customer_contact_no); ?></td>
						</tr>
						<tr>
							<td ><b>গ্রাম :</b> <?php echo $single->village; ?></td>
							<td ><b>ডাক :</b> <?php echo $single->postoffice; ?></td>
						</tr>	
						<tr>
							<td ><b>থানা :</b> <?php echo $single->police_station; ?></td>
							<td ><b>জেলা :</b> <?php echo $single->district; ?></td>
						</tr>
					</table>	
				</div> <!--end of invoice_details_header-->
				
			
				<div style="width:100%;margin:0px auto;float:left;border-right: 0px solid #ddd;">
					<table class="customers">
						<tr>
						<th colspan="4" style="text-align: center;padding: 5px;"><h4><b>পণ্যের বিবরণ</b></h4></th>
					</tr>
						<tr>
							<td colspan="2" style="text-align:left;">
								<b>মডেল : </b><?php
									echo $single->product_name;
								?>
							</td>
							
						</tr>
						
						<tr>
							
									<table class="table" style="padding: 0px;margin:0px;border: none;">
									<tr>
										<td align="left">
											
											<p style="font-size: 15px;"><b>জমা :</b> </p>
										</td>
										<td align="right">
											
											<p><?php echo $this->bangla_ntw->engToBn(sprintf('%0.2f',($single->amount))); ?></p>
										
										</td>
									</tr>
								</table>
							</th>
						</tr>
					</table>	
				</div>
			
				<div id = "transaction_details">
					
					<div id = "signature_area" style="width: 698px;display: flex;padding-top: 50px;">	
						<div id = "signature_one"  style="width:250px;text-align: center;margin: auto;">
						<div class = "customer_signature"> <b>ক্রেতার স্বাক্ষর </b>	</div>
					</div>
					<div id = "signature_one" style="width:250px;text-align: center;margin: auto;"></div>
					<div id = "signature_one" style="margin-right: auto;width:250px;    margin: auto;    text-align: center;"> 
						<div class = "customer_signature2"> <b>বিক্রেতার স্বাক্ষর</b> </div>
					</div>
					</div>

					<div class ="pos_top_header_fotter" style="margin-top:5px;line-height: 16px;width: 100%;float: left;text-align: center;font-size: 12px;"> Thank You For Being With Us.</div>
					<div style="width: 100%; height: 1px; float:left;"> </div>
				
					<div class ="pos_top_header_fotter" style="background:;line-height:14px;float: left;text-align: center;width: 100%;font-size: 12px;">Software Developed By: <b>IT Lab Solutions Ltd.</b> Call: +88 018 4248 5222</div>
			
				</div> <!--end of invoice-->
			</div>
		<img class="img" src="<?php echo base_url()?>images/suprobha-logo.jpg" alt="">
			
		</div>

	</body>
</html>	