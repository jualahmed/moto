document.onkeypress = processKey; 
    function processKey(e)
    {
    if (null == e)
    e = window.event ;
    if (e.keyCode == 13)  {
    submitForm() ;
    }
    }

var js_array = <?php echo json_encode($product_info); ?>;
    for(var i in js_array){
}

$(document).ready(function() {
    $('#products').keyup(function(){
     var keyupval=$('#products').val();
     var length=$('#products').val().length;
     if(length>1)
      purchesEntry(keyupval);
     
      if(length==0)
      $("#product_show").html('');
     });
     
     $(".listStyl a").click(function(){
        $("#product_show").html('');
     });
	 
    });
    function purchesEntry(onkeyUpvalu){
        var i;
        var outputs="";
        var submiturl=$('#purchesEntry_link').val();
            $.ajax({
                url: submiturl,
                type: 'POST',
                dataType: 'json',
                data: {'keyupvalu':onkeyUpvalu},
                success:function(result){
                for(i=0; i<result.length; i++ ){
                  outputs+='<li class="listStyl"><a href='base_url+'product/searchBarcode/'+result[i].product_id+'">'+result[i].product_name+'</a></li>';

				 }
                 $("#product_show").html(outputs);
                 },
                error: function (jXHR, textStatus, errorThrown) {html("")}
            });
        }