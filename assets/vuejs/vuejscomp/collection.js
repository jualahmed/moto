jQuery(document).ready(function($) {
	$("#submitnewinfoice").click(function(event) {
		var a = $('#datadddddddd').val();
		window.open(base_url+"sale/insinvoiceprint/"+a);
		location.reload();
	});
});


function latefeecalculate(v){
	var ddd= document.getElementById('latef').value
	var amount=document.getElementById("permonthpaydd").value;
	document.getElementById("amount").value=parseFloat(ddd)+parseFloat(amount);
}


Vue.component('multiselect', window.VueMultiselect.default)
new Vue({
	el:"#vuejscom",
	data:{
		month:null,
		allmonthdata:null,
        installmentdate:[],
        id:null,
        selectedcustomar:[],
        customers:[],
        isLoading: false,
        allsale:[],
        sale_id:null,
        withinterest:null,
        totalkisti:0,
        isokay:true,
        totalkisti1:0,
        donemonth:0,
        message:'',
        installmentfee:null,
	},
	components:{
	  	vuejsDatepicker
	},
	methods:{
		testss(v){
			var self=this
			this.allsale=[];
			$.ajax({
				url: base_url+'sale/salelogbycustomar/'+v.customar_id,
			})
			.done(function(re) {
				var re=jQuery.parseJSON(re);
				self.allsale=re;
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		},
		searchfind(q){
	    	var self=this;
	    	$.ajax({
	  			url: base_url+'customer/querywithsale',
		      	data: {query: q},
            	method: 'POST',
	  		})
	  		.done(function(re) {
	  			var re= jQuery.parseJSON(re);
	  			self.customers=re;
	  		})
	    },
		limitText (count) {
	      return `and ${count} other countries`
	    },
		removedata(index){
    		this.installmentdate.splice(index, 1);
    	},
		formatDate(date) {
		    var d = new Date(date),
		    month = '' + (d.getMonth() + 1),
		    day = '' + d.getDate(),
		    year = d.getFullYear();
		    if (month.length < 2) month = '0' + month;
		    if (day.length < 2) day = '0' + day;
		    return [year, month, day].join('-');
		},
		pushdata(){
			this.installmentdate.push(this.formatDate(this.allmonthdata))
			this.allmonthdata=null;
		},
		incressordesressmonth(id){
			$.ajax({
				url: base_url+'sale/submitincress/'+id,
				type: 'POST',
				data: {month: this.month,installmentdate:this.installmentdate,withinterest:this.withinterest,installmentfee:this.installmentfee},
			})
			.done(function(re) {
				console.log(re)
				if(re){
					swal({
                        title: "Good job!",
                        text: "Installment Updated successfully!",
                        icon: "success",
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
				}
			})
			.fail(function() {
				console.log("error");
			})
		}
	},
	watch:{
		month:function(v){
			if(parseInt(this.donemonth)>=parseInt(v)){
				this.isokay=false;
				this.message="Total Installment can not equal previous total Installments and total Installments can not greater than paid installment"
			}else{
				this.isokay=true;
				this.message="";
			}

	    	this.installmentdate=[];
	    	var self=this;
	    	$.ajax({
	    		url: base_url+'/sale/insdate/'+v,
	    		type: 'GET',
	    		data: {id: this.sale_id},
	    	})
	    	.done(function(re) {
	    		var re=jQuery.parseJSON(re);
	    		for (var i = 0; i< re.length; i++) {
	    			self.installmentdate.push(re[i]);
	    		}
	    	})
	    	.fail(function() {
	    		console.log("error");
	    	})
	    	.always(function() {
	    		console.log("complete");
	    	});

	    }
	},
	created(){
		var sale_id=document.getElementById('saleid').value;
		this.sale_id=sale_id;
		var totalkisti=document.getElementById('totalkisti').value;
		this.totalkisti=totalkisti;
		var totalkisti1=document.getElementById('totalkisti1').value;
		this.totalkisti1=totalkisti1;
		var donemonth=document.getElementById('doneistallment').value;
		this.donemonth=donemonth;
	}
})