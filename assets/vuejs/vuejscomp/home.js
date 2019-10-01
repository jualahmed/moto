function sendsms(argument,ar2) {
	$.ajax({
		url: base_url+'admin/findinstlalment/'+argument
	})
	.done(function(re) {
		var d=jQuery.parseJSON(re);
		var daaa = new Date(d[0].date),
        month = '' + (daaa.getMonth() + 1),
        day = '' + daaa.getDate(),
        year = daaa.getFullYear();
	    if (month.length < 2) month = '0' + month;
	    if (day.length < 2) day = '0' + day;
	    var ddddddd= [day, month, year].join('-');
		var msg=`সম্মানিত গ্রাহক, সুপ্রভা ইন্টারন্যাশনাল এর পক্ষ থেকে অভিনন্দন। আপনার ক্রয়কৃত ${ d[0].product_name } এর  ${ ar2 } তম কিস্তি প্রদানের শেষ তারিখ ${ ddddddd } ইং ইঞ্জিন নং ${ d[0].engineno }  চেসিস নং ${ d[0].chassisno }  টাকা ${ d[0].amount },
ধন্যবাদ।`;
		$("#messsages").html("messsag send successfully");
		$.ajax({
			url: 'http://sms.dhost247.net/index.php?number=88'+d[0].customer_contact_no+'&text='+msg,
		})
		.done(function(re) {
			console.log(re);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	})
	.fail(function() {
		console.log("error");
	})	
}
