retinajs();
$(document).ready(function () {
  $('.modalBg').hide();
  $('.profile').hide();

  var obj = {};

  $('.scroll a[href^="#"]').click(function (e) {
    e.preventDefault();
    $(window).stop(true).scrollTo(this.hash, { duration: 500, interrupt: true });
  });

  $('.perfiles a').bind("click", function(){
    var clicked = $(this).attr('data-href');
    obj.clicked = clicked;
  });



  $('.closeModal, .perfil a').click(function (e) {
    e.preventDefault();
    $('.modalBg').hide();
    $('.profile').hide();
  });

  $('.email__registro').focusout(function(e) {
    $('.modalBg').show();
    $('.profile').show();
  });

  $('.form__registro').submit(function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var email = $('.email__registro').val();
    var input = $('.email__registro');
    obj.email = email;
    $('.email__registro').removeClass('shake');
    $('.form__info').removeClass('form__info_error');


    $.ajax({
      'method': 'GET',
      'url': './lib/register.php',
      'data': obj
    }).done(function (data) {
      var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
      console.log(data);
      var data = JSON.parse(data);

      if (data.status == "error") {
        input.addClass('animated shake').one(animationEnd, function () {
          $(this).removeClass('animated shake');
        });
        $('.form__info').text(data.message).addClass('form__info_error');
      }

      if (data.status == "success") {
        $('.form__info').text(data.message).removeClass('form__info_error');
      }
    });
  });
});
