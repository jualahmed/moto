var vuejsapp = new Vue({
	el:"#vuejsapp",
	data:{
		base_url:base_url,
		result:[],
	},
	created(){
		var self = this;
	    $.ajax({
	        url: this.base_url+'config/all',
	        type: 'GET',
	        dataType: 'json',
	        success: function(result) {
	         	self.result.push(result);
	        }
	    });
	}
})

// config_form
$(document).ready(function () {
       
    $(document).on('click', '.edit', function (e){
        e.preventDefault();
        $('#EditModel').modal('show');
        var id = $(this).attr('id');
        $.ajax({
            url: base_url+'config/find',
            method: 'post',
            data: {id:id},
            dataType: 'json',
            success: function (res){
                $('#id').val(res.id);
                $('#rate').val(res.rate);
                $('#freemonth').val(res.freemonth);
                $('#pardayrate').val(res.pardayrate);
            }
        });
    });

    $('#configupdate').submit(function (e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: data,
            dataType: 'json',
            success: function (res){
                 swal({
                    title: "Good job!",
                    text: "Config updated successfully!",
                    icon: "success",
                });
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        });
    });
});
