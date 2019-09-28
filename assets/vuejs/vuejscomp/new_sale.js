Vue.component('multiselect', window.VueMultiselect.default)
new Vue({
  el:"#vuejscom",
  data() {
      return {
      	base_url:base_url,
        query: "",
	    selectedCountries: [],
	    selectedcustomar:[],
        countries: [],
        isLoading: false,
        quantity:null,
        sell_info:[],
        month:0,
        price:null,
        advancepay:null,
        discount:null,
        screchcard:null,
        finalamount:0.00,
        cford:null,
        cfors:null,
        afors:null,
        aforsfee:null,
        totalintrast:null,
        parmanthpay:0,
        data:Date.now(),
        customers:[],
        installmentdate:[],
        allmonthdata:null,
        configdata:[

        ],
        id:null,
        installmentfee:0,
        selldata:[],
        remarks:null,
        check:null,
        referencename:null,
        referenccontact:null,
        id:null,
        key:null,
      };
    },
    components:{
	  	vuejsDatepicker
	},
    methods: {
	    submit(){
	    	var self=this;
	    	this.installmentdate.forEach(function(element,i) {
  				var d = new Date(element),
		        month = '' + (d.getMonth() + 1),
		        day = '' + d.getDate(),
		        year = d.getFullYear();
			    if (month.length < 2) month = '0' + month;
			    if (day.length < 2) day = '0' + day;
			    var d= [year, month, day].join('-');
  				self.installmentdate[i]=d;
			});
	    	$.ajax({
	    		url: this.base_url+'/sale/new_sale',
	    		type: 'POST',
	    		data: {id:this.id,key:this.key,referencename:this.referencename,referenccontact:this.referenccontact,installmentdate:this.installmentdate,remarks:this.remarks,installmentfee:this.installmentfee,product_id: this.selectedCountries.product_id,w_product_id: this.selectedCountries.ip_id,price:this.price,discount:this.discount,screchcard:this.screchcard,advancepay:this.advancepay,finalamount:this.finalamount,month:this.month,totaldue:this.finalamount,totalinterest:this.totalintrast,permonthpay:this.parmanthpay,date:this.formatDate(this.data),customar_id:this.selectedcustomar.customer_id},
	    	})
	    	.done(function(re) {
	    		var re = jQuery.parseJSON(re);
	    		if(re){
	    			self.selectedCountries=[];
		    		self.id=re.id;
		    		self.selldata.push(re.data);
	    		    swal({
                        title: "Good job!",
                        text: "Sale Created successfully!",
                        icon: "success",
                    });
	            }
	    	})
	    	.always(function() {
	    		console.log("complete");
	    	});
	    },
	    print(){
	    	 window.open(this.base_url+"sale/invoiceprint/"+this.id,'_blank');
	    },
	    printmoneyrecopt(){
	    	 window.open(this.base_url+"sale/insinvoiceprint/"+this.id,'_blank');
	    },
	    limitText (count) {
	      return `and ${count} other countries`
	    },
	    asyncFind (query) {
	      this.isLoading = true
	      this.countries=[];
	      var self=this;
	      if(query.length>0){
		      $.ajax({
		      	url: this.base_url+'sale/search',
		      	data: {query: query},
		      })
		      .done(function(re) {
		      	var re=jQuery.parseJSON(re);
		      	self.countries = re
		        self.isLoading = false
		      })
		      .fail(function(re) {
		      	console.log(re);
		      })
		    }
	        self.isLoading = false

	    },
	    searchfind(q){
	    	var self=this;
	    	$.ajax({
	  			url: this.base_url+'/customer/query',
		      	data: {query: q},
            	method: 'POST',
	  		})
	  		.done(function(re) {
	  			var re= jQuery.parseJSON(re);
	  			self.customers=re;
	  		})
	    },
	    clearAll () {
	      this.selectedCountries = []
	    },
	    changefinalamount(){
	    	if(this.cford==null){
	    		this.cford=this.discount;
	    		this.finalamount=this.finalamount-this.discount;
	    	}else{
	    		this.finalamount=parseInt(this.cford)+parseInt(this.finalamount);
	    		this.finalamount=this.finalamount-this.discount;
	    		this.cford=this.discount;
	    	}
	    },
	    changefinalamounts(){
	    	if(this.cfors==null){
	    		this.cfors=this.screchcard;
	    		this.finalamount=this.finalamount-this.screchcard;
	    	}else{
	    		this.finalamount=parseInt(this.cfors)+parseInt(this.finalamount);
	    		this.finalamount=this.finalamount-this.screchcard;
	    		this.cfors=this.screchcard;
	    	}
	    },
	    changefinalamounta(){
	    	if(this.afors==null){
	    		this.afors=this.advancepay;
	    		this.finalamount=this.finalamount-this.advancepay;
	    	}else{
	    		this.finalamount=parseInt(this.afors)+parseInt(this.finalamount);
	    		this.finalamount=this.finalamount-this.advancepay;
	    		this.afors=this.advancepay;
	    	}
	    },
	    calculateinterast(){
	    	if(this.check){
	    		var interast=(this.finalamount*this.configdata[0].rate)/100;
	    		var interast=interast/12;
	    		var interast=interast*this.month;
	    		this.totalintrast=interast.toFixed(2);
	    		var d =(parseFloat(this.finalamount)+parseFloat(interast))/this.month;
	    		this.parmanthpay=d.toFixed(2);
	    	}else{
	    		this.totalintrast=0;
	    		this.parmanthpay=this.finalamount/this.month;
	    		this.parmanthpay=this.parmanthpay.toFixed(2);
	    	}
	    },
	    changefinalamountaextrafee(){
	    	if(this.installmentfee!=''){
		    	if(this.aforsfee==null){
		    		this.aforsfee=this.installmentfee;
		    		this.finalamount=parseInt(this.finalamount)+parseInt(this.installmentfee);
		    		console.log(this.finalamount);
		    	}else{
		    		this.finalamount=parseInt(this.finalamount)-parseInt(this.aforsfee);
		    		this.finalamount=parseInt(this.finalamount)+parseInt(this.installmentfee);
		    		this.aforsfee=this.installmentfee;
		    	}
		    }
	    },
	    formatDate(date) {
		    var d = new Date(date),
		    month = '' + (d.getMonth() + 1),
		    day = '' + d.getDate(),
		    year = d.getFullYear();
		    if (month.length < 2) month = '0' + month;
		    if (day.length < 2) day = '0' + day;
		    return [year, month, day].join('-');
		}
  	},
  	watch:{
  		data:function(data){
  			this.installmentdate=[];
	    	var self=this;
	    	$.ajax({
	    		url: base_url+'/sale/insdate/'+this.month,
	    		data:{date:data}
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
  		},
  		quantity: function (val) {
	      this.total_buy_price = val;
	      this.unit_buy_price_purchase = this.total_buy_price/val;
	    },
	    selectedCountries:function(val){
	    	if(val!=null){
		    	this.price=val.sale_price	
		    	this.finalamount=parseInt(val.sale_price)+parseInt(this.installmentfee);
		    	this.quantity=1
	    	}
	    },
	    check:function(v){
	    	if(this.check){
	    		var interast=(this.finalamount*this.configdata[0].rate)/100;
	    		var interast=interast/12;
	    		var interast=interast*this.month;
	    		this.totalintrast=interast.toFixed(2);
	    		var d =(parseFloat(this.finalamount)+parseFloat(interast))/this.month;
	    		this.parmanthpay=d.toFixed(2);
	    	}else{
	    		this.totalintrast=0;
	    		this.parmanthpay=this.finalamount/this.month;
	    		this.parmanthpay=this.parmanthpay.toFixed(2);
	    	}
	    },
	    month:function(v){
	    	
	    	this.installmentdate=[];
	    	var self=this;
	    	$.ajax({
	    		url: base_url+'/sale/insdate/'+v,
	    		data:{date:this.data}
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
  		this.data=this.formatDate(Date.now());
  		var self = this;
  		$.ajax({
  			url: this.base_url+'/config/all',
  		})
  		.done(function(re) {
  			var re= jQuery.parseJSON(re);
  			self.configdata.push(re[0])
  		})

  		$.ajax({
  			url: this.base_url+'/customer/alls',
  		})
  		.done(function(re) {
  			var re= jQuery.parseJSON(re);
  			self.customers=re;
  		})
  	}
})


// customer_form
$(document).ready(function () {
    $('#customer').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (res){
                if (res.check == true) {
                    $('#customer').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#customer').find('p.text-danger').remove();
                    if (res.success == true) {
                           var file_data = $('#file').prop('files')[0];
                            var form_data = new FormData();
                            form_data.append('file', file_data);
                            $.ajax({
                                url: base_url+'customer/upload_file/'+res.id, // point to server-side controller method
                                dataType: 'text', // what to expect back from the server
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: form_data,
                                type: 'post',
                                success: function (response) {
                                    console.log(response)
                                    $('#msg').html(response); // display success response from the server
                                },
                                error: function (response) {
                                    $('#msg').html(response); // display error response from the server
                                }
                            });
                            swal({
	                            title: "Good job!",
	                            text: "Customer Created successfully!",
	                            icon: "success",
	                        });
                        $('#cModel').modal('hide');
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('.'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').siblings('p.text-danger').remove();
                        el.after(value);
                    });
                }
            }
        });
    });
});
