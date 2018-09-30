$(function() {

  $.validator.addMethod("is_phone", function (value, element) {
    return this.optional(element) || /^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/i.test(value);
}, "من فضلك اكتب رقم هاتف صحيح.");

  $("form[name='send_code']").validate({
    rules: {
      phone: {
        required:true,
        number: true,
        is_phone: true
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/send/forget/code',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {

               $('#resend_phone').val(msg.phone);

                $('#forgetCarousel').carousel({
                    interval: 2000
                }).carousel('next');

             }else if (msg.status === 'error') {
                $('#login_error').text(msg.msg);
                $('#login_error').css('display','block');
                 $("#login_error").fadeTo(2000, 500).slideUp(2000, function(){
                    $("#login_error").slideUp(2000);
                });
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


  $("form[name='reset_password']").validate({
    rules: {
      password: {
        required: true,
        minlength: 6,
      },
      password_confirmation:{
        required: true,
        equalTo: '#password'
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/reset/password',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {
                toggleLogin('.forgetPass','.mainLogin');
             }else if (msg.status === 'error') {
                $('#verify_error').text(msg.msg);
                $('#verify_error').css('display','block');
             }
          },
          error : function(){
              window.location.reload();
          },
      });
    }
  });

  $('.resend_code').on('click', function(){
     $.ajax({
        url: base_url+'/send/forget/code',
        type: 'POST',
        data:  {'phone':$('#resend_phone').val(),'_token': $('meta[name="csrf-token"]').attr('content')},
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



  $("form[name='verify_reset_code']").validate({
    rules: {
      code: {
        required: true,
        minlength: 4,
        maxlength: 4
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/verify/reset/code',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {
               $('#reset_phone').val(msg.phone);
                $('#reset_type').val(msg.type);
                 $('#forgetCarousel').carousel({
                    interval: 2000
                }).carousel('next');

             }else if (msg.status === 'error') {
                $('.alert').text(msg.msg);
                $('.alert').css('display','block');
             }
          },
          error : function(){
              window.location.reload();
          },
      });
    }
  });





});