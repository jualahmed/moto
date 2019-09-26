// new Vue({
//   el:"#vueapp",
//   data:{
//     alldata:[],
//   },
//   methods:{
//     stockreport(){
//       alldata=[];
//       var self=this;
//      $.ajax({
//       url:  base_url,
//       type: "POST",
//       dataType: 'json',
//       data: $('#form_2').serialize(),
//       success: function(result) { 
//         self.alldata=result;
//       }
//     });
//     }
//   }
// })