Vue.component('multiselect', window.VueMultiselect.default)
var vuejsapp = new Vue({
    el:"#vuejsapp",
    data:{
        base_url:base_url,
        result:[],
        pagno:0,
        pagination:[],
        row:0,
        rowperpage:0,
        total:0,
        customers:[],
        isLoading: false,
        selectedcustomar:[],
    },
    created(){
        var self = this;
        $.ajax({
            url: this.base_url+'customer/all/'+this.pagno,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                self.rowperpage=result.rowperpage;
                self.total=result.total;
                self.result.push(result.result);
                self.pagination.push(result.pagination);
            }
        });

        $.ajax({
            url: this.base_url+'/customer/alls',
        })
        .done(function(re) {
            var re= jQuery.parseJSON(re);
            self.customers=re;
        })
    },
    methods:{
         limitText (count) {
          return `and ${count} other countries`
        },
        greetdd:function(pageno){
            this.result=[];
            this.pagination=[];
            var self = this;
            $.ajax({
                url: this.base_url+'customer/all/'+pageno,
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    self.rowperpage=result.rowperpage;
                    self.row=result.row;
                    self.result.push(result.result);
                    self.pagination.push(result.pagination);
                }
            });
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
    }
})


jQuery(document).ready(function($) {
    $('#pagination').on('click','.page-link',function(e){
       e.preventDefault(); 
       var pageno = $(this).children().attr('data-ci-pagination-page');
       vuejsapp.$data.pagno=pageno;
       vuejsapp.greetdd(pageno)
    });
});

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
                        $('#customer')[0].reset();
                        swal({
                            title: "Good job!",
                            text: "customer Created successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
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
       
    $(document).on('click', '.edit', function (e){
        e.preventDefault();
        $('#EditModel').modal('show');
        var customer_id = $(this).attr('customer_id');
        $.ajax({
            url: base_url+'customer/find',
            method: 'post',
            data: {customer_id:customer_id},
            dataType: 'json',
            success: function (res){
                console.log(res);
                $('#customer_id').val(res.customer_id);
                $('#customer_name').val(res.customer_name);
                $('#father_name').val(res.father_name);
                $('#customer_contact_no').val(res.customer_contact_no);
                $('#customer_email').val(res.customer_email);
                $('#int_balance').val(res.int_balance);
                $('#customer_type').val(res.customer_type);
                $('#village').val(res.village);
                $('.police_station').val(res.police_station);
                $('.postoffice').val(res.postoffice);
                $('.district').val(res.district);
            }
        });
    });

    $('#customerupdate').submit(function (e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: data,
            dataType: 'json',
            success: function (res){
                console.log(res)
                if (res.check == true) {
                    $('#customerupdate').find('div.form-group').removeClass('has-error').removeClass('has-success');
                    $('#customerupdate').find('p.text-danger').remove();
                    if (res.success == true) {
                        var file_data = $('#files').prop('files')[0];
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
                        $('#customerupdate')[0].reset();
                        $('#customerupdate').modal('hide');
                        swal({
                            title: "Good job!",
                            text: "Customer updated successfully!",
                            icon: "success",
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                }else {
                    $.each(res.errors, function (key, value){
                        var el = $('#'+key);
                        el.removeClass('has-error').addClass(value.length > 0 ? 'has-error':'has-success').siblings('p.text-danger').remove();
                        el.after(value);
                    });
                }
            }
        });
    });
});
