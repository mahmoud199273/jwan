$(function() {

  $.validator.addMethod("is_phone", function (value, element) {
    return this.optional(element) || /^(5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/i.test(value);
}, "من فضلك اكتب رقم هاتف صحيح.");

  $("form[name='registration']").validate({
    rules: {
      phone: {
        required:true,
        number: true,
        remote: 'auth/validate/phone',
        is_phone: true
      },
      password: {
        required: true,
        minlength: 8,
        maxlength:15
      },
       type: {
        required: true
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/auth/register',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {

                $('#phone').val(msg.phone);
                $('#type').val(msg.type);

                $('#registerCarousel').carousel({
                    interval: 2000
                }).carousel('next');
             }
          },
          error : function(){
              window.location.reload();
          },
      });
    },
       highlight: function(element) {
       $(element).parent().addClass("errorInput");
       },
       unhighlight: function(element) {
           $(element).parent().removeClass("errorInput");
       }

  });



  $("form[name='verify']").validate({
    rules: {
      code: {
        required: true,
        minlength: 4,
        maxlength: 4
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/auth/verify/code',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {
                toggleLogin('#registerCarousel','.welcome');
             }else if (msg.status === 'error') {
                $('#verify_error').text(msg.msg);
                $('#verify_error').css('display','block');
                $("#verify_error").fadeTo(2000, 500).slideUp(2000, function(){
                    $("#verify_error").slideUp(2000);
                });
             }
          },
          error : function(){
              window.location.reload();
          },
      });
    }
  });


  $('.resend_code_resgister').on('click', function(){
     $.ajax({
        url: base_url+'/auth/resend/code',
        type: 'POST',
        data:  {'phone':$('#phone').val(),'type':$('#type').val(),'_token': $('meta[name="csrf-token"]').attr('content')},
        success: function( msg ) {
            if ( msg.status === 'success' ) {
              

             }else if (msg.status === 'error') {
                $('#login_error').text(msg.msg);
                $('#login_error').css('display','block');
             }
          },
          error : function(){
              // window.location.reload();
          },
      });
  });





});


