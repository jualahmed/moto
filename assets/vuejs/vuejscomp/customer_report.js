new Vue({
  el:"#vue_app",
  data:{
    base_url:base_url,
    alldata:[],
    customer_id:0,
    loding:false,
  },
  methods:{
    result(){
      var self=this;
      self.loding=!self.loding;
      alldata:[];
      $.ajax({
      url: base_url+'Report/customer_report_response',
      type: 'POST',
      dataType: 'json',
      data: {customer_id:this.customer_id},
      success: function(result) {
        self.loding=!self.loding;
        self.alldata=result;
      }
    });
    },
    formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [day,month,year].join('-');
    }
  }
})