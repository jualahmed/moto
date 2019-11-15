new Vue({
  el:"#vue_app",
  data:{
    base_url:base_url,
    alldata:[],
    startdate:'',
    enddate:'',
  },
  methods:{
    result(){
      this.startdate=($("#datepickerrr").val());
      this.enddate=($("#datepicker").val());
      var self=this;
      alldata:[];
      $.ajax({
      url: base_url+'Report/income_report_response',
      type: 'POST',
      dataType: 'json',
      data: $('#salereport').serialize(),
      success: function(result) {
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