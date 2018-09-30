
$(function() {

 $.validator.addMethod("is_phone", function (value, element) {
    return this.optional(element) || /^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/i.test(value);
}, "من فضلك اكتب رقم هاتف صحيح.");

  $("form[name='login']").validate({
    rules: {
      phone: {
        required:true,
        number: true,
        is_phone: true
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/auth/login',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
            if ( msg.status === 'success' ) {

              window.location.reload();
                 

             }else if(msg.status === 'error'){

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
});


$('#open_register').on('click',function(){
  $('#loginModal').modal('hide');
});
$('#open_login').on('click',function(){
  $('#registerModal').modal('hide');
});
$('#user').on('click',function(){
  $('#login_type').val('user');
})
$('#office').on('click',function(){
  $('#login_type').val('office');
})