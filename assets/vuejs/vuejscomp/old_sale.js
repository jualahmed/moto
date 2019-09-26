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
	    	}

	    },
	    changefinalamountaextrafee(){

	    	if(this.aforsfee==null){
	    		this.aforsfee=this.installmentfee;
	    		this.finalamount=parseInt(this.finalamount)+parseInt(this.installmentfee);
	    	}else{
	    		this.finalamount=parseInt(this.finalamount)-parseInt(this.aforsfee);
	    		this.finalamount=parseInt(this.finalamount)+parseInt(this.installmentfee);
	    		this.aforsfee=this.installmentfee;
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
	    	}
	    	// this.parmanthpay=this.parmanthpay.toFixed(2);
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

function edValueKeyPress()
{
    var edValue = document.getElementById("edValue");
    var length=$('#edValue').val();
    if(length.length >=4){
        var s = length.substring(0, 4); 
    }
    else{
        var s = edValue.value;
    }
    var br_code = '14578787';
    $(".barcode_id").val(br_code); 
}

$(document).ready(function() {
    $('#edValue').keyup(function(){
     var length=$('#edValue').val().length;
      if(length>1){
          $('#submit_btn').attr('disabled', true);
      }
      if(length==0){
        $('#submit_btn').removeAttr('disabled',false);
        $("#user-availability-status1").hide();
        $("#user-availability-status2").hide()
      }
    });
});
    
function checkAvailability() {
    $("#loaderIcon").show();
    $.ajax({
    url: base_url+"product/checkAvailability",
    data:'customProductName='+$("#edValue").val(),
    type: "POST",
    success:function(data){
        if(data == 'Product Name Available') 
        {
            $('#submit_btn').removeAttr('disabled',false);
            $("#user-availability-status1").html(data).show();
            $("#user-availability-status2").html(data).hide()
            $("#loaderIcon").hide();
        }
        else if (data == 'Product Name Not Available') 
        {
            $('#submit_btn').attr('disabled', true);
            $("#user-availability-status2").html(data).show();
            $("#user-availability-status1").html(data).hide();
            $("#loaderIcon").hide();
        }
    }
    });
}

jQuery(document).ready(function($) {
    $('#tot_prrice').keyup(function(){
        var quant = $('#tot_qquantity').val();
        var tot_price = $('#tot_prrice').val();
        
        var avg_price = tot_price/quant;
        
        $('#byu_price').val(avg_price);
    });

    $('#tot_sale_price').keyup(function(){
        var quant = $('#tot_qquantity').val();
        var tot_price = $('#tot_sale_price').val();
        
        var avg_price = tot_price/quant;
        
        $('#uni_slae_pric').val(avg_price);
    });
});

$(document).ready(function()
{
    $("#product_specification").change(function()
    { 
        var value = $(this).val();
        if(value ==2)
        {
            $(".war_peri").show();
        }
        else
        {
            $(".war_peri").hide();
        }
        
    });
});










// purchas listing for one product

Vue.component('v-select', VueSelect.VueSelect);
Vue.component('multiselect', window.VueMultiselect.default)
new Vue({
  el:"#PModel",
  data() {
      return {
        base_url:base_url,
        single_purchase:0,
        purchase_receipt_info:[],
        selected1: '',
        query: "",
        selected: "",
        selectedCountries: [],
        countries: [],
        isLoading: false,
        expiredate:this.formatDate(new Date()),
        tp_total:0,
        vat_total:0,
        quantity:null,
        total_buy_price:null,
        unit_buy_price_purchase:null,
        exclusive_sale_price:0,
        general_sale_price:null,
        purchase_info:[],
        productinfo:[
            
        ],
        engineno:null,
        batteryno:null,
        color:null,
        chassisno:null,
        sssssssss:null,
      };
    },
    methods: {
          formatDate(date) {
            var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            return [day,month,year].join('-');
        },
        incress(){
            this.productinfo.push({engineno:this.engineno,batteryno:this.batteryno,color:this.color,chassisno:this.chassisno})
            this.engineno=null;
            this.batteryno=null;
            this.color=null;
            this.chassisno=null;
        },
        submit(){
            this.sssssssss=this.sssssssss+this.total_buy_price;
            var purchase_receipt_id=this.selected1.receipt_id;
            var self=this;
            $.ajax({
                url: this.base_url+'purchase/createlisting',
                type: 'POST',
                data: {productinfo:this.productinfo,purchase_receipt_id: purchase_receipt_id,product_id:this.selectedCountries.product_id,expiredate:this.expiredate,tp_total:this.tp_total,vat_total:this.vat_total,quantity:this.quantity,total_buy_price:this.total_buy_price,unit_buy_price_purchase:this.unit_buy_price_purchase,exclusive_sale_price:this.exclusive_sale_price,general_sale_price:this.general_sale_price},
            })
            .done(function(re) {
                var re = jQuery.parseJSON(re);
                self.purchase_info[0].push(re[0]);
                self.general_sale_price=0;
                self.exclusive_sale_price=0;
                self.unit_buy_price_purchase=0;
                self.total_buy_price=0;
                self.quantity=0;
                self.productinfo=[];
                swal({
                    title: "Good job!",
                    text: "Purchase Created successfully!",
                    icon: "success",
                });
            })
            .fail(function() {
                console.log("error");
            })
        },
        insertotherdata(){
            console.log('ddddddd');
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
                url: this.base_url+'/product/search',
                data: {query: query},
              })
              .done(function(re) {
                var re=jQuery.parseJSON(re);
                self.countries = re
                self.isLoading = false
              })
              .fail(function() {
                console.log("error");
              })
          }

          self.isLoading = false

        },
        clearAll () {
          this.selectedCountries = []
        },
        setSelected(){
            console.log("sdfdsf");
        }
    },
    watch:{
        quantity: function (val) {
          this.total_buy_price = val;
          this.unit_buy_price_purchase = this.total_buy_price/val;
        },
        total_buy_price: function (val) {
          this.unit_buy_price_purchase = this.total_buy_price/this.quantity;
        },
        unit_buy_price_purchase: function (val) {
          this.total_buy_price = this.quantity*val;
        },
        selected1:function(val){
            this.sssssssss=0;
            if(val){
            this.purchase_info=[];
            var self = this;
            var purchase_receipt_id=this.selected1.receipt_id;
            $.ajax({
                url: base_url+'purchase/allproductbelogntopurchase/'+purchase_receipt_id,
            })
            .done(function(re) {
                var re= jQuery.parseJSON(re);
                var j=re;
                j.forEach( function(element, index) {
                    self.sssssssss+=element.purchase_quantity*element.unit_buy_price;
                });
                self.purchase_info.push(re);
            })
            .fail(function() {
                console.log("error");
            })
            }
        }
    },
    created(){
        var self = this;
        $.ajax({
          url     : base_url+'purchase/alls',
          cash    : false,
          dataType: 'json',
          success : function(re)
          { 
            for (var i = re.length - 1; i >= 0; i--) {
                self.purchase_receipt_info.push(re[i]);
            }
          }
        });
    },
    computed: {
       
    },
})






























