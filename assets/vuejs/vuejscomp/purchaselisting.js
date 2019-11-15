Vue.component('v-select', VueSelect.VueSelect);
Vue.component('multiselect', window.VueMultiselect.default)
const vm = new Vue({
  el:"#vuejscom",
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
        expiredate:'11-11-2019',
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
		isdesable:false,
      };
    },
    methods: {
    	incress(){
    		this.productinfo.push({engineno:this.engineno,batteryno:this.batteryno,color:this.color,chassisno:this.chassisno})
    		this.engineno=null;
			this.batteryno=null;
			this.color=null;
			this.chassisno=null;
    	},
	    submit(){
	    	this.isdesable=true;
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
	    		self.isdesable=false;
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
	    },
	    updatepurchase_info(){
	    	this.purchase_info=[];
	    	var self = this;
	    	if(this.selected1){
	    		var purchase_receipt_id=this.selected1.receipt_id;
	    	}
	    	$.ajax({
	    		url: base_url+'purchaselisting/allproductbelogntopurchase/'+purchase_receipt_id,
	    	})
	    	.done(function(re) {
	    		self.totalqty=0;
	    		self.tunit_buy_price=0;
	    		self.unit_buy_price=0;
	    		var re= jQuery.parseJSON(re);
	    		self.purchase_info.push(re);
	    		re.forEach( function(element, index) {
	    			self.totalqty= parseInt(self.totalqty) + parseInt(element.purchase_quantity);
	    			self.unit_buy_price= parseInt(self.unit_buy_price) + parseInt(element.unit_buy_price);
	    			self.tunit_buy_price= parseInt(self.tunit_buy_price) + parseInt(element.purchase_quantity*element.unit_buy_price);
	    		});
	    	})
	    	.fail(function() {
	    		console.log("error");
	    	})
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
      var purchase_id            = $(this).attr('purchase_id');
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
                url       : base_url+"purchase/removeProductFromPurchase",
                type      : 'POST',
                cash      : false,
                data      : {purchase_receipt_id: purchase_receipt_id, pro_id: product_id,purchase_id:purchase_id},
                success: function(result)
                {	
                	vm.updatepurchase_info();
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
	  var product_id            = $(this).attr('id');
      var purchase_id            = $(this).attr('purchase_id');
      var purchase_receipt_id   = $('#pur_rec_id').val();
      console.log(product_id);
      $.ajax({
      	url: base_url+'purchaselisting/find',
      	type: 'POST',
      	data: {purchaselisting_id: purchase_id},
      })
      .done(function(re) {
      	var re= jQuery.parseJSON(re);
  		$("#purchase_id").val(re.purchase_id);
  		$("#qty").val(re.purchase_quantity);
  		$("#u_b_p").val(re.unit_buy_price);
  		$("#g_b_p").val(re.general_unit_sale_price);
  		$("#e_b_p").val(re.bulk_unit_sale_price);
      })
      .fail(function() {
      	console.log("error");
      })
    });

    $('#edit_modal_form').on('submit', function(ev){
        ev.preventDefault();
        var qty             = $('#qty').val();
        var purchase_id             = $('#purchase_id').val();
        var unit_buy_price  = $('#u_b_p').val();
        var general_unit_sale_price  = $('#g_b_p').val();
        var bulk_unit_sale_price  = $('#e_b_p').val();
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
                $.ajax({
                  url       : base_url+'purchaselisting/editPruchaseProduct',
                  type      : 'POST',
                  data      : {
	                            purchase_id           : purchase_id,
	                            qty                   : qty, 
	                            u_b_p                 : unit_buy_price,
	                            e_b_p                 : bulk_unit_sale_price,
	                            g_b_p                 : general_unit_sale_price,
	                          },
                  success   : function(info)
				  {	
				  	vm.updatepurchase_info();
				  	console.log(info)
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
