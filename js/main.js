

$(document).ready(function () {

  $( ".has-sub-menu" ).click(function() {
    $(this).find(".sub-menu-ul").toggle("slow");
  });

  $('#nav-icon1').on('click', function () {
      $('#sidebar').toggleClass('active');
      $(this).toggleClass('open');
      $('#header').toggleClass('slide');
      $('#content').toggleClass('slide');
      $('.overlay').toggleClass('display');
  });

  $('.overlay').on('click', function () {
     // hide the sidebar
     $('#sidebar').removeClass('active');
     $('#nav-icon1').removeClass('open');
     $('#header').toggleClass('slide');
     $('#content').toggleClass('slide');
     // fade out the overlay
     $(this).toggleClass('display');
   });






    // smooth Scrolling

    $('#sidebar', '.container').niceScroll({
      scrollspeed: 150,
      horizrailenabled:false
    });

    // $("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#00F",boxzoom:true});




});