// old js will delete soon
$(document).ready(function() {
    $('#edValue').keyup(function(){
     var length=$('#edValue').val().length;
      if(length>1){
          $('#submit_btn').attr('disabled', true);
      }
      if(length==0){
        $('#submit_btn').removeAttr('disabled',false);
        $("#user-availability-status1").hide();
        $("#user-availability-status2").hide()
      }
     });
});


$(function () {
    /* Starting: getProducts() */
    function getProducts2(purchase_receipt_id)
    {
      $.ajax({
        url     : base_url+'Purchase/getSpecificPurchaseReceiptProduct',
        type    : 'POST',
        cash    : false,
        data    : {purchase_receipt_id: purchase_receipt_id},
        success : function(info)
        {
            var total_final = 0.00;
            $('.total_purchase_price_final').each(function(){
                total_final += parseFloat($(this).text()); 
            });
            
            $('#total_purchase_price_new_final').html(total_final.toFixed(2));

            $('#purchase_products').html(info);
            $('#search_by_name').focus();
            
        }
      });
    }

    /* Ending: getProducts()*/
    $('#purchase_amount').on('keyup', function(){
      purchase_amount = $(this).val();
      if(purchase_amount != ''){
        purchase_amount = parseFloat(purchase_amount);
        if(!isNaN(purchase_amount)){
          $('#final_amount').val(purchase_amount);
        }
      }
      else if(purchase_amount == ''){
        $('#final_amount').val('');
      }
    });

    $('#discount').on('keyup', function(){
      var purchase_amount = $('#purchase_amount').val();
      var discount        = $('#discount').val();
      var final_amount    = 0;

      if(purchase_amount != '' && discount != ''){
        purchase_amount = parseFloat(purchase_amount);
        discount        = parseFloat(discount);

        if(!isNaN(purchase_amount) && !isNaN(discount)){
          var tmp       = ((purchase_amount * discount)/100);
          final_amount  = purchase_amount - tmp;
          $('#final_amount').val(Math.round(final_amount));
        }
      }
    });

    $('#search_by_barcode').on('keyup', function(ev){
        ev.preventDefault();

        if(ev.which == 13)
        {
            var barcode = $(this).val();

            if(barcode != '')
            {
                $.ajax({
                    url         : base_url+"purchase/search_product_by_barcode",
                    type        : 'POST',
                    dataType    : 'json',
                    data        : { barcode: barcode },
                    success     : function(result)
                    {
                        $('#search_by_barcode').val(result['product_name']);
                        $('#product_name').val(result['product_name']);
                        $('#product_id').val(result['product_id']);
                        $('#product_specification').val(result['product_specification']);
                        
                        if(result['unit_buy_price'] =='' || result['unit_buy_price'] =='0')
                        {
                        $('#unit_buy_price_purchase').val(result['bulk_unit_buy_price']);
                        }
                        else
                        {
                        $('#unit_buy_price_purchase').val(result['unit_buy_price']);
                        }

                        $('#general_sale_price').val(result['general_unit_sale_price']);
                        $('#exclusive_sale_price').val(result['general_unit_sale_price']);
                        $('#quantity').focus();
                    }

                });
            }
        }

    });
    /*Ending: search_by_barcode*/

    $('#add_product_serial_form').on('submit', function(service)
    {
        service.preventDefault();
        var submiturl = $(this).attr('action');
        var methods = $(this).attr('method');
        var data = $('#add_product_serial_form').serialize();
        var pro_id = $('#product_id').val();
        var unit_buy_price        = $('#unit_buy_price_purchase').val();
        var purchase_receipt_id   = $('#pur_rec_id').val();
        var pro_name              = $('#product_name').val();
        var qnty                  = $('#quantity').val();
        var ex_date               = $('#datepicker').val();
        var total_buy_price       = $('#total_buy_price').val();
        var general_sale_price    = $('#general_sale_price').val();
        var exclusive_sale_price  = $('#exclusive_sale_price').val();
        var product_specification  = $('#product_specification').val();

        var testid = $('#testid').val();
        if(testid == 0){
            $('#testid').val(1);
            $.ajax(
            {
                url: submiturl,
                type: methods,
                data: {'product_type': data,'product_id':pro_id,'purchase_receipt_id':purchase_receipt_id,'unit_buy_price':unit_buy_price},  
                cache: false,       
                success:function(result)
                {
                    //alert(result);
                    //$("#show_product_individual_add_modal").modal('hide');
                        var grand_total             = Math.round(parseFloat($('#grand_total').val()));
                        var total_purchase_amount   = Math.round(parseFloat($('#total_purchase_amount').val()));

                        $.ajax({
                          url       : base_url+"purchase/addProductToList",
                          type      : 'POST',
                          cash      : false,
                          data      : {
                                        purchase_receipt_id     : purchase_receipt_id,
                                        pro_name                : pro_name,
                                        pro_id                  : pro_id,
                                        qnty                    : qnty,
                                        ex_date                 : ex_date,
                                        total_buy_price         : total_buy_price,
                                        general_sale_price      : general_sale_price,
                                        unit_buy_price          : unit_buy_price,
                                        exclusive_sale_price    : exclusive_sale_price,
                                        grand_total             : grand_total,
                                        total_purchase_amount   : total_purchase_amount
                                    },
                          success: function(data)
                          {
                              $("#show_product_individual_add_modal").modal('hide');
                              getProducts2($('#purchase_receipt_id').val());
                             // $('#purchase_products').last().append(data);
                              $('#search_by_name').val("");
                              $('#search_by_barcode').val("");
                              $('#product_id').val("");
                              $('#quantity').val("");
                              $('#datepicker').val("");
                              $('#total_buy_price').val("");
                              $('#general_sale_price').val("");
                              $('#unit_buy_price').val("");
                              $('#exclusive_sale_price').val("");
                              $('#search_by_name').focus();
                            var total_final = 0.00;
                            $('.total_purchase_price_final').each(function(){
                                total_final += parseFloat($(this).text()); 
                            });
                            
                            $('#total_purchase_price_new_final').html(total_final);
                            $('#add_product_serial_form').reset();
                            //$('#add_product_serial_form')[0].reset();
                          }
                        });
                    
                }
            });
        }
        
    });
    
    
    /* Starting: Reset. */
    $('#reset').on('click', function(){
      $('#search_by_name').val("");
      $('#search_by_barcode').val();
      $('#product_id').val("");
      $('#quantity').val("");
      $('#datepicker').val("");
      $('#total_buy_price').val("");
      $('#general_sale_price').val("");
      $('#unit_buy_price').val("");
      $('#exclusive_sale_price').val("");
      $('#search_by_name').focus();
    });
    /* Ending: Reset. */
    
    $('#delete_purchase_invoice').on('click', function()
    {
      var purchase_receipt_id   = $('#pur_rec_id').val();
      
      if(purchase_receipt_id != '')
      {
        swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            cancelButtonText    : 'No',
            confirmButtonText   : 'Yes'
          }).then(function () {
              
              $.ajax({
                url       : "<?php echo base_url();?>purchase/removeProductFromPurchase",
                type      : 'POST',
                cash      : false,
                data      : {purchase_receipt_id: purchase_receipt_id, pro_id: product_id},
                success: function(result)
                {
                    //alert(result);
                    getProducts2(purchase_receipt_id);
                  tr.closest('tr').remove();
                    var total_final = 0.00;
                    $('.total_purchase_price_final').each(function(){
                        total_final += parseFloat($(this).text()); 
                    });
                    $('#total_purchase_price_new_final').html(total_final);
                  swal(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                  );
                  
                }
              });
          })
      }

    });

    $('#purchase_products').on('click', "[name='remove']", function(){
      var product_id            = $(this).attr('id');
      var purchase_receipt_id   = $('#pur_rec_id').val();
      var tr                    = $(this);
      
      if(product_id != '' && purchase_receipt_id != '')
      {
        swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            cancelButtonText    : 'No',
            confirmButtonText   : 'Yes'
          }).then(function () {
              
              $.ajax({
                url       : "<?php echo base_url();?>purchase/removeProductFromPurchase",
                type      : 'POST',
                cash      : false,
                data      : {purchase_receipt_id: purchase_receipt_id, pro_id: product_id},
                success: function(result)
                {
                    //alert(result);
                    getProducts2(purchase_receipt_id);
                  tr.closest('tr').remove();
                    var total_final = 0.00;
                    $('.total_purchase_price_final').each(function(){
                        total_final += parseFloat($(this).text()); 
                    });
                    $('#total_purchase_price_new_final').html(total_final);
                  swal(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                  );
                  
                }
              });
          })
      }

    });

    $('#purchase_products').on('click', "[name='edit']", function(ev)
    {
        ev.preventDefault();
      
        global_product_id                   = $(this).attr('id');
        global_purchase_receipt_id          = $('#pur_rec_id').val();
        var purchase_receipt_id             = $('#purchase_receipt_id').val();
        selected_row                        = $(this);
        var specification_id                = $('#spec'+global_product_id).val();
        var old_qty                         = parseFloat(selected_row.closest('tr').find('td:nth-child(4)').text());
        var old_tp                          = parseFloat(selected_row.closest('tr').find('td:nth-child(5)').text());

        $('#edit_modal').modal('show');
        $('#pro_hide').val(global_product_id);
        $('#pro_hide_buy').val(old_tp);
        //alert(specification_id);
        if(specification_id==2)
        {
            $('#save_change').hide();
            $('.serial_qnt_price').hide();
            $('.pro_serial_input_for_edit').show();
            
            var submiturl = '<?php echo base_url();?>purchase/getIndiVidualProduct_warranty';
            var methods = 'POST';
            var output = '';
            var input_box='';
            var k=1;
            $.ajax(
            {
                url: submiturl,
                type: methods,
                dataType: 'JSON',
                data: {'purchase_receipt_id':purchase_receipt_id,'product_id':global_product_id},   
                success:function(result)
                {
                    for(var i=0; i<old_qty; i++)
                    {
                        input_box='';
                        for(var ii=0; ii<=result.length; ii++)
                        {
                            //alert(result[ii].ip_id);
                            if(result[ii].status==1)
                            {
                                input_box+='<tr><td style="width: 16%;">'+k+'. Serial No</td><td style="width: 76%;"><input type="text" name="product_type[]" value="'+result[ii].sl_no+'" class ="form-control product_type" maxlength="100" id="product_type'+result[ii].ip_id+'" placeholder="Serial No" autocomplete="off" required="on"></td><td style="width: 8%;"><i class="fa fa-fw fa-remove css_for_cursor" style="color: red; " id='+result[ii].ip_id+' name="remove_warran" title="Remove"></i> <i class="fa fa-fw fa-check css_for_cursor" style="color: green; " id='+result[ii].ip_id+' name="edit_warran" title="Edit"></i></td></tr>';
                                //alert(input_box);
                                k++;
                                $(".pro_serial_input_for_edit_new").html(input_box);
                            }
                            else
                            {
                                input_box+='<tr><td style="width: 16%;">'+k+'. Serial No</td><td style="width: 76%;"><input type="text" name="product_type[]" value="'+result[ii].sl_no+'" class ="form-control product_type" maxlength="100" id="product_type" placeholder="Serial No" autocomplete="off" required="on" readonly></td><td style="width: 8%;"></td></tr>';
                                //alert(input_box);
                                k++;
                                $(".pro_serial_input_for_edit_new").html(input_box);
                            }
                        }
                    }
                }
            });
            
            
        }
        else
        {
            $('#save_change').show();
            $('.serial_qnt_price').show();
            $('.pro_serial_input_for_edit').hide();
            $('#qty').val(old_qty);
            $('#u_b_p').val(old_tp);
        }
    });

    $('#pro_serial_input_for_edit').on('click', "[name='edit_warran']", function(ev)
    {
        ev.preventDefault();
      
        var ip_id                   = $(this).attr('id');
        var product_type_name       = $('#product_type'+ip_id).val();   
            var submiturl = '<?php echo base_url();?>purchase/update_product_warranty';
            var methods = 'POST';
            var output = '';
            var input_box='';
            var k=1;
            $.ajax(
            {
                url: submiturl,
                type: methods,
                dataType: 'JSON',
                data: {'ip_id':ip_id,'product_type_name':product_type_name},    
                success:function(result)
                {
                    swal(
                        'Updated!',
                        'Product has been updated.',
                        'success'
                      );
                    $('#product_type'+ip_id).val(result.sl_no);
                }
            });
    });

    $('#pro_serial_input_for_edit').on('click', "[name='remove_warran']", function(){
      var ip_id            = $(this).attr('id');
      var purchase_receipt_id   = $('#pur_rec_id').val();
      var tr                    = $(this);
      var product_id     = parseInt($('#pro_hide').val());
      var pro_hide_buy     = parseInt($('#pro_hide_buy').val());
      //alert(ip_id);
      //alert(purchase_receipt_id);
     // alert(product_id);
      if(ip_id != '' && purchase_receipt_id != '' && product_id != '')
      {
        swal({
            title               : 'Are you sure?',
            text                : "You won't be able to revert this!",
            type                : 'warning',
            showCancelButton    : true,
            confirmButtonColor  : '#db8b0b',
            cancelButtonColor   : '#419641',
            cancelButtonText    : 'No',
            confirmButtonText   : 'Yes'
          }).then(function () 
          {
              
              $.ajax({
                url       : "<?php echo base_url();?>purchase/removeProductFromPurchase_warranty",
                type      : 'POST',
                cash      : false,
                data      : {purchase_receipt_id: purchase_receipt_id, ip_id: ip_id, product_id: product_id, pro_hide_buy: pro_hide_buy},
                success: function(result)
                {
                    //alert(result);
                    getProducts2(purchase_receipt_id);
                    tr.closest('tr').remove();
                    var total_final = 0.00;
                    $('.total_purchase_price_final').each(function(){
                        total_final += parseFloat($(this).text()); 
                    });
                    $('#total_purchase_price_new_final').html(total_final);
                  swal(
                    'Deleted!',
                    'Product has been deleted.',
                    'success'
                  );
                  
                }
              });
          })
      }

    });

    $('#edit_modal_form').on('submit', function(ev){
        ev.preventDefault();
        var qty             = $('#qty').val();
        var unit_buy_price  = $('#u_b_p').val();

        /*swal*/
        if(qty != '' && qty > 0 && !isNaN(qty) && unit_buy_price !='' && unit_buy_price > 0 && !isNaN(unit_buy_price)){
            swal({
                title               : 'Are you sure?',
                text                : ":)",
                type                : 'warning',
                showCancelButton    : true,
                confirmButtonColor  : '#db8b0b',
                cancelButtonColor   : '#419641',
                confirmButtonText   : 'Yes',
                cancelButtonText    : 'No'
            }).then(function (){
               var old_qty     = parseFloat(selected_row.closest('tr').find('td:nth-child(4)').text());
                var old_tp      = parseFloat(selected_row.closest('tr').find('td:nth-child(5)').text());
                qty             = parseFloat(qty);
                unit_buy_price  = parseFloat(unit_buy_price);

                $.ajax({
                  url       : '<?php echo base_url();?>purchase/editPruchaseProduct',
                  type      : 'POST',
                  data      : {
                                pro_id                : global_product_id,
                                purchase_receipt_id   : global_purchase_receipt_id, 
                                qty                   : qty, 
                                u_b_p                 : unit_buy_price
                              },
                  success   : function(info)
                  {
                    selected_row.closest('tr').find('td:nth-child(4)').html(qty);
                    selected_row.closest('tr').find('td:nth-child(5)').html(unit_buy_price);
                    selected_row.closest('tr').find('td:nth-child(6)').html(Math.round(qty * unit_buy_price));
                    $('#edit_modal_form').trigger("reset");
                    $('#edit_modal').modal('hide');
                    
                    var total_final = 0.00;
                    $('.total_purchase_price_final').each(function(){
                        total_final += parseFloat($(this).text()); 
                    });
                    $('#total_purchase_price_new_final').html(total_final);

                    swal(
                      'Edited!',
                      'Data has been edited.',
                      'success'
                    );
                  }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                  $('#edit_modal_form').trigger("reset");
                  $('#edit_modal').modal('hide');
                  swal(
                    'Canceled',
                    ':)',
                    'info'
                  )
                }
            })
        }
        else{
          $('#edit_modal_form').trigger("reset");
          swal(
            'Oops...!',
            'Invalid Data!!!',
            'error'
          );
        }
        /*swal*/
    });

  });



$('#download_database').on('click', function(){
    swal({
      title               : 'Are you sure?',
      text                : "To Download Database!",
      type                : 'warning',
      showCancelButton    : true,
      confirmButtonColor  : '#db8b0b',
      cancelButtonColor   : '#008d4c',
      confirmButtonText   : 'Yes',
      cancelButtonText    : 'No'
    }).then(function () {
         $.ajax({
            url: base_url+'admin/download_database',
            type: "POST",
            cache: false,
            data: { },
            beforeSend: function(){
             $(".modal12345").show();
            },
            success:function(result){
            $(".modal12345").hide();
              swal(
                'Download',
                'Your database has been downloaded.',
                'success'
              );
            }

        });
    })
});

