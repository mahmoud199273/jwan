
$(function() {


  $("form[name='create_ad']").validate({
    rules: {
      price: {
        required:true,
        number: true
      },
      property_type: {
        required:true
      },
      title: {
        required:true
      },
      description: {
        required:true
      },
      city: {
        required:true
      },
      area:{
        required:true
      },
      detailed_address:{
        required:true
      },
      front_yard:{
        required:true
      },
      hall_numbers:{
        required:true,
        number:true
      },
      room_numbers:{
        required:true,
        number:true
      },
      bathrooms_number:{
        required:true,
        number:true
      },
      property_age:{
        required:true,
        number:true
      },
      size:{
        required:true,
        number:true
      },
      contact_phone:{
        required:true,
        number:true
      },
      contact_time:{
        required:true
      }
    },
    submitHandler: function(form) {
      form.submit();
       
    },
       highlight: function(element) {
       $(element).parent().addClass("errorInput");
       },
       unhighlight: function(element) {
           $(element).parent().removeClass("errorInput");
       }
  });

});

$('#open_register').on('click',function(){
  $('#loginModal').modal('hide');
});


