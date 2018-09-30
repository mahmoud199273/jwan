$(function() {

  $("form[name='payment_details']").validate({
    rules: {
      bank_transaction: {
        required: true
      },
      transaction_number: {
        required: true,
        number: true
      },
      transaction_amount: {
        required: true,
        number: true
      },
      user_name: {
        required: true
      },
      transaction_date:{
        required: true
      },
      transaction_image:{
        required : true
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


