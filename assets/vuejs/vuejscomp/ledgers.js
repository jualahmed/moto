new Vue({
	el:"#vueapp",
	data:{
		purpose_id:0,
		distributor_id:0,
		customer_id:0,
		startdate:0,
		enddate:0,
		alldata:[],
	},
	methods:{
		onSubmit(){
			var self=this;
			this.alldata=[];
			this.startdate=document.getElementById('start').value;
			this.enddate=document.getElementById('end').value;
			$.ajax({
				url: base_url+'account/all_ledger_report_find',
				type: 'POST',
				data: {purpose_id: this.purpose_id,distributor_id:this.distributor_id,customer_id:this.customer_id,start:this.startdate,end:this.enddate},
			})
			.done(function(re) {
				var re=JSON.parse(re);
				self.alldata=re;
			})
			.fail(function(re) {
				console.log(re);
			})
		}
	}
})