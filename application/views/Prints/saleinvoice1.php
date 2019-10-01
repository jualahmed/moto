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
		    left: -2%;
		    opacity: .15;
		    top: 12%;
		    width: 100%;
		}
	</style>
</head>
<body> 
	<?php 
		$this->load->config('custom_config'); 
		$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
	?>
 	<div id ="main_invoice" style="width: 700px; margin: auto;">
		<div id = "invoice"  style="width: 698px;">
			<div id="shop_title_box"  style="width: 698px;">			
					<img style="width: 698px;" src="<?php echo base_url();?>images/common.jpg" height="101px">
					<table class="table" style="margin-bottom: 0px;">
						<tr >
							<td style="padding: 3px;" colspan="4" align="center"><b><span style="font-size: 20px;">প্রোপ্রাইটর : প্রদীপ কান্তি দে (নির্মল) </span> </b><br>ইমেইল : internationalsuprova2019pd@gmail.com </td>
						</tr>
						<tr align="center" style="padding: 0px;margin: 0px;">
							<th align="center" style="padding: 0px;width: 33.333333333%;"><h4 style="text-align: left;    margin-top: 4px;
    margin-bottom: 4px;">বিক্রয় রশিদ নং : <b><?php echo  $this->bangla_ntw->engToBn($all[0]->sid); ?></b></h4></th>
							<th align="center" style="padding: 0px;width: 33.333333333%;"><h4 style="text-align: center;    margin-top: 4px;
    margin-bottom: 4px;">তারিখ : <b><?php echo  $this->bangla_ntw->engToBn(date("d-m-Y", strtotime($all[0]->date))); ?></b></h4></th>
							<th align="center" style="padding: 0px;width: 33.333333333%;"><h4 style="text-align: right;    margin-top: 4px;
    margin-bottom: 4px;">প্রস্তুত কারক : <b><?php echo $all[0]->user_full_name; ?></b></h4></th>
						</tr>
					</table>
			</div> <!--end of shop_title_box-->
			<div  style="width: 699px;">	
				<table class="customers" style="width: 100%;">
					<tr>
						<th colspan="6" style="text-align: center;padding: 2px;"><h4 style="padding: 0px;margin: 4px;"><b>গ্রাহকের বিবরণ</b></h4></th>
					</tr>
					<tr>
						<td align="center" rowspan="5">
							<?php if($all[0]->profile){ ?>
								<img src="<?php echo $all[0]->profile; ?>" alt="" width="50px">
							<?php }else{ ?>
								<img src="<?php echo base_url() ?>/assets/img/user.jpg" alt="" width="50px">
							<?php } ?>
						</td>
						<td colspan="2" style="padding: 1px 3px;"><b>নাম :</b> <?php echo $all[0]->customer_name; ?></td>
						<td colspan="2" style="padding: 1px 3px;"><b>আইডি</b> : <?php echo $this->bangla_ntw->engToBn($all[0]->customer_id); ?></td>	
					</tr>
					<tr>
						<td colspan="2" style="padding: 1px 3px;"><b>পিতার নাম : </b><?php echo $all[0]->father_name; ?></td>
						<td colspan="2" style="padding: 1px 3px;"><b>মোবাইল নং :</b> <?php echo  $this->bangla_ntw->engToBn($all[0]->customer_contact_no); ?></td>
					</tr>
					<tr>
						<td colspan="2" style="padding: 1px 3px;"><b>গ্রাম :</b> <?php echo $all[0]->village; ?></td>
						<td colspan="2" style="padding: 1px 3px;"><b>ডাক :</b> <?php echo $all[0]->postoffice; ?></td>
					</tr>
					<tr>
						<td colspan="2" style="padding: 1px 3px;"><b>থানা : </b><?php echo $all[0]->police_station; ?></td>
						<td colspan="2" style="padding: 1px 3px;"><b>জেলা :</b> <?php echo $all[0]->district; ?></td>
					</tr>
					<tr>
						<td colspan="3" style="padding: 1px 3px;"><b>রেফারেন্স নাম </b>: <?php echo $all[0]->referencename; ?></td>
						<td colspan="2" style="padding: 1px 3px;"><b>রেফারেন্স মোবাইল নং</b> : <?php echo $this->bangla_ntw->engToBn($all[0]->referenccontact); ?></td>
					</tr>					
				</table>	
			</div> <!--end of invoice_details_header-->
			<div style="width:100%;margin:0px auto;float:left;">
				<table class="customers">	
					<tr>
						<th colspan="4" style="text-align: center;padding: 5px;"><h4 style="padding: 0px;margin: 4px;"><b>পণ্যের বিবরণ</b></h4></th>
					</tr>
					<tr>
						<td colspan="2" style="padding: 1px 3px;">
							<b>মডেল : <?php echo $all[0]->product_name; ?></b>
						</td>
						<td style="text-align:left;width: 10px; padding: 1px 3px;">
							কালার : <b><?php echo $all[0]->color ?></b>
						</td>
					</tr>
					<tr>
						<td style="padding: 1px 3px;">
							ইঞ্জিন নং : <b> <?php echo $all[0]->engineno ?></b>
						</td>
						<td style="padding: 1px 3px;">
							চেসিস নং : <b> <?php echo $all[0]->chassisno ?></b>
						</td>
						<td style="padding: 1px 3px;">
							ব্যাটারী নং : <b> <?php echo $all[0]->batteryno ?></b>
						</td>
					</tr>
					<tr>
						<th colspan="4" style="text-align: center;padding: 5px;"><h4 style="padding: 0px;margin: 4px;"><b>লেনদেনের বিবরণ</b></h4></th>
					</tr>
					<tr style="height: 300px;">
						<th width="30%"><?php echo $all[0]->remarks ?></th>
						<th width="40%" style="padding: 3px 3px;">
							<b><p style="text-align: center;">মোট কিস্তি : <?php echo  $this->bangla_ntw->engToBn($all[0]->totalkisti); ?> টি</p></b>
							<table class="table" style="padding: 0px;margin: 0px;list-style: none;">
								<tr>
									<th style="text-align: center;padding: 3px;"><b>কিস্তি নং </b></th>
									<th style="text-align: center;padding: 3px;"><b>তারিখ </b></th>
									<th style="text-align: center;padding: 3px;"><b>টাকা </b></th>
								</tr>
								<?php if($all[0]->alldate!="null") foreach (json_decode($all[0]->alldate) as $key => $value): ?>
									<tr>
										<td style="padding: 1px 5px;"><?php if(10>$key+1)echo '০'; echo $this->bangla_ntw->engToBn($key+1) ?></td>
										<td style="padding: 1px 5px;" align="center"><?php echo  $this->bangla_ntw->engToBn(date("d-m-Y", strtotime($value))) ?></td>
										<td style="padding: 1px 5px;" align="right"><?php echo $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->permonthpay)) ?></td>
									</tr>
								<?php endforeach ?>
							</table>
						</th>
						<th width="30%" style="position: relative;">
							<table class="table" style="padding: 0px;margin:0px;border: none;">
								<tr>
									<td>
										<p><b>বিক্রয় মূল্য :</b></p>
										<p style="font-size: 15px;"><b>নগদ জমা :</b> </p>
										<p style="font-size: 15px;"><b>বকেয়া :</b></p>
									    <p><b>ডিসকাউন্ট : ( - )</b> </p>
										<p style="width: 103px;"><b><b>স্ক্রার্চ কার্ড</b> : ( - )</b></p>
									</td>
									<td align="right" style="font-size: 15px;">
										<b>
											<p><?php echo  $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->price+$all[0]->totalinterastlog+$all[0]->installmentfee)); ?></p>
											<p><?php echo  $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->advancepay)); ?></p>
											<p><?php echo  $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->totaldue+$all[0]->totalinterest)); ?></p>
											<p><?php echo  $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->discount)); ?></p>
											<p><?php echo  $this->bangla_ntw->engToBn(sprintf('%0.2f',$all[0]->screchcard)); ?></p>
										</b>
									</td>
								</tr>
							
							</table>

							<table class="table" style="padding: 0px;margin:0px;border: none;position: absolute; bottom: 0px; width: 98%;">
								<tr>
									<td style="font-size: 20px;text-align: center;"> <p><b>মোট :</b> </p></td>
									<td align="right" style="font-size: 20px;"><p><b><?php echo $this->bangla_ntw->engToBn(sprintf('%0.2f',($all[0]->totaldue+$all[0]->totalinterest))); ?></b></p></td>
								</tr>
							</table>
						</th>
					</tr>
					
					<tr>
						<td colspan="3" style="text-align: right;font-size: 18px;"><b>
							<?php 
							$v=$all[0]->totaldue+$all[0]->totalinterest;
							$a= (int) $v; 
							if($a==$v) 
							{ 
								echo $this->bangla_ntw->numToWord(sprintf('%0.2f',$a));
							}else{ 
								echo $this->bangla_ntw->numToWord(sprintf('%0.2f',$v));
							} ?> টাকা মাত্র</b></td>
					</tr>
					<tr>
						<td colspan="3"><p style="margin: -1px;">উক্ত মোটরসাইকেল এর সাথে টুলস বক্স, চাবি <b><?php echo $this->bangla_ntw->engToBn($all[0]->key) ?></b> টি, আটটি কুপন সহ একটি সার্ভিস ওয়ারেন্টি বই, একটি ডকুমেন্ট কভার সহ মোটরসাইকেল ক্রেতার নিকট বুঝাইয়া দেওয়া হইলো। </p></td>
					</tr>
					<tr>
						<td colspan="3"> <b>বি : দ্র : </b> বকেয়া টাকা পরিশোধ হওয়ার পর বিক্রয় রশিদ বুঝে নিন, অন্যথায় কর্তৃপক্ষ দায়ী নয়।</td>
					</tr>
				</table>	
			</div>
			
			<div id = "transaction_details">
				<div id = "signature_area" style="width: 698px;display: flex;padding-top: 50px;">	
					<div id = "signature_one"  style="width:250px;text-align: center;margin: auto;">
						<div class = "customer_signature"> <b>ক্রেতার স্বাক্ষর </b>	</div>
					</div>
					<div id = "signature_one" style="width:250px;text-align: center;margin: -16px 0px;">
						<img src="<?php echo base_url().'images/uttora.jpg' ?>" alt="" style="width: 64px;">
					</div>
					<div id = "signature_one" style="margin-right: auto;width:250px;    margin: auto;    text-align: center;"> 
						<div class = "customer_signature2"> <b>বিক্রেতার স্বাক্ষর</b> </div>
					</div>
				</div>
				<div class ="pos_top_header_fotter" style="margin-top: 5px;line-height: 16px;width: 100%;float: left;text-align: center;font-size: 12px;"> Thank You For Being With Us.</div>
				<div style="width: 100%; height: 1px; float:left;"> </div>
			
				<div class ="pos_top_header_fotter" style="background:;line-height:14px;float: left;text-align: center;width: 100%;font-size: 12px;">Software Developed By: <b>IT Lab Solutions Ltd.</b> Call: +88 018 4248 5222</div>
		
			</div> <!--end of invoice-->
		</div>
		<img class="img" src="<?php echo base_url()?>images/suprobha-logo.jpg" alt="">
	</div>
	</body>
</html>	