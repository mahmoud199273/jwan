
$(function() {


  $("form[name='edit_setting']").validate({
    rules: {
      number_of_ads_for_user: {
        required:true,
        number: true
      },
      period_for_user: {
        required:true,
        number:true
      },
      number_of_ads_for_office: {
        required:true,
        number:true
      },
      period_for_office: {
        required:true,
        number:true
      },
      about_us: {
        required:true
      },
      fb_link:{
        required:true,
        url:true
      },
      twitter_link:{
        required:true,
        url:true
      },
      google_link:{
        required:true,
        url:true
      },
      linkedin_link:{
        required:true,
        url:true
      },
      pintrist_link:{
        required:true,
        url:true
      },
      google_play_link:{
        required:true,
        url:true
      },
      apple_link:{
        required:true,
        url:true
      },
      address:{
        required:true,
      },
      phone:{
        required:true,
        number:true
      },
      email:{
        required:true,
        email:true
      },
      fax:{
        required:true,
        number:true
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




