$("#lock2122").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : base_url+"sale_controller/search_warranty_product22",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term, flag: 1},
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
					id              			: item.id,
					label           			: item.name,
					catagory_name   			: item.catagory_name,
					bulk_unit_buy_price 		: item.bulk_unit_buy_price,
					unit_buy_price 				: item.unit_buy_price,
					bulk_unit_sale_price 		: item.bulk_unit_sale_price,
					general_unit_sale_price 	: item.general_unit_sale_price
                    }
                  }));
                }
              });
          },
          minLength     : 1,
          select        : function (event, ui) 
			{
              $('#pro_id').val(ui.item.id); 
              $("#lock2122").focus();   
            },
});

$(document).ready(function() {
  $("#lock2122").keyup(function(){
    var length=$('#lock2122').val().length;
     if(length>=1){
       $("#lock").prop("disabled", true);
       $("#lock3").prop("disabled", true);
       $("#lock4").prop("disabled", true);
       $("#lock5").prop("disabled", true);
       $("#lock66").prop("disabled", true);
       $("#lock77").prop("disabled", true);
       $("#type_wise").prop("disabled", true);
     }
      else{
      $("#lock").prop("disabled", false);
       $("#lock3").prop("disabled", false);
       $("#lock4").prop("disabled", false);
       $("#lock5").prop("disabled", false);
       $("#lock66").prop("disabled", false);
       $("#lock77").prop("disabled", false);
       $("#type_wise").prop("disabled", false);
      }
  });
});

$(document).ready(function() 
{
  $("#reset_btn").click(function(event) 
  {
    event.preventDefault();
    $('#lock').val('');
    $('#type_wise').val('');
    $('#type_wise').select2();
    $('#lock3').val('');
    $('#lock3').select2();
    $('#lock4').val('');
    $('#lock4').select2();
    $('#lock5').val('');
    $('#lock5').select2();
    $('#lock55').val('');
    $('#lock55').select2();
    $('#lock66').val('');
    $('#lock6').val('');
    $('#lock6').select2();
    $('#lock').val('');
    $('#lock22').val('');
    $('#lock77').val('');
    $('#lock7').val('');
    $('#lock7').select2();
    $('#datepickerrr').val('');
    $('#datepickerr').val('');
    $('#lock2').val('');
    $('#datep').val('');
    $('#datep2').val('');
    $("#lock2").prop("disabled", false);
    $("#lock22").prop("disabled", false);
    $("#lock").prop("disabled", false);
    $("#lock3").prop("disabled", false);
    $("#lock4").prop("disabled", false);
    $("#lock5").prop("disabled", false);
    $("#lock55").prop("disabled", false);
    $("#lock6").prop("disabled", false);
    $("#lock66").prop("disabled", false);
    $("#lock7").prop("disabled", false);
    $("#lock77").prop("disabled", false);
    $("#datepickerrr").prop("disabled", false);
    $("#datepickerr").prop("disabled", false);  
    $("#datep").prop("disabled", false);  
    $("#datep2").prop("disabled", false); 
  });
});

$(document).ready(function() {  
  $("#form_2").submit(function(event) 
  {
    event.preventDefault();
    var submiturl = $(this).attr('action');
    var methods = $(this).attr('method');
    var output2 = '';
    var output3 = '';
    var output4 = '';
    var output5 = '';
    var i=0;
    var k= 1;
    var profit= 0;
    var profit2= 0;
    var profit_percent= 0;
    var unit_buy_price= 0;
    var unit_sale_price= 0;
    var unit_shop_price= 0;
    var profit_percent2= 0;
    var total_buy= 0;
    var total_sale= 0;
    var all_warranty = '';
    $.ajax({
      url: submiturl,
      type: methods,
      dataType: 'json',
      data: $(this).serialize(),
      beforeSend: function(){
         $(".modal").show();
      },
      success: function(result) { 
        $(".modal").hide();
        for(i=0; i<result['pro_list'].length; i++)
        {
          unit_buy_price = parseFloat(result['pro_list'][i].bulk_unit_buy_price).toFixed(2);
          unit_sale_price = parseFloat(result['pro_list'][i].bulk_unit_sale_price).toFixed(2);
          unit_shop_price = parseFloat(result['pro_list'][i].general_unit_sale_price).toFixed(2);
          all_warranty = '';
          
          for(var kkk=0; kkk<result['pro_list'][i]['warranty_name'].length; kkk++)
          {
            all_warranty+= result['pro_list'][i]['warranty_name'][kkk]['sl_no']+',<br> ';
          }
          
          output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;">'+result['pro_list'][i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result['pro_list'][i].product_name+'">'+result['pro_list'][i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;width: 56px;" title="'+all_warranty+'">'+all_warranty+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result['pro_list'][i].company_name+'">'+result['pro_list'][i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result['pro_list'][i].catagory_name+'">'+result['pro_list'][i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result['pro_list'][i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
          
          k++;
        }
        if(output2 != '')
        {
          $('#search_data').html(output2);
          $('#infomsg').show();
          $('#down').show();
        }
        else
        {
          $('#search_data').html("No Data Available");
          $('#infomsg').show();
          $('#down').show();
        }
        
        
        var product12 = (unescape($('#lock33').val()));
        var product1 = $('#pro_id').val();
        var catagory1 =(unescape($('#lock3').val()));
        var company1 = (unescape($('#lock4').val()));

        $('#product').val(product1);
        $('#product22').val(product12);
        $('#category').val(catagory1);
        $('#company').val(company1);
        
        $('.product2').text(product1);
        $('.product22').text(product12);
        $('.category2').text(catagory1);
        $('.company2').text(company1);
        
        $('#lock3').val('');
        $('#lock3').select2();
        $('#lock4').val('');
        $('#lock4').select2();
        $('#lock5').val('');
        $('#lock5').select2();
        
        $('#lock33').val('');
        $('#lock7').val('');
        $('#lock6').val('');

      }
    });
  });
  $("#down").click(function(event2) 
  {
    event2.preventDefault();
    submiturl = $(this).attr('href');
    
    var barcode = $('#barcode').val();
    var product = $('#product').val();
    var category = $('#category').val();
    var company = $('#company').val();
    var pro_type = $('#pro_type').val();
    //var pro_size = $('#pro_size').val();
    var pro_amount = $('#pro_amount').val();
    //var start = $('#start').val();
    //var end = $('#end').val();
    if(barcode == ''){
      barcode = 'null';
    }
    if(product == ''){
      product = 'null';
    }
    if(category == ''){
      category = 'null';
    }
    if(company == ''){
      company = 'null';
    }
    if(pro_type == ''){
      pro_type = 'null';
    }
    
    /* if(pro_size == ''){
      pro_size = 'null';
    } */
    if(pro_amount == ''){
      pro_amount = 'null';
    }
    /* if(start == ''){
      start = 'null';
    }
    if(end == ''){
      end = 'null';
    } */

    window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_amount,'_blank');
    //window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_amount+'/'+start+'/'+end,'_blank');
    //window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
    //window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_amount,'_blank');
    
  });
  
});