
$("#FormSubmit").on('submit', function(e) {
     //alert("ok");
    // $("#pageloader").fadeIn();
   e.preventDefault();
   var data = new FormData(this);
   //alert(data);
   $.ajax({
       type: 'POST',
       url: data.get('location'),
       data: data,
       cache: false,
       contentType: false,
       processData: false,
        beforeSend: function() {
           $("#uploadBtn").attr("disabled", true);
           $('#uploadSpin').show();
       },
       success: function(response) {
           //alert(response);
            $("#pageloader").fadeOut();
           var  response= JSON.parse(response);
           $("#uploadBtn").removeAttr("disabled");
           $('#uploadSpin').hide();
           if(response.res == 'success'){
                //alert(response.msg);
                $.notify(response.msg,'success');
            // $.alert({
            //     title: 'Alert!',
            //     content: 'Success!',
            // });
              
                setInterval(function () {
                      location.href=response.url;
                  },3000);
           }
           else if(response.res == 'otp'){
               // alert("ok");
               $("#otp").show();
               $("#SelectLogin").val(response.otp);
               $("#EmailPwd").prop('readonly', true);
               $.notify(response.msg,'success');
           }else if(response.res=='newPwd'){
               $.notify(response.msg,'success');
               setInterval(function () {
                  location.href=response.url;
              },3000)
           }else{
               $.notify(response.msg,'error');
           }
       },
       error: function() {
            $("#uploadBtn").removeAttr("disabled");
            $('#uploadSpin').hide();
           $.notify('Something went wrong','success');
       }
   });
})


// keyup



//upload file
jQuery(function($) {
 $('#file').change(function() {
   if ($(this).val()) {
        var filename = $(this).val();
        $(this).closest('.file-upload').find('.file-name').html(filename);
        var formData = new FormData();
       formData.append('file', $('#file')[0].files[0]);
       $("#pageloader").fadeIn();
        $.ajax({
         url: 'code/ManageAccount.php?flag=UpdateProfile',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(response){
              var  response= JSON.parse(response);
           if(response.res == 'success'){
               $("#pageloader").fadeOut();
               $.notify(response.msg,'success');
                setInterval(function () {
                      location.reload();
                  },3000)
           }else{
               $.notify(response.msg,'error');
               }

         },
         error:function(){
             alert("error");
         }
      });
   }
 });
});
//update background

jQuery(function($) {
 $('#BgFile').change(function() {
   if ($(this).val()) {
        // var filename = $(this).val();
        // $(this).closest('.file-upload').find('.file-name').html(filename);
        var formData = new FormData();
       formData.append('BgFile', $('#BgFile')[0].files[0]);
       // alert(formData);
       $("#pageloader").fadeIn();
        $.ajax({
         url: 'code/ManageAccount.php?flag=UpdateProfile',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(response){
             // alert(response);
           $("#pageloader").fadeOut();
              var  response= JSON.parse(response);
           if(response.res == 'success'){
               $.notify(response.msg,'success');
                setInterval(function () {
                      location.reload();
                  },3000)
           }else{
               $.notify(response.msg,'error');
               }

         },
         error:function(){
             alert("error");
         }
      });
   }
 });
});