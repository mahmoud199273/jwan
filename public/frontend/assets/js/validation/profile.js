
$(function() {


  $("form[name='profileData']").validate({
    rules: {
      name: {
        required:true,
        minlength:15,
      },
      email: {
        required:true,
        email:true,
        remote:'profile/validate/email'
      },
      city: {
        required:true
      },
      office_name: {
        required:true
      },
      office_address: {
        required:true
      },
      about_office: {
        required:true
      },
      cr_licence: {
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



  $("form[name='passwordUpdate']").validate({
    rules: {
      old_password: {
        required:true,
        remote:'profile/check/old/password'
      },
      password: {
        required:true,
        minlength:8,
        maxlength:15
      },
      password_confirmation: {
        required:true,
        equalTo:'#new_password'
      }
    },
    messages:{
      old_password:{
        remote:'كلمة المرور  غير صحيحة'
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


  $("form[name='updatePhone']").validate({
    rules: {
      phone: {
        required:true,
        is_phone: true,
        remote:'profile/validate/phone'
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/user/phone/send/code',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
          if ( msg.status === 'success' ) {

            $('#new_phone').val(msg.phone);
            $('#activeModal').modal('show');
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



  $("form[name='activatePhone']").validate({
    rules: {
      code: {
        required: true,
        minlength: 4,
        maxlength: 4
      }
    },
    submitHandler: function(form) {
      $.ajax({
        url: base_url+'/user/profile/phone/update',
        type: 'POST',
        data:  $(form).serialize(),
        success: function( msg ) {
          if ( msg.status === 'success' ) {
            window.location.reload();
          }else if (msg.status === 'error') {

            $('#invalid_code').text(msg.msg);
            $('#invalid_code').css('display','block');
             $("#login_error").fadeTo(2000, 500).slideUp(2000, function(){
                    $("#login_error").slideUp(2000);
                });
          }
        },
        error : function(){
          window.location.reload();
        },
      });
    }
  });

  $('.delete').on('click', function(){
    var id  = $(this).attr('data-id');
    swal({
      title: 'هل تريد الاستمرار؟',
      confirmButtonText:  'نعم',
      cancelButtonText:  'لا',
      showCancelButton: true,
      showCloseButton: true,
      target: document.getElementById('rtl-container')
    }).then((result) => {
      if (result.value) {
       $.ajax({
        url: base_url+'/user/remove/ad/'+ id,
        type: 'POST',
        data: {'_token': $('meta[name="csrf-token"]').attr('content') },
        success: function( msg ) {
          if ( msg.status === 'success' ) {
            swal({
              position: 'center',
              type: 'success',
              title: 'تم الحذف بنجاح',
              showConfirmButton: false,
              timer: 2000
            });
            window.location.reload();
          }
        },
        error : function(){
          swal({
            position: 'center',
            type: 'error',
            title: "تم الالغاء",
            showConfirmButton: false,
            timer: 2000
          });
          window.location.reload();
        },
      });
     }else {
      swal("تم الالغاء", "", "error");
    }
  });
  });



  $('#profileChooseImg').change(function (){
    var file_data = $('#profileChooseImg').prop('files')[0];
    var form_data = new FormData();
    form_data.append('image',file_data);
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
      }
    });
    $.ajax({
      method: "POST",
      url: base_url+"/user/profile/image/upload",
      contentType: false,
      cache: false,
      processData: false,
      data: form_data
    })
    .done(function( msg ) {
      console.log(msg);
    });
  });


  $('#logout').on('click', function(){
    var id  = $(this).attr('data-id');
    swal({
      title: 'هل تريد الاستمرار؟',
      confirmButtonText:  'نعم',
      cancelButtonText:  'لا',
      showCancelButton: true,
      showCloseButton: true,
      target: document.getElementById('rtl-container')
    }).then((result) => {
      if (result.value) {
       $.ajax({
        url: base_url+'/auth/logout',
        type: 'GET',
        success: function( msg ) {
          if ( msg.status === 'success' ) {
            window.location.reload();
          }
        },
        error : function(){
          swal({
            position: 'center',
            type: 'error',
            title: "تم الالغاء",
            showConfirmButton: false,
            timer: 2000
          });
          window.location.reload();
        },
      });
     }else {
       swal({
            position: 'center',
            type: 'error',
            title: "تم الالغاء",
            showConfirmButton: false,
            timer: 2000
          });
    }
  });
  });


  $("form[name='contact_us']").validate({
    rules: {
      name: {
        required:true,
      },
      email: {
        required:true,
        email:true
      },
      message: {
        required:true,
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


